@extends('layouts.app')

@section('title', 'Muzakki - Manajemen ZIS')
@section('page_title', 'Daftar Muzakki')

@section('content')
<div class="bg-white rounded-lg shadow p-6 mb-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Data Muzakki</h3>
        <a href="{{ route('admin.muzakki.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> Tambah Muzakki
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">No</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Nama</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">No. HP</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Alamat</th>
                    <th class="px-4 py-2 text-center text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($muzakki as $item)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-700">{{ ($muzakki->currentPage() - 1) * $muzakki->perPage() + $loop->iteration }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700 font-medium">{{ $item->nama }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $item->no_hp ?? '-' }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ Str::limit($item->alamat, 30) ?? '-' }}</td>
                        <td class="px-4 py-2 text-center text-sm">
                            <a href="{{ route('admin.muzakki.show', $item) }}" class="text-blue-600 hover:text-blue-800 mr-2">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.muzakki.edit', $item) }}" class="text-yellow-600 hover:text-yellow-800 mr-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.muzakki.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Yakin?')">
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
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">Belum ada data muzakki</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $muzakki->links() }}</div>
</div>
@endsection
