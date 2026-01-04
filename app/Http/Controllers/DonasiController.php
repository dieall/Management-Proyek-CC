<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('donasi.create');
    }

    public function store(Request $request)
    {
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
        
        return view('donasi.show', compact('donasi', 'totalDonasi', 'totalDonatur', 'riwayatDonasi'));
    }

    public function edit(Donasi $donasi)
    {
        return view('donasi.edit', compact('donasi'));
    }

    public function update(Request $request, Donasi $donasi)
    {
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
        $donasi->delete();
        return redirect()->route('donasi.index')->with('success', 'Program donasi berhasil dihapus!');
    }

    // Submit donasi
    public function submitDonasi(Request $request, $id)
    {
        $request->validate([
            'besar_donasi' => 'required|numeric|min:1000',
            'tanggal_donasi' => 'required|date',
        ]);

        $donasi = Donasi::findOrFail($id);
        $user = auth()->user();

        DB::table('riwayat_donasi')->insert([
            'id_jamaah' => $user->id,
            'id_donasi' => $donasi->id_donasi,
            'besar_donasi' => $request->besar_donasi,
            'tanggal_donasi' => $request->tanggal_donasi,
        ]);

        return back()->with('success', 'Donasi berhasil dicatat!');
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

