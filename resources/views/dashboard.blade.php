@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Total Events Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Events
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalEvents }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Aset Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Inventaris
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAset }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Kegiatan Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Kegiatan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalKegiatan }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Donasi Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Donasi Terkumpul
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalDonasiTerkumpul, 0, ',', '.') }}
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

<!-- Second Stats Row -->
<div class="row">
    <!-- Jadwal Perawatan Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Jadwal Perawatan
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalJadwal }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kegiatan Aktif Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Kegiatan Aktif
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kegiatanAktif }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Program Donasi Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Program Donasi
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProgramDonasi }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-gift fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Donatur Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Donatur
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDonatur }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->
<div class="row">
    <!-- Event Terdekat -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-calendar-check"></i> Event Terdekat</h6>
                <a href="{{ route('events.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($eventsTerdekat->count() > 0)
                    @foreach($eventsTerdekat as $event)
                    <div class="mb-3 pb-3 border-bottom">
                        <h6 class="font-weight-bold text-gray-800">{{ $event->nama_kegiatan }}</h6>
                        <p class="mb-1 text-sm text-muted">
                            <i class="fas fa-calendar"></i> {{ \Carbon\Carbon::parse($event->start_at)->format('d M Y, H:i') }} WIB
                        </p>
                        @if($event->lokasi)
                        <p class="mb-1 text-sm text-muted">
                            <i class="fas fa-map-marker-alt"></i> {{ $event->lokasi }}
                        </p>
                        @endif
                        <a href="{{ route('events.show', $event->event_id) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                    </div>
                    @endforeach
                @else
                    <p class="text-center text-muted">Tidak ada event terdekat</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Jadwal Perawatan Terdekat -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Jadwal Perawatan Terdekat</h6>
                <a href="{{ route('jadwal-perawatan.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Aset</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jadwalTerdekat as $jadwal)
                            <tr>
                                <td>{{ $jadwal->aset->nama_aset }}</td>
                                <td>{{ $jadwal->tanggal_jadwal->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge badge-{{ $jadwal->status === 'terjadwal' ? 'info' : ($jadwal->status === 'selesai' ? 'success' : 'warning') }}">
                                        {{ ucfirst(str_replace('_', ' ', $jadwal->status)) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada jadwal perawatan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Aset Perlu Perhatian -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-danger">Aset Perlu Perhatian</h6>
                <a href="{{ route('aset.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nama Aset</th>
                                <th>Kondisi</th>
                                <th>Lokasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($asetPerluPerhatian as $aset)
                            <tr>
                                <td>{{ $aset->nama_aset }}</td>
                                <td>
                                    <span class="badge badge-{{ $aset->kondisi === 'baik' ? 'success' : ($aset->kondisi === 'rusak_ringan' ? 'warning' : 'danger') }}">
                                        {{ ucfirst(str_replace('_', ' ', $aset->kondisi)) }}
                                    </span>
                                </td>
                                <td>{{ $aset->lokasi ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Semua aset dalam kondisi baik</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ZIS Statistics Row -->
<div class="row">
    <!-- Total ZIS Masuk Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total ZIS Masuk
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalZISMasuk, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hand-holding-usd fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Penyaluran Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Total Penyaluran
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($totalPenyaluran, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-share-square fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Saldo ZIS Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Saldo ZIS
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($saldoZIS, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-wallet fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Muzakki Card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Muzakki
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalMuzakki }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ZIS Detail Row -->
<div class="row">
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rincian ZIS Masuk</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span><i class="fas fa-mosque text-primary"></i> Zakat</span>
                        <strong>Rp {{ number_format($totalZakat, 0, ',', '.') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span><i class="fas fa-hand-holding-heart text-success"></i> Infaq</span>
                        <strong>Rp {{ number_format($totalInfaq, 0, ',', '.') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span><i class="fas fa-donate text-warning"></i> Shadaqah</span>
                        <strong>Rp {{ number_format($totalShadaqah, 0, ',', '.') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-landmark text-info"></i> Wakaf</span>
                        <strong>Rp {{ number_format($totalWakaf, 0, ',', '.') }}</strong>
                    </div>
                </div>
                <hr>
                <div class="text-center">
                    <a href="{{ route('zis-masuk.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i> Lihat Detail ZIS Masuk
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Mustahik</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <h3 class="text-primary">{{ $totalMustahik }}</h3>
                    <p class="text-muted mb-0">Mustahik Aktif</p>
                </div>
                <hr>
                <div class="text-center">
                    <a href="{{ route('mustahik.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-users"></i> Kelola Mustahik
                    </a>
                    <a href="{{ route('penyaluran.index') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-share-square"></i> Penyaluran ZIS
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Selamat Datang -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Selamat Datang, {{ auth()->user()->nama_lengkap ?? auth()->user()->name }}!</h6>
            </div>
            <div class="card-body">
                <p>Anda login sebagai: 
                    @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin())
                        <span class="badge badge-danger">Administrator</span>
                    @elseif(auth()->user()->isDkm())
                        <span class="badge badge-warning">DKM</span>
                    @elseif(auth()->user()->isPanitia())
                        <span class="badge badge-info">Panitia</span>
                    @elseif(auth()->user()->isJemaah())
                        <span class="badge badge-success">Jemaah</span>
                    @else
                        <span class="badge badge-secondary">User</span>
                    @endif
                </p>
                <p class="mb-0">Gunakan menu di sidebar untuk mengakses fitur-fitur yang tersedia.</p>
            </div>
        </div>
    </div>
</div>
@endsection
