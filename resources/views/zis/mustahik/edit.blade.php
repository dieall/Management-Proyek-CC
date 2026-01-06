@extends('layouts.app')

@section('title', 'Edit Mustahik')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Data Mustahik</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Mustahik</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('mustahik.update', $mustahik->id_mustahik) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                       id="nama" name="nama" value="{{ old('nama', $mustahik->nama) }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                          id="alamat" name="alamat" rows="3">{{ old('alamat', $mustahik->alamat) }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kategori_mustahik">Kategori Mustahik</label>
                        <select class="form-control @error('kategori_mustahik') is-invalid @enderror" 
                                id="kategori_mustahik" name="kategori_mustahik">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="fakir" {{ old('kategori_mustahik', $mustahik->kategori_mustahik) == 'fakir' ? 'selected' : '' }}>Fakir</option>
                            <option value="miskin" {{ old('kategori_mustahik', $mustahik->kategori_mustahik) == 'miskin' ? 'selected' : '' }}>Miskin</option>
                            <option value="amil" {{ old('kategori_mustahik', $mustahik->kategori_mustahik) == 'amil' ? 'selected' : '' }}>Amil</option>
                            <option value="muallaf" {{ old('kategori_mustahik', $mustahik->kategori_mustahik) == 'muallaf' ? 'selected' : '' }}>Muallaf</option>
                            <option value="riqab" {{ old('kategori_mustahik', $mustahik->kategori_mustahik) == 'riqab' ? 'selected' : '' }}>Riqab</option>
                            <option value="gharim" {{ old('kategori_mustahik', $mustahik->kategori_mustahik) == 'gharim' ? 'selected' : '' }}>Gharim</option>
                            <option value="fisabillillah" {{ old('kategori_mustahik', $mustahik->kategori_mustahik) == 'fisabillillah' ? 'selected' : '' }}>Fisabillillah</option>
                            <option value="ibnu sabil" {{ old('kategori_mustahik', $mustahik->kategori_mustahik) == 'ibnu sabil' ? 'selected' : '' }}>Ibnu Sabil</option>
                        </select>
                        @error('kategori_mustahik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="no_hp">No HP</label>
                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror" 
                               id="no_hp" name="no_hp" value="{{ old('no_hp', $mustahik->no_hp) }}">
                        @error('no_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="surat_dtks">Surat DTKS Baru (Opsional)</label>
                @if($mustahik->surat_dtks)
                    <div class="mb-2">
                        <small class="text-muted">File saat ini: </small>
                        <a href="{{ Storage::url($mustahik->surat_dtks) }}" target="_blank" class="text-primary">
                            <i class="fas fa-file"></i> Lihat File
                        </a>
                    </div>
                @endif
                <input type="file" class="form-control-file @error('surat_dtks') is-invalid @enderror" 
                       id="surat_dtks" name="surat_dtks" accept="image/*,.pdf">
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah file</small>
                @error('surat_dtks')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status_verifikasi">Status Verifikasi <span class="text-danger">*</span></label>
                        <select class="form-control @error('status_verifikasi') is-invalid @enderror" 
                                id="status_verifikasi" name="status_verifikasi" required>
                            <option value="pending" {{ old('status_verifikasi', $mustahik->status_verifikasi) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="disetujui" {{ old('status_verifikasi', $mustahik->status_verifikasi) == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                            <option value="ditolak" {{ old('status_verifikasi', $mustahik->status_verifikasi) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        @error('status_verifikasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="aktif" {{ old('status', $mustahik->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="non-aktif" {{ old('status', $mustahik->status) == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <a href="{{ route('mustahik.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection










