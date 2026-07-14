<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Data\Penukaran;
use App\Models\Data\RiwayatPoin;
use App\Models\Master\Hadiah;
use App\Models\Master\KodeHadiah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenukaranController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:member']);
    }

    /**
     * Halaman daftar hadiah + riwayat penukaran member.
     */
    public function index()
    {
        $user = auth()->user();

        $hadiahTersedia = Hadiah::tersedia()->orderBy('biaya_poin')->get();

        // ✅ FIX: hapus 'kodeHadiah' dari with() — relasi itu tidak ada di model Penukaran
        $riwayatPenukaran = $user->penukaran()
            ->with(['hadiah'])
            ->orderBy('dibuat_pada', 'desc')
            ->paginate(10);

        return view('member.penukaran.index', compact('user', 'hadiahTersedia', 'riwayatPenukaran'));
    }

    /**
     * Proses penukaran hadiah — member mendapat 1 kode dari pool kode tersedia.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_hadiah' => 'required|exists:01_hadiah,id',
        ]);

        $user   = auth()->user();
        $hadiah = Hadiah::findOrFail($request->id_hadiah);

        if (!$hadiah->isTersedia()) {
            return back()->with('error', 'Hadiah tidak tersedia saat ini.');
        }

        if ($user->saldo_poin < $hadiah->biaya_poin) {
            return back()->with('error', 'Poin Anda tidak mencukupi untuk menukar hadiah ini.');
        }

        // Cari 1 kode yang masih tersedia
        $kode = KodeHadiah::where('id_hadiah', $hadiah->id)
            ->where('status', 'tersedia')
            ->lockForUpdate()
            ->first();

        if (!$kode) {
            return back()->with('error', 'Stok kode hadiah habis. Hubungi admin untuk generate kode.');
        }

        DB::beginTransaction();
        try {
            $penukaran = Penukaran::create([
                'id_user'        => $user->id,
                'id_hadiah'      => $hadiah->id,
                'poin_digunakan' => $hadiah->biaya_poin,
                'status'         => 'diklaim',
                'dibuat_pada'    => now(),
            ]);

            $kode->update([
                'id_member' => $user->id,
                'status'    => 'diredeem',
            ]);

            // Catat riwayat poin — kolom id_penukaran_kode & jenis_keterangan opsional
            // (ada jika migration 900001 sudah jalan, tidak ada jika belum)
            $riwayatData = [
                'id_user'      => $user->id,
                'id_transaksi' => null,
                'id_penukaran' => $penukaran->id,
                'poin'         => $hadiah->biaya_poin,
                'jenis'        => 'keluar',
                'keterangan'   => 'Penukaran hadiah: ' . $hadiah->nama . ' (Kode: ' . $kode->kode_hadiah . ')',
                'dibuat_pada'  => now(),
            ];

            // Tambah kolom baru hanya jika sudah ada di tabel
            if (\Illuminate\Support\Facades\Schema::hasColumn('02_riwayat_poin', 'id_penukaran_kode')) {
                $riwayatData['id_penukaran_kode'] = $kode->id;
            }
            if (\Illuminate\Support\Facades\Schema::hasColumn('02_riwayat_poin', 'jenis_keterangan')) {
                $riwayatData['jenis_keterangan'] = 'penukaran';
            }

            RiwayatPoin::create($riwayatData);

            $user->decrement('saldo_poin', $hadiah->biaya_poin);
            $hadiah->decrement('stok');

            DB::commit();

            return redirect()->route('member.penukaran.index')
                ->with('success', 'Penukaran berhasil! Kode hadiah Anda: <strong>' . $kode->kode_hadiah . '</strong>. Tunjukkan kode ini ke petugas.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Batalkan penukaran — hanya status 'menunggu'.
     */
    public function destroy(Penukaran $penukaran)
    {
        $user = auth()->user();

        if ($penukaran->id_user !== $user->id) {
            return back()->with('error', 'Akses ditolak.');
        }

        if (!$penukaran->isMenunggu()) {
            return back()->with('error', 'Penukaran tidak dapat dibatalkan karena sudah diproses.');
        }

        DB::beginTransaction();
        try {
            $riwayatData = [
                'id_user'      => $user->id,
                'id_transaksi' => null,
                'id_penukaran' => $penukaran->id,
                'poin'         => $penukaran->poin_digunakan,
                'jenis'        => 'masuk',
                'keterangan'   => 'Pembatalan penukaran hadiah: ' . $penukaran->hadiah->nama,
                'dibuat_pada'  => now(),
            ];

            if (\Illuminate\Support\Facades\Schema::hasColumn('02_riwayat_poin', 'jenis_keterangan')) {
                $riwayatData['jenis_keterangan'] = 'penukaran';
            }

            RiwayatPoin::create($riwayatData);

            $user->increment('saldo_poin', $penukaran->poin_digunakan);
            $penukaran->hadiah->increment('stok');
            $penukaran->update(['status' => 'dibatalkan']);

            DB::commit();
            return back()->with('success', 'Penukaran berhasil dibatalkan. Poin Anda telah dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
