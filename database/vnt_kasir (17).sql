-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Waktu pembuatan: 05 Jan 2025 pada 21.16
-- Versi server: 5.7.44
-- Versi PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vnt_kasir`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksis`
--

CREATE TABLE `detail_transaksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaksi_id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `gambar_menu` varchar(255) DEFAULT NULL,
  `nama_menu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_transaksis`
--

INSERT INTO `detail_transaksis` (`id`, `transaksi_id`, `menu_id`, `jumlah`, `harga`, `created_at`, `updated_at`, `gambar_menu`, `nama_menu`) VALUES
(1, 1, 1, 2, 20000.00, '2025-01-05 20:27:03', '2025-01-05 20:27:03', 'images/x68HXQIUKbSvPdWd757YAp5WtyPGK8iqSsY1vuBe.jpg', 'Kopi Susu Classic'),
(2, 1, 2, 2, 20000.00, '2025-01-05 20:27:03', '2025-01-05 20:27:03', 'images/fSnvgwA4vvibuo86uATivRh2Xjt2twKUAExkqmF5.jpg', 'Kopi Gula Aren'),
(3, 1, 3, 2, 20000.00, '2025-01-05 20:27:03', '2025-01-05 20:27:03', 'images/qQfyhjae4cqFdlZPvTBPV9k9O0AfwgOJq88EQVVo.jpg', 'Kopi Susu Brown'),
(4, 1, 4, 1, 20000.00, '2025-01-05 20:27:03', '2025-01-05 20:27:03', 'images/OMjGVyXqzUedW4di5OJl8ohHeqThI5RyFXNbcwPX.jpg', 'Kopi Susu Vanilla');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_users`
--

