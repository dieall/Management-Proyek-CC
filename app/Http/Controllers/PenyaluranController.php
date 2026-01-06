<?php

namespace App\Http\Controllers;

use App\Models\Penyaluran;
use App\Models\ZisMasuk;
use App\Models\Mustahik;
use Illuminate\Http\Request;

class PenyaluranController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Jika user adalah mustahik, redirect ke halaman riwayat mereka sendiri
        if ($user->isMustahik() && $user->mustahik) {
            return redirect()->route('penyaluran.my-penyaluran');
        }
        
        $penyaluran = Penyaluran::with(['zisMasuk.muzakki', 'mustahik'])
                                 ->orderBy('tgl_salur', 'desc')
                                 ->get();
        
        // Statistik
        $totalDisalurkan = Penyaluran::sum('jumlah');
        $jumlahPenyaluran = Penyaluran::count();
        $jumlahMustahik = Mustahik::has('penyaluran')->count();
        
        return view('zis.penyaluran.index', compact('penyaluran', 'totalDisalurkan', 'jumlahPenyaluran', 'jumlahMustahik'));
    }

    // Riwayat penyaluran untuk Mustahik sendiri
    public function myPenyaluran()
    {
        $user = auth()->user();
        
        if (!$user->isMustahik() || !$user->mustahik) {
            abort(403, 'Hanya mustahik yang dapat mengakses halaman ini.');
        }
        
        $mustahik = $user->mustahik;
        $penyaluran = Penyaluran::where('id_mustahik', $mustahik->id_mustahik)
                                ->with(['zisMasuk.muzakki'])
                                ->orderBy('tgl_salur', 'desc')
                                ->get();
        
        // Statistik untuk mustahik ini
        $totalDiterima = $penyaluran->sum('jumlah');
        $jumlahPenyaluran = $penyaluran->count();
        
        return view('zis.penyaluran.my-penyaluran', compact('penyaluran', 'mustahik', 'totalDiterima', 'jumlahPenyaluran'));
    }

    public function create()
    {
        // ZIS yang masih punya sisa
        $zisMasuk = ZisMasuk::with('muzakki', 'penyaluran')->get();
        
        $mustahiks = Mustahik::where('status', 'aktif')
                            ->where('status_verifikasi', 'disetujui')
                            ->get();
        
        return view('zis.penyaluran.create', compact('zisMasuk', 'mustahiks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_zis' => 'required|exists:zis_masuk,id_zis',
            'id_mustahik' => 'required|exists:mustahik,id_mustahik',
            'tgl_salur' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // Validasi: jumlah tidak boleh melebihi sisa
        $zisMasuk = ZisMasuk::findOrFail($request->id_zis);
        $totalDisalurkan = $zisMasuk->penyaluran()->sum('jumlah');
        $sisa = $zisMasuk->jumlah - $totalDisalurkan;
        
        if ($request->jumlah > $sisa) {
            return back()->withErrors(['jumlah' => "Jumlah melebihi sisa yang tersedia (Rp " . number_format($sisa, 0, ',', '.') . ")"])->withInput();
        }

        Penyaluran::create($request->all());

        return redirect()->route('penyaluran.index')->with('success', 'Penyaluran berhasil ditambahkan!');
    }

    public function show(Penyaluran $penyaluran)
    {
        $penyaluran->load(['zisMasuk.muzakki', 'mustahik']);
        return view('zis.penyaluran.show', compact('penyaluran'));
    }

    public function edit(Penyaluran $penyaluran)
    {
        $zisMasuk = ZisMasuk::with('muzakki', 'penyaluran')->get();
        $mustahiks = Mustahik::where('status', 'aktif')
                            ->where('status_verifikasi', 'disetujui')
                            ->get();
        
        return view('zis.penyaluran.edit', compact('penyaluran', 'zisMasuk', 'mustahiks'));
    }

    public function update(Request $request, Penyaluran $penyaluran)
    {
        $request->validate([
            'id_zis' => 'required|exists:zis_masuk,id_zis',
            'id_mustahik' => 'required|exists:mustahik,id_mustahik',
            'tgl_salur' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        // Validasi sisa
        $zisMasuk = ZisMasuk::findOrFail($request->id_zis);
        $totalDisalurkan = $zisMasuk->penyaluran()->where('id_penyaluran', '!=', $penyaluran->id_penyaluran)->sum('jumlah');
        $sisa = $zisMasuk->jumlah - $totalDisalurkan;
        
        if ($request->jumlah > $sisa) {
            return back()->withErrors(['jumlah' => "Jumlah melebihi sisa yang tersedia"])->withInput();
        }

        $penyaluran->update($request->all());

        return redirect()->route('penyaluran.index')->with('success', 'Penyaluran berhasil diperbarui!');
    }

    public function destroy(Penyaluran $penyaluran)
    {
        $penyaluran->delete();
        return redirect()->route('penyaluran.index')->with('success', 'Penyaluran berhasil dihapus!');
    }

    // Laporan penyaluran
    public function laporan(Request $request)
    {
        $query = Penyaluran::with(['zisMasuk.muzakki', 'mustahik']);
        
        // Filter berdasarkan mustahik
        if ($request->filled('id_mustahik')) {
            $query->where('id_mustahik', $request->id_mustahik);
        }
        
        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_dari')) {
            $query->where('tgl_salur', '>=', $request->tanggal_dari);
        }
        
        if ($request->filled('tanggal_sampai')) {
            $query->where('tgl_salur', '<=', $request->tanggal_sampai);
        }
        
        $penyalurans = $query->orderBy('tgl_salur', 'desc')->get();
        $totalJumlah = $query->sum('jumlah');
        $mustahiks = Mustahik::aktif()->get();
        
        return view('zis.penyaluran.laporan', compact('penyalurans', 'totalJumlah', 'mustahiks'));
    }
}

