@extends('layouts.app')

@section('title', 'Detail Penugasan - #' . $assignment->id)

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Detail Penugasan</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('task-assignments.index') }}">Penugasan</a></li>
            <li class="breadcrumb-item active">#{{ $assignment->id }}</li>
        </ol>
    </div>
    <div>
        <a href="{{ route('task-assignments.edit', $assignment->id) }}" class="btn btn-warning shadow-sm mr-2">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('task-assignments.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <!-- Left: Main Info -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Penugasan</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>{{ $assignment->jobResponsibility->task_name }}</h5>
                        <p class="text-muted mb-3">
                            @if($assignment->jobResponsibility->position)
                                <i class="fas fa-sitemap"></i> {{ $assignment->jobResponsibility->position->name }}
                            @endif
                        </p>

                        <h6 class="text-muted">Pengurus</h6>
                        <div class="d-flex align-items-center mb-4">
                            <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-user fa-2x text-white"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="mb-1">{{ $assignment->committee->full_name }}</h5>
                                <p class="mb-0 text-muted">{{ $assignment->committee->position->name ?? 'Tidak ada jabatan' }}</p>
                            </div>
                        </div>

                        <h6 class="text-muted">Timeline</h6>
                        <ul class="timeline">
                            <li>
                                <strong>Penugasan:</strong> {{ $assignment->assigned_date->format('d F Y') }}
                            </li>
                            <li class="{{ $assignment->is_overdue ? 'text-danger' : '' }}">
                                <strong>Deadline:</strong> {{ $assignment->due_date->format('d F Y') }}
                                @if($assignment->is_overdue)
                                    <span class="badge badge-danger ms-2">Terlambat</span>
                                @endif
                            </li>
                            @if($assignment->completed_date)
                            <li class="text-success">
                                <strong>Selesai:</strong> {{ $assignment->completed_date->format('d F Y') }}
                            </li>
                            @endif
                        </ul>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-muted">Progress</h6>
                        <div class="progress mb-2" style="height: 30px;">
                            <div class="progress-bar bg-{{ $assignment->progress_percentage == 100 ? 'success' : 'info' }} progress-bar-striped"
                                 style="width: {{ $assignment->progress_percentage }}%">
                                <strong>{{ $assignment->progress_percentage }}%</strong>
                            </div>
                        </div>

                        <h6 class="text-muted mt-4">Status</h6>
                        <div>
                            @switch($assignment->status)
                                @case('completed') <span class="badge badge-success badge-pill px-4 py-2">Selesai</span> @break
                                @case('in_progress') <span class="badge badge-warning badge-pill px-4 py-2">Dalam Proses</span> @break
                                @case('pending') <span class="badge badge-info badge-pill px-4 py-2">Pending</span> @break
                                @case('overdue') <span class="badge badge-danger badge-pill px-4 py-2">Terlambat</span> @break
                                @default <span class="badge badge-secondary badge-pill px-4 py-2">Dibatalkan</span>
                            @endswitch
                        </div>

                        @if($assignment->approved_by)
                        <div class="mt-4">
                            <h6 class="text-success"><i class="fas fa-check-circle"></i> Disetujui</h6>
                            <p class="mb-0">Oleh: <strong>{{ $assignment->approver->full_name }}</strong><br>
                            Pada: {{ $assignment->approved_at->format('d F Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                @if($assignment->notes)
                <hr>
                <h6 class="text-muted">Catatan</h6>
                <div class="card bg-light">
                    <div class="card-body">
                        <p class="mb-0">{{ $assignment->notes }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Progress Update -->
        @if(!in_array($assignment->status, ['completed', 'cancelled']))
        <div class="card shadow mb-4 border-left-primary">
            <div class="card-header py-3 bg-primary text-white">
                <h6 class="m-0 font-weight-bold">Update Progress</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('task-assignments.update-progress', $assignment->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <label class="form-label">Progress (%)</label>
                            <input type="range" class="form-range" name="progress_percentage"
                                   min="0" max="100" step="5" value="{{ $assignment->progress_percentage }}"
                                   oninput="this.nextElementSibling.value = this.value + '%'">
                            <output class="d-block text-center fw-bold">{{ $assignment->progress_percentage }}%</output>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Catatan Update</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Tambahkan catatan...">{{ $assignment->notes }}</textarea>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>

    <!-- Right: Task Info & Actions -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Detail Tugas</h6>
            </div>
            <div class="card-body">
                <p><strong>Prioritas:</strong><br>
                    @switch($assignment->jobResponsibility->priority)
                        @case('critical') <span class="badge badge-danger">Kritis</span> @break
                        @case('high') <span class="badge badge-warning">Tinggi</span> @break
                        @case('medium') <span class="badge badge-info">Sedang</span> @break
                        @default <span class="badge badge-secondary">Rendah</span>
                    @endswitch
                </p>
                <p><strong>Deskripsi:</strong><br>
                    {{ $assignment->jobResponsibility->task_description ?? '<em class="text-muted">Tidak ada deskripsi</em>' }}
                </p>
                <hr>
                <a href="{{ route('job-responsibilities.show', $assignment->job_responsibility_id) }}" class="btn btn-info btn-sm w-100">
                    <i class="fas fa-tasks"></i> Lihat Detail Tugas
                </a>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($assignment->status == 'completed' && !$assignment->approved_by)
                        <button class="btn btn-success" data-toggle="modal" data-target="#approveModal">
                            <i class="fas fa-check"></i> Setujui Tugas
                        </button>
                    @endif
                    @if(!in_array($assignment->status, ['completed', 'cancelled']))
                        <a href="{{ route('task-assignments.edit', $assignment->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Penugasan
                        </a>
                    @endif
                    <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                        <i class="fas fa-trash"></i> Hapus Penugasan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approval Modal -->
@if($assignment->status == 'completed' && !$assignment->approved_by)
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('task-assignments.approve', $assignment->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Setujui Penugasan</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Disetujui Oleh</label>
                        <select name="approver_id" class="form-select" required>
                            <option value="">Pilih Pengurus</option>
                            @foreach($committees as $c)
                                @if($c->id != $assignment->committee_id)
                                    <option value="{{ $c->id }}">{{ $c->full_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan Persetujuan</label>
                        <textarea name="notes" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Setujui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus penugasan ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form action="{{ route('task-assignments.destroy', $assignment->id) }}" method="POST" style="display:inline;">
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
function confirmDelete() {
    $('#deleteModal').modal('show');
}
</script>
<style>
.timeline { position: relative; padding-left: 30px; }
.timeline::before { content: ''; position: absolute; left: 15px; top: 0; bottom: 0; width: 2px; background: #e3e6f0; }
.timeline li { position: relative; margin-bottom: 15px; }
.timeline li::before { content: ''; position: absolute; left: -30px; width: 12px; height: 12px; background: #4e73df; border-radius: 50%; border: 3px solid #fff; box-shadow: 0 0 0 3px #4e73df; }
</style>
@endpush
