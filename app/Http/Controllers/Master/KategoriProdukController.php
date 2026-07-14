<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\KategoriProduk;
use Illuminate\Http\Request;

class KategoriProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = KategoriProduk::withCount('produk');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        $perPage = in_array((int) $request->get('per_page', 5), [5, 10, 25, 50, 100])
            ? (int) $request->get('per_page', 5)
            : 5;

        $kategoris = $query->latest()->paginate($perPage)->withQueryString();

        return view('master.kategori-produk.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.kategori-produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255|unique:01_kategori_produk,nama',
            'keterangan' => 'nullable|max:500',
            'ikon' => 'nullable|max:100',
        ]);

        KategoriProduk::create($validated);

        return redirect()->route('admin.kategori-produk.index')
            ->with('success', 'Kategori produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriProduk $kategoriProduk)
    {
        $kategoriProduk->loadCount('produk');
        $kategoriProduk->load(['produk' => function ($query) {
            $query->latest()->take(10);
        }]);

        return view('master.kategori-produk.show', compact('kategoriProduk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriProduk $kategoriProduk)
    {
        return view('master.kategori-produk.edit', compact('kategoriProduk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriProduk $kategoriProduk)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255|unique:01_kategori_produk,nama,' . $kategoriProduk->id,
            'keterangan' => 'nullable|max:500',
            'ikon' => 'nullable|max:100',
        ]);

        $kategoriProduk->update($validated);

        return redirect()->route('admin.kategori-produk.index')
            ->with('success', 'Kategori produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriProduk $kategoriProduk)
    {
        // Cek apakah kategori memiliki produk
        if ($kategoriProduk->produk()->count() > 0) {
            return redirect()->route('admin.kategori-produk.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk terkait!');
        }

        $kategoriProduk->delete();

        return redirect()->route('admin.kategori-produk.index')
            ->with('success', 'Kategori produk berhasil dihapus!');
    }
}
