<?php

namespace App\Http\Controllers;

use App\Models\Jamaah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username'   => 'required|string',
            'kata_sandi' => 'required|string'
        ]);

        // Cari jamaah berdasarkan username
        $user = Jamaah::where('username', $validated['username'])->first();

        // 1. Cek User ada?
        // 2. Cek Password hash match?
        if (!$user || !Hash::check($validated['kata_sandi'], $user->kata_sandi)) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Username atau password salah'
            ], 401);
        }

        // 3. Cek Status Aktif
        if (!$user->status_aktif) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Akun Anda telah dinonaktifkan.'
            ], 403);
        }

        // Hapus token lama (opsional, agar 1 device 1 token) atau biarkan untuk multi-device
        // $user->tokens()->delete(); 

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'data' => [
                'user'  => $user,
                'token' => $token
            ]
        ]);
    }

    public function logout(Request $request)
    {
        // Hapus token yang sedang dipakai saat ini
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil logout'
        ]);
    }
}