# 🚀 QUICK START - INFORMASI & PENGUMUMAN

## ✅ MODUL SUDAH 100% SIAP PAKAI!

---

## 🔑 TESTING

### 1. Refresh Browser
```
Tekan Ctrl + F5 untuk force refresh
```

### 2. Login & Akses Menu
Di **sidebar kiri** akan ada 2 menu baru di bagian **"Informasi"**:
- 📰 **Artikel & Pengumuman**
- 🕌 **Jadwal Sholat**

---

## 🎯 SKENARIO PENGGUNAAN

### Skenario 1: MEMBUAT PENGUMUMAN BARU

**Contoh: Pengumuman Kajian Ramadhan**

1. Klik **"Artikel & Pengumuman"** → **"Tambah Artikel"**
2. Isi form:
   - **Judul**: `Kajian Ramadhan 1447 H`
   - **Deskripsi**: `Kajian bulan Ramadhan akan dilaksanakan setiap malam ba'da Tarawih`
   - **Konten**: `Tema kajian: "Meraih Malam Lailatul Qadar". Pembicara: Ustadz Dr. Ahmad Syakir. Tempat: Masjid Al-Nassr. Waktu: 20:00 - 21:00 WIB`
   - **URL Gambar**: (Opsional) Link gambar poster
   - **Urutan**: `1` (tampil paling atas)
   - **Status**: ✅ Aktif
3. Klik **"Simpan"**
4. ✅ Pengumuman muncul di daftar!

---

### Skenario 2: UPDATE JADWAL SHOLAT

**Contoh: Update Jadwal karena Perubahan Musim**

1. Klik **"Jadwal Sholat"**
2. Lihat jadwal hari ini di bagian atas
3. Scroll ke tabel jadwal mingguan
4. Klik **"✏️ Edit"** pada waktu "Subuh"
5. Update waktu untuk 7 hari:
   - **Senin**: `04:25:00`
   - **Selasa**: `04:25:00`
   - **Rabu**: `04:26:00`
   - **Kamis**: `04:26:00`
   - **Jumat**: `04:27:00`
   - **Sabtu**: `04:27:00`
   - **Minggu**: `04:28:00`
6. Klik **"Update Jadwal"**
7. ✅ Jadwal terupdate!

---

### Skenario 3: MENGATUR URUTAN ARTIKEL

**Artikel yang penting tampil di atas**

1. Klik **"Artikel & Pengumuman"**
2. Klik **"✏️ Edit"** pada artikel penting
3. Ubah **Urutan** menjadi `1` (paling atas)
4. Artikel lain diberi urutan `2`, `3`, dst
5. Klik **"Update"**
6. ✅ Artikel tampil sesuai urutan!

---

### Skenario 4: MENONAKTIFKAN ARTIKEL LAMA

**Pengumuman sudah lewat, jangan ditampilkan lagi**

1. Klik **"Artikel & Pengumuman"**
2. Klik **"✏️ Edit"** pada artikel lama
3. **Hilangkan centang** pada "Aktif"
4. Klik **"Update"**
5. ✅ Artikel tidak tampil di daftar (tapi tidak dihapus)

---

## 📱 FITUR PENTING

### ✅ Artikel & Pengumuman
- **Pagination**: Otomatis jika artikel > 10
- **Urutan Tampil**: Semakin kecil angka = semakin atas
- **Status Aktif**: Control publikasi tanpa hapus data
- **Link Gambar**: Support URL gambar dari internet
- **Link Eksternal**: Redirect ke website lain
- **Rich Content**: Konten lengkap dengan paragraf

### ✅ Jadwal Sholat
- **Auto-Highlight Hari Ini**: Kolom hari aktif berwarna abu-abu
- **Update per Waktu**: Edit Subuh, Dzuhur, Ashar, Maghrib, Isya terpisah
- **Format 24 Jam**: HH:MM (04:26, bukan 4:26 AM)
- **Tampil di Dashboard**: Jadwal hari ini di card atas (jika ada)

---

## 🔍 TIPS & TRIK

### 📰 Untuk Artikel

**1. Judul yang Menarik**
```
✅ GOOD: "Penyembelihan Hewan Kurban Hari Raya Idul Adha 1447 H"
❌ BAD: "Kurban"
```

**2. Deskripsi Singkat & Jelas**
```
✅ GOOD: "Pendaftaran kurban dibuka 1 Jan - 1 Jun. Hub. DKM untuk info harga."
❌ BAD: "Kurban dibuka."
```

**3. Gunakan Konten Lengkap untuk Detail**
- Deskripsi = Ringkasan (muncul di daftar)
- Konten = Detail lengkap (muncul di halaman detail)

**4. Urutan Prioritas**
```
1 = Pengumuman URGENT (paling atas)
2 = Pengumuman Penting
3 = Info Biasa
4+ = Info Lama
```

### 🕌 Untuk Jadwal Sholat

**1. Update Berkala**
- Update setiap bulan mengikuti pergerakan matahari
- Biasanya berubah 1-2 menit per minggu

**2. Waktu Jamaah vs Waktu Adzan**
- Simpan waktu **adzan** di database
- Jamaah biasanya 5-10 menit setelah adzan

**3. Koordinasi dengan Muadzin**
- Pastikan jadwal di sistem = jadwal muadzin
- Update segera jika ada perubahan

---

## 🛠️ TROUBLESHOOTING

### Menu Tidak Muncul
```bash
php artisan optimize:clear
```

### Data Tidak Muncul
```bash
php artisan db:seed --class=InformasiPengumumanSeeder
```

### Error 500 saat Akses
```bash
php artisan cache:clear
php artisan view:clear
```

---

## 📊 STATISTIK AWAL

Setelah seeding, Anda punya:
- **4 Artikel** (Kurban, Gotong Royong, Kajian, TPA)
- **5 Jadwal Sholat** (Subuh s/d Isya)
- **1 Info Masjid** (Al-Nassr)

---

## 🎉 SELAMAT MENGGUNAKAN!

Modul Informasi & Pengumuman ini dirancang untuk:
✅ Mempermudah penyebaran informasi ke jemaah
✅ Update jadwal sholat secara real-time
✅ Manajemen pengumuman dengan mudah
✅ Integrasi dengan sistem masjid yang ada

**Jika ada pertanyaan atau butuh bantuan, silakan hubungi developer.**

---

**Dibuat dengan ❤️ untuk kemudahan komunikasi di masjid** 🕌



