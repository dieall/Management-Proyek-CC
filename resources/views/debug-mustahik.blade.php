@extends('layouts.app')

@section('title', 'Debug Mustahik Data')
@section('page_title', 'Debug Mustahik Data')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-2xl font-bold mb-4">Debug: Semua Data Mustahik</h2>
    
    <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-600 rounded">
        <p class="text-blue-700"><strong>Total Mustahik:</strong> {{ $allMustahik->count() }}</p>
        <p class="text-blue-700"><strong>Pending (status_verifikasi = 'pending'):</strong> {{ $pendingMustahik->count() }}</p>
    </div>

    <h3 class="text-lg font-semibold mb-3">Semua Data Mustahik:</h3>
    @if($allMustahik->isEmpty())
        <p class="text-gray-500">Tidak ada data Mustahik</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse border border-gray-300">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="border p-2">ID</th>
                        <th class="border p-2">Nama</th>
                        <th class="border p-2">Kategori</th>
                        <th class="border p-2">No HP</th>
                        <th class="border p-2">status_verifikasi</th>
                        <th class="border p-2">status</th>
                        <th class="border p-2">created_at</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allMustahik as $mustahik)
                    <tr>
                        <td class="border p-2">{{ $mustahik->id_mustahik }}</td>
                        <td class="border p-2">{{ $mustahik->nama }}</td>
                        <td class="border p-2">{{ $mustahik->kategori_mustahik }}</td>
                        <td class="border p-2">{{ $mustahik->no_hp }}</td>
                        <td class="border p-2">
                            <span class="px-2 py-1 rounded text-sm font-semibold 
                                @if($mustahik->status_verifikasi === 'pending') bg-yellow-200 text-yellow-700
                                @elseif($mustahik->status_verifikasi === 'disetujui') bg-green-200 text-green-700
                                @else bg-red-200 text-red-700
                                @endif">
                                {{ $mustahik->status_verifikasi ?? 'NULL' }}
                            </span>
                        </td>
                        <td class="border p-2">{{ $mustahik->status ?? 'NULL' }}</td>
                        <td class="border p-2">{{ $mustahik->created_at?->format('d M Y H:i') ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('admin.dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
