@extends('layouts.app')

@section('title', 'Detail Mustahik')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Mustahik</h1>
    <a href="{{ route('mustahik.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <!-- Info Mustahik -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Mustahik</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="180"><strong>Nama</strong></td>
                        <td>: {{ $mustahik->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat</strong></td>
                        <td>: {{ $mustahik->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Kategori</strong></td>
                        <td>: <span class="badge badge-info">{{ ucwords($mustahik->kategori_mustahik ?? '-') }}</span></td>
                    </tr>
                    <tr>
                        <td><strong>No HP</strong></td>
                        <td>: {{ $mustahik->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status Verifikasi</strong></td>
                        <td>: 
                            @if($mustahik->status_verifikasi == 'disetujui')
                                <span class="badge badge-success">Disetujui</span>
                            @elseif($mustahik->status_verifikasi == 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>: 
                            @if($mustahik->status == 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Non-Aktif</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Surat DTKS</strong></td>
                        <td>: 
                            @if($mustahik->surat_dtks)
                                <a href="{{ Storage::url($mustahik->surat_dtks) }}" target="_blank" class="btn btn-sm btn-info">
                                    <i class="fas fa-file"></i> Lihat File
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Daftar</strong></td>
                        <td>: {{ $mustahik->tgl_daftar->format('d F Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Statistik Penerimaan -->
    <div class="col-lg-6">
        <div class="card shadow mb-4 border-left-success">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Statistik Penerimaan</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Total Penerimaan</small>
                    <h3 class="text-success">Rp {{ number_format($totalPenerimaan, 0, ',', '.') }}</h3>
                </div>
                <hr>
                <div class="mb-2">
                    <i class="fas fa-hand-holding-usd text-primary"></i>
                    <strong>Jumlah Penyaluran:</strong> {{ $jumlahPenyaluran }} kali
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Penerimaan -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Penerimaan ZIS</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Dari Muzakki</th>
                        <th>Jenis ZIS</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mustahik->penyaluran as $index => $penyaluran)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $penyaluran->tgl_salur ? $penyaluran->tgl_salur->format('d/m/Y') : '-' }}</td>
                        <td>{{ $penyaluran->zisMasuk->muzakki->nama ?? '-' }}</td>
                        <td>
                            <span class="badge badge-{{ $penyaluran->zisMasuk->jenis_zis == 'zakat' ? 'primary' : ($penyaluran->zisMasuk->jenis_zis == 'infaq' ? 'success' : ($penyaluran->zisMasuk->jenis_zis == 'shadaqah' ? 'warning' : 'info')) }}">
                                {{ ucfirst($penyaluran->zisMasuk->jenis_zis ?? '-') }}
                            </span>
                        </td>
                        <td>Rp {{ number_format($penyaluran->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $penyaluran->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada riwayat penerimaan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection









