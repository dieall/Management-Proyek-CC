@extends('layouts.app')

@section('title', 'Detail Muzakki - Manajemen ZIS')
@section('page_title', 'Detail Muzakki')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Muzakki</h3>
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <p class="text-gray-500 text-sm">Nama</p>
                    <p class="text-gray-800 font-semibold text-lg">{{ $muzakki->nama }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-500 text-sm">No. HP</p>
                        <p class="text-gray-800 font-medium">{{ $muzakki->no_hp ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Tanggal Daftar</p>
                        <p class="text-gray-800 font-medium">{{ $muzakki->tgl_daftar->format('d/m/Y') }}</p>
                    </div>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Alamat</p>
                    <p class="text-gray-800">{{ $muzakki->alamat ?? '-' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-money-bill text-green-500 mr-2"></i> Riwayat ZIS Masuk
            </h3>
            @if($muzakki->zismasuk->count() > 0)
                <div class="space-y-3">
                    @foreach($muzakki->zismasuk as $zis)
                        <div class="flex justify-between items-start border-b pb-3">
                            <div>
                                <p class="font-medium text-gray-800">{{ ucfirst($zis->jenis_zis) }}</p>
                                <p class="text-sm text-gray-500">{{ $zis->tgl_masuk->format('d/m/Y') }}</p>
                            </div>
                            <p class="font-semibold text-green-600">Rp {{ number_format($zis->jumlah, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                    <div class="pt-3 font-semibold text-lg text-green-600">
                        Total: Rp {{ number_format($muzakki->zismasuk->sum('jumlah'), 0, ',', '.') }}
                    </div>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada ZIS masuk dari muzakki ini</p>
            @endif
        </div>
    </div>

    <div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h3>
            <div class="space-y-2">
                <a href="{{ route('admin.muzakki.edit', $muzakki) }}" class="block w-full text-center bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                
                {{-- Tombol Setujui Muzakki (jika status menunggu) --}}
                @if($muzakki->status_pendaftaran === 'menunggu')
                <form action="{{ route('admin.muzakki.approve', $muzakki->id_muzakki) }}" method="POST" onsubmit="return confirm('Setujui pendaftaran Muzakki ini?')" class="block">
                    @csrf
                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition font-medium">
                        <i class="fas fa-check mr-2"></i> Setujui Pendaftaran
                    </button>
                </form>
                @else
                <div class="w-full bg-gray-200 text-gray-700 px-4 py-2 rounded text-center text-sm">
                    <i class="fas fa-check-circle mr-2"></i>Status: {{ ucfirst($muzakki->status_pendaftaran) }}
                </div>
                @endif
                
                {{-- Tombol Tolak (Hapus Data) --}}
                <form action="{{ route('admin.muzakki.destroy', $muzakki) }}" method="POST" onsubmit="return confirm('Tolak dan hapus data Muzakki ini? Tindakan ini tidak bisa dibatalkan.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition font-medium">
                        <i class="fas fa-times mr-2"></i> Tolak Pendaftaran
                    </button>
                </form>
                
                {{-- Tombol Kembali ke Dashboard --}}
                <a href="{{ route('admin.dashboard') }}" class="block w-full text-center bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
