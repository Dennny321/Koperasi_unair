<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Data\Penukaran;
use App\Models\Data\RiwayatPoin;
use App\Models\Master\Hadiah;
use App\Models\Master\KodeHadiah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HadiahController extends Controller
{
    /**
     * Tampilkan daftar hadiah + penukaran yang menunggu klaim.
     */
    public function index(Request $request)
    {
        $query = Hadiah::withCount(['kodeHadiah', 'kodeHadiahTersedia']);

        if ($request->filled('aktif')) {
            $query->where('aktif', $request->aktif === '1');
        }

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $perPage = in_array((int) $request->get('per_page', 10), [10, 25, 50, 100])
            ? (int) $request->get('per_page', 10)
            : 10;

        $perPagePenukaran = in_array((int) $request->get('per_page_penukaran', 5), [5, 10, 25, 50, 100])
            ? (int) $request->get('per_page_penukaran', 5)
            : 5;

        $hadiah = $query->latest()->paginate($perPage, ['*'], 'page')->withQueryString();

        $penukaranMenunggu = Penukaran::with(['user', 'hadiah'])
            ->menunggu()
            ->orderBy('dibuat_pada', 'desc')
            ->paginate($perPagePenukaran, ['*'], 'page_penukaran')
            ->withQueryString();

        return view('master.hadiah.index', compact('hadiah', 'penukaranMenunggu'));
    }

    public function create()
    {
        return view('master.hadiah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'       => 'required|max:255',
            'keterangan' => 'nullable|string',
            'foto'       => 'nullable|image|max:2048',
            'biaya_poin' => 'required|integer|min:0',
            'stok'       => 'required|integer|min:0',
            'aktif'      => 'required|boolean',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('hadiah', 'public');
        }

        Hadiah::create($validated);

        return redirect()->route('admin.hadiah.index')
            ->with('success', 'Hadiah berhasil ditambahkan!');
    }

    public function show(Hadiah $hadiah)
    {
        $hadiah->load('penukaran.user');
        $kodeHadiah = $hadiah->kodeHadiah()->with('member')->latest()->paginate(20);
        return view('master.hadiah.show', compact('hadiah', 'kodeHadiah'));
    }

    public function edit(Hadiah $hadiah)
    {
        return view('master.hadiah.edit', compact('hadiah'));
    }

    public function update(Request $request, Hadiah $hadiah)
    {
        $validated = $request->validate([
            'nama'       => 'required|max:255',
            'keterangan' => 'nullable|string',
            'foto'       => 'nullable|image|max:2048',
            'biaya_poin' => 'required|integer|min:0',
            'stok'       => 'required|integer|min:0',
            'aktif'      => 'required|boolean',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('hadiah', 'public');
        }

        $hadiah->update($validated);

        return redirect()->route('admin.hadiah.index')
            ->with('success', 'Hadiah berhasil diperbarui!');
    }

    public function destroy(Hadiah $hadiah)
    {
        if ($hadiah->penukaran()->exists()) {
            return redirect()->route('admin.hadiah.index')
                ->with('error', 'Hadiah tidak dapat dihapus karena sudah pernah ditukar!');
        }

        $hadiah->delete();

        return redirect()->route('admin.hadiah.index')
            ->with('success', 'Hadiah berhasil dihapus!');
    }

    // =========================================================
    // KODE HADIAH
    // =========================================================

    /**
     * Halaman kelola kode hadiah untuk 1 hadiah.
     */
    public function kodeIndex(Hadiah $hadiah)
    {
        $kode = $hadiah->kodeHadiah()
            ->with('member')
            ->latest()
            ->paginate(20);

        $jumlahTersedia  = $hadiah->kodeHadiah()->where('status', 'tersedia')->count();
        $jumlahDiredeem  = $hadiah->kodeHadiah()->where('status', 'diredeem')->count();
        $jumlahGenerated = $hadiah->kodeHadiah()->count();
        $sisaPerluGenerate = max(0, $hadiah->stok - $jumlahTersedia);

        return view('master.hadiah.kode.index', compact(
            'hadiah', 'kode',
            'jumlahTersedia', 'jumlahDiredeem', 'jumlahGenerated', 'sisaPerluGenerate'
        ));
    }

    /**
     * Generate kode hadiah sejumlah stok yang belum punya kode.
     * Setiap 1 stok = 1 kode unik.
     */
    public function kodeGenerate(Request $request, Hadiah $hadiah)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1|max:500',
        ]);

        $jumlah = (int) $request->jumlah;

        DB::beginTransaction();
        try {
            $generated = 0;
            for ($i = 0; $i < $jumlah; $i++) {
                KodeHadiah::create([
                    'id_hadiah'   => $hadiah->id,
                    'jumlah_poin' => $hadiah->biaya_poin,
                    'status'      => 'tersedia',
                ]);
                $generated++;
            }

            DB::commit();
            return back()->with('success', "{$generated} kode hadiah berhasil di-generate!");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal generate kode: ' . $e->getMessage());
        }
    }

    /**
     * Hapus 1 kode hadiah (hanya yang statusnya 'tersedia').
     */
    public function kodeDestroy(Hadiah $hadiah, KodeHadiah $kode)
    {
        if ($kode->id_hadiah !== $hadiah->id) {
            return back()->with('error', 'Kode ini bukan milik hadiah tersebut.');
        }

        if ($kode->isDiredeem()) {
            return back()->with('error', 'Kode yang sudah diredeem tidak bisa dihapus.');
        }

        $kode->delete();
        return back()->with('success', 'Kode berhasil dihapus.');
    }

    /**
     * Hapus semua kode 'tersedia' dari hadiah ini.
     */
    public function kodeDestroyAll(Hadiah $hadiah)
    {
        $count = $hadiah->kodeHadiah()->where('status', 'tersedia')->count();
        $hadiah->kodeHadiah()->where('status', 'tersedia')->delete();

        return back()->with('success', "{$count} kode tersedia berhasil dihapus.");
    }

    // =========================================================
    // KONFIRMASI PENUKARAN (admin klaim / batal)
    // =========================================================

    public function klaimPenukaran(Penukaran $penukaran)
    {
        if (!$penukaran->isMenunggu()) {
            return back()->with('error', 'Penukaran ini tidak dalam status menunggu.');
        }

        $penukaran->update(['status' => 'diklaim']);

        return back()->with('success',
            'Penukaran ' . $penukaran->kode_unik . ' berhasil dikonfirmasi.');
    }

    public function batalPenukaran(Penukaran $penukaran)
    {
        if (!$penukaran->isMenunggu()) {
            return back()->with('error', 'Penukaran ini tidak dapat dibatalkan.');
        }

        DB::beginTransaction();
        try {
            RiwayatPoin::create([
                'id_user'           => $penukaran->id_user,
                'id_transaksi'      => null,
                'id_penukaran'      => $penukaran->id,
                'poin'              => $penukaran->poin_digunakan,
                'jenis'             => 'masuk',
                'keterangan'        => 'Pembatalan penukaran oleh admin: ' . $penukaran->hadiah->nama,
                'jenis_keterangan'  => 'penukaran',
                'dibuat_pada'       => now(),
            ]);

            $penukaran->user->increment('saldo_poin', $penukaran->poin_digunakan);
            $penukaran->hadiah->increment('stok');
            $penukaran->update(['status' => 'dibatalkan']);

            DB::commit();
            return back()->with('success', 'Penukaran dibatalkan. Poin member telah dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
