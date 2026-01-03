<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Kelola Masjid</title>
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
            padding: 20px;
        }

        .header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
            border-radius: 15px 15px 0 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
        }

        .admin-panel {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .section {
            padding: 30px;
            border-bottom: 1px solid #eee;
        }

        .section:last-child {
            border-bottom: none;
        }

        .section h2 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 15px;
            border-bottom: 2px solid var(--light-bg);
        }

        .section h2 i {
            color: var(--accent-color);
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 8px;
            display: block;
        }

        .form-control, .form-control:focus {
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 10px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(107, 166, 57, 0.25);
        }

        .btn {
            border-radius: 8px;
            padding: 10px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 80, 22, 0.3);
            color: white;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
            padding: 8px 15px;
            font-size: 0.9rem;
        }

        .btn-danger:hover {
            background: #c82333;
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            color: white;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.875rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }

        /* Article Item */
        .article-item {
            background: var(--light-bg);
            border-left: 4px solid var(--secondary-color);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .article-item-info {
            flex: 1;
        }

        .article-item-title {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .article-item-desc {
            color: #666;
            font-size: 0.9rem;
            max-width: 400px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .article-item-actions {
            display: flex;
            gap: 8px;
            flex-shrink: 0;
        }

        /* Prayer Item */
        .prayer-item {
            background: var(--light-bg);
            border-left: 4px solid var(--secondary-color);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .prayer-item-name {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        .prayer-item-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .prayer-item-table td {
            padding: 10px;
            border: 1px solid #ddd;
            font-size: 0.9rem;
        }

        .prayer-item-table td:first-child {
            font-weight: 600;
            color: var(--primary-color);
            background: #f5f5f5;
            min-width: 80px;
        }

        .prayer-item-actions {
            display: flex;
            gap: 8px;
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            border: none;
        }

        .modal-title {
            font-weight: 700;
        }

        .btn-close-white {
            filter: invert(1);
        }

        .alert {
            border-radius: 8px;
            border: none;
            margin-bottom: 20px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            color: var(--primary-color);
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .empty-state i {
            font-size: 2rem;
            margin-bottom: 10px;
            opacity: 0.5;
        }

        .add-form {
            background: var(--light-bg);
            padding: 20px;
            border-radius: 8px;
        }

        .add-form h4 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 20px;
        }

        .form-row-wide {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }

        .day-label {
            font-weight: 600;
            color: var(--primary-color);
            font-size: 0.9rem;
            margin-bottom: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container-custom">
        <a href="{{ route('masjid.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Halaman Utama
        </a>

        <div class="header">
            <h1>
                <i class="fas fa-cogs"></i> Admin Panel
            </h1>
            <p style="margin: 0; opacity: 0.9;">Kelola Informasi Masjid, Artikel, dan Jadwal Shalat</p>
        </div>

        <div class="admin-panel">
            <!-- Success Messages -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin: 20px 30px 0;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin: 20px 30px 0;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Section: Informasi Masjid -->
            <div class="section">
                <h2>
                    <i class="fas fa-mosque"></i> Informasi Masjid
                </h2>

                <form action="{{ route('masjid.update') }}" method="POST">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Nama Masjid *</label>
                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                value="{{ old('name', $masjid->name ?? '') }}"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="address">Alamat *</label>
                            <input
                                type="text"
                                class="form-control"
                                id="address"
                                name="address"
                                value="{{ old('address', $masjid->address ?? '') }}"
                                required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Telepon</label>
                            <input
                                type="tel"
                                class="form-control"
                                id="phone"
                                name="phone"
                                value="{{ old('phone', $masjid->phone ?? '') }}"
                                placeholder="Contoh: 021-1234567">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                value="{{ old('email', $masjid->email ?? '') }}"
                                placeholder="Contoh: info@masjid.com">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Informasi
                    </button>
                </form>
            </div>

            <!-- Section: Artikel Islam -->
            <div class="section">
                <h2>
                    <i class="fas fa-book"></i> Artikel Berita atau Informasi
                </h2>

                <!-- List Articles -->
                @if ($articles && $articles->count() > 0)
                    <div style="margin-bottom: 30px;">
                        @foreach ($articles as $article)
                            <div class="article-item">
                                <div class="article-item-info">
                                    <div class="article-item-title">{{ $article->title }}</div>
                                    <div class="article-item-desc">{{ $article->description }}</div>
                                </div>
                                <div class="article-item-actions">
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editArticleModal{{ $article->id }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form action="{{ route('article.delete', $article) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Edit Article Modal -->
                            <div class="modal fade" id="editArticleModal{{ $article->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Artikel</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('article.update', $article) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>Judul *</label>
                                                    <input type="text" class="form-control" name="title" value="{{ $article->title }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Deskripsi Singkat *</label>
                                                    <textarea class="form-control" name="description" rows="3" required>{{ $article->description }}</textarea>
                                                </div>
                                                <!-- Konten dihapus sesuai permintaan -->
                                                <div class="form-group">
                                                    <label>Ganti Gambar (opsional)</label>
                                                    <input type="file" class="form-control" name="image" accept="image/*">
                                                    @if ($article->image_url)
                                                        <small class="form-text text-muted">Gambar saat ini: <a href="{{ $article->image_url }}" target="_blank">lihat</a></small>
                                                    @endif
                                                    <small class="form-text text-muted">Kosongkan jika tak ingin mengubah gambar. Max 2MB.</small>
                                                </div>

                                                <div class="form-group">
                                                    <label>URL Gambar (opsional)</label>
                                                    <input type="url" class="form-control" name="image_url" value="{{ $article->image_url ?? '' }}">
                                                    <small class="form-text text-muted">Jika diisi dan tidak mengunggah file, URL ini akan digunakan sebagai gambar.</small>
                                                </div>

                                                <div class="form-group">
                                                    <label>URL Link</label>
                                                    <input type="url" class="form-control" name="link_url" value="{{ $article->link_url ?? '' }}">
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="is_active{{ $article->id }}" name="is_active" value="1" {{ $article->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_active{{ $article->id }}">
                                                        Tampilkan di halaman utama
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-inbox"></i>
                        <p>Belum ada artikel</p>
                    </div>
                @endif

                <!-- Add Article Form -->
                <div class="add-form">
                    <h4><i class="fas fa-plus"></i> Tambah Artikel Baru</h4>
                    <form action="{{ route('article.add') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Judul *</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi Singkat *</label>
                            <textarea class="form-control" name="description" rows="2" required></textarea>
                        </div>
                        <!-- Konten dihapus sesuai permintaan; tambahkan upload gambar -->
                        <div class="form-row">
                            <div class="form-group">
                                <label>Upload Gambar</label>
                                <input type="file" class="form-control" name="image" accept="image/*">
                                <small class="form-text text-muted">Max 2MB. Jika diisi, file akan disimpan dan digunakan pada kartu artikel.</small>
                            </div>
                            <div class="form-group">
                                <label>URL Gambar (opsional)</label>
                                <input type="url" class="form-control" name="image_url" placeholder="https://example.com/image.jpg">
                                <small class="form-text text-muted">Jika diisi dan Anda tidak mengunggah file, gambar akan menggunakan URL ini.</small>
                            </div>
                            <div class="form-group">
                                <label>URL Link</label>
                                <input type="url" class="form-control" name="link_url">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Tambah
                        </button>
                    </form>
                </div>
            </div>

            <!-- Jadwal shalat (admin) dihapus: penayangan dan pengelolaan tidak tersedia -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
