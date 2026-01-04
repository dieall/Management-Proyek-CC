<?php

namespace App\Http\Controllers;

use App\Models\WeeklyPrayerSchedule;
use Illuminate\Http\Request;

class WeeklyPrayerScheduleController extends Controller
{
    public function index()
    {
        $schedules = WeeklyPrayerSchedule::all();
        $today = strtolower(date('l')); // monday, tuesday, etc
        
        return view('informasi.prayer-schedules.index', compact('schedules', 'today'));
    }

    public function create()
    {
        return view('informasi.prayer-schedules.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'prayer_name' => 'required|string|max:255',
            'monday' => 'required|date_format:H:i',
            'tuesday' => 'required|date_format:H:i',
            'wednesday' => 'required|date_format:H:i',
            'thursday' => 'required|date_format:H:i',
            'friday' => 'required|date_format:H:i',
            'saturday' => 'required|date_format:H:i',
            'sunday' => 'required|date_format:H:i',
        ]);

        WeeklyPrayerSchedule::create($request->all());

        return redirect()->route('prayer-schedules.index')->with('success', 'Jadwal Sholat berhasil ditambahkan!');
    }

    public function show(WeeklyPrayerSchedule $prayerSchedule)
    {
        return view('informasi.prayer-schedules.show', compact('prayerSchedule'));
    }

    public function edit(WeeklyPrayerSchedule $prayerSchedule)
    {
        return view('informasi.prayer-schedules.edit', compact('prayerSchedule'));
    }

    public function update(Request $request, WeeklyPrayerSchedule $prayerSchedule)
    {
        $request->validate([
            'prayer_name' => 'required|string|max:255',
            'monday' => 'required|date_format:H:i',
            'tuesday' => 'required|date_format:H:i',
            'wednesday' => 'required|date_format:H:i',
            'thursday' => 'required|date_format:H:i',
            'friday' => 'required|date_format:H:i',
            'saturday' => 'required|date_format:H:i',
            'sunday' => 'required|date_format:H:i',
        ]);

        $prayerSchedule->update($request->all());

        return redirect()->route('prayer-schedules.index')->with('success', 'Jadwal Sholat berhasil diperbarui!');
    }

    public function destroy(WeeklyPrayerSchedule $prayerSchedule)
    {
        $prayerSchedule->delete();
        return redirect()->route('prayer-schedules.index')->with('success', 'Jadwal Sholat berhasil dihapus!');
    }
}
