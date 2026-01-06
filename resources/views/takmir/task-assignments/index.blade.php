@extends('layouts.app')

@section('title', 'Penugasan Tugas')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Penugasan Tugas</h1>
    <a href="{{ route('task-assignments.create') }}" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tambah Penugasan</span>
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Penugasan Tugas</h6>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form method="GET" action="{{ route('task-assignments.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-2">
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Berjalan</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="committee_id" class="form-control">
                        <option value="">Semua Pengurus</option>
                        @foreach($committees as $comm)
                            <option value="{{ $comm->id }}" {{ request('committee_id') == $comm->id ? 'selected' : '' }}>{{ $comm->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="due_date_from" class="form-control" value="{{ request('due_date_from') }}" placeholder="Due Date From">
                </div>
                <div class="col-md-2">
                    <input type="date" name="due_date_to" class="form-control" value="{{ request('due_date_to') }}" placeholder="Due Date To">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('task-assignments.index') }}" class="btn btn-secondary btn-block">Reset</a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pengurus</th>
                        <th>Tugas</th>
                        <th>Tanggal Mulai</th>
                        <th>Due Date</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($taskAssignments as $task)
                    <tr>
                        <td>{{ ($taskAssignments->currentPage() - 1) * $taskAssignments->perPage() + $loop->iteration }}</td>
                        <td>{{ $task->committee->full_name }}</td>
                        <td>{{ $task->jobResponsibility->task_name }}</td>
                        <td>{{ $task->assigned_date->format('d/m/Y') }}</td>
                        <td>{{ $task->due_date->format('d/m/Y') }}</td>
                        <td>
                            <div class="progress" style="height: 20px;">
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
                        <td>
                            <a href="{{ route('task-assignments.show', $task->id) }}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('task-assignments.edit', $task->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('task-assignments.destroy', $task->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data penugasan tugas</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $taskAssignments->links() }}
        </div>
    </div>
</div>
@endsection








