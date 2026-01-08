@extends('layouts.app')

@section('title', 'Tambah Laporan Perawatan')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Laporan Perawatan</h1>
    <a href="{{ route('laporan-perawatan.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('laporan-perawatan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Jadwal Perawatan (Opsional)</label>
                <select name="jadwal_perawatan_id" class="form-control @error('jadwal_perawatan_id') is-invalid @enderror">
                    <option value="">Pilih Jadwal (Opsional)</option>
                    @foreach($jadwalList as $j)
                    <option value="{{ $j->id }}" {{ old('jadwal_perawatan_id', request('jadwal_id')) == $j->id ? 'selected' : '' }}>
                        {{ $j->aset->nama_aset }} - {{ $j->tanggal_jadwal->format('d/m/Y') }}
                    </option>
                    @endforeach
                </select>
                @error('jadwal_perawatan_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Aset <span class="text-danger">*</span></label>
                <select name="aset_id" id="aset_id" class="form-control @error('aset_id') is-invalid @enderror" required>
                    <option value="">Pilih Aset</option>
                    @foreach($aset as $a)
                    <option value="{{ $a->id }}" {{ old('aset_id', $jadwal?->aset_id) == $a->id ? 'selected' : '' }}>
                        {{ $a->nama_aset }} ({{ $a->kode_aset }}) - {{ ucfirst(str_replace('_', ' ', $a->kondisi)) }}
                    </option>
                    @endforeach
                </select>
                @error('aset_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Tanggal Pemeriksaan <span class="text-danger">*</span></label>
                <input type="date" name="tanggal_pemeriksaan" class="form-control @error('tanggal_pemeriksaan') is-invalid @enderror" value="{{ old('tanggal_pemeriksaan', date('Y-m-d')) }}" required>
                @error('tanggal_pemeriksaan')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kondisi Sebelum <span class="text-danger">*</span></label>
                        <select name="kondisi_sebelum" class="form-control @error('kondisi_sebelum') is-invalid @enderror" required>
                            <option value="">Pilih Kondisi</option>
                            <option value="baik" {{ old('kondisi_sebelum') === 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="rusak_ringan" {{ old('kondisi_sebelum') === 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="rusak_berat" {{ old('kondisi_sebelum') === 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                            <option value="tidak_layak" {{ old('kondisi_sebelum') === 'tidak_layak' ? 'selected' : '' }}>Tidak Layak</option>
                        </select>
                        @error('kondisi_sebelum')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kondisi Sesudah <span class="text-danger">*</span></label>
                        <select name="kondisi_sesudah" class="form-control @error('kondisi_sesudah') is-invalid @enderror" required>
                            <option value="">Pilih Kondisi</option>
                            <option value="baik" {{ old('kondisi_sesudah') === 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="rusak_ringan" {{ old('kondisi_sesudah') === 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="rusak_berat" {{ old('kondisi_sesudah') === 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
                            <option value="tidak_layak" {{ old('kondisi_sesudah') === 'tidak_layak' ? 'selected' : '' }}>Tidak Layak</option>
                        </select>
                        @error('kondisi_sesudah')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label>Hasil Pemeriksaan <span class="text-danger">*</span></label>
                <textarea name="hasil_pemeriksaan" class="form-control @error('hasil_pemeriksaan') is-invalid @enderror" rows="4" required>{{ old('hasil_pemeriksaan') }}</textarea>
                @error('hasil_pemeriksaan')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Tindakan</label>
                <textarea name="tindakan" class="form-control @error('tindakan') is-invalid @enderror" rows="3">{{ old('tindakan') }}</textarea>
                @error('tindakan')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Biaya Perawatan</label>
                <input type="number" name="biaya_perawatan" class="form-control @error('biaya_perawatan') is-invalid @enderror" value="{{ old('biaya_perawatan') }}" step="0.01">
                @error('biaya_perawatan')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Foto Sebelum</label>
                        <input type="file" name="foto_sebelum" class="form-control @error('foto_sebelum') is-invalid @enderror" accept="image/*">
                        @error('foto_sebelum')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Foto Sesudah</label>
                        <input type="file" name="foto_sesudah" class="form-control @error('foto_sesudah') is-invalid @enderror" accept="image/*">
                        @error('foto_sesudah')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('laporan-perawatan.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
























