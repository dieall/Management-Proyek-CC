@extends('layouts.app')

@section('title', 'Penugasan Tugas')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Penugasan Tugas</h1>
    <div>
        <a href="{{ route('task-assignments.create') }}" class="btn btn-primary shadow-sm mr-2">
            <i class="fas fa-plus fa-sm text-white-50"></i> Buat Penugasan
        </a>
        <a href="{{ route('task-assignments.overdue') }}" class="btn btn-danger shadow-sm mr-2">
            <i class="fas fa-exclamation-triangle fa-sm text-white-50"></i> Terlambat
        </a>
        <a href="{{ route('task-assignments.statistics') }}" class="btn btn-info shadow-sm">
            <i class="fas fa-chart-bar fa-sm text-white-50"></i> Statistik
        </a>
    </div>
</div>

<!-- Filter Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('task-assignments.index') }}">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <select name="committee_id" class="form-select">
                        <option value="">Semua Pengurus</option>
                        @foreach($committees as $committee)
                            <option value="{{ $committee->id }}" {{ request('committee_id') == $committee->id ? 'selected' : '' }}>
                                {{ $committee->full_name }} @if($committee->position) - {{ $committee->position->name }} @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <select name="job_responsibility_id" class="form-select">
                        <option value="">Semua Tugas</option>
                        @foreach($jobResponsibilities as $responsibility)
                            <option value="{{ $responsibility->id }}" {{ request('job_responsibility_id') == $responsibility->id ? 'selected' : '' }}>
                                {{ $responsibility->task_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Proses</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <select name="priority" class="form-select">
                        <option value="">Prioritas</option>
                        <option value="critical" {{ request('priority') == 'critical' ? 'selected' : '' }}>Kritis</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Sedang</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari catatan..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="row" id="advancedFilters" style="display: {{ request()->except(['committee_id','job_responsibility_id','status','priority','search','page']) ? 'block' : 'none' }};">
                <div class="col-md-3 mb-3">
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="Penugasan Dari">
                </div>
                <div class="col-md-3 mb-3">
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="Penugasan Sampai">
                </div>
                <div class="col-md-3 mb-3">
                    <input type="date" name="due_date_from" class="form-control" value="{{ request('due_date_from') }}" placeholder="Deadline Dari">
                </div>
                <div class="col-md-3 mb-3">
                    <input type="date" name="due_date_to" class="form-control" value="{{ request('due_date_to') }}" placeholder="Deadline Sampai">
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="toggleAdvanced()">
                        <i class="fas fa-filter"></i> Filter Lanjutan
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm ml-2">
                        <i class="fas fa-search"></i> Terapkan
                    </button>
                </div>
                <a href="{{ route('task-assignments.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-redo"></i> Reset
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Table Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Penugasan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tugas</th>
                        <th>Pengurus</th>
                        <th>Tanggal</th>
                        <th>Deadline</th>
                        <th>Progress</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($assignments as $assignment)
                        @php $isOverdue = $assignment->due_date->isPast() && $assignment->status != 'completed'; @endphp
                        <tr class="{{ $isOverdue ? 'table-danger' : ($assignment->status == 'completed' ? 'table-success' : '') }}">
                            <td>{{ $loop->iteration + ($assignments->currentPage() - 1) * $assignments->perPage() }}</td>
                            <td>
                                <strong>{{ $assignment->jobResponsibility->task_name }}</strong><br>
                                <small class="text-muted">
                                    @if($assignment->jobResponsibility->position)
                                        {{ $assignment->jobResponsibility->position->name }}
                                    @endif
                                </small>
                            </td>
                            <td>
                                <strong>{{ $assignment->committee->full_name }}</strong>
                            </td>
                            <td>{{ $assignment->assigned_date->format('d/m/Y') }}</td>
                            <td>
                                {{ $assignment->due_date->format('d/m/Y') }}
                                @if($isOverdue)
                                    <br><span class="badge badge-danger">Terlambat</span>
                                @endif
                            </td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-{{ $assignment->progress_percentage == 100 ? 'success' : 'info' }}"
                                         style="width: {{ $assignment->progress_percentage }}%">
                                        {{ $assignment->progress_percentage }}%
                                    </div>
                                </div>
                            </td>
                            <td>
                                @switch($assignment->status)
                                    @case('completed') <span class="badge badge-success">Selesai</span> @break
                                    @case('in_progress') <span class="badge badge-warning">Proses</span> @break
                                    @case('pending') <span class="badge badge-info">Pending</span> @break
                                    @case('overdue') <span class="badge badge-danger">Terlambat</span> @break
                                    @default <span class="badge badge-secondary">Dibatalkan</span>
                                @endswitch
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('task-assignments.show', $assignment->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('task-assignments.edit', $assignment->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $assignment->id }}, '{{ addslashes($assignment->jobResponsibility->task_name) }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada penugasan tugas</p>
                                <a href="{{ route('task-assignments.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Buat Penugasan Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($assignments->hasPages())
            <div class="d-flex justify-content-between mt-4">
                <div class="text-muted">
                    Menampilkan {{ $assignments->firstItem() }} - {{ $assignments->lastItem() }} dari {{ $assignments->total() }} penugasan
                </div>
                <div>
                    {{ $assignments->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus Penugasan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus penugasan <strong id="deleteName"></strong>?</p>
                <p class="text-danger"><small>Data yang dihapus tidak dapat dikembalikan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('deleteForm').action = '/task-assignments/' + id;
    $('#deleteModal').modal('show');
}

function toggleAdvanced() {
    const el = document.getElementById('advancedFilters');
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
</script>
@endpush
