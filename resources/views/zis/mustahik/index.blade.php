@extends('layouts.app')

@section('title', 'Data Mustahik')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Mustahik (Penerima Zakat)</h1>
    <a href="{{ route('mustahik.create') }}" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tambah Mustahik</span>
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Mustahik</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>No HP</th>
                        <th>Status Verifikasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mustahiks as $index => $mustahik)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $mustahik->nama }}</td>
                        <td>
                            <span class="badge badge-info">{{ ucwords($mustahik->kategori_mustahik ?? '-') }}</span>
                        </td>
                        <td>{{ $mustahik->no_hp ?? '-' }}</td>
                        <td>
                            @if($mustahik->status_verifikasi == 'disetujui')
                                <span class="badge badge-success">Disetujui</span>
                            @elseif($mustahik->status_verifikasi == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            @if($mustahik->status == 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Non-Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('mustahik.show', $mustahik->id_mustahik) }}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('mustahik.edit', $mustahik->id_mustahik) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('mustahik.destroy', $mustahik->id_mustahik) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada data mustahik</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection



