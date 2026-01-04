@extends('layouts.app')

@section('title', 'Detail Laporan Perawatan')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Laporan Perawatan</h1>
    <div>
        <a href="{{ route('laporan-perawatan.edit', $laporan->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('laporan-perawatan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card shadow mb-4 h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Laporan</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless mb-0">
                    <tr>
                        <th width="35%">Aset</th>
                        <td>: {{ $laporan->aset->nama_aset }} ({{ $laporan->aset->kode_aset }})</td>
                    </tr>
                    @if($laporan->jadwalPerawatan)
                    <tr>
                        <th>Jadwal Perawatan</th>
                        <td>: {{ $laporan->jadwalPerawatan->jenis_perawatan }} - {{ $laporan->jadwalPerawatan->tanggal_jadwal->format('d/m/Y') }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Tanggal Pemeriksaan</th>
                        <td>: {{ $laporan->tanggal_pemeriksaan->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <th>Pengurus</th>
                        <td>: {{ $laporan->user->name }}</td>
                    </tr>
                    <tr>
                        <th>Kondisi Sebelum</th>
                        <td>:
                            <span class="badge badge-{{ $laporan->kondisi_sebelum === 'baik' ? 'success' : 'warning' }}">
                                {{ ucfirst(str_replace('_', ' ', $laporan->kondisi_sebelum)) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Kondisi Sesudah</th>
                        <td>:
                            <span class="badge badge-{{ $laporan->kondisi_sesudah === 'baik' ? 'success' : 'warning' }}">
                                {{ ucfirst(str_replace('_', ' ', $laporan->kondisi_sesudah)) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Hasil Pemeriksaan</th>
                        <td>: {{ $laporan->hasil_pemeriksaan }}</td>
                    </tr>
                    @if($laporan->tindakan)
                    <tr>
                        <th>Tindakan</th>
                        <td>: {{ $laporan->tindakan }}</td>
                    </tr>
                    @endif
                    @if($laporan->biaya_perawatan)
                    <tr>
                        <th>Biaya Perawatan</th>
                        <td>: Rp {{ number_format($laporan->biaya_perawatan, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card shadow mb-4 h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Dokumentasi</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    @if($laporan->foto_sebelum)
                    <div class="col-sm-12 col-md-6 mb-3 d-flex flex-column">
                        <h6>Foto Sebelum</h6>
                        @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($laporan->foto_sebelum))
                            <div class="border rounded p-2 text-center">
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($laporan->foto_sebelum) }}" alt="Foto Sebelum" class="img-fluid" style="max-height: 280px; object-fit: contain;">
                            </div>
                        @else
                            <div class="text-muted small">File tidak ditemukan di storage/app/public/{{ $laporan->foto_sebelum }}</div>
                        @endif
                    </div>
                    @endif

                    @if($laporan->foto_sesudah)
                    <div class="col-sm-12 col-md-6 mb-3 d-flex flex-column">
                        <h6>Foto Sesudah</h6>
                        @if(\Illuminate\Support\Facades\Storage::disk('public')->exists($laporan->foto_sesudah))
                            <div class="border rounded p-2 text-center">
                                <img src="{{ \Illuminate\Support\Facades\Storage::url($laporan->foto_sesudah) }}" alt="Foto Sesudah" class="img-fluid" style="max-height: 280px; object-fit: contain;">
                            </div>
                        @else
                            <div class="text-muted small">File tidak ditemukan di storage/app/public/{{ $laporan->foto_sesudah }}</div>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



