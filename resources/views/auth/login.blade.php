@extends('layouts.guest')

@section('title', 'Login - Manajemen ZIS')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-600 via-blue-500 to-purple-600 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        {{-- Card Login --}}
        <div class="bg-white rounded-2xl shadow-2xl p-8 transform hover:scale-105 transition duration-300">
            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full mb-4">
                    <i class="fas fa-hand-holding-heart text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800">Sistem ZIS</h1>
                <p class="text-gray-500 text-sm mt-2">Manajemen Zakat, Infaq & Shadaqah</p>
            </div>
            
            {{-- Error Message --}}
            @if (session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6 flex items-start" role="alert">
                    <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3 flex-shrink-0 mt-0.5"></i>
                    <div>
                        <p class="text-red-700 font-semibold text-sm">Gagal Login</p>
                        <p class="text-red-600 text-sm mt-1">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            
            {{-- Hidden Field: Login Type (Default: user untuk Admin/Petugas/Jemaah) --}}
            <input type="hidden" name="login_type" value="user">

            {{-- Username / Email --}}
            <div>
                <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-user text-blue-500 mr-2"></i>Username / Email / Nama
                </label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" 
                    class="w-full px-4 py-3 border @error('username') border-red-500 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                    placeholder="Masukkan kredensial login Anda"
                    required autofocus>
                @error('username')
                    <span class="text-red-500 text-sm mt-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </span>
                @enderror
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-lock text-blue-500 mr-2"></i>Password
                </label>
                <input type="password" id="password" name="password" 
                    class="w-full px-4 py-3 border @error('password') border-red-500 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" 
                    placeholder="Masukkan password Anda"
                    required>
                @error('password')
                    <span class="text-red-500 text-sm mt-2 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </span>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center">
                <input type="checkbox" id="remember" name="remember" 
                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                <label for="remember" class="ml-2 text-sm text-gray-600 cursor-pointer hover:text-gray-800">
                    Ingat saya di perangkat ini
                </label>
            </div>

            {{-- Login Button --}}
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white py-3 rounded-lg hover:from-blue-700 hover:to-blue-800 transition font-semibold flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl">
                <i class="fas fa-sign-in-alt"></i>
                <span>Login</span>
            </button>
        </form>

        {{-- Register Link --}}
        <p class="text-center text-gray-600 text-sm mt-6 pb-6 border-b">
            Belum punya akun? <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:text-blue-700 transition">Daftar sebagai Jemaah</a>
        </p>
        
        {{-- Demo Account Info --}}
        <div class="mt-6 pt-4 text-sm">
            <h6 class="font-bold text-gray-800 mb-3 flex items-center">
                <i class="fas fa-key text-blue-500 mr-2"></i>Akun Demo
            </h6>
            <div class="bg-blue-50 rounded-lg p-4 space-y-2">
                <div class="flex items-start">
                    <span class="inline-block w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                    <div>
                        <p class="text-gray-800"><span class="font-semibold">Admin:</span> <code class="bg-gray-100 px-2 py-1 rounded text-xs">admin_zis</code></p>
                        <p class="text-gray-600 text-xs">Password: <code class="bg-gray-100 px-2 py-1 rounded">password</code></p>
                    </div>
                </div>
                <div class="flex items-start">
                    <span class="inline-block w-2 h-2 bg-green-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                    <div>
                        <p class="text-gray-800"><span class="font-semibold">Jemaah/Muzakki:</span> <code class="bg-gray-100 px-2 py-1 rounded text-xs">Prof. Ferne Bashirian III</code></p>
                        <p class="text-gray-600 text-xs">Password: <code class="bg-gray-100 px-2 py-1 rounded">password</code></p>
                    </div>
                </div>
                <div class="flex items-start">
                    <span class="inline-block w-2 h-2 bg-yellow-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                    <div>
                        <p class="text-gray-800"><span class="font-semibold">Mustahik:</span> <code class="bg-gray-100 px-2 py-1 rounded text-xs">Ms. Rubye Reilly</code></p>
                        <p class="text-gray-600 text-xs">Password: <code class="bg-gray-100 px-2 py-1 rounded">password</code></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection