@extends('layouts.app')

@section('title', 'Jadwal Perawatan')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Jadwal Perawatan</h1>
    <a href="{{ route('jadwal-perawatan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Jadwal
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Jadwal Perawatan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Aset</th>
                        <th>Jenis Perawatan</th>
                        <th>Tanggal Jadwal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwal as $item)
                    <tr>
                        <td>{{ $item->aset->nama_aset }}</td>
                        <td>{{ $item->jenis_perawatan }}</td>
                        <td>{{ $item->tanggal_jadwal->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge badge-{{ $item->status === 'selesai' ? 'success' : ($item->status === 'terjadwal' ? 'info' : 'warning') }}">
                                {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('jadwal-perawatan.show', $item->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('jadwal-perawatan.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('jadwal-perawatan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus jadwal ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $jadwal->links() }}
        </div>
    </div>
</div>
@endsection
























