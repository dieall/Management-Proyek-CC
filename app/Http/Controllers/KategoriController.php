<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::withCount('jamaah')
            ->latest()
            ->get();

        return view('admin.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori',
            'deskripsi'     => 'nullable|string',
        ]);

        Kategori::create([
            'nama_kategori' => $validated['nama_kategori'],
            'deskripsi'     => $validated['deskripsi'] ?? null,
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,' . $id . ',id_kategori',
            'deskripsi'     => 'nullable|string',
        ]);

        $kategori->update([
            'nama_kategori' => $validated['nama_kategori'],
            'deskripsi'     => $validated['deskripsi'] ?? null,
        ]);

        return back()->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        // Opsional pengaman:
        // if ($kategori->jamaah()->count() > 0) {
        //     return back()->with('error', 'Kategori masih digunakan jamaah');
        // }

        $kategori->delete();

        return back()->with('success', 'Kategori berhasil dihapus');
    }
}
