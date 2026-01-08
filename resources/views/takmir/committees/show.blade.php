@extends('layouts.app')

@section('title', 'Detail Pengurus')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Pengurus</h1>
    <div>
        <a href="{{ route('committees.edit', $committee->id) }}" class="btn btn-warning btn-icon-split">
            <span class="icon text-white-50"><i class="fas fa-edit"></i></span>
            <span class="text">Edit</span>
        </a>
        <a href="{{ route('committees.index') }}" class="btn btn-secondary btn-icon-split">
            <span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
            <span class="text">Kembali</span>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Pengurus</h6>
            </div>
            <div class="card-body">
                @if($committee->photo_path)
                    <div class="text-center mb-3">
                        <img src="{{ asset('storage/' . $committee->photo_path) }}" alt="Foto" class="img-thumbnail" style="max-width: 200px;">
                    </div>
                @endif

                <table class="table table-borderless">
                    <tr>
                        <th width="200">Nama Lengkap</th>
                        <td>: {{ $committee->full_name }}</td>
                    </tr>
                    <tr>
                        <th>Posisi/Jabatan</th>
                        <td>: {{ $committee->position->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>: {{ $committee->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>No HP</th>
                        <td>: {{ $committee->phone_number ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Kelamin</th>
                        <td>: {{ $committee->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>: {{ $committee->address ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Lahir</th>
                        <td>: {{ $committee->birth_date ? $committee->birth_date->format('d/m/Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Bergabung</th>
                        <td>: {{ $committee->join_date ? $committee->join_date->format('d/m/Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>: 
                            @if($committee->active_status == 'active')
                                <span class="badge badge-success">Aktif</span>
                            @elseif($committee->active_status == 'inactive')
                                <span class="badge badge-secondary">Tidak Aktif</span>
                            @else
                                <span class="badge badge-danger">Mengundurkan Diri</span>
                            @endif
                        </td>
                    </tr>
                    @if($committee->user)
                    <tr>
                        <th>User Account</th>
                        <td>: {{ $committee->user->name ?? $committee->user->nama_lengkap }}</td>
                    </tr>
                    @endif
                    @if($committee->cv_path)
                    <tr>
                        <th>CV/Dokumen</th>
                        <td>: <a href="{{ asset('storage/' . $committee->cv_path) }}" target="_blank" class="btn btn-sm btn-info">Download CV</a></td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>

@if($committee->positionHistories->count() > 0)
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Posisi ({{ $committee->positionHistories->count() }})</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Posisi</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Tipe Penunjukan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($committee->positionHistories as $history)
                    <tr>
                        <td>{{ $history->position->name }}</td>
                        <td>{{ $history->start_date->format('d/m/Y') }}</td>
                        <td>{{ $history->end_date ? $history->end_date->format('d/m/Y') : '-' }}</td>
                        <td>{{ ucfirst($history->appointment_type) }}</td>
                        <td>
                            @if($history->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@if($committee->dutySchedules->count() > 0)
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Jadwal Piket Terbaru ({{ $committee->dutySchedules->count() }})</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Lokasi</th>
                        <th>Tipe</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($committee->dutySchedules as $schedule)
                    <tr>
                        <td>{{ $schedule->duty_date->format('d/m/Y') }}</td>
                        <td>{{ $schedule->start_time }} - {{ $schedule->end_time }}</td>
                        <td>{{ $schedule->location }}</td>
                        <td>{{ ucfirst($schedule->duty_type) }}</td>
                        <td>
                            @if($schedule->status == 'completed')
                                <span class="badge badge-success">Selesai</span>
                            @elseif($schedule->status == 'ongoing')
                                <span class="badge badge-info">Berjalan</span>
                            @elseif($schedule->status == 'cancelled')
                                <span class="badge badge-danger">Dibatalkan</span>
                            @else
                                <span class="badge badge-warning">Terjadwal</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@if($committee->taskAssignments->count() > 0)
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Penugasan Tugas Terbaru ({{ $committee->taskAssignments->count() }})</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tugas</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Progress</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($committee->taskAssignments as $task)
                    <tr>
                        <td>{{ $task->jobResponsibility->task_name }}</td>
                        <td>{{ $task->assigned_date->format('d/m/Y') }}</td>
                        <td>{{ $task->due_date->format('d/m/Y') }}</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $task->progress_percentage }}%">
                                    {{ $task->progress_percentage }}%
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($task->status == 'completed')
                                <span class="badge badge-success">Selesai</span>
                            @elseif($task->status == 'in_progress')
                                <span class="badge badge-info">Berjalan</span>
                            @elseif($task->status == 'overdue')
                                <span class="badge badge-danger">Terlambat</span>
                            @elseif($task->status == 'cancelled')
                                <span class="badge badge-secondary">Dibatalkan</span>
                            @else
                                <span class="badge badge-warning">Menunggu</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection











