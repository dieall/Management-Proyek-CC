@extends('layouts.app')

@section('title', 'Detail Jadwal')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Detail Jadwal</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('duty-schedules.index') }}">Jadwal</a></li>
            <li class="breadcrumb-item active">Detail</li>
        </ol>
    </div>
    <div>
        <a href="{{ route('duty-schedules.edit', $schedule->id) }}" class="btn btn-warning shadow-sm mr-2">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('duty-schedules.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <!-- Left: Info Jadwal -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Jadwal</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Tanggal</th>
                        <td>: <strong>{{ $schedule->duty_date->translatedFormat('l, d F Y') }}</strong></td>
                    </tr>
                    <tr>
                        <th>Waktu</th>
                        <td>: <strong>{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</strong></td>
                    </tr>
                    <tr>
                        <th>Jenis Tugas</th>
                        <td>: <span class="badge badge-pill badge-{{ getDutyTypeColor($schedule->duty_type) }}">{{ ucfirst($schedule->duty_type) }}</span></td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>: {{ $schedule->location }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>:
                            @switch($schedule->status)
                                @case('completed') <span class="badge badge-success">Selesai</span> @break
                                @case('ongoing') <span class="badge badge-warning">Sedang Berjalan</span> @break
                                @case('pending') <span class="badge badge-info">Pending</span> @break
                                @default <span class="badge badge-secondary">Dibatalkan</span>
                            @endswitch
                        </td>
                    </tr>
                    @if($schedule->is_recurring)
                    <tr>
                        <th>Berulang</th>
                        <td>: <span class="text-info"><i class="fas fa-redo"></i> {{ ucfirst($schedule->recurring_type) }}
                            @if($schedule->recurring_end_date) sampai {{ $schedule->recurring_end_date->format('d/m/Y') }} @endif
                        </span></td>
                    </tr>
                    @endif
                    @if($schedule->remarks)
                    <tr>
                        <th>Catatan</th>
                        <td>: {{ $schedule->remarks }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <!-- Update Status -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Update Status</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('duty-schedules.update-status', $schedule->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-7">
                            <select name="status" class="form-select" required>
                                <option value="pending" {{ $schedule->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="ongoing" {{ $schedule->status == 'ongoing' ? 'selected' : '' }}>Sedang Berjalan</option>
                                <option value="completed" {{ $schedule->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ $schedule->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <button type="submit" class="btn btn-primary w-100">Update Status</button>
                        </div>
                    </div>
                    <div class="mt-3">
                        <textarea name="remarks" class="form-control" rows="3" placeholder="Catatan status (opsional)">{{ old('remarks', $schedule->remarks) }}</textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Right: Pengurus & Jadwal Serupa -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Pengurus Bertugas</h6>
            </div>
            <div class="card-body text-center">
                <div class="mb-4">
                    <div class="rounded-circle bg-gradient-primary d-inline-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px;">
                        <i class="fas fa-user fa-3x text-white"></i>
                    </div>
                </div>
                <h5>{{ $schedule->committee->full_name }}</h5>
                @if($schedule->committee->position)
                    <p class="text-primary">{{ $schedule->committee->position->name }}</p>
                @endif
                <hr>
                <div class="row text-left">
                    <div class="col-6">
                        <small class="text-muted">Email</small><br>
                        @if($schedule->committee->email)
                            <a href="mailto:{{ $schedule->committee->email }}">{{ $schedule->committee->email }}</a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Telepon</small><br>
                        @if($schedule->committee->phone_number)
                            <a href="tel:{{ $schedule->committee->phone_number }}">{{ $schedule->committee->phone_number }}</a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('committees.show', $schedule->committee->id) }}" class="btn btn-primary btn-sm">
                        Lihat Profil Lengkap
                    </a>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Jadwal Serupa</h6>
            </div>
            <div class="card-body p-0">
                @if($similarSchedules->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($similarSchedules as $similar)
                                <tr>
                                    <td>{{ $similar->duty_date->format('d/m/Y') }}</td>
                                    <td>{{ $similar->start_time->format('H:i') }} - {{ $similar->end_time->format('H:i') }}</td>
                                    <td>
                                        @switch($similar->status)
                                            @case('completed') <span class="badge badge-success">Selesai</span> @break
                                            @case('ongoing') <span class="badge badge-warning">Berjalan</span> @break
                                            @case('pending') <span class="badge badge-info">Pending</span> @break
                                            @default <span class="badge badge-secondary">Dibatalkan</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <a href="{{ route('duty-schedules.show', $similar->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted py-4 mb-0">Tidak ada jadwal serupa</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@php
function getDutyTypeColor($type) {
    return ['piket'=>'primary','kebersihan'=>'success','keamanan'=>'dark','administrasi'=>'info','lainnya'=>'secondary'][$type] ?? 'secondary';
}
@endphp
