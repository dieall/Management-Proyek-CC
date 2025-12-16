@extends('layouts.app')

@section('title', 'Verifikasi Mustahik Baru')
@section('page_title', 'Tinjau Pendaftaran Mustahik')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    
    <h3 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-3">
        Verifikasi Data: {{ $mustahik->nama }}
    </h3>

    <div class="grid grid-cols-2 gap-6 mb-6">
        <div class="space-y-4">
            {{-- Detail Data Mustahik --}}
            <div class="p-4 border rounded-lg bg-gray-50">
                <h4 class="font-semibold text-lg mb-2">Data Diri</h4>
                <p><strong>Kategori:</strong> <span class="text-blue-600">{{ $mustahik->kategori_mustahik }}</span></p>
                <p><strong>Alamat:</strong> {{ $mustahik->alamat }}</p>
                <p><strong>No. HP:</strong> {{ $mustahik->no_hp }}</p>
                <p><strong>Status:</strong> <span class="text-yellow-600 font-semibold">{{ ucfirst($mustahik->status_verifikasi ?? 'Pending') }}</span></p>
            </div>
        </div>

        <div>
            {{-- Detail File DTKS --}}
            <h4 class="font-semibold text-lg mb-2">Dokumen Pendukung (DTKS/SKTM)</h4>
            
            @if($dtksUrl)
                <div class="border p-4 rounded-lg bg-green-50 space-y-3">
                    <p class="text-sm text-green-700 font-semibold">✓ File DTKS terlampir. Tinjau sebelum menyetujui.</p>
                    <div class="bg-gray-50 p-2 rounded text-xs text-gray-600 break-all">
                        <strong>Path:</strong> {{ $mustahik->surat_dtks ?? 'N/A' }}
                    </div>
                    <div class="flex gap-2 justify-center flex-wrap">
                        <a href="{{ $dtksUrl }}" download class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 transition">
                            <i class="fas fa-download mr-2"></i> Unduh Dokumen
                        </a>
                        <a href="{{ $dtksUrl }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition">
                            <i class="fas fa-eye mr-2"></i> Lihat di Tab Baru
                        </a>
                    </div>
                </div>
            @else
                <div class="p-4 border-l-4 border-red-400 rounded-lg bg-red-50 space-y-2">
                    <p class="text-red-700 font-semibold"><i class="fas fa-exclamation-triangle mr-2"></i>Dokumen DTKS tidak ditemukan!</p>
                    <p class="text-sm text-red-600">Path di database: {{ $mustahik->surat_dtks ?? 'Kosong' }}</p>
                    <p class="text-xs text-red-500">Pastikan file sudah di-upload saat pendaftaran dan storage link sudah dibuat.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Aksi Verifikasi --}}
    <div class="mt-8 pt-6 border-t-2 bg-gray-50 p-6 rounded-lg">
        <h4 class="font-semibold text-lg mb-4 text-gray-800">Aksi Verifikasi</h4>
        
        <div class="flex justify-between items-center gap-4">
            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-800 hover:underline">
                <i class="fas fa-arrow-left mr-1"></i>Kembali ke Dashboard
            </a>
            
            <div class="flex gap-3">
                {{-- Tombol Tolak --}}
                <button onclick="if(confirm('Tolak pendaftaran Mustahik ini? Tindakan ini tidak bisa dibatalkan.')) { document.getElementById('denyForm').submit(); }"
                        class="px-6 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100 hover:border-red-500 transition">
                    <i class="fas fa-times mr-2"></i>Tolak
                </button>

                {{-- Form Persetujuan --}}
                <form action="{{ route('admin.mustahik.approve', $mustahik->id_mustahik) }}" method="POST" onsubmit="return confirm('Setujui pendaftaran Mustahik ini?')" class="inline">
                    @csrf
                    <button type="submit" 
                            class="px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 transition">
                        <i class="fas fa-check mr-2"></i>Setujui Mustahik
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Form Reject (Hidden) --}}
    <form id="denyForm" action="{{ route('admin.mustahik.destroy', $mustahik->id_mustahik) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

</div>
@endsection