<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manajemen ZIS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar-link {
            @apply block px-4 py-3 rounded-lg hover:bg-blue-600 transition duration-200 border-l-4 border-transparent;
        }
        .sidebar-link.active {
            @apply bg-blue-600 border-l-blue-200;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        {{-- SIDEBAR --}}
        <aside class="w-64 bg-gradient-to-b from-blue-700 via-blue-800 to-blue-900 text-white shadow-xl fixed left-0 top-0 h-screen overflow-y-auto">
            
            {{-- Brand --}}
            <div class="p-6 border-b border-blue-600">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                        <i class="fas fa-hand-holding-heart text-blue-700 text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">ZIS Manager</h1>
                        <p class="text-xs text-blue-200">v1.0</p>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <nav class="mt-6 px-4 space-y-2">
                @auth
                    @if(Auth::user()->role === 'admin')
                        {{-- ADMIN NAVIGATION --}}
                        <a href="{{ route('admin.dashboard') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-chart-line mr-3 text-blue-200"></i>
                            <span class="font-semibold">Dashboard</span>
                        </a>
                        
                        <div class="pt-2 pb-2">
                            <p class="text-xs font-bold text-blue-200 uppercase px-4 mb-2">Manajemen</p>
                        </div>
                        
                        <a href="{{ route('admin.zis.masuk.index') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.zis.masuk.*') ? 'active' : '' }}">
                            <i class="fas fa-money-bill mr-3 text-green-300"></i>
                            <span class="font-semibold">ZIS Masuk</span>
                        </a>
                        
                        <a href="{{ route('admin.penyaluran.index') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.penyaluran.*') ? 'active' : '' }}">
                            <i class="fas fa-hand-holding mr-3 text-orange-300"></i>
                            <span class="font-semibold">Penyaluran</span>
                        </a>
                        
                        <a href="{{ route('admin.muzakki.index') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.muzakki.*') ? 'active' : '' }}">
                            <i class="fas fa-users mr-3 text-purple-300"></i>
                            <span class="font-semibold">Muzakki</span>
                        </a>
                        
                        <a href="{{ route('admin.mustahik.index') }}" 
                           class="sidebar-link {{ request()->routeIs('admin.mustahik.*') ? 'active' : '' }}">
                            <i class="fas fa-user-friends mr-3 text-pink-300"></i>
                            <span class="font-semibold">Mustahik</span>
                        </a>

                    @elseif(Auth::user()->role === 'jemaah')
                        {{-- USER NAVIGATION --}}
                        <a href="{{ route('user.dashboard') }}" 
                           class="sidebar-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-home mr-3 text-blue-200"></i>
                            <span class="font-semibold">Beranda</span>
                        </a>
                        
                        <div class="pt-2 pb-2">
                            <p class="text-xs font-bold text-blue-200 uppercase px-4 mb-2">Fitur</p>
                        </div>
                        
                        <a href="{{ route('user.kalkulator.index') }}" 
                           class="sidebar-link {{ request()->routeIs('user.kalkulator.*') ? 'active' : '' }}">
                            <i class="fas fa-calculator mr-3 text-yellow-300"></i>
                            <span class="font-semibold">Kalkulator Zakat</span>
                        </a>
                        
                        <a href="{{ route('user.pembayaran.create') }}" 
                           class="sidebar-link {{ request()->routeIs('user.pembayaran.create') ? 'active' : '' }}">
                            <i class="fas fa-hand-holding-dollar mr-3 text-green-300"></i>
                            <span class="font-semibold">Input Pembayaran</span>
                        </a>
                        
                        <a href="{{ route('user.pembayaran.index') }}" 
                           class="sidebar-link {{ request()->routeIs('user.pembayaran.index') ? 'active' : '' }}">
                            <i class="fas fa-history mr-3 text-blue-300"></i>
                            <span class="font-semibold">Riwayat</span>
                        </a>
                    @endif
                @endauth
            </nav>

            {{-- Divider --}}
            <div class="border-t border-blue-600 my-6"></div>

            {{-- User Info --}}
            @auth
            <div class="px-4 pb-4">
                <div class="bg-blue-600 rounded-lg p-4">
                    <p class="text-xs text-blue-200 mb-1">Pengguna</p>
                    <p class="text-sm font-bold text-white truncate">{{ Auth::user()->nama_lengkap ?? Auth::user()->name }}</p>
                    <p class="text-xs text-blue-200 mt-2">
                        <span class="inline-block bg-blue-500 px-2 py-1 rounded text-xs">
                            {{ Auth::user()->role === 'admin' ? 'Admin/Petugas' : 'Jemaah' }}
                        </span>
                    </p>
                </div>
            </div>
            @endauth

        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 ml-64">
            
            {{-- TOP NAVIGATION --}}
            <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-10">
                <div class="px-8 py-4 flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-gray-800">@yield('page_title', 'Dashboard')</h2>
                    <div class="flex items-center gap-4">
                        @auth
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="fas fa-circle text-green-500"></i>
                                <span>Online</span>
                            </div>
                            <div class="w-1 h-6 bg-gray-300"></div>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold flex items-center gap-1 transition">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        @endauth
                    </div>
                </div>
            </nav>

            {{-- CONTENT AREA --}}
            <div class="p-8">
                
                {{-- ALERT MESSAGES --}}
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-r-lg p-6">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-exclamation-circle text-red-600 text-xl mt-1"></i>
                            <div>
                                <h3 class="text-red-800 font-bold mb-2">Validasi Gagal</h3>
                                <ul class="text-red-700 text-sm space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li class="flex items-center gap-2">
                                            <span class="inline-block w-1.5 h-1.5 bg-red-600 rounded-full"></span>
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-6 bg-green-50 border-l-4 border-green-500 rounded-r-lg p-6 flex items-center gap-3">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        <p class="text-green-700 font-semibold">{{ session('success') }}</p>
                    </div>
                @endif

                {{-- PAGE CONTENT --}}
                @yield('content')
            </div>

        </main>
    </div>

    @stack('scripts')
</body>
</html>