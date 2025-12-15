@extends('layouts.app')

@section('header_title', 'Dashboard')

@section('content')
<div class="h-full flex flex-col overflow-hidden">

    {{-- ================= STAT CARD ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 flex-shrink-0 mb-6">
        
        <div class="bg-white p-6 rounded-[2rem] border shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-2xl">👥</div>
            <div>
                <p class="text-sm text-gray-500 font-bold uppercase">Total Jamaah</p>
                <h3 class="text-3xl font-bold">{{ number_format($stats['total_jamaah'] ?? 0) }}</h3>
                <p class="text-xs text-blue-600 mt-1">Terdaftar dalam sistem</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl">💰</div>
            <div>
                <p class="text-sm text-gray-500 font-bold uppercase">Total Infaq/Donasi</p>
                <h3 class="text-3xl font-bold">
                    Rp {{ number_format(($stats['total_donasi'] ?? 0) / 1000000, 1, ',', '.') }} Jt
                </h3>
                <p class="text-xs text-emerald-600 mt-1">Total pemasukan tercatat</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border shadow-sm flex items-center gap-4">
            <div class="w-14 h-14 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-2xl">📅</div>
            <div>
                <p class="text-sm text-gray-500 font-bold uppercase">Kegiatan Aktif</p>
                <h3 class="text-3xl font-bold">{{ $stats['kegiatan_aktif'] ?? 0 }}</h3>
                <p class="text-xs text-purple-600 mt-1">Acara bulan ini</p>
            </div>
        </div>
    </div>

    {{-- ================= MAIN CONTENT ================= --}}
    <div class="flex-1 grid grid-cols-1 lg:grid-cols-3 gap-8 overflow-hidden">

        {{-- LEFT SIDE --}}
        <div class="lg:col-span-2 flex flex-col gap-6 overflow-hidden">

            {{-- QUICK ACCESS --}}
            <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-[2rem] p-8 text-white flex-shrink-0">
                <div class="flex justify-between items-center gap-6">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">Akses Cepat Admin</h3>
                        <p class="text-gray-400 text-sm">Kelola data masjid dengan cepat.</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('jamaah.create') }}"
                           class="bg-white/10 px-4 py-3 rounded-xl text-sm font-bold border border-white/10">
                            + Jamaah
                        </a>
                        <a href="{{ route('donasi.index') }}"
                           class="bg-emerald-500 px-4 py-3 rounded-xl text-sm font-bold shadow">
                            + Program Donasi
                        </a>
                    </div>
                </div>
            </div>

            {{-- DONASI TERBARU (SCROLL INTERNAL) --}}
            <div class="bg-white rounded-[2rem] border shadow-sm flex flex-col flex-1 overflow-hidden">
                <div class="p-6 border-b flex-shrink-0 flex justify-between">
                    <h3 class="font-bold">Donasi Masuk Terbaru</h3>
                    <a href="{{ route('donasi.index') }}" class="text-xs font-bold text-blue-600">Lihat Semua</a>
                </div>

                <div class="flex-1 overflow-y-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 text-xs font-bold uppercase sticky top-0">
                            <tr>
                                <th class="px-6 py-3">Donatur</th>
                                <th class="px-6 py-3">Program</th>
                                <th class="px-6 py-3 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y text-sm">
                            @forelse($terbaruDonasi as $d)
                            <tr>
                                <td class="px-6 py-3 font-medium">{{ $d->jamaah->nama_lengkap ?? 'Hamba Allah' }}</td>
                                <td class="px-6 py-3 text-gray-500">{{ Str::limit($d->donasi->nama_donasi, 20) }}</td>
                                <td class="px-6 py-3 text-right font-bold text-emerald-600">
                                    Rp {{ number_format($d->besar_donasi, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-400">
                                    Belum ada data terbaru.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="bg-white rounded-[2rem] border shadow-sm p-6 flex flex-col overflow-hidden">
            <h3 class="font-bold mb-4 flex-shrink-0">Kegiatan Terdekat</h3>

            <div class="flex-1 overflow-y-auto space-y-6">
                @forelse($kegiatanTerdekat as $k)
                <div class="flex gap-4">
                    <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex flex-col items-center justify-center border">
                        <span class="text-[10px] font-bold uppercase">{{ $k->tanggal?->format('M') }}</span>
                        <span class="text-xl font-bold">{{ $k->tanggal?->format('d') }}</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-sm">{{ $k->nama_kegiatan }}</h4>
                        <p class="text-xs text-gray-500">📍 {{ $k->lokasi }}</p>
                        <span class="mt-1 inline-block text-[10px] font-bold px-2 py-0.5 rounded bg-gray-100">
                            {{ ucfirst($k->status_kegiatan) }}
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-400 text-sm">Tidak ada kegiatan terdekat.</p>
                @endforelse
            </div>

            <button onclick="location.href='{{ route('kegiatan.index') }}'"
                class="mt-4 py-3 rounded-xl border text-sm font-bold flex-shrink-0">
                Kelola Jadwal
            </button>
        </div>
    </div>

</div>
@endsection
