<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    {{-- INPUT AREA --}}
    <div class="lg:col-span-7 bg-white rounded-xl shadow-lg border border-gray-100 p-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-800">
                <i class="fas fa-coins text-amber-600 mr-2"></i>Aset & Simpanan (Haul 1 Tahun)
            </h3>
        </div>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Uang Tunai/Tabungan/Deposito</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold">Rp</span>
                    <input type="text" id="wealth_tabungan"
                        class="wealth-input w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-0 transition font-semibold text-right"
                        placeholder="0">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nilai Emas/Perak/Logam Mulia</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold">Rp</span>
                    <input type="text" id="wealth_emas"
                        class="wealth-input w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-0 transition font-semibold text-right"
                        placeholder="0">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Surat Berharga/Saham/Investasi</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold">Rp</span>
                    <input type="text" id="wealth_saham"
                        class="wealth-input w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:border-amber-500 focus:ring-0 transition font-semibold text-right"
                        placeholder="0">
                </div>
            </div>

            <div class="pt-4 border-t border-dashed border-gray-200">
                <label class="block text-sm font-bold text-gray-700 mb-2">Hutang Jatuh Tempo</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-red-500 font-bold">Rp</span>
                    <input type="text" id="wealth_hutang"
                        class="wealth-input w-full pl-12 pr-4 py-3 border-2 border-red-200 rounded-lg focus:border-red-500 focus:ring-0 transition font-semibold text-right text-red-600"
                        placeholder="0">
                </div>
            </div>
        </div>
    </div>

    {{-- OUTPUT AREA --}}
    <div class="lg:col-span-5 flex flex-col">
        <div
            class="bg-gradient-to-br from-amber-50 to-white rounded-xl shadow-lg border border-amber-100 p-6 h-full flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-bold text-amber-900 mb-4 border-b border-amber-200 pb-2">Rincian Perhitungan
                </h3>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Harta</span>
                        <span id="wealth_total_harta" class="font-bold text-gray-800">Rp 0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Pengurang (Hutang)</span>
                        <span id="wealth_total_hutang" class="font-bold text-red-500 text-right">- Rp 0</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-gray-200">
                        <span class="font-bold text-amber-900">Harta Bersih</span>
                        <span id="wealth_harta_bersih" class="font-bold text-amber-900">Rp 0</span>
                    </div>
                    
                    {{-- PERBAIKAN DI SINI: Menggunakan $nishabTahun --}}
                    <div class="flex justify-between items-center bg-gray-100 p-2 rounded text-xs mt-2">
                        <span>Nishab (85gr Emas):</span>
                        <span class="font-mono">Rp {{ number_format($nishabTahun, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Status Box --}}
                <div id="wealth_status_box"
                    class="mt-6 p-4 rounded-lg bg-gray-100 text-gray-500 text-center text-sm font-semibold transition-colors duration-300">
                    Lengkapi data untuk melihat hasil
                </div>
            </div>

            <div class="mt-6">
                <p class="text-sm text-gray-600 mb-1 text-center">Zakat Wajib Dibayar (2.5%)</p>
                <p id="wealth_nilai_zakat" class="text-3xl font-extrabold text-amber-700 text-center mb-4">Rp 0</p>

                <input type="hidden" id="wealth_zakat_final" value="0">

                <button id="btn_bayar_wealth" disabled
                    onclick="window.globalPay('Zakat Harta Simpanan', document.getElementById('wealth_zakat_final').value)"
                    class="w-full bg-gray-300 text-white py-3 rounded-lg font-bold shadow-sm transition-all cursor-not-allowed">
                    Bayar Zakat
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.wealth-input');

        function calculateWealth() {
            const tabungan = window.parseRupiah(document.getElementById('wealth_tabungan').value);
            const emas = window.parseRupiah(document.getElementById('wealth_emas').value);
            const saham = window.parseRupiah(document.getElementById('wealth_saham').value);
            const hutang = window.parseRupiah(document.getElementById('wealth_hutang').value);

            const totalHarta = tabungan + emas + saham;
            const bersih = totalHarta - hutang;
            
            // Menggunakan Nishab TAHUNAN dari Config Global
            const nishab = window.ZakatConfig.nishabMaalTahun; 

            // Update UI
            document.getElementById('wealth_total_harta').textContent = window.formatRupiah(totalHarta);
            document.getElementById('wealth_total_hutang').textContent = '- ' + window.formatRupiah(hutang);
            document.getElementById('wealth_harta_bersih').textContent = window.formatRupiah(bersih);

            const statusBox = document.getElementById('wealth_status_box');
            const btnBayar = document.getElementById('btn_bayar_wealth');
            let zakatAmount = 0;

            if (bersih >= nishab) {
                // WAJIB
                zakatAmount = Math.floor(bersih * 0.025);
                
                statusBox.innerHTML = `<i class="fas fa-check-circle mr-1"></i> Wajib Membayar Zakat (Nishab: ${window.formatRupiah(nishab)})`;
                statusBox.className = "mt-6 p-4 rounded-lg bg-green-100 text-green-800 text-center text-sm font-bold border border-green-200";

                btnBayar.disabled = false;
                btnBayar.className = "w-full bg-amber-600 hover:bg-amber-700 text-white py-3 rounded-lg font-bold shadow-lg hover:shadow-amber-500/30 transition-all transform hover:-translate-y-1";
            } else if (bersih > 0) {
                // BELUM
                statusBox.innerHTML = `<i class="fas fa-info-circle mr-1"></i> Belum Mencapai Nishab (Min: ${window.formatRupiah(nishab)})`;
                statusBox.className = "mt-6 p-4 rounded-lg bg-yellow-100 text-yellow-800 text-center text-sm font-bold border border-yellow-200";

                btnBayar.disabled = true;
                btnBayar.className = "w-full bg-gray-300 text-white py-3 rounded-lg font-bold shadow-sm cursor-not-allowed";
            } else {
                // KOSONG
                statusBox.innerHTML = 'Lengkapi data untuk melihat hasil';
                statusBox.className = "mt-6 p-4 rounded-lg bg-gray-100 text-gray-500 text-center text-sm font-semibold";

                btnBayar.disabled = true;
                btnBayar.className = "w-full bg-gray-300 text-white py-3 rounded-lg font-bold shadow-sm cursor-not-allowed";
            }

            document.getElementById('wealth_nilai_zakat').textContent = window.formatRupiah(zakatAmount);
            document.getElementById('wealth_zakat_final').value = zakatAmount;
        }

        inputs.forEach(input => {
            input.addEventListener('input', function() {
                window.autoFormatInput(this);
                calculateWealth();
            });
        });
    });
</script>