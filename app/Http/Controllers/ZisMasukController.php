<?php

namespace App\Http\Controllers;

use App\Models\ZisMasuk;
use App\Models\Muzakki;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ZisMasukController extends Controller
{
    /**
     * Display a listing of the ZIS masuk.
     */
    public function index(): View
    {
        $query = ZisMasuk::with('muzakki')->orderBy('tgl_masuk', 'desc');
        $user = Auth::user();
        $userRole = $user->role;

        if ($userRole === 'admin') {
            // Admin bisa lihat semua ZIS Masuk
            $zisMasuk = $query->paginate(10);
            $view = 'zis.masuk.index'; 
        } else {
            // User/Jemaah: Hanya lihat pembayaran mereka sendiri
            $user->load('muzakkiProfile');
            $muzakkiProfile = $user->muzakkiProfile;
            
            if ($muzakkiProfile) {
                $muzakkiId = $muzakkiProfile->id_muzakki;
                $zisMasuk = $query->where('id_muzakki', $muzakkiId)->paginate(10);
            } else {
                // Jika belum punya profil Muzakki, tampilkan pesan
                $zisMasuk = collect(); // Kosongkan data
            }
            $view = 'user.pembayaran.index';
        }

        return view($view, compact('zisMasuk'));
    }

    /**
     * Show the form for creating a new ZIS masuk.
     */
    public function create(): View|RedirectResponse
    {
        $user = Auth::user();
        $userRole = $user->role;
        
        // --- DEKLARASI DATA KONSTANTA ---
        $jenisZisOptions = ['Zakat', 'Infak', 'Sedekah']; // Level 1
        $zakatTypes = ['Zakat Fitrah', 'Zakat Maal'];      // Level 2
        $fitrahAmount = [
            'beras_kg' => '3.5 liter',
            'uang_rp' => 55000, 
        ];
        $subJenisZakatMaal = [ // Level 3
            'Zakat Emas', 'Zakat Penghasilan', 'Zakat Tabungan', 'Zakat Perak', 
            'Zakat Perhiasan Perak', 'Zakat Perindustrian', 'Zakat Hasil Perniagaan', 
            'Zakat Pertambangan Emas', 'Zakat Pertambangan Perak', 'Zakat Perusahaan', 'Lainnya',
        ];

        if ($userRole === 'admin') {
            $muzakki = Muzakki::all();
            
            // ADMIN: Return view terpisah untuk input admin
            return view('zis.masuk.create', compact('muzakki', 'jenisZisOptions', 'zakatTypes', 'subJenisZakatMaal')); 
        } else {
            // LOGIKA JEMAAH/MUZAKKI
            $muzakkiProfile = $user->muzakkiProfile;

            // CEK STATUS MUZAKKI
            if (!$muzakkiProfile || $muzakkiProfile->status_pendaftaran !== 'disetujui') {
                 return redirect()->route('user.dashboard')->with('error', 'Akses Pembayaran ditolak. Akun Muzakki Anda belum disetujui oleh Admin.');
            }
            
            // JEMAAH: Return view pembayaran dinamis
            return view('user.pembayaran.create', compact('jenisZisOptions', 'fitrahAmount', 'zakatTypes', 'subJenisZakatMaal')); 
        }
    }

    /**
     * Store a newly created ZIS masuk in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $is_admin = ($user->role === 'admin');

        $validation_rules = [
            'jenis_zis' => 'required|in:zakat,infaq,shadaqah,wakaf', 
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'sub_jenis_zis' => 'nullable|string|max:50', 
        ];
        
        if ($is_admin) {
            $validation_rules['tgl_masuk'] = 'required|date';
            $validation_rules['id_muzakki'] = 'required|exists:muzakki,id_muzakki';
        } else {
            $validation_rules['tanggal_pembayaran'] = 'required|date';
        }

        $validated = $request->validate($validation_rules);
        $dataToStore = $validated;
        
        if (!$is_admin) {
            $muzakkiProfile = $user->muzakkiProfile;

            if (!$muzakkiProfile || $muzakkiProfile->status_pendaftaran !== 'disetujui') {
                 return back()->with('error', 'Akses Pembayaran ditolak. Akun Muzakki Anda belum disetujui oleh Admin.');
            }
            
            $dataToStore['id_muzakki'] = $muzakkiProfile->id_muzakki;
            
            $dataToStore['tgl_masuk'] = $dataToStore['tanggal_pembayaran'];
            unset($dataToStore['tanggal_pembayaran']); 
        }

        ZisMasuk::create($dataToStore);

        if ($is_admin) {
            return redirect()->route('admin.zis.masuk.index')
                ->with('success', 'Data ZIS berhasil ditambahkan');
        } else {
            return redirect()->route('user.pembayaran.index')
                ->with('success', 'Pembayaran ZIS berhasil dicatat. Terima kasih.');
        }
    }

    /**
     * Display the specified ZIS masuk.
     */
    public function show(ZisMasuk $zisMasuk): View
    {
        $user = Auth::user();
        $userRole = $user->role;
        
        if ($userRole !== 'admin') {
            // User biasa hanya bisa lihat pembayaran mereka sendiri
            $user->load('muzakkiProfile');
            $muzakkiProfile = $user->muzakkiProfile;
            
            // Jika user belum punya profil Muzakki, tolak akses
            if (!$muzakkiProfile) {
                abort(403, 'Anda belum memiliki profil sebagai Muzakki. Daftarkan diri Anda terlebih dahulu.');
            }
            
            $muzakkiId = $muzakkiProfile->id_muzakki;
            
            // Jika ZisMasuk bukan milik Muzakki mereka, tolak akses
            if ($zisMasuk->id_muzakki != $muzakkiId) {
                abort(403, 'Anda tidak memiliki akses ke pembayaran ini.');
            }
            
            return view('user.pembayaran.show', compact('zisMasuk')); 
        }

        // Admin bisa lihat semua dengan relasi lengkap
        $zisMasuk->load('muzakki', 'penyaluran.mustahik');
        return view('zis.masuk.show', compact('zisMasuk')); 
    }

    /**
     * Show the form for editing the specified ZIS masuk.
     * HANYA UNTUK ADMIN.
     */
    public function edit(ZisMasuk $zisMasuk): View
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $muzakki = Muzakki::all();
        $jenisZisOptions = ['Zakat', 'Infak', 'Sedekah']; 
        $zakatTypes = ['Zakat Fitrah', 'Zakat Maal'];
        
        // Data Sub-Jenis Zakat Maal (Untuk Edit Admin)
        $subJenisZakatMaal = [
            'Zakat Emas', 'Zakat Penghasilan', 'Zakat Tabungan', 'Zakat Perak', 'Zakat Perhiasan Perak',
            'Zakat Perindustrian', 'Zakat Hasil Perniagaan', 'Zakat Pertambangan Emas', 'Zakat Pertambangan Perak',
            'Zakat Perusahaan', 'Lainnya',
        ];
        
        return view('zis.masuk.edit', compact('zisMasuk', 'muzakki', 'jenisZisOptions', 'zakatTypes', 'subJenisZakatMaal'));
    }

    /**
     * Update the specified ZIS masuk in storage.
     * HANYA UNTUK ADMIN.
     */
    public function update(Request $request, ZisMasuk $zisMasuk): RedirectResponse
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        
        $validated = $request->validate([
            'id_muzakki' => 'required|exists:muzakki,id_muzakki',
            'tgl_masuk' => 'required|date',
            'jenis_zis' => 'required|in:Zakat,Infak,Sedekah', 
            'sub_jenis_zis' => 'nullable|string|max:50', 
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $zisMasuk->update($validated);

        return redirect()->route('admin.zis.masuk.show', $zisMasuk)
            ->with('success', 'Data ZIS berhasil diperbarui');
    }

    /**
     * Remove the specified ZIS masuk from storage.
     * HANYA UNTUK ADMIN.
     */
    public function destroy(ZisMasuk $zisMasuk): RedirectResponse
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        
        $zisMasuk->delete();

        return redirect()->route('admin.zis.masuk.index')
            ->with('success', 'Data ZIS berhasil dihapus');
    }
}