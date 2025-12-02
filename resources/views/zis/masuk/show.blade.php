@extends('layouts.app')

@section('title', 'Detail ZIS Masuk - Manajemen ZIS')
@section('page_title', 'Detail ZIS Masuk')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi ZIS Masuk</h3>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-500 text-sm">Muzakki</p>
                    <p class="text-gray-800 font-medium">{{ $zisMasuk->muzakki->nama }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">No. Hp</p>
                    <p class="text-gray-800 font-medium">{{ $zisMasuk->muzakki->no_hp ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Jenis ZIS</p>
                    <p class="text-gray-800 font-medium">{{ ucfirst($zisMasuk->jenis_zis) }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Tanggal Masuk</p>
                    <p class="text-gray-800 font-medium">{{ $zisMasuk->tgl_masuk->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Jumlah</p>
                    <p class="text-gray-800 font-semibold text-lg text-green-600">Rp {{ number_format($zisMasuk->jumlah, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">Status Pencatatan</p>
                    <p class="text-gray-800 font-medium">{{ $zisMasuk->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            @if($zisMasuk->keterangan)
                <div class="mt-4 pt-4 border-t">
                    <p class="text-gray-500 text-sm">Keterangan</p>
                    <p class="text-gray-800">{{ $zisMasuk->keterangan }}</p>
                </div>
            @endif
        </div>

        <!-- Penyaluran Related -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">
                <i class="fas fa-hand-holding text-orange-500 mr-2"></i> Penyaluran dari ZIS Ini
            </h3>
            
            @if($zisMasuk->penyaluran->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 text-left">Mustahik</th>
                                <th class="px-4 py-2 text-right">Jumlah</th>
                                <th class="px-4 py-2 text-left">Tgl Salur</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($zisMasuk->penyaluran as $salur)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $salur->mustahik->nama }}</td>
                                    <td class="px-4 py-2 text-right font-medium">Rp {{ number_format($salur->jumlah, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2">{{ $salur->tgl_salur->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                            <tr class="bg-gray-50 font-semibold">
                                <td class="px-4 py-2">Total Penyaluran</td>
                                <td class="px-4 py-2 text-right">Rp {{ number_format($zisMasuk->penyaluran->sum('jumlah'), 0, ',', '.') }}</td>
                                <td class="px-4 py-2"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada penyaluran untuk ZIS ini</p>
            @endif
        </div>
    </div>

    <div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h3>
            
            <div class="space-y-2">
                <a href="{{ route('zis.masuk.edit', $zisMasuk) }}" class="block w-full text-center bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">
                    <i class="fas fa-edit mr-2"></i> Edit
                </a>
                <form action="{{ route('zis.masuk.destroy', $zisMasuk) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                        <i class="fas fa-trash mr-2"></i> Hapus
                    </button>
                </form>
                <a href="{{ route('zis.masuk.index') }}" class="block w-full text-center bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>

            <div class="mt-6 p-4 bg-blue-50 rounded">
                <p class="text-sm text-gray-600">
                    <strong>Informasi:</strong><br>
                    Sisa dana yang dapat disalurkan: <span class="text-lg font-bold text-blue-600">Rp {{ number_format($zisMasuk->jumlah - $zisMasuk->penyaluran->sum('jumlah'), 0, ',', '.') }}</span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
