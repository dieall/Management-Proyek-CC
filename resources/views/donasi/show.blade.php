@extends('layouts.app')

@section('title', 'Detail Program Donasi')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Detail Program Donasi</h1>
    <a href="{{ route('donasi.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <!-- Info Program Donasi -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informasi Program Donasi</h6>
            </div>
            <div class="card-body">
                <h3 class="mb-3">{{ $donasi->nama_donasi }}</h3>
                <table class="table table-borderless">
                    <tr>
                        <td width="200"><strong>Tanggal Mulai</strong></td>
                        <td>: {{ $donasi->tanggal_mulai->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal Selesai</strong></td>
                        <td>: {{ $donasi->tanggal_selesai ? $donasi->tanggal_selesai->format('d F Y') : 'Tidak Dibatasi' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Deskripsi</strong></td>
                        <td>: {{ $donasi->deskripsi ?? '-' }}</td>
                    </tr>
                </table>

                @if(auth()->user()->isAdmin() || auth()->user()->isSuperAdmin() || auth()->user()->isDkm())
                <!-- Form Submit Donasi (hanya untuk admin/DKM) -->
                <div class="card border-left-success mt-4">
                    <div class="card-body">
                        <h6 class="font-weight-bold text-success mb-3">
                            <i class="fas fa-hand-holding-usd"></i> Catat Donasi
                        </h6>
                        <form action="{{ route('donasi.submit', $donasi->id_donasi) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="id_jamaah">Nama Jamaah <span class="text-danger">*</span></label>
                                <select class="form-control @error('id_jamaah') is-invalid @enderror" 
                                        id="id_jamaah" name="id_jamaah" required>
                                    <option value="">-- Pilih Jamaah --</option>
                                    @foreach($jamaahs as $jamaah)
                                        <option value="{{ $jamaah->id }}" {{ old('id_jamaah') == $jamaah->id ? 'selected' : '' }}>
                                            {{ $jamaah->nama_lengkap ?? $jamaah->name }} 
                                            @if($jamaah->email)
                                                ({{ $jamaah->email }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_jamaah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Pilih jamaah yang melakukan donasi</small>
                            </div>
                            <div class="form-group">
                                <label for="besar_donasi">Jumlah Donasi (Rp) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('besar_donasi') is-invalid @enderror" 
                                       id="besar_donasi" name="besar_donasi" min="1000" step="1000" value="{{ old('besar_donasi') }}" required>
                                @error('besar_donasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tanggal_donasi">Tanggal Donasi <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('tanggal_donasi') is-invalid @enderror" 
                                       id="tanggal_donasi" name="tanggal_donasi" value="{{ old('tanggal_donasi', date('Y-m-d')) }}" required>
                                @error('tanggal_donasi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-donate"></i> Catat Donasi
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistik Donasi -->
    <div class="col-lg-4">
        <div class="card shadow mb-4 border-left-success">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Statistik Donasi</h6>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <small class="text-muted">Total Terkumpul</small>
                    <h3 class="text-success">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</h3>
                </div>
                <hr>
                <div class="mb-2">
                    <i class="fas fa-user-friends text-primary"></i>
                    <strong>{{ $totalDonatur }}</strong> Donatur
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Riwayat Donasi -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Riwayat Donasi</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Donatur</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatDonasi as $index => $riwayat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $riwayat->nama_lengkap }}</td>
                        <td>Rp {{ number_format($riwayat->besar_donasi, 0, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($riwayat->tanggal_donasi)->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada donasi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

