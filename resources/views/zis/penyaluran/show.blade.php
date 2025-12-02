@extends('layouts.app')

@section('title', 'Detail Penyaluran - Manajemen ZIS')
@section('page_title', 'Detail Penyaluran')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Penyaluran</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-500 text-sm">Muzakki (Pemberi)</p>
                    <p class="text-gray-800 font-medium">{{ $penyaluran->zismasuk->muzakki->nama }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Mustahik (Penerima)</p>
                    <p class="text-gray-800 font-medium">{{ $penyaluran->mustahik->nama }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Kategori Mustahik</p>
                    <p class="text-gray-800 font-medium">{{ ucfirst($penyaluran->mustahik->kategori_mustahik) }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Jenis ZIS</p>
                    <p class="text-gray-800 font-medium">{{ ucfirst($penyaluran->zismasuk->jenis_zis) }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Jumlah Penyaluran</p>
                    <p class="text-gray-800 font-semibold text-lg text-orange-600">Rp {{ number_format($penyaluran->jumlah, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Tanggal Penyaluran</p>
                    <p class="text-gray-800 font-medium">{{ $penyaluran->tgl_salur->format('d/m/Y') }}</p>
                </div>
            </div>

            @if($penyaluran->keterangan)
                <div class="mt-4 pt-4 border-t">
                    <p class="text-gray-500 text-sm">Keterangan</p>
                    <p class="text-gray-800">{{ $penyaluran->keterangan }}</p>
                </div>
            @endif
        </div>
    </div>

    <div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h3>
            <div class="space-y-2">
                <a href="{{ route('penyaluran.edit', $penyaluran) }}" class="block w-full text-center bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <form action="{{ route('penyaluran.destroy', $penyaluran) }}" method="POST" onsubmit="return confirm('Yakin?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i> Hapus
                    </button>
                </form>
                <a href="{{ route('penyaluran.index') }}" class="block w-full text-center bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
