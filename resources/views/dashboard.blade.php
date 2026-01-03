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
        <!-- Left Column -->
        <div class="col-lg-8">
            <!-- Today's Schedule -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-calendar-day"></i> Jadwal Hari Ini
                    </h6>
                    <a href="{{ route('duty-schedules.index') }}" class="btn btn-sm btn-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if($todaySchedules->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Pengurus</th>
                                        <th>Waktu</th>
                                        <th>Lokasi</th>
                                        <th>Tugas</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($todaySchedules as $schedule)
                                    <tr>
                                        <td>{{ $schedule->committee->full_name ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                                        <td>{{ $schedule->location }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $schedule->duty_type }}</span>
                                        </td>
                                        <td>
                                            @if($schedule->status == 'ongoing')
                                                <span class="badge bg-warning">Sedang Berjalan</span>
                                            @elseif($schedule->status == 'completed')
                                                <span class="badge bg-success">Selesai</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $schedule->status }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada jadwal untuk hari ini</p>
                        </div>
                    @endif
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
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Belum ada data pengurus</p>
                    @endif
                </div>
            </div>

            <!-- Urgent Tasks -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-exclamation-triangle"></i> Tugas Mendesak
                    </h6>
                </div>
                <div class="card-body">
                    @if($urgentTasks->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($urgentTasks as $task)
                            <div class="list-group-item px-0">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $task->jobResponsibility->task_name ?? 'Tugas' }}</h6>
                                    <small class="text-{{ $task->status == 'overdue' ? 'danger' : 'warning' }}">
                                        {{ $task->status == 'overdue' ? 'Terlambat' : 'Mendesak' }}
                                    </small>
                                </div>
                                <p class="mb-1">
                                    <small>Oleh: {{ $task->committee->full_name ?? '-' }}</small>
                                </p>
                                <small class="text-muted">
                                    Jatuh tempo: {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                                </small>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-{{ $task->status == 'overdue' ? 'danger' : 'warning' }}"
                                         style="width: {{ $task->progress_percentage }}%"></div>
                                </div>
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
