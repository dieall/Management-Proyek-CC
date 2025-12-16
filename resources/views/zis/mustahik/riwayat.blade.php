@extends('layouts.app')

@section('title', 'Riwayat Penerimaan Bantuan')
@section('page_title', 'Riwayat Penyaluran ZIS')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-lg">
    <h3 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-3">
        Riwayat Penerimaan Dana/Bantuan
    </h3>
    
    <div class="mb-4 p-4 bg-orange-50 border border-orange-200 rounded">
        <p class="font-semibold text-orange-800">Total Bantuan Diterima: 
            Rp {{ number_format($mustahik->penyaluran()->sum('jumlah') ?? 0, 0, ',', '.') }}
        </p>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Salur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Penyaluran</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah (Rp)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($penyaluran as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($item->tgl_salur)->format('d M Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $item->id_penyaluran }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-orange-600 font-semibold">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 max-w-xs truncate">{{ $item->keterangan ?? 'Bantuan rutin ZIS' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat penerimaan bantuan ZIS yang ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8 text-right">
        <a href="{{ route('mustahik.dashboard') }}" class="inline-block bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>
</div>
@endsection