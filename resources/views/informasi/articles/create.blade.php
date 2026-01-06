@extends('layouts.app')

@section('title', 'Tambah Artikel')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Artikel/Pengumuman Baru</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Artikel/Pengumuman</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('articles.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="title">Judul <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                       id="title" name="title" value="{{ old('title') }}" required>
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Singkat <span class="text-danger">*</span></label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                <small class="form-text text-muted">Ringkasan singkat artikel yang akan ditampilkan di daftar</small>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="content">Konten Lengkap (Opsional)</label>
                <textarea class="form-control @error('content') is-invalid @enderror" 
                          id="content" name="content" rows="6">{{ old('content') }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image_url">URL Gambar (Opsional)</label>
                        <input type="url" class="form-control @error('image_url') is-invalid @enderror" 
                               id="image_url" name="image_url" value="{{ old('image_url') }}" 
                               placeholder="https://example.com/image.jpg">
                        @error('image_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="link_url">URL Link Eksternal (Opsional)</label>
                        <input type="url" class="form-control @error('link_url') is-invalid @enderror" 
                               id="link_url" name="link_url" value="{{ old('link_url') }}" 
                               placeholder="https://example.com">
                        @error('link_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="order">Urutan Tampil</label>
                        <input type="number" class="form-control @error('order') is-invalid @enderror" 
                               id="order" name="order" value="{{ old('order', 0) }}" min="0">
                        <small class="form-text text-muted">Semakin kecil angka, semakin di atas</small>
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Aktif</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <a href="{{ route('articles.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection









