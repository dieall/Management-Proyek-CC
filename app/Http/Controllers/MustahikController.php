<?php

namespace App\Http\Controllers;

use App\Models\Mustahik;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MustahikController extends Controller
{
    /**
     * Display a listing of mustahik.
     */
    public function index(): View
    {
        $mustahik = Mustahik::orderBy('nama')->paginate(10);
        return view('zis.mustahik.index', compact('mustahik'));
    }

    /**
     * Show the form for creating a new mustahik.
     */
    public function create(): View
    {
        $categories = ['fakir', 'miskin', 'amil', 'muallaf', 'riqab', 'gharim', 'fisabillillah', 'ibnu sabil'];
        return view('zis.mustahik.create', compact('categories'));
    }

    /**
     * Store a newly created mustahik in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'kategori_mustahik' => 'required|in:fakir,miskin,amil,muallaf,riqab,gharim,fisabillillah,ibnu sabil',
            'no_hp' => 'nullable|string|max:20',
            'surat_dtks' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,non-aktif',
        ]);

        Mustahik::create($validated);

        return redirect()->route('mustahik.index')
            ->with('success', 'Data mustahik berhasil ditambahkan');
    }

    /**
     * Display the specified mustahik.
     */
    public function show(Mustahik $mustahik): View
    {
        $mustahik->load('penyaluran.zismasuk');
        return view('zis.mustahik.show', compact('mustahik'));
    }

    /**
     * Show the form for editing the specified mustahik.
     */
    public function edit(Mustahik $mustahik): View
    {
        $categories = ['fakir', 'miskin', 'amil', 'muallaf', 'riqab', 'gharim', 'fisabillillah', 'ibnu sabil'];
        return view('zis.mustahik.edit', compact('mustahik', 'categories'));
    }

    /**
     * Update the specified mustahik in storage.
     */
    public function update(Request $request, Mustahik $mustahik): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'kategori_mustahik' => 'required|in:fakir,miskin,amil,muallaf,riqab,gharim,fisabillillah,ibnu sabil',
            'no_hp' => 'nullable|string|max:20',
            'surat_dtks' => 'nullable|string|max:255',
            'status' => 'required|in:aktif,non-aktif',
        ]);

        $mustahik->update($validated);

        return redirect()->route('mustahik.show', $mustahik)
            ->with('success', 'Data mustahik berhasil diperbarui');
    }

    /**
     * Remove the specified mustahik from storage.
     */
    public function destroy(Mustahik $mustahik): RedirectResponse
    {
        $mustahik->delete();

        return redirect()->route('mustahik.index')
            ->with('success', 'Data mustahik berhasil dihapus');
    }
}
