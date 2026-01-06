@extends('layouts.app')

@section('title', 'Riwayat ZIS Saya')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Riwayat ZIS Saya</h1>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>
</div>

<!-- Info Muzakki -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Informasi Muzakki</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Nama:</strong> {{ $muzakki->nama }}</p>
                <p><strong>Alamat:</strong> {{ $muzakki->alamat ?? '-' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>No HP:</strong> {{ $muzakki->no_hp ?? '-' }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge badge-{{ $muzakki->status_pendaftaran == 'disetujui' ? 'success' : 'warning' }}">
                        {{ ucfirst($muzakki->status_pendaftaran) }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Statistik -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total ZIS</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalZIS, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hand-holding-usd fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Zakat</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalZakat, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-mosque fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Infaq</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalInfaq, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hand-holding-heart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Shadaqah + Wakaf</div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalShadaqah + $totalWakaf, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-donate fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar ZIS Saya</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis ZIS</th>
                        <th>Sub Jenis</th>
                        <th>Jumlah</th>
                        <th>Status Penyaluran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($zisMasuk as $index => $zis)
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
                        <td>
                            @php
                                $totalDisalurkan = $zis->penyaluran->sum('jumlah');
                                $sisa = $zis->jumlah - $totalDisalurkan;
                            @endphp
                            @if($totalDisalurkan == 0)
                                <span class="badge badge-warning">Belum Disalurkan</span>
                            @elseif($sisa > 0)
                                <span class="badge badge-info">Sebagian Disalurkan</span>
                                <br><small class="text-muted">Rp {{ number_format($totalDisalurkan, 0, ',', '.') }} dari Rp {{ number_format($zis->jumlah, 0, ',', '.') }}</small>
                            @else
                                <span class="badge badge-success">Sudah Disalurkan</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('zis-masuk.show', $zis->id_zis) }}" class="btn btn-info btn-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada riwayat ZIS</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

