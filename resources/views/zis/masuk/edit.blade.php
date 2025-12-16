@extends('layouts.app')

@section('title', 'Edit ZIS Masuk - Manajemen ZIS')
@section('page_title', 'Edit ZIS Masuk')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('admin.zis.masuk.update', $zisMasuk) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="id_muzakki" class="block text-sm font-medium text-gray-700 mb-2">Muzakki <span class="text-red-500">*</span></label>
                <select id="id_muzakki" name="id_muzakki" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Muzakki --</option>
                    @foreach($muzakki as $m)
                        <option value="{{ $m->id_muzakki }}" {{ old('id_muzakki', $zisMasuk->id_muzakki) == $m->id_muzakki ? 'selected' : '' }}>
                            {{ $m->nama }} - {{ $m->no_hp ?? '-' }}
                        </option>
                    @endforeach
                </select>
                @error('id_muzakki')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="jenis_zis" class="block text-sm font-medium text-gray-700 mb-2">Jenis ZIS <span class="text-red-500">*</span></label>
                <select id="jenis_zis" name="jenis_zis" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Jenis --</option>
                    <option value="zakat" {{ old('jenis_zis', $zisMasuk->jenis_zis) === 'zakat' ? 'selected' : '' }}>Zakat</option>
                    <option value="infaq" {{ old('jenis_zis', $zisMasuk->jenis_zis) === 'infaq' ? 'selected' : '' }}>Infaq</option>
                    <option value="shadaqah" {{ old('jenis_zis', $zisMasuk->jenis_zis) === 'shadaqah' ? 'selected' : '' }}>Shadaqah</option>
                    <option value="wakaf" {{ old('jenis_zis', $zisMasuk->jenis_zis) === 'wakaf' ? 'selected' : '' }}>Wakaf</option>
                </select>
                @error('jenis_zis')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="tgl_masuk" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Masuk <span class="text-red-500">*</span></label>
                <input type="date" id="tgl_masuk" name="tgl_masuk" value="{{ old('tgl_masuk', $zisMasuk->tgl_masuk->format('Y-m-d')) }}" 
                    required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('tgl_masuk')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-2">Jumlah (Rp) <span class="text-red-500">*</span></label>
                <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah', $zisMasuk->jumlah) }}" 
                    min="0" step="1000" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('jumlah')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div>
            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
            <textarea id="keterangan" name="keterangan" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('keterangan', $zisMasuk->keterangan) }}</textarea>
            @error('keterangan')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex gap-2 pt-4 border-t">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                <i class="fas fa-save mr-2"></i> Simpan
            </button>
            <a href="{{ route('admin.zis.masuk.show', $zisMasuk) }}" class="bg-gray-400 text-white px-6 py-2 rounded hover:bg-gray-500">
                <i class="fas fa-times mr-2"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection
