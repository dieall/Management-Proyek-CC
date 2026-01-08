@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail User</h1>
    <div>
        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-edit"></i>
            </span>
            <span class="text">Edit</span>
        </a>
        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-arrow-left"></i>
            </span>
            <span class="text">Kembali</span>
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi User</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="30%">Username</th>
                        <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Nama Lengkap</th>
                        <td>{{ $user->nama_lengkap ?? $user->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>No. HP</th>
                        <td>{{ $user->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $user->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
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
                    </tr>
                    <tr>
                        <th>Status Aktif</th>
                        <td>
                            @if($user->status_aktif === 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Non-Aktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Daftar</th>
                        <td>{{ $user->tanggal_daftar ? \Carbon\Carbon::parse($user->tanggal_daftar)->format('d/m/Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Dibuat</th>
                        <td>{{ $user->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Diupdate</th>
                        <td>{{ $user->updated_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

