<?php

namespace App\Http\Controllers;

use App\Models\ZisMasuk;
use App\Models\Muzakki;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ZisMasukController extends Controller
{
    public function index()
    {
        $zisMasuk = ZisMasuk::with('muzakki')->orderBy('tgl_masuk', 'desc')->get();
        
        // Statistik
        $totalZIS = ZisMasuk::sum('jumlah');
        $totalZakat = ZisMasuk::where('jenis_zis', 'zakat')->sum('jumlah');
        $totalInfaq = ZisMasuk::where('jenis_zis', 'infaq')->sum('jumlah');
        $totalShadaqah = ZisMasuk::where('jenis_zis', 'shadaqah')->sum('jumlah');
        $totalWakaf = ZisMasuk::where('jenis_zis', 'wakaf')->sum('jumlah');
        
        return view('zis.zis-masuk.index', compact('zisMasuk', 'totalZIS', 'totalZakat', 'totalInfaq', 'totalShadaqah', 'totalWakaf'));
    }

    public function create()
    {
        $muzakkis = Muzakki::where('status_pendaftaran', 'disetujui')->get();
        return view('zis.zis-masuk.create', compact('muzakkis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_muzakki' => 'required|exists:muzakki,id_muzakki',
            'tgl_masuk' => 'required|date',
            'jenis_zis' => 'required|in:zakat,infaq,shadaqah,wakaf',
            'sub_jenis_zis' => 'nullable|string|max:50',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        ZisMasuk::create($request->all());

        return redirect()->route('zis-masuk.index')->with('success', 'ZIS Masuk berhasil ditambahkan!');
    }

    public function show(ZisMasuk $zisMasuk)
    {
        $zisMasuk->load(['muzakki', 'penyaluran.mustahik']);
        
        // Statistik
        $totalDisalurkan = $zisMasuk->penyaluran()->sum('jumlah');
        $jumlahPenyaluran = $zisMasuk->penyaluran()->count();
        
        return view('zis.zis-masuk.show', compact('zisMasuk', 'totalDisalurkan', 'jumlahPenyaluran'));
    }

    public function edit(ZisMasuk $zisMasuk)
    {
        $muzakkis = Muzakki::where('status_pendaftaran', 'disetujui')->get();
        return view('zis.zis-masuk.edit', compact('zisMasuk', 'muzakkis'));
    }

    public function update(Request $request, ZisMasuk $zisMasuk)
    {
        $request->validate([
            'id_muzakki' => 'required|exists:muzakki,id_muzakki',
            'tgl_masuk' => 'required|date',
            'jenis_zis' => 'required|in:zakat,infaq,shadaqah,wakaf',
            'sub_jenis_zis' => 'nullable|string|max:50',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $zisMasuk->update($request->all());

        return redirect()->route('zis-masuk.index')->with('success', 'ZIS Masuk berhasil diperbarui!');
    }

    public function destroy(ZisMasuk $zisMasuk)
    {
        $zisMasuk->delete();
        return redirect()->route('zis-masuk.index')->with('success', 'ZIS Masuk berhasil dihapus!');
    }

    // Laporan ZIS
    public function laporan(Request $request)
    {
        $query = ZisMasuk::with('muzakki');
        
        // Filter berdasarkan jenis
        if ($request->filled('jenis_zis')) {
            $query->where('jenis_zis', $request->jenis_zis);
        }
        
        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_dari')) {
            $query->where('tgl_masuk', '>=', $request->tanggal_dari);
        }
        
        if ($request->filled('tanggal_sampai')) {
            $query->where('tgl_masuk', '<=', $request->tanggal_sampai);
        }
        
        $zisMasuk = $query->orderBy('tgl_masuk', 'desc')->get();
        $totalJumlah = $query->sum('jumlah');
        
        return view('zis.zis-masuk.laporan', compact('zisMasuk', 'totalJumlah'));
    }
}

