@extends('layouts.app')

@section('title', 'Dashboard Admin - Manajemen ZIS')
@section('page_title', 'Dashboard Admin')

@section('content')
<div class="space-y-8">
    
    {{-- ===== STATISTIK UTAMA ===== --}}
    <section>
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-chart-line text-blue-600 mr-3"></i>Statistik Utama
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total ZIS Masuk --}}
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow-md hover:shadow-lg transition p-6 border-l-4 border-green-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Total ZIS Masuk</p>
                        <p class="text-3xl font-bold text-green-700 mt-2">Rp {{ number_format($totalZis, 0, ',', '.') }}</p>
                    </div>
                    <i class="fas fa-money-bill text-5xl text-green-200"></i>
                </div>
            </div>

            {{-- Total Penyaluran --}}
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg shadow-md hover:shadow-lg transition p-6 border-l-4 border-orange-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Total Penyaluran</p>
                        <p class="text-3xl font-bold text-orange-700 mt-2">Rp {{ number_format($totalPenyaluran, 0, ',', '.') }}</p>
                    </div>
                    <i class="fas fa-hand-holding text-5xl text-orange-200"></i>
                </div>
            </div>

            {{-- Sisa Dana --}}
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-md hover:shadow-lg transition p-6 border-l-4 border-blue-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Sisa Dana</p>
                        <p class="text-3xl font-bold text-blue-700 mt-2">Rp {{ number_format($sisaDana, 0, ',', '.') }}</p>
                    </div>
                    <i class="fas fa-wallet text-5xl text-blue-200"></i>
                </div>
            </div>

            {{-- Jumlah Data --}}
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow-md hover:shadow-lg transition p-6 border-l-4 border-purple-600">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <p class="text-gray-600 text-xs font-semibold">Muzakki</p>
                        <p class="text-2xl font-bold text-purple-700 mt-1">{{ $countMuzakki }}</p>
                    </div>
                    <div class="text-center border-l border-purple-300">
                        <p class="text-gray-600 text-xs font-semibold">Mustahik</p>
                        <p class="text-2xl font-bold text-purple-700 mt-1">{{ $countMustahik }}</p>
                    </div>
                    <div class="text-center pt-2">
                        <p class="text-gray-600 text-xs font-semibold">ZIS Masuk</p>
                        <p class="text-2xl font-bold text-purple-700 mt-1">{{ $countZismasuk }}</p>
                    </div>
                    <div class="text-center border-l border-purple-300 pt-2">
                        <p class="text-gray-600 text-xs font-semibold">Penyaluran</p>
                        <p class="text-2xl font-bold text-purple-700 mt-1">{{ $countPenyaluran }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== NAVIGASI QUICK ACTION ===== --}}
    <section>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Persetujuan Muzakki --}}
            <a href="{{ route('admin.muzakki.index') }}" class="group bg-white rounded-lg shadow-md hover:shadow-xl transition p-6 border-t-4 border-orange-600">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-800 group-hover:text-orange-600 transition">
                        <i class="fas fa-user-check text-orange-600 mr-2"></i>Persetujuan Muzakki
                    </h3>
                    <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-sm font-bold">
                        {{ $muzakkiPending->count() }}
                    </span>
                </div>
                <p class="text-gray-600 text-sm">{{ $muzakkiPending->count() }} menunggu persetujuan</p>
            </a>

            {{-- Persetujuan Mustahik --}}
            <a href="{{ route('admin.mustahik.index') }}" class="group bg-white rounded-lg shadow-md hover:shadow-xl transition p-6 border-t-4 border-yellow-600">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-800 group-hover:text-yellow-600 transition">
                        <i class="fas fa-user-friends text-yellow-600 mr-2"></i>Persetujuan Mustahik
                    </h3>
                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-bold">
                        {{ $mustahikPending->count() }}
                    </span>
                </div>
                <p class="text-gray-600 text-sm">{{ $mustahikPending->count() }} menunggu verifikasi</p>
            </a>
        </div>
    </section>

    {{-- ===== DATA TERBARU ===== --}}
    <section>
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-history text-blue-600 mr-3"></i>Aktivitas Terbaru
        </h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- ZIS Masuk Terbaru --}}
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition p-6 border-t-4 border-green-600">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-arrow-down text-green-600 mr-2"></i>ZIS Masuk Terbaru
                </h3>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse($recentZis as $zis)
                        <div class="flex justify-between items-start p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition border-l-4 border-green-300">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $zis->muzakki->nama }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-tag mr-1"></i>{{ ucfirst($zis->jenis_zis) }}
                                    <span class="mx-1">•</span>
                                    {{ $zis->tgl_masuk->format('d M Y') }}
                                </p>
                            </div>
                            <p class="font-bold text-green-600 whitespace-nowrap ml-2">Rp {{ number_format($zis->jumlah, 0, ',', '.') }}</p>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2 opacity-50"></i>
                            <p>Belum ada transaksi</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Penyaluran Terbaru --}}
            <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition p-6 border-t-4 border-orange-600">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-arrow-up text-orange-600 mr-2"></i>Penyaluran Terbaru
                </h3>
                <div class="space-y-3 max-h-96 overflow-y-auto">
                    @forelse($recentPenyaluran as $salur)
                        <div class="flex justify-between items-start p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition border-l-4 border-orange-300">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $salur->mustahik->nama }}</p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-calendar mr-1"></i>{{ $salur->tgl_salur->format('d M Y') }}
                                </p>
                            </div>
                            <p class="font-bold text-orange-600 whitespace-nowrap ml-2">Rp {{ number_format($salur->jumlah, 0, ',', '.') }}</p>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-inbox text-4xl mb-2 opacity-50"></i>
                            <p>Belum ada penyaluran</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- ===== STATISTIK TAMBAHAN ===== --}}
    <section>
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-chart-pie text-purple-600 mr-3"></i>Statistik Lainnya
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Muzakki Disetujui --}}
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow-md p-6 border-l-4 border-green-600">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Muzakki Disetujui</p>
                        <p class="text-3xl font-bold text-green-700 mt-2">{{ $muzakkiApproved }}</p>
                    </div>
                    <i class="fas fa-user-check text-5xl text-green-200"></i>
                </div>
            </div>

            {{-- Muzakki Ditolak --}}
            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg shadow-md p-6 border-l-4 border-red-600">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Muzakki Ditolak</p>
                        <p class="text-3xl font-bold text-red-700 mt-2">{{ $muzakkiRejected }}</p>
                    </div>
                    <i class="fas fa-user-times text-5xl text-red-200"></i>
                </div>
            </div>

            {{-- Mustahik Disetujui --}}
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow-md p-6 border-l-4 border-blue-600">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Mustahik Disetujui</p>
                        <p class="text-3xl font-bold text-blue-700 mt-2">{{ $mustahikApproved }}</p>
                    </div>
                    <i class="fas fa-users text-5xl text-blue-200"></i>
                </div>
            </div>

            {{-- Mustahik Ditolak --}}
            <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg shadow-md p-6 border-l-4 border-pink-600">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Mustahik Ditolak</p>
                        <p class="text-3xl font-bold text-pink-700 mt-2">{{ $mustahikRejected }}</p>
                    </div>
                    <i class="fas fa-user-slash text-5xl text-pink-200"></i>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== JENIS ZIS TERBANYAK ===== --}}
    @if($topZisTypes->isNotEmpty())
    <section>
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-list text-indigo-600 mr-3"></i>Jenis ZIS Terbanyak
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($topZisTypes as $zisType)
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-indigo-600">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-gray-800 capitalize">{{ ucfirst($zisType->jenis_zis) }}</h3>
                    <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-bold">
                        {{ $zisType->count }} Transaksi
                    </span>
                </div>
                <p class="text-gray-600 text-sm mb-2">
                    <i class="fas fa-sum text-gray-400 mr-2"></i>Total: <span class="font-bold text-indigo-600">Rp {{ number_format($zisType->total, 0, ',', '.') }}</span>
                </p>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ ($zisType->total / $topZisTypes->sum('total') * 100) }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ===== KATEGORI MUSTAHIK ===== --}}
    @if($topCategories->isNotEmpty())
    <section>
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-users text-cyan-600 mr-3"></i>Kategori Mustahik Terbanyak
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($topCategories as $category)
            <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-cyan-600">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="font-bold text-gray-800 capitalize">{{ ucfirst(str_replace('_', ' ', $category->kategori_mustahik)) }}</h3>
                    <span class="bg-cyan-100 text-cyan-700 px-3 py-1 rounded-full text-sm font-bold">
                        {{ $category->count }} Orang
                    </span>
                </div>
                <p class="text-gray-600 text-sm">
                    <i class="fas fa-percentage text-cyan-600 mr-1"></i>
                    <span class="font-semibold">{{ round($category->count / $topCategories->sum('count') * 100, 1) }}%</span> dari total
                </p>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ===== PERSETUJUAN MUZAKKI ===== --}}
    <section>
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-clipboard-check text-orange-600 mr-3"></i>Persetujuan Pendaftaran Muzakki
        </h2>
        @if(isset($muzakkiPending) && !$muzakkiPending->isEmpty())
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-orange-50 to-orange-100 border-b-2 border-orange-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-bold text-orange-800">Nama Muzakki</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-orange-800">Kontak</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-orange-800">Tanggal Daftar</th>
                                <th class="px-6 py-4 text-right text-sm font-bold text-orange-800">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($muzakkiPending as $muzakki)
                            <tr class="hover:bg-orange-50 transition">
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    <i class="fas fa-user text-orange-500 mr-2"></i>{{ $muzakki->nama }}
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <i class="fas fa-phone text-gray-400 mr-2"></i>{{ $muzakki->no_hp ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <i class="fas fa-calendar text-gray-400 mr-2"></i>{{ $muzakki->tgl_daftar->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.muzakki.show', $muzakki->id_muzakki) }}" 
                                       class="inline-flex items-center bg-blue-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                                        <i class="fas fa-eye mr-1"></i>Lihat
                                    </a>
                                    <form action="{{ route('admin.muzakki.approve', $muzakki->id_muzakki) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center bg-green-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-green-700 transition"
                                                onclick="return confirm('Setujui pendaftaran Muzakki ini?')">
                                            <i class="fas fa-check mr-1"></i>Setujui
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.muzakki.destroy', $muzakki->id_muzakki) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center bg-red-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-red-700 transition"
                                                onclick="return confirm('Tolak pendaftaran Muzakki ini?')">
                                            <i class="fas fa-times mr-1"></i>Tolak
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 rounded-lg p-6 flex items-center">
                <i class="fas fa-check-circle text-green-600 text-3xl mr-4"></i>
                <div>
                    <p class="font-bold text-green-800">Sempurna!</p>
                    <p class="text-green-700 text-sm">Tidak ada permintaan persetujuan Muzakki yang tertunda</p>
                </div>
            </div>
        @endif
    </section>

    {{-- ===== PERSETUJUAN MUSTAHIK ===== --}}
    <section>
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-user-shield text-yellow-600 mr-3"></i>Persetujuan Pendaftaran Mustahik
        </h2>
        @if(isset($mustahikPending) && !$mustahikPending->isEmpty())
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-yellow-50 to-yellow-100 border-b-2 border-yellow-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-bold text-yellow-800">Nama Mustahik</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-yellow-800">Kategori</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-yellow-800">Tanggal Daftar</th>
                                <th class="px-6 py-4 text-right text-sm font-bold text-yellow-800">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($mustahikPending as $mustahik)
                            <tr class="hover:bg-yellow-50 transition">
                                <td class="px-6 py-4 font-semibold text-gray-800">
                                    <i class="fas fa-user text-yellow-500 mr-2"></i>{{ $mustahik->nama }}
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                                        {{ $mustahik->kategori_mustahik ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <i class="fas fa-calendar text-gray-400 mr-2"></i>{{ $mustahik->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.mustahik.verifikasi.show', $mustahik->id_mustahik) }}" 
                                       class="inline-flex items-center bg-blue-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                                        <i class="fas fa-eye mr-1"></i>Lihat
                                    </a>
                                    <form action="{{ route('admin.mustahik.approve', $mustahik->id_mustahik) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center bg-green-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-green-700 transition"
                                                onclick="return confirm('Setujui pendaftaran Mustahik ini?')">
                                            <i class="fas fa-check mr-1"></i>Setujui
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.mustahik.destroy', $mustahik->id_mustahik) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center bg-red-600 text-white px-3 py-2 rounded-lg text-sm hover:bg-red-700 transition"
                                                onclick="return confirm('Tolak pendaftaran Mustahik ini?')">
                                            <i class="fas fa-times mr-1"></i>Tolak
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 rounded-lg p-6 flex items-center">
                <i class="fas fa-check-circle text-green-600 text-3xl mr-4"></i>
                <div>
                    <p class="font-bold text-green-800">Sempurna!</p>
                    <p class="text-green-700 text-sm">Tidak ada permintaan persetujuan Mustahik yang tertunda</p>
                </div>
            </div>
        @endif
    </section>

    {{-- ===== TOMBOL AKSI CEPAT ===== --}}
    <section>
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-star text-yellow-500 mr-3"></i>Aksi Cepat
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('admin.zis.masuk.index') }}" class="group bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow-md hover:shadow-lg transition p-6 border-t-4 border-green-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-700 font-semibold group-hover:text-green-700 transition">
                            <i class="fas fa-money-bill-wave text-green-600 mr-2"></i>Tambah ZIS Masuk
                        </p>
                        <p class="text-gray-600 text-sm mt-1">Catat penerimaan ZIS baru</p>
                    </div>
                    <i class="fas fa-arrow-right text-green-300 text-xl group-hover:translate-x-1 transition"></i>
                </div>
            </a>
            <a href="{{ route('admin.penyaluran.index') }}" class="group bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg shadow-md hover:shadow-lg transition p-6 border-t-4 border-orange-600">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-700 font-semibold group-hover:text-orange-700 transition">
                            <i class="fas fa-hand-holding-heart text-orange-600 mr-2"></i>Tambah Penyaluran
                        </p>
                        <p class="text-gray-600 text-sm mt-1">Catat pendistribusian ZIS</p>
                    </div>
                    <i class="fas fa-arrow-right text-orange-300 text-xl group-hover:translate-x-1 transition"></i>
                </div>
            </a>
        </div>
    </section>
</div>
@endsection