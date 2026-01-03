@extends('layouts.app')

@section('title', 'Data Pengurus')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Pengurus</h1>
    <a href="{{ route('committees.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Pengurus
    </a>
</div>

<!-- Filter Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('committees.index') }}" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari nama, email, atau telepon..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="resigned" {{ request('status') == 'resigned' ? 'selected' : '' }}>Mengundurkan Diri</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="position_id" class="form-select">
                    <option value="">Semua Jabatan</option>
                    @foreach($positions as $position)
                        <option value="{{ $position->id }}" {{ request('position_id') == $position->id ? 'selected' : '' }}>
                            {{ $position->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="gender" class="form-select">
                    <option value="">Semua Gender</option>
                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="col-12">
                <a href="{{ route('committees.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-redo"></i> Reset Filter
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Data Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Pengurus</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Lengkap</th>
                        <th>Jabatan</th>
                        <th>Kontak</th>
                        <th>Status</th>
                        <th>Bergabung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($committees as $committee)
                        <tr>
                            <td>{{ $loop->iteration + ($committees->currentPage() - 1) * $committees->perPage() }}</td>
                            <td>
                                <strong>{{ $committee->full_name }}</strong><br>
                                <small class="text-muted">
                                    <i class="fas fa-{{ $committee->gender == 'male' ? 'mars' : 'venus' }}"></i>
                                    {{ $committee->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}
                                </small>
                            </td>
                            <td>
                                @if($committee->position)
                                    <span class="badge badge-pill badge-info">{{ $committee->position->name }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($committee->email)
                                    <div><i class="fas fa-envelope text-primary"></i> {{ $committee->email }}</div>
                                @endif
                                @if($committee->phone_number)
                                    <div><i class="fas fa-phone text-success"></i> {{ $committee->phone_number }}</div>
                                @endif
                            </td>
                            <td>
                                @switch($committee->active_status)
                                    @case('active')
                                        <span class="badge badge-success">Aktif</span>
                                        @break
                                    @case('inactive')
                                        <span class="badge badge-secondary">Tidak Aktif</span>
                                        @break
                                    @case('resigned')
                                        <span class="badge badge-warning">Mengundurkan Diri</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                {{ $committee->join_date->format('d/m/Y') }}<br>
                                <small class="text-muted">{{ $committee->join_date->diffForHumans() }}</small>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('committees.show', $committee->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('committees.edit', $committee->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $committee->id }}, '{{ addslashes($committee->full_name) }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data pengurus</p>
                                <a href="{{ route('committees.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Tambah Pengurus Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($committees->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <span class="text-muted">
                        Menampilkan {{ $committees->firstItem() }} sampai {{ $committees->lastItem() }} dari {{ $committees->total() }} data
                    </span>
                </div>
                <div>
                    {{ $committees->links('vendor.pagination.bootstrap-4') }}
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
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus pengurus <strong id="deleteName"></strong>?</p>
                <p class="text-danger"><small>Data yang dihapus tidak dapat dikembalikan.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="deleteForm" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus Permanen</button>
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
    document.getElementById('deleteForm').action = '/committees/' + id;
    $('#deleteModal').modal('show');
}
</script>
@endpush
