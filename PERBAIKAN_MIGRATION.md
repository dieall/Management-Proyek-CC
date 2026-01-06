# 🔧 PERBAIKAN MIGRATION KE DATABASE MINPRI

## Masalah
Laravel masih mencoba connect ke SQLite padahal Anda sudah punya database MySQL 'minpri'.

## Solusi

### 1. Pastikan file `.env` sudah dikonfigurasi dengan benar:

Buka file `.env` di root project dan pastikan konfigurasi database seperti ini:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=minpri
DB_USERNAME=root
DB_PASSWORD=
```

**PENTING**: Pastikan `DB_CONNECTION=mysql` (bukan sqlite)

### 2. Clear config cache:

```bash
php artisan config:clear
php artisan cache:clear
```

### 3. Jalankan migration:

```bash
php artisan migrate --path=database/migrations/2026_01_04_000000_create_takmir_masjid_tables.php
```

Atau jika ingin menjalankan semua migration yang belum dijalankan:

```bash
php artisan migrate
```

## Alternatif: Jika masih error

Jika masih error, gunakan file SQL langsung:

1. Buka phpMyAdmin
2. Pilih database **minpri**
3. Klik tab **SQL**
4. Copy semua isi file `database/takmir_tables.sql`
5. Paste dan jalankan

File SQL menggunakan `CREATE TABLE IF NOT EXISTS`, jadi aman dijalankan.







