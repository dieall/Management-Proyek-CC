@extends('layouts.app')

@section('title', 'Input Pembayaran ZIS')
@section('page_title', 'Input Zakat, Infak, dan Sedekah')

@section('content')
<div class="space-y-8">
    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-2xl p-8 shadow-lg">
        <h1 class="text-4xl font-bold mb-2 flex items-center">
            <i class="fas fa-money-bill-wave mr-3"></i>Input Pembayaran ZIS
        </h1>
        <p class="text-purple-100">Hitung dan bayar zakat, infak, atau sedekah Anda dengan mudah</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-8">
        {{-- PAYER INFO --}}
        <div class="mb-8 p-6 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border-l-4 border-blue-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-700 font-semibold mb-1 flex items-center">
                        <i class="fas fa-user-circle text-blue-600 mr-2 text-lg"></i>Pembayar
                    </p>
                    <p class="text-2xl font-bold text-blue-900">{{ Auth::user()->name ?? 'Pengguna' }}</p>
                </div>
                <div class="text-right">
                    <p class="text-blue-600 text-sm font-semibold">Status Muzakki</p>
                    <p class="text-2xl font-bold text-green-600 flex items-center justify-end">
                        <i class="fas fa-check-circle mr-2"></i>DISETUJUI
                    </p>
                </div>
            </div>
        </div>

        <form action="{{ route('user.pembayaran.store') }}" method="POST" class="space-y-8">
            @csrf
            <input type="hidden" name="tanggal_pembayaran" value="{{ now()->format('Y-m-d') }}">
            <input type="hidden" name="sub_jenis_zis" id="final_sub_jenis_zis">

            {{-- STEP 1: JENIS DONASI --}}
            <div class="bg-gray-50 rounded-xl p-6 border-2 border-gray-200">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-600 text-white rounded-full font-bold mr-3">1</span>
                    Jenis Donasi
                </h3>
                <select name="jenis_zis" id="jenis_zis" required class="w-full py-3 px-4 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition text-gray-800 font-semibold">
                    <option value="">-- Pilih Zakat / Infak / Sedekah --</option>
                    <option value="Zakat" {{ old('jenis_zis') == 'Zakat' ? 'selected' : '' }}>
                        <i class="fas fa-hands-praying"></i> Zakat
                    </option>
                    <option value="Infak" {{ old('jenis_zis') == 'Infak' ? 'selected' : '' }}>
                        <i class="fas fa-heart"></i> Infak
                    </option>
                    <option value="Sedekah" {{ old('jenis_zis') == 'Sedekah' ? 'selected' : '' }}>
                        <i class="fas fa-gift"></i> Sedekah
                    </option>
                </select>
                @error('jenis_zis')
                    <p class="text-red-600 text-sm mt-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            {{-- STEP 2: ZAKAT DETAILS (Dynamic) --}}
            <div id="zakat-block" class="hidden bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-6 border-2 border-yellow-300">
                <h3 class="text-xl font-bold text-yellow-900 mb-4 flex items-center">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-yellow-600 text-white rounded-full font-bold mr-3">2</span>
                    Detail Zakat
                </h3>

                <div class="mb-6">
                    <label for="tipe_zakat" class="block text-sm font-bold text-yellow-900 mb-3">Tipe Zakat</label>
                    <select id="tipe_zakat" class="w-full py-3 px-4 border-2 border-yellow-300 rounded-lg focus:border-yellow-500 focus:ring-2 focus:ring-yellow-200 transition text-gray-800 font-semibold">
                        <option value="">-- Pilih Zakat Fitrah atau Maal --</option>
                        @foreach ($zakatTypes as $tipe)
                            <option value="{{ $tipe }}" {{ old('tipe_zakat') == $tipe ? 'selected' : '' }}>{{ $tipe }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- FITRAH CALCULATOR --}}
                <div id="fitrah-calc" class="hidden bg-white rounded-lg p-6 border-2 border-yellow-200 mb-6">
                    <h4 class="font-bold text-lg text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-calculator text-purple-600 mr-2"></i>Kalkulator Zakat Fitrah
                    </h4>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="jumlah_peserta" class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Peserta</label>
                            <input type="number" id="jumlah_peserta" value="1" min="1" class="w-full py-2 px-3 border-2 border-gray-300 rounded-lg focus:border-blue-500">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="nama_peserta" class="block text-sm font-semibold text-gray-700 mb-2">Nama Peserta (Opsional)</label>
                        <textarea id="nama_peserta" rows="2" placeholder="Contoh: Suami, Istri, Anak 1, Anak 2" class="w-full py-2 px-3 border-2 border-gray-300 rounded-lg focus:border-blue-500"></textarea>
                    </div>
                    
                    <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-4 rounded-lg border-l-4 border-purple-600 mb-4">
                        <p class="text-sm text-gray-700 mb-1">Besar zakat fitrah per jiwa:</p>
                        <p class="text-3xl font-bold text-purple-700 mb-2">Rp {{ number_format($fitrahAmount['uang_rp'], 0, ',', '.') }}</p>
                        <p class="text-xs text-gray-600">* Setara dengan harga beras {{ $fitrahAmount['beras_kg'] }}</p>
                    </div>

                    <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-600">
                        <p class="text-sm text-gray-600 mb-1">Total zakat fitrah yang harus dibayar:</p>
                        <p id="total_zakat_fitrah_output" class="text-4xl font-extrabold text-blue-700">Rp 55.000</p>
                    </div>
                </div>

                {{-- MAAL DETAILS --}}
                <div id="maal-detail" class="hidden bg-white rounded-lg p-6 border-2 border-yellow-200">
                    <h4 class="font-bold text-lg text-gray-800 mb-4">Jenis Zakat Maal</h4>
                    
                    <select id="sub_jenis_maal_select" class="w-full py-3 px-4 border-2 border-gray-300 rounded-lg focus:border-blue-500 mb-4 text-gray-800 font-semibold">
                        <option value="">-- Pilih Kategori Zakat Maal --</option>
                        @foreach ($subJenisZakatMaal as $sub)
                            <option value="{{ $sub }}">{{ $sub }}</option>
                        @endforeach
                    </select>

                    <div class="bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-500 text-sm">
                        <p class="font-semibold text-yellow-900 mb-2">
                            <i class="fas fa-info-circle mr-2"></i>Catatan Penting
                        </p>
                        <p class="text-yellow-800">Nominal Zakat Maal harus dihitung secara mandiri. Anda dapat menggunakan <a href="{{ route('user.kalkulator.index') }}" class="font-bold text-blue-600 hover:text-blue-700">Halaman Kalkulator Zakat</a> untuk menghitung dengan akurat. Masukkan hasilnya di kolom nominal di bawah.</p>
                    </div>
                </div>
            </div>

            {{-- STEP 3: NOMINAL AMOUNT --}}
            <div class="bg-gray-50 rounded-xl p-6 border-2 border-gray-200">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-green-600 text-white rounded-full font-bold mr-3">3</span>
                    Jumlah Nominal Pembayaran
                </h3>
                <div class="relative">
                    <span class="absolute left-4 top-3 text-2xl font-bold text-gray-700">Rp</span>
                    <input type="number" name="jumlah" id="jumlah" required placeholder="Masukkan jumlah yang akan dibayarkan"
                           min="1000" class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:border-green-500 focus:ring-2 focus:ring-green-200 transition text-2xl font-bold">
                </div>
                @error('jumlah')
                    <p class="text-red-600 text-sm mt-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            {{-- STEP 4: NOTES --}}
            <div class="bg-gray-50 rounded-xl p-6 border-2 border-gray-200">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-600 text-white rounded-full font-bold mr-3">4</span>
                    Catatan (Opsional)
                </h3>
                <textarea name="keterangan" id="keterangan" rows="3" placeholder="Contoh: Pembayaran Zakat Penghasilan, Zakat Emas, atau hal lainnya yang ingin Anda catat" class="w-full py-3 px-4 border-2 border-gray-300 rounded-lg focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"></textarea>
            </div>

            {{-- SUBMIT BUTTON --}}
            <button type="submit" class="w-full bg-gradient-to-r from-green-600 to-green-700 text-white py-4 rounded-xl hover:from-green-700 hover:to-green-800 transition font-bold text-lg flex items-center justify-center shadow-lg hover:shadow-xl">
                <i class="fas fa-check-circle mr-3"></i>Konfirmasi dan Bayar ZIS
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jenisZis = document.getElementById('jenis_zis');
        const tipeZakat = document.getElementById('tipe_zakat');
        const subJenisMaalSelect = document.getElementById('sub_jenis_maal_select');
        const finalSubJenisZis = document.getElementById('final_sub_jenis_zis');
        
        const zakatBlock = document.getElementById('zakat-block');
        const fitrahCalc = document.getElementById('fitrah-calc');
        const maalDetail = document.getElementById('maal-detail');
        const jumlahInput = document.getElementById('jumlah');

        const jumlahPesertaInput = document.getElementById('jumlah_peserta');
        const totalZakatFitrahOutput = document.getElementById('total_zakat_fitrah_output');
        const fitrahPerJiwa = {{ $fitrahAmount['uang_rp'] }};

        function calculateFitrah() {
            const jiwa = parseInt(jumlahPesertaInput.value) || 0;
            const total = jiwa * fitrahPerJiwa;
            
            const formattedTotal = total.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            });
            
            totalZakatFitrahOutput.textContent = formattedTotal;
            jumlahInput.value = total;
            finalSubJenisZis.value = 'Zakat Fitrah Uang';
        }

        function updateZakatContent() {
            const selectedJenis = jenisZis.value;
            const selectedTipe = tipeZakat.value;

            if (selectedJenis === 'Zakat') {
                zakatBlock.classList.remove('hidden');
            } else {
                zakatBlock.classList.add('hidden');
                fitrahCalc.classList.add('hidden');
                maalDetail.classList.add('hidden');
                tipeZakat.value = '';
                finalSubJenisZis.value = '';
                jumlahInput.value = '';
                return;
            }

            fitrahCalc.classList.add('hidden');
            maalDetail.classList.add('hidden');
            jumlahInput.value = '';
            finalSubJenisZis.value = '';

            if (selectedTipe.includes('Fitrah')) {
                fitrahCalc.classList.remove('hidden');
                calculateFitrah();
            } else if (selectedTipe.includes('Maal')) {
                maalDetail.classList.remove('hidden');
            }
        }
        
        function updateMaalSubJenis() {
            if (tipeZakat.value.includes('Maal') && subJenisMaalSelect.value) {
                finalSubJenisZis.value = subJenisMaalSelect.value;
            } else if (!tipeZakat.value.includes('Fitrah')) {
                finalSubJenisZis.value = '';
            }
        }

        jenisZis.addEventListener('change', updateZakatContent);
        tipeZakat.addEventListener('change', updateZakatContent);
        jumlahPesertaInput.addEventListener('input', calculateFitrah);
        subJenisMaalSelect.addEventListener('change', updateMaalSubJenis);

        updateZakatContent();
    });
</script>
@endpush
@endsection