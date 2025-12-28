@extends('layouts.app-bootstrap')

@section('title', 'Manajemen Jamaah')

@section('content')
<div
    x-data="{
        tab: 'jamaah',
        openJamaahModal: false,
        openKategoriModal: false,
        editMode: false,
        formAction: '',
        
        // Data Form Jamaah
        formDataJamaah: {
            nama: '',
            username: '',
            password: '',
            hp: '',
            alamat: '',
            jk: 'L',
            tglLahir: '',
            tglGabung: '',
            status: '1',
            kategori_ids: []
        },

        // Data Form Kategori
        formDataKategori: {
            nama: '',
            deskripsi: ''
        },

        searchJamaah: '',
        searchKategori: '',
        filterStatus: ''
    }"
    class="h-full flex flex-col overflow-hidden bg-gray-50"
>

    {{-- ================= TAB NAVIGATION ================= --}}
    <div class="bg-white border-b border-gray-200 px-8 pt-2 flex-shrink-0 z-20">
        <div class="flex gap-8">
            <button
                @click="tab = 'jamaah'"
                :class="tab === 'jamaah' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-400 hover:text-gray-600 border-b-2 border-transparent'"
                class="pb-4 font-bold text-sm uppercase tracking-wide transition-all"
            >
                Data Jamaah
            </button>
            <button
                @click="tab = 'kategori'"
                :class="tab === 'kategori' ? 'text-purple-600 border-b-2 border-purple-600' : 'text-gray-400 hover:text-gray-600 border-b-2 border-transparent'"
                class="pb-4 font-bold text-sm uppercase tracking-wide transition-all"
            >
                Master Kategori
            </button>
        </div>
    </div>

    {{-- ================= TAB 1: DATA JAMAAH ================= --}}
    <div x-show="tab === 'jamaah'" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         class="flex flex-col flex-1 overflow-hidden p-6 sm:p-8"
    >
        {{-- TOOLBAR --}}
        <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center gap-4 mb-8 flex-shrink-0">
            <div>
                <h3 class="font-bold text-2xl text-gray-800">Data Jamaah</h3>
                <p class="text-gray-500 text-sm mt-1">Total {{ $jamaah->count() }} jamaah terdaftar di sistem.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 w-full xl:w-auto">
                <div class="relative flex-1 sm:w-64 group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input
                        x-model="searchJamaah"
                        type="text"
                        placeholder="Cari nama / username..."
                        class="pl-10 w-full rounded-xl border-gray-200 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition text-sm py-2.5 shadow-sm"
                    >
                </div>

                <div class="relative sm:w-40">
                    <select x-model="filterStatus" class="w-full rounded-xl border-gray-200 bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition text-sm py-2.5 shadow-sm text-gray-600 pl-3 pr-8 appearance-none">
                        <option value="">Semua Status</option>
                        <option value="AKTIF">Aktif</option>
                        <option value="NON">Non Aktif</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>

                <button
                    @click="
                        openJamaahModal = true;
                        editMode = false;
                        formAction = '{{ route('jamaah.store') }}';
                        formDataJamaah = { nama:'', username:'', password:'', hp:'', alamat:'', jk:'L', tglLahir:'', tglGabung:'', status:'1', kategori_ids: [] }
                    "
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-blue-200 hover:shadow-blue-300 transition-all flex items-center justify-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Tambah Jamaah
                </button>
            </div>
        </div>

        {{-- TABLE JAMAAH --}}
        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm flex flex-col flex-1 overflow-hidden">
            <div class="flex-1 overflow-y-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 sticky top-0 z-10 text-gray-500 text-xs uppercase font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Informasi Jamaah</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Kontak</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($jamaah as $j)
                        <tr
                            x-show="
                                '{{ $j->nama_lengkap }} {{ $j->username }}'.toLowerCase().includes(searchJamaah.toLowerCase()) &&
                                (filterStatus === '' || (filterStatus === 'AKTIF' && {{ $j->status_aktif ? 'true':'false' }}) || (filterStatus === 'NON' && !{{ $j->status_aktif ? 'true':'false' }}))
                            "
                            class="hover:bg-gray-50 transition-colors group"
                        >
                            {{-- Kolom Jamaah --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                                        {{ substr($j->nama_lengkap, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800">{{ $j->nama_lengkap }}</div>
                                        <div class="text-xs text-gray-400 font-bold mt-0.5">@ {{ $j->username }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Kolom Kategori --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1.5">
                                    @forelse($j->kategori as $kat)
                                        <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide bg-gray-100 text-gray-600 rounded-lg border border-gray-200">
                                            {{ $kat->nama_kategori }}
                                        </span>
                                    @empty
                                        <span class="text-gray-400 text-xs italic">- Tidak ada -</span>
                                    @endforelse
                                </div>
                            </td>

                            {{-- Kolom Kontak --}}
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        {{ $j->no_handphone ?? '-' }}
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-gray-400">
                                        <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span class="truncate max-w-[150px]">{{ $j->alamat ?? 'Alamat kosong' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-[11px] text-gray-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span>Lahir: {{ $j->tanggal_lahir ? $j->tanggal_lahir->format('d M Y') : '-' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-[11px] text-gray-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <span>Bergabung: {{ $j->tanggal_bergabung ? $j->tanggal_bergabung->format('d M Y') : '-' }}</span>
                                    </div>
                                </div>
                            </td>

                            {{-- Kolom Status --}}
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $j->status_aktif ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-red-50 text-red-600 border-red-100' }}">
                                    {{ $j->status_aktif ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button
                                        @click="
                                            openJamaahModal = true;
                                            editMode = true;
                                            formAction = '/jamaah/{{ $j->id_jamaah }}';
                                            formDataJamaah = {
                                                nama:'{{ $j->nama_lengkap }}',
                                                username:'{{ $j->username }}',
                                                password: '', // Password dikosongkan saat edit
                                                hp:'{{ $j->no_handphone }}',
                                                alamat:'{{ $j->alamat }}',
                                                jk:'{{ $j->jenis_kelamin }}',
                                                tglLahir:'{{ $j->tanggal_lahir?->format('Y-m-d') }}',
                                                tglGabung:'{{ $j->tanggal_bergabung?->format('Y-m-d') }}',
                                                status: '{{ $j->status_aktif ? '1' : '0' }}',
                                                kategori_ids: {{ $j->kategori->pluck('id_kategori') }}
                                            }
                                        "
                                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition"
                                        title="Edit"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>

                                    <form action="{{ route('jamaah.destroy', $j->id_jamaah) }}" method="POST" onsubmit="return confirm('Hapus jamaah ini?')">
                                        @csrf @method('DELETE')
                                        <button class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ================= TAB 2: MASTER KATEGORI ================= --}}
    <div x-show="tab === 'kategori'" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         class="flex flex-col flex-1 overflow-hidden p-6 sm:p-8"
    >
        {{-- TOOLBAR KATEGORI --}}
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8 flex-shrink-0">
            <div>
                <h3 class="font-bold text-2xl text-gray-800">Master Kategori</h3>
                <p class="text-gray-500 text-sm mt-1">Kelola label untuk mengelompokkan jamaah.</p>
            </div>

            <div class="flex gap-3 w-full md:w-auto">
                <div class="relative flex-1 md:w-64 group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-purple-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input
                        x-model="searchKategori"
                        type="text"
                        placeholder="Cari kategori..."
                        class="pl-10 w-full rounded-xl border-gray-200 bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-50 transition text-sm py-2.5 shadow-sm"
                    >
                </div>

                <button
                    @click="
                        openKategoriModal = true;
                        editMode = false;
                        formAction = '{{ route('kategori.store') }}';
                        formDataKategori = { nama:'', deskripsi:'' }
                    "
                    class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-purple-200 hover:shadow-purple-300 transition-all flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Kategori Baru
                </button>
            </div>
        </div>

        {{-- TABLE KATEGORI --}}
        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm flex flex-col flex-1 overflow-hidden">
            <div class="flex-1 overflow-y-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 sticky top-0 z-10 text-gray-500 text-xs uppercase font-bold tracking-wider">
                        <tr>
                            <th class="px-8 py-4">Nama Kategori</th>
                            <th class="px-6 py-4 text-center">Jumlah Anggota</th>
                            <th class="px-8 py-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($kategoriList as $k)
                        <tr
                            x-show="'{{ $k->nama_kategori }}'.toLowerCase().includes(searchKategori.toLowerCase())"
                            class="hover:bg-gray-50 transition-colors group"
                        >
                            <td class="px-8 py-4">
                                <div class="font-bold text-gray-800 text-lg">{{ $k->nama_kategori }}</div>
                                @if($k->deskripsi)
                                    <div class="text-xs text-gray-400 mt-1">{{ $k->deskripsi }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-purple-50 text-purple-700 px-3 py-1 rounded-full text-xs font-bold border border-purple-100">
                                    {{ $k->jamaah_count }} Jamaah
                                </span>
                            </td>
                            <td class="px-8 py-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button
                                        @click="
                                            openKategoriModal = true;
                                            editMode = true;
                                            formAction = '/kategori/{{ $k->id_kategori }}';
                                            formDataKategori = { nama:'{{ $k->nama_kategori }}', deskripsi:'{{ $k->deskripsi }}' }
                                        "
                                        class="p-2 text-gray-400 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition"
                                    >
                                        Edit
                                    </button>
                                    <form action="{{ route('kategori.destroy', $k->id_kategori) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf @method('DELETE')
                                        <button class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ================= MODAL: FORM JAMAAH ================= --}}
    <div x-show="openJamaahModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="openJamaahModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="openJamaahModal = false"></div>

        <div x-show="openJamaahModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4" class="bg-white rounded-[2rem] w-full max-w-2xl shadow-2xl relative overflow-hidden flex flex-col max-h-[90vh]">
            
            {{-- Header --}}
            <div class="bg-gray-50 px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800" x-text="editMode ? 'Edit Data Jamaah' : 'Tambah Jamaah Baru'"></h3>
                        <p class="text-sm text-gray-500">Lengkapi formulir biodata di bawah ini.</p>
                    </div>
                </div>
                <button @click="openJamaahModal=false" class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-200 rounded-full transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>

            {{-- Form Body --}}
            <div class="p-8 overflow-y-auto">
                <form :action="formAction" method="POST" id="formJamaah" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf
                    <input type="hidden" name="_method" :value="editMode ? 'PUT' : 'POST'">

                    <div class="md:col-span-2">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Nama Lengkap</label>
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-300"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/></svg></span>
                            <input type="text" name="nama_lengkap" x-model="formDataJamaah.nama" required class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition">
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Username</label>
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-300"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg></span>
                            <input type="text" name="username" x-model="formDataJamaah.username" required class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition">
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Password</label>
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-300"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></span>
                            <input type="password" name="kata_sandi" x-model="formDataJamaah.password" :required="!editMode" placeholder="Minimal 6 karakter" class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition placeholder-gray-400">
                        </div>
                        <p x-show="editMode" class="text-[10px] text-gray-400 mt-1 ml-1">*Kosongkan jika tidak ingin mengganti password</p>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">No. Handphone</label>
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-300"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg></span>
                            <input type="text" name="no_handphone" x-model="formDataJamaah.hp" class="w-full pl-11 pr-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition">
                        </div>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" x-model="formDataJamaah.jk" class="w-full mt-1 px-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition">
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" x-model="formDataJamaah.tglLahir" class="w-full mt-1 px-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition">
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Tanggal Bergabung</label>
                        <input type="date" name="tanggal_bergabung" x-model="formDataJamaah.tglGabung" class="w-full mt-1 px-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition">
                    </div>

                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Status Aktif</label>
                        <select name="status_aktif" x-model="formDataJamaah.status" class="w-full mt-1 px-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition">
                            <option value="1">Aktif</option>
                            <option value="0">Non Aktif</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1">Alamat Lengkap</label>
                        <textarea name="alamat" x-model="formDataJamaah.alamat" rows="2" class="w-full mt-1 px-4 py-3 rounded-xl bg-gray-50 border-gray-200 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-50 transition resize-none"></textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider ml-1 mb-2 block">Kategori Jamaah</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($allKategori as $kat)
                            <label class="flex items-center space-x-3 p-3 rounded-xl border border-gray-100 hover:bg-blue-50 hover:border-blue-100 transition cursor-pointer group">
                                <input type="checkbox" name="kategori_ids[]" value="{{ $kat->id_kategori }}" x-model="formDataJamaah.kategori_ids" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-5 h-5">
                                <span class="text-sm font-medium text-gray-700 group-hover:text-blue-700">{{ $kat->nama_kategori }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </form>
            </div>

            {{-- Footer Buttons --}}
            <div class="bg-white p-8 pt-0 flex gap-4">
                <button type="button" @click="openJamaahModal=false" class="flex-1 py-3.5 rounded-xl font-bold text-gray-500 bg-gray-100 hover:bg-gray-200 hover:text-gray-700 transition">Batal</button>
                <button type="submit" form="formJamaah" class="flex-[2] bg-blue-600 hover:bg-blue-700 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-blue-200 hover:shadow-blue-300 transition-all flex items-center justify-center gap-2">
                    <span x-text="editMode ? 'Simpan Perubahan' : 'Simpan Data Jamaah'"></span>
                </button>
            </div>
        </div>
    </div>


    {{-- ================= MODAL: FORM KATEGORI ================= --}}
    <div x-show="openKategoriModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="openKategoriModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="openKategoriModal = false"></div>

        <div x-show="openKategoriModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4" class="bg-white rounded-[2rem] w-full max-w-md shadow-2xl relative overflow-hidden flex flex-col">
            
            {{-- Header --}}
            <div class="bg-gray-50 px-8 py-6 border-b border-gray-100 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800" x-text="editMode ? 'Edit Kategori' : 'Tambah Kategori'"></h3>
                    </div>
                </div>
                <button @click="openKategoriModal=false" class="text-gray-400 hover:text-gray-600 p-2 hover:bg-gray-200 rounded-full transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>

            {{-- Form Body --}}
            <div class="p-8">
                <form :action="formAction" method="POST" id="formKategori" class="space-y-6">
                    @csrf
                    <input type="hidden" name="_method" :value="editMode ? 'PUT' : 'POST'">

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Nama Kategori</label>
                        <input type="text" name="nama_kategori" x-model="formDataKategori.nama" placeholder="Contoh: Remaja Masjid" required
                            class="w-full px-4 py-3.5 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-50 transition text-gray-800 font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 ml-1">Deskripsi</label>
                        <textarea name="deskripsi" x-model="formDataKategori.deskripsi" rows="3" placeholder="Opsional..."
                            class="w-full px-4 py-3.5 rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-50 transition text-gray-800 font-medium resize-none"></textarea>
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="bg-white p-8 pt-0 flex gap-4">
                <button type="button" @click="openKategoriModal=false" class="flex-1 py-3.5 rounded-xl font-bold text-gray-500 bg-gray-100 hover:bg-gray-200 hover:text-gray-700 transition">Batal</button>
                <button type="submit" form="formKategori" class="flex-[2] bg-purple-600 hover:bg-purple-700 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-purple-200 hover:shadow-purple-300 transition-all">
                    <span x-text="editMode ? 'Simpan Perubahan' : 'Buat Kategori'"></span>
                </button>
            </div>
        </div>
    </div>

</div>
@endsection