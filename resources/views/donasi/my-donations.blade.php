@extends('layouts.app')

@section('title', 'Riwayat Donasi Saya')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Riwayat Donasi Saya</h1>
    <a href="{{ route('donasi.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<!-- Total Donasi Card -->
<div class="row mb-4">
    <div class="col-xl-4 col-md-6">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Donasi Saya
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalDonasi, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hand-holding-heart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Donasi -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Detail Riwayat Donasi</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Program Donasi</th>
                        <th>Jumlah Donasi</th>
                        <th>Tanggal Donasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatDonasi as $index => $riwayat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $riwayat->nama_donasi }}</td>
                        <td>Rp {{ number_format($riwayat->besar_donasi, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($riwayat->tanggal_donasi)->format('d F Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            <div class="py-4">
                                <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                                <p class="text-muted">Anda belum memiliki riwayat donasi</p>
                                <a href="{{ route('donasi.index') }}" class="btn btn-primary">
                                    <i class="fas fa-donate"></i> Donasi Sekarang
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($riwayatDonasi->count() > 0)
                <tfoot>
                    <tr>
                        <th colspan="2" class="text-right">TOTAL:</th>
                        <th colspan="2">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>

<!-- Informasi -->
<div class="alert alert-info">
    <i class="fas fa-info-circle"></i>
    <strong>Informasi:</strong> Donasi Anda sangat berarti untuk kemakmuran masjid. Jazakumullahu khairan katsiran.
</div>
@endsection

