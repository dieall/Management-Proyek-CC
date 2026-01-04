<?php

namespace App\Http\Controllers;

use App\Models\Masjid;
use Illuminate\Http\Request;

class MasjidController extends Controller
{
    public function index()
    {
        $masjids = Masjid::latest()->paginate(10);
        return view('informasi.masjids.index', compact('masjids'));
    }

    public function create()
    {
        return view('informasi.masjids.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        Masjid::create($request->all());

        return redirect()->route('masjids.index')->with('success', 'Data Masjid berhasil ditambahkan!');
    }

    public function show(Masjid $masjid)
    {
        return view('informasi.masjids.show', compact('masjid'));
    }

    public function edit(Masjid $masjid)
    {
        return view('informasi.masjids.edit', compact('masjid'));
    }

    public function update(Request $request, Masjid $masjid)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $masjid->update($request->all());

        return redirect()->route('masjids.index')->with('success', 'Data Masjid berhasil diperbarui!');
    }

    public function destroy(Masjid $masjid)
    {
        $masjid->delete();
        return redirect()->route('masjids.index')->with('success', 'Data Masjid berhasil dihapus!');
    }
}
