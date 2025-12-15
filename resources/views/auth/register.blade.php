@extends('layouts.main')

@section('title', 'Daftar Akun')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-8 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-lg border border-gray-100 relative">
        
        <div class="absolute top-8 left-8">
            <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:text-gray-900 flex items-center gap-1 transition-colors">
                <span>&larr;</span> Kembali
            </a>
        </div>

        <div class="text-center mt-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-900">Daftar Akun</h2>
            <p class="text-sm text-gray-500 mt-1">Buat akun barumu sekarang</p>
        </div>

        <form class="space-y-4" action="{{ url('/register') }}" method="POST">
            @csrf
            
            {{-- Username --}}
            <div>
                <input id="username" name="username" type="text" required 
                    class="appearance-none rounded-lg relative block w-full px-4 py-3 bg-gray-50 border border-gray-200 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm transition-all" 
                    placeholder="Username">
                @error('username') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
            </div>

            {{-- Nama Lengkap --}}
            <div>
                <input id="nama_lengkap" name="nama_lengkap" type="text" required 
                    class="appearance-none rounded-lg relative block w-full px-4 py-3 bg-gray-50 border border-gray-200 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm transition-all" 
                    placeholder="Nama Lengkap">
            </div>

            {{-- Jenis Kelamin --}}
            <div class="relative">
                <select name="jenis_kelamin" required 
                    class="appearance-none rounded-lg relative block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm transition-all">
                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>

            {{-- No Handphone --}}
            <div>
                <input id="no_handphone" name="no_handphone" type="text" 
                    class="appearance-none rounded-lg relative block w-full px-4 py-3 bg-gray-50 border border-gray-200 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm transition-all" 
                    placeholder="Nomor Telepon (Opsional)">
            </div>

            {{-- Tanggal Lahir --}}
            <div>
                <input id="tanggal_lahir" name="tanggal_lahir" type="date" 
                    class="appearance-none rounded-lg relative block w-full px-4 py-3 bg-gray-50 border border-gray-200 placeholder-gray-400 text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm transition-all">
            </div>

            {{-- Alamat --}}
            <div>
                <input id="alamat" name="alamat" type="text" 
                    class="appearance-none rounded-lg relative block w-full px-4 py-3 bg-gray-50 border border-gray-200 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm transition-all" 
                    placeholder="Alamat Lengkap">
            </div>

            {{-- KATA SANDI UTAMA (DIMODIFIKASI) --}}
            <div class="relative">
                {{-- Tambahkan pr-10 agar teks tidak tertutup ikon --}}
                <input id="kata_sandi" name="kata_sandi" type="password" required 
                    class="appearance-none rounded-lg relative block w-full px-4 py-3 pr-10 bg-gray-50 border border-gray-200 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm transition-all" 
                    placeholder="Kata Sandi">
                
                {{-- Tombol Ikon Mata --}}
                <button type="button" onclick="togglePasswordVisibility('kata_sandi', 'icon-show-pass', 'icon-hide-pass')" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-blue-500 focus:outline-none">
                    {{-- Ikon Mata Terbuka (Default Show) --}}
                    <svg id="icon-show-pass" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    {{-- Ikon Mata Tertutup (Default Hidden) --}}
                    <svg id="icon-hide-pass" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            @error('kata_sandi') <span class="text-xs text-red-500">{{ $message }}</span> @enderror


            {{-- KONFIRMASI KATA SANDI (DIMODIFIKASI) --}}
            <div class="relative">
                {{-- Tambahkan pr-10 agar teks tidak tertutup ikon --}}
                <input id="kata_sandi_confirmation" name="kata_sandi_confirmation" type="password" required 
                    class="appearance-none rounded-lg relative block w-full px-4 py-3 pr-10 bg-gray-50 border border-gray-200 placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent sm:text-sm transition-all" 
                    placeholder="Verifikasi Kata Sandi">

                 {{-- Tombol Ikon Mata --}}
                 <button type="button" onclick="togglePasswordVisibility('kata_sandi_confirmation', 'icon-show-conf', 'icon-hide-conf')" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-blue-500 focus:outline-none">
                    {{-- Ikon Mata Terbuka --}}
                    <svg id="icon-show-conf" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    {{-- Ikon Mata Tertutup --}}
                    <svg id="icon-hide-conf" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>

            <div class="pt-2">
                <button type="submit" 
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-full text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-md transition duration-150 transform active:scale-95">
                    Daftar
                </button>
            </div>

            <div class="text-sm text-center pt-2">
                <span class="text-gray-500">Sudah memiliki akun? </span>
                <a href="{{ url('/') }}" class="font-bold text-blue-600 hover:text-blue-500">
                    Login
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Tambahkan Script Javascript --}}
<script>
    function togglePasswordVisibility(inputId, showIconId, hideIconId) {
        const input = document.getElementById(inputId);
        const showIcon = document.getElementById(showIconId);
        const hideIcon = document.getElementById(hideIconId);

        if (input.type === 'password') {
            input.type = 'text';
            showIcon.classList.add('hidden');
            hideIcon.classList.remove('hidden');
        } else {
            input.type = 'password';
            showIcon.classList.remove('hidden');
            hideIcon.classList.add('hidden');
        }
    }
</script>
@endsection