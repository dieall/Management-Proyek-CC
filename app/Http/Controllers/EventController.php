<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Admin & DKM bisa lihat semua event
        if ($user->isAdmin() || $user->isSuperAdmin() || $user->isDkm()) {
            $events = Event::with(['creator', 'peserta'])->latest()->paginate(10);
        }
        // Panitia hanya bisa lihat event yang mereka buat
        elseif ($user->isPanitia()) {
            $events = Event::where('created_by', $user->id)
                          ->with(['creator', 'peserta'])
                          ->latest()
                          ->paginate(10);
        }
        // Jemaah hanya bisa lihat event yang published
        else {
            $events = Event::where('status', 'published')
                          ->with(['creator', 'peserta'])
                          ->latest()
                          ->paginate(10);
        }

        return view('events.index', compact('events'));
    }

    public function create()
    {
        // Hanya admin, dkm, dan panitia yang bisa membuat event
        if (!Auth::user()->isAdmin() && !Auth::user()->isSuperAdmin() && !Auth::user()->isDkm() && !Auth::user()->isPanitia()) {
            abort(403, 'Anda tidak memiliki akses untuk membuat event.');
        }

        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'nullable|string|max:100',
            'lokasi' => 'nullable|string|max:255',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'kuota' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'rule' => 'nullable|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,cancelled',
        ]);

        $data = $request->all();
        $data['created_by'] = Auth::id();

        // Upload poster jika ada
        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        Event::create($data);

        return redirect()->route('events.index')->with('success', 'Event berhasil dibuat!');
    }

    public function show(string $id)
    {
        $event = Event::with(['creator', 'peserta'])->findOrFail($id);
        $user = Auth::user();
        
        // Cek apakah user sudah terdaftar (untuk jemaah)
        $isRegistered = false;
        if ($user->isJemaah()) {
            $isRegistered = $event->peserta()->where('user_id', $user->id)->exists();
        }
        
        return view('events.show', compact('event', 'isRegistered'));
    }

    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        
        $user = Auth::user();
        
        // Hanya pembuat event atau admin/dkm yang bisa edit
        if (!$user->isAdmin() && !$user->isSuperAdmin() && !$user->isDkm() && $event->created_by != $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit event ini.');
        }

        return view('events.edit', compact('event'));
    }

    public function update(Request $request, string $id)
    {
        $event = Event::findOrFail($id);
        
        $user = Auth::user();
        
        // Hanya pembuat event atau admin/dkm yang bisa update
        if (!$user->isAdmin() && !$user->isSuperAdmin() && !$user->isDkm() && $event->created_by != $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate event ini.');
        }

        $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'jenis_kegiatan' => 'nullable|string|max:100',
            'lokasi' => 'nullable|string|max:255',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'kuota' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
            'rule' => 'nullable|string',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,cancelled',
        ]);

        $data = $request->all();

        // Upload poster jika ada
        if ($request->hasFile('poster')) {
            // Hapus poster lama jika ada
            if ($event->poster) {
                Storage::disk('public')->delete($event->poster);
            }
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $event->update($data);

        return redirect()->route('events.index')->with('success', 'Event berhasil diupdate!');
    }

    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        
        $user = Auth::user();
        
        // Hanya admin/dkm yang bisa delete event
        if (!$user->isAdmin() && !$user->isSuperAdmin() && !$user->isDkm()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus event.');
        }

        // Hapus poster jika ada
        if ($event->poster) {
            Storage::disk('public')->delete($event->poster);
        }

        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event berhasil dihapus!');
    }

    // Daftarkan jemaah ke event
    public function daftar(Request $request, string $id)
    {
        $event = Event::findOrFail($id);
        $user = Auth::user();

        // Hanya jemaah yang bisa mendaftar
        if (!$user->isJemaah()) {
            abort(403, 'Hanya jemaah yang dapat mendaftar event.');
        }

        // Cek apakah event sudah published
        if ($event->status !== 'published') {
            return back()->with('error', 'Event belum dipublikasikan.');
        }

        // Cek apakah sudah terdaftar
        if ($event->peserta()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Anda sudah terdaftar di event ini!');
        }

        // Cek kuota jika ada
        if ($event->kuota && $event->peserta()->count() >= $event->kuota) {
            return back()->with('error', 'Kuota event sudah penuh.');
        }

        // Daftarkan peserta
        $event->peserta()->attach($user->id, [
            'tanggal_daftar' => now()->toDateString(),
            'status_kehadiran' => 'terdaftar',
        ]);

        // Update jumlah attendees
        $event->update(['attendees' => $event->peserta()->count()]);

        return back()->with('success', 'Berhasil mendaftar event!');
    }

    // List peserta event (untuk admin)
    public function peserta(string $id)
    {
        $event = Event::with(['peserta' => function($query) {
            $query->orderBy('nama_lengkap');
        }])->findOrFail($id);
        
        $user = Auth::user();
        
        // Hanya admin, superadmin, dkm, atau panitia yang membuat event yang bisa lihat peserta
        if (!$user->isAdmin() && !$user->isSuperAdmin() && !$user->isDkm() && 
            ($event->created_by != $user->id || !$user->isPanitia())) {
            abort(403, 'Anda tidak memiliki akses untuk melihat peserta event.');
        }

        return view('events.peserta', compact('event'));
    }

    // Update absensi peserta (untuk admin)
    public function updateAbsensi(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'status_kehadiran' => 'required|in:terdaftar,hadir,izin,alpa',
        ]);

        $event = Event::findOrFail($id);
        $user = Auth::user();
        
        // Hanya admin, superadmin, dkm, atau panitia yang membuat event yang bisa update absensi
        if (!$user->isAdmin() && !$user->isSuperAdmin() && !$user->isDkm() && 
            ($event->created_by != $user->id || !$user->isPanitia())) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate absensi.');
        }

        // Cek apakah user terdaftar di event
        if (!$event->peserta()->where('user_id', $request->user_id)->exists()) {
            return back()->with('error', 'Peserta tidak terdaftar di event ini.');
        }

        // Update status kehadiran
        $event->peserta()->updateExistingPivot($request->user_id, [
            'status_kehadiran' => $request->status_kehadiran,
        ]);

        return back()->with('success', 'Status kehadiran berhasil diperbarui!');
    }
}

