@extends('layouts.app')

@section('title', 'Mustahik - Manajemen ZIS')
@section('page_title', 'Daftar Mustahik')

@section('content')
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Data Mustahik (Penerima Zakat)</h3>
        <a href="{{ route('admin.mustahik.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> Tambah Mustahik
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">No</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Nama</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Kategori</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">No. HP</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mustahik as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-700">{{ ($mustahik->currentPage() - 1) * $mustahik->perPage() + $loop->iteration }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700 font-medium">{{ $item->nama }}</td>
                        <td class="px-4 py-2 text-sm">
                            <span class="px-2 py-1 rounded text-white text-xs font-semibold bg-purple-500">
                                {{ ucfirst(str_replace('_', ' ', $item->kategori_mustahik)) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $item->no_hp ?? '-' }}</td>
                        <td class="px-4 py-2 text-sm">
                            <span class="px-2 py-1 rounded text-white text-xs font-semibold {{ $item->status === 'aktif' ? 'bg-green-500' : 'bg-gray-500' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center text-sm">
                            <a href="{{ route('admin.mustahik.show', $item) }}" class="text-blue-600 hover:text-blue-800 mr-2">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.mustahik.edit', $item) }}" class="text-yellow-600 hover:text-yellow-800 mr-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.mustahik.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Yakin?')">
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
                        <td colspan="6" class="px-4 py-4 text-center text-gray-500">Belum ada data mustahik</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $mustahik->links() }}</div>
</div>
@endsection
