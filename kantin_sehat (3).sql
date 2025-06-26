-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2025 at 01:41 AM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kantin_sehat`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `batch_uuid` char(36) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":1,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(2, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":1,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(3, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":2,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(4, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 4, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":2,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(5, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":3,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(6, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 6, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":3,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(7, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":4,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(8, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":4,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(9, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 9, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":5,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(10, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 10, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":5,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(11, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 11, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":6,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(12, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 12, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":6,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(13, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 13, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":7,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(14, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 14, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":7,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(15, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 15, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":8,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(16, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 16, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":8,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(17, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 17, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":9,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(18, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 18, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":9,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(19, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 19, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":10,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(20, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 20, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":10,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(21, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 21, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":11,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(22, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 22, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":11,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(23, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 23, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":12,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(24, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 24, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":12,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(25, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 25, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":13,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(26, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 26, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":13,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(27, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 27, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":14,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(28, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 28, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":14,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(29, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 29, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":15,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(30, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 30, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":15,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(31, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 31, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":16,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(32, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 32, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":16,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(33, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 33, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":17,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(34, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 34, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":17,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(35, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 35, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":18,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(36, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 36, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":18,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(37, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 37, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":19,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(38, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 38, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":19,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(39, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 39, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":20,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(40, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 40, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":20,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(41, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 41, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":21,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(42, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 42, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":21,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(43, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 43, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":22,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(44, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 44, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":22,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(45, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 45, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":23,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(46, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 46, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":23,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(47, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 47, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":24,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(48, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 48, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":24,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(49, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 49, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":25,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(50, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 50, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":25,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(51, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 51, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":26,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(52, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 52, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":26,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(53, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 53, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":27,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(54, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 54, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":27,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(55, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 55, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":28,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(56, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 56, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":28,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(57, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 57, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":29,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(58, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 58, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":29,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(59, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 59, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":30,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(60, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 60, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":30,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(61, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 61, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":31,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(62, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 62, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":31,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(63, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 63, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":32,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(64, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 64, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":32,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(65, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 65, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":33,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(66, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 66, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":33,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(67, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 67, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":34,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(68, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 68, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":34,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(69, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 69, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":35,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(70, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 70, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":35,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(71, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 71, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":36,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(72, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 72, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":36,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(73, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 73, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":37,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(74, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 74, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":37,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(75, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 75, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":38,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(76, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 76, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":38,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(77, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 77, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":39,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(78, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 78, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":39,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(79, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 79, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":40,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(80, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 80, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":40,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(81, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 81, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":41,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(82, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 82, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":41,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(83, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 83, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":42,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(84, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 84, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":42,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(85, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 85, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":43,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(86, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 86, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":43,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(87, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 87, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":44,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(88, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 88, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":44,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(89, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 89, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":45,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(90, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 90, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":45,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(91, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 91, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":46,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(92, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 92, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":46,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(93, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 93, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":47,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(94, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 94, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":47,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(95, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 95, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":48,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(96, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 96, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":48,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(97, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 97, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":49,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(98, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 98, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":49,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(99, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 99, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"June 2025\",\"barang_id\":50,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(100, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 100, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"July 2025\",\"barang_id\":50,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:31:45', '2025-06-25 22:31:45'),
(101, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 101, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":1,\"kuantitas_awal\":0,\"kuantitas_akhir\":32,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"56400.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(102, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":32,\"nilai_kuantitas_awal\":\"56400.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(103, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 102, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":2,\"kuantitas_awal\":0,\"kuantitas_akhir\":22,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"46900.92\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(104, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":22,\"nilai_kuantitas_awal\":\"46900.92\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(105, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 103, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":3,\"kuantitas_awal\":0,\"kuantitas_akhir\":4,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"3340.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(106, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":4,\"nilai_kuantitas_awal\":\"3340.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(107, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 104, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":4,\"kuantitas_awal\":0,\"kuantitas_akhir\":3,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"5391.63\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(108, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":3,\"nilai_kuantitas_awal\":\"5391.63\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(109, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 105, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":5,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(110, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 9, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(111, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 106, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":6,\"kuantitas_awal\":0,\"kuantitas_akhir\":57,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"105096.60\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(112, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 11, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":57,\"nilai_kuantitas_awal\":\"105096.60\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(113, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 107, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":7,\"kuantitas_awal\":0,\"kuantitas_akhir\":8,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"9066.40\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(114, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 13, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":8,\"nilai_kuantitas_awal\":\"9066.40\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(115, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 108, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":8,\"kuantitas_awal\":0,\"kuantitas_akhir\":35,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"158433.45\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(116, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 15, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":35,\"nilai_kuantitas_awal\":\"158433.45\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(117, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 109, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":9,\"kuantitas_awal\":0,\"kuantitas_akhir\":35,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"155050.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(118, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 17, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":35,\"nilai_kuantitas_awal\":\"155050.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(119, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 110, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":10,\"kuantitas_awal\":0,\"kuantitas_akhir\":29,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"128687.50\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(120, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 19, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":29,\"nilai_kuantitas_awal\":\"128687.50\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(121, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 111, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":11,\"kuantitas_awal\":0,\"kuantitas_akhir\":19,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"87400.95\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(122, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 21, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":19,\"nilai_kuantitas_awal\":\"87400.95\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(123, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 112, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":12,\"kuantitas_awal\":0,\"kuantitas_akhir\":32,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"142000.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(124, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 23, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":32,\"nilai_kuantitas_awal\":\"142000.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(125, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 113, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":13,\"kuantitas_awal\":0,\"kuantitas_akhir\":15,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"66562.50\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(126, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 25, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":15,\"nilai_kuantitas_awal\":\"66562.50\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(127, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 114, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":14,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(128, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 27, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(129, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 115, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":15,\"kuantitas_awal\":0,\"kuantitas_akhir\":45,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"121249.80\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(130, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 29, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":45,\"nilai_kuantitas_awal\":\"121249.80\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(131, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 116, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":16,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(132, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 31, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(133, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 117, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":17,\"kuantitas_awal\":0,\"kuantitas_akhir\":419,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"906087.50\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(134, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 33, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":419,\"nilai_kuantitas_awal\":\"906087.50\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(135, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 118, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":18,\"kuantitas_awal\":0,\"kuantitas_akhir\":25,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"68227.75\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(136, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 35, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":25,\"nilai_kuantitas_awal\":\"68227.75\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(137, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 119, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":19,\"kuantitas_awal\":0,\"kuantitas_akhir\":4,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"6933.48\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(138, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 37, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":4,\"nilai_kuantitas_awal\":\"6933.48\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(139, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 120, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":20,\"kuantitas_awal\":0,\"kuantitas_akhir\":21,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"22890.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(140, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 39, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":21,\"nilai_kuantitas_awal\":\"22890.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(141, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 121, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":21,\"kuantitas_awal\":0,\"kuantitas_akhir\":12,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"11000.04\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(142, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 41, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":12,\"nilai_kuantitas_awal\":\"11000.04\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(143, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 122, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":22,\"kuantitas_awal\":0,\"kuantitas_akhir\":14,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"7980.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(144, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 43, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":14,\"nilai_kuantitas_awal\":\"7980.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(145, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 123, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":23,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(146, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 45, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(147, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 124, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":24,\"kuantitas_awal\":0,\"kuantitas_akhir\":13,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"58987.50\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(148, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 47, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":13,\"nilai_kuantitas_awal\":\"58987.50\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(149, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 125, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":25,\"kuantitas_awal\":0,\"kuantitas_akhir\":7,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"12950.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(150, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 49, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":7,\"nilai_kuantitas_awal\":\"12950.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(151, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 126, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":26,\"kuantitas_awal\":0,\"kuantitas_akhir\":4,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"6733.32\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(152, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 51, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":4,\"nilai_kuantitas_awal\":\"6733.32\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(153, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 127, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":27,\"kuantitas_awal\":0,\"kuantitas_akhir\":54,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"276509.70\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(154, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 53, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":54,\"nilai_kuantitas_awal\":\"276509.70\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(155, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 128, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":28,\"kuantitas_awal\":0,\"kuantitas_akhir\":27,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"47250.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(156, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 55, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":27,\"nilai_kuantitas_awal\":\"47250.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(157, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 129, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":29,\"kuantitas_awal\":0,\"kuantitas_akhir\":2,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"1861.44\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(158, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 57, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":2,\"nilai_kuantitas_awal\":\"1861.44\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(159, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 130, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":30,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(160, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 59, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(161, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 131, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":31,\"kuantitas_awal\":0,\"kuantitas_akhir\":24,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"108922.80\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(162, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 61, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":24,\"nilai_kuantitas_awal\":\"108922.80\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(163, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 132, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":32,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(164, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 63, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(165, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 133, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":33,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(166, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 65, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(167, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 134, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":34,\"kuantitas_awal\":0,\"kuantitas_akhir\":25,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"42250.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(168, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 67, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":25,\"nilai_kuantitas_awal\":\"42250.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(169, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 135, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":35,\"kuantitas_awal\":0,\"kuantitas_akhir\":8,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"16533.36\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(170, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 69, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":8,\"nilai_kuantitas_awal\":\"16533.36\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(171, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 136, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":36,\"kuantitas_awal\":0,\"kuantitas_akhir\":2,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"11362.94\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(172, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 71, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":2,\"nilai_kuantitas_awal\":\"11362.94\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(173, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 137, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":37,\"kuantitas_awal\":0,\"kuantitas_akhir\":45,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"45246.60\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(174, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 73, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":45,\"nilai_kuantitas_awal\":\"45246.60\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(175, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 138, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":38,\"kuantitas_awal\":0,\"kuantitas_akhir\":1,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"3662.50\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(176, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 75, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":1,\"nilai_kuantitas_awal\":\"3662.50\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(177, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 139, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":39,\"kuantitas_awal\":0,\"kuantitas_akhir\":16,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"26048.64\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(178, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 77, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":16,\"nilai_kuantitas_awal\":\"26048.64\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(179, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 140, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":40,\"kuantitas_awal\":0,\"kuantitas_akhir\":5,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"13128.05\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(180, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 79, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":5,\"nilai_kuantitas_awal\":\"13128.05\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(181, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 141, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":41,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(182, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 81, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(183, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 142, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":42,\"kuantitas_awal\":0,\"kuantitas_akhir\":1,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"416.67\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(184, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 83, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":1,\"nilai_kuantitas_awal\":\"416.67\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(185, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 143, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":43,\"kuantitas_awal\":0,\"kuantitas_akhir\":2,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"3188.90\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(186, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 85, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":2,\"nilai_kuantitas_awal\":\"3188.90\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(187, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 144, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":44,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(188, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 87, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(189, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 145, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":45,\"kuantitas_awal\":0,\"kuantitas_akhir\":9,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"27412.47\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(190, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 89, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":9,\"nilai_kuantitas_awal\":\"27412.47\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(191, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 146, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":46,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(192, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 91, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(193, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 147, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":47,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(194, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 93, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(195, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 148, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":48,\"kuantitas_awal\":0,\"kuantitas_akhir\":0,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(196, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 95, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(197, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 149, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":49,\"kuantitas_awal\":0,\"kuantitas_akhir\":9,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"20970.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(198, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 97, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":9,\"nilai_kuantitas_awal\":\"20970.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(199, 'saldo_barang_bulanan', 'Saldo barang bulanan telah created', 'App\\Models\\SaldoBarangBulanan', 'created', 150, 'App\\Models\\User', 1, '{\"attributes\":{\"periode_bulan\":\"May 2025\",\"barang_id\":50,\"kuantitas_awal\":0,\"kuantitas_akhir\":30,\"nilai_kuantitas_awal\":\"0.00\",\"nilai_kuantitas_akhir\":\"159000.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(200, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 99, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":30,\"nilai_kuantitas_awal\":\"159000.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(201, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 1, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":32,\"nilai_kuantitas_akhir\":\"56400.00\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(202, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 2, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":32,\"nilai_kuantitas_awal\":\"56400.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(203, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 3, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":22,\"nilai_kuantitas_akhir\":\"46900.92\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(204, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 4, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":22,\"nilai_kuantitas_awal\":\"46900.92\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(205, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 5, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":4,\"nilai_kuantitas_akhir\":\"3340.00\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(206, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 6, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":4,\"nilai_kuantitas_awal\":\"3340.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(207, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 7, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":3,\"nilai_kuantitas_akhir\":\"5391.63\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(208, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 8, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":3,\"nilai_kuantitas_awal\":\"5391.63\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(209, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 9, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(210, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 10, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(211, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 11, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":57,\"nilai_kuantitas_akhir\":\"105096.60\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(212, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 12, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":57,\"nilai_kuantitas_awal\":\"105096.60\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(213, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 13, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":8,\"nilai_kuantitas_akhir\":\"9066.40\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(214, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 14, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":8,\"nilai_kuantitas_awal\":\"9066.40\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(215, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 15, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":35,\"nilai_kuantitas_akhir\":\"158433.45\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(216, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 16, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":35,\"nilai_kuantitas_awal\":\"158433.45\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(217, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 17, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":35,\"nilai_kuantitas_akhir\":\"155050.00\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(218, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 18, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":35,\"nilai_kuantitas_awal\":\"155050.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(219, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 19, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":29,\"nilai_kuantitas_akhir\":\"128687.50\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(220, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 20, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":29,\"nilai_kuantitas_awal\":\"128687.50\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(221, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 21, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":19,\"nilai_kuantitas_akhir\":\"87400.95\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(222, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 22, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":19,\"nilai_kuantitas_awal\":\"87400.95\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(223, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 23, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":32,\"nilai_kuantitas_akhir\":\"142000.00\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(224, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 24, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":32,\"nilai_kuantitas_awal\":\"142000.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(225, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 25, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":15,\"nilai_kuantitas_akhir\":\"66562.50\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(226, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 26, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":15,\"nilai_kuantitas_awal\":\"66562.50\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(227, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 27, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(228, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 28, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(229, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 29, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":45,\"nilai_kuantitas_akhir\":\"121249.80\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(230, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 30, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":45,\"nilai_kuantitas_awal\":\"121249.80\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(231, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 31, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(232, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 32, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(233, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 33, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":419,\"nilai_kuantitas_akhir\":\"906087.50\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(234, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 34, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":419,\"nilai_kuantitas_awal\":\"906087.50\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(235, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 35, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":25,\"nilai_kuantitas_akhir\":\"68227.75\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(236, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 36, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":25,\"nilai_kuantitas_awal\":\"68227.75\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(237, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 37, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":4,\"nilai_kuantitas_akhir\":\"6933.48\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(238, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 38, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":4,\"nilai_kuantitas_awal\":\"6933.48\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(239, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 39, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":21,\"nilai_kuantitas_akhir\":\"22890.00\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(240, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 40, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":21,\"nilai_kuantitas_awal\":\"22890.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(241, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 41, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":12,\"nilai_kuantitas_akhir\":\"11000.04\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(242, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 42, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":12,\"nilai_kuantitas_awal\":\"11000.04\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(243, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 43, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":14,\"nilai_kuantitas_akhir\":\"7980.00\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(244, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 44, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":14,\"nilai_kuantitas_awal\":\"7980.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(245, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 45, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(246, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 46, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(247, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 47, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":13,\"nilai_kuantitas_akhir\":\"58987.50\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(248, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 48, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":13,\"nilai_kuantitas_awal\":\"58987.50\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(249, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 49, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":7,\"nilai_kuantitas_akhir\":\"12950.00\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(250, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 50, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":7,\"nilai_kuantitas_awal\":\"12950.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(251, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 51, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":4,\"nilai_kuantitas_akhir\":\"6733.32\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(252, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 52, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":4,\"nilai_kuantitas_awal\":\"6733.32\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(253, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 53, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":54,\"nilai_kuantitas_akhir\":\"276509.70\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(254, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 54, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":54,\"nilai_kuantitas_awal\":\"276509.70\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(255, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 55, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":27,\"nilai_kuantitas_akhir\":\"47250.00\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(256, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 56, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":27,\"nilai_kuantitas_awal\":\"47250.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(257, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 57, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":2,\"nilai_kuantitas_akhir\":\"1861.44\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(258, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 58, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":2,\"nilai_kuantitas_awal\":\"1861.44\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(259, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 59, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(260, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 60, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(261, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 61, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":24,\"nilai_kuantitas_akhir\":\"108922.80\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(262, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 62, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":24,\"nilai_kuantitas_awal\":\"108922.80\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(263, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 63, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(264, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 64, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(265, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 65, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(266, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 66, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(267, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 67, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":25,\"nilai_kuantitas_akhir\":\"42250.00\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(268, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 68, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":25,\"nilai_kuantitas_awal\":\"42250.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(269, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 69, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":8,\"nilai_kuantitas_akhir\":\"16533.36\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(270, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 70, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":8,\"nilai_kuantitas_awal\":\"16533.36\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(271, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 71, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":2,\"nilai_kuantitas_akhir\":\"11362.94\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(272, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 72, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":2,\"nilai_kuantitas_awal\":\"11362.94\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(273, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 73, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":45,\"nilai_kuantitas_akhir\":\"45246.60\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(274, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 74, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":45,\"nilai_kuantitas_awal\":\"45246.60\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(275, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 75, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":1,\"nilai_kuantitas_akhir\":\"3662.50\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(276, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 76, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":1,\"nilai_kuantitas_awal\":\"3662.50\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(277, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 77, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":16,\"nilai_kuantitas_akhir\":\"26048.64\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(278, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 78, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":16,\"nilai_kuantitas_awal\":\"26048.64\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(279, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 79, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":5,\"nilai_kuantitas_akhir\":\"13128.05\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(280, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 80, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":5,\"nilai_kuantitas_awal\":\"13128.05\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(281, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 81, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(282, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 82, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(283, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 83, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":1,\"nilai_kuantitas_akhir\":\"416.67\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(284, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 84, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":1,\"nilai_kuantitas_awal\":\"416.67\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:12', '2025-06-25 22:36:12'),
(285, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 85, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":2,\"nilai_kuantitas_akhir\":\"3188.90\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:13', '2025-06-25 22:36:13');
INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(286, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 86, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":2,\"nilai_kuantitas_awal\":\"3188.90\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:13', '2025-06-25 22:36:13'),
(287, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 87, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:13', '2025-06-25 22:36:13'),
(288, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 88, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:13', '2025-06-25 22:36:13'),
(289, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 89, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":9,\"nilai_kuantitas_akhir\":\"27412.47\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:13', '2025-06-25 22:36:13'),
(290, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 90, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":9,\"nilai_kuantitas_awal\":\"27412.47\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:13', '2025-06-25 22:36:13'),
(291, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 91, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:13', '2025-06-25 22:36:13'),
(292, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 92, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:13', '2025-06-25 22:36:13'),
(293, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 93, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:13', '2025-06-25 22:36:13'),
(294, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 94, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:13', '2025-06-25 22:36:13'),
(295, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 95, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:13', '2025-06-25 22:36:13'),
(296, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 96, 'App\\Models\\User', 1, '{\"attributes\":[],\"old\":[]}', NULL, '2025-06-25 22:36:13', '2025-06-25 22:36:13'),
(297, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 97, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":9,\"nilai_kuantitas_akhir\":\"20970.00\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:13', '2025-06-25 22:36:13'),
(298, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 98, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":9,\"nilai_kuantitas_awal\":\"20970.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:13', '2025-06-25 22:36:13'),
(299, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 99, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_akhir\":30,\"nilai_kuantitas_akhir\":\"159000.00\"},\"old\":{\"kuantitas_akhir\":0,\"nilai_kuantitas_akhir\":\"0.00\"}}', NULL, '2025-06-25 22:36:13', '2025-06-25 22:36:13'),
(300, 'saldo_barang_bulanan', 'Saldo barang bulanan telah updated', 'App\\Models\\SaldoBarangBulanan', 'updated', 100, 'App\\Models\\User', 1, '{\"attributes\":{\"kuantitas_awal\":30,\"nilai_kuantitas_awal\":\"159000.00\"},\"old\":{\"kuantitas_awal\":0,\"nilai_kuantitas_awal\":\"0.00\"}}', NULL, '2025-06-25 22:36:13', '2025-06-25 22:36:13');

-- --------------------------------------------------------

--
-- Table structure for table `barangs`
--

CREATE TABLE `barangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga_pokok` decimal(15,2) NOT NULL,
  `harga_jual` decimal(15,2) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `status_titipan` tinyint(1) NOT NULL DEFAULT 0,
  `tipe_barang` enum('snack','minuman','kebutuhan','titipan','lainnya') NOT NULL DEFAULT 'lainnya',
  `hasil_bagi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barangs`
--

INSERT INTO `barangs` (`id`, `kode_barang`, `nama`, `harga_pokok`, `harga_jual`, `stok`, `is_active`, `status_titipan`, `tipe_barang`, `hasil_bagi_id`, `created_at`, `updated_at`) VALUES
(1, '271032672', 'Apollo Layer Cake Cocoa', 1762.50, 3000.00, 32, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(2, '541241054', 'Beng Beng', 2131.86, 3000.00, 22, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(3, '412085022', 'Biskuit Coklat', 835.00, 2000.00, 4, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(4, '384594016', 'Garuda Potato BBQ', 1797.21, 3000.00, 3, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(5, '706564130', 'Garuda Rosta Bawang', 1715.34, 3000.00, 0, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(6, '763764760', 'Good Time Rainbow Chocochips Cookies', 1843.80, 3000.00, 57, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(7, '535082418', 'Khong Guan Saltcheese Combo', 1133.30, 2000.00, 8, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(8, '921870695', 'POP MIE Ayam 75G', 4526.67, 10000.00, 35, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(9, '492677643', 'POP MIE Ayam Bawang 75G', 4430.00, 10000.00, 35, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(10, '886762142', 'POP MIE Baso 75G', 4437.50, 10000.00, 29, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(11, '757606110', 'POP MIE Goreng Spesial 85G', 4600.05, 10000.00, 19, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(12, '127169503', 'POP MIE Soto Ayam 75G', 4437.50, 10000.00, 32, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(13, '503457583', 'POP MIE Kari Ayam 75G', 4437.50, 10000.00, 15, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(14, '651361048', 'Tos Tos', 1750.00, 3000.00, 0, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(15, '380258839', 'Yupi Gummy Fruit', 2694.44, 5000.00, 45, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(16, '248200371', 'Chocolatos Original Wafer Stick', 887.50, 2000.00, 0, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(17, '202972269', 'Lee Mineral 600ML', 2162.50, 5000.00, 419, 1, 0, 'minuman', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(18, '525264863', 'Teh Pucuk Harum 350ML', 2729.11, 5000.00, 25, 1, 0, 'minuman', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(19, '161212483', 'Biskuat Bolu Coklat', 1733.37, 3000.00, 4, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(20, '373777708', 'SOBA MIE', 1090.00, 2000.00, 21, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(21, '492574457', 'Tisu', 916.67, 2000.00, 12, 1, 0, 'kebutuhan', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(22, '311378376', 'Pembalut', 570.00, 2000.00, 14, 1, 0, 'kebutuhan', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(23, '120254384', 'Susu Ultra Coklat 200ML', 4500.00, 7000.00, 0, 1, 0, 'minuman', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(24, '154731338', 'Susu Ultra Strawberry 200ML', 4537.50, 7000.00, 13, 1, 0, 'minuman', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(25, '866187288', 'Chiki Ball Coklat', 1850.00, 3000.00, 7, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(26, '801227786', 'Sari Gandum coklat', 1683.33, 3000.00, 4, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(27, '469739287', 'Yupi Gummy Apple', 5120.55, 7000.00, 54, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(28, '198314584', 'Chiki Balls Chicken', 1750.00, 3000.00, 27, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(29, '545648094', 'Superstar', 930.72, 2000.00, 2, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(30, '244835194', 'Chiki Ball Keju', 1975.24, 3000.00, 0, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(31, '125235232', 'Susu Ultra Plain 200', 4538.45, 7000.00, 24, 1, 0, 'minuman', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(32, '266928987', 'Teh Kotak Jasmine 300', 3083.33, 6000.00, 0, 1, 0, 'minuman', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(33, '627234438', 'Oreo Sandwich', 1856.28, 3000.00, 0, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(34, '113506880', 'Pampers S, M, L', 1690.00, 3000.00, 25, 1, 0, 'kebutuhan', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(35, '332279274', 'Yakult', 2066.67, 3000.00, 8, 1, 0, 'minuman', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(36, '619902272', 'Kopiko 78C Coffee Late', 5681.47, 7000.00, 2, 1, 0, 'minuman', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(37, '175632236', 'Dk Usagi Puf', 1005.48, 1500.00, 45, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(38, '887410694', 'Chiki Twist Corn', 3662.50, 5000.00, 1, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(39, '842768231', 'Apollo Lapis Strawberry', 1628.04, 3000.00, 16, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(40, '490317691', 'Foridina', 2625.61, 5000.00, 5, 1, 0, 'minuman', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(41, '780843111', 'Garuda Kc Telur', 899.00, 1500.00, 0, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(42, '566871473', 'Garuda Pilus Pedas', 416.67, 1000.00, 1, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(43, '378327436', 'Pembalut Cool & Wing', 1594.45, 3000.00, 2, 1, 0, 'kebutuhan', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(44, '863930522', 'Garuda Pilus Rendang', 815.00, 1500.00, 0, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(45, '985307226', 'Golda', 3045.83, 5000.00, 9, 1, 0, 'minuman', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(46, '925004668', 'Superco Malk', 960.00, 2000.00, 0, 1, 0, 'minuman', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(47, '831885119', 'Choki-Choki', 1005.00, 2000.00, 0, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(48, '168394637', 'Oreo Soft Cake', 1650.04, 3000.00, 0, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(49, '458920057', 'Pempers XL', 2330.00, 4000.00, 9, 1, 0, 'kebutuhan', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(50, '976891142', 'Yupi Little Stars', 5300.00, 7000.00, 30, 1, 0, 'snack', NULL, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(51, '396279722', 'Amplang', 5000.00, 6000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(52, '967018153', 'Peyek', 14000.00, 15000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(53, '456708879', 'Masker', 4000.00, 5000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(54, '337106503', 'Jahe', 14000.00, 15000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(55, '424180282', 'Kripik Bawang', 14000.00, 15000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(56, '622354436', 'Makroni Pedas/Balado/Asin/Keju', 5000.00, 6000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(57, '329451857', 'Kerupuk Singkong Pink', 4000.00, 5000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(58, '448292782', 'Emping', 6000.00, 7000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(59, '708622587', 'Kripik Pangsit Kecil', 5000.00, 6000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(60, '417699137', 'Kacang/Jintan/Jagung', 4000.00, 5000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(61, '866728521', 'Kripik Singkong Besar', 14000.00, 15000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(62, '476193328', 'Kripik Singkong kecil', 6000.00, 7000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(63, '164175827', 'Kembang Goyang', 9000.00, 10000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(64, '693404951', 'Kripik Pisang Ori', 8000.00, 9000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(65, '806035938', 'Kripik Pisang Coklat', 12000.00, 13000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(66, '357967758', 'Kripik Tempe', 13000.00, 14000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(67, '634554226', 'Pudding', 7000.00, 8000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '0000-00-00 00:00:00'),
(68, '324794172', 'Cheesecuit Ori/Coklat', 11000.00, 12000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(69, '919802158', 'Cheesecuit Blueberry', 13000.00, 14000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(70, '687357116', 'Nasi Ayam Caramel/BBQ/Blackpaper', 12000.00, 13000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(71, '785236014', 'Mihun', 10000.00, 11000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(72, '626892737', 'Jasuke', 5000.00, 6000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(73, '987198214', 'Nasi Ayam Serundeng', 14000.00, 15000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(74, '803703265', 'Cendol', 10000.00, 11000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(75, '895694719', 'Thai Tea/Matcha', 11000.00, 12000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(76, '500796565', 'Bolu Peca', 5000.00, 6000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(77, '782673706', 'Cincau', 9000.00, 10000.00, 0, 1, 1, 'titipan', 2, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(78, '243301665', 'Roti', 5000.00, 7000.00, 0, 1, 1, 'titipan', 3, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(79, '294620007', 'Kripik Pangsit Besar', 10000.00, 12000.00, 0, 1, 1, 'titipan', 3, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(80, '971174964', 'Risol/Martabak', 3000.00, 3500.00, 0, 1, 1, 'titipan', 1, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(81, '661737404', 'Tahu Bakso', 4000.00, 4500.00, 0, 1, 1, 'titipan', 1, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(82, '357067885', 'Donat/Bakpao/Tahu Isi', 2000.00, 2500.00, 0, 1, 1, 'titipan', 1, '2025-05-27 16:00:00', '2025-05-27 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksis`
--

