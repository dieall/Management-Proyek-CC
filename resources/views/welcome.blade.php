<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen ZIS - Zakat, Infak, Sedekah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-b from-blue-50 to-indigo-100">
    {{-- NAVBAR --}}
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <i class="fas fa-hand-holding-heart text-blue-600 text-2xl mr-3"></i>
                    <span class="font-bold text-xl text-gray-800">Manajemen ZIS</span>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition font-medium">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-medium transition">
                            <i class="fas fa-sign-in-alt mr-1"></i>Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-12">
        <div class="text-center max-w-4xl mb-12">
            {{-- HERO SECTION --}}
            <div class="mb-12">
                <h1 class="text-6xl font-bold text-blue-600 mb-4">
                    <i class="fas fa-hand-holding-heart mr-3"></i>Manajemen ZIS
                </h1>
                <p class="text-2xl text-gray-700 mb-3 font-semibold">Sistem Manajemen Zakat, Infak, dan Sedekah</p>
                <p class="text-lg text-gray-600">Platform profesional untuk mengelola ZIS dengan terukur, transparan, dan efisien</p>
            </div>

            {{-- FEATURE CARDS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
                <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition transform hover:-translate-y-1">
                    <i class="fas fa-users text-blue-600 text-4xl mb-4"></i>
                    <h3 class="font-semibold text-lg text-gray-800 mb-3">Manajemen Muzakki</h3>
                    <p class="text-gray-600">Kelola data pembayar zakat dengan sistem yang terorganisir dan mudah diakses</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition transform hover:-translate-y-1">
                    <i class="fas fa-people-roof text-green-600 text-4xl mb-4"></i>
                    <h3 class="font-semibold text-lg text-gray-800 mb-3">Manajemen Mustahik</h3>
                    <p class="text-gray-600">Kelola daftar penerima zakat secara terstruktur dengan kategori yang jelas</p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-8 hover:shadow-xl transition transform hover:-translate-y-1">
                    <i class="fas fa-chart-line text-orange-600 text-4xl mb-4"></i>
                    <h3 class="font-semibold text-lg text-gray-800 mb-3">Laporan & Analitik</h3>
                    <p class="text-gray-600">Lihat laporan lengkap ZIS masuk, penyaluran, dan sisa dana secara real-time</p>
                </div>
            </div>

            {{-- CTA BUTTONS --}}
            @guest
            <div class="bg-white rounded-xl shadow-2xl p-12 max-w-2xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-800 mb-8">Mulai Sekarang</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    {{-- Login Button --}}
                    <a href="{{ route('login') }}" class="group bg-gradient-to-br from-blue-600 to-blue-700 text-white px-8 py-4 rounded-lg hover:shadow-xl transition transform hover:-translate-y-1 font-semibold text-lg">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-sign-in-alt text-3xl mb-3 group-hover:scale-110 transition"></i>
                            <span>Login</span>
                        </div>
                        <p class="text-xs mt-2 text-blue-100">Masuk ke akun Anda</p>
                    </a>

                    {{-- Daftar Jemaah Button --}}
                    <a href="{{ route('register') }}" class="group bg-gradient-to-br from-purple-600 to-purple-700 text-white px-8 py-4 rounded-lg hover:shadow-xl transition transform hover:-translate-y-1 font-semibold text-lg">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-user-plus text-3xl mb-3 group-hover:scale-110 transition"></i>
                            <span>Daftar Jemaah</span>
                        </div>
                        <p class="text-xs mt-2 text-purple-100">Sebagai Pembayar Zakat</p>
                    </a>

                    {{-- Daftar Mustahik Button --}}
                    <a href="{{ route('mustahik.register') }}" class="group bg-gradient-to-br from-green-600 to-green-700 text-white px-8 py-4 rounded-lg hover:shadow-xl transition transform hover:-translate-y-1 font-semibold text-lg">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-hand-holding text-3xl mb-3 group-hover:scale-110 transition"></i>
                            <span>Daftar Mustahik</span>
                        </div>
                        <p class="text-xs mt-2 text-green-100">Sebagai Penerima Zakat</p>
                    </a>
                </div>

                <p class="text-gray-600 text-sm">
                    Pilih opsi di atas untuk memulai. Jika Anda sudah memiliki akun, silakan <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">login</a>
                </p>
            </div>
            @else
            <div class="bg-white rounded-xl shadow-2xl p-12 max-w-2xl mx-auto">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Selamat Datang</h2>
                <p class="text-gray-600 mb-8">Akses dashboard Anda untuk mengelola ZIS</p>
                <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-8 py-4 rounded-lg hover:bg-blue-700 transition font-semibold text-lg inline-block">
                    <i class="fas fa-tachometer-alt mr-2"></i>Buka Dashboard
                </a>
            </div>
            @endguest
        </div>

        {{-- INFO FOOTER --}}
        <div class="mt-16 max-w-2xl bg-blue-50 border-l-4 border-blue-600 rounded-lg p-6 text-left">
            <h3 class="font-semibold text-gray-800 mb-3 text-lg">
                <i class="fas fa-info-circle text-blue-600 mr-2"></i>Informasi Login Admin
            </h3>
            <p class="text-gray-700 mb-2">Untuk mengakses dashboard admin, gunakan kredensial berikut:</p>
            <div class="bg-white p-4 rounded border border-blue-200">
                <p class="text-sm text-gray-600"><strong>Username:</strong> <code class="bg-gray-100 px-2 py-1 rounded text-blue-600 font-mono">admin_zis</code></p>
                <p class="text-sm text-gray-600"><strong>Password:</strong> <code class="bg-gray-100 px-2 py-1 rounded text-blue-600 font-mono">password</code></p>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="mb-2"><i class="fas fa-hand-holding-heart text-blue-400 mr-2"></i><span class="font-semibold">Manajemen ZIS</span></p>
                <p class="text-gray-400 text-sm">© 2025 Sistem Manajemen Zakat, Infak, dan Sedekah. Semua hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>
</body>
</html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />



        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
