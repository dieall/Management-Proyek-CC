{{-- File: resources/views/user/pembayaran/index.blade.php --}}

@extends('layouts.app')

@section('title', 'Riwayat Pembayaran ZIS')
@section('page_title', 'Riwayat Pembayaran ZIS Anda')

@section('content')
<div class="space-y-8">
    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-green-600 to-green-700 text-white rounded-2xl p-8 shadow-lg">
        <h1 class="text-4xl font-bold mb-2 flex items-center">
            <i class="fas fa-history mr-3"></i>Riwayat Transaksi ZIS
        </h1>
        <p class="text-green-100">Lihat semua riwayat pembayaran zakat, infaq, dan sedekah Anda</p>
    </div>

    @if($zisMasuk->isEmpty())
        {{-- EMPTY STATE --}}
        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border-2 border-yellow-300 rounded-xl p-12 shadow-md text-center">
            <i class="fas fa-inbox text-6xl text-yellow-300 mb-4"></i>
            <h3 class="text-2xl font-bold text-yellow-900 mb-2">Belum Ada Riwayat Transaksi</h3>
            <p class="text-yellow-800 mb-6">Anda belum memiliki riwayat pembayaran ZIS yang tercatat.</p>
            <a href="{{ route('user.pembayaran.create') }}" class="inline-flex items-center bg-yellow-600 text-white px-8 py-4 rounded-lg hover:bg-yellow-700 transition font-semibold shadow-lg hover:shadow-xl">
                <i class="fas fa-plus-circle mr-2"></i>Ayo Bayar ZIS Sekarang!
            </a>
        </div>
    @else
        {{-- STAT CARD: TOTAL DONASI --}}
        <div class="bg-white rounded-xl shadow-md p-6 border-t-4 border-green-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold">Total Donasi Anda</p>
                    <p class="text-4xl font-bold text-green-700 mt-2">
                        Rp {{ number_format($zisMasuk->sum('jumlah'), 0, ',', '.') }}
                    </p>
                </div>
                <i class="fas fa-award text-6xl text-green-200"></i>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-green-50 to-green-100 border-b-2 border-green-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-bold text-green-900">Tanggal</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-green-900">Jenis ZIS</th>
                            <th class="px-6 py-4 text-left text-sm font-bold text-green-900">Kategori</th>
                            <th class="px-6 py-4 text-right text-sm font-bold text-green-900">Jumlah</th>
                            <th class="px-6 py-4 text-center text-sm font-bold text-green-900">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($zisMasuk as $zis)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                <span class="font-semibold text-gray-800">{{ \Carbon\Carbon::parse($zis->tgl_masuk)->format('d M Y') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold 
                                    @if($zis->jenis_zis == 'Zakat') bg-blue-100 text-blue-800
                                    @elseif($zis->jenis_zis == 'Infak') bg-purple-100 text-purple-800
                                    @else bg-orange-100 text-orange-800
                                    @endif">
                                    {{ ucfirst($zis->jenis_zis) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                @if($zis->sub_jenis_zis)
                                    <span class="bg-gray-100 px-3 py-1 rounded-full text-xs font-semibold">{{ $zis->sub_jenis_zis }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <span class="text-xl font-bold text-green-600">Rp {{ number_format($zis->jumlah, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('user.pembayaran.show', $zis->id_zis) }}" class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-semibold">
                                    <i class="fas fa-eye mr-1"></i>Lihat Detail
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION --}}
        @if($zisMasuk->hasPages())
        <div class="flex justify-center">
            {{ $zisMasuk->links() }}
        </div>
        @endif

        {{-- ACTION BUTTON --}}
        <div class="text-center">
            <a href="{{ route('user.pembayaran.create') }}" class="inline-flex items-center bg-green-600 text-white px-8 py-4 rounded-lg hover:bg-green-700 transition font-semibold shadow-lg hover:shadow-xl">
                <i class="fas fa-plus-circle mr-2"></i>Tambah Transaksi Baru
            </a>
        </div>
    @endif
</div>
@endsection