<?php

namespace App\Http\Controllers;

use App\Models\Muzakki;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MuzakkiController extends Controller
{
    /**
     * Display a listing of muzakki.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        
        $query = Muzakki::query();
        
        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }
        
        $muzakki = $query->orderBy('nama')->paginate(10)->appends($request->query());
        
        return view('zis.muzakki.index', compact('muzakki', 'search'));
    }

    /**
     * Show the form for creating a new muzakki.
     */
    public function create(): View
    {
        return view('zis.muzakki.create');
    }

    /**
     * Store a newly created muzakki in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        if ($validated['password']) {
            $validated['password'] = bcrypt($validated['password']);
        }

        Muzakki::create($validated);

        return redirect()->route('admin.muzakki.index')
            ->with('success', 'Data muzakki berhasil ditambahkan');
    }

    /**
     * Display the specified muzakki.
     */
    public function show(Muzakki $muzakki): View
    {
        $muzakki->load('zismasuk');
        return view('zis.muzakki.show', compact('muzakki'));
    }

    /**
     * Show the form for editing the specified muzakki.
     */
    public function edit(Muzakki $muzakki): View
    {
        return view('zis.muzakki.edit', compact('muzakki'));
    }

    /**
     * Update the specified muzakki in storage.
     */
    public function update(Request $request, Muzakki $muzakki): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        if ($validated['password']) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $muzakki->update($validated);

        return redirect()->route('admin.muzakki.show', $muzakki)
            ->with('success', 'Data muzakki berhasil diperbarui');
    }

    /**
     * Remove the specified muzakki from storage.
     */
    public function destroy(Muzakki $muzakki): RedirectResponse
    {
        $muzakki->delete();

        return redirect()->route('admin.muzakki.index')
            ->with('success', 'Data muzakki berhasil dihapus');
    }
}
