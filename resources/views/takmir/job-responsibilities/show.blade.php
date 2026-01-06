@extends('layouts.app')

@section('title', 'Detail Tugas & Tanggung Jawab')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Tugas & Tanggung Jawab</h1>
    <div>
        <a href="{{ route('job-responsibilities.edit', $jobResponsibility->id) }}" class="btn btn-warning btn-icon-split">
            <span class="icon text-white-50"><i class="fas fa-edit"></i></span>
            <span class="text">Edit</span>
        </a>
        <a href="{{ route('job-responsibilities.index') }}" class="btn btn-secondary btn-icon-split">
            <span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
            <span class="text">Kembali</span>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Tugas</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Nama Tugas</th>
                        <td>: {{ $jobResponsibility->task_name }}</td>
                    </tr>
                    <tr>
                        <th>Posisi/Jabatan</th>
                        <td>: {{ $jobResponsibility->position->name }}</td>
                    </tr>
                    <tr>
                        <th>Prioritas</th>
                        <td>: 
                            @if($jobResponsibility->priority == 'critical')
                                <span class="badge badge-danger">Kritis</span>
                            @elseif($jobResponsibility->priority == 'high')
                                <span class="badge badge-warning">Tinggi</span>
                            @elseif($jobResponsibility->priority == 'medium')
                                <span class="badge badge-info">Sedang</span>
                            @else
                                <span class="badge badge-secondary">Rendah</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Frekuensi</th>
                        <td>: {{ ucfirst($jobResponsibility->frequency) }}</td>
                    </tr>
                    <tr>
                        <th>Estimasi Jam</th>
                        <td>: {{ $jobResponsibility->estimated_hours ?? '-' }} jam</td>
                    </tr>
                    <tr>
                        <th>Core Responsibility</th>
                        <td>: 
                            @if($jobResponsibility->is_core_responsibility)
                                <span class="badge badge-primary">Ya</span>
                            @else
                                <span class="badge badge-secondary">Tidak</span>
                            @endif
                        </td>
                    </tr>
                    @if($jobResponsibility->task_description)
                    <tr>
                        <th>Deskripsi</th>
                        <td>: {{ $jobResponsibility->task_description }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>

@if($jobResponsibility->taskAssignments->count() > 0)
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Penugasan Tugas ({{ $jobResponsibility->taskAssignments->count() }})</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Pengurus</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Progress</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobResponsibility->taskAssignments as $task)
                    <tr>
                        <td><a href="{{ route('committees.show', $task->committee->id) }}">{{ $task->committee->full_name }}</a></td>
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







