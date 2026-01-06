<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;
use App\Models\JadwalPerawatan;
use App\Models\LaporanPerawatan;
use App\Models\Kegiatan;
use App\Models\Donasi;
use App\Models\Muzakki;
use App\Models\Mustahik;
use App\Models\ZisMasuk;
use App\Models\Penyaluran;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // ========== STATISTIK INVENTARIS/ASET ==========
        $totalAset = Aset::active()->count();
        $totalJadwal = JadwalPerawatan::where('status', 'terjadwal')->count();
        $totalLaporan = LaporanPerawatan::count();
        
        // Total nilai aset (hanya admin)
        $totalNilaiAset = 0;
        if ($user->isAdmin()) {
            $totalNilaiAset = Aset::active()
                ->get()
                ->sum(function($aset) {
                    return $aset->harga ?? $aset->nilai_donasi ?? 0;
                });
        }

        // Jadwal perawatan terdekat
        $jadwalTerdekat = JadwalPerawatan::with('aset')
            ->where('status', 'terjadwal')
            ->where('tanggal_jadwal', '>=', now())
            ->orderBy('tanggal_jadwal', 'asc')
            ->limit(5)
            ->get();

        // Aset dengan kondisi perlu perhatian
        $asetPerluPerhatian = Aset::active()
            ->whereIn('kondisi', ['rusak_ringan', 'rusak_berat', 'tidak_layak'])
            ->limit(5)
            ->get();

        // ========== STATISTIK EVENTS ==========
        $totalEvents = 0;
        $eventsPublished = 0;
        $eventsDraft = 0;
        $eventsTerdekat = collect();
        
        if (\Schema::hasTable('events')) {
            $totalEvents = DB::table('events')->count();
            $eventsPublished = DB::table('events')->where('status', 'published')->count();
            $eventsDraft = DB::table('events')->where('status', 'draft')->count();
            
            $eventsTerdekat = DB::table('events')
                ->where('status', 'published')
                ->where('start_at', '>=', now())
                ->orderBy('start_at', 'asc')
                ->limit(5)
                ->get();
        }

        // ========== STATISTIK KEGIATAN ==========
        $totalKegiatan = Kegiatan::count();
        $kegiatanAktif = Kegiatan::where('status_kegiatan', 'aktif')->count();
        $kegiatanSelesai = Kegiatan::where('status_kegiatan', 'selesai')->count();
        $kegiatanTerdekat = Kegiatan::where('status_kegiatan', 'aktif')
            ->where('tanggal', '>=', now())
            ->orderBy('tanggal', 'asc')
            ->limit(5)
            ->get();

        // ========== STATISTIK DONASI ==========
        $totalProgramDonasi = Donasi::count();
        $totalDonasiTerkumpul = DB::table('riwayat_donasi')->sum('besar_donasi');
        $totalDonatur = DB::table('riwayat_donasi')->distinct('id_jamaah')->count();
        
        // Program donasi terbaru
        $programDonasiTerbaru = Donasi::orderBy('tanggal_mulai', 'desc')
            ->limit(5)
            ->get()
            ->map(function($donasi) {
                $donasi->total_terkumpul = DB::table('riwayat_donasi')
                    ->where('id_donasi', $donasi->id_donasi)
                    ->sum('besar_donasi');
                return $donasi;
            });

        // ========== STATISTIK ZIS ==========
        $totalMuzakki = Muzakki::disetujui()->count();
        $totalMustahik = Mustahik::aktif()->count();
        $totalZISMasuk = ZisMasuk::sum('jumlah');
        $totalZakat = ZisMasuk::zakat()->sum('jumlah');
        $totalInfaq = ZisMasuk::infaq()->sum('jumlah');
        $totalShadaqah = ZisMasuk::shadaqah()->sum('jumlah');
        $totalWakaf = ZisMasuk::wakaf()->sum('jumlah');
        $totalPenyaluran = Penyaluran::sum('jumlah');
        $saldoZIS = $totalZISMasuk - $totalPenyaluran;

        // Statistik bulanan untuk Muzakki & Mustahik (bulan berjalan)
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        // Total ZIS masuk dari Muzakki bulan ini
        $zisMasukBulanIni = ZisMasuk::whereBetween('tgl_masuk', [$startOfMonth, $endOfMonth])->sum('jumlah');

        // Total penyaluran kepada Mustahik bulan ini
        $penyaluranBulanIni = Penyaluran::whereBetween('tgl_salur', [$startOfMonth, $endOfMonth])->sum('jumlah');

        // Jumlah Muzakki baru yang disetujui bulan ini
        $muzakkiBaruBulanIni = Muzakki::disetujui()
            ->whereBetween('tgl_daftar', [$startOfMonth, $endOfMonth])
            ->count();

        // Jumlah Mustahik yang menerima penyaluran bulan ini
        $mustahikTerbantuBulanIni = Mustahik::whereHas('penyaluran', function ($query) use ($startOfMonth, $endOfMonth) {
                $query->whereBetween('tgl_salur', [$startOfMonth, $endOfMonth]);
            })
            ->distinct('id_mustahik')
            ->count();

        return view('dashboard', compact(
            // Inventaris/Aset
            'totalAset',
            'totalJadwal',
            'totalLaporan',
            'totalNilaiAset',
            'jadwalTerdekat',
            'asetPerluPerhatian',
            // Events
            'totalEvents',
            'eventsPublished',
            'eventsDraft',
            'eventsTerdekat',
            // Kegiatan
            'totalKegiatan',
            'kegiatanAktif',
            'kegiatanSelesai',
            'kegiatanTerdekat',
            // Donasi
            'totalProgramDonasi',
            'totalDonasiTerkumpul',
            'totalDonatur',
            'programDonasiTerbaru',
            // ZIS
            'totalMuzakki',
            'totalMustahik',
            'totalZISMasuk',
            'totalZakat',
            'totalInfaq',
            'totalShadaqah',
            'totalWakaf',
            'totalPenyaluran',
            'saldoZIS',
            // Statistik bulanan Muzakki & Mustahik
            'zisMasukBulanIni',
            'penyaluranBulanIni',
            'muzakkiBaruBulanIni',
            'mustahikTerbantuBulanIni'
        ));
    }
}

