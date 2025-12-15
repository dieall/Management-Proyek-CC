<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Masjid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50">
    <div x-data="{ sidebarOpen: false, sidebarMinimized: false }" class="flex h-screen overflow-hidden">

        <aside 
            :class="(sidebarOpen ? 'translate-x-0' : '-translate-x-full') + ' ' + (sidebarMinimized ? 'md:w-20' : 'md:w-64')"
            class="fixed inset-y-0 left-0 z-50 bg-white border-r border-gray-200 transition-all duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col justify-between w-64"
        >
            
            <div class="flex-1 overflow-y-auto overflow-x-hidden">
                
                <div class="flex items-center h-16 border-b border-gray-100 px-4 transition-all" 
                     :class="sidebarMinimized ? 'justify-center' : 'justify-start gap-3'">
                    
                    <button @click="sidebarMinimized = !sidebarMinimized" class="hidden md:flex items-center justify-center w-8 h-8 rounded-lg text-gray-500 hover:text-blue-600 hover:bg-blue-50 transition-colors focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                    
                    <h1 x-show="!sidebarMinimized" class="text-xl font-bold text-gray-800 transition-opacity duration-300 whitespace-nowrap">
                        LOGO
                    </h1>

                    <button @click="sidebarOpen = false" class="md:hidden ml-auto text-gray-500 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <nav class="mt-5 px-3 space-y-2">

                    {{-- LOGIKA MENU ADMIN --}}
                    @if(request()->routeIs('dashboard') || request()->routeIs('jamaah.*') || request()->routeIs('donasi.*') || request()->routeIs('kegiatan.*') || request()->routeIs('kategori.*'))
                        
                        <div x-show="!sidebarMinimized" class="mb-2 px-2 text-xs font-bold text-gray-400 uppercase tracking-wider whitespace-nowrap transition-all delay-100">Menu Admin</div>
                        <div x-show="sidebarMinimized" class="mb-2 flex justify-center"><div class="w-4 h-0.5 bg-gray-200 rounded"></div></div>

                        <a href="{{ route('dashboard') }}" 
                           class="flex items-center px-3 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
                           :class="sidebarMinimized ? 'justify-center' : ''">
                            <span class="text-xl">📊</span>
                            <span x-show="!sidebarMinimized" class="ml-3 font-medium whitespace-nowrap transition-opacity duration-200">Dashboard</span>
                            <div x-show="sidebarMinimized" class="absolute left-16 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-50 ml-2" x-cloak>Dashboard</div>
                        </a>

                        <a href="{{ route('jamaah.index') }}" 
                           class="flex items-center px-3 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('jamaah.*') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
                           :class="sidebarMinimized ? 'justify-center' : ''">
                            <span class="text-xl">👥</span>
                            <span x-show="!sidebarMinimized" class="ml-3 font-medium whitespace-nowrap transition-opacity duration-200">Kelola Jamaah</span>
                            <div x-show="sidebarMinimized" class="absolute left-16 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-50 ml-2" x-cloak>Jamaah</div>
                        </a>

                        <a href="{{ route('donasi.index') }}" 
                           class="flex items-center px-3 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('donasi.*') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
                           :class="sidebarMinimized ? 'justify-center' : ''">
                            <span class="text-xl">💰</span>
                            <span x-show="!sidebarMinimized" class="ml-3 font-medium whitespace-nowrap transition-opacity duration-200">Kelola Donasi</span>
                            <div x-show="sidebarMinimized" class="absolute left-16 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-50 ml-2" x-cloak>Donasi</div>
                        </a>

                        <a href="{{ route('kegiatan.index') }}" 
                           class="flex items-center px-3 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('kegiatan.*') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}"
                           :class="sidebarMinimized ? 'justify-center' : ''">
                            <span class="text-xl">📅</span>
                            <span x-show="!sidebarMinimized" class="ml-3 font-medium whitespace-nowrap transition-opacity duration-200">Kelola Acara</span>
                            <div x-show="sidebarMinimized" class="absolute left-16 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-50 ml-2" x-cloak>Acara</div>
                        </a>

                        <div class="mt-8 border-t border-gray-100 pt-4">
                            <a href="{{ route('home') }}" class="flex items-center px-3 py-2 text-sm text-blue-600 hover:text-blue-800 font-bold group" :class="sidebarMinimized ? 'justify-center' : ''">
                                <span class="text-lg">&larr;</span>
                                <span x-show="!sidebarMinimized" class="ml-3">Kembali ke Beranda</span>
                                <div x-show="sidebarMinimized" class="absolute left-16 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-50 ml-2" x-cloak>Beranda</div>
                            </a>
                        </div>

                    {{-- LOGIKA MENU JAMAAH --}}
                    @else

                        <div x-show="!sidebarMinimized" class="mb-2 px-2 text-xs font-bold text-gray-400 uppercase tracking-wider whitespace-nowrap">Menu Jamaah</div>
                        <div x-show="sidebarMinimized" class="mb-2 flex justify-center"><div class="w-4 h-0.5 bg-gray-200 rounded"></div></div>

                        <a href="{{ route('home') }}" class="flex items-center px-3 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}" :class="sidebarMinimized ? 'justify-center' : ''">
                            <span class="text-xl">🏠</span>
                            <span x-show="!sidebarMinimized" class="ml-3 font-medium whitespace-nowrap">Beranda</span>
                            <div x-show="sidebarMinimized" class="absolute left-16 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-50 ml-2" x-cloak>Beranda</div>
                        </a>
                        
                        <a href="{{ route('user.donasi') }}" class="flex items-center px-3 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('user.donasi') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}" :class="sidebarMinimized ? 'justify-center' : ''">
                            <span class="text-xl">🎁</span>
                            <span x-show="!sidebarMinimized" class="ml-3 font-medium whitespace-nowrap">Riwayat Donasi</span>
                            <div x-show="sidebarMinimized" class="absolute left-16 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-50 ml-2" x-cloak>Donasi</div>
                        </a>
                        
                        <a href="{{ route('user.kegiatan') }}" class="flex items-center px-3 py-3 rounded-lg transition-all duration-200 group {{ request()->routeIs('user.kegiatan') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}" :class="sidebarMinimized ? 'justify-center' : ''">
                            <span class="text-xl">📅</span>
                            <span x-show="!sidebarMinimized" class="ml-3 font-medium whitespace-nowrap">Riwayat Kegiatan</span>
                            <div x-show="sidebarMinimized" class="absolute left-16 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-50 ml-2" x-cloak>Kegiatan</div>
                        </a>

                        @if(Auth::user()->isAdmin())
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <p x-show="!sidebarMinimized" class="px-4 text-xs text-gray-400 mb-2 whitespace-nowrap">Akses Pengurus</p>
                                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-3 bg-gray-900 text-white rounded-xl shadow-lg hover:bg-black transition-all group" :class="sidebarMinimized ? 'justify-center' : ''">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    <span x-show="!sidebarMinimized" class="ml-3 font-bold text-sm whitespace-nowrap">Dashboard</span>
                                    <div x-show="sidebarMinimized" class="absolute left-16 bg-gray-900 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-50 ml-2" x-cloak>Admin</div>
                                </a>
                            </div>
                        @endif

                    @endif
                </nav>
            </div>

            <div class="p-4 border-t border-gray-100 bg-white">
                <a href="/logout" class="flex items-center w-full px-3 py-2 text-sm font-bold text-red-600 bg-red-50 rounded-lg hover:bg-red-100 hover:text-red-700 transition-colors group" :class="sidebarMinimized ? 'justify-center' : 'justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span x-show="!sidebarMinimized" class="ml-2 whitespace-nowrap">Keluar Aplikasi</span>
                    <div x-show="sidebarMinimized" class="absolute left-16 bg-red-600 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-50 ml-2" x-cloak>Keluar</div>
                </a>
            </div>

        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            
            <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200 shadow-sm z-10">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none md:hidden">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <h2 class="text-2xl font-bold text-gray-800 ml-4 md:ml-0">@yield('header_title')</h2>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('user.profile') }}" class="flex items-center gap-4 hover:bg-gray-50 p-2 pr-4 rounded-full border border-transparent hover:border-gray-200 transition-all group">
                        
                        <div class="hidden md:block text-right">
                            <p class="text-base font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ Auth::user()->username }}</p>
                            <p class="text-xs text-gray-500 font-bold truncate max-w-[180px] mt-0.5">{{ Auth::user()->nama_lengkap }}</p>
                        </div>

                        <div class="w-11 h-11 rounded-full bg-blue-600 text-white flex items-center justify-center text-lg font-bold shadow-md ring-2 ring-white group-hover:ring-blue-200 transition-all">
                            {{ substr(Auth::user()->nama_lengkap, 0, 1) }}
                        </div>
                    </a>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>