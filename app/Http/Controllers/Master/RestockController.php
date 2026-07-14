<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Restock;
use App\Models\Data\RestockDetail;
use App\Models\Master\Supplier;
use App\Models\Master\Produk;
use App\Exports\RestockExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class RestockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Restock::with(['supplier', 'user']);

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('supplier')) {
            $query->where('id_supplier', $request->supplier);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->byPeriode($request->start_date, $request->end_date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_restock', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $perPage = in_array((int) $request->get('per_page', 5), [5, 10, 25, 50, 100])
            ? (int) $request->get('per_page', 5)
            : 5;

        $restocks  = $query->latest('tanggal_restock')->paginate($perPage)->withQueryString();
        $suppliers = Supplier::aktif()->get();

        return view('master.restock.index', compact('restocks', 'suppliers'));
    }

    // ─────────────────────────────────────────────────────────────
    //  EXPORT EXCEL
    // ─────────────────────────────────────────────────────────────

    /**
     * Export restock ke file Excel (.xlsx) — termasuk sheet Detail Produk
     */
    public function exportExcel(Request $request)
    {
        return (new RestockExport($request))->download();
    }

    // ─────────────────────────────────────────────────────────────
    //  EXPORT PDF
    // ─────────────────────────────────────────────────────────────

    /**
     * Export restock ke file PDF — termasuk sub-tabel detail per restock
     */
    public function exportPdf(Request $request)
    {
        // Eager-load details beserta produk & kategori agar tersedia di Blade
        $query = Restock::with(['supplier', 'user', 'details.produk.kategori']);

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('supplier')) {
            $query->where('id_supplier', $request->supplier);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->byPeriode($request->start_date, $request->end_date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_restock', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $restocks = $query->latest('tanggal_restock')->get();

        // Ambil nama supplier untuk label filter
        $supplierName = null;
        if ($request->filled('supplier')) {
            $supplier     = Supplier::find($request->supplier);
            $supplierName = $supplier ? $supplier->nama : null;
        }

        $filters = [
            'search'        => $request->search,
            'status'        => $request->status,
            'supplier_name' => $supplierName,
            'start_date'    => $request->start_date,
            'end_date'      => $request->end_date,
        ];

        $pdf = Pdf::loadView('master.restock.pdf', compact('restocks', 'filters'))
            ->setPaper('a4', 'landscape')
            ->setOptions([
                'defaultFont'          => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled'      => false,
            ]);

        $filename = 'laporan-restock-' . now()->format('Ymd-His') . '.pdf';

        return $pdf->download($filename);
    }

    // ─────────────────────────────────────────────────────────────
    //  CRUD
    // ─────────────────────────────────────────────────────────────

    public function create()
    {
        $kodeRestock = Restock::generateKodeRestock();
        $suppliers   = Supplier::aktif()->get();
        $produks     = Produk::aktif()->with('kategori')->get();

        return view('master.restock.create', compact('kodeRestock', 'suppliers', 'produks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_restock'           => 'required|unique:01_restock,kode_restock|max:50',
            'tanggal_restock'        => 'required|date',
            'id_supplier'            => 'nullable|exists:01_supplier,id',
            'keterangan'             => 'nullable',
            'status'                 => 'required|in:draft,selesai,dibatalkan',
            'produk'                 => 'required|array|min:1',
            'produk.*.id_produk'     => 'required|exists:01_produk,id',
            'produk.*.jumlah'        => 'required|integer|min:1',
            'produk.*.harga_beli'    => 'required|numeric|min:0',
            'produk.*.catatan'       => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $totalBiaya = 0;
            foreach ($request->produk as $item) {
                $totalBiaya += $item['jumlah'] * $item['harga_beli'];
            }

            $restock = Restock::create([
                'kode_restock'    => $validated['kode_restock'],
                'tanggal_restock' => $validated['tanggal_restock'],
                'id_supplier'     => $validated['id_supplier'],
                'id_user'         => Auth::id(),
                'keterangan'      => $validated['keterangan'],
                'total_biaya'     => $totalBiaya,
                'status'          => $validated['status'],
            ]);

            foreach ($request->produk as $item) {
                $subtotal = $item['jumlah'] * $item['harga_beli'];
                RestockDetail::create([
                    'id_restock' => $restock->id,
                    'id_produk'  => $item['id_produk'],
                    'jumlah'     => $item['jumlah'],
                    'harga_beli' => $item['harga_beli'],
                    'subtotal'   => $subtotal,
                    'catatan'    => $item['catatan'] ?? null,
                ]);

                if ($validated['status'] === 'selesai') {
                    Produk::find($item['id_produk'])->increment('stok', $item['jumlah']);
                }
            }

            DB::commit();
            return redirect()->route('admin.restock.index')->with('success', 'Restock berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Restock $restock)
    {
        $restock->load(['supplier', 'user', 'details.produk.kategori']);
        return view('master.restock.show', compact('restock'));
    }

    public function edit(Restock $restock)
    {
        if ($restock->status !== 'draft') {
            return redirect()->route('admin.restock.index')
                ->with('error', 'Hanya restock dengan status draft yang dapat diedit!');
        }

        $restock->load(['details.produk']);
        $suppliers = Supplier::aktif()->get();
        $produks   = Produk::aktif()->with('kategori')->get();

        return view('master.restock.edit', compact('restock', 'suppliers', 'produks'));
    }

    public function update(Request $request, Restock $restock)
    {
        if ($restock->status !== 'draft') {
            return redirect()->route('admin.restock.index')
                ->with('error', 'Hanya restock dengan status draft yang dapat diupdate!');
        }

        $validated = $request->validate([
            'kode_restock'           => 'required|max:50|unique:01_restock,kode_restock,' . $restock->id,
            'tanggal_restock'        => 'required|date',
            'id_supplier'            => 'nullable|exists:01_supplier,id',
            'keterangan'             => 'nullable',
            'status'                 => 'required|in:draft,selesai,dibatalkan',
            'produk'                 => 'required|array|min:1',
            'produk.*.id_produk'     => 'required|exists:01_produk,id',
            'produk.*.jumlah'        => 'required|integer|min:1',
            'produk.*.harga_beli'    => 'required|numeric|min:0',
            'produk.*.catatan'       => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $totalBiaya = 0;
            foreach ($request->produk as $item) {
                $totalBiaya += $item['jumlah'] * $item['harga_beli'];
            }

            $restock->update([
                'kode_restock'    => $validated['kode_restock'],
                'tanggal_restock' => $validated['tanggal_restock'],
                'id_supplier'     => $validated['id_supplier'],
                'keterangan'      => $validated['keterangan'],
                'total_biaya'     => $totalBiaya,
                'status'          => $validated['status'],
            ]);

            $restock->details()->delete();

            foreach ($request->produk as $item) {
                $subtotal = $item['jumlah'] * $item['harga_beli'];
                RestockDetail::create([
                    'id_restock' => $restock->id,
                    'id_produk'  => $item['id_produk'],
                    'jumlah'     => $item['jumlah'],
                    'harga_beli' => $item['harga_beli'],
                    'subtotal'   => $subtotal,
                    'catatan'    => $item['catatan'] ?? null,
                ]);

                if ($validated['status'] === 'selesai') {
                    Produk::find($item['id_produk'])->increment('stok', $item['jumlah']);
                }
            }

            DB::commit();
            return redirect()->route('admin.restock.index')->with('success', 'Restock berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Restock $restock)
    {
        if ($restock->status !== 'draft') {
            return redirect()->route('admin.restock.index')
                ->with('error', 'Hanya restock dengan status draft yang dapat dihapus!');
        }

        DB::beginTransaction();
        try {
            $restock->details()->delete();
            $restock->delete();
            DB::commit();
            return redirect()->route('admin.restock.index')->with('success', 'Restock berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function approve(Restock $restock)
    {
        if ($restock->status !== 'draft') {
            return redirect()->back()->with('error', 'Hanya restock dengan status draft yang dapat diapprove!');
        }

        DB::beginTransaction();
        try {
            foreach ($restock->details as $detail) {
                Produk::find($detail->id_produk)->increment('stok', $detail->jumlah);
            }
            $restock->update(['status' => 'selesai']);
            DB::commit();
            return redirect()->back()->with('success', 'Restock berhasil diapprove dan stok telah diupdate!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cancel(Restock $restock)
    {
        if ($restock->status === 'dibatalkan') {
            return redirect()->back()->with('error', 'Restock sudah dibatalkan!');
        }

        if ($restock->status === 'selesai') {
            return redirect()->back()->with('error', 'Restock yang sudah selesai tidak dapat dibatalkan!');
        }

        $restock->update(['status' => 'dibatalkan']);
        return redirect()->back()->with('success', 'Restock berhasil dibatalkan!');
    }

    public function getProduks(Request $request)
    {
        $search = $request->get('search');

        $produks = Produk::aktif()
            ->with('kategori')
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode_produk', 'like', "%{$search}%");
            })
            ->select('id', 'kode_produk', 'nama', 'stok', 'harga', 'satuan', 'id_kategori_produk')
            ->limit(10)
            ->get();

        return response()->json($produks);
    }
}
