@extends('layouts.app')

@section('title', 'Detail Mustahik - Manajemen ZIS')
@section('page_title', 'Detail Mustahik')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Mustahik</h3>
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <p class="text-gray-500 text-sm">Nama</p>
                    <p class="text-gray-800 font-semibold text-lg">{{ $mustahik->nama }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-500 text-sm">Kategori</p>
                        <p class="text-gray-800 font-medium">{{ ucfirst(str_replace('_', ' ', $mustahik->kategori_mustahik)) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Status</p>
                        <span class="px-2 py-1 rounded text-white text-sm font-semibold {{ $mustahik->status === 'aktif' ? 'bg-green-500' : 'bg-gray-500' }}">
                            {{ ucfirst($mustahik->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">No. HP</p>
                        <p class="text-gray-800 font-medium">{{ $mustahik->no_hp ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Tanggal Daftar</p>
                        <p class="text-gray-800 font-medium">{{ $mustahik->tgl_daftar->format('d/m/Y') }}</p>
                    </div>
                </div>
                @if($mustahik->surat_dtks)
                    <div>
                        <p class="text-gray-500 text-sm">No. Surat DTKS</p>
                        <p class="text-gray-800 font-medium">{{ $mustahik->surat_dtks }}</p>
                    </div>
                @endif
                <div>
                    <p class="text-gray-500 text-sm">Alamat</p>
                    <p class="text-gray-800">{{ $mustahik->alamat ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-hand-holding text-orange-500 mr-2"></i> Riwayat Penyaluran
            </h3>
            @if($mustahik->penyaluran->count() > 0)
                <div class="space-y-3">
                    @foreach($mustahik->penyaluran as $salur)
                        <div class="flex justify-between items-start border-b pb-3">
                            <div>
                                <p class="font-medium text-gray-800">{{ $salur->zismasuk->muzakki->nama }}</p>
                                <p class="text-sm text-gray-500">{{ ucfirst($salur->zismasuk->jenis_zis) }} - {{ $salur->tgl_salur->format('d/m/Y') }}</p>
                            </div>
                            <p class="font-semibold text-orange-600">Rp {{ number_format($salur->jumlah, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                    <div class="pt-3 font-semibold text-lg text-orange-600">
                        Total Diterima: Rp {{ number_format($mustahik->penyaluran->sum('jumlah'), 0, ',', '.') }}
                    </div>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada penyaluran ke mustahik ini</p>
            @endif
        </div>
    </div>

    <div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h3>
            <div class="space-y-2">
                <a href="{{ route('admin.mustahik.edit', $mustahik) }}" class="block w-full text-center bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <form action="{{ route('admin.mustahik.destroy', $mustahik) }}" method="POST" onsubmit="return confirm('Yakin?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i> Hapus
                    </button>
                </form>
                <a href="{{ route('admin.mustahik.index') }}" class="block w-full text-center bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
