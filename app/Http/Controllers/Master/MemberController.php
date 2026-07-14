<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::member();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('no_telepon', 'like', "%{$search}%");
            });
        }

        $perPage = in_array((int) $request->get('per_page', 5), [5, 10, 25, 50, 100])
            ? (int) $request->get('per_page', 5)
            : 5;

        $members = $query->latest()->paginate($perPage)->withQueryString();

        return view('master.member.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('master.member.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|max:255',
            'no_telepon'  => 'required|max:20|unique:users,no_telepon',
        ]);

        User::create([
            'name'       => $validated['name'],
            'no_telepon' => $validated['no_telepon'],
            'password'   => $validated['no_telepon'], // password = no_telepon (auto-hashed via cast)
            'role'       => 'member',
            'saldo_poin' => 0,
        ]);

        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'kasir';
        return redirect()->route("{$routePrefix}.member.index")
            ->with('success', 'Member berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $member)
    {
        $member->load('transaksiSebagaiMember', 'riwayatPoin', 'penukaran');
        return view('master.member.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $member)
    {
        return view('master.member.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $member)
    {
        $validated = $request->validate([
            'name'        => 'required|max:255',
            'no_telepon'  => 'required|max:20|unique:users,no_telepon,' . $member->id,
            'new_password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'name.required'          => 'Nama lengkap wajib diisi.',
            'no_telepon.required'    => 'Nomor telepon wajib diisi.',
            'no_telepon.unique'      => 'Nomor telepon sudah digunakan member lain.',
            'new_password.min'       => 'Password minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $data = [
            'name'       => $validated['name'],
            'no_telepon' => $validated['no_telepon'],
        ];

        // Hanya update password jika diisi
        if (!empty($validated['new_password'])) {
            $data['password'] = $validated['new_password']; // auto-hashed via cast
        }

        $member->update($data);

        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'kasir';
        return redirect()->route("{$routePrefix}.member.index")
            ->with('success', 'Data member berhasil diperbarui!');
    }

    /**
     * Reset password member menjadi no_telepon.
     */
    public function resetPassword(User $member)
    {
        $member->update([
            'password' => $member->no_telepon,
        ]);

        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'kasir';
        return redirect()->route("{$routePrefix}.member.show", $member->id)
            ->with('success', 'Password member berhasil direset ke nomor telepon!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $member)
    {
        $member->delete();

        $routePrefix = auth()->user()->role === 'admin' ? 'admin' : 'kasir';
        return redirect()->route("{$routePrefix}.member.index")
            ->with('success', 'Member berhasil dihapus!');
    }
}
