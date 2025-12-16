@extends('layouts.app') 

@section('title', 'Dashboard Petugas ZIS')
@section('page_title', 'Dashboard Petugas')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">Selamat Bertugas, {{ Auth::user()->nama_lengkap }}!</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    {{-- Card 1: Total ZIS Masuk --}}
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
        <p class="text-gray-500 text-sm">Total ZIS Masuk (Keseluruhan)</p>
        <p class="text-3xl font-bold text-blue-700 mt-1">Rp {{ number_format($totalZis ?? 0, 0, ',', '.') }}</p>
    </div>

    {{-- Card 2: Total Penyaluran --}}
    <div class="bg-white rounded-lg shadow p-6 border-l-4 border-red-500">
        <p class="text-gray-500 text-sm">Total Penyaluran (Keseluruhan)</p>
        <p class="text-3xl font-bold text-red-700 mt-1">Rp {{ number_format($totalPenyaluran ?? 0, 0, ',', '.') }}</p>
    </div>

    {{-- Card 3: Mustahik Menunggu Verifikasi --}}
    <a href="{{ route('admin.mustahik.index') }}" class="block">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500 hover:bg-yellow-50 transition">
            <p class="text-gray-500 text-sm">Mustahik Menunggu Aktivasi</p>
            <p class="text-3xl font-bold text-yellow-700 mt-1">{{ $mustahikMenunggu ?? 0 }} Data</p>
        </div>
    </a>
</div>

<div class="bg-white rounded-lg shadow p-6">
    <h3 class="text-xl font-semibold mb-4">Aksi Cepat Operasional</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.zis.masuk.create') }}" class="text-center p-4 border rounded-lg hover:bg-gray-50">
            <i class="fas fa-plus-circle text-green-600 text-2xl mb-2"></i>
            <p class="text-sm font-medium">Input ZIS Manual</p>
        </a>
        <a href="{{ route('admin.penyaluran.create') }}" class="text-center p-4 border rounded-lg hover:bg-gray-50">
            <i class="fas fa-arrow-alt-circle-down text-blue-600 text-2xl mb-2"></i>
            <p class="text-sm font-medium">Buat Penyaluran Baru</p>
        </a>
        <a href="{{ route('admin.mustahik.index') }}" class="text-center p-4 border rounded-lg hover:bg-gray-50">
            <i class="fas fa-clipboard-check text-yellow-600 text-2xl mb-2"></i>
            <p class="text-sm font-medium">Kelola Mustahik</p>
        </a>
        <a href="{{ route('admin.muzakki.index') }}" class="text-center p-4 border rounded-lg hover:bg-gray-50">
            <i class="fas fa-users text-purple-600 text-2xl mb-2"></i>
            <p class="text-sm font-medium">Daftar Muzakki</p>
        </a>
    </div>
</div>
@endsection