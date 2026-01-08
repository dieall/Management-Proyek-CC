# ⚡ QUICK START GUIDE
## Sistem Manajemen Masjid Al-Ikhlas

Panduan cepat untuk menjalankan aplikasi dalam 5 menit.

---

## 📋 PERSYARATAN CEPAT

- ✅ Laragon (Windows) atau XAMPP (Windows/Mac/Linux)
- ✅ Node.js LTS (https://nodejs.org/)
- ✅ Internet aktif

---

## 🚀 LANGKAH CEPAT (5 MENIT)

### **1. Download & Install Laragon**
- Download: https://laragon.org/download/
- Install dengan pengaturan default
- Start Laragon → Klik **"Start All"**

### **2. Download & Install Node.js**
- Download: https://nodejs.org/ (pilih versi LTS)
- Install dengan pengaturan default

### **3. Download Project**
- Clone atau download ZIP project
- Extract ke: `C:\laragon\www\Masjid inpen`

### **4. Buat Database**
- Buka Laragon → Klik **"Database"**
- Buat database baru: `masjid_inpen`
- Collation: `utf8mb4_unicode_ci`

### **5. Setup Project**

Buka **Terminal/Command Prompt** di folder project:

```bash
# Masuk ke folder project
cd C:\laragon\www\Masjid inpen

# Install dependencies PHP
composer install

# Install dependencies Frontend
npm install

# Copy file environment
copy .env.example .env

# Generate key
php artisan key:generate

# Edit file .env (buka dengan Notepad++)
# Ubah bagian database:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=masjid_inpen
# DB_USERNAME=root
# DB_PASSWORD=

# Migrasi database
php artisan migrate

# Isi data awal
php artisan db:seed

# Build assets
npm run build

# Jalankan server
php artisan serve
```

### **6. Akses Aplikasi**

Buka browser: **http://127.0.0.1:8000**

---

## 🔑 LOGIN DEFAULT

| Role | Username | Password |
|------|----------|----------|
| Admin | `admin` | `admin123` |
| DKM | `dkm` | `dkm123` |
| Panitia | `Hasan` | `panitia123` |
| Jemaah | `jamaah` | `jamaah123` |

---

## ⚠️ TROUBLESHOOTING CEPAT

**Error database?**
```bash
php artisan config:clear
```

**CSS/JS tidak muncul?**
```bash
npm run build
```

**Port 8000 sudah digunakan?**
```bash
php artisan serve --port=8001
```

---

## 📖 DOKUMENTASI LENGKAP

Lihat file **`PANDUAN_INSTALASI_DAN_PENGGUNAAN.md`** untuk panduan detail.

---

**Selamat menggunakan! 🎉**

