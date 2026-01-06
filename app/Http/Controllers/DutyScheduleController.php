<?php

namespace App\Http\Controllers;

use App\Models\DutySchedule;
use App\Models\Committee;
use Illuminate\Http\Request;

class DutyScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = DutySchedule::with('committee.position');
        
        // Filter by date
        if ($request->has('start_date') && $request->start_date !== '') {
            $query->where('duty_date', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date !== '') {
            $query->where('duty_date', '<=', $request->end_date);
        }
        
        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        // Filter by duty type
        if ($request->has('duty_type') && $request->duty_type !== '') {
            $query->where('duty_type', $request->duty_type);
        }
        
        // Filter by committee
        if ($request->has('committee_id') && $request->committee_id !== '') {
            $query->where('committee_id', $request->committee_id);
        }
        
        $dutySchedules = $query->orderBy('duty_date', 'desc')->orderBy('start_time')->paginate(15);
        $committees = Committee::active()->with('position')->orderBy('full_name')->get();
        
        return view('takmir.duty-schedules.index', compact('dutySchedules', 'committees'));
    }

    public function create()
    {
        $committees = Committee::active()->with('position')->orderBy('full_name')->get();
        return view('takmir.duty-schedules.create', compact('committees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'committee_id' => 'required|exists:committees,id',
            'duty_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
            'duty_type' => 'required|in:piket,kebersihan,keamanan,acara,lainnya',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
            'remarks' => 'nullable|string',
            'is_recurring' => 'boolean',
            'recurring_type' => 'nullable|required_if:is_recurring,1|in:daily,weekly,monthly,yearly',
            'recurring_end_date' => 'nullable|required_if:is_recurring,1|date|after:duty_date',
        ]);

        $data = $request->all();
        $data['is_recurring'] = $request->has('is_recurring');

        DutySchedule::create($data);

        return redirect()->route('duty-schedules.index')->with('success', 'Jadwal piket berhasil ditambahkan!');
    }

    public function show(DutySchedule $dutySchedule)
    {
        $dutySchedule->load('committee.position');
        return view('takmir.duty-schedules.show', compact('dutySchedule'));
    }

    public function edit(DutySchedule $dutySchedule)
    {
        $committees = Committee::active()->with('position')->orderBy('full_name')->get();
        return view('takmir.duty-schedules.edit', compact('dutySchedule', 'committees'));
    }

    public function update(Request $request, DutySchedule $dutySchedule)
    {
        $request->validate([
            'committee_id' => 'required|exists:committees,id',
            'duty_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
            'duty_type' => 'required|in:piket,kebersihan,keamanan,acara,lainnya',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
            'remarks' => 'nullable|string',
            'is_recurring' => 'boolean',
            'recurring_type' => 'nullable|required_if:is_recurring,1|in:daily,weekly,monthly,yearly',
            'recurring_end_date' => 'nullable|required_if:is_recurring,1|date|after:duty_date',
        ]);

        $data = $request->all();
        $data['is_recurring'] = $request->has('is_recurring');

        $dutySchedule->update($data);

        return redirect()->route('duty-schedules.index')->with('success', 'Jadwal piket berhasil diperbarui!');
    }

    public function destroy(DutySchedule $dutySchedule)
    {
        $dutySchedule->delete();
        return redirect()->route('duty-schedules.index')->with('success', 'Jadwal piket berhasil dihapus!');
    }
}








