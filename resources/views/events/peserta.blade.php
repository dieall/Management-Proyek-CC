@extends('layouts.app')

@section('title', 'Daftar Peserta Event')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Peserta Event</h1>
    <a href="{{ route('events.show', $event->event_id) }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali ke Detail Event
    </a>
</div>

<!-- Event Info -->
<div class="card shadow mb-4">
    <div class="card-body">
        <h4 class="mb-3">{{ $event->nama_kegiatan }}</h4>
        <div class="row">
            <div class="col-md-6">
                <p><strong><i class="fas fa-calendar"></i> Waktu:</strong> 
                    {{ $event->start_at ? $event->start_at->format('d F Y, H:i') : '-' }} - 
                    {{ $event->end_at ? $event->end_at->format('d F Y, H:i') : '-' }} WIB
                </p>
            </div>
            <div class="col-md-6">
                <p><strong><i class="fas fa-users"></i> Total Peserta:</strong> {{ $event->peserta->count() }} orang</p>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Kehadiran -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Terdaftar</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $event->peserta->where('pivot.status_kehadiran', 'terdaftar')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
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
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hadir</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $event->peserta->where('pivot.status_kehadiran', 'hadir')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Izin</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $event->peserta->where('pivot.status_kehadiran', 'izin')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-exclamation-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Alpa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $event->peserta->where('pivot.status_kehadiran', 'alpa')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Peserta -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Peserta</h6>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if($event->peserta->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Tanggal Daftar</th>
                        <th>Status Kehadiran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($event->peserta as $index => $peserta)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $peserta->nama_lengkap ?? $peserta->name ?? '-' }}</td>
                        <td>{{ $peserta->email ?? '-' }}</td>
                        <td>{{ $peserta->no_hp ?? '-' }}</td>
                        <td>{{ $peserta->pivot->tanggal_daftar ? \Carbon\Carbon::parse($peserta->pivot->tanggal_daftar)->format('d F Y') : '-' }}</td>
                        <td>
                            @if($peserta->pivot->status_kehadiran === 'hadir')
                                <span class="badge badge-success">Hadir</span>
                            @elseif($peserta->pivot->status_kehadiran === 'izin')
                                <span class="badge badge-warning">Izin</span>
                            @elseif($peserta->pivot->status_kehadiran === 'alpa')
                                <span class="badge badge-danger">Alpa</span>
                            @else
                                <span class="badge badge-info">Terdaftar</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('events.absensi', $event->event_id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $peserta->id }}">
                                <div class="btn-group" role="group">
                                    <select name="status_kehadiran" class="form-control form-control-sm" onchange="this.form.submit()">
                                        <option value="terdaftar" {{ $peserta->pivot->status_kehadiran === 'terdaftar' ? 'selected' : '' }}>Terdaftar</option>
                                        <option value="hadir" {{ $peserta->pivot->status_kehadiran === 'hadir' ? 'selected' : '' }}>Hadir</option>
                                        <option value="izin" {{ $peserta->pivot->status_kehadiran === 'izin' ? 'selected' : '' }}>Izin</option>
                                        <option value="alpa" {{ $peserta->pivot->status_kehadiran === 'alpa' ? 'selected' : '' }}>Alpa</option>
                                    </select>
                                </div>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Belum ada peserta yang mendaftar di event ini.
        </div>
        @endif
    </div>
</div>
@endsection

