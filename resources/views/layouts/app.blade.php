<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manajemen ZIS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-gradient-to-b from-blue-700 to-blue-800 text-white shadow-lg">
            <div class="p-6">
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i class="fas fa-hand-holding-heart"></i>
                    ZIS Management
                </h1>
            </div>
            
            <nav class="mt-8 px-4 space-y-2">
                @auth
                    @if(Auth::user()->role === 'admin')
                        {{-- NAVIGASI ADMIN (Petugas ZIS) --}}
                        <a href="{{ route('admin.dashboard') }}" 
                           class="block px-4 py-2 rounded hover:bg-blue-600 transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600' : '' }}">
                            <i class="fas fa-chart-line mr-2"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.zis.masuk.index') }}" 
                           class="block px-4 py-2 rounded hover:bg-blue-600 transition {{ request()->routeIs('admin.zis.masuk.*') ? 'bg-blue-600' : '' }}">
                            <i class="fas fa-money-bill mr-2"></i> ZIS Masuk
                        </a>
                        <a href="{{ route('admin.penyaluran.index') }}" 
                           class="block px-4 py-2 rounded hover:bg-blue-600 transition {{ request()->routeIs('admin.penyaluran.*') ? 'bg-blue-600' : '' }}">
                            <i class="fas fa-hand-holding mr-2"></i> Penyaluran
                        </a>
                        <a href="{{ route('admin.muzakki.index') }}" 
                           class="block px-4 py-2 rounded hover:bg-blue-600 transition {{ request()->routeIs('admin.muzakki.*') ? 'bg-blue-600' : '' }}">
                            <i class="fas fa-users mr-2"></i> Muzakki
                        </a>
                        <a href="{{ route('admin.mustahik.index') }}" 
                           class="block px-4 py-2 rounded hover:bg-blue-600 transition {{ request()->routeIs('admin.mustahik.*') ? 'bg-blue-600' : '' }}">
                            <i class="fas fa-people-roof mr-2"></i> Mustahik
                        </a>

                    @elseif(Auth::user()->role === 'jemaah')
                        {{-- NAVIGASI USER (Muzakki) --}}
                        <a href="{{ route('user.dashboard') }}" 
                           class="block px-4 py-2 rounded hover:bg-blue-600 transition {{ request()->routeIs('user.dashboard') ? 'bg-blue-600' : '' }}">
                            <i class="fas fa-chart-line mr-2"></i> Dashboard Saya
                        </a>
                        
                        {{-- START: PENAMBAHAN NAVIGASI KALKULATOR ZAKAT --}}
                        <a href="{{ route('user.kalkulator.index') }}" 
                           class="block px-4 py-2 rounded hover:bg-blue-600 transition {{ request()->routeIs('user.kalkulator.*') ? 'bg-blue-600' : '' }}">
                            <i class="fas fa-calculator mr-2"></i> Kalkulator Zakat
                        </a>
                        {{-- END: PENAMBAHAN NAVIGASI KALKULATOR ZAKAT --}}
                        
                        <a href="{{ route('user.pembayaran.create') }}" 
                           class="block px-4 py-2 rounded hover:bg-blue-600 transition {{ request()->routeIs('user.pembayaran.create') ? 'bg-blue-600' : '' }}">
                            <i class="fas fa-hand-holding-dollar mr-2"></i> Input Pembayaran ZIS
                        </a>
                        
                        <a href="{{ route('user.pembayaran.index') }}" 
                           class="block px-4 py-2 rounded hover:bg-blue-600 transition {{ request()->routeIs('user.pembayaran.index') ? 'bg-blue-600' : '' }}">
                            <i class="fas fa-clock-rotate-left mr-2"></i> Riwayat Pembayaran
                        </a>
                    @endif
                @endauth
            </nav>
        </aside>

        <main class="flex-1">
            <nav class="bg-white shadow-sm border-b border-gray-200">
                <div class="px-6 py-4 flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800">@yield('page_title', 'Dashboard')</h2>
                    <div class="flex items-center gap-4">
                        @auth
                            <span class="text-sm text-gray-600">
                                <i class="fas fa-user-circle mr-1"></i>
                                {{ Auth::user()->nama_lengkap }}
                            </span>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </nav>

            <div class="p-6">
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 rounded p-4">
                        <h3 class="text-red-800 font-semibold mb-2">Validation Errors</h3>
                        <ul class="text-red-700 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 rounded p-4 text-green-700">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    {{-- Script stack untuk JavaScript (penting untuk Kalkulator dinamis) --}}
    @stack('scripts') 
</body>
</html>