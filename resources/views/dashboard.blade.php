@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <span class="text-muted">{{ now()->translatedFormat('l, d F Y') }}</span>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Total Pengurus -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Pengurus
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_committees'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengurus Aktif -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Pengurus Aktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active_committees'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Hari Ini -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Jadwal Hari Ini
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['today_duties'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tugas Tertunda -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Tugas Tertunda
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['pending_tasks'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tasks fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Jadwal Hari Ini -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Jadwal Hari Ini</h6>
            </div>
            <div class="card-body">
                @if($todaySchedules->isEmpty())
                    <p class="text-center text-muted">Tidak ada jadwal hari ini</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Pengurus</th>
                                    <th>Waktu</th>
                                    <th>Lokasi</th>
                                    <th>Tugas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todaySchedules as $schedule)
                                <tr>
                                    <td>{{ $schedule->committee->full_name }}</td>
                                    <td>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</td>
                                    <td>{{ $schedule->location }}</td>
                                    <td><span class="badge badge-info">{{ ucfirst($schedule->duty_type) }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Tugas Mendesak -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">Tugas Mendesak</h6>
            </div>
            <div class="card-body">
                @if($urgentTasks->isEmpty())
                    <p class="text-center text-success"><i class="fas fa-check-circle fa-3x"></i><br>Tidak ada tugas mendesak</p>
                @else
                    <ul class="list-group">
                        @foreach($urgentTasks as $task)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>{{ $task->jobResponsibility->task_name }}</strong><br>
                                    <small>Oleh: {{ $task->committee->full_name }}</small>
                                </div>
                                <span class="badge badge-{{ $task->status == 'overdue' ? 'danger' : 'warning' }}">
                                    {{ $task->status == 'overdue' ? 'Terlambat' : 'Mendesak' }}
                                </span>
                            </div>
                            <div class="progress mt-2" style="height: 8px;">
                                <div class="progress-bar" style="width: {{ $task->progress_percentage }}%"></div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
