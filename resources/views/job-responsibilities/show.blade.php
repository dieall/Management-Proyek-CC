@extends('layouts.app')

@section('title', 'Detail Tugas - ' . $responsibility->task_name)

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Detail Tugas</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('job-responsibilities.index') }}">Tugas</a></li>
            <li class="breadcrumb-item active">{{ $responsibility->task_name }}</li>
        </ol>
    </div>
    <div>
        <a href="{{ route('job-responsibilities.edit', $responsibility->id) }}" class="btn btn-warning shadow-sm mr-2">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('job-responsibilities.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <!-- Left: Task Info -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Tugas</h6>
            </div>
            <div class="card-body">
                <h4>{{ $responsibility->task_name }}</h4>
                @if($responsibility->is_core_responsibility)
                    <span class="badge badge-success badge-pill mb-3">Tugas Inti</span>
                @else
                    <span class="badge badge-secondary badge-pill mb-3">Tugas Tambahan</span>
                @endif

                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Jabatan</th>
                        <td>: <a href="{{ route('positions.show', $responsibility->position_id) }}">
                            <span class="badge badge-info">{{ $responsibility->position->name }}</span>
                        </a></td>
                    </tr>
                    <tr>
                        <th>Prioritas</th>
                        <td>:
                            @switch($responsibility->priority)
                                @case('critical') <span class="badge badge-danger">Kritis</span> @break
                                @case('high') <span class="badge badge-warning">Tinggi</span> @break
                                @case('medium') <span class="badge badge-info">Sedang</span> @break
                                @default <span class="badge badge-secondary">Rendah</span>
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <th>Frekuensi</th>
                        <td>:
                            @switch($responsibility->frequency)
                                @case('daily') <span class="badge badge-dark">Harian</span> @break
                                @case('weekly') <span class="badge badge-primary">Mingguan</span> @break
                                @case('monthly') <span class="badge badge-info">Bulanan</span> @break
                                @case('yearly') <span class="badge badge-warning">Tahunan</span> @break
                                @default <span class="badge badge-secondary">Sesuai Kebutuhan</span>
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <th>Estimasi Waktu</th>
                        <td>:
                            @if($responsibility->estimated_hours)
                                <span class="badge badge-light text-dark border">
                                    <i class="fas fa-clock"></i> {{ $responsibility->estimated_hours }} jam
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @if($responsibility->task_description)
                    <tr>
                        <th>Deskripsi</th>
                        <td>: {{ $responsibility->task_description }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <!-- Stats -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Statistik Penugasan</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-3 border-right">
                        <h4 class="text-primary">{{ $stats['total_assignments'] }}</h4>
                        <small>Total</small>
                    </div>
                    <div class="col-3 border-right">
                        <h4 class="text-warning">{{ $stats['active_assignments'] }}</h4>
                        <small>Aktif</small>
                    </div>
                    <div class="col-3 border-right">
                        <h4 class="text-success">{{ $stats['completed_assignments'] }}</h4>
                        <small>Selesai</small>
                    </div>
                    <div class="col-3">
                        <h4 class="text-danger">{{ $stats['overdue_assignments'] }}</h4>
                        <small>Terlambat</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right: Assignments & Actions -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Penugasan Terbaru</h6>
                <a href="{{ route('task-assignments.create') }}?job_responsibility_id={{ $responsibility->id }}"
                   class="btn btn-sm btn-primary">+ Penugasan Baru</a>
            </div>
            <div class="card-body p-0">
                @if($recentAssignments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Pengurus</th>
                                    <th>Deadline</th>
                                    <th>Progress</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentAssignments as $assignment)
                                <tr class="{{ $assignment->status == 'overdue' ? 'table-danger' : '' }}">
                                    <td>
                                        <strong>{{ $assignment->committee->full_name }}</strong>
                                    </td>
                                    <td>{{ $assignment->due_date->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-{{ $assignment->progress_percentage >= 100 ? 'success' : 'info' }}"
                                                 style="width: {{ $assignment->progress_percentage }}%"></div>
                                        </div>
                                        <small>{{ $assignment->progress_percentage }}%</small>
                                    </td>
                                    <td>
                                        @switch($assignment->status)
                                            @case('completed') <span class="badge badge-success">Selesai</span> @break
                                            @case('overdue') <span class="badge badge-danger">Terlambat</span> @break
                                            @case('in_progress') <span class="badge badge-warning">Proses</span> @break
                                            @default <span class="badge badge-secondary">{{ ucfirst($assignment->status) }}</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        <a href="{{ route('task-assignments.show', $assignment->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada penugasan</p>
                        <a href="{{ route('task-assignments.create') }}?job_responsibility_id={{ $responsibility->id }}"
                           class="btn btn-primary btn-sm">Buat Penugasan</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6">
                        <a href="{{ route('positions.show', $responsibility->position_id) }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-sitemap"></i> Lihat Jabatan
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('job-responsibilities.by-position', $responsibility->position_id) }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-list"></i> Tugas Lain
                        </a>
                    </div>
                    <div class="col-12 mt-2">
                        <button type="button" class="btn btn-outline-danger w-100" onclick="confirmDelete({{ $responsibility->id }}, '{{ addslashes($responsibility->task_name) }}')">
                            <i class="fas fa-trash"></i> Hapus Tugas Ini
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus tugas <strong id="deleteName"></strong>?</p>
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
    document.getElementById('deleteForm').action = '/job-responsibilities/' + id;
    $('#deleteModal').modal('show');
}
</script>
@endpush
