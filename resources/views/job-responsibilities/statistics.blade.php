@extends('layouts.app')

@section('title', 'Statistik Tugas & Tanggung Jawab')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Statistik Tugas & Tanggung Jawab</h1>
    <a href="{{ route('job-responsibilities.index') }}" class="btn btn-secondary shadow-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<!-- Overview Cards -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Tugas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-tasks fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tugas Inti</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['core_vs_non_core'][1] ?? 0 }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-star fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jabatan Aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['positions_with_responsibilities'] }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-sitemap fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Rata-rata Jam</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['average_hours'], 1) }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-clock fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts & Tables -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Distribusi Prioritas</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Prioritas</th>
                            <th>Jumlah</th>
                            <th>Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['by_priority'] as $item)
                        <tr>
                            <td>
                                @switch($item->priority)
                                    @case('critical') <span class="badge badge-danger">Kritis</span> @break
                                    @case('high') <span class="badge badge-warning">Tinggi</span> @break
                                    @case('medium') <span class="badge badge-info">Sedang</span> @break
                                    @default <span class="badge badge-secondary">Rendah</span>
                                @endswitch
                            </td>
                            <td class="text-center">{{ $item->count }}</td>
                            <td>
                                @php $pct = $stats['total'] ? round($item->count / $stats['total'] * 100, 1) : 0 @endphp
                                <div class="progress">
                                    <div class="progress-bar bg-{{ $item->priority == 'critical' ? 'danger' : ($item->priority == 'high' ? 'warning' : ($item->priority == 'medium' ? 'info' : 'secondary')) }}"
                                         style="width: {{ $pct }}%">{{ $pct }}%</div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Distribusi Frekuensi</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Frekuensi</th>
                            <th>Jumlah</th>
                            <th>Persentase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stats['by_frequency'] as $item)
                        <tr>
                            <td>
                                @switch($item->frequency)
                                    @case('daily') <span class="badge badge-dark">Harian</span> @break
                                    @case('weekly') <span class="badge badge-primary">Mingguan</span> @break
                                    @case('monthly') <span class="badge badge-info">Bulanan</span> @break
                                    @case('yearly') <span class="badge badge-warning">Tahunan</span> @break
                                    @default <span class="badge badge-secondary">Sesuai Kebutuhan</span>
                                @endswitch
                            </td>
                            <td class="text-center">{{ $item->count }}</td>
                            <td>
                                @php $pct = $stats['total'] ? round($item->count / $stats['total'] * 100, 1) : 0 @endphp
                                <div class="progress">
                                    <div class="progress-bar bg-primary" style="width: {{ $pct }}%">{{ $pct }}%</div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Top Positions -->
<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">5 Jabatan dengan Tugas Terbanyak</h6>
    </div>
    <div class="card-body">
        @if($topPositions->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Jabatan</th>
                            <th>Jumlah Tugas</th>
                            <th>Progress</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topPositions as $index => $position)
                        <tr>
                            <td class="text-center">
                                <h5><span class="badge badge-{{ $index == 0 ? 'warning' : ($index == 1 ? 'secondary' : ($index == 2 ? 'danger' : 'light text-dark')) }}">{{ $index + 1 }}</span></h5>
                            </td>
                            <td>
                                <a href="{{ route('positions.show', $position->id) }}">{{ $position->name }}</a>
                            </td>
                            <td class="text-center"><span class="badge badge-primary">{{ $position->responsibility_count }}</span></td>
                            <td>
                                @php $max = $topPositions->max('responsibility_count'); $pct = $max ? round($position->responsibility_count / $max * 100) : 0; @endphp
                                <div class="progress">
                                    <div class="progress-bar bg-success" style="width: {{ $pct }}%">{{ $pct }}%</div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('job-responsibilities.by-position', $position->id) }}" class="btn btn-sm btn-info">
                                    Lihat Tugas
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-muted py-4">Belum ada data tugas</p>
        @endif
    </div>
</div>
@endsection
