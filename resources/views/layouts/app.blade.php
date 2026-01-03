<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Zakat, Infaq & Shadaqah">
    <meta name="theme-color" content="#2563eb">
    <title>@yield('title', 'Manajemen ZIS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Mobile menu toggle */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }
        .sidebar.hidden {
            transform: translateX(-100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen flex-col md:flex-row">
        <!-- Mobile Menu Toggle Button -->
        <button id="menu-toggle" class="md:hidden fixed top-4 left-4 z-50 bg-blue-700 text-white p-3 rounded-lg shadow-lg">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <!-- Sidebar (dengan responsive behavior) -->
        <aside id="sidebar" class="sidebar fixed inset-y-0 left-0 z-40 w-64 bg-gradient-to-b from-blue-700 to-blue-800 text-white shadow-lg md:relative md:translate-x-0 md:flex md:flex-col">
            <div class="p-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold flex items-center gap-2">
                    <i class="fas fa-hand-holding-heart"></i>
                    <span class="hidden sm:inline">ZIS Management</span>
                </h1>
                <button id="close-menu" class="md:hidden text-white text-2xl">
                    <i class="fas fa-times"></i>
                </button>
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

        <main class="flex-1 w-full md:ml-0 mt-16 md:mt-0">
            <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30">
                <div class="px-4 md:px-6 py-3 md:py-4 flex flex-col md:flex-row md:justify-between md:items-center gap-2">
                    <h2 class="text-lg md:text-xl font-semibold text-gray-800">@yield('page_title', 'Dashboard')</h2>
                    <div class="flex items-center gap-2 md:gap-4 flex-wrap">
                        @auth
                            <span class="text-xs md:text-sm text-gray-600 truncate">
                                <i class="fas fa-user-circle mr-1"></i>
                                <span class="hidden sm:inline">{{ Auth::user()->nama_lengkap }}</span>
                            </span>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-xs md:text-sm text-red-600 hover:text-red-800 px-2 md:px-0">
                                    <i class="fas fa-sign-out-alt mr-1"></i> <span class="hidden sm:inline">Logout</span>
                                </button>
                            </form>
                        @elseif(session('mustahik_id'))
                            <span class="text-sm md:text-base font-semibold flex items-center space-x-3">
                                <i class="fas fa-user-circle mr-1"></i>
                                <span class="hidden sm:inline">{{ session('mustahik_nama') }}</span>
                            </span>
                            <form action="{{ route('mustahik.logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-xs md:text-sm text-red-600 hover:text-red-800 px-2 md:px-0">
                                    <i class="fas fa-sign-out-alt mr-1"></i> <span class="hidden sm:inline">Logout</span>
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </nav>

            <div class="p-4 md:p-6">
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 rounded p-3 md:p-4">
                        <h3 class="text-red-800 font-semibold mb-2 text-sm md:text-base">Validation Errors</h3>
                        <ul class="text-red-700 text-xs md:text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 rounded p-3 md:p-4 text-green-700 text-sm md:text-base">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Mobile Overlay -->
    <div id="mobile-overlay" class="fixed inset-0 bg-black opacity-50 z-30 hidden md:hidden"></div>

    <!-- Mobile Menu Scripts -->
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const closeMenu = document.getElementById('close-menu');
        const mobileOverlay = document.getElementById('mobile-overlay');

        // Open menu
        menuToggle.addEventListener('click', () => {
            sidebar.classList.remove('hidden');
            mobileOverlay.classList.remove('hidden');
        });

        // Close menu
        const closeMenuHandler = () => {
            sidebar.classList.add('hidden');
            mobileOverlay.classList.add('hidden');
        };

        closeMenu.addEventListener('click', closeMenuHandler);
        mobileOverlay.addEventListener('click', closeMenuHandler);

        // Close menu when a link is clicked
        const navLinks = sidebar.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', closeMenuHandler);
        });
    </script>

    {{-- Script stack untuk JavaScript (penting untuk Kalkulator dinamis) --}}
    @stack('scripts') 
</body>
</html>