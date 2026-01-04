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
            $events = Event::with('creator')->latest()->paginate(10);
        }
        // Panitia hanya bisa lihat event yang mereka buat
        elseif ($user->isPanitia()) {
            $events = Event::where('created_by', $user->id)
                          ->with('creator')
                          ->latest()
                          ->paginate(10);
        }
        // Jemaah hanya bisa lihat event yang published
        else {
            $events = Event::where('status', 'published')
                          ->with('creator')
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
        $event = Event::with('creator')->findOrFail($id);
        return view('events.show', compact('event'));
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
}

