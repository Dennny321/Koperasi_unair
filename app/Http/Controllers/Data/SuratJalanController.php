<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Data\TransaksiSuratJalan;
use App\Models\Data\DetailTransaksiSuratJalan;
use App\Models\Master\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuratJalanController extends Controller
{
    public function index(Request $request)
    {
        $query = TransaksiSuratJalan::with('kasir')
            ->withCount('detail');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('no_surat', 'like', "%{$s}%")
                  ->orWhere('tujuan', 'like', "%{$s}%")
                  ->orWhere('no_transaksi', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = in_array((int) $request->get('per_page', 10), [10, 25, 50, 100])
            ? (int) $request->get('per_page', 10)
            : 5;

        $suratJalan = $query->orderByDesc('created_at')->paginate($perPage)->withQueryString();

        return view('master.surat-jalan.index', compact('suratJalan'));
    }

    public function create()
    {
        $produk = Produk::aktif()->orderBy('nama')->get();
        return view('master.surat-jalan.create', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_surat'              => 'required|string|max:100|unique:02_transaksi_surat_jalan,no_surat',
            'no_transaksi'          => 'required|string|max:100|unique:02_transaksi_surat_jalan,no_transaksi',
            'tujuan'                => 'required|string|max:255',
            'keterangan'            => 'nullable|string',
            'produk'                => 'required|array|min:1',
            'produk.*.id_produk'    => 'required|exists:01_produk,id',
            'produk.*.jumlah'       => 'required|integer|min:1',
            'produk.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        $stokErrors = [];
        foreach ($request->produk as $item) {
            $produk = Produk::find($item['id_produk']);
            if ($produk && $item['jumlah'] > $produk->stok) {
                $stokErrors[] = "Stok <strong>{$produk->nama}</strong> tidak cukup. Tersedia: {$produk->stok} {$produk->satuan}.";
            }
        }
        if (!empty($stokErrors)) {
            return back()->withInput()->with('stok_errors', $stokErrors);
        }

        DB::beginTransaction();
        try {
            $sj = TransaksiSuratJalan::create([
                'no_surat'     => $request->no_surat,
                'no_transaksi' => $request->no_transaksi,
                'id_kasir'     => auth()->id(),
                'tujuan'       => $request->tujuan,
                'keterangan'   => $request->keterangan,
                'status'       => 'draft',
                'total_harga'  => 0,
            ]);

            $total = 0;
            foreach ($request->produk as $item) {
                $subtotal = $item['jumlah'] * $item['harga_satuan'];
                $total   += $subtotal;

                DetailTransaksiSuratJalan::create([
                    'id_transaksi' => $sj->id,
                    'id_produk'    => $item['id_produk'],
                    'jumlah'       => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal'     => $subtotal,
                ]);

                Produk::where('id', $item['id_produk'])
                    ->decrement('stok', $item['jumlah']);
            }

            $sj->update(['total_harga' => $total]);
            DB::commit();

            $rp = auth()->user()->role === 'admin' ? 'admin' : 'kasir';
            return redirect()->route($rp . '.surat-jalan.show', $sj->id)
                ->with('success', 'Surat jalan ' . $sj->no_surat . ' berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Gagal membuat surat jalan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $suratJalan = TransaksiSuratJalan::with(['kasir', 'detail.produk'])
            ->findOrFail($id);

        return view('master.surat-jalan.show', compact('suratJalan'));
    }

    public function edit($id)
    {
        $suratJalan = TransaksiSuratJalan::with('detail.produk')->findOrFail($id);

        if ($suratJalan->status !== 'draft') {
            $rp = auth()->user()->role === 'admin' ? 'admin' : 'kasir';
            return redirect()->route($rp . '.surat-jalan.show', $suratJalan->id)
                ->with('error', 'Surat jalan yang sudah dicetak tidak bisa diubah.');
        }

        $produk = Produk::aktif()->orderBy('nama')->get();
        return view('master.surat-jalan.edit', compact('suratJalan', 'produk'));
    }

    public function update(Request $request, $id)
    {
        $suratJalan = TransaksiSuratJalan::findOrFail($id);
        $rp = auth()->user()->role === 'admin' ? 'admin' : 'kasir';

        if ($request->has('_status_override') && $request->_status_override === 'selesai') {
            $suratJalan->update(['status' => 'selesai']);
            return redirect()->route($rp . '.surat-jalan.show', $suratJalan->id)
                ->with('success', 'Surat jalan berhasil ditandai selesai.');
        }

        if ($suratJalan->status !== 'draft') {
            return back()->with('error', 'Surat jalan tidak bisa diubah.');
        }

        $request->validate([
            'tujuan'                => 'required|string|max:255',
            'keterangan'            => 'nullable|string',
            'produk'                => 'required|array|min:1',
            'produk.*.id_produk'    => 'required|exists:01_produk,id',
            'produk.*.jumlah'       => 'required|integer|min:1',
            'produk.*.harga_satuan' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $suratJalan->update([
                'tujuan'     => $request->tujuan,
                'keterangan' => $request->keterangan,
            ]);

            $suratJalan->detail()->delete();

            $total = 0;
            foreach ($request->produk as $item) {
                $subtotal = $item['jumlah'] * $item['harga_satuan'];
                $total   += $subtotal;

                DetailTransaksiSuratJalan::create([
                    'id_transaksi' => $suratJalan->id,
                    'id_produk'    => $item['id_produk'],
                    'jumlah'       => $item['jumlah'],
                    'harga_satuan' => $item['harga_satuan'],
                    'subtotal'     => $subtotal,
                ]);
            }

            $suratJalan->update(['total_harga' => $total]);
            DB::commit();

            return redirect()->route($rp . '.surat-jalan.show', $suratJalan->id)
                ->with('success', 'Surat jalan berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    /**
     * Hapus surat jalan — semua status bisa dihapus.
     * Stok dikembalikan jika status bukan selesai.
     */
    public function destroy($id)
    {
        $suratJalan = TransaksiSuratJalan::with('detail')->findOrFail($id);

        DB::beginTransaction();
        try {
            // Kembalikan stok jika surat jalan belum selesai
            // (draft & dicetak berarti barang belum benar-benar diterima)
            if ($suratJalan->status !== 'selesai') {
                foreach ($suratJalan->detail as $detail) {
                    Produk::where('id', $detail->id_produk)
                        ->increment('stok', $detail->jumlah);
                }
            }

            $suratJalan->detail()->delete();
            $suratJalan->delete();

            DB::commit();

            $rp = auth()->user()->role === 'admin' ? 'admin' : 'kasir';
            return redirect()->route($rp . '.surat-jalan.index')
                ->with('success', 'Surat jalan berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus: ' . $e->getMessage());
        }
    }

    public function cetak($id)
    {
        $suratJalan = TransaksiSuratJalan::with(['kasir', 'detail.produk'])
            ->findOrFail($id);

        if ($suratJalan->status === 'draft') {
            $suratJalan->update(['status' => 'dicetak']);
        }

        return view('master.surat-jalan.cetak', compact('suratJalan'));
    }

    public function cariProduk(Request $request)
    {
        $q = $request->get('q', '');
        $produk = Produk::aktif()
            ->where(function ($query) use ($q) {
                $query->where('nama', 'like', "%{$q}%")
                    ->orWhere('kode_produk', 'like', "%{$q}%");
            })
            ->select('id', 'kode_produk', 'nama', 'harga', 'satuan')
            ->limit(20)
            ->get();

        return response()->json($produk);
    }
}