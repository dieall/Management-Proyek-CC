@extends('layouts.app')

@section('header_title', 'Manajemen Kegiatan')

@section('content')
<div
    x-data="{
        tab: 'acara',
        openModal: false,
        editMode: false,
        formAction: '',
        
        // Data Form Kegiatan
        formData: {
            nama: '',
            tgl: '',
            lok: '',
            status: 'aktif'
        },

        // Search & Filter
        searchAcara: '',
        filterStatusAcara: '',
        searchPeserta: '',
        filterHadir: ''
    }"
    class="h-full flex flex-col overflow-hidden bg-gray-50"
>

    {{-- ================= TAB NAVIGATION ================= --}}
    <div class="bg-white border-b border-gray-200 px-8 pt-2 flex-shrink-0 z-20">
        <div class="flex gap-8">
            <button
                @click="tab = 'acara'"
                :class="tab === 'acara' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-400 hover:text-gray-600 border-b-2 border-transparent'"
                class="pb-4 font-bold text-sm uppercase tracking-wide transition-all"
            >
                Jadwal Kegiatan
            </button>
            <button
                @click="tab = 'peserta'"
                :class="tab === 'peserta' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-400 hover:text-gray-600 border-b-2 border-transparent'"
                class="pb-4 font-bold text-sm uppercase tracking-wide transition-all"
            >
                Data Presensi
            </button>
        </div>
    </div>

    {{-- ================= TAB 1: MASTER ACARA ================= --}}
    <div x-show="tab === 'acara'" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         class="flex flex-col flex-1 overflow-hidden p-6 sm:p-8"
    >
        {{-- TOOLBAR --}}
        <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 mb-8 flex-shrink-0">
            <div>
                <h3 class="font-bold text-2xl text-gray-800">Daftar Kegiatan</h3>
                <p class="text-gray-500 text-sm mt-1">Kelola agenda dan acara masjid.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full xl:w-auto">
                <div class="relative flex-1 sm:w-64 group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input
                        x-model="searchAcara"
                        type="text"
                        placeholder="Cari kegiatan / lokasi..."
                        class="pl-10 w-full rounded-xl border-gray-200 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition text-sm py-2.5 shadow-sm"
                    >
                </div>

                <div class="relative sm:w-40">
                    <select x-model="filterStatusAcara" class="w-full rounded-xl border-gray-200 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition text-sm py-2.5 shadow-sm text-gray-600 pl-3 pr-8 appearance-none">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="selesai">Selesai</option>
                        <option value="batal">Batal</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>

                <button
                    @click="
                        openModal = true;
                        editMode = false;
                        formAction = '{{ route('kegiatan.store') }}';
                        formData = { nama:'', tgl:'', lok:'', status:'aktif' }
                    "
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-blue-200 hover:shadow-blue-300 transition-all flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Buat Acara
                </button>
            </div>
        </div>

        {{-- LIST CARD (GRID) --}}
        <div class="flex-1 overflow-y-auto pr-2 pb-10">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($masterKegiatan as $k)
                <div
                    x-show="
                        (
                            '{{ $k->nama_kegiatan }} {{ $k->lokasi }}'
                            .toLowerCase()
                            .includes(searchAcara.toLowerCase())
                        )
                        &&
                        (
                            filterStatusAcara === '' ||
                            filterStatusAcara === '{{ $k->status_kegiatan }}'
                        )
                    "
                    class="bg-white p-6 rounded-[1.5rem] border border-gray-100 shadow-sm hover:shadow-xl hover:border-blue-100 transition-all group flex flex-col h-full relative overflow-hidden"
                >
                    {{-- Status Badge (Top Right) --}}
                    <div class="absolute top-4 right-4">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border
                            {{ $k->status_kegiatan === 'aktif' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : '' }}
                            {{ $k->status_kegiatan === 'selesai' ? 'bg-gray-50 text-gray-500 border-gray-200' : '' }}
                            {{ $k->status_kegiatan === 'batal' ? 'bg-red-50 text-red-600 border-red-100' : '' }}
                        ">
                            {{ $k->status_kegiatan }}
                        </span>
                    </div>

                    <div class="flex items-start gap-4 mb-4">
                        {{-- DATE ICON --}}
                        <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex flex-col items-center justify-center border border-blue-100 group-hover:scale-105 transition-transform flex-shrink-0 shadow-sm">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-blue-400">
                                {{ $k->tanggal?->format('M') ?? '-' }}
                            </span>
                            <span class="text-2xl font-bold leading-none mt-0.5">
                                {{ $k->tanggal?->format('d') ?? '-' }}
                            </span>
                        </div>
                        
                        {{-- INFO HEADER --}}
                        <div class="pt-1 pr-16">
                            <h4 class="font-bold text-lg text-gray-800 leading-tight mb-1 line-clamp-2">{{ $k->nama_kegiatan }}</h4>
                            <div class="flex items-center gap-1 text-xs text-gray-500 font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $k->lokasi ?? 'Lokasi belum diatur' }}
                            </div>
                        </div>
                    </div>

                    {{-- FOOTER / ACTIONS --}}
                    <div class="mt-auto pt-4 border-t border-gray-50 flex justify-between items-center">
                        <div class="text-xs text-gray-400 font-semibold">
                            {{ $k->tanggal?->format('l, Y') }}
                        </div>

                        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <button
                                @click="
                                    openModal = true;
                                    editMode = true;
                                    formAction = '/kegiatan/{{ $k->id_kegiatan }}';
                                    formData = {
                                        nama:'{{ $k->nama_kegiatan }}',
                                        tgl:'{{ $k->tanggal?->format('Y-m-d') }}',
                                        lok:'{{ $k->lokasi }}',
                                        status:'{{ $k->status_kegiatan }}'
                                    }
                                "
                                class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                title="Edit"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>

                            <form action="{{ route('kegiatan.destroy', $k->id_kegiatan) }}" method="POST" onsubmit="return confirm('Hapus kegiatan ini?')">
                                @csrf @method('DELETE')
                                <button class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ================= TAB 2: DATA PRESENSI ================= --}}
    <div x-show="tab === 'peserta'" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         class="flex flex-col flex-1 overflow-hidden p-6 sm:p-8"
    >
        {{-- TOOLBAR --}}
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8 flex-shrink-0">
            <div>
                <h3 class="font-bold text-2xl text-gray-800">Data Presensi</h3>
                <p class="text-gray-500 text-sm mt-1">Daftar kehadiran jamaah pada setiap kegiatan.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <div class="relative flex-1 sm:w-64 group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input
                        x-model="searchPeserta"
                        type="text"
                        placeholder="Cari jamaah / kegiatan..."
                        class="pl-10 w-full rounded-xl border-gray-200 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition text-sm py-2.5 shadow-sm"
                    >
                </div>

                <div class="relative sm:w-40">
                    <select x-model="filterHadir" class="w-full rounded-xl border-gray-200 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition text-sm py-2.5 shadow-sm text-gray-600 pl-3 pr-8 appearance-none">
                        <option value="">Semua Status</option>
                        <option value="hadir">Hadir</option>
                        <option value="izin">Izin</option>
                        <option value="belum">Belum</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm flex flex-col flex-1 overflow-hidden">
            <div class="flex-1 overflow-y-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 sticky top-0 z-10 text-gray-500 text-xs uppercase font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Jamaah</th>
                            <th class="px-6 py-4">Kegiatan</th>
                            <th class="px-6 py-4">Tanggal Daftar</th>
                            <th class="px-6 py-4 text-center">Status Kehadiran</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @foreach($peserta as $p)
                        <tr
                            x-show="
                                (
                                    '{{ $p->jamaah->nama_lengkap }} {{ $p->kegiatan->nama_kegiatan }}'
                                    .toLowerCase()
                                    .includes(searchPeserta.toLowerCase())
                                )
                                &&
                                (
                                    filterHadir === '' ||
                                    filterHadir === '{{ $p->status_kehadiran }}'
                                )
                            "
                            class="hover:bg-gray-50 transition-colors"
                        >
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800">{{ $p->jamaah->nama_lengkap }}</div>
                                <div class="text-xs text-gray-400 font-bold mt-0.5">@ {{ $p->jamaah->username }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded-md">
                                    {{ $p->kegiatan->nama_kegiatan }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 font-medium">
                                {{ $p->tanggal_daftar ? \Carbon\Carbon::parse($p->tanggal_daftar)->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide
                                    {{ $p->status_kehadiran === 'hadir' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                    {{ $p->status_kehadiran === 'izin' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $p->status_kehadiran === 'belum' ? 'bg-gray-100 text-gray-500' : '' }}
                                ">
                                    {{ $p->status_kehadiran }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ================= MODAL: FORM KEGIATAN ================= --}}
    <div x-show="openModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="openModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="openModal = false"></div>

        <div x-show="openModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4" class="bg-white rounded-[2rem] w-full max-w-lg shadow-2xl relative overflow-hidden flex flex-col">
            
            {{-- Header --}}
            <div class="bg-gray-50 px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800" x-text="editMode ? 'Edit Kegiatan' : 'Buat Kegiatan Baru'"></h3>
                        <p class="text-sm text-gray-500">Isi detail acara di bawah ini.</p>
                    </div>
                </div>
                <button @click="openModal=false" class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-200 rounded-full transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>

            {{-- Form Body --}}
            <div class="p-8">
                <form :action="formAction" method="POST" id="formKegiatan" class="space-y-5">
                    @csrf
                    <input type="hidden" name="_method" :value="editMode ? 'PUT' : 'POST'">

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Nama Kegiatan</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-300"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></span>
                            <input type="text" name="nama_kegiatan" x-model="formData.nama" placeholder="Contoh: Pengajian Bulanan" required
                                class="w-full pl-11 pr-4 py-3.5 rounded-xl bg-gray-50 border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition text-gray-800 font-medium">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Tanggal</label>
                            <input type="date" name="tanggal" x-model="formData.tgl" required
                                class="w-full px-4 py-3.5 rounded-xl bg-gray-50 border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition text-gray-800 font-medium">
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Status</label>
                            <select name="status_kegiatan" x-model="formData.status"
                                class="w-full px-4 py-3.5 rounded-xl bg-gray-50 border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition text-gray-800 font-medium appearance-none">
                                <option value="aktif">Aktif</option>
                                <option value="selesai">Selesai</option>
                                <option value="batal">Batal</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Lokasi</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-300"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></span>
                            <input type="text" name="lokasi" x-model="formData.lok" placeholder="Contoh: Masjid Utama"
                                class="w-full pl-11 pr-4 py-3.5 rounded-xl bg-gray-50 border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition text-gray-800 font-medium">
                        </div>
                    </div>

                </form>
            </div>

            {{-- Footer Buttons --}}
            <div class="bg-white p-8 pt-0 flex gap-4">
                <button type="button" @click="openModal=false" class="flex-1 py-3.5 rounded-xl font-bold text-gray-500 bg-gray-100 hover:bg-gray-200 hover:text-gray-700 transition">Batal</button>
                <button type="submit" form="formKegiatan" class="flex-[2] bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-blue-200 hover:shadow-blue-300 transition-all flex items-center justify-center gap-2">
                    <span x-text="editMode ? 'Simpan Perubahan' : 'Terbitkan Kegiatan'"></span>
                </button>
            </div>
        </div>
    </div>

</div>
@endsection