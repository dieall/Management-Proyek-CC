<?php

namespace App\Http\Controllers;

use App\Models\Mustahik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MustahikController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $mustahiks = Mustahik::orderBy('created_at', 'desc')->get();
        } else {
            $mustahiks = Mustahik::aktif()->disetujui()->orderBy('created_at', 'desc')->get();
        }
        
        return view('zis.mustahik.index', compact('mustahiks'));
    }

    public function create()
    {
        return view('zis.mustahik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'kategori_mustahik' => 'nullable|string|max:50',
            'no_hp' => 'nullable|string|max:20',
            'surat_dtks' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
            'status' => 'required|in:aktif,non-aktif',
        ]);

        $data = $request->all();
        
        if ($request->hasFile('surat_dtks')) {
            $data['surat_dtks'] = $request->file('surat_dtks')->store('mustahik_dtks', 'public');
        }

        Mustahik::create($data);

        return redirect()->route('mustahik.index')->with('success', 'Data Mustahik berhasil ditambahkan!');
    }

    public function show(Mustahik $mustahik)
    {
        $mustahik->load('penyaluran.zisMasuk');
        
        // Statistik
        $totalPenerimaan = $mustahik->penyaluran()->sum('jumlah');
        $jumlahPenyaluran = $mustahik->penyaluran()->count();
        
        return view('zis.mustahik.show', compact('mustahik', 'totalPenerimaan', 'jumlahPenyaluran'));
    }

    public function edit(Mustahik $mustahik)
    {
        return view('zis.mustahik.edit', compact('mustahik'));
    }

    public function update(Request $request, Mustahik $mustahik)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'kategori_mustahik' => 'nullable|string|max:50',
            'no_hp' => 'nullable|string|max:20',
            'surat_dtks' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
            'status' => 'required|in:aktif,non-aktif',
            'status_verifikasi' => 'required|in:pending,disetujui,ditolak',
        ]);

        $data = $request->except('surat_dtks');
        
        if ($request->hasFile('surat_dtks')) {
            // Hapus file lama jika ada
            if ($mustahik->surat_dtks) {
                Storage::disk('public')->delete($mustahik->surat_dtks);
            }
            $data['surat_dtks'] = $request->file('surat_dtks')->store('mustahik_dtks', 'public');
        }

        $mustahik->update($data);

        return redirect()->route('mustahik.index')->with('success', 'Data Mustahik berhasil diperbarui!');
    }

    public function destroy(Mustahik $mustahik)
    {
        if ($mustahik->surat_dtks) {
            Storage::disk('public')->delete($mustahik->surat_dtks);
        }
        
        $mustahik->delete();
        return redirect()->route('mustahik.index')->with('success', 'Data Mustahik berhasil dihapus!');
    }
}

