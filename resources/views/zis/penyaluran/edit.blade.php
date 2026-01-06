@extends('layouts.app')

@section('title', 'Edit Penyaluran')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Penyaluran ZIS</h1>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Penyaluran</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('penyaluran.update', $penyaluran->id_penyaluran) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="id_zis">Dari ZIS Masuk <span class="text-danger">*</span></label>
                <select class="form-control @error('id_zis') is-invalid @enderror" 
                        id="id_zis" name="id_zis" required>
                    <option value="">-- Pilih ZIS --</option>
                    @foreach($zisMasuk as $zis)
                        <option value="{{ $zis->id_zis }}" 
                            data-sisa="{{ $zis->jumlah - $zis->penyaluran->sum('jumlah') + ($penyaluran->id_zis == $zis->id_zis ? $penyaluran->jumlah : 0) }}"
                            {{ old('id_zis', $penyaluran->id_zis) == $zis->id_zis ? 'selected' : '' }}>
                            {{ $zis->muzakki->nama ?? '-' }} - {{ ucfirst($zis->jenis_zis) }} - 
                            Rp {{ number_format($zis->jumlah, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('id_zis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="id_mustahik">Kepada Mustahik <span class="text-danger">*</span></label>
                <select class="form-control @error('id_mustahik') is-invalid @enderror" 
                        id="id_mustahik" name="id_mustahik" required>
                    <option value="">-- Pilih Mustahik --</option>
                    @foreach($mustahiks as $mustahik)
                        <option value="{{ $mustahik->id_mustahik }}" 
                            {{ old('id_mustahik', $penyaluran->id_mustahik) == $mustahik->id_mustahik ? 'selected' : '' }}>
                            {{ $mustahik->nama }} - {{ ucwords($mustahik->kategori_mustahik ?? '') }}
                        </option>
                    @endforeach
                </select>
                @error('id_mustahik')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tgl_salur">Tanggal Penyaluran <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tgl_salur') is-invalid @enderror" 
                               id="tgl_salur" name="tgl_salur" 
                               value="{{ old('tgl_salur', $penyaluran->tgl_salur ? $penyaluran->tgl_salur->format('Y-m-d') : '') }}" required>
                        @error('tgl_salur')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jumlah">Jumlah yang Disalurkan (Rp) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" 
                               id="jumlah" name="jumlah" value="{{ old('jumlah', $penyaluran->jumlah) }}" 
                               min="0" step="0.01" required>
                        <small class="form-text text-muted" id="sisa-info"></small>
                        @error('jumlah')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="keterangan">Keterangan</label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                          id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $penyaluran->keterangan) }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <a href="{{ route('penyaluran.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('id_zis').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const sisa = selectedOption.getAttribute('data-sisa');
        const sisaInfo = document.getElementById('sisa-info');
        
        if (sisa) {
            sisaInfo.textContent = 'Sisa dana yang bisa disalurkan: Rp ' + parseFloat(sisa).toLocaleString('id-ID');
        } else {
            sisaInfo.textContent = '';
        }
    });

    // Trigger on page load
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('id_zis').dispatchEvent(new Event('change'));
    });
</script>
@endpush
@endsection










