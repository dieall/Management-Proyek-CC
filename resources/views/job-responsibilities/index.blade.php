@extends('layouts.app')

@section('title', 'Tugas & Tanggung Jawab')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tugas & Tanggung Jawab</h1>
    <div>
        <a href="{{ route('job-responsibilities.create') }}" class="btn btn-primary shadow-sm mr-2">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Tugas
        </a>
        <a href="{{ route('job-responsibilities.statistics') }}" class="btn btn-info shadow-sm">
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
        <form method="GET" action="{{ route('job-responsibilities.index') }}">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Nama tugas, deskripsi, jabatan..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <select name="position_id" class="form-select">
                        <option value="">Semua Jabatan</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}" {{ request('position_id') == $position->id ? 'selected' : '' }}>
                                {{ $position->name }}
                            </option>
                        @endforeach
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
                    <select name="is_core" class="form-select">
                        <option value="">Jenis Tugas</option>
                        <option value="1" {{ request('is_core') == '1' ? 'selected' : '' }}>Tugas Inti</option>
                        <option value="0" {{ request('is_core') == '0' ? 'selected' : '' }}>Tambahan</option>
                    </select>
                </div>
                <div class="col-md-1 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <a href="{{ route('job-responsibilities.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-redo"></i> Reset Filter
            </a>
        </form>
    </div>
</div>

<!-- Table Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Tugas & Tanggung Jawab</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Tugas</th>
                        <th>Jabatan</th>
                        <th>Prioritas</th>
                        <th>Frekuensi</th>
                        <th>Estimasi</th>
                        <th>Penugasan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($responsibilities as $responsibility)
                        <tr>
                            <td>{{ $loop->iteration + ($responsibilities->currentPage() - 1) * $responsibilities->perPage() }}</td>
                            <td>
                                <strong>{{ $responsibility->task_name }}</strong><br>
                                @if($responsibility->task_description)
                                    <small class="text-muted">{{ Str::limit($responsibility->task_description, 60) }}</small>
                                @endif
                                @if($responsibility->is_core_responsibility)
                                    <br><span class="badge badge-success badge-pill">Tugas Inti</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('positions.show', $responsibility->position_id) }}" class="text-decoration-none">
                                    <span class="badge badge-pill badge-info">{{ $responsibility->position->name }}</span>
                                </a>
                            </td>
                            <td>
                                @switch($responsibility->priority)
                                    @case('critical') <span class="badge badge-danger">Kritis</span> @break
                                    @case('high') <span class="badge badge-warning">Tinggi</span> @break
                                    @case('medium') <span class="badge badge-info">Sedang</span> @break
                                    @default <span class="badge badge-secondary">Rendah</span>
                                @endswitch
                            </td>
                            <td>
                                @switch($responsibility->frequency)
                                    @case('daily') <span class="badge badge-dark">Harian</span> @break
                                    @case('weekly') <span class="badge badge-primary">Mingguan</span> @break
                                    @case('monthly') <span class="badge badge-info">Bulanan</span> @break
                                    @case('yearly') <span class="badge badge-warning">Tahunan</span> @break
                                    @default <span class="badge badge-secondary">Sesuai Kebutuhan</span>
                                @endswitch
                            </td>
                            <td>
                                @if($responsibility->estimated_hours)
                                    <span class="badge badge-light text-dark border">
                                        <i class="fas fa-clock"></i> {{ $responsibility->estimated_hours }} jam
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge badge-{{ $responsibility->task_assignments_count > 0 ? 'primary' : 'secondary' }}">
                                    {{ $responsibility->task_assignments_count }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('job-responsibilities.show', $responsibility->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('job-responsibilities.edit', $responsibility->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $responsibility->id }}, '{{ addslashes($responsibility->task_name) }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada tugas & tanggung jawab</p>
                                <a href="{{ route('job-responsibilities.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Tugas Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($responsibilities->hasPages())
            <div class="d-flex justify-content-between mt-4">
                <div class="text-muted">
                    Menampilkan {{ $responsibilities->firstItem() }} - {{ $responsibilities->lastItem() }} dari {{ $responsibilities->total() }} tugas
                </div>
                <div>
                    {{ $responsibilities->links('vendor.pagination.bootstrap-4') }}
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
                <h5 class="modal-title">Konfirmasi Hapus Tugas</h5>
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
