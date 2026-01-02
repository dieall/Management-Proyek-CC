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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 min-h-screen overflow-x-hidden">
    <!-- Background Decorations -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob"></div>
        <div class="absolute top-1/2 right-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 left-1/2 w-96 h-96 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10 animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative z-10 min-h-screen flex flex-col items-center justify-center py-8 md:py-12 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </div>

    <!-- SweetAlert Success Handler -->
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Registrasi Berhasil! 🎉',
                    background: '#fff',
                    color: '#1f2937',
                    html: `
                        <div class="text-left">
                            <p class="mb-4 text-gray-700 font-medium">Pendaftaran Anda telah berhasil disimpan.</p>
                            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 border-l-4 border-yellow-400 p-4 rounded-lg shadow-md">
                                <p class="text-sm font-bold text-yellow-900 mb-2">
                                    <i class="fas fa-hourglass-end mr-2 text-yellow-600"></i>Status Verifikasi
                                </p>
                                <p class="text-sm text-yellow-800 leading-relaxed">
                                    Mohon menunggu konfirmasi dari <strong>Petugas ZIS</strong> sebelum dapat melakukan login. Proses verifikasi biasanya memakan waktu <strong>1-3 hari kerja</strong>.
                                </p>
                            </div>
                            <p class="text-xs text-gray-500 mt-4 italic">
                                <i class="fas fa-envelope mr-1"></i>Anda akan menerima notifikasi setelah dokumen Anda diverifikasi.
                            </p>
                        </div>
                    `,
                    confirmButtonColor: '#2563eb',
                    confirmButtonText: 'Kembali ke Login',
                    confirmButtonClass: 'px-6 py-2 rounded-lg font-semibold',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: (modal) => {
                        modal.classList.add('shadow-2xl');
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("login") }}';
                    }
                });
            });
        </script>
    @endif

    <!-- SweetAlert Error Handler -->
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan',
                    text: '{{ session("error") }}',
                    background: '#fff',
                    color: '#1f2937',
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'Tutup',
                    confirmButtonClass: 'px-6 py-2 rounded-lg font-semibold',
                    didOpen: (modal) => {
                        modal.classList.add('shadow-2xl');
                    }
                });
            });
        </script>
    @endif

    @stack('scripts')
</body>
</html>
