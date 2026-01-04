@extends('layouts.app')

@section('title', 'Edit Kegiatan')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Kegiatan</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Kegiatan</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('kegiatan.update', $kegiatan->id_kegiatan) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="nama_kegiatan">Nama Kegiatan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror" 
                       id="nama_kegiatan" name="nama_kegiatan" value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan) }}" required>
                @error('nama_kegiatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                               id="tanggal" name="tanggal" value="{{ old('tanggal', $kegiatan->tanggal->format('Y-m-d')) }}" required>
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lokasi">Lokasi</label>
                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                               id="lokasi" name="lokasi" value="{{ old('lokasi', $kegiatan->lokasi) }}">
                        @error('lokasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="status_kegiatan">Status <span class="text-danger">*</span></label>
                <select class="form-control @error('status_kegiatan') is-invalid @enderror" 
                        id="status_kegiatan" name="status_kegiatan" required>
                    <option value="aktif" {{ old('status_kegiatan', $kegiatan->status_kegiatan) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ old('status_kegiatan', $kegiatan->status_kegiatan) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="batal" {{ old('status_kegiatan', $kegiatan->status_kegiatan) == 'batal' ? 'selected' : '' }}>Batal</option>
                </select>
                @error('status_kegiatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                          id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <a href="{{ route('kegiatan.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

