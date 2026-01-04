<?php

namespace App\Http\Controllers;

use App\Models\Muzakki;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MuzakkiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            $muzakkis = Muzakki::orderBy('created_at', 'desc')->get();
        } else {
            // User biasa hanya lihat yang sudah disetujui
            $muzakkis = Muzakki::disetujui()->orderBy('created_at', 'desc')->get();
        }
        
        return view('zis.muzakki.index', compact('muzakkis'));
    }

    public function create()
    {
        return view('zis.muzakki.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        $data = $request->except('password');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        // Jika user sudah login, hubungkan ke user_id
        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        Muzakki::create($data);

        return redirect()->route('muzakki.index')->with('success', 'Data Muzakki berhasil ditambahkan!');
    }

    public function show(Muzakki $muzakki)
    {
        $muzakki->load('zisMasuk');
        
        // Statistik
        $totalZIS = $muzakki->zisMasuk()->sum('jumlah');
        $totalZakat = $muzakki->zisMasuk()->where('jenis_zis', 'zakat')->sum('jumlah');
        $totalInfaq = $muzakki->zisMasuk()->where('jenis_zis', 'infaq')->sum('jumlah');
        $totalShadaqah = $muzakki->zisMasuk()->where('jenis_zis', 'shadaqah')->sum('jumlah');
        $totalWakaf = $muzakki->zisMasuk()->where('jenis_zis', 'wakaf')->sum('jumlah');
        
        return view('zis.muzakki.show', compact('muzakki', 'totalZIS', 'totalZakat', 'totalInfaq', 'totalShadaqah', 'totalWakaf'));
    }

    public function edit(Muzakki $muzakki)
    {
        return view('zis.muzakki.edit', compact('muzakki'));
    }

    public function update(Request $request, Muzakki $muzakki)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
            'status_pendaftaran' => 'required|in:menunggu,disetujui,ditolak',
        ]);

        $data = $request->except('password');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $muzakki->update($data);

        return redirect()->route('muzakki.index')->with('success', 'Data Muzakki berhasil diperbarui!');
    }

    public function destroy(Muzakki $muzakki)
    {
        $muzakki->delete();
        return redirect()->route('muzakki.index')->with('success', 'Data Muzakki berhasil dihapus!');
    }

    // Approve muzakki
    public function approve($id)
    {
        $muzakki = Muzakki::findOrFail($id);
        $muzakki->update(['status_pendaftaran' => 'disetujui']);
        
        return back()->with('success', 'Muzakki berhasil disetujui!');
    }

    // Reject muzakki
    public function reject($id)
    {
        $muzakki = Muzakki::findOrFail($id);
        $muzakki->update(['status_pendaftaran' => 'ditolak']);
        
        return back()->with('success', 'Muzakki ditolak!');
    }
}

