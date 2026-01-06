@extends('layouts.app')

@section('title', 'Data Pengurus')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Pengurus Masjid</h1>
    <a href="{{ route('committees.create') }}" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tambah Pengurus</span>
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Pengurus</h6>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form method="GET" action="{{ route('committees.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama/email/no HP..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="resigned" {{ request('status') == 'resigned' ? 'selected' : '' }}>Mengundurkan Diri</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="position_id" class="form-control">
                        <option value="">Semua Posisi</option>
                        @foreach($positions as $pos)
                            <option value="{{ $pos->id }}" {{ request('position_id') == $pos->id ? 'selected' : '' }}>{{ $pos->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('committees.index') }}" class="btn btn-secondary btn-block">Reset</a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Posisi</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($committees as $committee)
                    <tr>
                        <td>{{ ($committees->currentPage() - 1) * $committees->perPage() + $loop->iteration }}</td>
                        <td>{{ $committee->full_name }}</td>
                        <td>{{ $committee->position->name ?? '-' }}</td>
                        <td>{{ $committee->email ?? '-' }}</td>
                        <td>{{ $committee->phone_number ?? '-' }}</td>
                        <td>
                            @if($committee->active_status == 'active')
                                <span class="badge badge-success">Aktif</span>
                            @elseif($committee->active_status == 'inactive')
                                <span class="badge badge-secondary">Tidak Aktif</span>
                            @else
                                <span class="badge badge-danger">Mengundurkan Diri</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('committees.show', $committee->id) }}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('committees.edit', $committee->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('committees.destroy', $committee->id) }}" method="POST" style="display:inline;">
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
                        <td colspan="7" class="text-center">Tidak ada data pengurus</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $committees->links() }}
        </div>
    </div>
</div>
@endsection







