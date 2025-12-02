@extends('layouts.app')

@section('title', 'Tambah Penyaluran - Manajemen ZIS')
@section('page_title', 'Tambah Penyaluran')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('penyaluran.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="id_zis" class="block text-sm font-medium text-gray-700 mb-2">ZIS Masuk <span class="text-red-500">*</span></label>
                <select id="id_zis" name="id_zis" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih ZIS Masuk --</option>
                    @foreach($zismasuk as $zis)
                        <option value="{{ $zis->id_zis }}" {{ old('id_zis') == $zis->id_zis ? 'selected' : '' }}>
                            {{ $zis->muzakki->nama }} - Rp {{ number_format($zis->jumlah, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
                @error('id_zis')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="id_mustahik" class="block text-sm font-medium text-gray-700 mb-2">Mustahik <span class="text-red-500">*</span></label>
                <select id="id_mustahik" name="id_mustahik" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Mustahik --</option>
                    @foreach($mustahik as $m)
                        <option value="{{ $m->id_mustahik }}" {{ old('id_mustahik') == $m->id_mustahik ? 'selected' : '' }}>
                            {{ $m->nama }} - {{ $m->kategori_mustahik }}
                        </option>
                    @endforeach
                </select>
                @error('id_mustahik')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="tgl_salur" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Penyaluran <span class="text-red-500">*</span></label>
                <input type="date" id="tgl_salur" name="tgl_salur" value="{{ old('tgl_salur', date('Y-m-d')) }}" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('tgl_salur')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-2">Jumlah (Rp) <span class="text-red-500">*</span></label>
                <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" min="0" step="1000" required 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('jumlah')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div>
            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
            <textarea id="keterangan" name="keterangan" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('keterangan') }}</textarea>
        </div>

        <div class="flex gap-2 pt-4 border-t">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
            <a href="{{ route('penyaluran.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">
                <i class="fas fa-times mr-2"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
