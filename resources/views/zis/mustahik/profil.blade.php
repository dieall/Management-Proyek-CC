@extends('layouts.app')

@section('title', 'Profil Mustahik')
@section('page_title', 'Profil Saya')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <h3 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-3">
        Data Profil Mustahik
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
        {{-- Nama --}}
        <div>
            <p class="font-medium text-gray-600">Nama Lengkap</p>
            <p class="font-bold text-gray-900 text-lg">{{ $mustahik->nama }}</p>
        </div>

        {{-- No. HP --}}
        <div>
            <p class="font-medium text-gray-600">Nomor HP</p>
            <p class="font-bold text-gray-900 text-lg">{{ $mustahik->no_hp ?? '-' }}</p>
        </div>

        {{-- Kategori Asnaf --}}
        <div>
            <p class="font-medium text-gray-600">Kategori Mustahik (Asnaf)</p>
            <p class="font-bold text-red-600 text-lg uppercase">{{ $mustahik->kategori_mustahik }}</p>
        </div>

        {{-- Status --}}
        <div>
            <p class="font-medium text-gray-600">Status Keaktifan</p>
            <p class="font-bold text-lg {{ $mustahik->status == 'aktif' ? 'text-green-600' : 'text-red-600' }}">
                {{ ucfirst($mustahik->status) }}
            </p>
        </div>

        {{-- Alamat --}}
        <div class="md:col-span-2">
            <p class="font-medium text-gray-600">Alamat</p>
            <p class="font-bold text-gray-900 text-lg">{{ $mustahik->alamat ?? '-' }}</p>
        </div>
        
        {{-- Surat DTKS --}}
        <div class="md:col-span-2">
            <p class="font-medium text-gray-600 mb-2">Nomor/Keterangan DTKS</p>
            <div class="flex items-center gap-3">
                <p class="font-bold text-gray-900 text-lg">{{ $mustahik->surat_dtks ?? 'Tidak tercatat' }}</p>
                @if($mustahik->surat_dtks)
                    <a href="{{ asset('storage/' . $mustahik->surat_dtks) }}" 
                       target="_blank" 
                       class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white px-3 md:px-4 py-2 rounded text-sm md:text-base font-medium transition shadow-md hover:shadow-lg">
                        <i class="fas fa-file-download mr-2"></i>
                        <span class="hidden sm:inline">Lihat File</span>
                        <span class="sm:hidden">File</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
    
    <div class="mt-8 text-right">
        <a href="{{ route('mustahik.dashboard') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection