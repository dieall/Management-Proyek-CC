@extends('layouts.guest')

@section('title', 'Login - Manajemen ZIS')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 flex items-center justify-center p-4">
    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
    
    <!-- Back Button -->
    <div class="absolute top-8 left-8 z-20">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur hover:bg-white/20 text-white px-4 py-2 rounded-lg transition duration-300 border border-white/20 hover:border-white/40">
            <i class="fas fa-arrow-left"></i>
            <span class="text-sm font-medium hidden sm:inline">Kembali ke Dashboard</span>
            <span class="text-sm font-medium sm:hidden">Kembali</span>
        </a>
    </div>
    
    <div class="w-full max-w-md relative z-10">
        {{-- Card Login --}}
        <div class="bg-white/95 backdrop-blur rounded-2xl shadow-2xl overflow-hidden">
            {{-- Colorful Top Bar --}}
            <div class="h-1 bg-gradient-to-r from-blue-600 via-purple-600 to-blue-600"></div>

            <div class="p-8 md:p-10">
                {{-- Header --}}
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-600 to-blue-700 rounded-full mb-4 shadow-lg transform hover:scale-110 transition duration-300">
                        <i class="fas fa-hand-holding-heart text-white text-3xl"></i>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        Sistem ZIS
                    </h1>
                    <p class="text-gray-600 text-sm md:text-base mt-2 font-medium">Manajemen Zakat, Infaq & Shadaqah</p>
                </div>
                
                {{-- Error Message --}}
                @if (session('error'))
                    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-6 flex items-start animate-pulse" role="alert">
                        <i class="fas fa-exclamation-circle text-red-600 text-xl mr-3 flex-shrink-0 mt-0.5"></i>
                        <div>
                            <p class="text-red-700 font-bold text-sm">Login Gagal</p>
                            <p class="text-red-600 text-sm mt-1">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    {{-- Hidden Field: Login Type --}}
                    <input type="hidden" name="login_type" value="user">

                    {{-- Username / Email --}}
                    <div>
                        <label for="username" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-user-circle text-blue-600 mr-2"></i>Username atau Email
                        </label>
                        <div class="relative">
                            <input type="text" id="username" name="username" value="{{ old('username') }}" 
                                class="w-full px-4 py-3 pl-10 border @error('username') border-red-500 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                placeholder="Masukkan username Anda"
                                required autofocus>
                            <i class="fas fa-user absolute left-3 top-3.5 text-gray-400"></i>
                        </div>
                        @error('username')
                            <span class="text-red-600 text-sm mt-2 flex items-center font-medium">
                                <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                            </span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-lock text-blue-600 mr-2"></i>Password
                        </label>
                        <div class="relative">
                            <input type="password" id="password" name="password" 
                                class="w-full px-4 py-3 pl-10 pr-10 border @error('password') border-red-500 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                                placeholder="Masukkan password Anda"
                                required>
                            <i class="fas fa-lock absolute left-3 top-3.5 text-gray-400"></i>
                            <button type="button" onclick="togglePassword()" class="absolute right-3 top-3.5 text-gray-400 hover:text-gray-600 transition">
                                <i id="toggleIcon" class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-red-600 text-sm mt-2 flex items-center font-medium">
                                <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                            </span>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center pt-2">
                        <input type="checkbox" id="remember" name="remember" 
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                        <label for="remember" class="ml-2 text-sm text-gray-600 cursor-pointer hover:text-gray-800 font-medium transition">
                            Ingat saya di perangkat ini
                        </label>
                    </div>

                    {{-- Login Button --}}
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 rounded-xl transition duration-300 flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Masuk ke Sistem</span>
                    </button>
                </form>

                {{-- Divider --}}
                <div class="flex items-center my-6">
                    <div class="flex-1 border-t border-gray-300"></div>
                    <span class="px-3 text-gray-500 text-sm font-medium">atau</span>
                    <div class="flex-1 border-t border-gray-300"></div>
                </div>

                {{-- Register Link --}}
                <p class="text-center text-gray-700 text-sm">
                    <span class="text-gray-600">Belum punya akun? </span>
                    <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-700 hover:underline transition">
                        Daftar Sekarang
                    </a>
                </p>

                {{-- Footer Info --}}
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <p class="text-center text-xs text-gray-500 font-medium">
                        <i class="fas fa-shield-alt text-green-600 mr-1"></i>
                        Sistem kami dilindungi dengan enkripsi SSL
                    </p>
                </div>
            </div>
        </div>

        {{-- Bottom Text --}}
        <p class="text-center text-gray-400 text-xs mt-6 font-medium">
            © 2026 Sistem Manajemen ZIS - All Rights Reserved
        </p>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>

@endsection