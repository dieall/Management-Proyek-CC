@extends('layouts.app')

@section('title', 'Kalkulator Zakat Akurat')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 text-white rounded-2xl p-8 shadow-xl mb-8 relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-4xl font-extrabold mb-2 flex items-center">
                <i class="fas fa-calculator mr-4 opacity-80"></i>Kalkulator Zakat
            </h1>
            <p class="text-indigo-100 text-lg max-w-2xl">Hitung kewajiban zakat Anda dengan mudah, transparan, dan sesuai syariat.</p>
        </div>
        {{-- Hiasan Background --}}
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
    </div>

    {{-- TABS NAVIGATION --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-2 mb-8">
        <div class="flex flex-col sm:flex-row gap-2" id="zakat-type-tabs">
            <button type="button" data-zakat-type="fitrah" class="zakat-tab-button flex-1 px-6 py-4 text-lg font-bold rounded-lg transition-all duration-300 border-b-4 border-blue-500 text-blue-700 bg-blue-50 shadow-inner">
                <i class="fas fa-dove mr-2"></i>Zakat Fitrah
            </button>
            <button type="button" data-zakat-type="maal" class="zakat-tab-button flex-1 px-6 py-4 text-lg font-bold rounded-lg transition-all duration-300 border-b-4 border-transparent text-gray-500 hover:bg-gray-50 hover:text-gray-700">
                <i class="fas fa-wallet mr-2"></i>Zakat Maal
            </button>
        </div>
    </div>

    {{-- CONTENT CONTAINER --}}
    <div id="zakat-content-container" class="transition-all duration-500">

        {{-- 1. ZAKAT FITRAH SECTION --}}
        <div id="fitrah-content" class="zakat-content animate-fade-in-up">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- INPUT AREA --}}
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center pb-4 border-b border-gray-100">
                        <i class="fas fa-user-group text-indigo-500 mr-3"></i>Data Peserta
                    </h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="fitrah_jumlah_peserta" class="block text-sm font-bold text-gray-700 mb-2">
                                Jumlah Jiwa
                            </label>
                            <div class="relative">
                                <input type="number" id="fitrah_jumlah_peserta" value="1" min="1" class="w-full pl-4 pr-12 py-3 border-2 border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-0 transition text-xl font-bold text-gray-800">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-gray-400 font-semibold">Orang</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-blue-50 p-6 rounded-xl border border-blue-100">
                            <p class="text-sm text-blue-800 font-semibold mb-1">Besaran Zakat per Jiwa</p>
                            <div class="flex items-end gap-2">
                                <p class="text-3xl font-extrabold text-blue-700">Rp {{ number_format($fitrahAmount['uang_rp'], 0, ',', '.') }}</p>
                                <span class="text-sm text-blue-600 mb-1">/ orang</span>
                            </div>
                            <p class="text-xs text-blue-500 mt-2 flex items-center">
                                <i class="fas fa-info-circle mr-1"></i> Setara 3.5 Liter / 2.5 Kg Beras
                            </p>
                        </div>
                    </div>
                </div>

                {{-- OUTPUT AREA --}}
                <div class="bg-indigo-900 rounded-xl shadow-lg p-8 text-white flex flex-col justify-between relative overflow-hidden">
                    <div class="relative z-10">
                        <h4 class="text-xl font-medium text-indigo-200 mb-2">Total Zakat Fitrah</h4>
                        <p id="total_zakat_fitrah" class="text-5xl font-extrabold text-white tracking-tight mb-8">Rp 55.000</p>
                        
                        <div class="bg-white/10 rounded-lg p-4 backdrop-blur-sm border border-white/10 mb-6">
                            <p class="text-sm text-indigo-100">"Rasulullah SAW mewajibkan zakat fitrah untuk menyucikan orang yang berpuasa dari perkataan sia-sia dan keji..." (HR. Abu Daud)</p>
                        </div>
                    </div>
                    
                    <input type="hidden" id="total_zakat_fitrah_value" value="{{ $fitrahAmount['uang_rp'] }}">
                    
                    <button onclick="globalPay('Zakat Fitrah', document.getElementById('total_zakat_fitrah_value').value)" 
                            class="relative z-10 w-full bg-green-500 hover:bg-green-600 text-white py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-green-500/30 transition-all transform hover:-translate-y-1 flex items-center justify-center group">
                        Bayar Sekarang <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </button>
                    
                    {{-- Decoration --}}
                    <div class="absolute bottom-0 right-0 w-48 h-48 bg-indigo-500 opacity-20 rounded-full blur-2xl -mr-10 -mb-10"></div>
                </div>
            </div>
        </div>

        {{-- 2. ZAKAT MAAL SECTION --}}
        <div id="maal-content" class="zakat-content hidden animate-fade-in-up">
            {{-- SUB TABS MAAL --}}
            <div class="flex justify-center mb-8">
                <div class="bg-gray-100 p-1 rounded-lg inline-flex shadow-inner">
                    <button type="button" data-maal-type="penghasilan" class="maal-tab-button px-6 py-2 text-sm font-bold rounded-md transition-all shadow-sm bg-white text-purple-700">
                        <i class="fas fa-money-bill-wave mr-2"></i>Penghasilan
                    </button>
                    <button type="button" data-maal-type="harta" class="maal-tab-button px-6 py-2 text-sm font-bold rounded-md transition-all text-gray-500 hover:text-gray-700">
                        <i class="fas fa-gem mr-2"></i>Simpanan/Harta
                    </button>
                </div>
            </div>

            {{-- MAAL FORMS --}}
            <div id="maal-inner-container">
                <div id="penghasilan-form" class="maal-inner-content">
                    @include('user.kalkulator.maal_penghasilan')
                </div>
                <div id="harta-form" class="maal-inner-content hidden">
                    @include('user.kalkulator.maal_harta')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- BAGIAN ATAS VIEW TETAP SAMA, HANYA UPDATE SCRIPT DI BAWAH INI --}}

