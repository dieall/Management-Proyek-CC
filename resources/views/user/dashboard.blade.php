@extends('layouts.app') 

@section('title', 'Dashboard Muzakki Portal')
@section('page_title', 'Dashboard Akun ZIS Anda')

@section('content')
<div class="space-y-8">
    {{-- WELCOME HEADER --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-2xl p-8 shadow-lg">
        <h1 class="text-4xl font-bold mb-2">
            <i class="fas fa-hand-holding-heart mr-3"></i>Selamat Datang, {{ $user->nama_lengkap }}!
        </h1>
        <p class="text-blue-100">Kelola donasi zakat, infaq, dan sedekah Anda dengan mudah</p>
    </div>

    {{-- ALERT MESSAGES --}}
    @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 flex items-start" role="alert">
            <i class="fas fa-check-circle text-green-600 text-xl mr-4 flex-shrink-0 mt-0.5"></i>
            <div>
                <p class="text-green-800 font-semibold">Sukses!</p>
                <p class="text-green-700 text-sm mt-1">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 flex items-start" role="alert">
            <i class="fas fa-exclamation-circle text-red-600 text-xl mr-4 flex-shrink-0 mt-0.5"></i>
            <div>
                <p class="text-red-800 font-semibold">Terjadi Kesalahan</p>
                <p class="text-red-700 text-sm mt-1">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    @if(!$isMuzakkiRegistered)
        {{-- STATUS: BELUM TERDAFTAR --}}
        <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-l-4 border-blue-600 rounded-xl p-8 shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-blue-900 mb-2 flex items-center">
                        <i class="fas fa-clipboard-check text-blue-600 mr-3"></i>Status: Belum Terdaftar Sebagai Muzakki
                    </h2>
                    <p class="text-blue-800 mb-3">Untuk dapat membayar ZIS dan melihat riwayat donasi, silakan daftarkan profil Muzakki Anda terlebih dahulu. Data akan diambil dari profil user Anda.</p>
                    <form action="{{ route('user.register-muzakki.store') }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold shadow-lg hover:shadow-xl">
                            <i class="fas fa-user-plus mr-2"></i>Daftar Sebagai Muzakki Sekarang
                        </button>
                    </form>
                </div>
                <i class="fas fa-clipboard-list text-blue-300 text-6xl opacity-50"></i>
            </div>
        </div>

    @elseif($isMuzakkiRegistered && !$isMuzakkiApproved)
        {{-- STATUS: MENUNGGU PERSETUJUAN --}}
        <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 border-l-4 border-yellow-600 rounded-xl p-8 shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-yellow-900 mb-2 flex items-center">
                        <i class="fas fa-hourglass-half text-yellow-600 mr-3"></i>Status: Menunggu Persetujuan Admin
                    </h2>
                    <p class="text-yellow-800 mb-1">Permintaan pendaftaran Muzakki Anda telah kami terima dengan status:</p>
                    <p class="text-yellow-900 font-bold mb-3">ID #{{ $muzakkiProfile->id_muzakki }} — <span class="bg-yellow-200 px-3 py-1 rounded-full">{{ ucfirst($muzakkiProfile->status_pendaftaran) }}</span></p>
                    <p class="text-yellow-800">Admin akan segera memverifikasi data Anda. Anda akan dapat bertransaksi ZIS setelah disetujui.</p>
                </div>
                <i class="fas fa-spinner text-yellow-300 text-6xl opacity-50 animate-spin"></i>
            </div>
        </div>

    @else
        {{-- STATUS: DISETUJUI - TAMPILKAN DASHBOARD --}}
        {{-- STAT CARDS & ACTION BUTTONS --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            {{-- Total Donasi --}}
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6 border-t-4 border-green-600">
                <div class="flex items-center justify-between h-full">
                    <div>
                        <p class="text-gray-600 text-sm font-semibold">Total Donasi ZIS</p>
                        <p class="text-2xl font-bold text-green-700 mt-2">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</p>
                    </div>
                    <i class="fas fa-heart text-4xl text-green-200"></i>
                </div>
            </div>
            
            {{-- Input ZIS Baru --}}
            <a href="{{ route('user.pembayaran.create') }}" class="group bg-white rounded-xl shadow-md hover:shadow-lg transition p-6 border-t-4 border-purple-600 flex flex-col justify-between h-full">
                <div>
                    <p class="text-gray-600 text-sm font-semibold">Aksi Cepat</p>
                    <p class="text-lg font-bold text-purple-700 mt-2 group-hover:text-purple-800 transition flex items-center">
                        <i class="fas fa-plus-circle mr-2"></i>Donasi
                    </p>
                </div>
                <i class="fas fa-arrow-right text-2xl text-purple-200 group-hover:text-purple-300 transition mt-4"></i>
            </a>

            {{-- Riwayat --}}
            <a href="{{ route('user.pembayaran.index') }}" class="group bg-white rounded-xl shadow-md hover:shadow-lg transition p-6 border-t-4 border-orange-600 flex flex-col justify-between h-full">
                <div>
                    <p class="text-gray-600 text-sm font-semibold">Riwayat</p>
                    <p class="text-lg font-bold text-orange-700 mt-2 group-hover:text-orange-800 transition flex items-center">
                        <i class="fas fa-history mr-2"></i>Lihat Semua
                    </p>
                </div>
                <i class="fas fa-arrow-right text-2xl text-orange-200 group-hover:text-orange-300 transition mt-4"></i>
            </a>

            {{-- Kalkulator --}}
            <a href="{{ route('user.kalkulator.index') }}" class="group bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl shadow-md hover:shadow-lg transition p-6 text-white flex flex-col justify-between h-full">
                <div>
                    <p class="text-indigo-100 text-sm font-semibold">Tools</p>
                    <p class="text-lg font-bold mt-2 group-hover:text-indigo-50 transition flex items-center">
                        <i class="fas fa-calculator mr-2"></i>Kalkulator
                    </p>
                </div>
                <i class="fas fa-arrow-right text-2xl text-indigo-200 group-hover:text-indigo-100 transition mt-4"></i>
            </a>
        </div>
        
        {{-- RIWAYAT TRANSAKSI TERBARU --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-list text-blue-600 mr-3"></i>Riwayat Donasi Terbaru
            </h3>
            
            @if($donasi->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b-2 border-gray-200">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Tanggal</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Jenis ZIS</th>
                                <th class="px-6 py-4 text-left text-sm font-bold text-gray-700">Kategori</th>
                                <th class="px-6 py-4 text-right text-sm font-bold text-gray-700">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($donasi->take(5) as $item)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <i class="fas fa-calendar text-gray-400 mr-2"></i>{{ \Carbon\Carbon::parse($item->tgl_masuk)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-800">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-800">
                                        @if($item->jenis_zis == 'zakat') Zakat
                                        @elseif($item->jenis_zis == 'infaq') Infak
                                        @elseif($item->jenis_zis == 'shadaqah') Sedekah
                                        @else {{ ucfirst($item->jenis_zis) }}
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $item->sub_jenis_zis ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <span class="text-green-600 font-bold">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6 text-center">
                    <a href="{{ route('user.pembayaran.index') }}" class="text-blue-600 font-semibold hover:text-blue-700 transition flex items-center justify-center">
                        Lihat Semua Riwayat
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <p class="text-gray-600 font-semibold mb-4">Anda belum memiliki riwayat donasi</p>
                    <a href="{{ route('user.pembayaran.create') }}" class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                        <i class="fas fa-plus mr-2"></i>Mulai Berdonasi Sekarang
                    </a>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection