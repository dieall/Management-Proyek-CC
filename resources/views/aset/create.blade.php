@extends('layouts.app')

@section('title', 'Tambah Aset')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Aset</h1>
    <a href="{{ route('aset.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('aset.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kode Aset <span class="text-danger">*</span></label>
                        <input type="text" name="kode_aset" class="form-control @error('kode_aset') is-invalid @enderror" value="{{ old('kode_aset') }}" required>
                        @error('kode_aset')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Aset <span class="text-danger">*</span></label>
                        <input type="text" name="nama_aset" class="form-control @error('nama_aset') is-invalid @enderror" value="{{ old('nama_aset') }}" required>
                        @error('nama_aset')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Aset <span class="text-danger">*</span></label>
                        <input type="text" name="jenis_aset" class="form-control @error('jenis_aset') is-invalid @enderror" value="{{ old('jenis_aset') }}" required>
                        @error('jenis_aset')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kondisi <span class="text-danger">*</span></label>
                        <select name="kondisi" class="form-control @error('kondisi') is-invalid @enderror" required>
                            <option value="">Pilih Kondisi</option>
                            <option value="baik" {{ old('kondisi') === 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="rusak_ringan" {{ old('kondisi') === 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="rusak_berat" {{ old('kondisi') === 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                            <option value="tidak_layak" {{ old('kondisi') === 'tidak_layak' ? 'selected' : '' }}>Tidak Layak</option>
                        </select>
                        @error('kondisi')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
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
                        <label>Lokasi</label>
                        <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi') }}">
                        @error('lokasi')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Sumber Perolehan <span class="text-danger">*</span></label>
                        <select name="sumber_perolehan" id="sumber_perolehan" class="form-control @error('sumber_perolehan') is-invalid @enderror" required>
                            <option value="">Pilih Sumber</option>
                            <option value="pembelian" {{ old('sumber_perolehan') === 'pembelian' ? 'selected' : '' }}>Pembelian</option>
                            <option value="donasi" {{ old('sumber_perolehan') === 'donasi' ? 'selected' : '' }}>Donasi</option>
                        </select>
                        @error('sumber_perolehan')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Pembelian Fields -->
            <div id="pembelian_fields" style="display: none;">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Harga</label>
                            <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}" step="0.01">
                            @error('harga')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Vendor</label>
                            <input type="text" name="vendor" class="form-control @error('vendor') is-invalid @enderror" value="{{ old('vendor') }}">
                            @error('vendor')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Pembelian</label>
                            <input type="date" name="tanggal_pembelian" class="form-control @error('tanggal_pembelian') is-invalid @enderror" value="{{ old('tanggal_pembelian') }}">
                            @error('tanggal_pembelian')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Donasi Fields -->
            <div id="donasi_fields" style="display: none;">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nilai Donasi (Rp)</label>
                            <input type="number" name="nilai_donasi" class="form-control @error('nilai_donasi') is-invalid @enderror" value="{{ old('nilai_donasi') }}" step="0.01">
                            @error('nilai_donasi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Donatur</label>
                            <input type="text" name="donatur" class="form-control @error('donatur') is-invalid @enderror" value="{{ old('donatur') }}">
                            @error('donatur')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Donasi</label>
                            <input type="date" name="tanggal_donasi" class="form-control @error('tanggal_donasi') is-invalid @enderror" value="{{ old('tanggal_donasi') }}">
                            @error('tanggal_donasi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Foto</label>
                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                @error('foto')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('aset.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('sumber_perolehan').addEventListener('change', function() {
        const value = this.value;
        const pembelianFields = document.getElementById('pembelian_fields');
        const donasiFields = document.getElementById('donasi_fields');
        
        if (value === 'pembelian') {
            pembelianFields.style.display = 'block';
            donasiFields.style.display = 'none';
        } else if (value === 'donasi') {
            pembelianFields.style.display = 'none';
            donasiFields.style.display = 'block';
        } else {
            pembelianFields.style.display = 'none';
            donasiFields.style.display = 'none';
        }
    });

    // Trigger on page load if old value exists
    if (document.getElementById('sumber_perolehan').value) {
        document.getElementById('sumber_perolehan').dispatchEvent(new Event('change'));
    }
</script>
@endpush
@endsection





















