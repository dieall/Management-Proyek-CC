@extends('layouts.app') 
{{-- Asumsi Anda menggunakan layout yang sama dengan form login, jika tidak, sesuaikan @extends --}}

@section('title', 'Daftar Mustahik')

{{-- Jika Anda hanya ingin form saja tanpa sidebar, gunakan struktur HTML dasar --}}

<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-2xl bg-white p-8 rounded-lg shadow-xl">
        <h2 class="text-3xl font-bold text-center text-blue-800 mb-6">
            Pendaftaran Mustahik
        </h2>
        <p class="text-center text-gray-600 mb-8">
            Silakan isi data diri Anda untuk diverifikasi sebagai penerima manfaat ZIS.
        </p>

        @if (session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ url('/daftar/mustahik') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- 1. Nama --}}
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required autofocus
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- 2. Alamat --}}
            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap <span class="text-red-500">*</span></label>
                <textarea id="alamat" name="alamat" rows="3" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 3. Kategori Mustahik --}}
            <div>
                <label for="kategori_mustahik" class="block text-sm font-medium text-gray-700">Kategori Mustahik <span class="text-red-500">*</span></label>
                <select id="kategori_mustahik" name="kategori_mustahik" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">-- Pilih Kategori --</option>
                    {{-- Loop data dari Controller --}}
                    @foreach($kategoriMustahik as $kategori)
                        <option value="{{ $kategori }}" {{ old('kategori_mustahik') == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_mustahik')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            {{-- 4. Nomor HP --}}
            <div>
                <label for="no_hp" class="block text-sm font-medium text-gray-700">Nomor HP (aktif) <span class="text-red-500">*</span></label>
                <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp') }}" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                @error('no_hp')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 5. Surat DTKS (Input File) --}}
            <div>
                <label for="surat_dtks" class="block text-sm font-medium text-gray-700">Surat Keterangan DTKS/SKTM (File PDF/Gambar) <span class="text-red-500">*</span></label>
                <input id="surat_dtks" type="file" name="surat_dtks" required
                       class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                <p class="text-xs text-gray-500 mt-1">Maksimal 2MB (format: PDF, JPG, JPEG, PNG)</p>
                @error('surat_dtks')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                {{-- 6. Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit"
                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Daftar Sekarang
                </button>
            </div>
            
            <div class="text-center text-sm mt-4">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">Login di sini</a>
            </div>
        </form>
    </div>
</div>