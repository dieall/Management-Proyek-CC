<?php

namespace App\Http\Controllers;

use App\Models\Kurban;
use App\Models\RiwayatKurban;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        
        $riwayatKurban = DB::table('riwayat_kurban')
            ->join('users', 'riwayat_kurban.id_jamaah', '=', 'users.id')
            ->where('riwayat_kurban.id_kurban', $kurban->id_kurban)
            ->select('users.nama_lengkap', 'riwayat_kurban.*')
            ->orderBy('riwayat_kurban.tanggal_pembayaran', 'desc')
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
            'jenis_pembayaran' => 'required|in:penuh,patungan',
            'jumlah_hewan' => 'required|integer|min:1',
            'jumlah_pembayaran' => 'required|numeric|min:0',
            'tanggal_pembayaran' => 'required|date',
            'status_pembayaran' => 'nullable|in:lunas,cicilan,belum_lunas',
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

    // Riwayat kurban saya
    public function myKurban()
    {
        $user = auth()->user();
        
        $riwayatKurban = DB::table('riwayat_kurban')
            ->join('kurban', 'riwayat_kurban.id_kurban', '=', 'kurban.id_kurban')
            ->where('riwayat_kurban.id_jamaah', $user->id)
            ->select('kurban.nama_kurban', 'kurban.tanggal_kurban', 'kurban.jenis_hewan', 'riwayat_kurban.*')
            ->orderBy('riwayat_kurban.tanggal_pembayaran', 'desc')
            ->get();
        
        $totalPembayaran = $riwayatKurban->sum('jumlah_pembayaran');
        $totalHewan = $riwayatKurban->sum('jumlah_hewan');
        
        return view('kurban.my-kurban', compact('riwayatKurban', 'totalPembayaran', 'totalHewan'));
    }
}

