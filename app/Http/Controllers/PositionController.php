<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PositionController extends Controller
{
    public function index()
    {
        $positions = Position::with('parent')
            ->orderBy('order')
            ->orderBy('name')
            ->get();
        
        return view('takmir.positions.index', compact('positions'));
    }

    public function create()
    {
        $positions = Position::active()->orderBy('name')->get();
        return view('takmir.positions.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:positions,id',
            'order' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
            'level' => 'required|in:leadership,member,staff',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        
        // Generate unique slug if exists
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Position::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        Position::create($data);

        return redirect()->route('positions.index')->with('success', 'Posisi berhasil ditambahkan!');
    }

    public function show(Position $position)
    {
        $position->load(['parent', 'children', 'committees', 'jobResponsibilities']);
        return view('takmir.positions.show', compact('position'));
    }

    public function edit(Position $position)
    {
        $positions = Position::where('id', '!=', $position->id)
            ->active()
            ->orderBy('name')
            ->get();
        return view('takmir.positions.edit', compact('position', 'positions'));
    }

    public function update(Request $request, Position $position)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:positions,id',
            'order' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
            'level' => 'required|in:leadership,member,staff',
        ]);

        $data = $request->except('slug');
        
        // Update slug if name changed
        if ($request->name !== $position->name) {
            $data['slug'] = Str::slug($request->name);
            
            // Generate unique slug if exists
            $originalSlug = $data['slug'];
            $counter = 1;
            while (Position::where('slug', $data['slug'])->where('id', '!=', $position->id)->exists()) {
                $data['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $position->update($data);

        return redirect()->route('positions.index')->with('success', 'Posisi berhasil diperbarui!');
    }

    public function destroy(Position $position)
    {
        // Cek apakah posisi digunakan
        if ($position->committees()->count() > 0) {
            return redirect()->route('positions.index')
                ->with('error', 'Posisi tidak dapat dihapus karena masih digunakan oleh pengurus!');
        }

        $position->delete();
        return redirect()->route('positions.index')->with('success', 'Posisi berhasil dihapus!');
    }
}