CREATE TABLE `detail_transaksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaksi_id` bigint(20) UNSIGNED NOT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `harga_satuan` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gaji_pembayarans`
--

CREATE TABLE `gaji_pembayarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `periode_bulan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hasil_bagis`
--

CREATE TABLE `hasil_bagis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tipe` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hasil_bagis`
--

INSERT INTO `hasil_bagis` (`id`, `tipe`, `created_at`, `updated_at`) VALUES
(1, '500', '2025-06-25 23:40:07', '2025-06-25 23:40:07'),
(2, '1000', '2025-06-25 23:40:15', '2025-06-25 23:40:15'),
(3, '2000', '2025-06-25 23:40:21', '2025-06-25 23:40:21');

-- --------------------------------------------------------

--
-- Table structure for table `kas`
--

CREATE TABLE `kas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `saldo_kas` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kasir_transaksis`
--

CREATE TABLE `kasir_transaksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unix_id` varchar(10) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_harga` decimal(15,2) NOT NULL,
  `metode_pembayaran` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `shift_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kas_kembalian`
--

CREATE TABLE `kas_kembalian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kas_kerugians`
--

CREATE TABLE `kas_kerugians` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kas_keuntungans`
--

CREATE TABLE `kas_keuntungans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kas_titipans`
--

CREATE TABLE `kas_titipans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `saldo_kas` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kas_titipans`
--

INSERT INTO `kas_titipans` (`id`, `barang_id`, `saldo_kas`, `created_at`, `updated_at`) VALUES
(1, 51, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(2, 52, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(3, 53, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(4, 54, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(5, 55, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(6, 56, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(7, 57, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(8, 58, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(9, 59, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(10, 60, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(11, 61, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(12, 62, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(13, 63, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(14, 64, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(15, 65, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(16, 66, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(17, 67, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(18, 68, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(19, 69, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(20, 70, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(21, 71, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(22, 72, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(23, 73, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(24, 74, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(25, 75, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(26, 76, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(27, 77, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(28, 78, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(29, 79, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(30, 80, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(31, 81, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(32, 82, 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '01_2025_06_02_061719_create_users_table', 1),
(2, '02_2025_06_02_061617_create_hasil_bagis_table', 1),
(3, '03_2025_06_02_061546_create_barangs_table', 1),
(4, '04_2025_06_02_061714_create_shifts_table', 1),
(5, '05_2025_06_02_061633_create_kasir_transaksis_table', 1),
(6, '06_2025_06_02_061605_create_detail_transaksis_table', 1),
(7, '07_2025_06_02_061658_create_persediaans_table', 1),
(8, '2025_05_03_032201_sessions', 1),
(9, '2025_05_23_105535_create_activity_log_table', 1),
(10, '2025_05_23_105536_add_event_column_to_activity_log_table', 1),
(11, '2025_05_23_105537_add_batch_uuid_column_to_activity_log_table', 1),
(12, '2025_06_02_061612_create_gaji_pembayarans_table', 1),
(13, '2025_06_02_061639_create_kas_kembalian_table', 1),
(14, '2025_06_02_061646_create_kas_kerugians_table', 1),
(15, '2025_06_02_061652_create_kas_titipans_table', 1),
(16, '2025_06_02_061703_create_saldo_barang_bulanans_table', 1),
(17, '2025_06_02_061709_create_saldo_kas_bulanans_table', 1),
(18, '2025_06_02_102013_create_kas_table', 1),
(19, '2025_06_03_083602_create_stok_masuk_table', 1),
(20, '2025_06_03_132257_create_pengeluaran', 1),
(21, '2025_06_06_165247_create_kas_keuntungan', 1),
(22, '2025_06_23_060941_add_default_value', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pengeluarans`
--

