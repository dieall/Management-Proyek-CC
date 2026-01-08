# 📖 PANDUAN LENGKAP INSTALASI DAN PENGGUNAAN
## Sistem Manajemen Masjid Al-Ikhlas

---

## 📋 DAFTAR ISI

1. [Persyaratan Sistem](#persyaratan-sistem)
2. [Download Software yang Diperlukan](#download-software-yang-diperlukan)
3. [Instalasi Software](#instalasi-software)
4. [Download Project](#download-project)
5. [Konfigurasi Database](#konfigurasi-database)
6. [Instalasi Dependencies](#instalasi-dependencies)
7. [Setup Environment](#setup-environment)
8. [Migrasi Database](#migrasi-database)
9. [Menjalankan Aplikasi](#menjalankan-aplikasi)
10. [Cara Menggunakan Aplikasi](#cara-menggunakan-aplikasi)
11. [Troubleshooting](#troubleshooting)

---

## 🖥️ PERSYARATAN SISTEM

Sebelum memulai instalasi, pastikan komputer Anda memenuhi persyaratan berikut:

- **Sistem Operasi**: Windows 10/11, macOS, atau Linux
- **RAM**: Minimal 4 GB (disarankan 8 GB)
- **Storage**: Minimal 2 GB ruang kosong
- **Internet**: Koneksi internet aktif untuk download dependencies

---

## 📥 DOWNLOAD SOFTWARE YANG DIPERLUKAN

### 1. **Laragon** (All-in-One Web Server untuk Windows)
   - **Link Download**: https://laragon.org/download/
   - **Keterangan**: Laragon sudah termasuk PHP, MySQL, Apache/Nginx, dan Composer
   - **Alternatif untuk macOS/Linux**: Gunakan XAMPP atau install manual

### 2. **Composer** (jika tidak menggunakan Laragon)
   - **Link Download**: https://getcomposer.org/download/
   - **Keterangan**: Package manager untuk PHP

### 3. **Node.js dan NPM**
   - **Link Download**: https://nodejs.org/
   - **Pilih versi LTS** (Long Term Support)
   - **Keterangan**: Untuk mengelola asset frontend (CSS, JavaScript)

### 4. **Git** (untuk download project dari GitHub)
   - **Link Download**: https://git-scm.com/downloads
   - **Keterangan**: Tools untuk clone project dari repository

### 5. **Text Editor** (Opsional, untuk edit file konfigurasi)
   - **Visual Studio Code**: https://code.visualstudio.com/
   - **Notepad++**: https://notepad-plus-plus.org/
   - **Atau text editor lainnya**

---

## 🔧 INSTALASI SOFTWARE

### **Langkah 1: Install Laragon (Windows)**

1. Download file installer Laragon dari link di atas
2. Double-click file installer yang sudah didownload
3. Ikuti wizard instalasi:
   - Klik **"Next"** pada setiap langkah
   - Pilih lokasi instalasi (default: `C:\laragon`)
   - Centang semua opsi yang tersedia
   - Klik **"Install"**
4. Tunggu proses instalasi selesai
5. Restart komputer jika diminta

**Catatan**: Laragon sudah termasuk:
- ✅ PHP 8.2+
- ✅ MySQL/MariaDB
- ✅ Apache/Nginx
- ✅ Composer
- ✅ Git

### **Langkah 2: Install Node.js**

1. Download installer Node.js LTS dari https://nodejs.org/
2. Double-click file installer
3. Ikuti wizard instalasi:
   - Klik **"Next"** pada setiap langkah
   - Centang opsi **"Automatically install the necessary tools"**
   - Klik **"Install"**
4. Tunggu proses instalasi selesai
5. Restart komputer jika diminta

**Verifikasi Instalasi**:
- Buka Command Prompt atau PowerShell
- Ketik: `node --version` (harus muncul versi Node.js)
- Ketik: `npm --version` (harus muncul versi NPM)

### **Langkah 3: Install Git (jika belum ada)**

1. Download installer Git dari https://git-scm.com/downloads
2. Double-click file installer
3. Ikuti wizard instalasi dengan pengaturan default
4. Klik **"Next"** pada setiap langkah hingga selesai

**Verifikasi Instalasi**:
- Buka Command Prompt atau PowerShell
- Ketik: `git --version` (harus muncul versi Git)

---

## 📦 DOWNLOAD PROJECT

### **Opsi 1: Download dari GitHub (Menggunakan Git)**

1. Buka Command Prompt atau PowerShell
2. Masuk ke folder web server (contoh: `C:\laragon\www`)
   ```bash
   cd C:\laragon\www
   ```
3. Clone project dari repository:
   ```bash
   git clone [URL_REPOSITORY_ANDA] "Masjid inpen"
   ```
   **Ganti `[URL_REPOSITORY_ANDA]` dengan URL repository GitHub Anda**

### **Opsi 2: Download Manual (ZIP)**

1. Download file ZIP project dari GitHub
2. Extract file ZIP ke folder web server:
   - **Laragon**: `C:\laragon\www\Masjid inpen`
   - **XAMPP**: `C:\xampp\htdocs\Masjid inpen`
   - **Lainnya**: Sesuaikan dengan lokasi web server Anda

---

## 🗄️ KONFIGURASI DATABASE

### **Langkah 1: Buat Database Baru**

1. **Jika menggunakan Laragon**:
   - Buka aplikasi Laragon
   - Klik tombol **"Start All"** untuk menjalankan MySQL
   - Klik tombol **"Database"** atau buka http://localhost/phpmyadmin
   - Login dengan:
     - Username: `root`
     - Password: (kosongkan)

2. **Jika menggunakan XAMPP**:
   - Buka http://localhost/phpmyadmin
   - Login dengan:
     - Username: `root`
     - Password: (kosongkan)

3. **Buat Database Baru**:
   - Klik menu **"New"** atau **"Database Baru"**
   - Nama database: `masjid_inpen` (atau nama lain sesuai keinginan)
   - Collation: `utf8mb4_unicode_ci`
   - Klik **"Create"** atau **"Buat"**

### **Langkah 2: Catat Informasi Database**

Catat informasi berikut (akan digunakan nanti):
- **DB_HOST**: `127.0.0.1` atau `localhost`
- **DB_PORT**: `3306`
- **DB_DATABASE**: `masjid_inpen` (nama database yang baru dibuat)
- **DB_USERNAME**: `root`
- **DB_PASSWORD**: (kosongkan jika tidak ada password)

---

## 📚 INSTALASI DEPENDENCIES

### **Langkah 1: Buka Terminal/Command Prompt**

1. Buka Command Prompt atau PowerShell
2. Masuk ke folder project:
   ```bash
   cd C:\laragon\www\Masjid inpen
   ```
   **Sesuaikan path dengan lokasi project Anda**

### **Langkah 2: Install Dependencies PHP (Composer)**

1. Pastikan Composer sudah terinstall:
   ```bash
   composer --version
   ```
   Jika muncul error, install Composer terlebih dahulu.

2. Install dependencies PHP:
   ```bash
   composer install
   ```
   **Proses ini mungkin memakan waktu 5-10 menit**, tunggu hingga selesai.

   **Jika muncul error "memory limit"**:
   ```bash
   php -d memory_limit=-1 composer install
   ```

### **Langkah 3: Install Dependencies Frontend (NPM)**

1. Pastikan Node.js dan NPM sudah terinstall:
   ```bash
   node --version
   npm --version
   ```

2. Install dependencies frontend:
   ```bash
   npm install
   ```
   **Proses ini mungkin memakan waktu 2-5 menit**, tunggu hingga selesai.

---

## ⚙️ SETUP ENVIRONMENT

### **Langkah 1: Buat File .env**

1. Di folder project, cari file `.env.example`
2. Copy file tersebut dan rename menjadi `.env`
   - **Windows**: Klik kanan → Copy → Paste → Rename menjadi `.env`
   - **Command Line**:
     ```bash
     copy .env.example .env
     ```
     (Windows)
     ```bash
     cp .env.example .env
     ```
     (macOS/Linux)

### **Langkah 2: Edit File .env**

1. Buka file `.env` dengan text editor (Notepad++, VS Code, dll)
2. Cari bagian **Database Configuration** dan edit seperti berikut:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=minpri
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   **Sesuaikan dengan informasi database yang sudah dibuat sebelumnya**

3. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```
   Perintah ini akan otomatis mengisi `APP_KEY` di file `.env`

---

## 🗃️ MIGRASI DATABASE

### **Langkah 1: Jalankan Migration**

1. Pastikan database sudah dibuat dan konfigurasi `.env` sudah benar
2. Jalankan perintah migration:
   ```bash
   php artisan migrate
   ```
   Perintah ini akan membuat semua tabel yang diperlukan di database.

   **Jika muncul error**, pastikan:
   - Database sudah dibuat
   - Konfigurasi `.env` sudah benar
   - MySQL sudah berjalan (Start All di Laragon)

### **Langkah 2: Jalankan Seeder (Data Awal)**

1. Jalankan seeder untuk mengisi data awal:
   ```bash
   php artisan db:seed
   ```
   Perintah ini akan membuat:
   - ✅ User default (Admin, DKM, Panitia, Jemaah)
   - ✅ Data contoh lainnya

---

## 🚀 MENJALANKAN APLIKASI

### **Langkah 1: Start Web Server**

**Jika menggunakan Laragon**:
1. Buka aplikasi Laragon
2. Klik tombol **"Start All"**
3. Pastikan semua service berjalan (hijau)

**Jika menggunakan XAMPP**:
1. Buka aplikasi XAMPP Control Panel
2. Start **Apache** dan **MySQL**

### **Langkah 2: Build Frontend Assets**

1. Buka terminal di folder project
2. Jalankan perintah build:
   ```bash
   npm run build
   ```
   **Catatan**: Proses ini hanya perlu dilakukan sekali atau saat ada perubahan asset.

### **Langkah 3: Jalankan Laravel Server**

1. Buka terminal di folder project
2. Jalankan perintah:
   ```bash
   php artisan serve
   ```
   Akan muncul pesan seperti:
   ```
   INFO  Server running on [http://127.0.0.1:8000]
   ```

### **Langkah 4: Akses Aplikasi**

1. Buka browser (Chrome, Firefox, Edge, dll)
2. Ketik URL berikut di address bar:
   ```
   http://127.0.0.1:8000
   ```
   atau
   ```
   http://localhost:8000
   ```

3. **Halaman Landing Page** akan muncul jika instalasi berhasil! 🎉

---

## 👤 CARA MENGGUNAKAN APLIKASI

### **1. Login ke Aplikasi**

**Kredensial Default**:

| Role | Username | Password | Akses |
|------|----------|----------|-------|
| **Admin** | `admin` | `admin123` | Full access semua modul |
| **DKM** | `dkm` | `dkm123` | Approval & management |
| **Panitia** | `Hasan` | `panitia123` | Buat event & kegiatan |
| **Jemaah** | `jamaah` | `jamaah123` | Lihat & daftar event/kegiatan |
| **Muzakki (contoh)** | `muzakki1` / `muzakki2` | `password` | Akses sebagai muzakki (pembayar ZIS) |
| **Mustahik (contoh)** | `mustahik1` / `mustahik2` | `password` | Akses sebagai mustahik (penerima ZIS) |

**Cara Login**:
1. Klik tombol **"Login"** di halaman landing page
2. Masukkan username dan password sesuai role
3. Klik **"Login"**

**⚠️ PENTING**: Setelah login pertama kali, **segera ubah password** untuk keamanan!

### **2. Fitur-Fitur Utama**

#### **📅 Event Management**
- **Admin/DKM**: Buat, edit, approve/reject event
- **Panitia**: Buat event baru (status draft)
- **Jemaah**: Lihat dan daftar event yang published

#### **📦 Inventaris/Aset**
- **Admin/DKM**: Kelola aset masjid, jadwal perawatan, laporan perawatan
- **Export PDF**: Klik tombol "Export PDF" di halaman laporan perawatan
- **Print**: Klik tombol "Print" untuk mencetak laporan

#### **👥 Kegiatan & Donasi**
- **Admin/DKM**: Kelola kegiatan masjid dan program donasi
- **Jemaah**: Daftar kegiatan dan submit donasi

#### **🕌 Jadwal Sholat**
- **Landing Page**: Menampilkan jadwal sholat otomatis dari API Kota Bandung
- **Tidak perlu input manual**, jadwal diambil otomatis setiap hari

#### **💰 ZIS Management**
- **Admin/DKM**: Kelola muzakki, mustahik, zakat masuk, dan penyaluran

#### **👨‍👩‍👧‍👦 Manajemen Takmir**
- **Admin/DKM**: Kelola struktur organisasi, posisi, komite, tugas, dan jadwal tugas

### **3. Mengubah Password**

1. Login ke aplikasi
2. Klik nama user di pojok kanan atas
3. Pilih **"Profile"** atau **"Settings"**
4. Masukkan password lama dan password baru
5. Klik **"Update"**

### **4. Menambah User Baru**

**Hanya Admin yang bisa menambah user**:
1. Login sebagai Admin
2. Masuk ke menu **"Users"** atau **"Manajemen User"**
3. Klik tombol **"Tambah User"**
4. Isi form:
   - Nama
   - Email
   - Username
   - Password
   - Role (Admin, DKM, Panitia, atau Jemaah)
5. Klik **"Simpan"**

---

## 🔧 TROUBLESHOOTING

### **Problem 1: Error "Class not found"**

**Solusi**:
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### **Problem 2: Error "Database connection failed"**

**Solusi**:
1. Pastikan MySQL sudah berjalan (Start All di Laragon)
2. Cek konfigurasi `.env`:
   - `DB_CONNECTION=mysql`
   - `DB_HOST=127.0.0.1`
   - `DB_DATABASE=masjid_inpen` (sesuai nama database)
   - `DB_USERNAME=root`
   - `DB_PASSWORD=` (kosongkan jika tidak ada password)
3. Clear config cache:
   ```bash
   php artisan config:clear
   ```

### **Problem 3: Error "Migration failed"**

**Solusi**:
1. Pastikan database sudah dibuat
2. Pastikan konfigurasi `.env` sudah benar
3. Coba reset migration (hati-hati, akan menghapus data):
   ```bash
   php artisan migrate:fresh --seed
   ```

### **Problem 4: Halaman kosong atau error 500**

**Solusi**:
1. Cek file `.env` sudah ada dan `APP_KEY` sudah terisi
2. Set permission folder storage:
   ```bash
   php artisan storage:link
   ```
3. Clear cache:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan view:clear
   ```

### **Problem 5: CSS/JavaScript tidak muncul**

**Solusi**:
1. Build ulang assets:
   ```bash
   npm run build
   ```
2. Clear cache browser (Ctrl + Shift + Delete)

### **Problem 6: Error saat export PDF**

**Solusi**:
1. Pastikan package DomPDF sudah terinstall:
   ```bash
   composer require barryvdh/laravel-dompdf
   ```
2. Clear cache:
   ```bash
   php artisan config:clear
   ```

### **Problem 7: Port 8000 sudah digunakan**

**Solusi**:
1. Gunakan port lain:
   ```bash
   php artisan serve --port=8001
   ```
2. Atau tutup aplikasi lain yang menggunakan port 8000

---

## 📞 BANTUAN TAMBAHAN

### **Link Berguna**:
- **Laravel Documentation**: https://laravel.com/docs
- **Laragon Documentation**: https://laragon.org/docs/
- **Composer Documentation**: https://getcomposer.org/doc/
- **Node.js Documentation**: https://nodejs.org/docs/

### **Cara Update Aplikasi**:

1. **Jika menggunakan Git**:
   ```bash
   git pull origin main
   composer install
   npm install
   php artisan migrate
   npm run build
   ```

2. **Jika download manual**:
   - Download versi terbaru
   - Backup folder `storage` dan file `.env`
   - Replace semua file kecuali `storage` dan `.env`
   - Jalankan:
     ```bash
     composer install
     npm install
     php artisan migrate
     npm run build
     ```

---

## ✅ CHECKLIST INSTALASI

Gunakan checklist berikut untuk memastikan semua langkah sudah dilakukan:

- [ ] ✅ Laragon/XAMPP sudah terinstall dan berjalan
- [ ] ✅ Node.js dan NPM sudah terinstall
- [ ] ✅ Git sudah terinstall (jika menggunakan Git)
- [ ] ✅ Project sudah didownload dan diletakkan di folder web server
- [ ] ✅ Database sudah dibuat
- [ ] ✅ File `.env` sudah dibuat dari `.env.example`
- [ ] ✅ Konfigurasi database di `.env` sudah benar
- [ ] ✅ `composer install` sudah dijalankan
- [ ] ✅ `npm install` sudah dijalankan
- [ ] ✅ `php artisan key:generate` sudah dijalankan
- [ ] ✅ `php artisan migrate` sudah dijalankan
- [ ] ✅ `php artisan db:seed` sudah dijalankan
- [ ] ✅ `npm run build` sudah dijalankan
- [ ] ✅ MySQL/Apache sudah berjalan
- [ ] ✅ `php artisan serve` sudah dijalankan
- [ ] ✅ Aplikasi bisa diakses di browser

---

## 🎉 SELAMAT!

Jika semua langkah sudah dilakukan dan aplikasi sudah berjalan, **selamat!** Anda sudah berhasil menginstall Sistem Manajemen Masjid Al-Ikhlas.

**Tips**:
- Simpan file `.env` dengan aman (jangan di-commit ke Git)
- Backup database secara berkala
- Update password default setelah instalasi pertama
- Baca dokumentasi fitur lengkap di file `INTEGRASI_LENGKAP.md`

---

**Dibuat dengan ❤️ untuk Masjid Al-Ikhlas**

*Terakhir diperbarui: 2025*

