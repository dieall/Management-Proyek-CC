@extends('layouts.app')

@section('title', 'Profil Muzakki')
@section('page_title', 'Profil Saya')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <h3 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-3">
        Data Profil Muzakki
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
        {{-- Nama --}}
        <div>
            <p class="font-medium text-gray-600">Nama Lengkap</p>
            <p class="font-bold text-gray-900 text-lg">{{ $muzakki->nama }}</p>
        </div>

        {{-- No. HP --}}
        <div>
            <p class="font-medium text-gray-600">Nomor HP</p>
            <p class="font-bold text-gray-900 text-lg">{{ $muzakki->no_hp ?? '-' }}</p>
        </div>

        {{-- Alamat --}}
        <div class="md:col-span-2">
            <p class="font-medium text-gray-600">Alamat</p>
            <p class="font-bold text-gray-900 text-lg">{{ $muzakki->alamat ?? '-' }}</p>
        </div>

        {{-- Tanggal Daftar --}}
        <div>
            <p class="font-medium text-gray-600">Terdaftar Sejak</p>
            <p class="font-bold text-gray-900 text-lg">{{ \Carbon\Carbon::parse($muzakki->tgl_daftar)->format('d F Y') }}</p>
        </div>
    </div>
    
    <div class="mt-8 text-right">
        <a href="{{ route('muzakki.dashboard') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection