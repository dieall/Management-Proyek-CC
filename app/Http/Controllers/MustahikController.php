<?php

namespace App\Http\Controllers;

use App\Models\Mustahik;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth; // Tambah impor
use Illuminate\Support\Facades\Storage; // Tambah impor

class MustahikController extends Controller
{
    /**
     * Display a listing of mustahik (Hanya yang sudah disetujui/aktif).
     */
    public function index(Request $request): View
    {
        // Default: Hanya tampilkan mustahik yang sudah disetujui
        $search = $request->input('search');
        
        $query = Mustahik::where('status_verifikasi', 'disetujui');
        
        if ($search) {
            $query->where('nama', 'like', '%' . $search . '%');
        }
        
        $mustahik = $query->orderBy('nama')->paginate(10)->appends($request->query());
        
        return view('zis.mustahik.index', compact('mustahik', 'search'));
    }

    /**
     * Show the form for creating a new mustahik (Admin input manual).
     */
    public function create(): View
    {
        $categories = ['fakir', 'miskin', 'amil', 'muallaf', 'riqab', 'gharim', 'fisabillillah', 'ibnu sabil'];
        return view('zis.mustahik.create', compact('categories'));
    }

    /**
     * Store a newly created mustahik in storage (Admin input manual).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'kategori_mustahik' => 'required|in:fakir,miskin,amil,muallaf,riqab,gharim,fisabillillah,ibnu sabil',
            'no_hp' => 'nullable|string|max:20',
            // File DTKS dihandle terpisah di RegistrationController, di sini diabaikan.
            // Jika Admin ingin input file manual, logic upload perlu ditambahkan.
            'surat_dtks' => 'nullable|string|max:255', 
            // 'status' dihapus karena diganti oleh status_verifikasi di pendaftaran
        ]);

        // Secara default, Admin yang memasukkan data dianggap disetujui dan aktif
        $validated['status_verifikasi'] = 'disetujui';

        Mustahik::create($validated);

        return redirect()->route('admin.mustahik.index')
             ->with('success', 'Data mustahik berhasil ditambahkan');
    }

    /**
     * Display the specified mustahik.
     */
    public function show(Mustahik $mustahik): View
    {
        $mustahik->load('penyaluran.zisMasuk');
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
            'surat_dtks' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // 2MB max
        ]);

        // Handle file upload untuk DTKS
        if ($request->hasFile('surat_dtks')) {
            // Hapus file lama jika ada
            if ($mustahik->surat_dtks && Storage::disk('public')->exists($mustahik->surat_dtks)) {
                Storage::disk('public')->delete($mustahik->surat_dtks);
            }

            // Upload file baru
            $file = $request->file('surat_dtks');
            $fileName = 'mustahik_dtks/' . time() . '_' . $file->getClientOriginalName();
            $file->storeAs('mustahik_dtks', basename($fileName), 'public');
            $validated['surat_dtks'] = $fileName;
        } else {
            // Jika tidak ada file baru, hapus key surat_dtks dari validated
            unset($validated['surat_dtks']);
        }

        $mustahik->update($validated);

        return redirect()->route('admin.mustahik.show', $mustahik)
            ->with('success', 'Data mustahik berhasil diperbarui');
    }

    /**
     * Remove the specified mustahik from storage.
     */
    public function destroy(Mustahik $mustahik): RedirectResponse
    {
        $mustahik->delete();

        return redirect()->route('admin.mustahik.index')
            ->with('success', 'Data mustahik berhasil dihapus');
    }

    // =======================================================
    // --- FITUR BARU: VERIFIKASI PENDAFTARAN MUSTAHIK ---
    // =======================================================

    /**
     * Tampilkan detail Mustahik dan file DTKS untuk verifikasi oleh Admin.
     */
    public function showVerification(Mustahik $mustahik): View|RedirectResponse
    {
        // Otorisasi: Pastikan hanya admin yang bisa mengakses
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        $dtksUrl = null;
        if ($mustahik->surat_dtks) {
            // Cek apakah file ada di storage
            if (Storage::disk('public')->exists($mustahik->surat_dtks)) {
                $dtksUrl = Storage::disk('public')->url($mustahik->surat_dtks);
            } else {
                // Fallback: coba langsung dari path yang disimpan
                $dtksUrl = asset('storage/' . $mustahik->surat_dtks);
            }
        }

        return view('admin.mustahik.verifikasi', compact('mustahik', 'dtksUrl'));
    }

    /**
     * Setujui pendaftaran Mustahik (Ubah status_verifikasi menjadi 'disetujui').
     */
    public function approve(Request $request, Mustahik $mustahik): RedirectResponse
    {
        // Otorisasi: Pastikan hanya admin yang bisa mengakses
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        // Update status verifikasi
        $mustahik->update([
            'status_verifikasi' => 'disetujui', 
        ]);

        return redirect()->route('admin.mustahik.index')
                         ->with('success', 'Mustahik ' . $mustahik->nama . ' berhasil disetujui.');
    }
}