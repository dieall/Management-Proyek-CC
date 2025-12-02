@extends('layouts.app')

@section('title', 'Penyaluran - Manajemen ZIS')
@section('page_title', 'Daftar Penyaluran')

@section('content')
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Data Penyaluran</h3>
        <a href="{{ route('penyaluran.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> Tambah Penyaluran
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">No</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Muzakki</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Mustahik</th>
                    <th class="px-4 py-2 text-right text-sm font-semibold text-gray-700">Jumlah</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penyaluran as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-700">{{ ($penyaluran->currentPage() - 1) * $penyaluran->perPage() + $loop->iteration }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $item->zismasuk->muzakki->nama }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">
                            <strong>{{ $item->mustahik->nama }}</strong><br>
                            <small class="text-gray-500">{{ $item->mustahik->kategori_mustahik }}</small>
                        </td>
                        <td class="px-4 py-2 text-sm text-right text-gray-700 font-semibold text-orange-600">
                            Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $item->tgl_salur->format('d/m/Y') }}</td>
                        <td class="px-4 py-2 text-center text-sm">
                            <a href="{{ route('penyaluran.show', $item) }}" class="text-blue-600 hover:text-blue-800 mr-2">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('penyaluran.edit', $item) }}" class="text-yellow-600 hover:text-yellow-800 mr-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('penyaluran.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Yakin?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">Belum ada data penyaluran</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $penyaluran->links() }}</div>
</div>
@endsection
