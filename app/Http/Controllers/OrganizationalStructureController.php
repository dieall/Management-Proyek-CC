<?php

namespace App\Http\Controllers;

use App\Models\OrganizationalStructure;
use App\Models\Position;
use Illuminate\Http\Request;

class OrganizationalStructureController extends Controller
{
    public function index()
    {
        // Get root nodes (depth = 0 or parent_id is null)
        $structures = OrganizationalStructure::with(['position', 'parent', 'children'])
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();
        
        return view('takmir.organizational-structures.index', compact('structures'));
    }

    public function create()
    {
        $positions = Position::active()->orderBy('name')->get();
        $structures = OrganizationalStructure::with('position')->orderBy('depth')->orderBy('order')->get();
        return view('takmir.organizational-structures.create', compact('positions', 'structures'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'position_id' => 'nullable|exists:positions,id',
            'parent_id' => 'nullable|exists:organizational_structures,id',
            'is_division' => 'boolean',
            'division_name' => 'nullable|required_if:is_division,1|string|max:255',
            'division_description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $data = $request->all();
        $data['is_division'] = $request->has('is_division');

        // Calculate lft, rgt, depth based on parent
        if ($request->filled('parent_id')) {
            $parent = OrganizationalStructure::findOrFail($request->parent_id);
            $data['depth'] = $parent->depth + 1;
            // Simple nested set - untuk production perlu algoritma yang lebih kompleks
            $maxRgt = OrganizationalStructure::max('rgt') ?? 0;
            $data['lft'] = $maxRgt + 1;
            $data['rgt'] = $maxRgt + 2;
        } else {
            $data['depth'] = 0;
            $maxRgt = OrganizationalStructure::max('rgt') ?? 0;
            $data['lft'] = $maxRgt + 1;
            $data['rgt'] = $maxRgt + 2;
        }

        OrganizationalStructure::create($data);

        return redirect()->route('organizational-structures.index')->with('success', 'Struktur organisasi berhasil ditambahkan!');
    }

    public function show(OrganizationalStructure $organizationalStructure)
    {
        $organizationalStructure->load(['position', 'parent', 'children.position']);
        return view('takmir.organizational-structures.show', compact('organizationalStructure'));
    }

    public function edit(OrganizationalStructure $organizationalStructure)
    {
        $positions = Position::active()->orderBy('name')->get();
        $structures = OrganizationalStructure::where('id', '!=', $organizationalStructure->id)
            ->with('position')
            ->orderBy('depth')
            ->orderBy('order')
            ->get();
        return view('takmir.organizational-structures.edit', compact('organizationalStructure', 'positions', 'structures'));
    }

    public function update(Request $request, OrganizationalStructure $organizationalStructure)
    {
        $request->validate([
            'position_id' => 'nullable|exists:positions,id',
            'parent_id' => 'nullable|exists:organizational_structures,id',
            'is_division' => 'boolean',
            'division_name' => 'nullable|required_if:is_division,1|string|max:255',
            'division_description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $data = $request->except(['lft', 'rgt', 'depth']);
        $data['is_division'] = $request->has('is_division');

        // Recalculate depth if parent changed
        if ($request->filled('parent_id') && $request->parent_id != $organizationalStructure->parent_id) {
            $parent = OrganizationalStructure::findOrFail($request->parent_id);
            $data['depth'] = $parent->depth + 1;
        }

        $organizationalStructure->update($data);

        return redirect()->route('organizational-structures.index')->with('success', 'Struktur organisasi berhasil diperbarui!');
    }

    public function destroy(OrganizationalStructure $organizationalStructure)
    {
        // Cek apakah punya children
        if ($organizationalStructure->children()->count() > 0) {
            return redirect()->route('organizational-structures.index')
                ->with('error', 'Struktur tidak dapat dihapus karena masih memiliki struktur anak!');
        }

        $organizationalStructure->delete();
        return redirect()->route('organizational-structures.index')->with('success', 'Struktur organisasi berhasil dihapus!');
    }
}







