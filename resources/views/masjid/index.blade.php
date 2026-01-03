<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $masjid?->name ?? 'Informasi dan Berita' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2d5016;
            --secondary-color: #6ba639;
            --accent-color: #d4af37;
            --light-bg: #f8f9fa;
            --dark-text: #1a1a1a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--dark-text);
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        /* Header */
        .header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 50px 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .header h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .header .location {
            font-size: 1.1rem;
            opacity: 0.95;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .admin-link {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .admin-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid white;
            padding: 8px 20px;
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .admin-btn:hover {
            background: white;
            color: var(--primary-color);
        }

        /* Container */
        .container-custom {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }

        /* Articles Section */
        .articles-section h2 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 40px;
            text-align: center;
            font-size: 2.5rem;
        }

        .articles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .article-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .article-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .article-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 3rem;
            overflow: hidden;
            position: relative;
        }

        .article-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .article-image i {
            opacity: 0.3;
        }

        .article-content {
            padding: 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .article-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
            min-height: 3.6em;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .article-description {
            color: #666;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 20px;
            flex: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .article-link {
            display: inline-block;
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 600;
            padding: 10px 20px;
            background: var(--light-bg);
            border-radius: 8px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .article-link:hover {
            background: var(--secondary-color);
            color: white;
        }

        /* Prayer Schedule Section */
        .prayer-section {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin-bottom: 30px;
        }

        .prayer-section h2 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .prayer-schedule-table {
            width: 100%;
            border-collapse: collapse;
        }

        .prayer-schedule-table thead {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
        }

        .prayer-schedule-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 1rem;
        }

        .prayer-schedule-table tbody tr {
            border-bottom: 1px solid #eee;
            transition: all 0.3s ease;
        }

        .prayer-schedule-table tbody tr:hover {
            background: var(--light-bg);
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .prayer-schedule-table tbody tr:last-child {
            border-bottom: none;
        }

        .prayer-schedule-table td {
            padding: 15px;
            font-size: 1rem;
        }

        .prayer-name {
            font-weight: 600;
            color: var(--primary-color);
            min-width: 100px;
        }

        .prayer-time {
            background: linear-gradient(135deg, var(--secondary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
            font-size: 1.2rem;
        }

        /* Quick Navigation Buttons */
        .quick-nav {
            margin: 20px 0;
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .quick-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 30px;
            padding: 8px 18px;
            font-weight: 700;
            color: white;
            text-decoration: none;
            box-shadow: 0 8px 20px rgba(43, 64, 14, 0.10);
            transition: transform .14s ease, box-shadow .14s ease, opacity .12s ease;
            border: none;
            font-size: 0.95rem;
        }

        .quick-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 36px rgba(43, 64, 14, 0.14);
            opacity: 0.98;
        }

        .quick-btn:active { transform: translateY(-1px) scale(.995); }
        .quick-btn:focus { outline: none; box-shadow: 0 0 0 6px rgba(107,166,57,0.12); }

        .quick-btn-primary {
            background: linear-gradient(90deg, var(--primary-color) 0%, #2f6a1b 100%);
            color: white;
        }

        .quick-btn-secondary {
            background: linear-gradient(90deg, #f3f6f0 0%, #eef6e6 100%);
            color: var(--primary-color);
            box-shadow: none;
            border: 1px solid rgba(45,80,22,0.06);
        }

        @media (max-width: 480px) {
            .quick-btn { padding: 8px 12px; font-size: 0.88rem; }
        }

        .empty-message {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        /* Masjid Info Section */
        .masjid-info {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px;
            margin-bottom: 30px;
        }

        .masjid-info h3 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: var(--light-bg);
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .info-item i {
            color: var(--secondary-color);
            font-size: 1.3rem;
            min-width: 30px;
        }

        .info-item a {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .info-item a:hover {
            text-decoration: underline;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 30px 20px;
            background: var(--primary-color);
            color: white;
            margin-top: 50px;
        }

        .footer p {
            margin: 0;
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }

            .articles-section h2 {
                font-size: 1.8rem;
            }

            .admin-link {
                position: static;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="admin-link">
            <a href="{{ route('masjid.edit') }}" class="admin-btn">
                <i class="fas fa-edit"></i> Admin Panel
            </a>
        </div>
        <div class="header-content">
            @if ($masjid)
                <h1>{{ $masjid->name }}</h1>
                <div class="location">
                    <i class="fas fa-map-marker-alt"></i>
                    {{ $masjid->address }}
                </div>
            @else
                <h1>Selamat Datang</h1>
                <p style="margin: 0; opacity: 0.9;">Informasi/Berita dan Jadwal Shalat</p>
            @endif
        </div>
    </div>

    <!-- Main Content -->
    <div class="container-custom">
        <!-- Masjid Info Section -->
        @if ($masjid)
            <div class="masjid-info">
                <h3>
                    <i class="fas fa-mosque"></i> Informasi Kontak
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px;">
                    @if ($masjid->phone)
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <strong>Telepon:</strong><br>
                                <a href="tel:{{ $masjid->phone }}">{{ $masjid->phone }}</a>
                            </div>
                        </div>
                    @endif
                    @if ($masjid->email)
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <strong>Email:</strong><br>
                                <a href="mailto:{{ $masjid->email }}">{{ $masjid->email }}</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif



        <!-- Quick Navigation -->
        <div class="quick-nav" aria-label="Navigasi cepat halaman">
            <a href="#jadwal-shalat" class="quick-btn quick-btn-primary" role="button" aria-label="Lihat Jadwal Shalat">
                <i class="fas fa-clock"></i> Lihat Jadwal Shalat
            </a>
            <a href="#informasi-berita" class="quick-btn quick-btn-secondary" role="button" aria-label="Lihat Informasi & Berita">
                <i class="fas fa-book"></i> Lihat Informasi & Berita
            </a>
        </div>

        <!-- Articles Section -->
        @if ($articles && $articles->count() > 0)
            <div class="articles-section" id="informasi-berita">
                <h2>
                    <i class="fas fa-book"></i> Informasi dan Berita
                </h2>

                <!-- Date filter -->
                <form method="GET" action="{{ route('masjid.index') }}" class="article-filter" style="display:flex; gap:12px; align-items:flex-end; margin-bottom:18px; flex-wrap:wrap;">
                    <div style="min-width:80px;">
                        <label style="font-weight:600; color:var(--primary-color); display:block;">Tanggal</label>
                        <select name="day" class="form-control form-control-sm">
                            <option value="">Semua</option>
                            @for ($d = 1; $d <= 31; $d++)
                                <option value="{{ $d }}" {{ (string)($selectedDay ?? '') === (string)$d ? 'selected' : '' }}>{{ $d }}</option>
                            @endfor
                        </select>
                    </div>

                    <div style="min-width:140px;">
                        <label style="font-weight:600; color:var(--primary-color); display:block;">Bulan</label>
                        <select name="month" class="form-control form-control-sm">
                            <option value="">Semua</option>
                            @foreach (($months ?? []) as $num => $name)
                                <option value="{{ $num }}" {{ (string)($selectedMonth ?? '') === (string)$num ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="min-width:120px;">
                        <label style="font-weight:600; color:var(--primary-color); display:block;">Tahun</label>
                        <select name="year" class="form-control form-control-sm">
                            <option value="">Semua</option>
                            @foreach (($availableYears ?? []) as $y)
                                <option value="{{ $y }}" {{ (string)($selectedYear ?? '') === (string)$y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="display:flex; gap:8px;">
                        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                        <a href="{{ route('masjid.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                    </div>
                </form>

                <div class="articles-grid">
                    @foreach ($articles as $article)
                        <div class="article-card">
                            <div class="article-image">
                                @if ($article->image_url)
                                    <img src="{{ $article->image_url }}" alt="{{ $article->title }}">
                                @else
                                    <i class="fas fa-book-open"></i>
                                @endif
                            </div>
                            <div class="article-content">
                                <h3 class="article-title">{{ $article->title }}</h3>
                                <p class="article-description">{{ $article->description }}</p>
                                @if ($article->link_url)
                                    <a href="{{ $article->link_url }}" target="_blank" rel="noopener noreferrer" class="article-link">
                                        <i class="fas fa-external-link-alt"></i> Baca Selengkapnya
                                    </a>
                                @else
                                    <span class="article-link" style="display: block; opacity: 0.6; cursor: default;">
                                        <i class="fas fa-file-alt"></i> Artikel
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="articles-section">
                <h2>
                    <i class="fas fa-book"></i> Informasi dan Berita
                </h2>
                <div class="empty-state" style="margin-bottom: 40px; text-align:center;">
                    <i class="fas fa-inbox"></i>
                    <p>Tidak ada artikel untuk kriteria yang dipilih</p>
                </div>
            </div>
        @endif

        <!-- Prayer Schedule Section -->
        @if ($prayerSchedules && $prayerSchedules->count() > 0)
            <div class="prayer-section" id="jadwal-shalat">
                <h2>
                    <i class="fas fa-clock"></i> Jadwal Shalat
                </h2>

                <div style="overflow-x: auto;">
                    <table class="prayer-schedule-table">
                        <thead>
                            <tr>
                                <th style="width: 15%; min-width: 100px;">Shalat</th>
                                <th style="width: 12%; min-width: 90px;">Senin</th>
                                <th style="width: 12%; min-width: 90px;">Selasa</th>
                                <th style="width: 12%; min-width: 90px;">Rabu</th>
                                <th style="width: 12%; min-width: 90px;">Kamis</th>
                                <th style="width: 12%; min-width: 90px;">Jumat</th>
                                <th style="width: 12%; min-width: 90px;">Sabtu</th>
                                <th style="width: 12%; min-width: 90px;">Minggu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prayerSchedules as $prayer)
                                <tr>
                                    <td>
                                        <span class="prayer-name">
                                            <i class="fas fa-moon"></i> {{ $prayer->prayer_name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="prayer-time">{{ $prayer->monday ? substr($prayer->monday, 0, 5) : '' }} WIB</span>
                                    </td>
                                    <td>
                                        <span class="prayer-time">{{ $prayer->tuesday ? substr($prayer->tuesday, 0, 5) : '' }} WIB</span>
                                    </td>
                                    <td>
                                        <span class="prayer-time">{{ $prayer->wednesday ? substr($prayer->wednesday, 0, 5) : '' }} WIB</span>
                                    </td>
                                    <td>
                                        <span class="prayer-time">{{ $prayer->thursday ? substr($prayer->thursday, 0, 5) : '' }} WIB</span>
                                    </td>
                                    <td>
                                        <span class="prayer-time">{{ $prayer->friday ? substr($prayer->friday, 0, 5) : '' }} WIB</span>
                                    </td>
                                    <td>
                                        <span class="prayer-time">{{ $prayer->saturday ? substr($prayer->saturday, 0, 5) : '' }} WIB</span>
                                    </td>
                                    <td>
                                        <span class="prayer-time">{{ $prayer->sunday ? substr($prayer->sunday, 0, 5) : '' }} WIB</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="prayer-section" id="jadwal-shalat">
                <h2>
                    <i class="fas fa-clock"></i> Jadwal Shalat
                </h2>
                <div class="empty-message">
                    <div>
                        <i class="fas fa-inbox" style="font-size: 2rem; margin-bottom: 10px;"></i>
                        <p>Jadwal shalat belum tersedia</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 {{ $masjid?->name ?? 'Informasi Masjid' }}. All rights reserved.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
