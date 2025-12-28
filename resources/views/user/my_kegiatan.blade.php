@extends('layouts.app-bootstrap')

@section('title', 'Kegiatan Saya')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <p class="text-gray-500">Daftar kegiatan yang Anda ikuti atau hadiri.</p>
        <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-bold w-fit">{{ $kegiatan->count() }} Kegiatan Ditampilkan</span>
    </div>

    <div class="bg-white p-4 rounded-3xl border border-gray-100 shadow-sm">
        <form action="{{ route('user.kegiatan') }}" method="GET" class="flex flex-col md:flex-row gap-4">
            
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama kegiatan atau lokasi..." 
                    class="pl-10 w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition text-sm py-2.5">
            </div>

            <div class="w-full md:w-48">
                <select name="status" class="w-full rounded-xl border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-200 transition text-sm text-gray-600 py-2.5">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Akan Datang</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold transition shadow-md flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter
            </button>
            
            @if(request()->has('q') || request()->has('status'))
            <a href="{{ route('user.kegiatan') }}" class="flex items-center justify-center bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2.5 rounded-xl text-sm font-bold transition">
                Reset
            </a>
            @endif
        </form>
    </div>

    <div class="space-y-4">
        @forelse($kegiatan as $k)
        <div class="bg-white p-5 rounded-3xl border border-gray-100 shadow-sm hover:shadow-md transition-all flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-2xl flex flex-col items-center justify-center border border-blue-100 flex-shrink-0">
                    <span class="text-[10px] font-bold uppercase tracking-wider">{{ \Carbon\Carbon::parse($k->tanggal)->format('M') }}</span>
                    <span class="text-2xl font-bold">{{ \Carbon\Carbon::parse($k->tanggal)->format('d') }}</span>
                </div>

                <div>
                    <h4 class="font-bold text-lg text-gray-900">{{ $k->nama_kegiatan }}</h4>
                    <div class="flex flex-wrap gap-x-4 gap-y-1 text-sm text-gray-500 mt-1">
                        <span class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $k->lokasi ?? 'Masjid Utama' }}
                        </span>
                        
                        @if($k->status_kegiatan == 'aktif')
                            <span class="text-emerald-600 font-medium flex items-center gap-1">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full"></span> Akan Datang
                            </span>
                        @elseif($k->status_kegiatan == 'selesai')
                            <span class="text-gray-400 font-medium">Selesai</span>
                        @elseif($k->status_kegiatan == 'batal')
                            <span class="text-red-400 font-medium">Dibatalkan</span>
                        @else
                            <span class="text-gray-400 font-medium">Status tidak dikenal</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex-shrink-0 border-t sm:border-t-0 sm:border-l border-gray-100 pt-3 sm:pt-0 sm:pl-5">
                <span class="block text-xs text-gray-400 font-bold uppercase mb-1">Status Kehadiran</span>
                @if($k->pivot->status_kehadiran == 'hadir')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                        ✅ Hadir
                    </span>
                @elseif($k->pivot->status_kehadiran == 'izin')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
                        📩 Izin
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500">
                        ⏳ Belum Hadir
                    </span>
                @endif
            </div>

        </div>
        @empty
        <div class="text-center py-12 bg-white rounded-3xl border border-gray-100 border-dashed">
            <svg class="w-16 h-16 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p class="text-gray-500 font-medium">Tidak ada kegiatan yang ditemukan.</p>
            <p class="text-sm text-gray-400">Coba ubah kata kunci atau status filter Anda.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection