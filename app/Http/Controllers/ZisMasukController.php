<?php

namespace App\Http\Controllers;

use App\Models\ZisMasuk;
use App\Models\Muzakki;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ZisMasukController extends Controller
{
    /**
     * Display a listing of the ZIS masuk.
     */
    public function index(): View
    {
        $zisMasuk = ZisMasuk::with('muzakki')
            ->orderBy('tgl_masuk', 'desc')
            ->paginate(10);

        return view('zis.masuk.index', compact('zisMasuk'));
    }

    /**
     * Show the form for creating a new ZIS masuk.
     */
    public function create(): View
    {
        $muzakki = Muzakki::all();
        return view('zis.masuk.create', compact('muzakki'));
    }

    /**
     * Store a newly created ZIS masuk in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_muzakki' => 'required|exists:muzakki,id_muzakki',
            'tgl_masuk' => 'required|date',
            'jenis_zis' => 'required|in:zakat,infaq,shadaqah,wakaf',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        ZisMasuk::create($validated);

        return redirect()->route('zis.masuk.index')
            ->with('success', 'Data ZIS berhasil ditambahkan');
    }

    /**
     * Display the specified ZIS masuk.
     */
    public function show(ZisMasuk $zisMasuk): View
    {
        $zisMasuk->load('muzakki', 'penyaluran.mustahik');
        return view('zis.masuk.show', compact('zisMasuk'));
    }

    /**
     * Show the form for editing the specified ZIS masuk.
     */
    public function edit(ZisMasuk $zisMasuk): View
    {
        $muzakki = Muzakki::all();
        return view('zis.masuk.edit', compact('zisMasuk', 'muzakki'));
    }

    /**
     * Update the specified ZIS masuk in storage.
     */
    public function update(Request $request, ZisMasuk $zisMasuk): RedirectResponse
    {
        $validated = $request->validate([
            'id_muzakki' => 'required|exists:muzakki,id_muzakki',
            'tgl_masuk' => 'required|date',
            'jenis_zis' => 'required|in:zakat,infaq,shadaqah,wakaf',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $zisMasuk->update($validated);

        return redirect()->route('zis.masuk.show', $zisMasuk)
            ->with('success', 'Data ZIS berhasil diperbarui');
    }

    /**
     * Remove the specified ZIS masuk from storage.
     */
    public function destroy(ZisMasuk $zisMasuk): RedirectResponse
    {
        $zisMasuk->delete();

        return redirect()->route('zis.masuk.index')
            ->with('success', 'Data ZIS berhasil dihapus');
    }
}