CREATE TABLE `pengeluarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `deskripsi` varchar(255) NOT NULL,
  `jumlah` decimal(15,2) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `persediaans`
--

CREATE TABLE `persediaans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `kelola_id` bigint(20) UNSIGNED NOT NULL,
  `tipe` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah` int(11) NOT NULL,
  `sisa_stok` decimal(10,2) NOT NULL DEFAULT 0.00,
  `alasan` text DEFAULT NULL,
  `total_harga` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `persediaans`
--

INSERT INTO `persediaans` (`id`, `barang_id`, `kelola_id`, `tipe`, `tanggal`, `jumlah`, `sisa_stok`, `alasan`, `total_harga`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'pembelian', '2025-05-28', 32, 32.00, 'Pembelian awal stok barang', 56400.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(2, 2, 1, 'pembelian', '2025-05-28', 22, 22.00, 'Pembelian awal stok barang', 46900.92, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(3, 3, 1, 'pembelian', '2025-05-28', 4, 4.00, 'Pembelian awal stok barang', 3340.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(4, 4, 1, 'pembelian', '2025-05-28', 3, 3.00, 'Pembelian awal stok barang', 5391.63, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(5, 5, 1, 'pembelian', '2025-05-28', 0, 0.00, 'Pembelian awal stok barang', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(6, 6, 1, 'pembelian', '2025-05-28', 57, 57.00, 'Pembelian awal stok barang', 105096.60, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(7, 7, 1, 'pembelian', '2025-05-28', 8, 8.00, 'Pembelian awal stok barang', 9066.40, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(8, 8, 1, 'pembelian', '2025-05-28', 35, 35.00, 'Pembelian awal stok barang', 158433.45, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(9, 9, 1, 'pembelian', '2025-05-28', 35, 35.00, 'Pembelian awal stok barang', 155050.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(10, 10, 1, 'pembelian', '2025-05-28', 29, 29.00, 'Pembelian awal stok barang', 128687.50, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(11, 11, 1, 'pembelian', '2025-05-28', 19, 19.00, 'Pembelian awal stok barang', 87400.95, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(12, 12, 1, 'pembelian', '2025-05-28', 32, 32.00, 'Pembelian awal stok barang', 142000.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(13, 13, 1, 'pembelian', '2025-05-28', 15, 15.00, 'Pembelian awal stok barang', 66562.50, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(14, 14, 1, 'pembelian', '2025-05-28', 0, 0.00, 'Pembelian awal stok barang', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(15, 15, 1, 'pembelian', '2025-05-28', 45, 45.00, 'Pembelian awal stok barang', 121249.80, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(16, 16, 1, 'pembelian', '2025-05-28', 0, 0.00, 'Pembelian awal stok barang', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(17, 17, 1, 'pembelian', '2025-05-28', 419, 419.00, 'Pembelian awal stok barang', 906087.50, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(18, 18, 1, 'pembelian', '2025-05-28', 25, 25.00, 'Pembelian awal stok barang', 68227.75, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(19, 19, 1, 'pembelian', '2025-05-28', 4, 4.00, 'Pembelian awal stok barang', 6933.48, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(20, 20, 1, 'pembelian', '2025-05-28', 21, 21.00, 'Pembelian awal stok barang', 22890.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(21, 21, 1, 'pembelian', '2025-05-28', 12, 12.00, 'Pembelian awal stok barang', 11000.04, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(22, 22, 1, 'pembelian', '2025-05-28', 14, 14.00, 'Pembelian awal stok barang', 7980.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(23, 23, 1, 'pembelian', '2025-05-28', 0, 0.00, 'Pembelian awal stok barang', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(24, 24, 1, 'pembelian', '2025-05-28', 13, 13.00, 'Pembelian awal stok barang', 58987.50, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(25, 25, 1, 'pembelian', '2025-05-28', 7, 7.00, 'Pembelian awal stok barang', 12950.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(26, 26, 1, 'pembelian', '2025-05-28', 4, 4.00, 'Pembelian awal stok barang', 6733.32, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(27, 27, 1, 'pembelian', '2025-05-28', 54, 54.00, 'Pembelian awal stok barang', 276509.70, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(28, 28, 1, 'pembelian', '2025-05-28', 27, 27.00, 'Pembelian awal stok barang', 47250.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(29, 29, 1, 'pembelian', '2025-05-28', 2, 2.00, 'Pembelian awal stok barang', 1861.44, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(30, 30, 1, 'pembelian', '2025-05-28', 0, 0.00, 'Pembelian awal stok barang', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(31, 31, 1, 'pembelian', '2025-05-28', 24, 24.00, 'Pembelian awal stok barang', 108922.80, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(32, 32, 1, 'pembelian', '2025-05-28', 0, 0.00, 'Pembelian awal stok barang', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(33, 33, 1, 'pembelian', '2025-05-28', 0, 0.00, 'Pembelian awal stok barang', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(34, 34, 1, 'pembelian', '2025-05-28', 25, 25.00, 'Pembelian awal stok barang', 42250.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(35, 35, 1, 'pembelian', '2025-05-28', 8, 8.00, 'Pembelian awal stok barang', 16533.36, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(36, 36, 1, 'pembelian', '2025-05-28', 2, 2.00, 'Pembelian awal stok barang', 11362.94, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(37, 37, 1, 'pembelian', '2025-05-28', 45, 45.00, 'Pembelian awal stok barang', 45246.60, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(38, 38, 1, 'pembelian', '2025-05-28', 1, 1.00, 'Pembelian awal stok barang', 3662.50, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(39, 39, 1, 'pembelian', '2025-05-28', 16, 16.00, 'Pembelian awal stok barang', 26048.64, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(40, 40, 1, 'pembelian', '2025-05-28', 5, 5.00, 'Pembelian awal stok barang', 13128.05, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(41, 41, 1, 'pembelian', '2025-05-28', 0, 0.00, 'Pembelian awal stok barang', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(42, 42, 1, 'pembelian', '2025-05-28', 1, 1.00, 'Pembelian awal stok barang', 416.67, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(43, 43, 1, 'pembelian', '2025-05-28', 2, 2.00, 'Pembelian awal stok barang', 3188.90, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(44, 44, 1, 'pembelian', '2025-05-28', 0, 0.00, 'Pembelian awal stok barang', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(45, 45, 1, 'pembelian', '2025-05-28', 9, 9.00, 'Pembelian awal stok barang', 27412.47, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(46, 46, 1, 'pembelian', '2025-05-28', 0, 0.00, 'Pembelian awal stok barang', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(47, 47, 1, 'pembelian', '2025-05-28', 0, 0.00, 'Pembelian awal stok barang', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(48, 48, 1, 'pembelian', '2025-05-28', 0, 0.00, 'Pembelian awal stok barang', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(49, 49, 1, 'pembelian', '2025-05-28', 9, 9.00, 'Pembelian awal stok barang', 20970.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(50, 50, 1, 'pembelian', '2025-05-28', 30, 30.00, 'Pembelian awal stok barang', 159000.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(51, 51, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(52, 52, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(53, 53, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(54, 54, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(55, 55, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(56, 56, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(57, 57, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(58, 58, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(59, 59, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(60, 60, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(61, 61, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(62, 62, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(63, 63, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(64, 64, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(65, 65, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(66, 66, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(67, 67, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(68, 68, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(69, 69, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(70, 70, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(71, 71, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(72, 72, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(73, 73, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(74, 74, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(75, 75, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(76, 76, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(77, 77, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(78, 78, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(79, 79, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(80, 80, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(81, 81, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(82, 82, 1, 'penambahan_titipan', '2025-05-28', 0, 0.00, 'Penambahan awal barang titipan', 0.00, '2025-05-27 16:00:00', '2025-05-27 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `saldo_barang_bulanans`
--

CREATE TABLE `saldo_barang_bulanans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `periode_bulan` varchar(255) NOT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `kuantitas_awal` int(11) NOT NULL,
  `kuantitas_akhir` int(11) NOT NULL DEFAULT 0,
  `nilai_kuantitas_awal` decimal(15,2) NOT NULL,
  `nilai_kuantitas_akhir` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `saldo_barang_bulanans`
