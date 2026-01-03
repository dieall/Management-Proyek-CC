@extends('layouts.app')

@section('title', 'Edit Penyaluran - Manajemen ZIS')
@section('page_title', 'Edit Penyaluran')

@section('content')
<div class="row">
    <div class="col-lg-9 mx-auto">
        {{-- Header Card --}}
        <div class="card mb-4 border-0" style="background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%); color: white; border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center">
                    <div style="font-size: 3rem; opacity: 0.3;">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div class="ms-4">
                        <h4 class="mb-1">
                            <i class="fas fa-pencil me-2"></i>Edit Penyaluran ZIS
                        </h4>
                        <p class="small mb-0 opacity-90">Perbarui informasi penyaluran dana ZIS</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Card --}}
        <form action="{{ route('admin.penyaluran.update', $penyaluran) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            {{-- SECTION 1: SUMBER DANA ZIS --}}
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-light border-bottom" style="border-radius: 8px 8px 0 0;">
                    <h6 class="mb-0 fw-bold" style="color: #2196f3;">
                        <i class="fas fa-step-backward me-2"></i>STEP 1: Sumber Dana
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-4">
                        <label for="id_zis" class="form-label fw-bold">
                            Dari Mana Dana Ini Berasal? <span class="text-danger">*</span>
                        </label>
                        <p class="text-muted small mb-3">
                            <i class="fas fa-info-circle me-1"></i>Sumber dana ZIS yang disalurkan
                        </p>
                        <select id="id_zis" name="id_zis" required class="form-select form-select-lg" onchange="updateZisInfo()" style="border-radius: 8px; border: 2px solid #e0e0e0;">
                            <option value="">-- Pilih Sumber Dana ZIS --</option>
                            @foreach($zismasuk as $zis)
                                @php
                                    $tersalur = $zis->penyaluran()->sum('jumlah');
                                    $sisa = $zis->jumlah - $tersalur;
                                @endphp
                                <option value="{{ $zis->id_zis }}" 
                                    data-jumlah="{{ $zis->jumlah }}"
                                    data-sisa="{{ $sisa }}"
                                    data-pembayar="{{ $zis->muzakki->nama }}"
                                    data-jenis="{{ $zis->jenis_zis }}"
                                    {{ old('id_zis', $penyaluran->id_zis) == $zis->id_zis ? 'selected' : '' }}>
                                    {{ $zis->muzakki->nama }} • {{ $zis->jenis_zis }} • Rp {{ number_format($zis->jumlah, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_zis')
                            <div class="alert alert-danger alert-sm mt-3 py-2 px-3" style="border-radius: 6px;">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- INFO BOX - Dana Details --}}
            <div id="infoBox" class="card mb-4 border-0 d-none" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border-radius: 8px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3" style="color: #0d47a1;">
                        <i class="fas fa-circle-info me-2"></i>Informasi Sumber Dana
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3" style="background: white; border-radius: 8px; border-left: 4px solid #2196f3;">
                                <p class="text-muted small mb-1">Pembayar (Muzakki)</p>
                                <p class="h6 fw-bold mb-0" id="infoPembayar">-</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3" style="background: white; border-radius: 8px; border-left: 4px solid #2196f3;">
                                <p class="text-muted small mb-1">Jenis ZIS</p>
                                <p class="h6 fw-bold mb-0" id="infoJenis">-</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3" style="background: white; border-radius: 8px; border-left: 4px solid #4caf50;">
                                <p class="text-muted small mb-1">Total Dana yang Masuk</p>
                                <p class="h6 fw-bold mb-0" style="color: #4caf50;" id="infoTotal">Rp 0</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3" style="background: white; border-radius: 8px; border-left: 4px solid #ff5252;">
                                <p class="text-muted small mb-1">Sisa Dana Tersedia</p>
                                <p class="h6 fw-bold mb-0" style="color: #ff5252;" id="infoSisa">Rp 0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: PENERIMA & TANGGAL --}}
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-light border-bottom" style="border-radius: 8px 8px 0 0;">
                    <h6 class="mb-0 fw-bold" style="color: #2196f3;">
                        <i class="fas fa-step-forward me-2"></i>STEP 2: Penerima & Tanggal
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label for="id_mustahik" class="form-label fw-bold">
                                Siapa Penerima? <span class="text-danger">*</span>
                            </label>
                            <p class="text-muted small mb-3">Mustahik yang menerima dana</p>
                            <select id="id_mustahik" name="id_mustahik" required class="form-select form-select-lg" style="border-radius: 8px; border: 2px solid #e0e0e0;">
                                <option value="">-- Pilih Mustahik --</option>
                                @foreach($mustahik as $m)
                                    <option value="{{ $m->id_mustahik }}" {{ old('id_mustahik', $penyaluran->id_mustahik) == $m->id_mustahik ? 'selected' : '' }}>
                                        {{ $m->nama }} • {{ $m->kategori_mustahik }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_mustahik')
                                <div class="alert alert-danger alert-sm mt-3 py-2 px-3" style="border-radius: 6px;">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="tgl_salur" class="form-label fw-bold">
                                Kapan Disalurkan? <span class="text-danger">*</span>
                            </label>
                            <p class="text-muted small mb-3">Tanggal penyaluran dana</p>
                            <input type="date" id="tgl_salur" name="tgl_salur" value="{{ old('tgl_salur', $penyaluran->tgl_salur->format('Y-m-d')) }}" required 
                                class="form-control form-control-lg" style="border-radius: 8px; border: 2px solid #e0e0e0;">
                            @error('tgl_salur')
                                <div class="alert alert-danger alert-sm mt-3 py-2 px-3" style="border-radius: 6px;">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION 3: NOMINAL --}}
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-light border-bottom" style="border-radius: 8px 8px 0 0;">
                    <h6 class="mb-0 fw-bold" style="color: #2196f3;">
                        <i class="fas fa-coins me-2"></i>STEP 3: Nominal Penyaluran
                    </h6>
                </div>
                <div class="card-body p-4">
                    <label for="jumlah" class="form-label fw-bold">
                        Berapa Jumlahnya? <span class="text-danger">*</span>
                    </label>
                    <p class="text-muted small mb-3">Nominal penyaluran</p>
                    
                    <div class="input-group input-group-lg mb-3" style="border-radius: 8px; overflow: hidden;">
                        <span class="input-group-text fw-bold" style="background-color: #2196f3; color: white; border: none;">Rp</span>
                        <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah', $penyaluran->jumlah) }}" 
                            min="0" step="1000" required class="form-control" placeholder="Contoh: 1000000"
                            style="border: 2px solid #e0e0e0; font-size: 1.1rem;">
                    </div>

                    @error('jumlah')
                        <div class="alert alert-danger alert-sm mt-3 py-2 px-3" style="border-radius: 6px;">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            {{-- SECTION 4: KETERANGAN --}}
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-light border-bottom" style="border-radius: 8px 8px 0 0;">
                    <h6 class="mb-0 fw-bold" style="color: #2196f3;">
                        <i class="fas fa-note-sticky me-2"></i>STEP 4: Catatan (Opsional)
                    </h6>
                </div>
                <div class="card-body p-4">
                    <label for="keterangan" class="form-label fw-bold">
                        Ada Catatan Khusus?
                    </label>
                    <p class="text-muted small mb-3">Cantumkan alasan atau keterangan penyaluran</p>
                    <textarea id="keterangan" name="keterangan" rows="4" class="form-control" 
                        placeholder="Contoh: Bantuan untuk bencana alam, kebutuhan mendesak, program pendidikan, dll..." 
                        style="border: 2px solid #e0e0e0; border-radius: 8px;">{{ old('keterangan', $penyaluran->keterangan) }}</textarea>
                </div>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-lg fw-bold flex-grow-1" style="background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%); color: white; border: none; border-radius: 8px;">
                            <i class="fas fa-check-circle me-2"></i>Perbarui Penyaluran
                        </button>
                        <a href="{{ route('admin.penyaluran.show', $penyaluran) }}" class="btn btn-lg btn-light fw-bold" style="border: 2px solid #e0e0e0; border-radius: 8px;">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let sisaDanaGlobal = 0;

    function updateZisInfo() {
        const select = document.getElementById('id_zis');
        const selectedOption = select.options[select.selectedIndex];
        const infoBox = document.getElementById('infoBox');

        if (selectedOption.value === '') {
            infoBox.classList.add('d-none');
            sisaDanaGlobal = 0;
            return;
        }

        const pembayar = selectedOption.getAttribute('data-pembayar');
        const jenis = selectedOption.getAttribute('data-jenis');
        const total = parseInt(selectedOption.getAttribute('data-jumlah'));
        const sisa = parseInt(selectedOption.getAttribute('data-sisa'));

        sisaDanaGlobal = sisa;

        // Update info box
        document.getElementById('infoPembayar').textContent = pembayar;
        document.getElementById('infoJenis').textContent = jenis;
        document.getElementById('infoTotal').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        document.getElementById('infoSisa').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(sisa);

        // Show info box
        infoBox.classList.remove('d-none');
    }

    // Initialize on page load if ZIS already selected
    document.addEventListener('DOMContentLoaded', function() {
        updateZisInfo();
    });
</script>
@endpush
@endsection
