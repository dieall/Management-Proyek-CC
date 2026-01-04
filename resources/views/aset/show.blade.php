@extends('layouts.app')

@section('title', 'Detail Aset')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Aset</h1>
    <div>
        @if($user->isAdmin())
        <a href="{{ route('aset.edit', $aset->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        @endif
        <a href="{{ route('aset.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row align-items-stretch">
    <div class="col-lg-8">
        <div class="card shadow mb-4 h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Aset</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="40%">Kode Aset</th>
                                <td>: {{ $aset->kode_aset }}</td>
                            </tr>
                            <tr>
                                <th>Nama Aset</th>
                                <td>: {{ $aset->nama_aset }}</td>
                            </tr>
                            <tr>
                                <th>Jenis Aset</th>
                                <td>: {{ $aset->jenis_aset }}</td>
                            </tr>
                            <tr>
                                <th>Kondisi</th>
                                <td>:
                                    <span class="badge badge-{{ $aset->kondisi === 'baik' ? 'success' : ($aset->kondisi === 'rusak_ringan' ? 'warning' : 'danger') }}">
                                        {{ ucfirst(str_replace('_', ' ', $aset->kondisi)) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Lokasi</th>
                                <td>: {{ $aset->lokasi ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Sumber Perolehan</th>
                                <td>: {{ ucfirst($aset->sumber_perolehan) }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            @if($user->isAdmin())
                            @if($aset->sumber_perolehan === 'pembelian')
                            <tr>
                                <th width="40%">Harga</th>
                                <td>: Rp {{ number_format($aset->harga ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Vendor</th>
                                <td>: {{ $aset->vendor ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Pembelian</th>
                                <td>: {{ $aset->tanggal_pembelian ? $aset->tanggal_pembelian->format('d/m/Y') : '-' }}</td>
                            </tr>
                            @else
                            <tr>
                                <th width="40%">Nilai Donasi</th>
                                <td>: Rp {{ number_format($aset->nilai_donasi ?? 0, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <th>Donatur</th>
                                <td>: {{ $aset->donatur ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Donasi</th>
                                <td>: {{ $aset->tanggal_donasi ? $aset->tanggal_donasi->format('d/m/Y') : '-' }}</td>
                            </tr>
                            @endif
                            @endif
                            <tr>
                                <th>Status</th>
                                <td>:
                                    @if($aset->is_archived)
                                        <span class="badge badge-secondary">Di-Archive</span>
                                    @else
                                        <span class="badge badge-success">Aktif</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                @if($aset->deskripsi)
                <div class="mt-3">
                    <h6>Deskripsi</h6>
                    <p>{{ $aset->deskripsi }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow mb-4 h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Foto</h6>
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                @if($aset->foto && \Illuminate\Support\Facades\Storage::disk('public')->exists($aset->foto))
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($aset->foto) }}" alt="Foto Aset" class="img-fluid" style="max-height: 380px; object-fit: contain;">
                @elseif($aset->foto)
                    <div class="text-center">
                        <img src="https://via.placeholder.com/400x300?text=Foto+tidak+ditemukan" alt="Foto Aset" class="img-fluid mb-2" style="max-height: 260px; object-fit: contain;">
                        <div class="text-muted small">File tidak ditemukan di storage. Pastikan ada di <code>storage/app/public/{{ $aset->foto }}</code>.</div>
                    </div>
                @else
                    <span class="text-muted">Tidak ada foto</span>
                @endif
            </div>
        </div>
    </div>
</div>
<br>
<!-- Jadwal Perawatan -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Jadwal Perawatan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis Perawatan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwalPerawatan as $jadwal)
                    <tr>
                        <td>{{ $jadwal->tanggal_jadwal->format('d/m/Y') }}</td>
                        <td>{{ $jadwal->jenis_perawatan }}</td>
                        <td>
                            <span class="badge badge-{{ $jadwal->status === 'selesai' ? 'success' : ($jadwal->status === 'terjadwal' ? 'info' : 'warning') }}">
                                {{ ucfirst(str_replace('_', ' ', $jadwal->status)) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('jadwal-perawatan.show', $jadwal->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada jadwal perawatan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Laporan Perawatan -->
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
                        <th>Hasil</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporanPerawatan as $laporan)
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
                        <td>{{ Str::limit($laporan->hasil_pemeriksaan, 50) }}</td>
                        <td>
                            <a href="{{ route('laporan-perawatan.show', $laporan->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada laporan perawatan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection



