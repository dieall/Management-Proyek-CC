@extends('layouts.app')

@section('title', 'Edit Mustahik - Manajemen ZIS')
@section('page_title', 'Edit Mustahik')

@section('content')
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

    <form action="{{ route('admin.mustahik.update', $mustahik) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Nama --}}
            <div class="md:col-span-2">
                <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">Nama <span class="text-red-500">*</span></label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $mustahik->nama) }}" required 
                    class="w-full px-4 py-2 border @error('nama') border-red-500 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('nama')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            {{-- Kategori --}}
            <div>
                <label for="kategori_mustahik" class="block text-sm font-semibold text-gray-700 mb-2">Kategori Mustahik <span class="text-red-500">*</span></label>
                <select id="kategori_mustahik" name="kategori_mustahik" required class="w-full px-4 py-2 border @error('kategori_mustahik') border-red-500 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('kategori_mustahik', $mustahik->kategori_mustahik) === $cat ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $cat)) }}</option>
                    @endforeach
                </select>
                @error('kategori_mustahik')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            {{-- Status --}}
            <div>
                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                <select id="status" name="status" required class="w-full px-4 py-2 border @error('status') border-red-500 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="aktif" {{ old('status', $mustahik->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="non-aktif" {{ old('status', $mustahik->status) === 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
                @error('status')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            {{-- No. HP --}}
            <div>
                <label for="no_hp" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-phone text-gray-600 mr-2"></i>No. HP
                </label>
                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $mustahik->no_hp) }}" 
                    class="w-full px-4 py-2 border @error('no_hp') border-red-500 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('no_hp')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>
        </div>

        {{-- Alamat --}}
        <div>
            <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-map-marker-alt text-gray-600 mr-2"></i>Alamat
            </label>
            <textarea id="alamat" name="alamat" rows="4" class="w-full px-4 py-2 border @error('alamat') border-red-500 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('alamat', $mustahik->alamat) }}</textarea>
            @error('alamat')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        {{-- Surat DTKS File Upload --}}
        <div class="border-t pt-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-file-pdf text-orange-600 mr-2"></i>File Surat DTKS
            </h3>

            <div class="bg-blue-50 border-l-4 border-blue-400 p-3 rounded mb-4">
                <p class="text-sm text-blue-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    Format: PDF, JPG, JPEG, PNG | Maksimal ukuran: 2MB
                </p>
            </div>

            {{-- Current File Display --}}
            @if($mustahik->surat_dtks)
                <div class="mb-4 p-4 bg-gray-50 border border-gray-300 rounded-lg">
                    <p class="text-sm text-gray-600 mb-2">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>File Saat Ini:
                    </p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            @if(str_ends_with($mustahik->surat_dtks, '.pdf'))
                                <i class="fas fa-file-pdf text-red-600 text-2xl mr-3"></i>
                                <span class="text-gray-800 font-medium">{{ basename($mustahik->surat_dtks) }}</span>
                            @else
                                <i class="fas fa-file-image text-blue-600 text-2xl mr-3"></i>
                                <span class="text-gray-800 font-medium">{{ basename($mustahik->surat_dtks) }}</span>
                            @endif
                        </div>
                        <a href="{{ asset('storage/' . $mustahik->surat_dtks) }}" target="_blank" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center">
                            <i class="fas fa-download mr-1"></i>Lihat
                        </a>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        <i class="fas fa-info-circle mr-1"></i>Upload file baru untuk mengganti file ini
                    </p>
                </div>
            @endif

            {{-- File Upload Input --}}
            <div>
                <label for="surat_dtks" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-cloud-upload-alt text-orange-600 mr-2"></i>Upload File DTKS
                </label>
                <div class="relative">
                    <input type="file" id="surat_dtks" name="surat_dtks" accept=".pdf,.jpg,.jpeg,.png" 
                        class="w-full px-4 py-2 border @error('surat_dtks') border-red-500 bg-red-50 @else border-gray-300 @enderror rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                </div>
                @error('surat_dtks')
                    <p class="text-red-600 text-sm mt-1 flex items-center">
                        <i class="fas fa-times-circle mr-1"></i>{{ $message }}
                    </p>
                @enderror
                <p class="text-xs text-gray-500 mt-2">
                    <i class="fas fa-lightbulb mr-1"></i>Tip: Pilih file gambar atau PDF dokumen DTKS Anda
                </p>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex gap-2 pt-4 border-t">
            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold flex items-center">
                <i class="fas fa-save mr-2"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.mustahik.show', $mustahik) }}" class="bg-gray-500 text-white px-6 py-3 rounded-lg hover:bg-gray-600 transition font-semibold flex items-center">
                <i class="fas fa-times mr-2"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
