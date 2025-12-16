@extends('layouts.app') 

@section('title', 'Dashboard Mustahik')
@section('page_title', 'Dashboard Mustahik')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">Selamat Datang, {{ session('mustahik_nama') }}!</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    {{-- Card 1: Total Diterima --}}
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-orange-500">
        <p class="text-gray-500 text-sm">Total Bantuan ZIS Diterima</p>
        {{-- TotalDiterima berasal dari DashboardController@mustahikDashboard --}}
        <p class="text-3xl font-bold text-orange-700 mt-1">Rp {{ number_format($totalDiterima ?? 0, 0, ',', '.') }}</p>
    </div>

    {{-- Card 2: Jumlah Penyaluran --}}
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-500 text-sm">Jumlah Penyaluran</p>
        {{-- Penyaluran berasal dari DashboardController@mustahikDashboard --}}
        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $penyaluran->count() ?? 0 }} Kali</p>
    </div>

    {{-- Card 3: Link Profil --}}
    <div class="bg-white rounded-lg shadow p-6 flex flex-col justify-center items-center">
        <a href="{{ route('mustahik.profil') }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center">
            <i class="fas fa-user-circle mr-2 text-xl"></i> Lihat Profil & Kategori
        </a>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-xl font-semibold mb-4">5 Riwayat Penyaluran Terbaru</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Penyaluran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($penyaluran->take(5) as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($item->tgl_salur)->format('d F Y') }}</td>
                    {{-- Asumsi keterangan penyaluran cukup informatif --}}
                    <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $item->keterangan ?? 'Bantuan ZIS' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-orange-600 font-semibold">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">Anda belum memiliki riwayat penerimaan bantuan ZIS.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4 text-right">
        <a href="{{ route('mustahik.riwayat') }}" class="text-blue-600 hover:underline font-medium">Lihat Semua Riwayat &rarr;</a>
    </div>
</div>
@endsection