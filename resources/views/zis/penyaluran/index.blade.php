@extends('layouts.app')

@section('title', 'Penyaluran - Manajemen ZIS')
@section('page_title', 'Daftar Penyaluran')

@section('content')
    <div class="space-y-6">
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Total Penyaluran --}}
            <div
                class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg shadow-md p-6 border-l-4 border-orange-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Total Penyaluran</p>
                        <p class="text-3xl font-bold text-orange-700 mt-2">Rp
                            {{ number_format($totalPenyaluran, 0, ',', '.') }}</p>
                    </div>
                    <i class="fas fa-hand-holding-heart text-5xl text-orange-200"></i>
                </div>
            </div>

            {{-- Jumlah Penyaluran --}}
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-md p-6 border-l-4 border-blue-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Jumlah Penyaluran</p>
                        <p class="text-3xl font-bold text-blue-700 mt-2">{{ $countPenyaluran }}</p>
                    </div>
                    <i class="fas fa-list text-5xl text-blue-200"></i>
                </div>
            </div>

            {{-- Rata-rata Per Penyaluran --}}
            <div
                class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow-md p-6 border-l-4 border-purple-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Rata-rata</p>
                        <p class="text-3xl font-bold text-purple-700 mt-2">Rp
                            {{ $countPenyaluran > 0 ? number_format($totalPenyaluran / $countPenyaluran, 0, ',', '.') : '0' }}
                        </p>
                    </div>
                    <i class="fas fa-calculator text-5xl text-purple-200"></i>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Filter Data</h3>
                @if ($month || $search)
                    <a href="{{ route('admin.penyaluran.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                        <i class="fas fa-times mr-2"></i>Reset Filter
                    </a>
                @endif
            </div>

            <form method="GET" action="{{ route('admin.penyaluran.index') }}"
                class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Filter Bulan --}}
                <div>
                    <label for="month" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Bulan</label>
                    <select name="month" id="month"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="">-- Semua Bulan --</option>
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::createFromDate(null, $m, 1)->isoFormat('MMMM') }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- Search Mustahik/Muzakki --}}
                <div>
                    <label for="search" class="block text-sm font-semibold text-gray-700 mb-2">Nama
                        Penerima/Pemberi</label>
                    <input type="text" name="search" id="search" placeholder="Cari nama..."
                        value="{{ $search }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                </div>

                {{-- Submit Button --}}
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition font-semibold flex items-center justify-center">
                        <i class="fas fa-search mr-2"></i>Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        {{-- Data Table --}}
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Data Penyaluran</h3>
                <a href="{{ route('admin.penyaluran.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
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
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    {{ ($penyaluran->currentPage() - 1) * $penyaluran->perPage() + $loop->iteration }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">{{ $item->zismasuk->muzakki->nama }}</td>
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    <strong>{{ $item->mustahik->nama }}</strong><br>
                                    <small class="text-gray-500">{{ $item->mustahik->kategori_mustahik }}</small>
                                </td>
                                <td class="px-4 py-2 text-sm text-right text-gray-700 font-semibold text-orange-600">
                                    Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-2 text-sm text-gray-700">
                                    {{ $item->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-4 py-2 text-center text-sm">
                                    <a href="{{ route('admin.penyaluran.show', $item) }}"
                                        class="text-blue-600 hover:text-blue-800 mr-2">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.penyaluran.edit', $item) }}"
                                        class="text-yellow-600 hover:text-yellow-800 mr-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.penyaluran.destroy', $item) }}" method="POST"
                                        class="inline" onsubmit="return confirm('Yakin?')">
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
                                <td colspan="6" class="px-4 py-4 text-center text-gray-500">Belum ada data penyaluran
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $penyaluran->links() }}</div>
        </div>
    </div>
@endsection
