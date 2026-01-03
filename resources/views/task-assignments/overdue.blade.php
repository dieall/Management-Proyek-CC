@extends('layouts.app')

@section('title', 'Tugas Terlambat')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 text-danger">Tugas Terlambat</h1>
    <a href="{{ route('task-assignments.index') }}" class="btn btn-secondary shadow-sm">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
    </a>
</div>

<!-- Stats -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Terlambat</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $overdueTasks->total() }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tambahkan stats lain jika diperlukan -->
</div>

<!-- Table -->
<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-danger">Daftar Tugas yang Terlambat</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tugas</th>
                        <th>Pengurus</th>
                        <th>Deadline</th>
                        <th>Terlambat</th>
                        <th>Progress</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($overdueTasks as $task)
                        @php $daysLate = now()->diffInDays($task->due_date); @endphp
                        <tr class="table-danger">
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $task->jobResponsibility->task_name }}</strong></td>
                            <td>{{ $task->committee->full_name }}</td>
                            <td>{{ $task->due_date->format('d/m/Y') }}</td>
                            <td><span class="badge badge-danger">{{ $daysLate }} hari</span></td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-warning" style="width: {{ $task->progress_percentage }}%">
                                        {{ $task->progress_percentage }}%
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('task-assignments.show', $task->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('task-assignments.edit', $task->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-success">
                                <i class="fas fa-check-circle fa-4x mb-3"></i>
                                <h5>Tidak ada tugas terlambat!</h5>
                                <p>Semua tugas berjalan sesuai jadwal.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
