@extends('layouts.guest')

@section('title', 'Login Mustahik - Manajemen ZIS')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-amber-900 to-slate-900 flex items-center justify-center p-4">
    <!-- Decorative Elements -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-amber-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-orange-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"></div>
    
    <!-- Back Button -->
    <div class="absolute top-8 left-8 z-20">
        <a href="{{ route('home') }}" class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur hover:bg-white/20 text-white px-4 py-2 rounded-lg transition duration-300 border border-white/20 hover:border-white/40">
            <i class="fas fa-arrow-left"></i>
            <span class="text-sm font-medium hidden sm:inline">Kembali</span>
        </a>
    </div>
    
    <div class="w-full max-w-md relative z-10">
        {{-- Card Login Mustahik --}}
        <div class="bg-white/95 backdrop-blur rounded-2xl shadow-2xl overflow-hidden">
            {{-- Colorful Top Bar --}}
            <div class="h-1 bg-gradient-to-r from-amber-600 via-orange-600 to-amber-600"></div>

            <div class="p-8 md:p-10">
                {{-- Header --}}
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-amber-600 to-orange-700 rounded-full mb-4 shadow-lg transform hover:scale-110 transition duration-300">
                        <i class="fas fa-heart text-white text-3xl"></i>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold bg-gradient-to-r from-amber-600 to-orange-600 bg-clip-text text-transparent">
                        Login Mustahik
                    </h1>
                    <p class="text-gray-600 text-sm md:text-base mt-2 font-medium">Portal Penerima Zakat & Infaq</p>
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

                <form action="{{ route('mustahik.login.store') }}" method="POST" class="space-y-5">
                    @csrf

                    {{-- Username / No HP --}}
                    <div>
                        <label for="username" class="block text-sm font-bold text-gray-700 mb-2">
                            <i class="fas fa-phone text-amber-600 mr-2"></i>Nomor HP atau Nama
                        </label>
                        <div class="relative">
                            <input type="text" id="username" name="username" value="{{ old('username') }}" 
                                class="w-full px-4 py-3 pl-10 border @error('username') border-red-500 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition" 
                                placeholder="Contoh: 0812-3456-7890 atau Nama Anda"
                                required autofocus>
                            <i class="fas fa-phone absolute left-3 top-3.5 text-gray-400"></i>
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
                            <i class="fas fa-lock text-amber-600 mr-2"></i>Password
                        </label>
                        <div class="relative">
                            <input type="password" id="password" name="password" 
                                class="w-full px-4 py-3 pl-10 pr-10 border @error('password') border-red-500 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition" 
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

                    {{-- Login Button --}}
                    <button type="submit" class="w-full bg-gradient-to-r from-amber-600 to-orange-600 text-white font-bold py-3 rounded-lg hover:from-amber-700 hover:to-orange-700 transition duration-300 transform hover:scale-[1.02] active:scale-95 shadow-lg mt-8">
                        <i class="fas fa-sign-in-alt mr-2"></i>Masuk ke Portal
                    </button>
                </form>

                {{-- Divider --}}
                <div class="my-6 flex items-center">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="flex-shrink mx-4 text-gray-500 text-sm">atau</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>

                {{-- Links --}}
                <div class="space-y-3">
                    <div class="text-center">
                        <p class="text-gray-600 text-sm">Belum punya akun Mustahik?</p>
                        <a href="{{ route('mustahik.register') }}" class="text-amber-600 hover:text-amber-700 font-bold text-sm transition">
                            <i class="fas fa-user-plus mr-1"></i>Daftar Sekarang
                        </a>
                    </div>
                    
                    <div class="text-center pt-4 border-t border-gray-200">
                        <p class="text-gray-600 text-xs mb-2">Login sebagai:</p>
                        <div class="flex gap-2 justify-center">
                            <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 text-xs font-medium px-3 py-1 rounded bg-blue-50 transition">
                                <i class="fas fa-user mr-1"></i>Muzakki
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Info --}}
        <div class="text-center mt-6 text-white/60 text-xs">
            <p>Sistem Manajemen ZIS &copy; 2025</p>
        </div>
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
