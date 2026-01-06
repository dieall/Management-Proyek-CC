@extends('layouts.app')

@section('title', 'Riwayat Kurban Saya')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Riwayat Kurban Saya</h1>
    <a href="{{ route('kurban.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<!-- Statistik -->
<div class="row mb-4">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Pembayaran
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalPembayaran, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Hewan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalHewan }} Ekor
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cow fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Program Kurban
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $riwayatKurban->count() }} Program
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Riwayat -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Kurban yang Saya Daftarkan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Program Kurban</th>
                        <th>Tanggal Kurban</th>
                        <th>Jenis Hewan</th>
                        <th>Jenis Pembayaran</th>
                        <th>Jumlah Hewan</th>
                        <th>Jumlah Pembayaran</th>
                        <th>Status Pembayaran</th>
                        <th>Tanggal Pembayaran</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatKurban as $index => $riwayat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $riwayat->nama_kurban }}</td>
                        <td>{{ \Carbon\Carbon::parse($riwayat->tanggal_kurban)->format('d/m/Y') }}</td>
                        <td>{{ ucfirst($riwayat->jenis_hewan) }}</td>
                        <td>
                            @if($riwayat->jenis_pembayaran == 'penuh')
                                <span class="badge badge-success">Penuh</span>
                            @else
                                <span class="badge badge-info">Patungan</span>
                            @endif
                        </td>
                        <td>{{ $riwayat->jumlah_hewan }} Ekor</td>
                        <td>Rp {{ number_format($riwayat->jumlah_pembayaran, 0, ',', '.') }}</td>
                        <td>
                            @if($riwayat->status_pembayaran == 'lunas')
                                <span class="badge badge-success">Lunas</span>
                            @elseif($riwayat->status_pembayaran == 'cicilan')
                                <span class="badge badge-warning">Cicilan</span>
                            @else
                                <span class="badge badge-danger">Belum Lunas</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($riwayat->tanggal_pembayaran)->format('d/m/Y') }}</td>
                        <td>{{ $riwayat->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">Anda belum mendaftar di program kurban manapun.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

