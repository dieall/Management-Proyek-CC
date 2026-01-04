@extends('layouts.app')

@section('title', 'Edit Program Donasi')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Program Donasi</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Program Donasi</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('donasi.update', $donasi->id_donasi) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="nama_donasi">Nama Program Donasi <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_donasi') is-invalid @enderror" 
                       id="nama_donasi" name="nama_donasi" value="{{ old('nama_donasi', $donasi->nama_donasi) }}" required>
                @error('nama_donasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal_mulai">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                               id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $donasi->tanggal_mulai->format('Y-m-d')) }}" required>
                        @error('tanggal_mulai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal_selesai">Tanggal Selesai</label>
                        <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                               id="tanggal_selesai" name="tanggal_selesai" 
                               value="{{ old('tanggal_selesai', $donasi->tanggal_selesai ? $donasi->tanggal_selesai->format('Y-m-d') : '') }}">
                        @error('tanggal_selesai')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                          id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $donasi->deskripsi) }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <a href="{{ route('donasi.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

