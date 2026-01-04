@extends('layouts.app')

@section('title', 'Data Posisi/Jabatan')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Posisi/Jabatan</h1>
    <a href="{{ route('positions.create') }}" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tambah Posisi</span>
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Posisi/Jabatan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Posisi</th>
                        <th>Level</th>
                        <th>Parent</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($positions as $index => $position)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $position->name }}</td>
                        <td>
                            @if($position->level == 'leadership')
                                <span class="badge badge-danger">Pimpinan</span>
                            @elseif($position->level == 'member')
                                <span class="badge badge-info">Anggota</span>
                            @else
                                <span class="badge badge-secondary">Staf</span>
                            @endif
                        </td>
                        <td>{{ $position->parent->name ?? '-' }}</td>
                        <td>
                            @if($position->status == 'active')
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>{{ $position->order }}</td>
                        <td>
                            <a href="{{ route('positions.show', $position->id) }}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('positions.edit', $position->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('positions.destroy', $position->id) }}" method="POST" style="display:inline;">
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
                        <td colspan="7" class="text-center">Tidak ada data posisi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