@push('scripts')
<script>
    // --- 1. CONFIGURATION & HELPERS (GLOBAL) ---
    window.ZakatConfig = {
        fitrahPerSoul: {{ $fitrahAmount['uang_rp'] }},
        // Terima 2 jenis nishab dari controller
        nishabMaalTahun: {{ $nishabTahun }}, 
        nishabPenghasilanBulan: {{ $nishabBulan }},
        paymentUrl: '{{ route('user.pembayaran.create') }}'
    };

    // Helper Format Rupiah Global
    window.formatRupiah = function(value) {
        return 'Rp ' + (value || 0).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
    };

    // Helper Parse Rupiah Global
    window.parseRupiah = function(str) {
        if (!str) return 0;
        const cleanStr = str.toString().replace(/[^0-9]/g, ''); 
        return parseFloat(cleanStr) || 0;
    };

    // Helper Auto Format Input
    window.autoFormatInput = function(inputElement) {
        let value = window.parseRupiah(inputElement.value);
        if (value > 0) {
            inputElement.value = value.toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
        } else {
            if(inputElement.value !== '') inputElement.value = '';
        }
    };

    // Helper Redirect Pembayaran
    window.globalPay = function(subJenis, jumlah) {
        if(jumlah <= 0) {
            alert('Jumlah zakat belum valid.');
            return;
        }
        const url = `${window.ZakatConfig.paymentUrl}?jenis=Zakat&sub=${encodeURIComponent(subJenis)}&jumlah=${jumlah}`;
        window.location.href = url;
    };

    // --- LOGIKA UI TABS & FITRAH (Sama seperti sebelumnya) ---
    document.addEventListener('DOMContentLoaded', function() {
        const fitrahInput = document.getElementById('fitrah_jumlah_peserta');
        if (fitrahInput) {
            fitrahInput.addEventListener('input', function() {
                const jiwa = parseInt(this.value) || 0;
                const total = jiwa * window.ZakatConfig.fitrahPerSoul;
                document.getElementById('total_zakat_fitrah').textContent = window.formatRupiah(total);
                document.getElementById('total_zakat_fitrah_value').value = total;
            });
        }

        // Tab Logic (Copy dari kode sebelumnya atau biarkan jika sudah jalan)
        const zakatTabs = document.querySelectorAll('.zakat-tab-button');
        zakatTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const type = this.dataset.zakatType;
                zakatTabs.forEach(t => t.className = 'zakat-tab-button flex-1 px-6 py-4 text-lg font-bold rounded-lg transition-all duration-300 border-b-4 border-transparent text-gray-500 hover:bg-gray-50 hover:text-gray-700');
                this.className = 'zakat-tab-button flex-1 px-6 py-4 text-lg font-bold rounded-lg transition-all duration-300 border-b-4 border-blue-500 text-blue-700 bg-blue-50 shadow-inner';
                document.getElementById('fitrah-content').classList.add('hidden');
                document.getElementById('maal-content').classList.add('hidden');
                if (type === 'fitrah') document.getElementById('fitrah-content').classList.remove('hidden');
                else document.getElementById('maal-content').classList.remove('hidden');
            });
        });

        const maalTabs = document.querySelectorAll('.maal-tab-button');
        maalTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const type = this.dataset.maalType;
                maalTabs.forEach(t => t.className = 'maal-tab-button px-6 py-2 text-sm font-bold rounded-md transition-all text-gray-500 hover:text-gray-700');
                this.className = 'maal-tab-button px-6 py-2 text-sm font-bold rounded-md transition-all shadow-sm bg-white text-purple-700';
                document.querySelectorAll('.maal-inner-content').forEach(c => c.classList.add('hidden'));
                if (type === 'penghasilan') document.getElementById('penghasilan-form').classList.remove('hidden');
                else document.getElementById('harta-form').classList.remove('hidden');
            });
        });
    });
</script>
@endpush