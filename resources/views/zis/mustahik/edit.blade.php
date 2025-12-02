@extends('layouts.app')

@section('title', 'Edit Mustahik - Manajemen ZIS')
@section('page_title', 'Edit Mustahik')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('mustahik.update', $mustahik) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama <span class="text-red-500">*</span></label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $mustahik->nama) }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('nama')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label for="kategori_mustahik" class="block text-sm font-medium text-gray-700 mb-2">Kategori Mustahik <span class="text-red-500">*</span></label>
                <select id="kategori_mustahik" name="kategori_mustahik" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ old('kategori_mustahik', $mustahik->kategori_mustahik) === $cat ? 'selected' : '' }}>{{ ucfirst(str_replace('_', ' ', $cat)) }}</option>
                    @endforeach
                </select>
                @error('kategori_mustahik')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                <select id="status" name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="aktif" {{ old('status', $mustahik->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="non-aktif" {{ old('status', $mustahik->status) === 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
                @error('status')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">No. HP</label>
                <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $mustahik->no_hp) }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('no_hp')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label for="surat_dtks" class="block text-sm font-medium text-gray-700 mb-2">No. Surat DTKS</label>
                <input type="text" id="surat_dtks" name="surat_dtks" value="{{ old('surat_dtks', $mustahik->surat_dtks) }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('surat_dtks')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password (biarkan kosong jika tidak ingin diubah)</label>
                <input type="password" id="password" name="password" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>
        </div>

        <div>
            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
            <textarea id="alamat" name="alamat" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('alamat', $mustahik->alamat) }}</textarea>
            @error('alamat')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>

        <div class="flex gap-2 pt-4 border-t">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
            <a href="{{ route('mustahik.show', $mustahik) }}" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">
                <i class="fas fa-times mr-2"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
