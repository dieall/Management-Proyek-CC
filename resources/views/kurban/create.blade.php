@extends('layouts.app')

@section('title', 'Tambah Program Kurban')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Program Kurban</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Program Kurban</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('kurban.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_kurban">Nama Program Kurban <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_kurban') is-invalid @enderror" 
                       id="nama_kurban" name="nama_kurban" value="{{ old('nama_kurban') }}" required>
                @error('nama_kurban')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal_kurban">Tanggal Kurban <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal_kurban') is-invalid @enderror" 
                               id="tanggal_kurban" name="tanggal_kurban" value="{{ old('tanggal_kurban') }}" required>
                        @error('tanggal_kurban')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jenis_hewan">Jenis Hewan <span class="text-danger">*</span></label>
                        <select class="form-control @error('jenis_hewan') is-invalid @enderror" 
                                id="jenis_hewan" name="jenis_hewan" required>
                            <option value="">-- Pilih Jenis Hewan --</option>
                            <option value="sapi" {{ old('jenis_hewan') == 'sapi' ? 'selected' : '' }}>Sapi</option>
                            <option value="kambing" {{ old('jenis_hewan') == 'kambing' ? 'selected' : '' }}>Kambing</option>
                            <option value="domba" {{ old('jenis_hewan') == 'domba' ? 'selected' : '' }}>Domba</option>
                        </select>
                        @error('jenis_hewan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="target_hewan">Target Hewan <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('target_hewan') is-invalid @enderror" 
                               id="target_hewan" name="target_hewan" value="{{ old('target_hewan', 1) }}" min="1" required>
                        @error('target_hewan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="harga_per_hewan">Harga per Hewan (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('harga_per_hewan') is-invalid @enderror" 
                               id="harga_per_hewan" name="harga_per_hewan" value="{{ old('harga_per_hewan') }}" min="0" step="1000" required>
                        @error('harga_per_hewan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control @error('status') is-invalid @enderror" 
                        id="status" name="status">
                    <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                          id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <a href="{{ route('kurban.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

