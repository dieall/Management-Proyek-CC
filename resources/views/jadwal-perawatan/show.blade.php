@extends('layouts.app')

@section('title', 'Detail Jadwal Perawatan')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Jadwal Perawatan</h1>
    <div>
        <a href="{{ route('jadwal-perawatan.edit', $jadwal->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('jadwal-perawatan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Informasi Jadwal</h6>
    </div>
    <div class="card-body">
        <table class="table table-borderless">
            <tr>
                <th width="30%">Aset</th>
                <td>: {{ $jadwal->aset->nama_aset }} ({{ $jadwal->aset->kode_aset }})</td>
            </tr>
            <tr>
                <th>Jenis Perawatan</th>
                <td>: {{ $jadwal->jenis_perawatan }}</td>
            </tr>
            <tr>
                <th>Tanggal Jadwal</th>
                <td>: {{ $jadwal->tanggal_jadwal->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>: 
                    <span class="badge badge-{{ $jadwal->status === 'selesai' ? 'success' : ($jadwal->status === 'terjadwal' ? 'info' : 'warning') }}">
                        {{ ucfirst(str_replace('_', ' ', $jadwal->status)) }}
                    </span>
                </td>
            </tr>
            @if($jadwal->deskripsi)
            <tr>
                <th>Deskripsi</th>
                <td>: {{ $jadwal->deskripsi }}</td>
            </tr>
            @endif
        </table>
    </div>
</div>

@if($jadwal->laporanPerawatan->count() > 0)
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Laporan Perawatan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Kondisi Sebelum</th>
                        <th>Kondisi Sesudah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwal->laporanPerawatan as $laporan)
                    <tr>
                        <td>{{ $laporan->tanggal_pemeriksaan->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge badge-{{ $laporan->kondisi_sebelum === 'baik' ? 'success' : 'warning' }}">
                                {{ ucfirst(str_replace('_', ' ', $laporan->kondisi_sebelum)) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $laporan->kondisi_sesudah === 'baik' ? 'success' : 'warning' }}">
                                {{ ucfirst(str_replace('_', ' ', $laporan->kondisi_sesudah)) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('laporan-perawatan.show', $laporan->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection
























