<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommitteeController extends Controller
{
    public function index(Request $request)
    {
        $query = Committee::with('position', 'user');
        
        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('active_status', $request->status);
        }
        
        // Filter by position
        if ($request->has('position_id') && $request->position_id !== '') {
            $query->where('position_id', $request->position_id);
        }
        
        // Search
        if ($request->has('search') && $request->search !== '') {
            $query->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone_number', 'like', '%' . $request->search . '%');
        }
        
        $committees = $query->orderBy('full_name')->paginate(15);
        $positions = Position::active()->orderBy('name')->get();
        
        return view('takmir.committees.index', compact('committees', 'positions'));
    }

    public function create()
    {
        $positions = Position::active()->orderBy('name')->get();
        $users = User::whereDoesntHave('committee')->orderBy('name')->get();
        return view('takmir.committees.create', compact('positions', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:committees,email',
            'phone_number' => 'nullable|string|max:20',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'join_date' => 'nullable|date',
            'active_status' => 'required|in:active,inactive,resigned',
            'position_id' => 'nullable|exists:positions,id',
            'user_id' => 'nullable|exists:users,id|unique:committees,user_id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = $request->except(['photo', 'cv']);

        // Upload photo
        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('committees/photos', 'public');
        }

        // Upload CV
        if ($request->hasFile('cv')) {
            $data['cv_path'] = $request->file('cv')->store('committees/cvs', 'public');
        }

        Committee::create($data);

        return redirect()->route('committees.index')->with('success', 'Data pengurus berhasil ditambahkan!');
    }

    public function show(Committee $committee)
    {
        $committee->load([
            'position',
            'user',
            'positionHistories.position',
            'dutySchedules' => function($q) {
                $q->orderBy('duty_date', 'desc')->limit(10);
            },
            'taskAssignments.jobResponsibility' => function($q) {
                $q->orderBy('due_date', 'desc')->limit(10);
            }
        ]);
        
        return view('takmir.committees.show', compact('committee'));
    }

    public function edit(Committee $committee)
    {
        $positions = Position::active()->orderBy('name')->get();
        $users = User::whereDoesntHave('committee')
            ->orWhere('id', $committee->user_id)
            ->orderBy('name')
            ->get();
        return view('takmir.committees.edit', compact('committee', 'positions', 'users'));
    }

    public function update(Request $request, Committee $committee)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:committees,email,' . $committee->id,
            'phone_number' => 'nullable|string|max:20',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'join_date' => 'nullable|date',
            'active_status' => 'required|in:active,inactive,resigned',
            'position_id' => 'nullable|exists:positions,id',
            'user_id' => 'nullable|exists:users,id|unique:committees,user_id,' . $committee->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = $request->except(['photo', 'cv']);

        // Upload photo
        if ($request->hasFile('photo')) {
            // Hapus photo lama
            if ($committee->photo_path) {
                Storage::disk('public')->delete($committee->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('committees/photos', 'public');
        }

        // Upload CV
        if ($request->hasFile('cv')) {
            // Hapus CV lama
            if ($committee->cv_path) {
                Storage::disk('public')->delete($committee->cv_path);
            }
            $data['cv_path'] = $request->file('cv')->store('committees/cvs', 'public');
        }

        $committee->update($data);

        return redirect()->route('committees.index')->with('success', 'Data pengurus berhasil diperbarui!');
    }

    public function destroy(Committee $committee)
    {
        // Hapus file photo dan CV
        if ($committee->photo_path) {
            Storage::disk('public')->delete($committee->photo_path);
        }
        if ($committee->cv_path) {
            Storage::disk('public')->delete($committee->cv_path);
        }

        $committee->delete();
        return redirect()->route('committees.index')->with('success', 'Data pengurus berhasil dihapus!');
    }
}

