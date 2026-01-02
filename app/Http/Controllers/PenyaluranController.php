<?php

namespace App\Http\Controllers;

use App\Models\Penyaluran;
use App\Models\ZisMasuk;
use App\Models\Mustahik;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PenyaluranController extends Controller
{
    /**
     * Display a listing of penyaluran.
     */
    /**
     * Display a listing of penyaluran.
     */
    public function index(Request $request): View
    {
        $query = Penyaluran::with(['zisMasuk.muzakki', 'mustahik']);

        // Get filter parameter
        $month = $request->input('month');
        $search = $request->input('search');

        // Apply filters
        if ($month) {
            $query->whereMonth('tgl_salur', $month);
        }
        if ($search) {
            $query->whereHas('mustahik', function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            })->orWhereHas('zisMasuk.muzakki', function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            });
        }

        // --- PERBAIKAN DI SINI ---
        // Mengurutkan berdasarkan waktu input data (created_at)
        // Data yang baru saja diinput akan langsung muncul di paling atas
        $query->orderBy('created_at', 'desc');

        $penyaluran = $query->paginate(10)->appends($request->query());

        // Get summary based on filters
        $summaryQuery = Penyaluran::query();
        if ($month) $summaryQuery->whereMonth('tgl_salur', $month);
        if ($search) {
            $summaryQuery->where(function($q) use ($search) {
                $q->whereHas('mustahik', function($sq) use ($search) {
                    $sq->where('nama', 'like', '%' . $search . '%');
                })->orWhereHas('zisMasuk.muzakki', function($sq) use ($search) {
                    $sq->where('nama', 'like', '%' . $search . '%');
                });
            });
        }

        $totalPenyaluran = $summaryQuery->sum('jumlah');
        $countPenyaluran = $summaryQuery->count();

        return view('zis.penyaluran.index', compact('penyaluran', 'totalPenyaluran', 'countPenyaluran', 'month', 'search'));
    }

    /**
     * Show the form for creating a new penyaluran.
     */
    public function create(): View
    {
        $zismasuk = ZisMasuk::with('muzakki')
            ->where('jumlah', '>', function($query) {
                $query->selectRaw('COALESCE(SUM(jumlah), 0)')
                    ->from('penyaluran')
                    ->whereColumn('id_zis', 'zis_masuk.id_zis');
            })
            ->get();

        $mustahik = Mustahik::where('status', 'aktif')->get();

        return view('zis.penyaluran.create', compact('zismasuk', 'mustahik'));
    }

    /**
     * Store a newly created penyaluran in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'id_zis' => 'required|exists:zis_masuk,id_zis',
            'id_mustahik' => 'required|exists:mustahik,id_mustahik',
            'tgl_salur' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        Penyaluran::create($validated);

        return redirect()->route('admin.penyaluran.index')
            ->with('success', 'Data penyaluran berhasil ditambahkan');
    }

    /**
     * Display the specified penyaluran.
     */
    public function show(Penyaluran $penyaluran): View
    {
        $penyaluran->load('zisMasuk.muzakki', 'mustahik'); // DIPERBAIKI: zisMasuk
        return view('zis.penyaluran.show', compact('penyaluran'));
    }
    /**
     * Show the form for editing the specified penyaluran.
     */
    public function edit(Penyaluran $penyaluran): View
    {
        $zismasuk = ZisMasuk::with('muzakki')->get();
        $mustahik = Mustahik::where('status', 'aktif')->get();

        return view('zis.penyaluran.edit', compact('penyaluran', 'zismasuk', 'mustahik'));
    }

    /**
     * Update the specified penyaluran in storage.
     */
    public function update(Request $request, Penyaluran $penyaluran): RedirectResponse
    {
        $validated = $request->validate([
            'id_zis' => 'required|exists:zis_masuk,id_zis',
            'id_mustahik' => 'required|exists:mustahik,id_mustahik',
            'tgl_salur' => 'required|date',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
        ]);

        $penyaluran->update($validated);

        return redirect()->route('admin.penyaluran.show', $penyaluran)
            ->with('success', 'Data penyaluran berhasil diperbarui');
    }

    /**
     * Remove the specified penyaluran from storage.
     */
    public function destroy(Penyaluran $penyaluran): RedirectResponse
    {
        $penyaluran->delete();

        return redirect()->route('admin.penyaluran.index')
            ->with('success', 'Data penyaluran berhasil dihapus');
    }
}
