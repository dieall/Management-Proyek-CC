# 🕌 Sistem Manajemen Masjid Al-Nassr

Sistem manajemen terintegrasi untuk masjid dengan 3 modul utama.

## ✨ Fitur Lengkap

### 📅 Event Management
- Kelola event masjid
- Sistem approval (Admin/DKM)
- Pendaftaran peserta event
- Status event (draft/published/cancelled)

### 📦 Inventaris/Aset
- Manajemen aset masjid
- Jadwal & laporan perawatan
- QR Code tracking
- Archive sistem

### 👥 Kegiatan & Donasi
- Kegiatan masjid (kajian, tabligh, santunan)
- Program donasi (renovasi, beasiswa, bantuan)
- Tracking donatur dan donasi
- Kategori jamaah (DKM, Remaja, TPA, dll)

## 🔐 Login Credentials

| Role | Username | Password | Akses |
|------|----------|----------|-------|
| Admin | `admin` | `admin123` | Full access semua modul |
| DKM | `dkm` | `dkm123` | Approval & management |
| Panitia | `Hasan` | `panitia123` | Buat event & kegiatan |
| Jemaah | `jamaah` | `jamaah123` | Lihat & daftar event/kegiatan |

## 🚀 Quick Start

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Setup
Edit `.env` sesuai konfigurasi database Anda, lalu:
```bash
php artisan migrate
php artisan db:seed
```

### 4. Run Application
```bash
php artisan serve
```

Buka browser: `http://127.0.0.1:8000`

## 📂 Struktur Modul

```
├── 📅 Event Management (GitHub C10)
│   ├── Events
│   ├── Sessions
│   └── Participants
│
├── 📦 Inventaris/Aset (Existing)
│   ├── Aset/Inventaris
│   ├── Jadwal Perawatan
│   ├── Laporan Perawatan
│   └── Log Aktivitas
│
└── 👥 Kegiatan & Donasi (masjid_db.sql)
    ├── Kategori Jamaah
    ├── Kegiatan Masjid
    ├── Keikutsertaan Kegiatan
    ├── Program Donasi
    └── Riwayat Donasi
```

## 🎯 Role & Permission

### 🔴 Admin/SuperAdmin
- ✅ Full access semua modul
- ✅ Kelola users, inventaris, events
- ✅ Lihat log aktivitas

### 🟠 DKM
- ✅ Approve/reject events
- ✅ Kelola kegiatan & program donasi
- ✅ Manajemen inventaris

### 🟡 Panitia
- ✅ Buat event baru (draft)
- ✅ Edit event sendiri
- ✅ Lihat kegiatan

### 🟢 Jemaah
- ✅ Lihat & daftar event published
- ✅ Daftar kegiatan aktif
- ✅ Submit donasi
- ✅ Lihat riwayat donasi pribadi

## 📊 Dashboard Features

Dashboard menampilkan:
- 📈 Total Events & Status
- 📦 Total Inventaris Aset
- 👥 Total Kegiatan & Peserta
- 💰 Total Donasi Terkumpul
- 📅 Event & Kegiatan Terdekat
- 🏦 Program Donasi Aktif

## 🛠️ Tech Stack

- **Framework**: Laravel 11
- **Database**: MySQL
- **Frontend**: Bootstrap (SB Admin 2)
- **Icons**: Font Awesome
- **PHP**: 8.2+

## 📖 Dokumentasi

Lihat file `INTEGRASI_LENGKAP.md` untuk dokumentasi lengkap tentang:
- Detail integrasi ketiga modul
- Struktur database
- Routes API
- Technical details

## 🎉 Status Integrasi

| Modul | Status |
|-------|--------|
| ✅ Event Management | Terintegrasi |
| ✅ Inventaris/Aset | Terintegrasi |
| ✅ Kegiatan Masjid | Terintegrasi |
| ✅ Program Donasi | Terintegrasi |
| ✅ Dashboard Unified | Terintegrasi |
| ✅ Role-Based Access | Terintegrasi |

## 📝 Notes

- Semua modul berjalan dalam satu aplikasi unified
- Single login system untuk semua modul
- Role-based access control terintegrasi
- Dashboard menampilkan statistik dari ketiga modul

---

Dibuat dengan ❤️ untuk Masjid Al-Nassr
