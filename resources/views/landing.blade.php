<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Masjid Al-Ikhlas - Sistem Manajemen Masjid</title>

    <!-- Custom fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    
    <!-- Custom styles -->
    <link href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.4/css/sb-admin-2.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
        }
        .hero-section h1 {
            font-size: 3rem;
            font-weight: 700;
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
        }
        .prayer-time-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
        }
        .prayer-time-card.today {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
    </style>
</head>

<body id="page-top">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-gradient-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-mosque"></i> Masjid Al-Ikhlas
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#artikel">Artikel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#jadwal">Jadwal Sholat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light btn-sm text-primary ml-2" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <div class="mb-4">
                <i class="fas fa-mosque fa-4x mb-3"></i>
            </div>
            <h1 class="mb-3">Selamat Datang di</h1>
            <h2 class="mb-4">Sistem Manajemen Masjid Al-Ikhlas</h2>
            <p class="lead mb-4">Platform terpadu untuk mengelola kegiatan, informasi, dan program masjid</p>
            <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                <i class="fas fa-sign-in-alt"></i> Masuk ke Sistem
            </a>
        </div>
    </section>

    <!-- Artikel & Pengumuman Section -->
    <section id="artikel" class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="text-primary"><i class="fas fa-newspaper"></i> Artikel & Pengumuman</h2>
                <p class="text-muted">Informasi terbaru dari Masjid Al-Ikhlas</p>
            </div>
            
            @if($articles->count() > 0)
            <div class="row">
                @foreach($articles as $article)
                <div class="col-md-4 mb-4">
                    <div class="card shadow card-hover h-100">
                        @if($article->image_url)
                        <img src="{{ $article->image_url }}" class="card-img-top" alt="{{ $article->title }}" style="height: 200px; object-fit: cover;">
                        @else
                        <div class="card-img-top bg-gradient-primary d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="fas fa-newspaper fa-3x text-white"></i>
                        </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $article->title }}</h5>
                            <p class="card-text">{{ Str::limit($article->description, 100) }}</p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <small class="text-muted">
                                <i class="fas fa-calendar"></i> {{ $article->created_at->format('d M Y') }}
                            </small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> Belum ada artikel atau pengumuman
            </div>
            @endif
        </div>
    </section>

    <!-- Jadwal Sholat Section -->
    <section id="jadwal" class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="text-primary"><i class="fas fa-pray"></i> Jadwal Sholat</h2>
                <p class="text-muted">Jadwal sholat untuk hari ini dan seminggu ke depan</p>
            </div>

            <!-- Jadwal Hari Ini -->
            <div class="card shadow mb-4">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-day"></i> Jadwal Sholat Hari Ini 
                        <span class="badge badge-light text-primary">{{ $todayIndonesian ?? ucfirst($today) }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($schedules as $schedule)
                        <div class="col-md-2 col-6 mb-3">
                            <div class="prayer-time-card">
                                <strong>{{ $schedule->prayer_name }}</strong><br>
                                <h4 class="m-0 mt-2">{{ $schedule->getTimeForDay($today) ?? '-' }}</h4>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Jadwal Lengkap Seminggu -->
            <div class="card shadow">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-calendar-week"></i> Jadwal Lengkap Seminggu</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Waktu Sholat</th>
                                    <th>Senin</th>
                                    <th>Selasa</th>
                                    <th>Rabu</th>
                                    <th>Kamis</th>
                                    <th>Jumat</th>
                                    <th>Sabtu</th>
                                    <th>Minggu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schedules as $schedule)
                                <tr>
                                    <td><strong>{{ $schedule->prayer_name }}</strong></td>
                                    <td class="{{ $today == 'monday' ? 'bg-light font-weight-bold' : '' }}">{{ $schedule->monday }}</td>
                                    <td class="{{ $today == 'tuesday' ? 'bg-light font-weight-bold' : '' }}">{{ $schedule->tuesday }}</td>
                                    <td class="{{ $today == 'wednesday' ? 'bg-light font-weight-bold' : '' }}">{{ $schedule->wednesday }}</td>
                                    <td class="{{ $today == 'thursday' ? 'bg-light font-weight-bold' : '' }}">{{ $schedule->thursday }}</td>
                                    <td class="{{ $today == 'friday' ? 'bg-light font-weight-bold' : '' }}">{{ $schedule->friday }}</td>
                                    <td class="{{ $today == 'saturday' ? 'bg-light font-weight-bold' : '' }}">{{ $schedule->saturday }}</td>
                                    <td class="{{ $today == 'sunday' ? 'bg-light font-weight-bold' : '' }}">{{ $schedule->sunday }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Belum ada jadwal sholat</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-primary text-white py-4">
        <div class="container text-center">
            <p class="mb-0">
                <i class="fas fa-mosque"></i> Masjid Al-Ikhlas - Sistem Manajemen Masjid
            </p>
            <p class="mb-0 mt-2">
                <a href="{{ route('login') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-sign-in-alt"></i> Login ke Sistem
                </a>
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Smooth Scroll -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>

