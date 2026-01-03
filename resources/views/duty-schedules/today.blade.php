@extends('layouts.app')

@section('title', 'Jadwal Hari Ini')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Jadwal Hari Ini</h1>
    <small class="text-muted">{{ now()->translatedFormat('l, d F Y') }}</small>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Jadwal</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $schedules->total() }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-calendar-alt fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Selesai</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $schedules->where('status', 'completed')->count() }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Sedang Berjalan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $schedules->where('status', 'ongoing')->count() }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-sync-alt fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pending</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $schedules->where('status', 'pending')->count() }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-clock fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="card shadow">
    <div class="card-header py-3 d-flex justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Jadwal Hari Ini</h6>
        <a href="{{ route('duty-schedules.create') }}" class="btn btn-primary btn-sm">Tambah Jadwal</a>
    </div>
    <div class="card-body">
        @if($schedules->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Waktu</th>
                            <th>Pengurus</th>
                            <th>Jabatan</th>
                            <th>Lokasi</th>
                            <th>Jenis Tugas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $schedule)
                        <tr>
                            <td>
                                <strong>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</strong>
                            </td>
                            <td>
                                <strong>{{ $schedule->committee->full_name }}</strong>
                            </td>
                            <td>
                                @if($schedule->committee->position)
                                    <span class="badge badge-info">{{ $schedule->committee->position->name }}</span>
                                @endif
                            </td>
                            <td>{{ $schedule->location }}</td>
                            <td>
                                <span class="badge badge-pill badge-{{ getDutyTypeColor($schedule->duty_type) }}">
                                    {{ ucfirst($schedule->duty_type) }}
                                </span>
                            </td>
                            <td>
                                @switch($schedule->status)
                                    @case('completed') <span class="badge badge-success">Selesai</span> @break
                                    @case('ongoing') <span class="badge badge-warning">Berjalan</span> @break
                                    @case('pending') <span class="badge badge-info">Pending</span> @break
                                    @default <span class="badge badge-secondary">Dibatalkan</span>
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('duty-schedules.show', $schedule->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('duty-schedules.edit', $schedule->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-calendar-check fa-4x text-success mb-3"></i>
                <h5>Belum ada jadwal hari ini</h5>
                <p class="text-muted">Semua tenang dan terkendali!</p>
            </div>
        @endif
    </div>
</div>
@endsection

@php
function getDutyTypeColor($type) {
    return ['piket'=>'primary','kebersihan'=>'success','keamanan'=>'dark','administrasi'=>'info','lainnya'=>'secondary'][$type] ?? 'secondary';
}
@endphp
