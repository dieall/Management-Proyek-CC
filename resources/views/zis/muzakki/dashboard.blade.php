@extends('layouts.app') 

@section('title', 'Dashboard Muzakki')
@section('page_title', 'Dashboard Muzakki')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">Selamat Datang, {{ session('muzakki_nama') }}!</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    {{-- Card 1: Total Donasi --}}
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
        <p class="text-gray-500 text-sm">Total Donasi ZIS Anda</p>
        {{-- TotalDonasi berasal dari DashboardController@muzakkiDashboard --}}
        <p class="text-3xl font-bold text-green-700 mt-1">Rp {{ number_format($totalDonasi ?? 0, 0, ',', '.') }}</p>
    </div>

    {{-- Card 2: Jumlah Transaksi --}}
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-500 text-sm">Jumlah Transaksi</p>
        {{-- Donasi berasal dari DashboardController@muzakkiDashboard --}}
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $donasi->count() ?? 0 }} Transaksi</p>
    </div>

    {{-- Card 3: Link Profil --}}
    <div class="bg-white rounded-lg shadow p-6 flex flex-col justify-center items-center">
        <a href="{{ route('muzakki.profil') }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center">
            <i class="fas fa-user-circle mr-2 text-xl"></i> Lihat Profil Lengkap
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-xl font-semibold mb-4">Riwayat ZIS Terbaru (Maks. 5)</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Masuk</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis ZIS</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($donasi->take(5) as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tgl_masuk)->format('d F Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->jenis_zis }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-green-600 font-semibold">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">Anda belum memiliki riwayat donasi yang tercatat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4 text-right">
        <a href="{{ route('muzakki.riwayat') }}" class="text-blue-600 hover:underline font-medium">Lihat Semua Riwayat &rarr;</a>
    </div>
</div>
@endsection