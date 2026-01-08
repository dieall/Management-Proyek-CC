<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Hanya admin / superadmin / DKM yang boleh melihat daftar user
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isSuperAdmin() && !$user->isDkm()) {
            abort(403, 'Hanya admin yang dapat mengelola user.');
        }

        $users = User::orderBy('created_at', 'desc')->paginate(15);
        
        return view('users.index', compact('users'));
    }

    public function create()
    {
        // Hanya admin / superadmin / DKM yang boleh membuat user
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isSuperAdmin() && !$user->isDkm()) {
            abort(403, 'Hanya admin yang dapat mengelola user.');
        }

        return view('users.create');
    }

    public function store(Request $request)
    {
        // Hanya admin / superadmin / DKM yang boleh membuat user
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isSuperAdmin() && !$user->isDkm()) {
            abort(403, 'Hanya admin yang dapat mengelola user.');
        }

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'nama_lengkap' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:superadmin,admin,dkm,panitia,jemaah,muzakki,mustahik,user',
            'status_aktif' => 'required|in:aktif,non-aktif',
            'tanggal_daftar' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        
        if (!$request->filled('tanggal_daftar')) {
            $data['tanggal_daftar'] = now()->toDateString();
        }

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    public function show(User $user)
    {
        // Hanya admin / superadmin / DKM yang boleh melihat detail user
        $authUser = Auth::user();
        if (!$authUser->isAdmin() && !$authUser->isSuperAdmin() && !$authUser->isDkm()) {
            abort(403, 'Hanya admin yang dapat mengelola user.');
        }

        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        // Hanya admin / superadmin / DKM yang boleh mengedit user
        $authUser = Auth::user();
        if (!$authUser->isAdmin() && !$authUser->isSuperAdmin() && !$authUser->isDkm()) {
            abort(403, 'Hanya admin yang dapat mengelola user.');
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Hanya admin / superadmin / DKM yang boleh mengupdate user
        $authUser = Auth::user();
        if (!$authUser->isAdmin() && !$authUser->isSuperAdmin() && !$authUser->isDkm()) {
            abort(403, 'Hanya admin yang dapat mengelola user.');
        }

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'nama_lengkap' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:superadmin,admin,dkm,panitia,jemaah,muzakki,mustahik,user',
            'status_aktif' => 'required|in:aktif,non-aktif',
            'tanggal_daftar' => 'nullable|date',
        ]);

        $data = $request->except('password', 'password_confirmation');
        
        // Update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        // Hanya admin / superadmin / DKM yang boleh menghapus user
        $authUser = Auth::user();
        if (!$authUser->isAdmin() && !$authUser->isSuperAdmin() && !$authUser->isDkm()) {
            abort(403, 'Hanya admin yang dapat mengelola user.');
        }

        // Jangan biarkan menghapus diri sendiri
        if ($user->id === $authUser->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}

