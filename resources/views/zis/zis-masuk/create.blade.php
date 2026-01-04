@extends('layouts.app')

@section('title', 'Input ZIS Masuk')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Input ZIS Masuk</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Input ZIS</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('zis-masuk.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="id_muzakki">Muzakki (Pemberi) <span class="text-danger">*</span></label>
                <select class="form-control @error('id_muzakki') is-invalid @enderror" 
                        id="id_muzakki" name="id_muzakki" required>
                    <option value="">-- Pilih Muzakki --</option>
                    @foreach($muzakkis as $muzakki)
                        <option value="{{ $muzakki->id_muzakki }}" {{ old('id_muzakki') == $muzakki->id_muzakki ? 'selected' : '' }}>
                            {{ $muzakki->nama }}
                        </option>
                    @endforeach
                </select>
                @error('id_muzakki')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tgl_masuk">Tanggal Masuk <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tgl_masuk') is-invalid @enderror" 
                               id="tgl_masuk" name="tgl_masuk" value="{{ old('tgl_masuk', date('Y-m-d')) }}" required>
                        @error('tgl_masuk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jenis_zis">Jenis ZIS <span class="text-danger">*</span></label>
                        <select class="form-control @error('jenis_zis') is-invalid @enderror" 
                                id="jenis_zis" name="jenis_zis" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="zakat" {{ old('jenis_zis') == 'zakat' ? 'selected' : '' }}>Zakat</option>
                            <option value="infaq" {{ old('jenis_zis') == 'infaq' ? 'selected' : '' }}>Infaq</option>
                            <option value="shadaqah" {{ old('jenis_zis') == 'shadaqah' ? 'selected' : '' }}>Shadaqah</option>
                            <option value="wakaf" {{ old('jenis_zis') == 'wakaf' ? 'selected' : '' }}>Wakaf</option>
                        </select>
                        @error('jenis_zis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sub_jenis_zis">Sub Jenis ZIS</label>
                        <input type="text" class="form-control @error('sub_jenis_zis') is-invalid @enderror" 
                               id="sub_jenis_zis" name="sub_jenis_zis" value="{{ old('sub_jenis_zis') }}"
                               placeholder="Contoh: Zakat Fitrah, Zakat Mal, dll">
                        @error('sub_jenis_zis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jumlah">Jumlah (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                               id="jumlah" name="jumlah" value="{{ old('jumlah') }}" 
                               min="0" step="0.01" required>
                        @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                          id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <a href="{{ route('zis-masuk.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection



