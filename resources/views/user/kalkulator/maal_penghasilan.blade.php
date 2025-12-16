{{-- Logic perhitungan Zakat Maal Penghasilan (Gambar fb443a.png) --}}
<h4 class="font-bold text-lg mb-4">Komponen Zakat</h4>
<p class="text-sm text-gray-500 mb-4">Silahkan diisi dengan pendapatan bulanan Anda. Perhitungan Nishob tetap didasarkan pada nishob emas 85 gr yang dihitung bulanan.</p>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    {{-- Input Komponen --}}
    <div>
        {{-- Tombol Perbulan/Pertahun --}}
        <div class="flex space-x-4 mb-4">
            <label class="inline-flex items-center">
                <input type="radio" name="freq_penghasilan" value="bulanan" checked class="form-radio text-blue-600">
                <span class="ml-2">Perbulan</span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="freq_penghasilan" value="tahunan" class="form-radio text-blue-600" disabled>
                <span class="ml-2">Pertahun</span>
            </label>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Pendapatan (Gaji bulanan)</label>
            <input type="text" id="pendapatan_gaji" value="" placeholder="Rp." class="w-full py-2 px-3 border rounded text-right">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Pendapatan lain bulanan (opsional)</label>
            <input type="text" id="pendapatan_lain" value="" placeholder="Rp." class="w-full py-2 px-3 border rounded text-right">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Hutang/Cicilan bulanan (opsional)</label>
            <input type="text" id="hutang_cicilan" value="" placeholder="Rp." class="w-full py-2 px-3 border rounded text-right">
        </div>
        
        <div class="mt-6">
            <label for="jenis_maal_penghasilan" class="block text-gray-700 font-bold mb-2">Pilih Jenis Zakat Maal *</label>
            <select id="jenis_maal_penghasilan" class="w-full py-2 px-3 border rounded">
                <option value="Zakat Penghasilan">Zakat Penghasilan</option>
            </select>
        </div>
    </div>

    {{-- Output Nilai Zakat --}}
    <div class="p-4 bg-yellow-50 border rounded-lg">
        <h4 class="font-semibold text-lg text-yellow-800 mb-3">Nilai Zakat</h4>
        <div class="mb-3 p-2 rounded text-center font-bold bg-red-100 text-red-700" id="maal_ketentuan">
            Hitung untuk melihat ketentuan
        </div>

        <div class="space-y-3">
            <p class="text-sm text-gray-600">Total Harta (Bersih): <span id="maal_total_harta" class="font-semibold text-gray-800 float-right">Rp 0</span></p>
            <p class="text-sm text-gray-600">Nishab (Batas Wajib): <span id="maal_nishab" class="font-semibold text-gray-800 float-right">Rp {{ number_format($nishab, 0, ',', '.') }}</span></p>
        </div>
        <hr class="my-3">
        <p class="text-sm text-gray-600">Nilai Zakat (2.5%):</p>
        <p id="maal_nilai_zakat" class="text-3xl font-extrabold text-blue-600">Rp 0</p>
        
        <input type="hidden" id="maal_zakat_input_final" value="0">
        
        <button onclick="copyToPayment(document.getElementById('jenis_maal_penghasilan').value, document.getElementById('maal_zakat_input_final').value)" 
                class="mt-4 bg-blue-600 text-white px-4 py-2 rounded w-full hover:bg-blue-700">
            Bayar Zakat Penghasilan &rarr;
        </button>
    </div>
</div>