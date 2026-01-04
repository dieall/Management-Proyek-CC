@extends('layouts.app')

@section('title', 'Detail Kegiatan')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Kegiatan</h1>
    <a href="{{ route('kegiatan.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <!-- Info Kegiatan -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Kegiatan</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="200"><strong>Nama Kegiatan</strong></td>
                        <td>: {{ $kegiatan->nama_kegiatan }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal</strong></td>
                        <td>: {{ $kegiatan->tanggal->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Lokasi</strong></td>
                        <td>: {{ $kegiatan->lokasi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status</strong></td>
                        <td>: 
                            @if($kegiatan->status_kegiatan == 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @elseif($kegiatan->status_kegiatan == 'selesai')
                                <span class="badge badge-secondary">Selesai</span>
                            @else
                                <span class="badge badge-danger">Batal</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Deskripsi</strong></td>
                        <td>: {{ $kegiatan->deskripsi ?? '-' }}</td>
                    </tr>
                </table>

                @if($kegiatan->status_kegiatan == 'aktif' && !$kegiatan->peserta()->where('id_jamaah', auth()->id())->exists())
                <div class="mt-3">
                    <form action="{{ route('kegiatan.daftar', $kegiatan->id_kegiatan) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-user-plus"></i> Daftar Kegiatan
                        </button>
                    </form>
                </div>
                @elseif($kegiatan->peserta()->where('id_jamaah', auth()->id())->exists())
                <div class="alert alert-success mt-3">
                    <i class="fas fa-check-circle"></i> Anda sudah terdaftar di kegiatan ini
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistik Peserta -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Statistik Peserta</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h4 class="text-primary">{{ $totalPeserta }}</h4>
                    <small class="text-muted">Total Peserta</small>
                </div>
                <hr>
                <div class="mb-2">
                    <span class="badge badge-success">Hadir: {{ $hadir }}</span>
                </div>
                <div class="mb-2">
                    <span class="badge badge-warning">Izin: {{ $izin }}</span>
                </div>
                <div class="mb-2">
                    <span class="badge badge-danger">Alpa: {{ $alpa }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Daftar Peserta -->
@if(auth()->user()->isAdmin() || auth()->user()->isDkm())
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Daftar Peserta</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal Daftar</th>
                        <th>Status Kehadiran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kegiatan->peserta as $index => $peserta)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $peserta->nama_lengkap }}</td>
                        <td>{{ $peserta->pivot->tanggal_daftar ? \Carbon\Carbon::parse($peserta->pivot->tanggal_daftar)->format('d/m/Y') : '-' }}</td>
                        <td>
                            @if($peserta->pivot->status_kehadiran == 'hadir')
                                <span class="badge badge-success">Hadir</span>
                            @elseif($peserta->pivot->status_kehadiran == 'izin')
                                <span class="badge badge-warning">Izin</span>
                            @elseif($peserta->pivot->status_kehadiran == 'alpa')
                                <span class="badge badge-danger">Alpa</span>
                            @else
                                <span class="badge badge-secondary">Terdaftar</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('kegiatan.kehadiran', $kegiatan->id_kegiatan) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="id_jamaah" value="{{ $peserta->id }}">
                                <select name="status_kehadiran" class="form-control form-control-sm d-inline" style="width: auto;" onchange="this.form.submit()">
                                    <option value="terdaftar" {{ $peserta->pivot->status_kehadiran == 'terdaftar' ? 'selected' : '' }}>Terdaftar</option>
                                    <option value="hadir" {{ $peserta->pivot->status_kehadiran == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                    <option value="izin" {{ $peserta->pivot->status_kehadiran == 'izin' ? 'selected' : '' }}>Izin</option>
                                    <option value="alpa" {{ $peserta->pivot->status_kehadiran == 'alpa' ? 'selected' : '' }}>Alpa</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada peserta terdaftar</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection

