<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Sistem Masjid</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-pattern {
            background-color: #ffffff;
            background-image: radial-gradient(#3b82f6 0.5px, transparent 0.5px), radial-gradient(#3b82f6 0.5px, #ffffff 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            opacity: 0.1;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased selection:bg-blue-100 selection:text-blue-600">

    <nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-blue-200">M</div>
                    <span class="font-bold text-xl tracking-tight text-gray-900">MasjidApp</span>
                </div>

                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-gray-600 hover:text-blue-600 transition-colors">Dashboard</a>
                            <div class="h-6 w-px bg-gray-200"></div>
                            <span class="text-sm font-medium text-gray-500">Hai, {{ Auth::user()->username }}</span>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-bold text-gray-600 hover:text-blue-600 transition-colors">Masuk</a>
                            <a href="{{ url('/register') }}" class="px-5 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-full hover:bg-black transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">Daftar</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute inset-0 hero-pattern z-0"></div>
        
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-extrabold text-gray-900 tracking-tight mb-6">
                Kelola Ibadah & <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-cyan-500">Kegiatan Umat</span>
            </h1>
            <p class="mt-4 text-xl text-gray-500 max-w-2xl mx-auto mb-10">
                Platform digital terintegrasi untuk manajemen kegiatan masjid, riwayat donasi, dan profil jamaah yang transparan dan mudah.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-5xl mx-auto mt-16 px-4">
                
                <a href="{{ Auth::check() ? url('/dashboard') : route('login') }}" class="group relative bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:shadow-blue-200/50 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-3xl flex items-center justify-center mb-6 text-3xl group-hover:scale-110 transition-transform duration-300">
                        👤
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Profil Saya</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Kelola data diri, status keanggotaan, dan preferensi akun Anda.
                    </p>
                    <div class="mt-6 flex items-center text-blue-600 font-bold text-sm">
                        <span>Akses Profil</span>
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </div>
                </a>

                <a href="{{ Auth::check() ? url('/riwayat/donasi') : route('login') }}" class="group relative bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:shadow-emerald-200/50 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-3xl flex items-center justify-center mb-6 text-3xl group-hover:scale-110 transition-transform duration-300">
                        🎁
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Riwayat Donasi</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Lihat catatan amal jariyah dan sedekah yang telah Anda salurkan.
                    </p>
                    <div class="mt-6 flex items-center text-emerald-600 font-bold text-sm">
                        <span>Lihat Riwayat</span>
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </div>
                </a>

                <a href="{{ Auth::check() ? url('/riwayat/kegiatan') : route('login') }}" class="group relative bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-xl shadow-gray-200/50 hover:shadow-2xl hover:shadow-purple-200/50 transition-all duration-300 hover:-translate-y-2">
                    <div class="w-16 h-16 bg-purple-50 text-purple-600 rounded-3xl flex items-center justify-center mb-6 text-3xl group-hover:scale-110 transition-transform duration-300">
                        📅
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Kegiatan</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Jadwal kajian, gotong royong, dan acara masjid yang Anda ikuti.
                    </p>
                    <div class="mt-6 flex items-center text-purple-600 font-bold text-sm">
                        <span>Cek Jadwal</span>
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </div>
                </a>

            </div>
        </div>
    </div>

    <footer class="bg-white border-t border-gray-100 py-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-400 font-medium text-sm">© 2025 Sistem Informasi Masjid. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>