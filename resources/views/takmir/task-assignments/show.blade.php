@extends('layouts.app')

@section('title', 'Detail Penugasan Tugas')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Penugasan Tugas</h1>
    <div>
        <a href="{{ route('task-assignments.edit', $taskAssignment->id) }}" class="btn btn-warning btn-icon-split">
            <span class="icon text-white-50"><i class="fas fa-edit"></i></span>
            <span class="text">Edit</span>
        </a>
        <a href="{{ route('task-assignments.index') }}" class="btn btn-secondary btn-icon-split">
            <span class="icon text-white-50"><i class="fas fa-arrow-left"></i></span>
            <span class="text">Kembali</span>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Penugasan</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="200">Pengurus</th>
                        <td>: <a href="{{ route('committees.show', $taskAssignment->committee->id) }}">{{ $taskAssignment->committee->full_name }}</a></td>
                    </tr>
                    <tr>
                        <th>Tugas</th>
                        <td>: {{ $taskAssignment->jobResponsibility->task_name }}</td>
                    </tr>
                    <tr>
                        <th>Posisi</th>
                        <td>: {{ $taskAssignment->jobResponsibility->position->name }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai</th>
                        <td>: {{ $taskAssignment->assigned_date->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Due Date</th>
                        <td>: {{ $taskAssignment->due_date->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>: 
                            @if($taskAssignment->status == 'completed')
                                <span class="badge badge-success">Selesai</span>
                            @elseif($taskAssignment->status == 'in_progress')
                                <span class="badge badge-info">Berjalan</span>
                            @elseif($taskAssignment->status == 'overdue')
                                <span class="badge badge-danger">Terlambat</span>
                            @elseif($taskAssignment->status == 'cancelled')
                                <span class="badge badge-secondary">Dibatalkan</span>
                            @else
                                <span class="badge badge-warning">Menunggu</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Progress</th>
                        <td>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: {{ $taskAssignment->progress_percentage }}%">
                                    {{ $taskAssignment->progress_percentage }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                    @if($taskAssignment->completed_date)
                    <tr>
                        <th>Tanggal Selesai (Actual)</th>
                        <td>: {{ $taskAssignment->completed_date->format('d/m/Y') }}</td>
                    </tr>
                    @endif
                    @if($taskAssignment->approver)
                    <tr>
                        <th>Disetujui Oleh</th>
                        <td>: {{ $taskAssignment->approver->full_name }}</td>
                    </tr>
                    @if($taskAssignment->approved_at)
                    <tr>
                        <th>Tanggal Persetujuan</th>
                        <td>: {{ $taskAssignment->approved_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endif
                    @endif
                    @if($taskAssignment->notes)
                    <tr>
                        <th>Catatan</th>
                        <td>: {{ $taskAssignment->notes }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection







