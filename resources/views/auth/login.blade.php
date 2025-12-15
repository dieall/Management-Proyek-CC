@extends('layouts.main')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
        
        <div class="flex flex-col items-center">
            <div class="h-24 w-full bg-gray-200 rounded-lg flex items-center justify-center text-gray-500 mb-4">
                <span class="text-sm">Gambar Utama dan Logo<br>Aplikasi Jamaah</span>
            </div>
            <h2 class="mt-2 text-center text-2xl font-bold text-gray-900">Selamat Datang</h2>
            <p class="mt-1 text-center text-sm text-gray-600">Masuk ke akun anda</p>
        </div>

        <form class="mt-8 space-y-6" action="#" method="POST">
            @csrf
            <div class="rounded-md shadow-sm space-y-4">
                <div class="relative">
                    <input id="username" name="username" type="text" required 
                        class="appearance-none rounded-lg relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50" 
                        placeholder="Username">
                </div>
                
                {{-- FIELD PASSWORD LOGIN (DIMODIFIKASI) --}}
                <div class="relative">
                    {{-- Tambahkan pr-10 (padding right) --}}
                    <input id="password" name="kata_sandi" type="password" required 
                        class="appearance-none rounded-lg relative block w-full px-3 py-3 pr-10 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-gray-50" 
                        placeholder="Kata Sandi">

                    {{-- Tombol Ikon Mata --}}
                    <button type="button" onclick="togglePasswordVisibility('password', 'icon-show-login', 'icon-hide-login')" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-400 hover:text-blue-500 focus:outline-none">
                        {{-- Ikon Mata Terbuka --}}
                        <svg id="icon-show-login" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        {{-- Ikon Mata Tertutup --}}
                        <svg id="icon-hide-login" class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    </button>
                </div>
            </div>

            <div>
                <button type="submit" 
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-full text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                    Login
                </button>
            </div>

            <div class="text-sm text-center">
                <span class="text-gray-500">Tidak memiliki akun? </span>
                <a href="{{ url('/register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    Daftar Akun
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Tambahkan Script Javascript yang sama --}}
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