<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DonasiController extends Controller
{
    public function index()
    {
        $donasis = Donasi::orderBy('tanggal_mulai', 'desc')->get();
        
        // Tambahkan total donasi ke setiap program
        $donasis->each(function ($donasi) {
            $donasi->total_terkumpul = DB::table('riwayat_donasi')
                ->where('id_donasi', $donasi->id_donasi)
                ->sum('besar_donasi');
        });
        
        return view('donasi.index', compact('donasis'));
    }

    public function create()
    {
        // Hanya admin / superadmin / DKM yang boleh mengisi (membuat) program donasi
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isSuperAdmin() && !$user->isDkm()) {
            abort(403, 'Hanya admin yang dapat mengelola program donasi.');
        }

        return view('donasi.create');
    }

    public function store(Request $request)
    {
        // Hanya admin / superadmin / DKM yang boleh mengisi (membuat) program donasi
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isSuperAdmin() && !$user->isDkm()) {
            abort(403, 'Hanya admin yang dapat mengelola program donasi.');
        }

        $request->validate([
            'nama_donasi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'deskripsi' => 'nullable|string',
        ]);

        Donasi::create($request->all());

        return redirect()->route('donasi.index')->with('success', 'Program donasi berhasil ditambahkan!');
    }

    public function show(Donasi $donasi)
    {
        $donasi->load('donatur');
        
        // Statistik
        $totalDonasi = DB::table('riwayat_donasi')
            ->where('id_donasi', $donasi->id_donasi)
            ->sum('besar_donasi');
        
        $totalDonatur = $donasi->donatur()->distinct('id_jamaah')->count();
        
        $riwayatDonasi = DB::table('riwayat_donasi')
            ->join('users', 'riwayat_donasi.id_jamaah', '=', 'users.id')
            ->where('riwayat_donasi.id_donasi', $donasi->id_donasi)
            ->select('users.nama_lengkap', 'riwayat_donasi.*')
            ->orderBy('riwayat_donasi.tanggal_donasi', 'desc')
            ->get();
        
        // Ambil daftar jamaah untuk dropdown (hanya untuk admin)
        $jamaahs = [];
        if (Auth::user()->isAdmin() || Auth::user()->isSuperAdmin() || Auth::user()->isDkm()) {
            $jamaahs = User::where('role', 'jemaah')
                          ->where('status_aktif', 'aktif')
                          ->orderBy('nama_lengkap')
                          ->orderBy('name')
                          ->get();
        }
        
        return view('donasi.show', compact('donasi', 'totalDonasi', 'totalDonatur', 'riwayatDonasi', 'jamaahs'));
    }

    public function edit(Donasi $donasi)
    {
        // Hanya admin / superadmin / DKM yang boleh mengubah program donasi
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isSuperAdmin() && !$user->isDkm()) {
            abort(403, 'Hanya admin yang dapat mengelola program donasi.');
        }

        return view('donasi.edit', compact('donasi'));
    }

    public function update(Request $request, Donasi $donasi)
    {
        // Hanya admin / superadmin / DKM yang boleh mengubah program donasi
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isSuperAdmin() && !$user->isDkm()) {
            abort(403, 'Hanya admin yang dapat mengelola program donasi.');
        }

        $request->validate([
            'nama_donasi' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'deskripsi' => 'nullable|string',
        ]);

        $donasi->update($request->all());

        return redirect()->route('donasi.index')->with('success', 'Program donasi berhasil diperbarui!');
    }

    public function destroy(Donasi $donasi)
    {
        // Hanya admin / superadmin / DKM yang boleh menghapus program donasi
        $user = Auth::user();
        if (!$user->isAdmin() && !$user->isSuperAdmin() && !$user->isDkm()) {
            abort(403, 'Hanya admin yang dapat mengelola program donasi.');
        }

        $donasi->delete();
        return redirect()->route('donasi.index')->with('success', 'Program donasi berhasil dihapus!');
    }

    // Submit donasi
    public function submitDonasi(Request $request, $id)
    {
        // Hanya admin / superadmin / DKM yang boleh mencatat donasi
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isSuperAdmin() && !$user->isDkm()) {
            abort(403, 'Hanya admin yang dapat mencatat donasi.');
        }

        $request->validate([
            'id_jamaah' => 'required|exists:users,id',
            'besar_donasi' => 'required|numeric|min:1000',
            'tanggal_donasi' => 'required|date',
        ]);

        // Validasi bahwa user yang dipilih adalah jamaah
        $jamaah = User::findOrFail($request->id_jamaah);
        if ($jamaah->role !== 'jemaah') {
            return back()->withErrors(['id_jamaah' => 'User yang dipilih harus berstatus jamaah.'])->withInput();
        }

        $donasi = Donasi::findOrFail($id);

        DB::table('riwayat_donasi')->insert([
            'id_jamaah' => $request->id_jamaah,
            'id_donasi' => $donasi->id_donasi,
            'besar_donasi' => $request->besar_donasi,
            'tanggal_donasi' => $request->tanggal_donasi,
        ]);

        return back()->with('success', 'Donasi berhasil dicatat atas nama ' . ($jamaah->nama_lengkap ?? $jamaah->name) . '!');
    }

    // Riwayat donasi saya
    public function myDonations()
    {
        $user = auth()->user();
        
        $riwayatDonasi = DB::table('riwayat_donasi')
            ->join('donasi', 'riwayat_donasi.id_donasi', '=', 'donasi.id_donasi')
            ->where('riwayat_donasi.id_jamaah', $user->id)
            ->select('donasi.nama_donasi', 'riwayat_donasi.*')
            ->orderBy('riwayat_donasi.tanggal_donasi', 'desc')
            ->get();
        
        $totalDonasi = $riwayatDonasi->sum('besar_donasi');
        
        return view('donasi.my-donations', compact('riwayatDonasi', 'totalDonasi'));
    }
}

