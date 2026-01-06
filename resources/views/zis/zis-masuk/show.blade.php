@extends('layouts.app')

@section('title', 'Detail ZIS Masuk')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail ZIS Masuk</h1>
    <a href="{{ route('zis-masuk.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <!-- Info ZIS -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi ZIS</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="150"><strong>Tanggal Masuk</strong></td>
                        <td>: {{ $zisMasuk->tgl_masuk ? $zisMasuk->tgl_masuk->format('d F Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Muzakki</strong></td>
                        <td>: {{ $zisMasuk->muzakki->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jenis ZIS</strong></td>
                        <td>: 
                            <span class="badge badge-{{ $zisMasuk->jenis_zis == 'zakat' ? 'primary' : ($zisMasuk->jenis_zis == 'infaq' ? 'success' : ($zisMasuk->jenis_zis == 'shadaqah' ? 'warning' : 'info')) }}">
                                {{ ucfirst($zisMasuk->jenis_zis) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Sub Jenis</strong></td>
                        <td>: {{ $zisMasuk->sub_jenis_zis ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Jumlah</strong></td>
                        <td>: <strong class="text-success">Rp {{ number_format($zisMasuk->jumlah, 0, ',', '.') }}</strong></td>
                    </tr>
                    <tr>
                        <td><strong>Keterangan</strong></td>
                        <td>: {{ $zisMasuk->keterangan ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Status Penyaluran -->
    <div class="col-lg-6">
        <div class="card shadow mb-4 border-left-warning">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Status Penyaluran</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Total Disalurkan</small>
                    <h3 class="text-warning">Rp {{ number_format($totalDisalurkan, 0, ',', '.') }}</h3>
                </div>
                <hr>
                <div class="mb-2">
                    <i class="fas fa-coins text-success"></i>
                    <strong>Sisa Dana:</strong> Rp {{ number_format($zisMasuk->jumlah - $totalDisalurkan, 0, ',', '.') }}
                </div>
                <div class="mb-2">
                    <i class="fas fa-users text-primary"></i>
                    <strong>Jumlah Penyaluran:</strong> {{ $jumlahPenyaluran }} kali
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Penyaluran -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Penyaluran</h6>
        <a href="{{ route('penyaluran.create', ['id_zis' => $zisMasuk->id_zis]) }}" class="btn btn-sm btn-success">
            <i class="fas fa-plus"></i> Salurkan Dana
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Salur</th>
                        <th>Kepada Mustahik</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($zisMasuk->penyaluran as $index => $penyaluran)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $penyaluran->tgl_salur ? $penyaluran->tgl_salur->format('d/m/Y') : '-' }}</td>
                        <td>{{ $penyaluran->mustahik->nama ?? '-' }}</td>
                        <td>Rp {{ number_format($penyaluran->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $penyaluran->keterangan ?? '-' }}</td>
                        <td>
                            <a href="{{ route('penyaluran.show', $penyaluran->id_penyaluran) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada penyaluran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection









