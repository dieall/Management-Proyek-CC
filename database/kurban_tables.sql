-- Migration untuk tabel Kurban
-- Database: minpri

-- Tabel Kurban
CREATE TABLE IF NOT EXISTS `kurban` (
    `id_kurban` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nama_kurban` VARCHAR(255) NOT NULL,
    `tanggal_kurban` DATE NOT NULL,
    `jenis_hewan` ENUM('sapi', 'kambing', 'domba') NOT NULL DEFAULT 'sapi',
    `target_hewan` INT NOT NULL DEFAULT 1,
    `harga_per_hewan` DECIMAL(15, 2) NOT NULL,
    `deskripsi` TEXT NULL,
    `status` ENUM('aktif', 'selesai', 'dibatalkan') NOT NULL DEFAULT 'aktif',
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id_kurban`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel Riwayat Kurban (Pendaftaran)
CREATE TABLE IF NOT EXISTS `riwayat_kurban` (
    `id_riwayat_kurban` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `id_kurban` BIGINT UNSIGNED NOT NULL,
    `id_jamaah` BIGINT UNSIGNED NOT NULL,
    `jenis_pembayaran` ENUM('penuh', 'patungan') NOT NULL DEFAULT 'penuh',
    `jumlah_hewan` INT NOT NULL DEFAULT 1,
    `jumlah_pembayaran` DECIMAL(15, 2) NOT NULL,
    `tanggal_pembayaran` DATE NOT NULL,
    `status_pembayaran` ENUM('lunas', 'cicilan', 'belum_lunas') NOT NULL DEFAULT 'belum_lunas',
    `keterangan` TEXT NULL,
    `created_at` TIMESTAMP NULL DEFAULT NULL,
    `updated_at` TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (`id_riwayat_kurban`),
    KEY `riwayat_kurban_id_kurban_index` (`id_kurban`),
    KEY `riwayat_kurban_id_jamaah_index` (`id_jamaah`),
    CONSTRAINT `riwayat_kurban_id_kurban_foreign` FOREIGN KEY (`id_kurban`) REFERENCES `kurban` (`id_kurban`) ON DELETE CASCADE,
    CONSTRAINT `riwayat_kurban_id_jamaah_foreign` FOREIGN KEY (`id_jamaah`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

