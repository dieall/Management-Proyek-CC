@extends('layouts.app') {{-- Pastikan layout Anda bernama 'layouts.app' --}}

@section('title', 'Dashboard - Manajemen ZIS')
@section('page_title', 'Dashboard Admin')

@section('content')

{{-- Bagian Persetujuan Muzakki --}}
<h2 class="text-2xl font-bold mb-4 mt-8">🔔 Permintaan Pendaftaran Muzakki Baru (Approval)</h2>

    @if($muzakkiMenunggu->isEmpty())
        <div class="p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
            Semua permintaan Muzakki sudah disetujui. Tidak ada data menunggu.
        </div>
    @else
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Muzakki</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. HP / Akun User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Daftar</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($muzakkiMenunggu as $muzakki)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $muzakki->nama }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $muzakki->no_hp }} <br>
                            {{-- Menggunakan operator nullsafe (?->) --}}
                            <span class="text-xs text-blue-500">({{ $muzakki->user?->username ?? 'Tidak Terikat' }})</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($muzakki->tgl_daftar)->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            {{-- Form yang memanggil route admin.muzakki.approve --}}
                            <form action="{{ route('admin.muzakki.approve', $muzakki->id_muzakki) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin menyetujui Muzakki ini?');">
                                @csrf
                                <button type="submit" class="text-white bg-green-600 hover:bg-green-700 font-bold py-1 px-3 rounded-full text-xs">
                                    Setujui
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    
    {{-- Bagian Statistik Utama --}}
    <h2 class="text-2xl font-bold mb-4 mt-8">📊 Statistik Utama ZIS</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Total ZIS --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total ZIS Masuk</p>
                    <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalZis, 0, ',', '.') }}</p>
                </div>
                <div class="text-4xl text-green-500"><i class="fas fa-money-bill"></i></div>
            </div>
        </div>

        {{-- Total Penyaluran --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Penyaluran</p>
                    <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($totalPenyaluran, 0, ',', '.') }}</p>
                </div>
                <div class="text-4xl text-orange-500"><i class="fas fa-hand-holding"></i></div>
            </div>
        </div>

        {{-- Sisa Dana --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Sisa Dana</p>
                    <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($sisaDana, 0, ',', '.') }}</p>
                </div>
                <div class="text-4xl text-blue-500"><i class="fas fa-wallet"></i></div>
            </div>
        </div>

        {{-- Count Stats --}}
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-xs">Muzakki</p><p class="text-2xl font-bold text-gray-800">{{ $countMuzakki }}</p></div>
            <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-xs">Mustahik</p><p class="text-2xl font-bold text-gray-800">{{ $countMustahik }}</p></div>
            <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-xs">ZIS Masuk</p><p class="text-2xl font-bold text-gray-800">{{ $countZismasuk }}</p></div>
            <div class="bg-white rounded-lg shadow p-4"><p class="text-gray-500 text-xs">Penyaluran</p><p class="text-2xl font-bold text-gray-800">{{ $countPenyaluran }}</p></div>
        </div>
    </div>

    {{-- Bagian Recent Transactions --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent ZIS Masuk --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4"><i class="fas fa-money-bill text-green-500 mr-2"></i> ZIS Masuk Terbaru</h3>
            <div class="space-y-3">
                @forelse($recentZis as $zis)
                    <div class="flex justify-between items-start border-b pb-3">
                        <div>
                            <p class="font-medium text-gray-800">{{ $zis->muzakki->nama }}</p>
                            <p class="text-sm text-gray-500">{{ ucfirst($zis->jenis_zis) }} - {{ $zis->tgl_masuk->format('d/m/Y') }}</p>
                        </div>
                        <p class="font-semibold text-green-600">Rp {{ number_format($zis->jumlah, 0, ',', '.') }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Belum ada data</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Penyaluran --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4"><i class="fas fa-hand-holding text-orange-500 mr-2"></i> Penyaluran Terbaru</h3>
            <div class="space-y-3">
                @forelse($recentPenyaluran as $salur)
                    <div class="flex justify-between items-start border-b pb-3">
                        <div>
                            <p class="font-medium text-gray-800">{{ $salur->mustahik->nama }}</p>
                            <p class="text-sm text-gray-500">{{ $salur->tgl_salur->format('d/m/Y') }}</p>
                        </div>
                        <p class="font-semibold text-orange-600">Rp {{ number_format($salur->jumlah, 0, ',', '.') }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="mt-6 text-center">
        <a href="{{ route('admin.zis.masuk.index') }}" class="inline-block mr-3 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            <i class="fas fa-plus mr-2"></i> Tambah ZIS Masuk
        </a>
        <a href="{{ route('admin.penyaluran.index') }}" class="inline-block bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700">
            <i class="fas fa-plus mr-2"></i> Tambah Penyaluran
        </a>
    </div>
@endsection