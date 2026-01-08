@extends('layouts.app')

@section('title', 'Tambah Jadwal Perawatan')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Jadwal Perawatan</h1>
    <a href="{{ route('jadwal-perawatan.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('jadwal-perawatan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Aset <span class="text-danger">*</span></label>
                <select name="aset_id" class="form-control @error('aset_id') is-invalid @enderror" required>
                    <option value="">Pilih Aset</option>
                    @foreach($aset as $a)
                    <option value="{{ $a->id }}" {{ old('aset_id') == $a->id ? 'selected' : '' }}>
                        {{ $a->nama_aset }} ({{ $a->kode_aset }})
                    </option>
                    @endforeach
                </select>
                @error('aset_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Jenis Perawatan <span class="text-danger">*</span></label>
                <input type="text" name="jenis_perawatan" class="form-control @error('jenis_perawatan') is-invalid @enderror" value="{{ old('jenis_perawatan') }}" required>
                @error('jenis_perawatan')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal Jadwal <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_jadwal" class="form-control @error('tanggal_jadwal') is-invalid @enderror" value="{{ old('tanggal_jadwal') }}" required>
                        @error('tanggal_jadwal')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                            <option value="terjadwal" {{ old('status') === 'terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                            <option value="sedang_dilakukan" {{ old('status') === 'sedang_dilakukan' ? 'selected' : '' }}>Sedang Dilakukan</option>
                            <option value="selesai" {{ old('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ old('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('jadwal-perawatan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
























