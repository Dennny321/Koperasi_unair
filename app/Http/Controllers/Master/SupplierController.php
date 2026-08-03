<?php


namespace App\Http\Controllers\Master;


use App\Http\Controllers\Controller;
use App\Models\Master\Supplier;
use Illuminate\Http\Request;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode_supplier', 'like', "%{$search}%")
                    ->orWhere('telepon', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $perPage = in_array((int) $request->get('per_page', 10), [10, 25, 50, 100])
            ? (int) $request->get('per_page', 10)
            : 5;

        $suppliers = $query->latest()->paginate($perPage)->withQueryString();

        return view('master.supplier.index', compact('suppliers'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.supplier.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_supplier' => 'required|unique:01_supplier,kode_supplier|max:50',
            'nama' => 'required|max:255',
            'telepon' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable',
            'status' => 'required|in:aktif,nonaktif',
        ]);


        Supplier::create($validated);


        return redirect()->route('admin.supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        $supplier->load(['restocks' => function ($query) {
            $query->with(['details.produk', 'user'])
                ->latest()
                ->limit(10);
        }]);


        return view('master.supplier.show', compact('supplier'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        return view('master.supplier.edit', compact('supplier'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'kode_supplier' => 'required|max:50|unique:01_supplier,kode_supplier,' . $supplier->id,
            'nama' => 'required|max:255',
            'telepon' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable',
            'status' => 'required|in:aktif,nonaktif',
        ]);


        $supplier->update($validated);


        return redirect()->route('admin.supplier.index')
            ->with('success', 'Supplier berhasil diperbarui!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        // Cek apakah supplier pernah digunakan di restock
        if ($supplier->restocks()->count() > 0) {
            return redirect()->route('admin.supplier.index')
                ->with('error', 'Supplier tidak dapat dihapus karena memiliki riwayat restock!');
        }


        $supplier->delete();


        return redirect()->route('admin.supplier.index')
            ->with('success', 'Supplier berhasil dihapus!');
    }


    /**
     * Get supplier data for select2 or ajax
     */
    public function getSuppliers(Request $request)
    {
        $search = $request->get('search');


        $suppliers = Supplier::aktif()
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode_supplier', 'like', "%{$search}%");
            })
            ->select('id', 'kode_supplier', 'nama', 'telepon')
            ->limit(10)
            ->get();


        return response()->json($suppliers);
    }
}