CREATE TABLE `log_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `log_users`
--

INSERT INTO `log_users` (`id`, `username`, `role`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Shafira', 'Manager', 'Shafira menambahkan menu: kopi tora', '2024-12-26 17:30:48', '2024-12-26 17:30:48'),
(2, 'Shafira', 'Manager', 'Shafira menambahkan menu: kopi susu', '2024-12-26 17:31:36', '2024-12-26 17:31:36'),
(3, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (Excel) data transaksi pemesanan', '2024-12-27 01:16:48', '2024-12-27 01:16:48'),
(4, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2024-12-27 01:18:05', '2024-12-27 01:18:05'),
(5, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2024-12-27 01:20:11', '2024-12-27 01:20:11'),
(6, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2024-12-27 01:20:36', '2024-12-27 01:20:36'),
(7, 'Shafira', 'Manager', 'Shafira melakukan ekspor (Excel) data menu', '2024-12-27 01:34:17', '2024-12-27 01:34:17'),
(8, 'Shafira', 'Manager', 'Shafira melakukan ekspor (PDF) data menu', '2024-12-27 01:34:22', '2024-12-27 01:34:22'),
(9, 'Shafira', 'Manager', 'Shafira melakukan ekspor (Excel) data menu', '2024-12-27 01:56:14', '2024-12-27 01:56:14'),
(10, 'Shafira', 'Manager', 'Shafira melakukan ekspor (Excel) data menu', '2024-12-27 02:02:09', '2024-12-27 02:02:09'),
(11, 'Shafira', 'Manager', 'Shafira melakukan ekspor (Excel) data transaksi pemesanan', '2024-12-27 02:03:26', '2024-12-27 02:03:26'),
(12, 'adminVNT', 'Admin', 'adminVNT melakukan ekspor (Excel) data user', '2024-12-27 02:04:11', '2024-12-27 02:04:11'),
(13, 'Shafira', 'Manager', 'Shafira menambahkan menu: Kopi Susu Classic', '2024-12-27 02:19:12', '2024-12-27 02:19:12'),
(14, 'Shafira', 'Manager', 'Shafira menambahkan menu: Kopi Gula Aren', '2024-12-27 02:21:21', '2024-12-27 02:21:21'),
(15, 'Shafira', 'Manager', 'Shafira menambahkan menu: Kopi Susu Brown', '2024-12-27 02:21:57', '2024-12-27 02:21:57'),
(16, 'Shafira', 'Manager', 'Shafira menambahkan menu: Kopi Susu Vanilla', '2024-12-27 02:22:43', '2024-12-27 02:22:43'),
(17, 'Shafira', 'Manager', 'Shafira menambahkan menu: Kopi Susu Caramel', '2024-12-27 02:23:12', '2024-12-27 02:23:12'),
(18, 'Shafira', 'Manager', 'Shafira menambahkan menu: Kopi Susu Hazelnut', '2024-12-27 02:23:41', '2024-12-27 02:23:41'),
(19, 'Shafira', 'Manager', 'Shafira menambahkan menu: Caffelatte', '2024-12-27 02:25:20', '2024-12-27 02:25:20'),
(20, 'Shafira', 'Manager', 'Shafira menambahkan menu: Seblak Mie Telur', '2024-12-27 02:26:01', '2024-12-27 02:26:01'),
(21, 'Shafira', 'Manager', 'Shafira menambahkan menu: Mie Goreng Telur', '2024-12-27 02:26:29', '2024-12-27 02:26:29'),
(22, 'Shafira', 'Manager', 'Shafira menambahkan menu: Mie Kuah Special', '2024-12-27 02:26:57', '2024-12-27 02:26:57'),
(23, 'Shafira', 'Manager', 'Shafira menambahkan menu: Kentang Goreng', '2024-12-27 02:27:34', '2024-12-27 02:27:34'),
(24, 'Shafira', 'Manager', 'Shafira menambahkan menu: Singkong Keju', '2024-12-27 02:28:15', '2024-12-27 02:28:15'),
(25, 'Shafira', 'Manager', 'Shafira menambahkan menu: Cheese Roll', '2024-12-27 02:28:54', '2024-12-27 02:28:54'),
(26, 'Shafira', 'Manager', 'Shafira menambahkan menu: Caramel', '2024-12-27 02:29:40', '2024-12-27 02:29:40'),
(27, 'Shafira', 'Manager', 'Shafira menambahkan menu: Fresh Grape', '2024-12-27 02:31:38', '2024-12-27 02:31:38'),
(28, 'Shafira', 'Manager', 'Shafira menambahkan menu: Lychee Tea', '2024-12-27 02:32:11', '2024-12-27 02:32:11'),
(29, 'Shafira', 'Manager', 'Shafira menambahkan menu: Lemon Tea', '2024-12-27 02:32:43', '2024-12-27 02:32:43'),
(30, 'Shafira', 'Manager', 'Shafira menambahkan menu: Espresso', '2024-12-27 02:33:27', '2024-12-27 02:33:27'),
(31, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (Excel) data transaksi pemesanan', '2024-12-27 02:36:48', '2024-12-27 02:36:48'),
(32, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (Excel) data transaksi pemesanan', '2025-01-05 22:55:07', '2025-01-05 22:55:07'),
(33, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 22:57:36', '2025-01-05 22:57:36'),
(34, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 22:57:50', '2025-01-05 22:57:50'),
(35, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:01:33', '2025-01-05 23:01:33'),
(36, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:01:46', '2025-01-05 23:01:46'),
(37, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:04:47', '2025-01-05 23:04:47'),
(38, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:05:45', '2025-01-05 23:05:45'),
(39, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:10:31', '2025-01-05 23:10:31'),
(40, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:14:31', '2025-01-05 23:14:31'),
(41, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:23:09', '2025-01-05 23:23:09'),
(42, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:24:20', '2025-01-05 23:24:20'),
(43, 'adminVNT', 'Admin', 'adminVNT melakukan ekspor (PDF) data user', '2025-01-05 23:25:37', '2025-01-05 23:25:37'),
(44, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:28:59', '2025-01-05 23:28:59'),
(45, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:30:51', '2025-01-05 23:30:51'),
(46, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:31:21', '2025-01-05 23:31:21'),
(47, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:32:40', '2025-01-05 23:32:40'),
(48, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:36:27', '2025-01-05 23:36:27'),
(49, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:37:50', '2025-01-05 23:37:50'),
(50, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:39:07', '2025-01-05 23:39:07'),
(51, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:45:33', '2025-01-05 23:45:33'),
(52, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:47:08', '2025-01-05 23:47:08'),
(53, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:48:07', '2025-01-05 23:48:07'),
(54, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:48:16', '2025-01-05 23:48:16'),
(55, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:49:40', '2025-01-05 23:49:40'),
(56, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:52:36', '2025-01-05 23:52:36'),
(57, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:53:58', '2025-01-05 23:53:58'),
(58, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:55:18', '2025-01-05 23:55:18'),
(59, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:57:36', '2025-01-05 23:57:36'),
(60, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-05 23:58:57', '2025-01-05 23:58:57'),
(61, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 00:00:19', '2025-01-06 00:00:19'),
(62, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 00:02:58', '2025-01-06 00:02:58'),
(63, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 00:03:08', '2025-01-06 00:03:08'),
(64, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 00:05:05', '2025-01-06 00:05:05'),
(65, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 00:07:58', '2025-01-06 00:07:58'),
(66, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 00:10:44', '2025-01-06 00:10:44'),
(67, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 00:11:50', '2025-01-06 00:11:50'),
(68, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (Excel) data transaksi pemesanan', '2025-01-06 00:12:25', '2025-01-06 00:12:25'),
(69, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 00:16:16', '2025-01-06 00:16:16'),
(70, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 00:19:25', '2025-01-06 00:19:25'),
(71, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 00:19:26', '2025-01-06 00:19:26'),
(72, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 00:37:39', '2025-01-06 00:37:39'),
(73, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 00:42:26', '2025-01-06 00:42:26'),
(74, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 00:52:29', '2025-01-06 00:52:29'),
(75, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 00:55:59', '2025-01-06 00:55:59'),
(76, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 00:57:50', '2025-01-06 00:57:50'),
(77, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 01:01:55', '2025-01-06 01:01:55'),
(78, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 01:03:22', '2025-01-06 01:03:22'),
(79, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 01:05:24', '2025-01-06 01:05:24'),
(80, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 01:07:58', '2025-01-06 01:07:58'),
(81, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 01:09:17', '2025-01-06 01:09:17'),
(82, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 01:11:42', '2025-01-06 01:11:42'),
(83, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 01:11:57', '2025-01-06 01:11:57'),
(84, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 01:13:05', '2025-01-06 01:13:05'),
(85, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 01:14:25', '2025-01-06 01:14:25'),
(86, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 01:16:05', '2025-01-06 01:16:05'),
(87, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 01:49:10', '2025-01-06 01:49:10'),
(88, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 01:50:33', '2025-01-06 01:50:33'),
(89, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 01:50:55', '2025-01-06 01:50:55'),
(90, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 01:51:27', '2025-01-06 01:51:27'),
(91, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 01:53:38', '2025-01-06 01:53:38'),
(92, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 01:55:23', '2025-01-06 01:55:23'),
(93, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 01:56:10', '2025-01-06 01:56:10'),
(94, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 01:59:01', '2025-01-06 01:59:01'),
(95, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:00:20', '2025-01-06 02:00:20'),
(96, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:02:53', '2025-01-06 02:02:53'),
(97, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:04:29', '2025-01-06 02:04:29'),
(98, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:05:16', '2025-01-06 02:05:16'),
(99, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:08:13', '2025-01-06 02:08:13'),
(100, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:08:59', '2025-01-06 02:08:59'),
(101, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:10:06', '2025-01-06 02:10:06'),
(102, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:11:01', '2025-01-06 02:11:01'),
(103, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:11:21', '2025-01-06 02:11:21'),
(104, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:12:07', '2025-01-06 02:12:07'),
(105, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:12:18', '2025-01-06 02:12:18'),
(106, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:12:54', '2025-01-06 02:12:54'),
(107, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:14:58', '2025-01-06 02:14:58'),
(108, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:17:01', '2025-01-06 02:17:01'),
(109, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:18:14', '2025-01-06 02:18:14'),
(110, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:19:29', '2025-01-06 02:19:29'),
(111, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:20:45', '2025-01-06 02:20:45'),
(112, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:21:40', '2025-01-06 02:21:40'),
(113, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:26:27', '2025-01-06 02:26:27'),
(114, 'karyawan1', 'Cashier', 'karyawan1 melakukan ekspor (PDF) data transaksi pemesanan', '2025-01-06 02:52:35', '2025-01-06 02:52:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_menu` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` decimal(10,2) NOT NULL DEFAULT '0.00',
  `deskripsi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ketersediaan` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `gambar_menu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `menus`
