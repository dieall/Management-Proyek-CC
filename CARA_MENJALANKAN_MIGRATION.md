# 🚀 CARA MENJALANKAN MIGRATION TABEL TAKMIR

Karena Anda menggunakan MySQL dengan database 'minpri', ada 2 cara untuk membuat tabel:

## Cara 1: Menggunakan SQL File (PALING MUDAH) ✅

1. Buka phpMyAdmin atau MySQL client
2. Pilih database **minpri**
3. Klik tab **SQL**
4. Copy isi file `database/takmir_tables.sql`
5. Paste dan jalankan (Execute)

Atau via command line:
```bash
mysql -u root -p minpri < database/takmir_tables.sql
```

## Cara 2: Menggunakan Laravel Migration

Pastikan file `.env` Anda sudah benar:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=minpri
DB_USERNAME=root
DB_PASSWORD=
```

Kemudian jalankan:
```bash
php artisan migrate --path=database/migrations/2026_01_04_000000_create_takmir_masjid_tables.php
```

Atau jika masih error, coba:
```bash
php artisan config:clear
php artisan cache:clear
php artisan migrate --path=database/migrations/2026_01_04_000000_create_takmir_masjid_tables.php
```

## ✅ SETELAH MIGRATION

Setelah tabel berhasil dibuat, pastikan juga membuat storage link untuk upload file:
```bash
php artisan storage:link
```

Selesai! Semua tabel sudah dibuat dan modul Takmir siap digunakan. 🎉








