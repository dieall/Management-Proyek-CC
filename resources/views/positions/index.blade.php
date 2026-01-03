@extends('layouts.app')

@section('title', 'Data Jabatan')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Jabatan</h1>
    <div>
        <a href="{{ route('positions.create') }}" class="btn btn-primary shadow-sm mr-2">
            <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Jabatan
        </a>
        <a href="{{ route('positions.index', ['view' => 'tree']) }}" class="btn btn-info shadow-sm">
            <i class="fas fa-project-diagram fa-sm text-white-50"></i> Tampilan Pohon
        </a>
    </div>
</div>

<!-- Filter Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('positions.index') }}">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Nama jabatan atau deskripsi..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <select name="level" class="form-select">
                        <option value="">Semua Level</option>
                        <option value="leadership" {{ request('level') == 'leadership' ? 'selected' : '' }}>Kepemimpinan</option>
                        <option value="division_head" {{ request('level') == 'division_head' ? 'selected' : '' }}>Kepala Divisi</option>
                        <option value="staff" {{ request('level') == 'staff' ? 'selected' : '' }}>Staf</option>
                        <option value="volunteer" {{ request('level') == 'volunteer' ? 'selected' : '' }}>Relawan</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <a href="{{ route('positions.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-redo"></i> Reset Filter
            </a>
        </form>
    </div>
</div>

<!-- Table Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Jabatan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Jabatan</th>
                        <th>Atasan</th>
                        <th>Level</th>
                        <th>Status</th>
                        <th>Statistik</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($positions as $position)
                        <tr>
                            <td>{{ $loop->iteration + ($positions->currentPage() - 1) * $positions->perPage() }}</td>
                            <td>
                                <strong>{{ $position->name }}</strong><br>
                                @if($position->description)
                                    <small class="text-muted">{{ Str::limit($position->description, 60) }}</small>
                                @endif
                            </td>
                            <td>
                                @if($position->parent)
                                    <span class="badge badge-pill badge-info">{{ $position->parent->name }}</span>
                                @else
                                    <span class="text-muted">Root</span>
                                @endif
                            </td>
                            <td>
                                @switch($position->level)
                                    @case('leadership') <span class="badge badge-danger">Kepemimpinan</span> @break
                                    @case('division_head') <span class="badge badge-warning">Kepala Divisi</span> @break
                                    @case('staff') <span class="badge badge-primary">Staf</span> @break
                                    @default <span class="badge badge-secondary">Relawan</span>
                                @endswitch
                            </td>
                            <td>
                                @if($position->status == 'active')
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <span class="badge badge-info" title="Pengurus">
                                        <i class="fas fa-users"></i> {{ $position->committees_count }}
                                    </span>
                                    <span class="badge badge-warning" title="Tugas">
                                        <i class="fas fa-tasks"></i> {{ $position->responsibilities_count }}
                                    </span>
                                    <span class="badge badge-secondary" title="Sub-jabatan">
                                        <i class="fas fa-sitemap"></i> {{ $position->children_count }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('positions.show', $position->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('positions.edit', $position->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $position->id }}, '{{ addslashes($position->name) }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-sitemap fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data jabatan</p>
                                <a href="{{ route('positions.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Jabatan Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($positions->hasPages())
            <div class="d-flex justify-content-between mt-4">
                <div class="text-muted">
                    Menampilkan {{ $positions->firstItem() }} - {{ $positions->lastItem() }} dari {{ $positions->total() }} jabatan
                </div>
                <div>
                    {{ $positions->links('vendor.pagination.bootstrap-4') }}
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
                <h5 class="modal-title">Konfirmasi Hapus Jabatan</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Yakin ingin menghapus jabatan <strong id="deleteName"></strong>?</p>
                <p class="text-danger"><small>Jabatan dengan pengurus atau sub-jabatan tidak dapat dihapus.</small></p>
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
    document.getElementById('deleteForm').action = '/positions/' + id;
    $('#deleteModal').modal('show');
}
</script>
@endpush