--

INSERT INTO `menus` (`id`, `nama_menu`, `harga`, `deskripsi`, `ketersediaan`, `gambar_menu`, `created_at`, `updated_at`) VALUES
(1, 'Kopi Susu Classic', 20000.00, 'Kopi susu dengan rasa klasik', 56, 'images/x68HXQIUKbSvPdWd757YAp5WtyPGK8iqSsY1vuBe.jpg', '2024-12-27 02:19:12', '2025-01-06 03:27:03'),
(2, 'Kopi Gula Aren', 20000.00, 'Kopi susu dengan gula aren', 54, 'images/fSnvgwA4vvibuo86uATivRh2Xjt2twKUAExkqmF5.jpg', '2024-12-27 02:21:21', '2025-01-06 03:27:03'),
(3, 'Kopi Susu Brown', 20000.00, 'Kopi susu dengan rasa cokelat', 57, 'images/qQfyhjae4cqFdlZPvTBPV9k9O0AfwgOJq88EQVVo.jpg', '2024-12-27 02:21:57', '2025-01-06 03:27:03'),
(4, 'Kopi Susu Vanilla', 20000.00, 'Kopi susu dengan rasa vanilla', 59, 'images/OMjGVyXqzUedW4di5OJl8ohHeqThI5RyFXNbcwPX.jpg', '2024-12-27 02:22:43', '2025-01-06 03:27:03'),
(5, 'Kopi Susu Caramel', 20000.00, 'Kopi susu dengan rasa caramel', 60, 'images/pvDBZSPggNOOc31B3MS75BdcHBsentp7gUA0f7qp.jpg', '2024-12-27 02:23:12', '2024-12-27 02:23:12'),
(6, 'Kopi Susu Hazelnut', 20000.00, 'Kopi susu dengan rasa hazelnut', 57, 'images/h8ehDIjHnSoTPX03kTJ9ElHS8NpXztQg7TqyesXr.jpg', '2024-12-27 02:23:41', '2025-01-06 01:37:33'),
(7, 'Caffelatte', 16000.00, 'Kopi dengan susu panas', 57, 'images/Tube8Bjz32HYSkNYhiPfXKAcZEdhtHdBJbZRX5nF.jpg', '2024-12-27 02:25:20', '2025-01-06 01:37:33'),
(8, 'Seblak Mie Telur', 13000.00, 'Seblak dengan mie telur', 60, 'images/wdnpHnwTQqVIv84gaJLn94Nqf6EDaXly0g8qlDzS.jpg', '2024-12-27 02:26:01', '2024-12-27 02:26:01'),
(9, 'Mie Goreng Telur', 13000.00, 'Mie goreng dengan telur', 60, 'images/3hAeNMe6SSmttZu1BFRdUMQl8wFb8TK6oMBngpub.jpg', '2024-12-27 02:26:29', '2024-12-27 02:26:29'),
(10, 'Mie Kuah Special', 15000.00, 'Mie kuah dengan bahan spesial', 60, 'images/kNB4uiUiLRdILHmui1Q2gXVZWg1xtrQohp4DCKel.jpg', '2024-12-27 02:26:57', '2024-12-27 02:26:57'),
(11, 'Kentang Goreng', 15000.00, 'Kentang goreng crispy', 60, 'images/haDh7Mp6l9Dzc4XJ78o8XXuZa4vTcAQ2vh5u6rCy.jpg', '2024-12-27 02:27:34', '2024-12-27 02:27:34'),
(12, 'Singkong Keju', 10000.00, 'Singkong goreng dengan taburan keju', 70, 'images/vWKAdPLGvgXfcadgGVSHnRFYw1wt7obTYK8Ax0jD.jpg', '2024-12-27 02:28:15', '2024-12-27 02:28:15'),
(13, 'Cheese Roll', 10000.00, 'Roti gulung isi keju', 60, 'images/ffztCNUjJSAlgCpKQ6MGIqsg79d9DnapI8plSqG8.jpg', '2024-12-27 02:28:54', '2024-12-27 02:28:54'),
(14, 'Caramel', 16000.00, 'Minuman dengan rasa caramel', 60, 'images/tEJyq3OLWCoAVBsUmVSmhGKmmKO3jQtPPA1VsENC.jpg', '2024-12-27 02:29:40', '2024-12-27 02:29:40'),
(15, 'Fresh Grape', 10000.00, 'Minuman dengan rasa anggur segar', 60, 'images/1GoAagY2OR3doGFYy2bvDkNnX19L8PP3uqv83kU5.jpg', '2024-12-27 02:31:38', '2024-12-27 02:31:38'),
(16, 'Lychee Tea', 12000.00, 'Minuman teh lychee', 60, 'images/guNCOonVRZh4kKvzNY76UNVcOAGONP3222Q1tzRJ.jpg', '2024-12-27 02:32:11', '2024-12-27 02:32:11'),
(17, 'Lemon Tea', 10000.00, 'Minuman teh lemon', 47, 'images/xeuduLE1lmCkOV7TfHNIQR7tGjfsb92HWLSfjurG.jpg', '2024-12-27 02:32:43', '2025-01-06 01:32:44'),
(18, 'Espresso', 10000.00, 'Kopi espresso murni', 50, 'images/KepiL9skuPcRGWFKPIIyt2Ty0CIKuQ7z4BM74xUf.jpg', '2024-12-27 02:33:27', '2024-12-27 02:33:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_21_212456_create_transaksis_table', 1),
(6, '2024_11_21_212546_create_menus_table', 1),
(7, '2024_11_21_212557_create_log_users_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_pelanggan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_pegawai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_harga` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status_pembayaran` enum('pending','paid','cancelled','expired','refunded','unknown') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `metode_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `nama_pelanggan`, `nama_pegawai`, `total_harga`, `status_pembayaran`, `token`, `created_at`, `updated_at`, `metode_pembayaran`, `order_id`) VALUES
(1, 'Farul', 'Karyawan 1', 140000.00, 'paid', 'd25f5973-d945-48cb-91a6-51c6ba797d6a', '2025-01-06 03:27:03', '2025-01-06 03:27:03', 'cash', 'ORDLmY75pKp');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `username`, `role`, `password`, `created_at`, `updated_at`) VALUES
(1, 'adminVNT', 'adminVNT', 'Admin', '$2y$10$bFtDZWH5yVU3NIAs9zmEtOgno7qL.4QCl8669AYL8.tDNTSeJSCSK', '2024-12-26 17:28:13', '2024-12-26 17:28:13'),
(2, 'Syafarul Priwantoro', 'Farul', 'Admin', '$2y$10$TrNwupbiRJyhN8utVmIFG.j28YvmuTguqw4yyrUH1UncLSqiWt17S', '2024-12-26 17:28:13', '2024-12-26 17:28:13'),
(3, 'Shafira Daffa', 'Shafira', 'Manager', '$2y$10$2j9oAGljb7XTRV7euyK5yuRs/PqSIxSZq0RX7/gqg.jHKADeEYRMa', '2024-12-26 17:28:13', '2024-12-26 17:28:13'),
(4, 'Angelica', 'angelica', 'Cashier', '$2y$10$zLegIZvSpnOvpJpY9FmpRumeaUhm.SdXW5ia/7glKF/DE3N3pQ6ha', '2024-12-26 17:28:13', '2024-12-26 17:28:13'),
(5, 'Karyawan 1', 'karyawan1', 'Cashier', '$2y$10$EP0OyvqjeOguvatn5cG59ui8x3z/VpOMnw1ytP5eyVhDXh6hpEzYi', '2024-12-26 17:28:13', '2024-12-26 17:28:13');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id` (`transaksi_id`),
  ADD KEY `detail_transaksis_ibfk_2` (`menu_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `log_users`
--
ALTER TABLE `log_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `menus_nama_menu_unique` (`nama_menu`),
  ADD KEY `menus_nama_menu_index` (`nama_menu`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaksi_token_unique` (`token`),
  ADD KEY `transaksi_nama_pelanggan_index` (`nama_pelanggan`),
  ADD KEY `transaksi_nama_pegawai_index` (`nama_pegawai`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `log_users`
--
ALTER TABLE `log_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;

--
-- AUTO_INCREMENT untuk tabel `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  ADD CONSTRAINT `detail_transaksis_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_transaksis_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
