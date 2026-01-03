@extends('layouts.app')

@section('title', 'Detail Jabatan - ' . $position->name)

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Detail Jabatan</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('positions.index') }}">Jabatan</a></li>
            <li class="breadcrumb-item active">{{ $position->name }}</li>
        </ol>
    </div>
    <div>
        <a href="{{ route('positions.edit', $position->id) }}" class="btn btn-warning shadow-sm mr-2">
            <i class="fas fa-edit"></i> Edit
        </a>
        <a href="{{ route('positions.index') }}" class="btn btn-secondary shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <!-- Left: Position Info -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Jabatan</h6>
            </div>
            <div class="card-body text-center">
                <div class="mb-4">
                    <div class="rounded-circle bg-gradient-primary d-inline-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px;">
                        <i class="fas fa-user-tie fa-3x text-white"></i>
                    </div>
                </div>
                <h4>{{ $position->name }}</h4>

                <div class="mb-3">
                    @switch($position->level)
                        @case('leadership') <span class="badge badge-danger badge-pill px-3 py-2">Kepemimpinan</span> @break
                        @case('division_head') <span class="badge badge-warning badge-pill px-3 py-2">Kepala Divisi</span> @break
                        @case('staff') <span class="badge badge-primary badge-pill px-3 py-2">Staf</span> @break
                        @default <span class="badge badge-secondary badge-pill px-3 py-2">Relawan</span>
                    @endswitch
                    <br><br>
                    @if($position->status == 'active')
                        <span class="badge badge-success badge-pill px-3 py-2">Aktif</span>
                    @else
                        <span class="badge badge-secondary badge-pill px-3 py-2">Tidak Aktif</span>
                    @endif
                </div>

                <div class="row text-center mb-4">
                    <div class="col-6 border-right">
                        <h5 class="text-primary">{{ $committeeStats['total'] }}</h5>
                        <small>Pengurus</small>
                    </div>
                    <div class="col-6">
                        <h5 class="text-warning">{{ $responsibilityStats['total'] }}</h5>
                        <small>Tugas</small>
                    </div>
                </div>

                <hr>

                <h6 class="text-muted mb-3">Hierarki</h6>
                <ul class="list-group list-group-flush">
                    @if($position->parent)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Atasan</span>
                            <a href="{{ route('positions.show', $position->parent->id) }}">
                                <span class="badge badge-info">{{ $position->parent->name }}</span>
                            </a>
                        </li>
                    @endif
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Sub-jabatan</span>
                        <span class="badge badge-secondary">{{ $position->children_count }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Urutan</span>
                        <span class="badge badge-light text-dark">{{ $position->order }}</span>
                    </li>
                </ul>
            </div>
        </div>

        @if($position->description)
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Deskripsi Jabatan</h6>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $position->description }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Right: Committees & Responsibilities -->
    <div class="col-lg-8">
        <!-- Committees -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Pengurus di Jabatan Ini</h6>
                <a href="{{ route('positions.committees', $position->id) }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="row mb-3 text-center">
                    <div class="col-3"><h5 class="text-success">{{ $committeeStats['active'] }}</h5><small>Aktif</small></div>
                    <div class="col-3"><h5 class="text-secondary">{{ $committeeStats['inactive'] }}</h5><small>Tidak Aktif</small></div>
                    <div class="col-3"><h5 class="text-warning">{{ $committeeStats['resigned'] }}</h5><small>Mengundurkan Diri</small></div>
                    <div class="col-3"><h5 class="text-info">{{ $committeeStats['total'] }}</h5><small>Total</small></div>
                </div>

                @if($position->committees->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Status</th>
                                    <th>Bergabung</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($position->committees->take(10) as $committee)
                                <tr>
                                    <td><strong>{{ $committee->full_name }}</strong></td>
                                    <td>
                                        @switch($committee->active_status)
                                            @case('active') <span class="badge badge-success">Aktif</span> @break
                                            @case('inactive') <span class="badge badge-secondary">Tidak Aktif</span> @break
                                            @default <span class="badge badge-warning">Mengundurkan Diri</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $committee->join_date->format('d/m/Y') }}</td>
                                    <td><a href="{{ route('committees.show', $committee->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted py-4">Belum ada pengurus</p>
                @endif
            </div>
        </div>

        <!-- Responsibilities -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Tugas & Tanggung Jawab</h6>
                <a href="{{ route('positions.responsibilities', $position->id) }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                <div class="row mb-3 text-center">
                    <div class="col-4"><h5 class="text-primary">{{ $responsibilityStats['core'] }}</h5><small>Tugas Inti</small></div>
                    <div class="col-4"><h5 class="text-secondary">{{ $responsibilityStats['non_core'] }}</h5><small>Tambahan</small></div>
                    <div class="col-4"><h5 class="text-warning">{{ $responsibilityStats['by_priority']['high'] ?? 0 }}</h5><small>Prioritas Tinggi</small></div>
                </div>

                @if($position->responsibilities->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tugas</th>
                                    <th>Prioritas</th>
                                    <th>Frekuensi</th>
                                    <th>Jenis</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($position->responsibilities->take(8) as $resp)
                                <tr>
                                    <td><strong>{{ $resp->task_name }}</strong></td>
                                    <td>
                                        @switch($resp->priority)
                                            @case('critical') <span class="badge badge-danger">Kritis</span> @break
                                            @case('high') <span class="badge badge-warning">Tinggi</span> @break
                                            @case('medium') <span class="badge badge-info">Sedang</span> @break
                                            @default <span class="badge badge-secondary">Rendah</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        @switch($resp->frequency)
                                            @case('daily') <span class="badge badge-dark">Harian</span> @break
                                            @case('weekly') <span class="badge badge-primary">Mingguan</span> @break
                                            @case('monthly') <span class="badge badge-info">Bulanan</span> @break
                                            @default <span class="badge badge-secondary">Lainnya</span>
                                        @endswitch
                                    </td>
                                    <td>
                                        @if($resp->is_core_responsibility)
                                            <span class="badge badge-success">Inti</span>
                                        @else
                                            <span class="badge badge-secondary">Tambahan</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted py-4">Belum ada tugas untuk jabatan ini</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
