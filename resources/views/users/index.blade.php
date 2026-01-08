@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen User</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tambah User</span>
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar User</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $users->firstItem() + $index }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->nama_lengkap ?? $user->name ?? '-' }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'superadmin')
                                <span class="badge badge-danger">Super Admin</span>
                            @elseif($user->role === 'admin')
                                <span class="badge badge-warning">Admin</span>
                            @elseif($user->role === 'dkm')
                                <span class="badge badge-info">DKM</span>
                            @elseif($user->role === 'panitia')
                                <span class="badge badge-primary">Panitia</span>
                            @elseif($user->role === 'jemaah')
                                <span class="badge badge-success">Jemaah</span>
                            @elseif($user->role === 'muzakki')
                                <span class="badge badge-primary">Muzakki</span>
                            @elseif($user->role === 'mustahik')
                                <span class="badge badge-success">Mustahik</span>
                            @else
                                <span class="badge badge-secondary">User</span>
                            @endif
                        </td>
                        <td>
                            @if($user->status_aktif === 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Non-Aktif</span>
                            @endif
                        </td>
                        <td>{{ $user->tanggal_daftar ? \Carbon\Carbon::parse($user->tanggal_daftar)->format('d/m/Y') : '-' }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data user</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

