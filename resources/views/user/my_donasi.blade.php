@extends('layouts.app-bootstrap')

@section('title', 'Riwayat Donasi Saya')

@section('content')
<div class="space-y-6">
    
    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-[2rem] p-8 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10">
            <p class="text-emerald-100 font-medium mb-1 text-sm uppercase tracking-wider">Total Sedekah & Infaq</p>
            <h3 class="text-4xl font-bold">Rp {{ number_format($riwayat->sum('besar_donasi'), 0, ',', '.') }}</h3>
            <p class="mt-2 text-sm text-emerald-100 opacity-90">Terima kasih atas kontribusi Anda untuk kemakmuran masjid.</p>
        </div>
        <div class="absolute right-0 top-0 h-full w-1/3 bg-white opacity-10 transform skew-x-12"></div>
    </div>

    <div class="bg-white p-4 rounded-3xl border border-gray-100 shadow-sm">
        <form action="{{ route('user.donasi') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama program donasi..." 
                    class="pl-10 w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition text-sm py-2.5">
            </div>

            <div class="w-full md:w-auto">
                <input type="date" name="start_date" value="{{ request('start_date') }}" 
                    class="w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition text-sm text-gray-500 py-2.5">
            </div>

            <div class="w-full md:w-auto">
                <input type="date" name="end_date" value="{{ request('end_date') }}" 
                    class="w-full rounded-xl border-gray-200 focus:border-emerald-500 focus:ring focus:ring-emerald-200 transition text-sm text-gray-500 py-2.5">
            </div>

            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition shadow-md">
                Filter
            </button>
            
            @if(request()->has('q') || request()->has('start_date'))
            <a href="{{ route('user.donasi') }}" class="flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2.5 rounded-xl text-sm font-bold transition">
                Reset
            </a>
            @endif
        </form>
    </div>

    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-900">Catatan Transaksi</h3>
            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $riwayat->count() }} Transaksi Ditemukan</span>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold">
                    <tr>
                        <th class="px-6 py-4">Program Donasi</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-right">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($riwayat as $r)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $r->donasi->nama_donasi ?? 'Donasi Umum' }}</div>
                            <div class="text-xs text-gray-500 mt-0.5">{{ Str::limit($r->donasi->deskripsi ?? '', 50) }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($r->tanggal_donasi)->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-emerald-600">
                            Rp {{ number_format($r->besar_donasi, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Tidak ada data donasi yang cocok dengan filter Anda.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection