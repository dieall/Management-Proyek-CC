# 🚀 QUICK START GUIDE - ZIS MANAGEMENT

## ✅ SISTEM SUDAH 100% SIAP PAKAI!

---

## 🔑 LOGIN & AKSES

### Login sebagai Admin:
```
Email/Username: admin@gmail.com atau admin
Password: password
```

### Akses Menu ZIS:
Setelah login, di **sidebar kiri** akan ada 4 menu baru:
1. 📊 **Muzakki** (Pemberi Zakat)
2. 👥 **Mustahik** (Penerima Zakat)
3. 💰 **ZIS Masuk** (Dana Masuk)
4. 📤 **Penyaluran** (Distribusi Dana)

---

## 🎯 SKENARIO PENGGUNAAN

### Skenario 1: INPUT ZAKAT DARI MUZAKKI BARU

**Langkah 1: Registrasi Muzakki**
1. Klik menu **"Muzakki"** → Tombol **"Tambah Muzakki"**
2. Isi data:
   - Nama: `Abdullah Rahman`
   - Alamat: `Jl. Merdeka No. 100, Jakarta`
   - No HP: `081234567890`
3. Klik **"Simpan"**
4. Status akan otomatis "Menunggu"
5. Klik tombol **✓ (Setujui)** untuk approve

**Langkah 2: Input ZIS dari Muzakki**
1. Klik menu **"ZIS Masuk"** → Tombol **"Input ZIS"**
2. Isi data:
   - Muzakki: Pilih `Abdullah Rahman`
   - Tanggal: `(hari ini)`
   - Jenis ZIS: `Zakat`
   - Sub Jenis: `Zakat Fitrah`
   - Jumlah: `500000`
   - Keterangan: `Zakat fitrah untuk keluarga`
3. Klik **"Simpan"**
4. ✅ Dana masuk tercatat!

---

### Skenario 2: REGISTRASI MUSTAHIK & PENYALURAN

**Langkah 1: Registrasi Mustahik**
1. Klik menu **"Mustahik"** → Tombol **"Tambah Mustahik"**
2. Isi data:
   - Nama: `Siti Maryam`
   - Alamat: `Jl. Raya No. 50, Bandung`
   - Kategori: Pilih `Fakir`
   - No HP: `082345678901`
   - Status Verifikasi: `Disetujui`
   - Status: `Aktif`
3. (Opsional) Upload Surat DTKS
4. Klik **"Simpan"**

**Langkah 2: Salurkan Dana ke Mustahik**
1. Klik menu **"Penyaluran"** → Tombol **"Salurkan Dana"**
2. Isi data:
   - Dari ZIS: Pilih `Abdullah Rahman - Zakat - Rp 500.000`
   - Kepada Mustahik: Pilih `Siti Maryam - Fakir`
   - Tanggal: `(hari ini)`
   - Jumlah: `200000`
   - Keterangan: `Bantuan kebutuhan sehari-hari`
3. Klik **"Simpan"**
4. ✅ Penyaluran berhasil!

---

### Skenario 3: CEK STATISTIK & LAPORAN

**Dashboard ZIS Masuk**
1. Klik menu **"ZIS Masuk"**
2. Lihat 4 card statistik di atas:
   - 💰 Total ZIS
   - 🕌 Total Zakat
   - 💚 Total Infaq
   - 🌟 Total Shadaqah + Wakaf

**Detail Muzakki**
1. Klik menu **"Muzakki"**
2. Klik tombol **👁️ (Lihat)** pada muzakki tertentu
3. Lihat:
   - Info lengkap muzakki
   - Statistik total ZIS per jenis
   - Riwayat semua ZIS yang diberikan

**Detail Mustahik**
1. Klik menu **"Mustahik"**
2. Klik tombol **👁️ (Lihat)** pada mustahik tertentu
3. Lihat:
   - Info lengkap mustahik
   - Statistik total penerimaan
   - Riwayat semua bantuan yang diterima

**Detail ZIS Masuk**
1. Klik menu **"ZIS Masuk"**
2. Klik tombol **👁️ (Lihat)** pada ZIS tertentu
3. Lihat:
   - Info lengkap ZIS dari muzakki
   - Status penyaluran
   - Sisa dana yang belum disalurkan
   - Riwayat penyaluran

---

## 📊 DATA DUMMY UNTUK TESTING

### Muzakki yang Sudah Ada:
1. **Ahmad Ibrahim** (Disetujui)
   - Total ZIS: Rp 15.500.000
   - 3 transaksi (Zakat Fitrah, Zakat Mal, Wakaf)

2. **Siti Aminah** (Disetujui)
   - Total ZIS: Rp 2.300.000
   - 2 transaksi (Infaq, Zakat Fitrah)

