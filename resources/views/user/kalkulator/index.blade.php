@extends('layouts.app')

@section('title', 'Kalkulator Zakat Akurat')
@section('page_title', 'Hitung Zakat Anda dengan Akurat')

@section('content')
<div class="space-y-8">
    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-2xl p-8 shadow-lg">
        <h1 class="text-4xl font-bold mb-2 flex items-center">
            <i class="fas fa-calculator mr-3"></i>Kalkulator Zakat
        </h1>
        <p class="text-indigo-100">Hitung kewajibanatan zakat Anda dengan mudah dan akurat</p>
    </div>

    {{-- TABS NAVIGATION --}}
    <div class="bg-white rounded-xl shadow-md p-1">
        <div class="flex gap-2" id="zakat-type-tabs">
            <button type="button" data-zakat-type="fitrah" class="zakat-tab-button flex-1 px-4 py-4 text-lg font-bold rounded-lg transition 
                border-b-4 border-blue-500 text-blue-600 bg-blue-50">
                <i class="fas fa-dove mr-2"></i>Zakat Fitrah
            </button>
            <button type="button" data-zakat-type="maal" class="zakat-tab-button flex-1 px-4 py-4 text-lg font-bold rounded-lg transition 
                border-b-4 border-transparent text-gray-600 hover:bg-gray-50">
                <i class="fas fa-wallet mr-2"></i>Zakat Maal
            </button>
        </div>
    </div>

    {{-- CONTENT CONTAINER --}}
    <div id="zakat-content-container" class="space-y-8">

        {{-- ZAKAT FITRAH SECTION --}}
        <div id="fitrah-content" class="zakat-content">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- INPUT AREA --}}
                <div class="bg-white rounded-xl shadow-md p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-input-numeric text-indigo-600 mr-3"></i>Data Peserta
                    </h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="fitrah_jumlah_peserta" class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fas fa-people-group text-indigo-500 mr-2"></i>Jumlah Peserta
                            </label>
                            <input type="number" id="fitrah_jumlah_peserta" value="1" min="1" class="w-full py-3 px-4 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-lg font-semibold">
                        </div>
                        
                        <div>
                            <label for="nama_peserta" class="block text-sm font-bold text-gray-700 mb-2">
                                <i class="fas fa-list text-indigo-500 mr-2"></i>Nama Peserta (Opsional)
                            </label>
                            <textarea id="nama_peserta" rows="4" placeholder="Contoh:&#10;- Suami&#10;- Istri&#10;- Anak 1&#10;- Anak 2" class="w-full py-3 px-4 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition text-sm"></textarea>
                        </div>

                        <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-lg border-2 border-indigo-200">
                            <p class="text-sm text-gray-700 font-semibold mb-2">Besar Zakat Fitrah Per Jiwa:</p>
                            <p class="text-4xl font-extrabold text-indigo-700 mb-3">Rp {{ number_format($fitrahAmount['uang_rp'], 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-600">
                                <i class="fas fa-info-circle mr-1"></i>
                                Setara dengan beras {{ $fitrahAmount['beras_kg'] }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- OUTPUT AREA --}}
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-md p-8 border-2 border-blue-300 flex flex-col justify-between">
                    <div>
                        <h4 class="text-2xl font-bold text-blue-900 mb-4 flex items-center">
                            <i class="fas fa-calculator text-blue-600 mr-2"></i>Total Kewajiban
                        </h4>
                        <p class="text-sm text-blue-700 font-semibold mb-2">Jumlah yang harus dibayar:</p>
                        <p id="total_zakat_fitrah" class="text-5xl font-extrabold text-blue-700 mb-6">Rp 55.000</p>
                        <input type="hidden" id="total_zakat_fitrah_value" value="{{ $fitrahAmount['uang_rp'] }}">
                    </div>
                    
                    <button onclick="copyToPayment('Zakat Fitrah Uang', document.getElementById('total_zakat_fitrah_value').value)" 
                            class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-4 rounded-lg hover:from-green-700 hover:to-green-800 transition font-bold text-lg flex items-center justify-center shadow-lg hover:shadow-xl">
                        <i class="fas fa-arrow-right mr-2"></i>Bayar Sekarang
                    </button>
                </div>
            </div>
        </div>

        {{-- ZAKAT MAAL SECTION --}}
        <div id="maal-content" class="zakat-content hidden">
            {{-- SUB TABS --}}
            <div class="bg-white rounded-xl shadow-md p-1 mb-8">
                <div class="flex gap-2" id="maal-sub-tabs">
                    <button type="button" data-maal-type="penghasilan" class="maal-tab-button flex-1 px-4 py-4 text-lg font-bold rounded-lg transition 
                        border-b-4 border-purple-500 text-purple-600 bg-purple-50">
                        <i class="fas fa-hand-holding-usd mr-2"></i>Penghasilan
                    </button>
                    <button type="button" data-maal-type="harta" class="maal-tab-button flex-1 px-4 py-4 text-lg font-bold rounded-lg transition 
                        border-b-4 border-transparent text-gray-600 hover:bg-gray-50">
                        <i class="fas fa-coins mr-2"></i>Harta
                    </button>
                </div>
            </div>

            {{-- MAAL CONTENT CONTAINER --}}
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

@push('scripts')
<script>
    const fitrahAmount = @json($fitrahAmount);
    const nishab = @json($nishab);

    function formatRupiah(number) {
        return 'Rp ' + (parseFloat(number) || 0).toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
    }
    
    function copyToPayment(subJenis, jumlah) {
        const url = '{{ route('user.pembayaran.create') }}';
        window.location.href = `${url}?jenis=Zakat&sub=${encodeURIComponent(subJenis)}&jumlah=${jumlah}`;
    }

    function calculateFitrah() {
        const pesertaInput = document.getElementById('fitrah_jumlah_peserta');
        const totalFitrahDiv = document.getElementById('total_zakat_fitrah');
        const totalFitrahValueInput = document.getElementById('total_zakat_fitrah_value');

        const jiwa = parseInt(pesertaInput?.value) || 0;
        const total = jiwa * fitrahAmount.uang_rp;
        
        totalFitrahDiv.textContent = formatRupiah(total);
        totalFitrahValueInput.value = total;
    }

    function updateMaalCalculation(formId, isIncome) {
        const form = document.getElementById(formId);
        if (!form) return;

        let totalHarta = 0;
        let hutang = 0;
        
        const inputs = form.querySelectorAll('input[type="text"]');
        
        inputs.forEach(input => {
            let value = parseFloat(input.value.replace(/\./g, '').replace(/,/g, '.')) || 0;
            
            if (input.id.includes('hutang') || input.id.includes('cicilan')) {
                hutang += value;
            } else if (value > 0) {
                totalHarta += value;
            }
        });

        const nishabValue = nishab;
        const bersih = totalHarta - hutang;
        let nilaiZakat = 0;
        
        if (bersih >= nishabValue && bersih > 0) {
            nilaiZakat = bersih * 0.025;
            ketentuanText = 'Wajib Zakat';
            ketentuanClass = 'bg-green-100 text-green-700';
        } else {
            ketentuanText = 'Belum Wajib Zakat';
            ketentuanClass = 'bg-yellow-100 text-yellow-700';
        }

        const resultDiv = form.querySelector('[data-zakat-result]');
        if (resultDiv) {
            resultDiv.innerHTML = `
                <div class="${ketentuanClass} p-4 rounded-lg mb-4 font-bold">${ketentuanText}</div>
                <div>
                    <p class="text-sm text-gray-600 mb-2">Total Harta: ${formatRupiah(totalHarta)}</p>
                    <p class="text-sm text-gray-600 mb-2">Hutang/Cicilan: ${formatRupiah(hutang)}</p>
                    <p class="text-sm text-gray-600 mb-4">Harta Bersih: ${formatRupiah(bersih)}</p>
                    <hr class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Zakat (2.5%): ${formatRupiah(nilaiZakat)}</p>
                    <button onclick="copyToPayment('Zakat Maal ${isIncome ? 'Penghasilan' : 'Harta'}', ${nilaiZakat})" class="mt-4 w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 font-bold">
                        Bayar Zakat Maal Sekarang →
                    </button>
                </div>
            `;
        }
    }

    // --- EVENT LISTENERS ---
    document.addEventListener('DOMContentLoaded', function() {
        const zakatTypeTabs = document.querySelectorAll('.zakat-tab-button');
        const maalSubTabs = document.querySelectorAll('.maal-tab-button');
        const fitrahInput = document.getElementById('fitrah_jumlah_peserta');

        zakatTypeTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const type = this.dataset.zakatType;
                
                zakatTypeTabs.forEach(t => t.classList.remove('border-b-4', 'border-blue-500', 'text-blue-600', 'bg-blue-50'));
                this.classList.add('border-b-4', 'border-blue-500', 'text-blue-600', 'bg-blue-50');
                
                document.querySelectorAll('.zakat-content').forEach(content => content.classList.add('hidden'));
                
                if (type === 'fitrah') {
                    document.getElementById('fitrah-content').classList.remove('hidden');
                } else {
                    document.getElementById('maal-content').classList.remove('hidden');
                }
            });
        });

        maalSubTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const type = this.dataset.maalType;
                
                maalSubTabs.forEach(t => t.classList.remove('border-b-4', 'border-purple-500', 'text-purple-600', 'bg-purple-50'));
                this.classList.add('border-b-4', 'border-purple-500', 'text-purple-600', 'bg-purple-50');
                
                document.querySelectorAll('.maal-inner-content').forEach(content => content.classList.add('hidden'));
                
                if (type === 'penghasilan') {
                    document.getElementById('penghasilan-form').classList.remove('hidden');
                } else {
                    document.getElementById('harta-form').classList.remove('hidden');
                }
            });
        });

        if (fitrahInput) {
            fitrahInput.addEventListener('input', calculateFitrah);
            calculateFitrah();
        }
    });
</script>
@endpush