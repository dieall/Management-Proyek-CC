@extends('layouts.guest')

@section('title', 'Daftar Mustahik - Manajemen ZIS')

@section('content')
<div class="w-full max-w-2xl bg-white p-6 md:p-8 rounded-lg shadow-xl">
    <div class="text-center mb-6 md:mb-8">
        <div class="inline-flex items-center justify-center w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full mb-4">
            <i class="fas fa-user-check text-white text-2xl md:text-3xl"></i>
        </div>
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
            Pendaftaran Mustahik
        </h2>
        <p class="text-sm md:text-base text-gray-600">
            Isi data diri Anda untuk diverifikasi sebagai penerima manfaat ZIS
        </p>
    </div>

    <form method="POST" action="{{ url('/daftar/mustahik') }}" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
        @csrf

        {{-- 1. Nama --}}
        <div>
            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-user text-blue-500 mr-2"></i>Nama Lengkap <span class="text-red-500">*</span>
            </label>
            <input id="nama" type="text" name="nama" value="{{ old('nama') }}" required autofocus
                   class="w-full px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('nama') border-red-500 bg-red-50 @enderror"
                   placeholder="Masukkan nama lengkap Anda">
            @error('nama')
                <p class="text-red-500 text-xs md:text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>
        
        {{-- 2. Alamat --}}
        <div>
            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-map-marker-alt text-blue-500 mr-2"></i>Alamat Lengkap <span class="text-red-500">*</span>
            </label>
            <textarea id="alamat" name="alamat" rows="3" required
                   class="w-full px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('alamat') border-red-500 bg-red-50 @enderror"
                   placeholder="Masukkan alamat lengkap Anda">{{ old('alamat') }}</textarea>
            @error('alamat')
                <p class="text-red-500 text-xs md:text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        {{-- 3. Kategori Mustahik --}}
        <div>
            <label for="kategori_mustahik" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-list text-blue-500 mr-2"></i>Kategori Mustahik <span class="text-red-500">*</span>
            </label>
            <select id="kategori_mustahik" name="kategori_mustahik" required
                   class="w-full px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('kategori_mustahik') border-red-500 bg-red-50 @enderror">
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoriMustahik as $kategori)
                    <option value="{{ $kategori }}" {{ old('kategori_mustahik') == $kategori ? 'selected' : '' }}>
                        {{ $kategori }}
                    </option>
                @endforeach
            </select>
            @error('kategori_mustahik')
                <p class="text-red-500 text-xs md:text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>
        
        {{-- 4. Nomor HP --}}
        <div>
            <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-phone text-blue-500 mr-2"></i>Nomor HP (Aktif) <span class="text-red-500">*</span>
            </label>
            <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp') }}" required
                   class="w-full px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('no_hp') border-red-500 bg-red-50 @enderror"
                   placeholder="08xxxxxxxxxx">
            @error('no_hp')
                <p class="text-red-500 text-xs md:text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        {{-- 5. Surat DTKS (Input File) --}}
        <div>
            <label for="surat_dtks" class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-file-pdf text-blue-500 mr-2"></i>Surat DTKS/SKTM <span class="text-red-500">*</span>
            </label>
            <div class="relative">
                <input id="surat_dtks" type="file" name="surat_dtks" required accept=".pdf,.jpg,.jpeg,.png"
                       class="hidden" onchange="updateFileName(this)">
                <label for="surat_dtks" class="cursor-pointer block">
                    <div class="w-full px-4 py-3 md:py-4 border-2 border-dashed border-gray-300 rounded-lg text-center hover:border-blue-500 transition bg-gray-50 hover:bg-blue-50">
                        <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl md:text-3xl mb-2 block"></i>
                        <p class="text-sm md:text-base text-gray-600">Klik untuk upload file</p>
                        <p class="text-xs text-gray-500 mt-1">Maksimal 2MB (PDF, JPG, PNG)</p>
                    </div>
                </label>
                <p id="fileName" class="text-xs md:text-sm text-green-600 mt-2 hidden">
                    <i class="fas fa-check-circle mr-1"></i><span id="fileNameText"></span>
                </p>
            </div>
            @error('surat_dtks')
                <p class="text-red-500 text-xs md:text-sm mt-1 flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                </p>
            @enderror
        </div>

        {{-- 6 & 7. Password Fields (Responsive Grid) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock text-blue-500 mr-2"></i>Password <span class="text-red-500">*</span>
                </label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       class="w-full px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password') border-red-500 bg-red-50 @enderror"
                       placeholder="Minimal 8 karakter">
                @error('password')
                    <p class="text-red-500 text-xs md:text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-lock text-blue-500 mr-2"></i>Konfirmasi Password <span class="text-red-500">*</span>
                </label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="w-full px-4 py-2 md:py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                       placeholder="Ulangi password Anda">
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="pt-4 md:pt-6">
            <button type="submit"
                    class="w-full bg-gradient-to-r from-yellow-500 to-yellow-600 text-white py-3 md:py-4 rounded-lg hover:from-yellow-600 hover:to-yellow-700 transition font-semibold flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl text-sm md:text-base">
                <i class="fas fa-check"></i>
                <span>Daftar Sekarang</span>
            </button>
        </div>
        
        {{-- Login Link --}}
        <div class="text-center text-xs md:text-sm text-gray-600 pt-2">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition">Login di sini</a>
        </div>
    </form>
</div>

<script>
function updateFileName(input) {
    if (input.files && input.files[0]) {
        document.getElementById('fileName').classList.remove('hidden');
        document.getElementById('fileNameText').textContent = input.files[0].name;
    }
}
</script>
@endsection