# 🕌 Sistem Manajemen Masjid Al-Ikhlas

Sistem manajemen terintegrasi untuk masjid dengan berbagai modul lengkap.

## 📚 **PANDUAN INSTALASI LENGKAP**

**Untuk pengguna baru, silakan baca panduan instalasi lengkap:**

- 📖 **[PANDUAN_INSTALASI_DAN_PENGGUNAAN.md](PANDUAN_INSTALASI_DAN_PENGGUNAAN.md)** - Panduan step-by-step lengkap dengan screenshot dan troubleshooting
- ⚡ **[QUICK_START.md](QUICK_START.md)** - Panduan cepat untuk pengguna yang sudah familiar dengan Laravel

---

## ✨ Fitur Lengkap

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

- **Framework**: Laravel 12
- **Database**: MySQL/MariaDB
- **Frontend**: Bootstrap (SB Admin 2), Tailwind CSS, Vite
- **Icons**: Font Awesome
- **PHP**: 8.2+
- **Package Tambahan**: DomPDF (Export PDF), Simple QR Code

## 📖 Dokumentasi

### **Untuk Pengguna**:
- 📖 **[PANDUAN_INSTALASI_DAN_PENGGUNAAN.md](PANDUAN_INSTALASI_DAN_PENGGUNAAN.md)** - Panduan instalasi dan penggunaan lengkap
- ⚡ **[QUICK_START.md](QUICK_START.md)** - Quick start guide

### **Untuk Developer**:
- 📋 **[INTEGRASI_LENGKAP.md](INTEGRASI_LENGKAP.md)** - Dokumentasi teknis lengkap:
  - Detail integrasi semua modul
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
| ✅ Program Kurban | Terintegrasi |
| ✅ ZIS Management | Terintegrasi |
| ✅ Manajemen Takmir | Terintegrasi |
| ✅ Jadwal Sholat (API) | Terintegrasi |
| ✅ Dashboard Unified | Terintegrasi |
| ✅ Role-Based Access | Terintegrasi |
| ✅ Export PDF | Terintegrasi |

## 📝 Notes

- Semua modul berjalan dalam satu aplikasi unified
- Single login system untuk semua modul
- Role-based access control terintegrasi
- Dashboard menampilkan statistik dari ketiga modul

---

## 🆘 Butuh Bantuan?

1. **Baca panduan lengkap**: [PANDUAN_INSTALASI_DAN_PENGGUNAAN.md](PANDUAN_INSTALASI_DAN_PENGGUNAAN.md)
2. **Cek troubleshooting**: Lihat bagian Troubleshooting di panduan lengkap
3. **Quick start**: [QUICK_START.md](QUICK_START.md)

---

**Dibuat dengan ❤️ untuk Masjid Al-Ikhlas**

*Terakhir diperbarui: 2025*
