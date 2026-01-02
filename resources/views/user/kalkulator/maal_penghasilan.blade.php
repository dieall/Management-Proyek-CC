<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    {{-- INPUT AREA --}}
    <div class="lg:col-span-7 bg-white rounded-xl shadow-lg border border-gray-100 p-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-800">
                <i class="fas fa-briefcase text-purple-600 mr-2"></i>Sumber Penghasilan
            </h3>
            <span class="text-xs font-semibold bg-purple-100 text-purple-700 px-3 py-1 rounded-full">Bulanan</span>
        </div>
        
        <div class="space-y-5">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Gaji Bulanan</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold">Rp</span>
                    <input type="text" id="income_gaji" class="income-input w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-0 transition font-semibold text-right" placeholder="0">
                </div>
            </div>
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Penghasilan Lainnya (Bonus/THR)</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-500 font-bold">Rp</span>
                    <input type="text" id="income_lain" class="income-input w-full pl-12 pr-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-0 transition font-semibold text-right" placeholder="0">
                </div>
            </div>

            <div class="pt-4 border-t border-dashed border-gray-200">
                <label class="block text-sm font-bold text-gray-700 mb-2">Hutang/Cicilan Jatuh Tempo</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-red-500 font-bold">Rp</span>
                    <input type="text" id="income_cicilan" class="income-input w-full pl-12 pr-4 py-3 border-2 border-red-200 rounded-lg focus:border-red-500 focus:ring-0 transition font-semibold text-right text-red-600" placeholder="0">
                </div>
                <p class="text-xs text-gray-500 mt-1">*Pengurang harta wajib zakat</p>
            </div>
        </div>
    </div>

    {{-- OUTPUT AREA --}}
    <div class="lg:col-span-5 flex flex-col">
        <div class="bg-gradient-to-br from-purple-50 to-white rounded-xl shadow-lg border border-purple-100 p-6 h-full flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-bold text-purple-900 mb-4 border-b border-purple-200 pb-2">Rincian Perhitungan</h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Pendapatan</span>
                        <span id="income_total_pendapatan" class="font-bold text-gray-800">Rp 0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Pengurang (Hutang)</span>
                        <span id="income_total_cicilan" class="font-bold text-red-500 text-right">- Rp 0</span>
                    </div>
                    <div class="flex justify-between pt-2 border-t border-gray-200">
                        <span class="font-bold text-purple-900">Penghasilan Bersih</span>
                        <span id="income_harta_bersih" class="font-bold text-purple-900">Rp 0</span>
                    </div>
                    
                    {{-- PERBAIKAN DI SINI: Menggunakan $nishabBulan --}}
                    <div class="flex justify-between items-center bg-gray-100 p-2 rounded text-xs mt-2">
                        <span>Nishab (Batas Minimal):</span>
                        <span class="font-mono">Rp {{ number_format($nishabBulan, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Status Box --}}
                <div id="income_status_box" class="mt-6 p-4 rounded-lg bg-gray-100 text-gray-500 text-center text-sm font-semibold transition-colors duration-300">
                    Lengkapi data untuk melihat hasil
                </div>
            </div>

            <div class="mt-6">
                <p class="text-sm text-gray-600 mb-1 text-center">Zakat Wajib Dibayar (2.5%)</p>
                <p id="income_nilai_zakat" class="text-3xl font-extrabold text-purple-700 text-center mb-4">Rp 0</p>
                
                <input type="hidden" id="income_zakat_final" value="0">
                
                <button id="btn_bayar_income" disabled onclick="window.globalPay('Zakat Penghasilan', document.getElementById('income_zakat_final').value)" 
                        class="w-full bg-gray-300 text-white py-3 rounded-lg font-bold shadow-sm transition-all cursor-not-allowed">
                    Bayar Zakat
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.income-input');
        
        function calculateIncome() {
            const gaji = window.parseRupiah(document.getElementById('income_gaji').value);
            const lain = window.parseRupiah(document.getElementById('income_lain').value);
            const cicilan = window.parseRupiah(document.getElementById('income_cicilan').value);
            
            const totalPendapatan = gaji + lain;
            const bersih = totalPendapatan - cicilan;
            
            // Menggunakan Nishab Bulanan dari Config Global
            const nishab = window.ZakatConfig.nishabPenghasilanBulan; 
            
            // Update UI Angka
            document.getElementById('income_total_pendapatan').textContent = window.formatRupiah(totalPendapatan);
            document.getElementById('income_total_cicilan').textContent = '- ' + window.formatRupiah(cicilan);
            document.getElementById('income_harta_bersih').textContent = window.formatRupiah(bersih);
            
            const statusBox = document.getElementById('income_status_box');
            let zakatAmount = 0;
            const btnBayar = document.getElementById('btn_bayar_income');

            if (bersih >= nishab) {
                 // Wajib Zakat
                 zakatAmount = Math.floor(bersih * 0.025);
                 
                 statusBox.innerHTML = `<i class="fas fa-check-circle mr-1"></i> Wajib Membayar Zakat (Nishab: ${window.formatRupiah(nishab)})`;
                 statusBox.className = "mt-6 p-4 rounded-lg bg-green-100 text-green-800 text-center text-sm font-bold border border-green-200";
                 
                 btnBayar.disabled = false;
                 btnBayar.classList.remove('bg-gray-300', 'cursor-not-allowed');
                 btnBayar.classList.add('bg-purple-600', 'hover:bg-purple-700', 'text-white', 'shadow-lg');
            } else if (bersih > 0) {
                 // Belum Wajib
                 statusBox.innerHTML = `<i class="fas fa-info-circle mr-1"></i> Belum Mencapai Nishab (Min: ${window.formatRupiah(nishab)})`;
                 statusBox.className = "mt-6 p-4 rounded-lg bg-yellow-100 text-yellow-800 text-center text-sm font-bold border border-yellow-200";
                 
                 btnBayar.disabled = true;
                 btnBayar.classList.add('bg-gray-300', 'cursor-not-allowed');
                 btnBayar.classList.remove('bg-purple-600', 'hover:bg-purple-700', 'text-white', 'shadow-lg');
            } else {
                 // Default / Kosong
                 statusBox.innerHTML = 'Lengkapi data untuk melihat hasil';
                 statusBox.className = "mt-6 p-4 rounded-lg bg-gray-100 text-gray-500 text-center text-sm font-semibold";
                 
                 btnBayar.disabled = true;
                 btnBayar.classList.add('bg-gray-300', 'cursor-not-allowed');
                 btnBayar.classList.remove('bg-purple-600', 'hover:bg-purple-700', 'text-white', 'shadow-lg');
            }

            document.getElementById('income_nilai_zakat').textContent = window.formatRupiah(zakatAmount);
            document.getElementById('income_zakat_final').value = zakatAmount;
        }
        
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                window.autoFormatInput(this);
                calculateIncome();
            });
        });
    });
</script>