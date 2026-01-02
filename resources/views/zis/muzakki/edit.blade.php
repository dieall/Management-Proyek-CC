@extends('layouts.app')

@section('title', 'Edit Muzakki - Manajemen ZIS')
@section('page_title', 'Edit Muzakki')

@section('content')
{{-- Success Message --}}
@if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 mb-6">
        <div class="flex items-start">
            <i class="fas fa-check-circle text-green-600 text-xl mr-3 mt-0.5"></i>
            <div>
                <p class="text-green-700 font-bold">Berhasil!</p>
                <p class="text-green-600 text-sm mt-1">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

<div class="bg-white rounded-lg shadow p-6">
    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6">
            <p class="text-red-700 font-semibold mb-2">
                <i class="fas fa-exclamation-circle mr-2"></i>Terjadi kesalahan:
            </p>
            <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.muzakki.update', $muzakki) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Data Dasar --}}
        <div class="border-b pb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-user text-blue-600 mr-2"></i>Data Dasar
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama" name="nama" value="{{ old('nama', $muzakki->nama) }}" required 
                        class="w-full px-4 py-2 border @error('nama') border-red-500 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('nama')
                        <p class="text-red-600 text-sm mt-1 flex items-center">
                            <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="no_hp" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-phone text-gray-600 mr-2"></i>No. HP
                    </label>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $muzakki->no_hp) }}" 
                        class="w-full px-4 py-2 border @error('no_hp') border-red-500 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('no_hp')
                        <p class="text-red-600 text-sm mt-1 flex items-center">
                            <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="tgl_daftar" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar text-gray-600 mr-2"></i>Tanggal Daftar
                    </label>
                    <input type="text" value="{{ $muzakki->tgl_daftar->format('d M Y') }}" disabled 
                        class="w-full px-4 py-2 border border-gray-300 bg-gray-100 rounded-lg text-gray-600">
                </div>
            </div>

            <div class="mt-6">
                <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-map-marker-alt text-gray-600 mr-2"></i>Alamat
                </label>
                <textarea id="alamat" name="alamat" rows="4" 
                    class="w-full px-4 py-2 border @error('alamat') border-red-500 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('alamat', $muzakki->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-red-600 text-sm mt-1 flex items-center">
                        <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>
        </div>

        {{-- Password Change --}}
        <div class="border-b pb-6 bg-gradient-to-br from-amber-50 to-orange-50 rounded-lg p-4">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-lock text-amber-600 mr-2"></i>Ubah Password
            </h3>
            
            <div class="bg-amber-50 border-l-4 border-amber-400 p-3 rounded mb-4">
                <p class="text-sm text-amber-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Catatan:</strong> Biarkan kosong jika tidak ingin mengubah password. Password minimal 6 karakter.
                </p>
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-key text-amber-600 mr-2"></i>Password Baru
                </label>
                <div class="relative">
                    <input type="password" id="password" name="password" value="{{ old('password', '') }}"
                        class="w-full px-4 py-2 pl-10 border @error('password') border-red-500 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500"
                        placeholder="Masukkan password baru (atau biarkan kosong)">
                    <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                </div>
                @error('password')
                    <p class="text-red-600 text-sm mt-1 flex items-center">
                        <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
                <p class="text-xs text-gray-600 mt-2 flex items-center">
                    <i class="fas fa-shield-alt mr-1"></i>Password akan di-hash dengan algoritma bcrypt sebelum disimpan
                </p>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex gap-2 pt-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold flex items-center">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.muzakki.show', $muzakki) }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition font-semibold flex items-center">
                <i class="fas fa-times mr-2"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
