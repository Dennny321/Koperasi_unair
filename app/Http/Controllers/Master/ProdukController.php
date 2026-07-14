<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\Produk;
use App\Models\Master\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Produk::with('kategori');

        if ($request->filled('kategori')) {
            $query->byKategori($request->kategori);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('stok_minimal')) {
            $query->stokMinimal();
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('kode_produk', 'like', "%{$search}%");
            });
        }

        $perPage = in_array((int) $request->get('per_page', 5), [5, 10, 25, 50, 100])
            ? (int) $request->get('per_page', 5)
            : 5;

        $produk    = $query->latest()->paginate($perPage)->withQueryString();
        $kategoris = KategoriProduk::all();

        return view('master.produk.index', compact('produk', 'kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = KategoriProduk::all();
        return view('master.produk.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_kategori_produk' => 'required|exists:01_kategori_produk,id',
            'kode_produk' => 'required|unique:01_produk,kode_produk|max:50',
            'nama' => 'required|max:255',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'satuan' => 'required|max:50',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('produk', $filename, 'public');
            $validated['foto'] = $path;
        }

        Produk::create($validated);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        $produk->load([
            'kategori',
            'restockDetails.restock.supplier',
        ]);

        return view('master.produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $kategoris = KategoriProduk::all();
        return view('master.produk.edit', compact('produk', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'id_kategori_produk' => 'required|exists:01_kategori_produk,id',
            'kode_produk' => 'required|max:50|unique:01_produk,kode_produk,' . $produk->id,
            'nama' => 'required|max:255',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'satuan' => 'required|max:50',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Delete old foto
            if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
                Storage::disk('public')->delete($produk->foto);
            }

            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('produk', $filename, 'public');
            $validated['foto'] = $path;
        }

        $produk->update($validated);

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        // Delete foto if exists
        if ($produk->foto && Storage::disk('public')->exists($produk->foto)) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil dihapus!');
    }
}
