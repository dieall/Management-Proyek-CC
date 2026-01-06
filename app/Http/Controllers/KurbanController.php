<?php

namespace App\Http\Controllers;

use App\Models\Kurban;
use App\Models\RiwayatKurban;
use App\Models\DokumentasiKurban;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KurbanController extends Controller
{
    public function index()
    {
        $kurbans = Kurban::orderBy('tanggal_kurban', 'desc')->get();
        
        // Tambahkan statistik ke setiap program kurban
        $kurbans->each(function ($kurban) {
            $kurban->total_hewan_terdaftar = $kurban->totalHewanTerdaftar();
            $kurban->total_pembayaran = $kurban->totalPembayaran();
            $kurban->sisa_hewan = $kurban->sisaHewan();
            $kurban->jumlah_peserta = $kurban->jumlahPeserta();
        });
        
        return view('kurban.index', compact('kurbans'));
    }

    public function create()
    {
        return view('kurban.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kurban' => 'required|string|max:255',
            'tanggal_kurban' => 'required|date',
            'jenis_hewan' => 'required|in:sapi,kambing,domba',
            'target_hewan' => 'required|integer|min:1',
            'harga_per_hewan' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|in:aktif,selesai,dibatalkan',
        ]);

        Kurban::create($request->all());

        return redirect()->route('kurban.index')->with('success', 'Program kurban berhasil ditambahkan!');
    }

    public function show(Kurban $kurban)
    {
        $kurban->load('peserta');
        
        // Statistik
        $totalHewanTerdaftar = $kurban->totalHewanTerdaftar();
        $totalPembayaran = $kurban->totalPembayaran();
        $jumlahPeserta = $kurban->jumlahPeserta();
        $sisaHewan = $kurban->sisaHewan();
        
        $riwayatKurban = RiwayatKurban::with(['jamaah', 'dokumentasi'])
            ->where('id_kurban', $kurban->id_kurban)
            ->orderBy('tanggal_pembayaran', 'desc')
            ->get();
        
        return view('kurban.show', compact('kurban', 'totalHewanTerdaftar', 'totalPembayaran', 'jumlahPeserta', 'sisaHewan', 'riwayatKurban'));
    }

    public function edit(Kurban $kurban)
    {
        return view('kurban.edit', compact('kurban'));
    }

    public function update(Request $request, Kurban $kurban)
    {
        $request->validate([
            'nama_kurban' => 'required|string|max:255',
            'tanggal_kurban' => 'required|date',
            'jenis_hewan' => 'required|in:sapi,kambing,domba',
            'target_hewan' => 'required|integer|min:1',
            'harga_per_hewan' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'nullable|in:aktif,selesai,dibatalkan',
        ]);

        $kurban->update($request->all());

        return redirect()->route('kurban.index')->with('success', 'Program kurban berhasil diperbarui!');
    }

    public function destroy(Kurban $kurban)
    {
        $kurban->delete();
        return redirect()->route('kurban.index')->with('success', 'Program kurban berhasil dihapus!');
    }

    // Submit pendaftaran kurban
    public function submitPendaftaran(Request $request, $id)
    {
        $request->validate([
            'jenis_pembayaran' => 'required|in:transfer,tunai',
            'jumlah_hewan' => 'required|integer|min:1',
            'jumlah_pembayaran' => 'required|numeric|min:0',
            'tanggal_pembayaran' => 'required|date',
            'status_pembayaran' => 'nullable|in:lunas,verifikasi,belum_lunas',
            'keterangan' => 'nullable|string',
        ]);

        $kurban = Kurban::findOrFail($id);
        $user = auth()->user();

        // Cek apakah masih ada sisa hewan
        $sisaHewan = $kurban->sisaHewan();
        if ($sisaHewan < $request->jumlah_hewan) {
            return back()->with('error', 'Jumlah hewan yang didaftarkan melebihi sisa hewan yang tersedia!');
        }

        RiwayatKurban::create([
            'id_kurban' => $kurban->id_kurban,
            'id_jamaah' => $user->id,
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'jumlah_hewan' => $request->jumlah_hewan,
            'jumlah_pembayaran' => $request->jumlah_pembayaran,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
            'status_pembayaran' => $request->status_pembayaran ?? 'belum_lunas',
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Pendaftaran kurban berhasil dicatat!');
    }

    // Update status pembayaran (untuk admin)
    public function updateStatus(Request $request, $id)
    {
        // Hanya admin / superadmin / DKM yang boleh update status
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isSuperAdmin() && !$user->isDkm()) {
            abort(403, 'Hanya admin yang dapat mengupdate status pembayaran.');
        }

        $request->validate([
            'status_pembayaran' => 'required|in:lunas,verifikasi,belum_lunas',
        ]);

        $riwayatKurban = RiwayatKurban::findOrFail($id);
        $riwayatKurban->update([
            'status_pembayaran' => $request->status_pembayaran,
        ]);

        return back()->with('success', 'Status pembayaran berhasil diperbarui!');
    }

    // Upload dokumentasi kurban (untuk admin)
    public function uploadDokumentasi(Request $request)
    {
        // Hanya admin / superadmin / DKM yang boleh upload dokumentasi
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isSuperAdmin() && !$user->isDkm()) {
            abort(403, 'Hanya admin yang dapat mengupload dokumentasi.');
        }

        $request->validate([
            'id_riwayat_kurban' => 'required|exists:riwayat_kurban,id_riwayat_kurban',
            'jenis_dokumentasi' => 'required|in:penyembelihan,pembagian_daging',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // max 5MB
            'keterangan' => 'nullable|string|max:500',
        ]);

        $riwayatKurban = RiwayatKurban::findOrFail($request->id_riwayat_kurban);

        // Upload foto
        $fotoPath = $request->file('foto')->store('kurban-dokumentasi', 'public');

        DokumentasiKurban::create([
            'id_riwayat_kurban' => $request->id_riwayat_kurban,
            'jenis_dokumentasi' => $request->jenis_dokumentasi,
            'foto' => $fotoPath,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Dokumentasi berhasil diupload!');
    }

    // Hapus dokumentasi (untuk admin)
    public function deleteDokumentasi($id)
    {
        // Hanya admin / superadmin / DKM yang boleh hapus dokumentasi
        $user = auth()->user();
        if (!$user->isAdmin() && !$user->isSuperAdmin() && !$user->isDkm()) {
            abort(403, 'Hanya admin yang dapat menghapus dokumentasi.');
        }

        $dokumentasi = DokumentasiKurban::findOrFail($id);

        // Hapus foto dari storage
        if ($dokumentasi->foto) {
            Storage::disk('public')->delete($dokumentasi->foto);
        }

        $dokumentasi->delete();

        return back()->with('success', 'Dokumentasi berhasil dihapus!');
    }

    // Riwayat kurban saya
    public function myKurban()
    {
        $user = auth()->user();
        
        $riwayatKurban = RiwayatKurban::with(['kurban', 'dokumentasi'])
            ->where('id_jamaah', $user->id)
            ->orderBy('tanggal_pembayaran', 'desc')
            ->get();
        
        $totalPembayaran = $riwayatKurban->sum('jumlah_pembayaran');
        $totalHewan = $riwayatKurban->sum('jumlah_hewan');
        
        return view('kurban.my-kurban', compact('riwayatKurban', 'totalPembayaran', 'totalHewan'));
    }
}

