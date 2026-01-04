@extends('layouts.app')

@section('title', 'Kegiatan Masjid')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kegiatan Masjid</h1>
    @if(auth()->user()->isAdmin() || auth()->user()->isDkm())
    <a href="{{ route('kegiatan.create') }}" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Tambah Kegiatan</span>
    </a>
    @endif
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Kegiatan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Status</th>
                        <th>Peserta</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatans as $index => $kegiatan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $kegiatan->nama_kegiatan }}</td>
                        <td>{{ $kegiatan->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $kegiatan->lokasi ?? '-' }}</td>
                        <td>
                            @if($kegiatan->status_kegiatan == 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @elseif($kegiatan->status_kegiatan == 'selesai')
                                <span class="badge badge-secondary">Selesai</span>
                            @else
                                <span class="badge badge-danger">Batal</span>
                            @endif
                        </td>
                        <td>{{ $kegiatan->peserta()->count() }} orang</td>
                        <td>
                            <a href="{{ route('kegiatan.show', $kegiatan->id_kegiatan) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(auth()->user()->isAdmin() || auth()->user()->isDkm())
                            <a href="{{ route('kegiatan.edit', $kegiatan->id_kegiatan) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('kegiatan.destroy', $kegiatan->id_kegiatan) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada kegiatan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

