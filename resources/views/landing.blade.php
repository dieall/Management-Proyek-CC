<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Masjid Al-Ikhlas - Sistem Manajemen Masjid</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #7c3aed;
            --accent-color: #ec4899;
            --dark-color: #1e293b;
            --light-color: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }

        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            padding: 1rem 0;
        }

        .navbar.scrolled {
            padding: 0.5rem 0;
            box-shadow: 0 4px 30px rgba(0,0,0,0.15);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
        }

        .nav-link {
            font-weight: 500;
            color: var(--dark-color) !important;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            transform: translateY(-2px);
        }

        .navbar-toggler {
            border: none;
            padding: 0.25rem 0.5rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(79, 70, 229, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            background-size: 200% 200%;
            animation: gradientShift 15s ease infinite;
            color: white;
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="100" height="100" patternUnits="userSpaceOnUse"><path d="M 100 0 L 0 0 0 100" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-icon {
            font-size: 5rem;
            margin-bottom: 2rem;
            animation: float 3s ease-in-out infinite;
            filter: drop-shadow(0 10px 30px rgba(0,0,0,0.3));
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 10px rgba(0,0,0,0.2);
        }

        .hero-subtitle {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .hero-description {
            font-size: 1.1rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-hero {
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 50px;
            background: white;
            color: var(--primary-color);
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-hero::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: var(--primary-color);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-hero:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-hero:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.4);
        }

        .btn-hero span {
            position: relative;
            z-index: 1;
        }

        /* Section Styles */
        .section {
            padding: 80px 0;
            position: relative;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 1rem;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
        }

        .section-subtitle {
            color: #64748b;
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }

        /* Article Cards */
        .article-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            border: none;
            position: relative;
        }

        .article-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .article-card:hover::before {
            transform: scaleX(1);
        }

        .article-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .article-image {
            height: 250px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .article-card:hover .article-image {
            transform: scale(1.1);
        }

        .article-image-placeholder {
            height: 250px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .article-body {
            padding: 1.5rem;
        }

        .article-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.75rem;
        }

        .article-text {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .article-footer {
            padding: 1rem 1.5rem;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #64748b;
            font-size: 0.9rem;
        }

        /* Prayer Schedule Cards */
        .prayer-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 1.5rem;
            color: white;
            text-align: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .prayer-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            transition: all 0.5s ease;
        }

        .prayer-card:hover::before {
            top: -30%;
            right: -30%;
        }

        .prayer-card:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
        }

        .prayer-card.today {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            box-shadow: 0 10px 25px rgba(245, 87, 108, 0.4);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { box-shadow: 0 10px 25px rgba(245, 87, 108, 0.4); }
            50% { box-shadow: 0 15px 35px rgba(245, 87, 108, 0.6); }
        }

        .prayer-name {
            font-size: 0.9rem;
            font-weight: 500;
            opacity: 0.9;
            margin-bottom: 0.5rem;
        }

        .prayer-time {
            font-size: 1.5rem;
            font-weight: 700;
            position: relative;
            z-index: 1;
        }

        /* Schedule Table */
        .schedule-table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .schedule-table thead {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .schedule-table th {
            font-weight: 600;
            padding: 1rem;
            border: none;
        }

        .schedule-table td {
            padding: 1rem;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .schedule-table tbody tr:hover {
            background: #f8fafc;
        }

        .schedule-table td.today-cell {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            font-weight: 700;
            color: var(--dark-color);
            position: relative;
        }

        .schedule-table td.today-cell::after {
            content: '●';
            position: absolute;
            top: 5px;
            right: 5px;
            color: var(--accent-color);
            font-size: 0.8rem;
        }

        /* Footer */
        footer {
            background: linear-gradient(135deg, var(--dark-color), #0f172a);
            color: white;
            padding: 3rem 0;
        }

        .footer-content {
            text-align: center;
        }

        .footer-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .footer-text {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }

        /* Background Sections */
        .bg-light-custom {
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.2rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .prayer-time {
                font-size: 1.2rem;
            }
        }

        /* Scroll Animation */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Floating Shapes */
        .shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: floatShape 20s infinite;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            background: var(--primary-color);
            top: 10%;
            left: -5%;
            animation-delay: 0s;
        }

        .shape-2 {
            width: 200px;
            height: 200px;
            background: var(--accent-color);
            bottom: 10%;
            right: -5%;
            animation-delay: 5s;
        }

        @keyframes floatShape {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-mosque"></i> Masjid Al-Ikhlas
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#artikel">Artikel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#jadwal">Jadwal Sholat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary btn-sm text-white ms-2 px-4" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="container">
            <div class="hero-content text-center" data-aos="fade-up" data-aos-duration="1000">
                <div class="hero-icon">
                    <i class="fas fa-mosque"></i>
                </div>
                <h1 class="hero-title">Selamat Datang di</h1>
                <h2 class="hero-subtitle">Sistem Manajemen Masjid Al-Ikhlas</h2>
                <p class="hero-description">
                    Platform terpadu untuk mengelola kegiatan, informasi, dan program masjid dengan mudah dan efisien
                </p>
                <a href="{{ route('login') }}" class="btn btn-hero">
                    <span><i class="fas fa-sign-in-alt me-2"></i>Masuk ke Sistem</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Artikel & Pengumuman Section -->
    <section id="artikel" class="section bg-light-custom">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title"><i class="fas fa-newspaper me-2"></i>Artikel & Pengumuman</h2>
                <p class="section-subtitle">Informasi terbaru dari Masjid Al-Ikhlas</p>
            </div>
            
            @if($articles->count() > 0)
            <div class="row g-4">
                @foreach($articles as $index => $article)
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                    <div class="article-card">
                        @if($article->image_url)
                        <img src="{{ $article->image_url }}" class="article-image w-100" alt="{{ $article->title }}">
                        @else
                        <div class="article-image-placeholder">
                            <i class="fas fa-newspaper fa-4x text-white"></i>
                        </div>
                        @endif
                        <div class="article-body">
                            <h5 class="article-title">{{ $article->title }}</h5>
                            <p class="article-text">{{ Str::limit($article->description, 100) }}</p>
                        </div>
                        <div class="article-footer">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ $article->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="alert alert-info text-center" data-aos="fade-up">
                <i class="fas fa-info-circle me-2"></i>Belum ada artikel atau pengumuman
            </div>
            @endif
        </div>
    </section>

    <!-- Jadwal Sholat Section -->
    <section id="jadwal" class="section">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title"><i class="fas fa-pray me-2"></i>Jadwal Sholat</h2>
                <p class="section-subtitle">Jadwal sholat untuk hari ini dan seminggu ke depan</p>
            </div>

            <!-- Jadwal Hari Ini (dari API Kota Bandung) -->
            <div class="card shadow-lg border-0 mb-5" data-aos="fade-up" style="border-radius: 20px; overflow: hidden;">
                <div class="card-header text-white" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); padding: 1.5rem;">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar-day me-2"></i>Jadwal Sholat Hari Ini 
                        <span class="badge bg-light text-primary ms-2">{{ $todayIndonesian ?? ucfirst($today) }}</span>
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        @foreach($schedules as $schedule)
                        <div class="col-md-2 col-6">
                            <div class="prayer-card">
                                <div class="prayer-name">{{ $schedule['prayer_name'] }}</div>
                                <div class="prayer-time">{{ $schedule['time'] ?? '-' }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-icon">
                    <i class="fas fa-mosque"></i>
                </div>
                <p class="footer-text">Masjid Al-Ikhlas - Sistem Manajemen Masjid</p>
                <a href="{{ route('login') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-sign-in-alt me-2"></i>Login ke Sistem
                </a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true,
            offset: 100
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNav');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offsetTop = target.offsetTop - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add fade-in animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>
