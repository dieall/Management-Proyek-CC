<?php

namespace App\Http\Controllers;

use App\Models\Jamaah;
use App\Models\Kategori; // Jangan lupa import ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class JamaahController extends Controller
{
    public function index(Request $request)
    {
        // 1. Data untuk Tab Jamaah (TAMPIL SEMUA)
        $query = Jamaah::with('kategori');

        if ($request->has('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->q . '%')
                ->orWhere('username', 'like', '%' . $request->q . '%');
            });
        }

        $jamaah = $query->latest()->get(); // ← INI KUNCINYA

        // 2. Data untuk Tab Kategori
        $kategoriList = Kategori::withCount('jamaah')->latest()->get();

        // 3. Data untuk Dropdown Form
        $allKategori = Kategori::all();

        return view('admin.jamaah.index', compact(
            'jamaah',
            'kategoriList',
            'allKategori'
        ));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'username'      => 'required|unique:jamaah,username',
            'nama_lengkap'  => 'required',
            'kata_sandi'    => 'required|min:6',
            'jenis_kelamin' => 'required|in:L,P',
            'no_handphone'  => 'nullable',
            'alamat'        => 'nullable',
            'kategori_ids'  => 'nullable|array' // Validasi input array kategori
        ]);

        $user = Jamaah::create($validated);

        // Simpan relasi kategori (Pivot)
        // Default status_aktif di pivot = true, periode = tahun ini
        if ($request->has('kategori_ids')) {
            $user->kategori()->syncWithPivotValues($request->kategori_ids, [
                'status_aktif' => true,
                'periode' => date('Y') . '-' . (date('Y') + 1)
            ]);
        }

        return redirect()->route('jamaah.index')->with('success', 'Jamaah berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $jamaah = Jamaah::findOrFail($id);

        $validated = $request->validate([
            'username'     => ['required', Rule::unique('jamaah')->ignore($id, 'id_jamaah')],
            'nama_lengkap' => 'required',
            'no_handphone' => 'nullable',
            'alamat'       => 'nullable',
            'kata_sandi'   => 'nullable|min:6',
            'kategori_ids' => 'nullable|array'
        ]);

        if (empty($validated['kata_sandi'])) {
            unset($validated['kata_sandi']);
        }

        $jamaah->update($validated);

        // Update relasi kategori
        if ($request->has('kategori_ids')) {
            $jamaah->kategori()->syncWithPivotValues($request->kategori_ids, [
                'status_aktif' => true,
                'periode' => date('Y') . '-' . (date('Y') + 1)
            ]);
        } else {
            // Jika semua checkbox diuncheck, hapus semua kategori
            $jamaah->kategori()->detach();
        }

        return redirect()->route('jamaah.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jamaah = Jamaah::findOrFail($id);
        $jamaah->kategori()->detach(); // Hapus relasi dulu
        $jamaah->delete();
        
        return redirect()->route('jamaah.index')->with('success', 'Data dihapus');
    }
}