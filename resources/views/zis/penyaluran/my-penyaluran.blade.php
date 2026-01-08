@extends('layouts.app')

@section('title', 'Riwayat Penyaluran Saya')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Riwayat Penyaluran ZIS Saya</h1>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>
</div>

<!-- Info Mustahik -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Informasi Mustahik</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nama:</strong> {{ $mustahik->nama }}</p>
                <p><strong>Alamat:</strong> {{ $mustahik->alamat ?? '-' }}</p>
                <p><strong>Kategori:</strong> 
                    <span class="badge badge-info">{{ ucwords($mustahik->kategori_mustahik ?? '-') }}</span>
                </p>
            </div>
            <div class="col-md-6">
                <p><strong>No HP:</strong> {{ $mustahik->no_hp ?? '-' }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge badge-{{ $mustahik->status == 'aktif' ? 'success' : 'secondary' }}">
                        {{ ucfirst($mustahik->status) }}
                    </span>
                </p>
                <p><strong>Verifikasi:</strong> 
                    <span class="badge badge-{{ $mustahik->status_verifikasi == 'disetujui' ? 'success' : 'warning' }}">
                        {{ ucfirst($mustahik->status_verifikasi) }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Statistik -->
<div class="row mb-4">
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Diterima</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalDiterima, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hand-holding-usd fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Penyaluran</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $jumlahPenyaluran }} kali
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Penyaluran yang Saya Terima</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Dari Muzakki</th>
                        <th>Jenis ZIS</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penyaluran as $index => $data)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $data->tgl_salur ? $data->tgl_salur->format('d/m/Y') : '-' }}</td>
                        <td>{{ $data->zisMasuk->muzakki->nama ?? '-' }}</td>
                        <td>
                            <span class="badge badge-{{ $data->zisMasuk->jenis_zis == 'zakat' ? 'primary' : ($data->zisMasuk->jenis_zis == 'infaq' ? 'success' : ($data->zisMasuk->jenis_zis == 'shadaqah' ? 'warning' : 'info')) }}">
                                {{ ucfirst($data->zisMasuk->jenis_zis ?? '-') }}
                            </span>
                        </td>
                        <td><strong class="text-success">Rp {{ number_format($data->jumlah, 0, ',', '.') }}</strong></td>
                        <td>{{ $data->keterangan ?? '-' }}</td>
                        <td>
                            <a href="{{ route('penyaluran.show', $data->id_penyaluran) }}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada riwayat penyaluran</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


