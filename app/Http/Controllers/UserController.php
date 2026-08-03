<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    // ─────────────────────────────────────────────────────────────
    //  INDEX
    // ─────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = User::query()->where('role', '!=', 'member');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('no_telepon', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->byRole($request->role);
        }

        // ✅ Ambil per_page dari request, default 10, max 100
        $perPage = in_array((int) $request->get('per_page', 10), [ 10, 25, 50, 100])
            ? (int) $request->get('per_page', 10)
            : 10;

        $users = $query->latest()->paginate($perPage)->withQueryString();

        $stats = [
            'total' => User::where('role', '!=', 'member')->count(),
            'admin' => User::admin()->count(),
            'kasir' => User::kasir()->count(),
        ];

        return view('master.user.index', compact('users', 'stats'));
    }

    // ─────────────────────────────────────────────────────────────
    //  AJAX: CEK DUPLIKAT (dipakai create & edit via fetch)
    //  GET /admin/user/check-duplicate?field=email&value=x&ignore_id=5
    // ─────────────────────────────────────────────────────────────

    public function checkDuplicate(Request $request)
    {
        $field    = $request->query('field');
        $value    = trim($request->query('value', ''));
        $ignoreId = $request->query('ignore_id');

        // Hanya izinkan field yang diketahui
        if (!in_array($field, ['name', 'username', 'email', 'no_telepon'])) {
            return response()->json(['exists' => false]);
        }

        if ($value === '') {
            return response()->json(['exists' => false]);
        }

        $query = User::where($field, $value);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return response()->json(['exists' => $query->exists()]);
    }

    // ─────────────────────────────────────────────────────────────
    //  CREATE
    // ─────────────────────────────────────────────────────────────

    public function create()
    {
        return view('master.user.create');
    }

    // ─────────────────────────────────────────────────────────────
    //  STORE
    // ─────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $request->validate([
            'name'       => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'name'),
            ],
            'username'   => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('users', 'username'),
            ],
            'email'      => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],
            'no_telepon' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('users', 'no_telepon'),
            ],
            'role'       => 'required|in:admin,kasir,member',
            'saldo_poin' => 'nullable|integer|min:0',
            'password'   => ['required', 'confirmed', Password::min(8)],
        ], [
            'name.unique'        => 'Nama ini sudah digunakan oleh user lain.',
            'username.unique'    => 'Username ini sudah digunakan oleh user lain.',
            'username.alpha_dash' => 'Username tidak boleh mengandung unsur spasi, hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
            'email.unique'       => 'Email ini sudah terdaftar.',
            'no_telepon.unique'  => 'Nomor telepon ini sudah digunakan oleh user lain.',
        ]);

        User::create([
            'name'       => $request->name,
            'username'   => $request->username,
            'email'      => $request->email,
            'no_telepon' => $request->no_telepon ?? null,
            'role'       => $request->role,
            'saldo_poin' => $request->saldo_poin ?? 0,
            'password'   => Hash::make($request->password),
        ]);

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    // ─────────────────────────────────────────────────────────────
    //  SHOW
    // ─────────────────────────────────────────────────────────────

    public function show(User $user)
    {
        return view('master.user.show', compact('user'));
    }
    // ─────────────────────────────────────────────────────────────
    //  EDIT
    // ─────────────────────────────────────────────────────────────

    public function edit(User $user)
    {
        return view('master.user.edit', compact('user'));
    }

    // ─────────────────────────────────────────────────────────────
    //  UPDATE
    // ─────────────────────────────────────────────────────────────

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'       => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'name')->ignore($user->id),
            ],
            'username'   => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email'      => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'no_telepon' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('users', 'no_telepon')->ignore($user->id),
            ],
            'role'       => 'required|in:admin,kasir,member',
            'saldo_poin' => 'nullable|integer|min:0',
            'password'   => ['nullable', 'confirmed', Password::min(8)],
        ], [
            'name.unique'        => 'Nama ini sudah digunakan oleh user lain.',
            'username.unique'    => 'Username ini sudah digunakan oleh user lain.',
            'username.alpha_dash' => 'Username tidak boleh mengandung unsur spasi, hanya boleh berisi huruf, angka, tanda hubung, dan garis bawah.',
            'email.unique'       => 'Email ini sudah terdaftar.',
            'no_telepon.unique'  => 'Nomor telepon ini sudah digunakan oleh user lain.',
        ]);

        $data = [
            'name'       => $request->name,
            'username'   => $request->username,
            'email'      => $request->email,
            'no_telepon' => $request->no_telepon ?? null,
            'role'       => $request->role,
            'saldo_poin' => $request->saldo_poin ?? $user->saldo_poin,
        ];

        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.user.index')
            ->with('success', 'Data user berhasil diperbarui!');
    }

    // ─────────────────────────────────────────────────────────────
    //  DESTROY
    // ─────────────────────────────────────────────────────────────

    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus akun yang sedang digunakan!');
        }

        $user->delete();

        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil dihapus!');
    }

    // ─────────────────────────────────────────────────────────────
    //  RESET PASSWORD
    // ─────────────────────────────────────────────────────────────

    public function resetPassword(User $user)
    {
        $user->update(['password' => Hash::make('password123')]);

        return redirect()->back()
            ->with('success', "Password user {$user->name} berhasil direset ke 'password123'!");
    }
}
