@extends('layouts.app')

@section('title', 'Jadwal Sholat Mingguan')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">🕌 Jadwal Sholat Mingguan</h1>
</div>

<!-- Jadwal Hari Ini -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-left-primary shadow">
            <div class="card-body">
                <h5 class="text-primary mb-3">
                    <i class="fas fa-calendar-day"></i> Jadwal Sholat Hari Ini ({{ ucfirst($today) }})
                </h5>
                <div class="row text-center">
                    @foreach($schedules as $schedule)
                        <div class="col-md-2 col-6 mb-2">
                            <div class="p-2 bg-light rounded">
                                <strong>{{ $schedule->prayer_name }}</strong><br>
                                <h4 class="text-primary m-0">{{ $schedule->getTimeForDay($today) }}</h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Jadwal Lengkap Seminggu -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Jadwal Lengkap Seminggu</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Waktu Sholat</th>
                        <th>Senin</th>
                        <th>Selasa</th>
                        <th>Rabu</th>
                        <th>Kamis</th>
                        <th>Jumat</th>
                        <th>Sabtu</th>
                        <th>Minggu</th>
                        @if(auth()->user()->isAdmin() || auth()->user()->isDkm())
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $schedule)
                    <tr>
                        <td><strong>{{ $schedule->prayer_name }}</strong></td>
                        <td class="{{ $today == 'monday' ? 'bg-light font-weight-bold' : '' }}">{{ $schedule->monday }}</td>
                        <td class="{{ $today == 'tuesday' ? 'bg-light font-weight-bold' : '' }}">{{ $schedule->tuesday }}</td>
                        <td class="{{ $today == 'wednesday' ? 'bg-light font-weight-bold' : '' }}">{{ $schedule->wednesday }}</td>
                        <td class="{{ $today == 'thursday' ? 'bg-light font-weight-bold' : '' }}">{{ $schedule->thursday }}</td>
                        <td class="{{ $today == 'friday' ? 'bg-light font-weight-bold' : '' }}">{{ $schedule->friday }}</td>
                        <td class="{{ $today == 'saturday' ? 'bg-light font-weight-bold' : '' }}">{{ $schedule->saturday }}</td>
                        <td class="{{ $today == 'sunday' ? 'bg-light font-weight-bold' : '' }}">{{ $schedule->sunday }}</td>
                        @if(auth()->user()->isAdmin() || auth()->user()->isDkm())
                            <td>
                                <a href="{{ route('prayer-schedules.edit', $schedule->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ (auth()->user()->isAdmin() || auth()->user()->isDkm()) ? '9' : '8' }}" class="text-center">
                            Belum ada jadwal sholat
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="alert alert-info">
    <i class="fas fa-info-circle"></i> <strong>Catatan:</strong> Jadwal sholat berubah setiap hari mengikuti pergerakan matahari. Kolom hari ini ditandai dengan latar abu-abu.
</div>
@endsection