--

INSERT INTO `saldo_barang_bulanans` (`id`, `periode_bulan`, `barang_id`, `kuantitas_awal`, `kuantitas_akhir`, `nilai_kuantitas_awal`, `nilai_kuantitas_akhir`, `created_at`, `updated_at`) VALUES
(1, 'June 2025', 1, 32, 32, 56400.00, 56400.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(2, 'July 2025', 1, 32, 0, 56400.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(3, 'June 2025', 2, 22, 22, 46900.92, 46900.92, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(4, 'July 2025', 2, 22, 0, 46900.92, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(5, 'June 2025', 3, 4, 4, 3340.00, 3340.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(6, 'July 2025', 3, 4, 0, 3340.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(7, 'June 2025', 4, 3, 3, 5391.63, 5391.63, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(8, 'July 2025', 4, 3, 0, 5391.63, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(9, 'June 2025', 5, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(10, 'July 2025', 5, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(11, 'June 2025', 6, 57, 57, 105096.60, 105096.60, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(12, 'July 2025', 6, 57, 0, 105096.60, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(13, 'June 2025', 7, 8, 8, 9066.40, 9066.40, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(14, 'July 2025', 7, 8, 0, 9066.40, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(15, 'June 2025', 8, 35, 35, 158433.45, 158433.45, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(16, 'July 2025', 8, 35, 0, 158433.45, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(17, 'June 2025', 9, 35, 35, 155050.00, 155050.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(18, 'July 2025', 9, 35, 0, 155050.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(19, 'June 2025', 10, 29, 29, 128687.50, 128687.50, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(20, 'July 2025', 10, 29, 0, 128687.50, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(21, 'June 2025', 11, 19, 19, 87400.95, 87400.95, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(22, 'July 2025', 11, 19, 0, 87400.95, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(23, 'June 2025', 12, 32, 32, 142000.00, 142000.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(24, 'July 2025', 12, 32, 0, 142000.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(25, 'June 2025', 13, 15, 15, 66562.50, 66562.50, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(26, 'July 2025', 13, 15, 0, 66562.50, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(27, 'June 2025', 14, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(28, 'July 2025', 14, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(29, 'June 2025', 15, 45, 45, 121249.80, 121249.80, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(30, 'July 2025', 15, 45, 0, 121249.80, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(31, 'June 2025', 16, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(32, 'July 2025', 16, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(33, 'June 2025', 17, 419, 419, 906087.50, 906087.50, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(34, 'July 2025', 17, 419, 0, 906087.50, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(35, 'June 2025', 18, 25, 25, 68227.75, 68227.75, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(36, 'July 2025', 18, 25, 0, 68227.75, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(37, 'June 2025', 19, 4, 4, 6933.48, 6933.48, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(38, 'July 2025', 19, 4, 0, 6933.48, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(39, 'June 2025', 20, 21, 21, 22890.00, 22890.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(40, 'July 2025', 20, 21, 0, 22890.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(41, 'June 2025', 21, 12, 12, 11000.04, 11000.04, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(42, 'July 2025', 21, 12, 0, 11000.04, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(43, 'June 2025', 22, 14, 14, 7980.00, 7980.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(44, 'July 2025', 22, 14, 0, 7980.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(45, 'June 2025', 23, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(46, 'July 2025', 23, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(47, 'June 2025', 24, 13, 13, 58987.50, 58987.50, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(48, 'July 2025', 24, 13, 0, 58987.50, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(49, 'June 2025', 25, 7, 7, 12950.00, 12950.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(50, 'July 2025', 25, 7, 0, 12950.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(51, 'June 2025', 26, 4, 4, 6733.32, 6733.32, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(52, 'July 2025', 26, 4, 0, 6733.32, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(53, 'June 2025', 27, 54, 54, 276509.70, 276509.70, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(54, 'July 2025', 27, 54, 0, 276509.70, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(55, 'June 2025', 28, 27, 27, 47250.00, 47250.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(56, 'July 2025', 28, 27, 0, 47250.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(57, 'June 2025', 29, 2, 2, 1861.44, 1861.44, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(58, 'July 2025', 29, 2, 0, 1861.44, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(59, 'June 2025', 30, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(60, 'July 2025', 30, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(61, 'June 2025', 31, 24, 24, 108922.80, 108922.80, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(62, 'July 2025', 31, 24, 0, 108922.80, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(63, 'June 2025', 32, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(64, 'July 2025', 32, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(65, 'June 2025', 33, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(66, 'July 2025', 33, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(67, 'June 2025', 34, 25, 25, 42250.00, 42250.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(68, 'July 2025', 34, 25, 0, 42250.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(69, 'June 2025', 35, 8, 8, 16533.36, 16533.36, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(70, 'July 2025', 35, 8, 0, 16533.36, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(71, 'June 2025', 36, 2, 2, 11362.94, 11362.94, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(72, 'July 2025', 36, 2, 0, 11362.94, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(73, 'June 2025', 37, 45, 45, 45246.60, 45246.60, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(74, 'July 2025', 37, 45, 0, 45246.60, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(75, 'June 2025', 38, 1, 1, 3662.50, 3662.50, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(76, 'July 2025', 38, 1, 0, 3662.50, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(77, 'June 2025', 39, 16, 16, 26048.64, 26048.64, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(78, 'July 2025', 39, 16, 0, 26048.64, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(79, 'June 2025', 40, 5, 5, 13128.05, 13128.05, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(80, 'July 2025', 40, 5, 0, 13128.05, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(81, 'June 2025', 41, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(82, 'July 2025', 41, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(83, 'June 2025', 42, 1, 1, 416.67, 416.67, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(84, 'July 2025', 42, 1, 0, 416.67, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(85, 'June 2025', 43, 2, 2, 3188.90, 3188.90, '2025-06-25 22:31:45', '2025-06-25 22:36:12'),
(86, 'July 2025', 43, 2, 0, 3188.90, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:13'),
(87, 'June 2025', 44, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:13'),
(88, 'July 2025', 44, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:13'),
(89, 'June 2025', 45, 9, 9, 27412.47, 27412.47, '2025-06-25 22:31:45', '2025-06-25 22:36:13'),
(90, 'July 2025', 45, 9, 0, 27412.47, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:13'),
(91, 'June 2025', 46, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:13'),
(92, 'July 2025', 46, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:13'),
(93, 'June 2025', 47, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:13'),
(94, 'July 2025', 47, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:13'),
(95, 'June 2025', 48, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:13'),
(96, 'July 2025', 48, 0, 0, 0.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:13'),
(97, 'June 2025', 49, 9, 9, 20970.00, 20970.00, '2025-06-25 22:31:45', '2025-06-25 22:36:13'),
(98, 'July 2025', 49, 9, 0, 20970.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:13'),
(99, 'June 2025', 50, 30, 30, 159000.00, 159000.00, '2025-06-25 22:31:45', '2025-06-25 22:36:13'),
(100, 'July 2025', 50, 30, 0, 159000.00, 0.00, '2025-06-25 22:31:45', '2025-06-25 22:36:13'),
(101, 'May 2025', 1, 0, 32, 0.00, 56400.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(102, 'May 2025', 2, 0, 22, 0.00, 46900.92, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(103, 'May 2025', 3, 0, 4, 0.00, 3340.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(104, 'May 2025', 4, 0, 3, 0.00, 5391.63, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(105, 'May 2025', 5, 0, 0, 0.00, 0.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(106, 'May 2025', 6, 0, 57, 0.00, 105096.60, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(107, 'May 2025', 7, 0, 8, 0.00, 9066.40, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(108, 'May 2025', 8, 0, 35, 0.00, 158433.45, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(109, 'May 2025', 9, 0, 35, 0.00, 155050.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(110, 'May 2025', 10, 0, 29, 0.00, 128687.50, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(111, 'May 2025', 11, 0, 19, 0.00, 87400.95, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(112, 'May 2025', 12, 0, 32, 0.00, 142000.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(113, 'May 2025', 13, 0, 15, 0.00, 66562.50, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(114, 'May 2025', 14, 0, 0, 0.00, 0.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(115, 'May 2025', 15, 0, 45, 0.00, 121249.80, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(116, 'May 2025', 16, 0, 0, 0.00, 0.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(117, 'May 2025', 17, 0, 419, 0.00, 906087.50, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(118, 'May 2025', 18, 0, 25, 0.00, 68227.75, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(119, 'May 2025', 19, 0, 4, 0.00, 6933.48, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(120, 'May 2025', 20, 0, 21, 0.00, 22890.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(121, 'May 2025', 21, 0, 12, 0.00, 11000.04, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(122, 'May 2025', 22, 0, 14, 0.00, 7980.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(123, 'May 2025', 23, 0, 0, 0.00, 0.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(124, 'May 2025', 24, 0, 13, 0.00, 58987.50, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(125, 'May 2025', 25, 0, 7, 0.00, 12950.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(126, 'May 2025', 26, 0, 4, 0.00, 6733.32, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(127, 'May 2025', 27, 0, 54, 0.00, 276509.70, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(128, 'May 2025', 28, 0, 27, 0.00, 47250.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(129, 'May 2025', 29, 0, 2, 0.00, 1861.44, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(130, 'May 2025', 30, 0, 0, 0.00, 0.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(131, 'May 2025', 31, 0, 24, 0.00, 108922.80, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(132, 'May 2025', 32, 0, 0, 0.00, 0.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(133, 'May 2025', 33, 0, 0, 0.00, 0.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(134, 'May 2025', 34, 0, 25, 0.00, 42250.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(135, 'May 2025', 35, 0, 8, 0.00, 16533.36, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(136, 'May 2025', 36, 0, 2, 0.00, 11362.94, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(137, 'May 2025', 37, 0, 45, 0.00, 45246.60, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(138, 'May 2025', 38, 0, 1, 0.00, 3662.50, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(139, 'May 2025', 39, 0, 16, 0.00, 26048.64, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(140, 'May 2025', 40, 0, 5, 0.00, 13128.05, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(141, 'May 2025', 41, 0, 0, 0.00, 0.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(142, 'May 2025', 42, 0, 1, 0.00, 416.67, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(143, 'May 2025', 43, 0, 2, 0.00, 3188.90, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(144, 'May 2025', 44, 0, 0, 0.00, 0.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(145, 'May 2025', 45, 0, 9, 0.00, 27412.47, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(146, 'May 2025', 46, 0, 0, 0.00, 0.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(147, 'May 2025', 47, 0, 0, 0.00, 0.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(148, 'May 2025', 48, 0, 0, 0.00, 0.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(149, 'May 2025', 49, 0, 9, 0.00, 20970.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12'),
(150, 'May 2025', 50, 0, 30, 0.00, 159000.00, '2025-06-25 22:32:12', '2025-06-25 22:32:12');

-- --------------------------------------------------------

--
-- Table structure for table `saldo_kas_bulanans`
--

CREATE TABLE `saldo_kas_bulanans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `periode_bulan` varchar(255) NOT NULL,
  `saldo_awal` decimal(15,2) NOT NULL,
  `saldo_akhir` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `saldo_kas_bulanans`
--

INSERT INTO `saldo_kas_bulanans` (`id`, `periode_bulan`, `saldo_awal`, `saldo_akhir`, `created_at`, `updated_at`) VALUES
(1, 'May 2025', 0.00, 25184300.00, '2025-06-25 20:38:06', '2025-06-25 22:32:12'),
(2, 'June 2025', 25184300.00, 25184300.00, '2025-06-25 20:38:06', '2025-06-25 22:36:12'),
(3, 'July 2025', 25184300.00, NULL, '2025-06-25 20:48:24', '2025-06-25 22:36:12');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('I0xawCldK7WRDhljWz49gXlvmpmmQ9AFg1gaH52z', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoib1RDT1dWMVkxNDRJV2YzY09JUEV3aWtYaVFkdVRZNFRkNjBoT3kyUSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNzoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2FkbWluL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjM3OiJodHRwOi8vMTI3LjAuMC4xOjgwMDAvYWRtaW4vZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQzOiJyZXBvcnRfcGVuZXJpbWFhbl9wZW1iYXlhcmFuXzIwMjUwNjI2MDYzMzM0IjtzOjQ3OTI6IjwhRE9DVFlQRSBodG1sPgo8aHRtbCBsYW5nPSJpZCI+CjxoZWFkPgogICAgPG1ldGEgY2hhcnNldD0iVVRGLTgiPgogICAgPG1ldGEgbmFtZT0idmlld3BvcnQiIGNvbnRlbnQ9IndpZHRoPWRldmljZS13aWR0aCwgaW5pdGlhbC1zY2FsZT0xLjAiPgogICAgPHRpdGxlPlJpbmdrYXNhbiBQZW5lcmltYWFuICYgUGVtYmF5YXJhbjwvdGl0bGU+CiAgICA8c3R5bGU+CiAgICAgICAgYm9keSB7IGZvbnQtZmFtaWx5OiBBcmlhbCwgc2Fucy1zZXJpZjsgbWFyZ2luOiAyMHB4OyBwYWRkaW5nLWxlZnQ6IDIwcHg7IHBhZGRpbmctcmlnaHQ6IDIwcHg7IGxpbmUtaGVpZ2h0OiAxLjQ7IH0KICAgICAgICBoMSB7IHRleHQtYWxpZ246IGNlbnRlcjsgZm9udC1zaXplOiAxcmVtOyBjb2xvcjogYmxhY2s7IH0KICAgICAgICBoMiB7IHRleHQtYWxpZ246IGNlbnRlcjsgZm9udC1zaXplOiAwLjlyZW07IGNvbG9yOiBibGFjazsgfQogICAgICAgIC50ZXh0LWNlbnRlciB7IHRleHQtYWxpZ246IGNlbnRlcjsgfQogICAgICAgIC5yZXBvcnQtY29udGFpbmVyIHsgb3ZlcmZsb3cteDogYXV0bzsgbWF4LXdpZHRoOiAxMDAlOyB9CiAgICAgICAgdGFibGUgeyB3aWR0aDogMTAwJTsgYm9yZGVyLWNvbGxhcHNlOiBjb2xsYXBzZTsgbWFyZ2luLXRvcDogMTVweDsgdGV4dC1hbGlnbjogbGVmdDsgZm9udC1zaXplOiAwLjc1cmVtOyBib3JkZXI6IDFweCBzb2xpZCAjMDA3MDIyOyB9CiAgICAgICAgdGggeyBiYWNrZ3JvdW5kLWNvbG9yOiAjMDA3MDIyOyBjb2xvcjogd2hpdGU7IGZvbnQtd2VpZ2h0OiBib2xkOyBwYWRkaW5nOiAwLjVyZW0gMXJlbTsgYm9yZGVyOiAxcHggc29saWQgIzAwNTUxYTsgdGV4dC1hbGlnbjogY2VudGVyOyBmb250LXNpemU6IDAuOXJlbTsgdGV4dC10cmFuc2Zvcm06IHVwcGVyY2FzZTsgfQogICAgICAgIHRkIHsgcGFkZGluZzogMC40cmVtIDAuOHJlbTsgYm9yZGVyOiAxcHggc29saWQgIzAwNzAyMjsgdGV4dC1hbGlnbjogbGVmdDsgfQogICAgICAgIHRyOm50aC1jaGlsZChldmVuKSB7IGJhY2tncm91bmQtY29sb3I6ICNmNWZhZjU7IH0KICAgICAgICAudGV4dC1yaWdodCB7IHRleHQtYWxpZ246IHJpZ2h0OyB9CiAgICAgICAgLmJvbGQgeyBmb250LXdlaWdodDogYm9sZDsgfQogICAgICAgIC5zZWN0aW9uLWhlYWRlciB7IGJhY2tncm91bmQtY29sb3I6ICNkY2VkYzg7IGZvbnQtd2VpZ2h0OiBib2xkOyBib3JkZXItdG9wOiAxcHggc29saWQgIzAwNzAyMjsgYm9yZGVyLWJvdHRvbTogMXB4IHNvbGlkICMwMDcwMjI7IH0KICAgICAgICAuc3ViY2F0ZWdvcnkgeyBwYWRkaW5nLWxlZnQ6IDEuNXJlbTsgfQogICAgICAgIC50b3RhbC1yb3cgeyBiYWNrZ3JvdW5kLWNvbG9yOiAjZGNlZGM4OyBmb250LXdlaWdodDogYm9sZDsgfQogICAgICAgIC5oaWdobGlnaHQgeyBiYWNrZ3JvdW5kLWNvbG9yOiAjZGNlZGM4OyB9CiAgICAgICAgLm10LTQgeyBtYXJnaW4tdG9wOiAxcmVtOyB9CiAgICAgICAgLm1iLTQgeyBtYXJnaW4tYm90dG9tOiAxcmVtOyB9CiAgICAgICAgQG1lZGlhIHByaW50IHsgYm9keSB7IG1hcmdpbjogMDsgcGFkZGluZy1sZWZ0OiAyMHB4OyBwYWRkaW5nLXJpZ2h0OiAyMHB4OyB9IHRhYmxlIHsgcGFnZS1icmVhay1pbnNpZGU6IGF1dG87IHdpZHRoOiAxMDAlOyB9IEBwYWdlIHBvcnRyYWl0IHsgc2l6ZTogQTQgcG9ydHJhaXQ7IG1hcmdpbjogMTBtbTsgfSBAcGFnZSBsYW5kc2NhcGUgeyBzaXplOiBBNCBsYW5kc2NhcGU7IG1hcmdpbjogMTBtbTsgfSBAcGFnZSB7IHNpemU6IEE0IHBvcnRyYWl0OyB9IC5yZXBvcnQtY29udGFpbmVyIHsgb3ZlcmZsb3cteDogdmlzaWJsZTsgfSB0YWJsZSB7IG1heC13aWR0aDogbm9uZTsgfSB0aGVhZCB7IGRpc3BsYXk6IHRhYmxlLWhlYWRlci1ncm91cDsgfSB0Ym9keSB7IGRpc3BsYXk6IHRhYmxlLXJvdy1ncm91cDsgfSB0ciB7IHBhZ2UtYnJlYWstaW5zaWRlOiBhdm9pZDsgcGFnZS1icmVhay1hZnRlcjogYXV0bzsgfSB0aCB7IGJhY2tncm91bmQtY29sb3I6ICMwMDcwMjIgIWltcG9ydGFudDsgLXdlYmtpdC1wcmludC1jb2xvci1hZGp1c3Q6IGV4YWN0OyBwcmludC1jb2xvci1hZGp1c3Q6IGV4YWN0OyBjb2xvcjogd2hpdGUgIWltcG9ydGFudDsgYm9yZGVyOiAxcHggc29saWQgIzAwNTUxYSAhaW1wb3J0YW50OyB9IHRkIHsgYm9yZGVyOiAxcHggc29saWQgIzAwNzAyMiAhaW1wb3J0YW50OyB9IC5zZWN0aW9uLWhlYWRlciB7IGJhY2tncm91bmQtY29sb3I6ICNkY2VkYzggIWltcG9ydGFudDsgLXdlYmtpdC1wcmludC1jb2xvci1hZGp1c3Q6IGV4YWN0OyBwcmludC1jb2xvci1hZGp1c3Q6IGV4YWN0OyB9IC50b3RhbC1yb3cgeyBiYWNrZ3JvdW5kLWNvbG9yOiAjZGNlZGM4ICFpbXBvcnRhbnQ7IC13ZWJraXQtcHJpbnQtY29sb3ItYWRqdXN0OiBleGFjdDsgcHJpbnQtY29sb3ItYWRqdXN0OiBleGFjdDsgfSAuaGlnaGxpZ2h0IHsgYmFja2dyb3VuZC1jb2xvcjogI2RjZWRjOCAhaW1wb3J0YW50OyAtd2Via2l0LXByaW50LWNvbG9yLWFkanVzdDogZXhhY3Q7IHByaW50LWNvbG9yLWFkanVzdDogZXhhY3Q7IH0gdHI6bnRoLWNoaWxkKGV2ZW4pIHsgYmFja2dyb3VuZC1jb2xvcjogI2Y1ZmFmNSAhaW1wb3J0YW50OyAtd2Via2l0LXByaW50LWNvbG9yLWFkanVzdDogZXhhY3Q7IHByaW50LWNvbG9yLWFkanVzdDogZXhhY3Q7IH0gfQogICAgPC9zdHlsZT4KICAgIDxzY3JpcHQ+d2luZG93Lm9ubG9hZCA9IGZ1bmN0aW9uKCkgeyB3aW5kb3cucHJpbnQoKTsgfTs8L3NjcmlwdD4KPC9oZWFkPgo8Ym9keT4KICAgIDxoMT5LYW50aW4gU2VoYXQgVVBUIFBlbGF5YW5hbiBLZXNlaGF0YW48L2gxPgogICAgPGgyPlJpbmdrYXNhbiBQZW5lcmltYWFuICYgUGVtYmF5YXJhbjwvaDI+CiAgICA8cCBjbGFzcz0idGV4dC1jZW50ZXIiPlBlcmlvZGU6IGRhcmkgdGFuZ2dhbCAwMS8wNS8yMDI1IHNhbXBhaSBkZW5nYW4gMzAvMDUvMjAyNTwvcD4KICAgIDxkaXYgY2xhc3M9Im10LTQgbWItNCI+PGRpdiBjbGFzcz0icmVwb3J0LWNvbnRhaW5lciI+CiAgICA8dGFibGU+CiAgICAgICAgPHRoZWFkPgogICAgICAgICAgICA8dHI+PHRoIGNvbHNwYW49IjIiPlBlbmVyaW1hYW48L3RoPjwvdHI+CiAgICAgICAgICAgIDx0cj48dGg+S2F0ZWdvcmk8L3RoPjx0aCBjbGFzcz0idGV4dC1yaWdodCI+SnVtbGFoPC90aD48L3RyPgogICAgICAgIDwvdGhlYWQ+CiAgICAgICAgPHRib2R5PgogICAgICAgICAgICA8dHIgY2xhc3M9InNlY3Rpb24taGVhZGVyIj48dGQgY29sc3Bhbj0iMiI+UGVuZGFwYXRhbiBCYWdpIEhhc2lsIChwZXIgSmVuaXMpPC90ZD48L3RyPiAgICAgICAgICAgIDx0ciBjbGFzcz0idG90YWwtcm93Ij48dGQ+VG90YWwgUGVuZGFwYXRhbiBCYWdpIEhhc2lsPC90ZD48dGQgY2xhc3M9InRleHQtcmlnaHQgYm9sZCI+UnAgMCwwMDwvdGQ+PC90cj4KICAgICAgICAgICAgPHRyPjx0ZD5QZW5qdWFsYW4gQmFyYW5nIERhZ2FuZyAoTm9uLVRpdGlwYW4pPC90ZD48dGQgY2xhc3M9InRleHQtcmlnaHQiPlJwIDAsMDA8L3RkPjwvdHI+CiAgICAgICAgICAgIDx0cj48dGQ+S2V1bnR1bmdhbiBLYXM8L3RkPjx0ZCBjbGFzcz0idGV4dC1yaWdodCI+UnAgMCwwMDwvdGQ+PC90cj4KICAgICAgICAgICAgPHRyIGNsYXNzPSJ0b3RhbC1yb3ciPjx0ZD5Ub3RhbCBQZW5lcmltYWFuPC90ZD48dGQgY2xhc3M9InRleHQtcmlnaHQgYm9sZCI+UnAgMCwwMDwvdGQ+PC90cj4KICAgICAgICA8L3Rib2R5PgogICAgPC90YWJsZT4KICAgIDx0YWJsZT4KICAgICAgICA8dGhlYWQ+CiAgICAgICAgICAgIDx0cj48dGggY29sc3Bhbj0iMiI+UGVtYmF5YXJhbiAmIFJpbmdrYXNhbjwvdGg+PC90cj4KICAgICAgICAgICAgPHRyPjx0aD5LYXRlZ29yaTwvdGg+PHRoIGNsYXNzPSJ0ZXh0LXJpZ2h0Ij5KdW1sYWg8L3RoPjwvdHI+CiAgICAgICAgPC90aGVhZD4KICAgICAgICA8dGJvZHk+CiAgICAgICAgICAgIDx0cj48dGQ+QmlheWEgR2FqaSBLYXJ5YXdhbjwvdGQ+PHRkIGNsYXNzPSJ0ZXh0LXJpZ2h0Ij5ScCAwLDAwPC90ZD48L3RyPgogICAgICAgICAgICA8dHI+PHRkPktlcnVnaWFuIFBlcnNlZGlhYW4gKE5vbi1UaXRpcGFuKTwvdGQ+PHRkIGNsYXNzPSJ0ZXh0LXJpZ2h0Ij5ScCAwLDAwPC90ZD48L3RyPgogICAgICAgICAgICA8dHI+PHRkPlBlcnNlZGlhYW4gZGkgVGFuZ2FuIChOb24tVGl0aXBhbik8L3RkPjx0ZCBjbGFzcz0idGV4dC1yaWdodCI+UnAgMi45OTEuMTMzLDQxPC90ZD48L3RyPgogICAgICAgICAgICA8dHI+PHRkPktlcnVnaWFuIEthczwvdGQ+PHRkIGNsYXNzPSJ0ZXh0LXJpZ2h0Ij5ScCAwLDAwPC90ZD48L3RyPiAgICAgICAgICAgIDx0ciBjbGFzcz0idG90YWwtcm93Ij48dGQ+VG90YWwgUGVtYmF5YXJhbjwvdGQ+PHRkIGNsYXNzPSJ0ZXh0LXJpZ2h0IGJvbGQiPlJwIDIuOTkxLjEzMyw0MTwvdGQ+PC90cj4KICAgICAgICAgICAgPHRyIGNsYXNzPSJoaWdobGlnaHQiPjx0ZD5UYW1iYWhhbiAoUGVuZ3VyYW5nYW4pIEJlcnNpaCBwYWRhIEthczwvdGQ+PHRkIGNsYXNzPSJ0ZXh0LXJpZ2h0Ij5ScCAtMi45OTEuMTMzLDQxPC90ZD48L3RyPgogICAgICAgICAgICA8dHI+PHRkPlNhbGRvIEF3YWwgS2FzPC90ZD48dGQgY2xhc3M9InRleHQtcmlnaHQiPlJwIDAsMDA8L3RkPjwvdHI+CiAgICAgICAgICAgIDx0ciBjbGFzcz0idG90YWwtcm93Ij48dGQ+U2FsZG8gQWtoaXIgS2FzPC90ZD48dGQgY2xhc3M9InRleHQtcmlnaHQgYm9sZCI+UnAgLTIuOTkxLjEzMyw0MTwvdGQ+PC90cj4KICAgICAgICA8L3Rib2R5PgogICAgPC90YWJsZT4KPC9kaXY+ICAgIDwvZGl2Pgo8L2JvZHk+CjwvaHRtbD4iO30=', 1750894857);

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_shift` varchar(255) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stok_masuk`
--

CREATE TABLE `stok_masuk` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah_masuk` int(11) NOT NULL,
  `harga_beli` decimal(10,2) NOT NULL,
  `sisa_stok` int(11) NOT NULL DEFAULT 0,
  `tanggal_masuk` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stok_masuk`
--

INSERT INTO `stok_masuk` (`id`, `barang_id`, `jumlah_masuk`, `harga_beli`, `sisa_stok`, `tanggal_masuk`, `created_at`, `updated_at`) VALUES
(1, 1, 32, 1762.50, 32, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(2, 2, 22, 2131.86, 22, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(3, 3, 4, 835.00, 4, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(4, 4, 3, 1797.21, 3, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(5, 5, 0, 1715.34, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(6, 6, 57, 1843.80, 57, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(7, 7, 8, 1133.30, 8, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(8, 8, 35, 4526.67, 35, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(9, 9, 35, 4430.00, 35, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(10, 10, 29, 4437.50, 29, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(11, 11, 19, 4600.05, 19, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(12, 12, 32, 4437.50, 32, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(13, 13, 15, 4437.50, 15, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(14, 14, 0, 1750.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(15, 15, 45, 2694.44, 45, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(16, 16, 0, 887.50, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(17, 17, 419, 2162.50, 419, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(18, 18, 25, 2729.11, 25, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(19, 19, 4, 1733.37, 4, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(20, 20, 21, 1090.00, 21, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(21, 21, 12, 916.67, 12, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(22, 22, 14, 570.00, 14, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(23, 23, 0, 4500.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(24, 24, 13, 4537.50, 13, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(25, 25, 7, 1850.00, 7, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(26, 26, 4, 1683.33, 4, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(27, 27, 54, 5120.55, 54, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(28, 28, 27, 1750.00, 27, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(29, 29, 2, 930.72, 2, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(30, 30, 0, 1975.24, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(31, 31, 24, 4538.45, 24, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(32, 32, 0, 3083.33, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(33, 33, 0, 1856.28, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(34, 34, 25, 1690.00, 25, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(35, 35, 8, 2066.67, 8, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(36, 36, 2, 5681.47, 2, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(37, 37, 45, 1005.48, 45, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(38, 38, 1, 3662.50, 1, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(39, 39, 16, 1628.04, 16, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(40, 40, 5, 2625.61, 5, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(41, 41, 0, 899.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(42, 42, 1, 416.67, 1, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(43, 43, 2, 1594.45, 2, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(44, 44, 0, 815.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(45, 45, 9, 3045.83, 9, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(46, 46, 0, 960.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(47, 47, 0, 1005.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(48, 48, 0, 1650.04, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(49, 49, 9, 2330.00, 9, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(50, 50, 30, 5300.00, 30, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(51, 51, 0, 5000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(52, 52, 0, 14000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(53, 53, 0, 4000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(54, 54, 0, 14000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(55, 55, 0, 14000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(56, 56, 0, 5000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(57, 57, 0, 4000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(58, 58, 0, 6000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(59, 59, 0, 5000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(60, 60, 0, 4000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(61, 61, 0, 14000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(62, 62, 0, 6000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(63, 63, 0, 9000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(64, 64, 0, 8000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(65, 65, 0, 12000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(66, 66, 0, 13000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(67, 67, 0, 7000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(68, 68, 0, 11000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(69, 69, 0, 13000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(70, 70, 0, 12000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(71, 71, 0, 10000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(72, 72, 0, 5000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(73, 73, 0, 14000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(74, 74, 0, 10000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(75, 75, 0, 11000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(76, 76, 0, 5000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(77, 77, 0, 9000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(78, 78, 0, 5000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(79, 79, 0, 10000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(80, 80, 0, 3000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(81, 81, 0, 4000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00'),
(82, 82, 0, 2000.00, 0, '2025-05-28', '2025-05-27 16:00:00', '2025-05-27 16:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `tanggal_berhenti` date DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `status`, `tanggal_berhenti`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Dinda Ayu Aprilia', 'ajadinda975@gmail.com', '$2y$12$vCRXQg6bw6YzuKWhOyD9L.NkHaBDTUYLmwtCNTRwzAv9KpAZhdryC', 'admin', 'aktif', NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indexes for table `barangs`
--
ALTER TABLE `barangs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `barangs_kode_barang_unique` (`kode_barang`),
  ADD KEY `barangs_hasil_bagi_id_foreign` (`hasil_bagi_id`);

--
-- Indexes for table `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_transaksis_transaksi_id_foreign` (`transaksi_id`),
  ADD KEY `detail_transaksis_barang_id_foreign` (`barang_id`);

--
-- Indexes for table `gaji_pembayarans`
--
ALTER TABLE `gaji_pembayarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gaji_pembayarans_karyawan_id_foreign` (`karyawan_id`),
  ADD KEY `gaji_pembayarans_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `hasil_bagis`
--
ALTER TABLE `hasil_bagis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kas`
--
ALTER TABLE `kas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kasir_transaksis`
--
ALTER TABLE `kasir_transaksis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kasir_transaksis_unix_id_unique` (`unix_id`),
  ADD KEY `kasir_transaksis_user_id_foreign` (`user_id`),
  ADD KEY `kasir_transaksis_shift_id_foreign` (`shift_id`);

--
-- Indexes for table `kas_kembalian`
--
ALTER TABLE `kas_kembalian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kas_kerugians`
--
ALTER TABLE `kas_kerugians`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kas_kerugians_user_id_foreign` (`user_id`);

--
-- Indexes for table `kas_keuntungans`
--
ALTER TABLE `kas_keuntungans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kas_keuntungans_user_id_foreign` (`user_id`);

--
-- Indexes for table `kas_titipans`
--
ALTER TABLE `kas_titipans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kas_titipans_barang_id_foreign` (`barang_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengeluarans`
--
ALTER TABLE `pengeluarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengeluarans_user_id_foreign` (`user_id`);

--
-- Indexes for table `persediaans`
--
ALTER TABLE `persediaans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `persediaans_barang_id_foreign` (`barang_id`),
  ADD KEY `persediaans_kelola_id_foreign` (`kelola_id`);

--
-- Indexes for table `saldo_barang_bulanans`
--
ALTER TABLE `saldo_barang_bulanans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saldo_barang_bulanans_barang_id_foreign` (`barang_id`);

--
-- Indexes for table `saldo_kas_bulanans`
--
ALTER TABLE `saldo_kas_bulanans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `stok_masuk_barang_id_foreign` (`barang_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=301;

--
-- AUTO_INCREMENT for table `barangs`
--
ALTER TABLE `barangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gaji_pembayarans`
--
ALTER TABLE `gaji_pembayarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hasil_bagis`
--
ALTER TABLE `hasil_bagis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kas`
--
ALTER TABLE `kas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kasir_transaksis`
--
ALTER TABLE `kasir_transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kas_kembalian`
--
ALTER TABLE `kas_kembalian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kas_kerugians`
--
ALTER TABLE `kas_kerugians`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kas_keuntungans`
--
ALTER TABLE `kas_keuntungans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kas_titipans`
--
ALTER TABLE `kas_titipans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pengeluarans`
--
ALTER TABLE `pengeluarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `persediaans`
--
ALTER TABLE `persediaans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `saldo_barang_bulanans`
--
ALTER TABLE `saldo_barang_bulanans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `saldo_kas_bulanans`
--
ALTER TABLE `saldo_kas_bulanans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barangs`
--
ALTER TABLE `barangs`
  ADD CONSTRAINT `barangs_hasil_bagi_id_foreign` FOREIGN KEY (`hasil_bagi_id`) REFERENCES `hasil_bagis` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `detail_transaksis`
--
ALTER TABLE `detail_transaksis`
  ADD CONSTRAINT `detail_transaksis_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_transaksis_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `kasir_transaksis` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gaji_pembayarans`
--
ALTER TABLE `gaji_pembayarans`
  ADD CONSTRAINT `gaji_pembayarans_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gaji_pembayarans_karyawan_id_foreign` FOREIGN KEY (`karyawan_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kasir_transaksis`
--
ALTER TABLE `kasir_transaksis`
  ADD CONSTRAINT `kasir_transaksis_shift_id_foreign` FOREIGN KEY (`shift_id`) REFERENCES `shifts` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `kasir_transaksis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kas_kerugians`
--
ALTER TABLE `kas_kerugians`
  ADD CONSTRAINT `kas_kerugians_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kas_keuntungans`
--
ALTER TABLE `kas_keuntungans`
  ADD CONSTRAINT `kas_keuntungans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `kas_titipans`
--
ALTER TABLE `kas_titipans`
  ADD CONSTRAINT `kas_titipans_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pengeluarans`
--
ALTER TABLE `pengeluarans`
  ADD CONSTRAINT `pengeluarans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `persediaans`
--
ALTER TABLE `persediaans`
  ADD CONSTRAINT `persediaans_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `persediaans_kelola_id_foreign` FOREIGN KEY (`kelola_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `saldo_barang_bulanans`
--
ALTER TABLE `saldo_barang_bulanans`
  ADD CONSTRAINT `saldo_barang_bulanans_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  ADD CONSTRAINT `stok_masuk_barang_id_foreign` FOREIGN KEY (`barang_id`) REFERENCES `barangs` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
