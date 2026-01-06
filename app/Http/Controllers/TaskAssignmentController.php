<?php

namespace App\Http\Controllers;

use App\Models\TaskAssignment;
use App\Models\Committee;
use App\Models\JobResponsibility;
use Illuminate\Http\Request;

class TaskAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $query = TaskAssignment::with('committee.position', 'jobResponsibility.position');
        
        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        // Filter by committee
        if ($request->has('committee_id') && $request->committee_id !== '') {
            $query->where('committee_id', $request->committee_id);
        }
        
        // Filter by due date
        if ($request->has('due_date_from') && $request->due_date_from !== '') {
            $query->where('due_date', '>=', $request->due_date_from);
        }
        if ($request->has('due_date_to') && $request->due_date_to !== '') {
            $query->where('due_date', '<=', $request->due_date_to);
        }
        
        $taskAssignments = $query->orderBy('due_date', 'asc')->orderBy('status')->paginate(15);
        $committees = Committee::active()->with('position')->orderBy('full_name')->get();
        
        return view('takmir.task-assignments.index', compact('taskAssignments', 'committees'));
    }

    public function create()
    {
        $committees = Committee::active()->with('position')->orderBy('full_name')->get();
        $jobResponsibilities = JobResponsibility::with('position')->orderBy('task_name')->get();
        return view('takmir.task-assignments.create', compact('committees', 'jobResponsibilities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'committee_id' => 'required|exists:committees,id',
            'job_responsibility_id' => 'required|exists:job_responsibilities,id',
            'assigned_date' => 'nullable|date',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed,cancelled,overdue',
            'progress_percentage' => 'required|integer|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        $data = $request->all();
        if (!$request->filled('assigned_date')) {
            $data['assigned_date'] = now()->toDateString();
        }

        TaskAssignment::create($data);

        return redirect()->route('task-assignments.index')->with('success', 'Penugasan tugas berhasil ditambahkan!');
    }

    public function show(TaskAssignment $taskAssignment)
    {
        $taskAssignment->load(['committee.position', 'jobResponsibility.position', 'approver']);
        return view('takmir.task-assignments.show', compact('taskAssignment'));
    }

    public function edit(TaskAssignment $taskAssignment)
    {
        $committees = Committee::active()->with('position')->orderBy('full_name')->get();
        $jobResponsibilities = JobResponsibility::with('position')->orderBy('task_name')->get();
        $approvers = Committee::active()->with('position')->orderBy('full_name')->get();
        return view('takmir.task-assignments.edit', compact('taskAssignment', 'committees', 'jobResponsibilities', 'approvers'));
    }

    public function update(Request $request, TaskAssignment $taskAssignment)
    {
        $request->validate([
            'committee_id' => 'required|exists:committees,id',
            'job_responsibility_id' => 'required|exists:job_responsibilities,id',
            'assigned_date' => 'nullable|date',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,in_progress,completed,cancelled,overdue',
            'progress_percentage' => 'required|integer|min:0|max:100',
            'notes' => 'nullable|string',
            'completed_date' => 'nullable|date',
            'approved_by' => 'nullable|exists:committees,id',
        ]);

        $data = $request->all();
        
        // Set completed_date jika status completed
        if ($request->status === 'completed' && !$request->filled('completed_date')) {
            $data['completed_date'] = now()->toDateString();
        }
        
        // Set approved_at jika approved_by diisi
        if ($request->filled('approved_by')) {
            $data['approved_at'] = now();
        }

        $taskAssignment->update($data);

        return redirect()->route('task-assignments.index')->with('success', 'Penugasan tugas berhasil diperbarui!');
    }

    public function destroy(TaskAssignment $taskAssignment)
    {
        $taskAssignment->delete();
        return redirect()->route('task-assignments.index')->with('success', 'Penugasan tugas berhasil dihapus!');
    }
}








