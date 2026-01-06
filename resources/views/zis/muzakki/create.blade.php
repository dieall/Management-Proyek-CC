@extends('layouts.app')

@section('title', 'Tambah Muzakki')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Muzakki Baru</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Data Muzakki</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('muzakki.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                       id="nama" name="nama" value="{{ old('nama') }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                          id="alamat" name="alamat" rows="3">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="no_hp">No HP</label>
                <input type="text" class="form-control @error('no_hp') is-invalid @enderror" 
                       id="no_hp" name="no_hp" value="{{ old('no_hp') }}">
                @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password (Opsional)</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password">
                <small class="form-text text-muted">Kosongkan jika tidak ingin set password</small>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <a href="{{ route('muzakki.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection









