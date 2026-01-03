@extends('layouts.app')

@section('title', 'Detail Pengurus - ' . $committee->full_name)

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Detail Pengurus</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('committees.index') }}">Pengurus</a></li>
            <li class="breadcrumb-item active">{{ $committee->full_name }}</li>
        </ol>
    </div>
    <div>
        <a href="{{ route('committees.edit', $committee->id) }}" class="btn btn-warning shadow-sm">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('committees.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <!-- Profile Card -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Profil</h6>
            </div>
            <div class="card-body text-center">
                <div class="mt-3 mb-4">
                    <div class="rounded-circle bg-gradient-primary d-inline-flex align-items-center justify-content-center mx-auto" style="width: 120px; height: 120px;">
                        <i class="fas fa-user fa-4x text-white"></i>
                    </div>
                </div>
                <h4 class="mb-1">{{ $committee->full_name }}</h4>
                @if($committee->position)
                    <p class="text-primary font-weight-bold">{{ $committee->position->name }}</p>
                @endif
                @switch($committee->active_status)
                    @case('active')
                        <span class="badge badge-success badge-pill px-3 py-2">Aktif</span>
                        @break
                    @case('inactive')
                        <span class="badge badge-secondary badge-pill px-3 py-2">Tidak Aktif</span>
                        @break
                    @case('resigned')
                        <span class="badge badge-warning badge-pill px-3 py-2">Mengundurkan Diri</span>
                        @break
                @endswitch

                <div class="row mt-4">
                    <div class="col-6">
                        <h5>{{ $stats['total_duties'] }}</h5>
                        <small class="text-muted">Total Jadwal</small>
                    </div>
                    <div class="col-6">
                        <h5>{{ $stats['completed_tasks'] }}</h5>
                        <small class="text-muted">Tugas Selesai</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Kontak</h6>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @if($committee->email)
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-envelope text-primary mr-3"></i>
                            <a href="mailto:{{ $committee->email }}">{{ $committee->email }}</a>
                        </li>
                    @endif
                    @if($committee->phone_number)
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-phone text-success mr-3"></i>
                            <a href="tel:{{ $committee->phone_number }}">{{ $committee->phone_number }}</a>
                        </li>
                    @endif
                    @if($committee->address)
                        <li class="list-group-item d-flex align-items-center">
                            <i class="fas fa-map-marker-alt text-danger mr-3"></i>
                            {{ $committee->address }}
                        </li>
                    @endif
                    <li class="list-group-item d-flex align-items-center">
                        <i class="fas fa-{{ $committee->gender == 'male' ? 'mars' : 'venus' }} text-info mr-3"></i>
                        {{ $committee->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <i class="fas fa-birthday-cake text-warning mr-3"></i>
                        {{ $committee->birth_date?->format('d/m/Y') ?? 'Tidak diketahui' }}
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <i class="fas fa-calendar-check text-success mr-3"></i>
                        Bergabung: {{ $committee->join_date->format('d/m/Y') }}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-8">
        <!-- Riwayat Jabatan -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Jabatan</h6>
            </div>
            <div class="card-body">
                @if($committee->positionHistories->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Jabatan</th>
                                    <th>Periode</th>
                                    <th>Status</th>
                                    <th>Tipe</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($committee->positionHistories as $history)
                                <tr class="{{ $history->is_active ? 'table-success' : '' }}">
                                    <td>{{ $history->position->name }}</td>
                                    <td>
                                        {{ $history->start_date->format('d/m/Y') }}
                                        @if($history->end_date)
                                            — {{ $history->end_date->format('d/m/Y') }}
                                        @else
                                            — Sekarang
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $history->is_active ? 'success' : 'secondary' }}">
                                            {{ $history->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                    <td><span class="badge badge-info">{{ ucfirst($history->appointment_type) }}</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted">Belum ada riwayat jabatan</p>
                @endif
            </div>
        </div>

        <!-- Jadwal & Tugas -->
        <!-- (Anda bisa pindahkan ke tab jika ingin lebih rapi) -->
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Jadwal Terbaru</h6>
                        <a href="{{ route('committees.duties', $committee->id) }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                    </div>
                    <div class="card-body p-0">
                        @if($committee->dutySchedules->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($committee->dutySchedules->take(5) as $duty)
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $duty->duty_date->format('d/m/Y') }}</h6>
                                        <small>{{ $duty->start_time->format('H:i') }} - {{ $duty->end_time->format('H:i') }}</small>
                                    </div>
                                    <p class="mb-1">{{ ucfirst($duty->duty_type) }} - {{ $duty->location }}</p>
                                    <small class="text-{{ $duty->status == 'completed' ? 'success' : 'warning' }}">
                                        {{ ucfirst(str_replace('_', ' ', $duty->status)) }}
                                    </small>
                                </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-muted py-4">Belum ada jadwal</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Tugas Terbaru</h6>
                        <a href="{{ route('committees.tasks', $committee->id) }}" class="btn btn-sm btn-primary">Lihat Semua</a>
                    </div>
                    <div class="card-body p-0">
                        @if($committee->taskAssignments->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($committee->taskAssignments->take(5) as $task)
                                <a href="#" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">{{ $task->jobResponsibility->task_name ?? 'Tugas' }}</h6>
                                        <small>{{ $task->due_date->format('d/m/Y') }}</small>
                                    </div>
                                    <div class="progress mt-2" style="height: 6px;">
                                        <div class="progress-bar bg-{{ $task->progress_percentage >= 100 ? 'success' : 'info' }}"
                                             style="width: {{ $task->progress_percentage }}%"></div>
                                    </div>
                                    <small class="text-muted mt-1">{{ $task->progress_percentage }}% selesai</small>
                                </a>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center text-muted py-4">Belum ada tugas</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
