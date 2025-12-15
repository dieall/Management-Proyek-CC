@extends('layouts.app')

@section('content')
<div
    x-data="{
        tab: 'master',
        openModal: false,
        editMode: false,
        formAction: '',
        formData: {
            nama: '',
            tgl: '',
            desc: ''
        },
        searchProgram: '',
        searchTransaksi: '',
        filterMin: '',
        filterMax: ''
    }"
    class="h-full flex flex-col overflow-hidden bg-gray-50"
>

    {{-- TAB NAVIGATION --}}
    <div class="bg-white border-b border-gray-200 px-8 pt-2 flex-shrink-0 z-20">
        <div class="flex gap-8">
            <button
                @click="tab = 'master'"
                :class="tab === 'master' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-400 hover:text-gray-600 border-b-2 border-transparent'"
                class="pb-4 font-bold text-sm uppercase tracking-wide transition-all"
            >
                Program Donasi
            </button>
            <button
                @click="tab = 'riwayat'"
                :class="tab === 'riwayat' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-gray-400 hover:text-gray-600 border-b-2 border-transparent'"
                class="pb-4 font-bold text-sm uppercase tracking-wide transition-all"
            >
                Riwayat Transaksi
            </button>
        </div>
    </div>

    {{-- ================= TAB 1: PROGRAM DONASI ================= --}}
    <div x-show="tab === 'master'" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         class="flex flex-col flex-1 overflow-hidden p-6 sm:p-8"
    >

        {{-- HEADER TOOLBAR --}}
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8 flex-shrink-0">
            <div>
                <h3 class="font-bold text-2xl text-gray-800">Daftar Program</h3>
                <p class="text-gray-500 text-sm mt-1">Kelola program donasi masjid yang tersedia.</p>
            </div>

            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="relative flex-1 md:w-72 group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input
                        x-model="searchProgram"
                        type="text"
                        placeholder="Cari program donasi..."
                        class="pl-10 w-full rounded-xl border-gray-200 bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 transition text-sm py-2.5 shadow-sm"
                    >
                </div>

                <button
                    @click="openModal = true; editMode = false; formAction = '{{ route('donasi.store') }}'; formData = {nama: '', tgl: '', desc: ''}"
                    class="bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-emerald-200 hover:shadow-emerald-300 transition-all transform hover:-translate-y-0.5 flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Buat Program
                </button>
            </div>
        </div>

        {{-- CARD LIST --}}
        <div class="flex-1 overflow-y-auto pr-2 pb-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($masterDonasi as $d)
                <div
                    x-show="
                        '{{ $d->nama_donasi }} {{ $d->deskripsi }}'
                        .toLowerCase()
                        .includes(searchProgram.toLowerCase())
                    "
                    class="bg-white p-6 rounded-[1.5rem] border border-gray-100 shadow-sm hover:shadow-xl hover:shadow-emerald-50/50 hover:border-emerald-100 transition-all group flex flex-col h-full"
                >
                    {{-- HEADER CARD --}}
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center border border-emerald-100 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                        
                        {{-- ACTIONS --}}
                        <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                             <button
                                @click="openModal = true; editMode = true; formAction = '/donasi/{{ $d->id_donasi }}'; formData = {nama:'{{ $d->nama_donasi }}', tgl:'{{ $d->tanggal_mulai?->format('Y-m-d') }}', desc:'{{ $d->deskripsi }}'}"
                                class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                title="Edit"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>

                            <form action="{{ route('donasi.destroy', $d->id_donasi) }}" method="POST"
                                onsubmit="return confirm('Hapus program ini?')">
                                @csrf @method('DELETE')
                                <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- CONTENT --}}
                    <div class="flex-1">
                        <h4 class="font-bold text-lg text-gray-800 mb-2 leading-tight">{{ $d->nama_donasi }}</h4>
                        <p class="text-sm text-gray-500 mb-4 line-clamp-3 leading-relaxed">
                            {{ $d->deskripsi ?? 'Tidak ada deskripsi untuk program ini.' }}
                        </p>
                    </div>

                    {{-- FOOTER --}}
                    <div class="pt-4 border-t border-gray-50 mt-2">
                        <div class="flex items-center gap-2 text-xs font-bold text-emerald-600 bg-emerald-50/80 w-fit px-3 py-1.5 rounded-lg border border-emerald-100">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Mulai: {{ $d->tanggal_mulai ? $d->tanggal_mulai->format('d M Y') : '-' }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ================= TAB 2: RIWAYAT TRANSAKSI ================= --}}
    <div x-show="tab === 'riwayat'" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         class="flex flex-col flex-1 overflow-hidden p-6 sm:p-8"
    >

        {{-- HEADER TOOLBAR --}}
        <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 mb-8 flex-shrink-0">
            <div>
                <h3 class="font-bold text-2xl text-gray-800">Riwayat Transaksi</h3>
                <p class="text-gray-500 text-sm mt-1">Monitoring seluruh donasi masuk secara realtime.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full xl:w-auto bg-white p-2 rounded-2xl border border-gray-200 shadow-sm">
                
                <div class="relative flex-1 sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input
                        x-model="searchTransaksi"
                        placeholder="Cari jamaah / program..."
                        class="pl-9 w-full rounded-xl border-transparent bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition text-sm py-2"
                    >
                </div>

                <div class="hidden sm:block w-px bg-gray-200 my-1"></div>

                <div class="flex gap-2 items-center">
                    <input
                        type="number"
                        x-model="filterMin"
                        placeholder="Min Rp"
                        class="w-full sm:w-28 rounded-xl border-transparent bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition text-sm py-2 text-center placeholder-gray-400"
                    >
                    <span class="text-gray-300 font-bold">-</span>
                    <input
                        type="number"
                        x-model="filterMax"
                        placeholder="Max Rp"
                        class="w-full sm:w-28 rounded-xl border-transparent bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition text-sm py-2 text-center placeholder-gray-400"
                    >
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm flex flex-col flex-1 overflow-hidden">
            <div class="flex-1 overflow-y-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 sticky top-0 z-10 text-gray-500 text-xs uppercase font-bold tracking-wider">
                        <tr>
                            <th class="px-8 py-4">Jamaah</th>
                            <th class="px-6 py-4">Program</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-8 py-4 text-right">Nominal</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach($riwayatTransaksi as $r)
                        <tr
                            x-show="
                                (
                                    '{{ $r->jamaah->nama_lengkap ?? '' }} {{ $r->donasi->nama_donasi ?? '' }}'
                                    .toLowerCase()
                                    .includes(searchTransaksi.toLowerCase())
                                )
                                &&
                                (
                                    (filterMin === '' || {{ $r->besar_donasi }} >= filterMin)
                                )
                                &&
                                (
                                    (filterMax === '' || {{ $r->besar_donasi }} <= filterMax)
                                )
                            "
                            class="hover:bg-gray-50 transition-colors group"
                        >
                            <td class="px-8 py-4">
                                <div class="font-bold text-gray-800">{{ $r->jamaah->nama_lengkap ?? 'Hamba Allah' }}</div>
                                <div class="text-xs text-gray-400 font-bold mt-0.5 group-hover:text-emerald-600 transition-colors">{{ $r->jamaah->username ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-bold border border-blue-100">
                                    {{ $r->donasi->nama_donasi ?? 'Donasi Umum' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 font-medium">
                                {{ $r->tanggal_donasi?->format('d M Y') ?? '-' }}
                            </td>
                            <td class="px-8 py-4 text-right">
                                <span class="font-bold text-emerald-600 text-base">Rp {{ number_format($r->besar_donasi, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ================= MODAL FORM (IMPROVED) ================= --}}
    <div
        x-show="openModal"
        style="display: none;"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
    >
        <div
            x-show="openModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"
            @click="openModal = false"
        ></div>

        <div
            x-show="openModal"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="bg-white rounded-[2rem] w-full max-w-lg shadow-2xl relative overflow-hidden flex flex-col max-h-[90vh]"
        >
            <div class="bg-gray-50 px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-6 h-6" x-show="!editMode" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        <svg class="w-6 h-6" x-show="editMode" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800" x-text="editMode ? 'Edit Program Donasi' : 'Buat Program Baru'"></h3>
                        <p class="text-sm text-gray-500">Isi detail informasi program di bawah ini.</p>
                    </div>
                </div>
                
                <button @click="openModal=false" class="text-gray-400 hover:text-gray-600 transition bg-white rounded-full p-2 hover:bg-gray-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="p-8 overflow-y-auto">
                <form :action="formAction" method="POST" id="programForm" class="space-y-6">
                    @csrf
                    <input type="hidden" name="_method" :value="editMode ? 'PUT' : 'POST'">

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Nama Program</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <input type="text" name="nama_donasi" x-model="formData.nama" placeholder="Contoh: Renovasi Tempat Wudhu"
                                class="w-full pl-11 pr-4 py-3.5 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 transition text-gray-800 font-medium placeholder-gray-400">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Tanggal Mulai</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <input type="date" name="tanggal_mulai" x-model="formData.tgl"
                                class="w-full pl-11 pr-4 py-3.5 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 transition text-gray-800 font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Deskripsi Singkat</label>
                        <textarea name="deskripsi" x-model="formData.desc" rows="4" placeholder="Jelaskan tujuan dan detail program donasi ini..."
                            class="w-full px-4 py-3.5 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 transition text-gray-800 font-medium placeholder-gray-400 resize-none"></textarea>
                    </div>

                </form>
            </div>

            <div class="bg-white p-8 pt-0 flex gap-4">
                <button type="button" @click="openModal=false" class="flex-1 py-3.5 rounded-xl font-bold text-gray-500 bg-gray-100 hover:bg-gray-200 hover:text-gray-700 transition">
                    Batal
                </button>
                <button type="submit" form="programForm" class="flex-[2] bg-emerald-600 hover:bg-emerald-700 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-emerald-200 hover:shadow-emerald-300 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <span x-text="editMode ? 'Simpan Perubahan' : 'Terbitkan Program'"></span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </div>
        </div>
    </div>

</div>
@endsection