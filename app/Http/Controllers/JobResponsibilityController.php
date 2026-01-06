<?php

namespace App\Http\Controllers;

use App\Models\JobResponsibility;
use App\Models\Position;
use Illuminate\Http\Request;

class JobResponsibilityController extends Controller
{
    public function index(Request $request)
    {
        $query = JobResponsibility::with('position');
        
        // Filter by position
        if ($request->has('position_id') && $request->position_id !== '') {
            $query->where('position_id', $request->position_id);
        }
        
        // Filter by priority
        if ($request->has('priority') && $request->priority !== '') {
            $query->where('priority', $request->priority);
        }
        
        // Search
        if ($request->has('search') && $request->search !== '') {
            $query->where('task_name', 'like', '%' . $request->search . '%')
                  ->orWhere('task_description', 'like', '%' . $request->search . '%');
        }
        
        $jobResponsibilities = $query->orderBy('position_id')->orderBy('priority')->paginate(15);
        $positions = Position::active()->orderBy('name')->get();
        
        return view('takmir.job-responsibilities.index', compact('jobResponsibilities', 'positions'));
    }

    public function create()
    {
        $positions = Position::active()->orderBy('name')->get();
        return view('takmir.job-responsibilities.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'position_id' => 'required|exists:positions,id',
            'task_name' => 'required|string|max:255',
            'task_description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high,critical',
            'estimated_hours' => 'nullable|integer|min:0',
            'frequency' => 'required|in:daily,weekly,monthly,quarterly,yearly,on_demand',
            'is_core_responsibility' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_core_responsibility'] = $request->has('is_core_responsibility');

        JobResponsibility::create($data);

        return redirect()->route('job-responsibilities.index')->with('success', 'Tugas dan tanggung jawab berhasil ditambahkan!');
    }

    public function show(JobResponsibility $jobResponsibility)
    {
        $jobResponsibility->load(['position', 'taskAssignments.committee']);
        return view('takmir.job-responsibilities.show', compact('jobResponsibility'));
    }

    public function edit(JobResponsibility $jobResponsibility)
    {
        $positions = Position::active()->orderBy('name')->get();
        return view('takmir.job-responsibilities.edit', compact('jobResponsibility', 'positions'));
    }

    public function update(Request $request, JobResponsibility $jobResponsibility)
    {
        $request->validate([
            'position_id' => 'required|exists:positions,id',
            'task_name' => 'required|string|max:255',
            'task_description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high,critical',
            'estimated_hours' => 'nullable|integer|min:0',
            'frequency' => 'required|in:daily,weekly,monthly,quarterly,yearly,on_demand',
            'is_core_responsibility' => 'boolean',
        ]);

        $data = $request->all();
        $data['is_core_responsibility'] = $request->has('is_core_responsibility');

        $jobResponsibility->update($data);

        return redirect()->route('job-responsibilities.index')->with('success', 'Tugas dan tanggung jawab berhasil diperbarui!');
    }

    public function destroy(JobResponsibility $jobResponsibility)
    {
        // Cek apakah digunakan di task assignments
        if ($jobResponsibility->taskAssignments()->count() > 0) {
            return redirect()->route('job-responsibilities.index')
                ->with('error', 'Tugas tidak dapat dihapus karena masih digunakan dalam penugasan!');
        }

        $jobResponsibility->delete();
        return redirect()->route('job-responsibilities.index')->with('success', 'Tugas dan tanggung jawab berhasil dihapus!');
    }
}








