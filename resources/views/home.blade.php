@extends('layouts.app')

@section('header_title', 'Beranda')

@section('content')
<div class="space-y-6">
    <div class="bg-gradient-to-r from-blue-600 to-blue-500 rounded-3xl p-8 text-white shadow-xl">
        <h2 class="text-3xl font-bold mb-2">Assalamu'alaikum, {{ $user->nama_lengkap }}</h2>
        <p class="text-blue-100">Selamat datang di Aplikasi Manajemen Masjid. Semoga harimu berkah.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-bold uppercase">Total Donasi Saya</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalDonasiKu, 0, ',', '.') }}</h3>
                <a href="{{ route('user.donasi') }}" class="text-blue-600 text-sm font-bold mt-2 inline-block">Lihat Detail &rarr;</a>
            </div>
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-xl">🎁</div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] border border-gray-100 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-bold uppercase">Kegiatan Diikuti</p>
                <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $kegiatanKu }} Acara</h3>
                <a href="{{ route('user.kegiatan') }}" class="text-blue-600 text-sm font-bold mt-2 inline-block">Lihat Jadwal &rarr;</a>
            </div>
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-xl">📅</div>
        </div>
    </div>
</div>
@endsection