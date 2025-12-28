@extends('layouts.app-bootstrap')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto pb-10">
    
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden relative">
            
            {{-- Header Profil --}}
            <div class="h-40 bg-gradient-to-r from-blue-600 to-indigo-700 relative">
                
                <div id="edit-trigger" class="absolute top-6 right-6">
                    <button type="button" onclick="toggleEditMode()" class="bg-white/20 hover:bg-white/30 text-white backdrop-blur-md px-5 py-2.5 rounded-xl text-sm font-semibold transition flex items-center gap-2 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        Edit Profil
                    </button>
                </div>

                <div class="absolute -bottom-14 left-8 sm:left-12">
                    <div class="w-28 h-28 bg-white rounded-full p-1.5 shadow-lg">
                        <div class="w-full h-full bg-gray-100 rounded-full flex items-center justify-center text-gray-400">
                            @if($user->jenis_kelamin == 'L')
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            @else
                                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-20 px-8 sm:px-12 pb-10">
                
                {{-- Nama & Kategori --}}
                <div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-8">
                    <div class="w-full">
                        <h2 class="text-3xl font-bold text-gray-800">{{ $user->nama_lengkap }}</h2>
                        <p class="text-gray-500 font-medium text-lg mt-1">@ {{ $user->username }}</p>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 justify-start md:justify-end mt-2 md:mt-0">
                        @forelse($user->kategori as $kat)
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600 border border-blue-100 uppercase tracking-wide">
                                {{ $kat->nama_kategori }}
                            </span>
                        @empty
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-50 text-gray-500 border border-gray-200">
                                Jamaah Umum
                            </span>
                        @endforelse
                    </div>
                </div>

                <hr class="border-gray-100 mb-8">

                {{-- Form Fields --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                    <div class="edit-mode hidden">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', optional($user->tanggal_lahir)->format('Y-m-d')) }}" 
                            class="w-full px-4 py-3 rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition shadow-sm text-gray-800 font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Tanggal Bergabung</label>
                        <div class="w-full px-4 py-3 bg-gray-50 rounded-xl border border-transparent text-gray-700 font-semibold">
                            {{ optional($user->tanggal_bergabung ?? $user->created_at)->format('d M Y') ?? '-' }}
                        </div>
                    </div>

                    <div class="edit-mode hidden">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Status Aktif</label>
                        <select name="status_aktif" class="w-full px-4 py-3 rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition shadow-sm bg-white">
                            <option value="1" {{ old('status_aktif', $user->status_aktif) ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('status_aktif', $user->status_aktif) ? '' : 'selected' }}>Non Aktif</option>
                        </select>
                    </div>

                    {{-- Field Nama Lengkap (Hanya muncul saat edit) --}}
                    <div class="edit-mode hidden md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" 
                            class="w-full px-4 py-3 rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition shadow-sm text-gray-800 font-medium">
                    </div>

                    {{-- PASSWORD SECTION (DIMODIFIKASI) --}}
                    {{-- Class 'edit-mode hidden' ditambahkan di wrapper utama agar default tersembunyi --}}
                    <div class="edit-mode hidden md:col-span-2 border-t border-b border-gray-100 py-6 my-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">
                            Password Baru <span class="text-blue-500 normal-case ml-1 font-normal">(Kosongkan jika tidak ingin mengubah)</span>
                        </label>
                        
                        {{-- Bagian 'view-mode' telah dihapus agar tidak ada tampilan 'Terkunci' --}}

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="relative">
                                <input type="password" name="password" id="password" placeholder="Password Baru" autocomplete="new-password"
                                    class="w-full px-4 py-3 rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition shadow-sm placeholder-gray-400">
                                
                                <button type="button" onclick="togglePassword('password', 'eye-pass')" 
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600 transition p-1">
                                    <svg id="eye-pass-hide" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    <svg id="eye-pass-show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div>

                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirm" placeholder="Ulangi Password Baru" autocomplete="new-password"
                                    class="w-full px-4 py-3 rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition shadow-sm placeholder-gray-400">
                                
                                <button type="button" onclick="togglePassword('password_confirm', 'eye-conf')" 
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600 transition p-1">
                                    <svg id="eye-conf-hide" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    <svg id="eye-conf-show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div>

                        </div>
                    </div>

                    {{-- Nomor Handphone --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Nomor Handphone</label>
                        
                        <div class="view-mode w-full px-4 py-3 bg-gray-50 rounded-xl border border-transparent text-gray-700 font-semibold">
                            {{ $user->no_handphone ?? '-' }}
                        </div>
                        
                        <input type="text" name="no_handphone" value="{{ old('no_handphone', $user->no_handphone) }}" 
                            class="edit-mode hidden w-full px-4 py-3 rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition shadow-sm">
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Jenis Kelamin</label>
                        
                        <div class="view-mode w-full px-4 py-3 bg-gray-50 rounded-xl border border-transparent text-gray-700 font-semibold">
                            {{ $user->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </div>
                        
                        <select name="jenis_kelamin" class="edit-mode hidden w-full px-4 py-3 rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition shadow-sm bg-white">
                            <option value="L" {{ $user->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ $user->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    {{-- Alamat --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Alamat Lengkap</label>
                        
                        <div class="view-mode w-full px-4 py-3 bg-gray-50 rounded-xl border border-transparent text-gray-700 font-medium leading-relaxed min-h-[5rem]">
                            {{ $user->alamat ?? 'Alamat belum diisi' }}
                        </div>
                        
                        <textarea name="alamat" rows="3" 
                            class="edit-mode hidden w-full px-4 py-3 rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition shadow-sm">{{ old('alamat', $user->alamat) }}</textarea>
                    </div>

                    <div class="md:col-span-2 mt-2">
                        <div class="flex items-center gap-2 text-sm text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Bergabung sejak {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                    </div>

                </div>

                <div id="action-buttons" class="hidden mt-10 pt-6 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="toggleEditMode()" class="px-6 py-2.5 rounded-xl text-sm font-bold text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold bg-blue-600 text-white shadow-lg shadow-blue-200 hover:bg-blue-700 hover:shadow-xl transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
    function toggleEditMode() {
        const viewElements = document.querySelectorAll('.view-mode');
        const editElements = document.querySelectorAll('.edit-mode');
        const btnEdit = document.getElementById('edit-trigger');
        const actionButtons = document.getElementById('action-buttons');

        // Toggle Hidden Class
        viewElements.forEach(el => el.classList.toggle('hidden'));
        editElements.forEach(el => el.classList.toggle('hidden'));
        
        // Toggle Buttons visibility
        if (btnEdit.classList.contains('hidden')) {
            // Masuk Mode View
            btnEdit.classList.remove('hidden');
            actionButtons.classList.add('hidden');
        } else {
            // Masuk Mode Edit
            btnEdit.classList.add('hidden');
            actionButtons.classList.remove('hidden');
        }
    }

    // Fungsi Toggle Password Visibility
    function togglePassword(inputId, iconIdPrefix) {
        const input = document.getElementById(inputId);
        const iconShow = document.getElementById(iconIdPrefix + '-show');
        const iconHide = document.getElementById(iconIdPrefix + '-hide');

        if (input.type === "password") {
            input.type = "text";
            iconShow.classList.add('hidden');
            iconHide.classList.remove('hidden');
        } else {
            input.type = "password";
            iconShow.classList.remove('hidden');
            iconHide.classList.add('hidden');
        }
    }
</script>
@endsection