-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 02, 2025 at 11:05 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manpro`
--

-- --------------------------------------------------------

--
-- Table structure for table `artikel`
--

CREATE TABLE `artikel` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text DEFAULT NULL,
  `penulis` varchar(255) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dana_dkm`
--

CREATE TABLE `dana_dkm` (
  `ID_DKM` int(11) NOT NULL,
  `Sumber_dana` varchar(255) DEFAULT NULL,
  `Jumlah_dana` decimal(10,2) DEFAULT NULL,
  `Tanggal_masuk` date DEFAULT NULL,
  `Keterangan` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dana_operasional`
--

CREATE TABLE `dana_operasional` (
  `ID_Operasional` int(11) NOT NULL,
  `Keperluan` varchar(255) DEFAULT NULL,
  `Jumlah_Pengeluaran` decimal(10,2) DEFAULT NULL,
  `Tanggal_Pengeluaran` date DEFAULT NULL,
  `Keterangan` text DEFAULT NULL,
  `ID_DKM` int(11) DEFAULT NULL,
  `ID_User` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `distribusi_daging`
--

CREATE TABLE `distribusi_daging` (
  `ID_Distribusi` int(11) NOT NULL,
  `ID_Hewan` int(11) NOT NULL,
  `ID_Penerima` int(11) NOT NULL,
  `Tanggal_Distribusi` date DEFAULT NULL,
  `Penerima` varchar(255) DEFAULT NULL,
  `Dokumentasi` varchar(255) DEFAULT NULL,
  `Status_Distribusi` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int(11) NOT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `jenis_kegiatan` varchar(100) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `kuota` int(11) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `status` enum('draft','published','cancelled') DEFAULT 'draft',
  `rule` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hewan_kurban`
--

CREATE TABLE `hewan_kurban` (
  `ID_Hewan` int(11) NOT NULL,
  `ID_Jadwal` int(11) NOT NULL,
  `Jenis_Hewan` varchar(50) DEFAULT NULL,
  `Status_Hewan` varchar(20) DEFAULT NULL,
  `ID_User` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventaris`
--

CREATE TABLE `inventaris` (
  `id_asset` int(11) NOT NULL,
  `nama_asset` varchar(255) NOT NULL,
  `jenis_asset` varchar(100) DEFAULT NULL,
  `kondisi` enum('baik','rusak','perlu perbaikan') DEFAULT 'baik',
  `tahun_peroleh` year(4) DEFAULT NULL,
  `status` enum('aktif','tidak aktif','dihapus') DEFAULT 'aktif',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jabatan`
--

CREATE TABLE `jabatan` (
  `id` int(11) NOT NULL,
  `nama_jabatan` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_penyembelih`
--

CREATE TABLE `jadwal_penyembelih` (
  `ID_Jadwal` int(11) NOT NULL,
  `Foto_Dokumentasi` varchar(255) DEFAULT NULL,
  `Nama_Penyembelih` varchar(255) DEFAULT NULL,
  `Waktu_Penyembelih` datetime DEFAULT NULL,
  `Lokasi_Penyembelih` varchar(255) DEFAULT NULL,
  `ID_Operasional` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_piket`
--

CREATE TABLE `jadwal_piket` (
  `id` int(11) NOT NULL,
  `pengurus_id` int(11) NOT NULL,
  `tanggal_tugas` date NOT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `lokasi_tugas` varchar(100) DEFAULT NULL,
  `jenis_tugas` varchar(100) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `status_tugas` enum('belum mulai','dalam pengerjaan','selesai') DEFAULT 'belum mulai',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_sholat`
--

CREATE TABLE `jadwal_sholat` (
  `id` int(11) NOT NULL,
  `subuh` time DEFAULT NULL,
  `dzuhur` time DEFAULT NULL,
  `ashar` time DEFAULT NULL,
  `maghrib` time DEFAULT NULL,
  `isya` time DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laporan_perawatan`
--

CREATE TABLE `laporan_perawatan` (
  `id_laporan` int(11) NOT NULL,
  `id_perawatan` int(11) NOT NULL,
  `id_asset` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal_laporan` date DEFAULT NULL,
  `hasil` text DEFAULT NULL,
  `status_barang` enum('siap pakai','perlu perbaikan lanjutan','tidak bisa diperbaiki') DEFAULT 'siap pakai',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mustahik`
--

CREATE TABLE `mustahik` (
  `id_mustahik` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `kategori_mustahik` varchar(50) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `surat_dtks` varchar(255) DEFAULT NULL,
  `status` enum('aktif','non-aktif') DEFAULT 'aktif',
  `password` varchar(255) DEFAULT NULL,
  `tgl_daftar` datetime DEFAULT current_timestamp(),
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `muzakki`
--

CREATE TABLE `muzakki` (
  `id_muzakki` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `tgl_daftar` datetime DEFAULT current_timestamp(),
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `metode` enum('email','whatsapp','push') DEFAULT 'push',
  `status` enum('pending','sent','failed') DEFAULT 'pending',
  `waktu_kirim` datetime DEFAULT NULL,
  `target_jemaah_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penerima_kurban`
--

CREATE TABLE `penerima_kurban` (
  `ID_Penerima` int(11) NOT NULL,
  `Nama` varchar(255) NOT NULL,
  `Tempat_Tinggal` varchar(255) DEFAULT NULL,
  `Tanggal_Terima` date DEFAULT NULL,
  `ID_User` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengajuan_event`
--

CREATE TABLE `pengajuan_event` (
  `pengajuan_event_id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `rule_usulan` text DEFAULT NULL,
  `tgl_mulai_usulan` date DEFAULT NULL,
  `tgl_selesai_usulan` date DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `catatan` text DEFAULT NULL,
  `jemaah_id` int(11) NOT NULL,
  `diinput_oleh_jemaah_id` int(11) NOT NULL,
  `approved_by_jemaah_id` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isi` text DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penugasan_tugas`
--

CREATE TABLE `penugasan_tugas` (
  `id` int(11) NOT NULL,
  `tugas_id` int(11) NOT NULL,
  `pengurus_id` int(11) NOT NULL,
  `tanggal_ditugaskan` date NOT NULL,
  `status` enum('belum mulai','dalam pengerjaan','selesai') DEFAULT 'belum mulai',
  `catatan` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penyaluran`
--

CREATE TABLE `penyaluran` (
  `id_penyaluran` int(11) NOT NULL,
  `id_zis` int(11) NOT NULL,
  `tgl_salur` date DEFAULT NULL,
  `jumlah` decimal(10,2) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `id_mustahik` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `perawatan`
--

CREATE TABLE `perawatan` (
  `id_perawatan` int(11) NOT NULL,
  `id_asset` int(11) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `jenis_perawatan` varchar(100) DEFAULT NULL,
  `status` enum('sedang berjalan','selesai','ditunda') DEFAULT 'sedang berjalan',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peserta_event`
--

CREATE TABLE `peserta_event` (
  `peserta_event_id` int(11) NOT NULL,
  `status_daftar` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `registered_at` datetime DEFAULT NULL,
  `status_hadir` enum('hadir','tidak hadir','belum diketahui') DEFAULT 'belum diketahui',
  `checkin_at` datetime DEFAULT NULL,
  `checkout_at` datetime DEFAULT NULL,
  `marked_at` datetime DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `jemaah_id` int(11) NOT NULL,
  `sesi_event_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `petugas_zis`
--

CREATE TABLE `petugas_zis` (
  `id_petugas_zis` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `tgl_daftar` datetime DEFAULT current_timestamp(),
  `id_user` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_jabatan`
--

CREATE TABLE `riwayat_jabatan` (
  `id` int(11) NOT NULL,
  `pengurus_id` int(11) NOT NULL,
  `jabatan_id` int(11) NOT NULL,
  `periode_awal` date DEFAULT NULL,
  `periode_akhir` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `keterangan` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sesi_event`
--

CREATE TABLE `sesi_event` (
  `sesi_event_id` int(11) NOT NULL,
  `start_at` datetime DEFAULT NULL,
  `end_at` datetime DEFAULT NULL,
  `title_override` varchar(255) DEFAULT NULL,
  `location_override` varchar(255) DEFAULT NULL,
  `published` tinyint(1) DEFAULT 0,
  `meta` text DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tugas_tanggung_jawab`
--

CREATE TABLE `tugas_tanggung_jawab` (
  `id` int(11) NOT NULL,
  `jabatan_id` int(11) NOT NULL,
  `nama_tugas` varchar(150) NOT NULL,
  `deskripsi_tugas` text DEFAULT NULL,
  `prioritas` enum('tinggi','sedang','rendah') DEFAULT 'sedang',
  `tanggal_ditambahkan` datetime DEFAULT current_timestamp(),
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('jemaah','pengurus','admin') DEFAULT 'jemaah',
  `status_aktif` enum('aktif','tidak aktif') DEFAULT 'aktif',
  `tanggal_daftar` datetime DEFAULT current_timestamp(),
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zis_masuk`
--

CREATE TABLE `zis_masuk` (
  `id_zis` int(11) NOT NULL,
  `id_muzakki` int(11) NOT NULL,
  `tgl_masuk` date DEFAULT NULL,
  `jenis_zis` enum('zakat','infaq','shadaqah','wakaf') DEFAULT NULL,
  `jumlah` decimal(10,2) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `artikel`
--
ALTER TABLE `artikel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `dana_dkm`
--
ALTER TABLE `dana_dkm`
  ADD PRIMARY KEY (`ID_DKM`);

--
-- Indexes for table `dana_operasional`
--
ALTER TABLE `dana_operasional`
  ADD PRIMARY KEY (`ID_Operasional`),
  ADD KEY `ID_DKM` (`ID_DKM`),
  ADD KEY `ID_User` (`ID_User`);

--
-- Indexes for table `distribusi_daging`
--
ALTER TABLE `distribusi_daging`
  ADD PRIMARY KEY (`ID_Distribusi`),
  ADD KEY `ID_Hewan` (`ID_Hewan`),
  ADD KEY `ID_Penerima` (`ID_Penerima`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `hewan_kurban`
--
ALTER TABLE `hewan_kurban`
  ADD PRIMARY KEY (`ID_Hewan`),
  ADD KEY `ID_Jadwal` (`ID_Jadwal`),
  ADD KEY `ID_User` (`ID_User`);

--
-- Indexes for table `inventaris`
--
ALTER TABLE `inventaris`
  ADD PRIMARY KEY (`id_asset`);

--
-- Indexes for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `jadwal_penyembelih`
--
ALTER TABLE `jadwal_penyembelih`
  ADD PRIMARY KEY (`ID_Jadwal`),
  ADD KEY `ID_Operasional` (`ID_Operasional`);

--
-- Indexes for table `jadwal_piket`
--
ALTER TABLE `jadwal_piket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengurus_id` (`pengurus_id`);

--
-- Indexes for table `jadwal_sholat`
--
ALTER TABLE `jadwal_sholat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laporan_perawatan`
--
ALTER TABLE `laporan_perawatan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `id_perawatan` (`id_perawatan`),
  ADD KEY `id_asset` (`id_asset`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `mustahik`
--
ALTER TABLE `mustahik`
  ADD PRIMARY KEY (`id_mustahik`);

--
-- Indexes for table `muzakki`
--
ALTER TABLE `muzakki`
  ADD PRIMARY KEY (`id_muzakki`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `target_jemaah_id` (`target_jemaah_id`);

--
-- Indexes for table `penerima_kurban`
--
ALTER TABLE `penerima_kurban`
  ADD PRIMARY KEY (`ID_Penerima`),
  ADD KEY `ID_User` (`ID_User`);

--
-- Indexes for table `pengajuan_event`
--
ALTER TABLE `pengajuan_event`
  ADD PRIMARY KEY (`pengajuan_event_id`),
  ADD KEY `jemaah_id` (`jemaah_id`),
  ADD KEY `diinput_oleh_jemaah_id` (`diinput_oleh_jemaah_id`),
  ADD KEY `approved_by_jemaah_id` (`approved_by_jemaah_id`);

--
-- Indexes for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `penugasan_tugas`
--
ALTER TABLE `penugasan_tugas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tugas_id` (`tugas_id`),
  ADD KEY `pengurus_id` (`pengurus_id`);

--
-- Indexes for table `penyaluran`
--
ALTER TABLE `penyaluran`
  ADD PRIMARY KEY (`id_penyaluran`),
  ADD KEY `id_zis` (`id_zis`),
  ADD KEY `id_mustahik` (`id_mustahik`);

--
-- Indexes for table `perawatan`
--
ALTER TABLE `perawatan`
  ADD PRIMARY KEY (`id_perawatan`),
  ADD KEY `id_asset` (`id_asset`);

--
-- Indexes for table `peserta_event`
--
ALTER TABLE `peserta_event`
  ADD PRIMARY KEY (`peserta_event_id`),
  ADD KEY `jemaah_id` (`jemaah_id`),
  ADD KEY `sesi_event_id` (`sesi_event_id`);

--
-- Indexes for table `petugas_zis`
--
ALTER TABLE `petugas_zis`
  ADD PRIMARY KEY (`id_petugas_zis`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `riwayat_jabatan`
--
ALTER TABLE `riwayat_jabatan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengurus_id` (`pengurus_id`),
  ADD KEY `jabatan_id` (`jabatan_id`);

--
-- Indexes for table `sesi_event`
--
ALTER TABLE `sesi_event`
  ADD PRIMARY KEY (`sesi_event_id`),
  ADD KEY `event_id` (`event_id`);

--
-- Indexes for table `tugas_tanggung_jawab`
--
ALTER TABLE `tugas_tanggung_jawab`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jabatan_id` (`jabatan_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_username` (`username`),
  ADD KEY `idx_role` (`role`),
  ADD KEY `idx_status` (`status_aktif`);

--
-- Indexes for table `zis_masuk`
--
ALTER TABLE `zis_masuk`
  ADD PRIMARY KEY (`id_zis`),
  ADD KEY `id_muzakki` (`id_muzakki`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `artikel`
--
ALTER TABLE `artikel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dana_dkm`
--
ALTER TABLE `dana_dkm`
  MODIFY `ID_DKM` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dana_operasional`
--
ALTER TABLE `dana_operasional`
  MODIFY `ID_Operasional` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `distribusi_daging`
--
ALTER TABLE `distribusi_daging`
  MODIFY `ID_Distribusi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hewan_kurban`
--
ALTER TABLE `hewan_kurban`
  MODIFY `ID_Hewan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventaris`
--
ALTER TABLE `inventaris`
  MODIFY `id_asset` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jabatan`
--
ALTER TABLE `jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_penyembelih`
--
ALTER TABLE `jadwal_penyembelih`
  MODIFY `ID_Jadwal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_piket`
--
ALTER TABLE `jadwal_piket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwal_sholat`
--
ALTER TABLE `jadwal_sholat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laporan_perawatan`
--
ALTER TABLE `laporan_perawatan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mustahik`
--
ALTER TABLE `mustahik`
  MODIFY `id_mustahik` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `muzakki`
--
ALTER TABLE `muzakki`
  MODIFY `id_muzakki` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penerima_kurban`
--
ALTER TABLE `penerima_kurban`
  MODIFY `ID_Penerima` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengajuan_event`
--
ALTER TABLE `pengajuan_event`
  MODIFY `pengajuan_event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penugasan_tugas`
--
ALTER TABLE `penugasan_tugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `penyaluran`
--
ALTER TABLE `penyaluran`
  MODIFY `id_penyaluran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `perawatan`
--
ALTER TABLE `perawatan`
  MODIFY `id_perawatan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peserta_event`
--
ALTER TABLE `peserta_event`
  MODIFY `peserta_event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `petugas_zis`
--
ALTER TABLE `petugas_zis`
  MODIFY `id_petugas_zis` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `riwayat_jabatan`
--
ALTER TABLE `riwayat_jabatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sesi_event`
--
ALTER TABLE `sesi_event`
  MODIFY `sesi_event_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tugas_tanggung_jawab`
--
ALTER TABLE `tugas_tanggung_jawab`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zis_masuk`
--
ALTER TABLE `zis_masuk`
  MODIFY `id_zis` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artikel`
--
ALTER TABLE `artikel`
  ADD CONSTRAINT `artikel_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `berita`
--
ALTER TABLE `berita`
  ADD CONSTRAINT `berita_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `dana_operasional`
--
ALTER TABLE `dana_operasional`
  ADD CONSTRAINT `dana_operasional_ibfk_1` FOREIGN KEY (`ID_DKM`) REFERENCES `dana_dkm` (`ID_DKM`),
  ADD CONSTRAINT `dana_operasional_ibfk_2` FOREIGN KEY (`ID_User`) REFERENCES `users` (`id`);

--
-- Constraints for table `distribusi_daging`
--
ALTER TABLE `distribusi_daging`
  ADD CONSTRAINT `distribusi_daging_ibfk_1` FOREIGN KEY (`ID_Hewan`) REFERENCES `hewan_kurban` (`ID_Hewan`),
  ADD CONSTRAINT `distribusi_daging_ibfk_2` FOREIGN KEY (`ID_Penerima`) REFERENCES `penerima_kurban` (`ID_Penerima`);

--
-- Constraints for table `hewan_kurban`
--
ALTER TABLE `hewan_kurban`
  ADD CONSTRAINT `hewan_kurban_ibfk_1` FOREIGN KEY (`ID_Jadwal`) REFERENCES `jadwal_penyembelih` (`ID_Jadwal`),
  ADD CONSTRAINT `hewan_kurban_ibfk_2` FOREIGN KEY (`ID_User`) REFERENCES `users` (`id`);

--
-- Constraints for table `jabatan`
--
ALTER TABLE `jabatan`
  ADD CONSTRAINT `jabatan_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `jabatan` (`id`);

--
-- Constraints for table `jadwal_penyembelih`
--
ALTER TABLE `jadwal_penyembelih`
  ADD CONSTRAINT `jadwal_penyembelih_ibfk_1` FOREIGN KEY (`ID_Operasional`) REFERENCES `dana_operasional` (`ID_Operasional`);

--
-- Constraints for table `jadwal_piket`
--
ALTER TABLE `jadwal_piket`
  ADD CONSTRAINT `jadwal_piket_ibfk_1` FOREIGN KEY (`pengurus_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `laporan_perawatan`
--
ALTER TABLE `laporan_perawatan`
  ADD CONSTRAINT `laporan_perawatan_ibfk_1` FOREIGN KEY (`id_perawatan`) REFERENCES `perawatan` (`id_perawatan`),
  ADD CONSTRAINT `laporan_perawatan_ibfk_2` FOREIGN KEY (`id_asset`) REFERENCES `inventaris` (`id_asset`),
  ADD CONSTRAINT `laporan_perawatan_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `notifikasi_ibfk_1` FOREIGN KEY (`target_jemaah_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `penerima_kurban`
--
ALTER TABLE `penerima_kurban`
  ADD CONSTRAINT `penerima_kurban_ibfk_1` FOREIGN KEY (`ID_User`) REFERENCES `users` (`id`);

--
-- Constraints for table `pengajuan_event`
--
ALTER TABLE `pengajuan_event`
  ADD CONSTRAINT `pengajuan_event_ibfk_1` FOREIGN KEY (`jemaah_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pengajuan_event_ibfk_2` FOREIGN KEY (`diinput_oleh_jemaah_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pengajuan_event_ibfk_3` FOREIGN KEY (`approved_by_jemaah_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD CONSTRAINT `pengumuman_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `penugasan_tugas`
--
ALTER TABLE `penugasan_tugas`
  ADD CONSTRAINT `penugasan_tugas_ibfk_1` FOREIGN KEY (`tugas_id`) REFERENCES `tugas_tanggung_jawab` (`id`),
  ADD CONSTRAINT `penugasan_tugas_ibfk_2` FOREIGN KEY (`pengurus_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `penyaluran`
--
ALTER TABLE `penyaluran`
  ADD CONSTRAINT `penyaluran_ibfk_1` FOREIGN KEY (`id_zis`) REFERENCES `zis_masuk` (`id_zis`),
  ADD CONSTRAINT `penyaluran_ibfk_2` FOREIGN KEY (`id_mustahik`) REFERENCES `mustahik` (`id_mustahik`);

--
-- Constraints for table `perawatan`
--
ALTER TABLE `perawatan`
  ADD CONSTRAINT `perawatan_ibfk_1` FOREIGN KEY (`id_asset`) REFERENCES `inventaris` (`id_asset`);

--
-- Constraints for table `peserta_event`
--
ALTER TABLE `peserta_event`
  ADD CONSTRAINT `peserta_event_ibfk_1` FOREIGN KEY (`jemaah_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `peserta_event_ibfk_2` FOREIGN KEY (`sesi_event_id`) REFERENCES `sesi_event` (`sesi_event_id`);

--
-- Constraints for table `petugas_zis`
--
ALTER TABLE `petugas_zis`
  ADD CONSTRAINT `petugas_zis_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `riwayat_jabatan`
--
ALTER TABLE `riwayat_jabatan`
  ADD CONSTRAINT `riwayat_jabatan_ibfk_1` FOREIGN KEY (`pengurus_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `riwayat_jabatan_ibfk_2` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`);

--
-- Constraints for table `sesi_event`
--
ALTER TABLE `sesi_event`
  ADD CONSTRAINT `sesi_event_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`);

--
-- Constraints for table `tugas_tanggung_jawab`
--
ALTER TABLE `tugas_tanggung_jawab`
  ADD CONSTRAINT `tugas_tanggung_jawab_ibfk_1` FOREIGN KEY (`jabatan_id`) REFERENCES `jabatan` (`id`);

--
-- Constraints for table `zis_masuk`
--
ALTER TABLE `zis_masuk`
  ADD CONSTRAINT `zis_masuk_ibfk_1` FOREIGN KEY (`id_muzakki`) REFERENCES `muzakki` (`id_muzakki`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
