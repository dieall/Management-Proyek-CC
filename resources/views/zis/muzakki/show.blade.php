@extends('layouts.app')

@section('title', 'Detail Muzakki')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Muzakki</h1>
    <a href="{{ route('muzakki.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <!-- Info Muzakki -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Muzakki</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="150"><strong>Nama</strong></td>
                        <td>: {{ $muzakki->nama }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat</strong></td>
                        <td>: {{ $muzakki->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>No HP</strong></td>
                        <td>: {{ $muzakki->no_hp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>: 
                            @if($muzakki->status_pendaftaran == 'disetujui')
                                <span class="badge badge-success">Disetujui</span>
                            @elseif($muzakki->status_pendaftaran == 'menunggu')
                                <span class="badge badge-warning">Menunggu</span>
                            @else
                                <span class="badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Daftar</strong></td>
                        <td>: {{ $muzakki->tgl_daftar->format('d F Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Statistik ZIS -->
    <div class="col-lg-6">
        <div class="card shadow mb-4 border-left-success">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Statistik ZIS</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Total ZIS</small>
                    <h3 class="text-success">Rp {{ number_format($totalZIS, 0, ',', '.') }}</h3>
                </div>
                <hr>
                <div class="mb-2">
                    <i class="fas fa-mosque text-primary"></i>
                    <strong>Zakat:</strong> Rp {{ number_format($totalZakat, 0, ',', '.') }}
                </div>
                <div class="mb-2">
                    <i class="fas fa-hand-holding-heart text-success"></i>
                    <strong>Infaq:</strong> Rp {{ number_format($totalInfaq, 0, ',', '.') }}
                </div>
                <div class="mb-2">
                    <i class="fas fa-donate text-warning"></i>
                    <strong>Shadaqah:</strong> Rp {{ number_format($totalShadaqah, 0, ',', '.') }}
                </div>
                <div>
                    <i class="fas fa-landmark text-info"></i>
                    <strong>Wakaf:</strong> Rp {{ number_format($totalWakaf, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat ZIS -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat ZIS Masuk</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis ZIS</th>
                        <th>Sub Jenis</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($muzakki->zisMasuk as $index => $zis)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $zis->tgl_masuk ? $zis->tgl_masuk->format('d/m/Y') : '-' }}</td>
                        <td>
                            <span class="badge badge-{{ $zis->jenis_zis == 'zakat' ? 'primary' : ($zis->jenis_zis == 'infaq' ? 'success' : ($zis->jenis_zis == 'shadaqah' ? 'warning' : 'info')) }}">
                                {{ ucfirst($zis->jenis_zis) }}
                            </span>
                        </td>
                        <td>{{ $zis->sub_jenis_zis ?? '-' }}</td>
                        <td>Rp {{ number_format($zis->jumlah, 0, ',', '.') }}</td>
                        <td>{{ $zis->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada riwayat ZIS</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection



