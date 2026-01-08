@extends('layouts.app')

@section('title', 'Laporan Perawatan')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Laporan Perawatan</h1>
    <div class="btn-group">
        <a href="{{ route('laporan-perawatan.pdf') }}" target="_blank" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
        <button type="button" onclick="window.print()" class="btn btn-secondary">
            <i class="fas fa-print"></i> Print
        </button>
        <a href="{{ route('laporan-perawatan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Laporan
        </a>
    </div>
</div>  

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Laporan Perawatan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Aset</th>
                        <th>Tanggal</th>
                        <th>Kondisi Sebelum</th>
                        <th>Kondisi Sesudah</th>
                        <th>Pengurus</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $item)
                    <tr>
                        <td>{{ $item->aset->nama_aset }}</td>
                        <td>{{ $item->tanggal_pemeriksaan->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge badge-{{ $item->kondisi_sebelum === 'baik' ? 'success' : 'warning' }}">
                                {{ ucfirst(str_replace('_', ' ', $item->kondisi_sebelum)) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $item->kondisi_sesudah === 'baik' ? 'success' : 'warning' }}">
                                {{ ucfirst(str_replace('_', ' ', $item->kondisi_sesudah)) }}
                            </span>
                        </td>
                        <td>{{ $item->user->name }}</td>
                        <td>
                            <a href="{{ route('laporan-perawatan.show', $item->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('laporan-perawatan.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('laporan-perawatan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus laporan ini?')">
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
                        <td colspan="6" class="text-center">Tidak ada data</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $laporan->links() }}
        </div>
    </div>
</div>
@endsection
























