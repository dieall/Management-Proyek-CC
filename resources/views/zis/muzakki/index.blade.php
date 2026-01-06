@extends('layouts.app')

@section('title', 'Data Muzakki')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Data Muzakki (Pemberi Zakat)</h1>
    <a href="{{ route('muzakki.create') }}" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tambah Muzakki</span>
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Muzakki</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No HP</th>
                        <th>Status</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($muzakkis as $index => $muzakki)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $muzakki->nama }}</td>
                        <td>{{ $muzakki->alamat ?? '-' }}</td>
                        <td>{{ $muzakki->no_hp ?? '-' }}</td>
                        <td>
                            @if($muzakki->status_pendaftaran == 'disetujui')
                                <span class="badge badge-success">Disetujui</span>
                            @elseif($muzakki->status_pendaftaran == 'menunggu')
                                <span class="badge badge-warning">Menunggu</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>{{ $muzakki->tgl_daftar->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('muzakki.show', $muzakki->id_muzakki) }}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('muzakki.edit', $muzakki->id_muzakki) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($muzakki->status_pendaftaran == 'menunggu')
                                    <form action="{{ route('muzakki.approve', $muzakki->id_muzakki) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('muzakki.reject', $muzakki->id_muzakki) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('muzakki.destroy', $muzakki->id_muzakki) }}" method="POST" style="display:inline;">
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
                        <td colspan="7" class="text-center">Belum ada data muzakki</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection










