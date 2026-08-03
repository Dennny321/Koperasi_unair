<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Data\Transaksi;
use App\Models\Data\DetailTransaksi;
use App\Models\Data\RiwayatPoin;
use App\Models\Master\Produk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\NotaPrinterService;

class TransaksiController extends Controller
{
    public function __construct(protected NotaPrinterService $printerService) {}

    /**
     * Daftar transaksi.
     */
    public function index(Request $request)
    {
        $query = Transaksi::with(['kasir', 'member', 'detail']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('metode_bayar')) {
            $query->byMetodeBayar($request->metode_bayar);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('dibuat_pada', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('dibuat_pada', '<=', $request->tanggal_sampai);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_transaksi', 'like', "%{$search}%")
                    ->orWhere('no_nota', 'like', "%{$search}%")
                    ->orWhereHas(
                        'member',
                        fn($q2) => $q2
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('no_telepon', 'like', "%{$search}%")
                    );
            });
        }

        $perPage = in_array((int) $request->get('per_page', 10), [10, 25, 50, 100])
            ? (int) $request->get('per_page', 10)
            : 5;

        $transaksi = $query->orderBy('dibuat_pada', 'desc')->paginate($perPage)->withQueryString();

        $today = now()->toDateString();
        $summaryHariIni = Transaksi::selesai()
            ->whereDate('dibuat_pada', $today)
            ->selectRaw('COUNT(*) as total_transaksi, SUM(total_harga) as total_pendapatan')
            ->first();

        return view('data.transaksi.index', compact('transaksi', 'summaryHariIni'));
    }

    /**
     * Form POS buat transaksi baru.
     */
    public function create()
    {
        $produk = Produk::with('kategori')
            ->where('status', 'aktif')
            ->where('stok', '>', 0)
            ->get();

        $members     = User::member()->select('id', 'name', 'no_telepon', 'saldo_poin')->get();
        $noTransaksi = $this->generateNoTransaksi();

        return view('data.transaksi.create', compact('produk', 'members', 'noTransaksi'));
    }

    /**
     * Simpan transaksi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_transaksi'         => 'required|unique:02_transaksi,no_transaksi',
            'items'                => 'required|array|min:1',
            'items.*.id_produk'    => 'required|exists:01_produk,id',
            'items.*.jumlah'       => 'required|integer|min:1',
            'items.*.harga_satuan' => 'required|numeric|min:0',
            'items.*.subtotal'     => 'required|numeric|min:0',
            'total_harga'          => 'required|numeric|min:0',
            'total_bayar'          => 'required|numeric|min:0',
            'kembalian'            => 'required|numeric|min:0',
            'metode_bayar'         => 'required|in:tunai,transfer,qris',
            'id_member'            => 'nullable|exists:users,id',
            'poin_diberikan'       => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            $noNota    = $this->generateNoNota();
            $transaksi = Transaksi::create([
                'no_transaksi' => $request->no_transaksi,
                'no_nota'      => $noNota,
                'id_kasir'     => auth()->id(),
                'id_member'    => $request->id_member ?: null,
                'total_harga'  => $request->total_harga,
                'total_bayar'  => $request->total_bayar,
                'kembalian'    => $request->kembalian,
                'metode_bayar' => $request->metode_bayar,
                'status'       => 'selesai',
                'dibuat_pada'  => now(),
            ]);

            foreach ($request->items as $item) {
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id,
                    'id_produk'    => $item['id_produk'],
                    'jumlah'       => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal'     => $item['subtotal'],
                ]);
                Produk::where('id', $item['id_produk'])->decrement('stok', $item['jumlah']);
            }

            if ($request->id_member && $request->poin_diberikan > 0) {
                $member = User::find($request->id_member);
                RiwayatPoin::create([
                    'id_user'      => $member->id,
                    'id_transaksi' => $transaksi->id,
                    'id_penukaran' => null,
                    'poin'         => $request->poin_diberikan,
                    'jenis'        => 'masuk',
                    'keterangan'   => 'Poin dari transaksi ' . $transaksi->no_transaksi,
                    'dibuat_pada'  => now(),
                ]);
                $member->increment('saldo_poin', $request->poin_diberikan);
            }

            DB::commit();

            $rp = auth()->user()->role === 'admin' ? 'admin' : 'kasir';
            return redirect()
                ->route($rp . '.transaksi.show', $transaksi->id)
                ->with('success', 'Transaksi berhasil disimpan!')
                ->with('auto_print', true); // trigger tombol cetak di view show

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Detail transaksi.
     */
    public function show($id)
    {
        $transaksi = Transaksi::with(['kasir', 'member', 'detail.produk', 'riwayatPoin'])
            ->findOrFail($id);

        return view('data.transaksi.show', compact('transaksi'));
    }

    /**
     * Cetak nota HTML (preview di browser / fallback).
     * Route: GET transaksi/{id}/nota
     */
    public function cetakNota($id)
    {
        $transaksi = Transaksi::with(['kasir', 'member', 'detail.produk', 'riwayatPoin'])
            ->findOrFail($id);

        return view('data.transaksi.nota', compact('transaksi'));
    }

    /**
     * Cetak nota via ESC/POS langsung ke printer USB/Network.
     * Route: POST transaksi/{id}/print-escpos
     *
     * Dipanggil via AJAX dari tombol "Cetak" di view show.
     */
    public function printEscpos($id)
    {
        $transaksi = Transaksi::with(['kasir', 'member', 'detail.produk', 'riwayatPoin'])
            ->findOrFail($id);

        try {
            $this->printerService->cetak($transaksi);

            return response()->json([
                'success' => true,
                'message' => 'Nota berhasil dicetak ke printer.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal cetak: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Batalkan transaksi.
     */
    public function destroy($id)
    {
        $transaksi = Transaksi::with(['detail', 'riwayatPoin'])->findOrFail($id);

        if ($transaksi->status === 'batal') {
            return back()->with('error', 'Transaksi sudah dibatalkan.');
        }

        DB::beginTransaction();
        try {
            foreach ($transaksi->detail as $detail) {
                Produk::where('id', $detail->id_produk)->increment('stok', $detail->jumlah);
            }

            if ($transaksi->riwayatPoin && $transaksi->id_member) {
                $poin   = $transaksi->riwayatPoin->poin;
                $member = User::find($transaksi->id_member);
                if ($member && $member->saldo_poin >= $poin) {
                    $member->decrement('saldo_poin', $poin);
                    RiwayatPoin::create([
                        'id_user'      => $member->id,
                        'id_transaksi' => $transaksi->id,
                        'id_penukaran' => null,
                        'poin'         => $poin,
                        'jenis'        => 'keluar',
                        'keterangan'   => 'Poin dibatalkan dari transaksi ' . $transaksi->no_transaksi,
                        'dibuat_pada'  => now(),
                    ]);
                }
            }

            $transaksi->update(['status' => 'batal']);
            DB::commit();

            $rp = auth()->user()->role === 'admin' ? 'admin' : 'kasir';
            return redirect()
                ->route($rp . '.transaksi.index')
                ->with('success', 'Transaksi berhasil dibatalkan dan stok dikembalikan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ── API Endpoints ─────────────────────────────────────────────

    public function cariProduk(Request $request)
    {
        $kode   = $request->get('kode');
        $produk = Produk::with('kategori')
            ->where('kode_produk', $kode)
            ->where('status', 'aktif')
            ->first();

        if (!$produk) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan']);
        }
        if ($produk->stok <= 0) {
            return response()->json(['success' => false, 'message' => 'Stok produk habis']);
        }

        return response()->json([
            'success' => true,
            'produk'  => [
                'id'          => $produk->id,
                'kode_produk' => $produk->kode_produk,
                'nama'        => $produk->nama,
                'harga'       => $produk->harga,
                'stok'        => $produk->stok,
                'satuan'      => $produk->satuan,
                'kategori'    => $produk->kategori?->nama,
                'foto'        => $produk->foto ? asset('storage/' . $produk->foto) : null,
            ],
        ]);
    }

    public function cariMember(Request $request)
    {
        $telepon = $request->get('no_telepon');
        $member  = User::member()->where('no_telepon', $telepon)->first();

        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Member tidak ditemukan']);
        }

        return response()->json([
            'success' => true,
            'member'  => [
                'id'         => $member->id,
                'name'       => $member->name,
                'no_telepon' => $member->no_telepon,
                'saldo_poin' => $member->saldo_poin,
            ],
        ]);
    }

    // ── Helpers ──────────────────────────────────────────────────

    private function generateNoTransaksi(): string
    {
        $prefix = 'TRX-' . now()->format('Ymd') . '-';
        $last   = Transaksi::where('no_transaksi', 'like', $prefix . '%')
            ->orderBy('no_transaksi', 'desc')
            ->value('no_transaksi');
        $next = $last ? ((int) substr($last, -4)) + 1 : 1;
        return $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    private function generateNoNota(): string
    {
        $prefix = 'NOTA-' . now()->format('Ym') . '-';
        $last   = Transaksi::where('no_nota', 'like', $prefix . '%')
            ->orderBy('no_nota', 'desc')
            ->value('no_nota');
        $next = $last ? ((int) substr($last, -4)) + 1 : 1;
        return $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Generate ESC/POS Base64 → dikirim ke browser → QZ Tray cetak ke printer lokal
     * Route: POST transaksi/{id}/print-qz
     */
    public function printQz($id)
    {
        $transaksi = Transaksi::with(['kasir', 'member', 'detail.produk', 'riwayatPoin'])
            ->findOrFail($id);

        try {
            $base64 = $this->printerService->generateBase64($transaksi);

            return response()->json([
                'success' => true,
                'data'    => $base64,
                'printer' => config('printer.name', 'POS58'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal generate nota: ' . $e->getMessage(),
            ], 500);
        }
    }
}