3. **Muhammad Hasan** (Disetujui)
   - Total ZIS: Rp 2.000.000
   - 2 transaksi (Shadaqah, Infaq Jumat)

4. **Fatimah Zahra** (Menunggu Approval)
   - Belum ada transaksi

### Mustahik yang Sudah Ada:
1. **Budi Santoso** (Fakir - Disetujui)
   - Total Penerimaan: Rp 1.200.000
   - 2 penyaluran

2. **Dewi Lestari** (Miskin - Disetujui)
   - Total Penerimaan: Rp 350.000
   - 2 penyaluran

3. **Hendra Wijaya** (Gharim - Disetujui)
   - Total Penerimaan: Rp 3.000.000
   - 1 penyaluran (pelunasan hutang)

4. **Rina Kartika** (Ibnu Sabil - Pending)
   - Belum ada penyaluran

5. **Yusuf Abdullah** (Fisabillillah - Disetujui)
   - Total Penerimaan: Rp 1.500.000
   - 1 penyaluran (dakwah & pendidikan)

---

## 🔍 FITUR PENTING

### ✅ Validasi Otomatis
- Sistem akan cek **sisa dana** saat penyaluran
- Tidak bisa menyalurkan lebih dari sisa dana
- Alert jika dana tidak cukup

### ✅ Tracking Lengkap
- Dari **Muzakki** → bisa lihat semua ZIS yang diberikan
- Dari **ZIS Masuk** → bisa lihat ke mana saja dana disalurkan
- Dari **Mustahik** → bisa lihat semua bantuan yang diterima
- Dari **Penyaluran** → bisa lihat detail lengkap transaksi

### ✅ Statistik Real-time
- Dashboard ZIS: Update otomatis setiap ada input baru
- Detail Muzakki: Total per jenis ZIS
- Detail Mustahik: Total penerimaan
- Detail ZIS: Sisa dana yang belum disalurkan

### ✅ 8 Kategori Mustahik (Asnaf)
1. **Fakir** - Orang yang tidak memiliki harta & pekerjaan
2. **Miskin** - Orang yang memiliki pekerjaan tapi tidak cukup
3. **Amil** - Pengurus zakat
4. **Muallaf** - Orang yang baru masuk Islam
5. **Riqab** - Budak yang ingin merdeka
6. **Gharim** - Orang yang berhutang
7. **Fisabillillah** - Orang yang berjuang di jalan Allah
8. **Ibnu Sabil** - Musafir yang kehabisan bekal

### ✅ 4 Jenis ZIS
1. **Zakat** - Fitrah, Mal (Harta), dll
2. **Infaq** - Umum, Jumat, dll
3. **Shadaqah** - Jariyah, dll
4. **Wakaf** - Tunai, Tanah, dll

---

## 🛠️ TROUBLESHOOTING

### Jika Menu ZIS Tidak Muncul:
```bash
php artisan route:clear
php artisan config:clear
php artisan view:clear
```

### Jika Data Tidak Muncul:
```bash
php artisan db:seed --class=ZISManagementSeeder
```

### Jika Ada Error 500:
```bash
php artisan cache:clear
php artisan config:cache
```

---

## 📱 CONTOH WORKFLOW HARIAN

### Pagi Hari (Cek Dashboard)
1. Login sebagai Admin
2. Klik menu **"ZIS Masuk"**
3. Lihat statistik total dana masuk
4. Cek apakah ada muzakki baru yang perlu diapprove

### Siang Hari (Input ZIS)
1. Jika ada muzakki datang membayar zakat
2. Klik menu **"ZIS Masuk"** → **"Input ZIS"**
3. Pilih muzakki (atau tambah baru jika belum terdaftar)
4. Input detail ZIS
5. Print bukti (coming soon)

### Sore Hari (Penyaluran)
1. Klik menu **"Penyaluran"**
2. Cek daftar mustahik yang perlu bantuan
3. Salurkan dana sesuai kebutuhan
4. Dokumentasi penyaluran

### Akhir Bulan (Laporan)
1. Klik menu **"ZIS Masuk"** → Export Excel (coming soon)
2. Klik menu **"Penyaluran"** → Export PDF (coming soon)
3. Review statistik total ZIS vs Penyaluran

---

## 🎉 SELAMAT MENGGUNAKAN!

Sistem ZIS Management ini dirancang untuk mempermudah pengelolaan zakat, infaq, shadaqah, dan wakaf di masjid Anda.

**Jika ada pertanyaan atau butuh bantuan, silakan hubungi developer.**

---

**Dibuat dengan ❤️ untuk kemudahan beribadah** 🕌









