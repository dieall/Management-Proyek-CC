@extends('layouts.app')

@section('title', 'Tambah Event')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Event Baru</h1>
    <a href="{{ route('events.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
    </a>
</div>

<!-- Form -->
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="nama_kegiatan">Nama Kegiatan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror" 
                               id="nama_kegiatan" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" required>
                        @error('nama_kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="jenis_kegiatan">Jenis Kegiatan</label>
                        <input type="text" class="form-control @error('jenis_kegiatan') is-invalid @enderror" 
                               id="jenis_kegiatan" name="jenis_kegiatan" value="{{ old('jenis_kegiatan') }}" 
                               placeholder="Contoh: Kajian, Seminar">
                        @error('jenis_kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                       id="lokasi" name="lokasi" value="{{ old('lokasi') }}">
                @error('lokasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="start_at">Tanggal & Waktu Mulai <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control @error('start_at') is-invalid @enderror" 
                               id="start_at" name="start_at" value="{{ old('start_at') }}" required>
                        @error('start_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="end_at">Tanggal & Waktu Selesai <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control @error('end_at') is-invalid @enderror" 
                               id="end_at" name="end_at" value="{{ old('end_at') }}" required>
                        @error('end_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kuota">Kuota Peserta</label>
                        <input type="number" class="form-control @error('kuota') is-invalid @enderror" 
                               id="kuota" name="kuota" value="{{ old('kuota') }}" min="1">
                        @error('kuota')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Kosongkan jika tidak ada batasan kuota</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                            <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="4">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="rule">Peraturan/Ketentuan</label>
                <textarea class="form-control @error('rule') is-invalid @enderror" 
                          id="rule" name="rule" rows="3">{{ old('rule') }}</textarea>
                @error('rule')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="poster">Poster Event</label>
                <input type="file" class="form-control-file @error('poster') is-invalid @enderror" 
                       id="poster" name="poster" accept="image/*">
                @error('poster')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Format: JPG, JPEG, PNG, GIF (Max: 2MB)</small>
            </div>
            
            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Event
                </button>
                <a href="{{ route('events.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

