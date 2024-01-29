-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 26, 2023 at 08:32 AM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `workplace`
--

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE `assessments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `date_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `checkin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checkout` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `working_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `late_entry` bigint(20) DEFAULT NULL,
  `early_leave` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `location` text COLLATE utf8mb4_unicode_ci,
  `device` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `symbol` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `code`, `symbol`, `created_at`, `updated_at`) VALUES
(1, 'Leke', 'ALL', 'Lek', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(2, 'Dollars', 'USD', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(3, 'Afghanis', 'AFN', '؋', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(4, 'Pesos', 'ARS', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(5, 'Guilders', 'AWG', 'ƒ', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(6, 'Dollars', 'AUD', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(7, 'New Manats', 'AZN', 'ман', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(8, 'Dollars', 'BSD', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(9, 'Dollars', 'BBD', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(10, 'Rubles', 'BYR', 'p.', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(11, 'Euro', 'EUR', '€', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(12, 'Dollars', 'BZD', 'BZ$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(13, 'Dollars', 'BMD', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(14, 'Bolivianos', 'BOB', '$b', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(15, 'Convertible Marka', 'BAM', 'KM', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(16, 'Pula', 'BWP', 'P', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(17, 'Leva', 'BGN', 'лв', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(18, 'Reais', 'BRL', 'R$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(19, 'Pounds', 'GBP', '£', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(20, 'Dollars', 'BND', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(21, 'Riels', 'KHR', '៛', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(22, 'Dollars', 'CAD', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(23, 'Dollars', 'KYD', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(24, 'Pesos', 'CLP', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(25, 'Yuan Renminbi', 'CNY', '¥', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(26, 'Pesos', 'COP', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(27, 'Colón', 'CRC', '₡', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(28, 'Kuna', 'HRK', 'kn', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(29, 'Pesos', 'CUP', '₱', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(30, 'Koruny', 'CZK', 'Kč', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(31, 'Kroner', 'DKK', 'kr', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(32, 'Pesos', 'DOP ', 'RD$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(33, 'Dollars', 'XCD', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(34, 'Pounds', 'EGP', '£', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(35, 'Colones', 'SVC', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(36, 'Pounds', 'FKP', '£', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(37, 'Dollars', 'FJD', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(38, 'Cedis', 'GHC', '¢', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(39, 'Pounds', 'GIP', '£', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(40, 'Quetzales', 'GTQ', 'Q', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(41, 'Pounds', 'GGP', '£', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(42, 'Dollars', 'GYD', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(43, 'Lempiras', 'HNL', 'L', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(44, 'Dollars', 'HKD', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(45, 'Forint', 'HUF', 'Ft', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(46, 'Kronur', 'ISK', 'kr', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(47, 'Rupees', 'INR', 'Rp', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(48, 'Rupiahs', 'IDR', 'Rp', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(49, 'Rials', 'IRR', '﷼', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(50, 'Pounds', 'IMP', '£', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(51, 'New Shekels', 'ILS', '₪', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(52, 'Dollars', 'JMD', 'J$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(53, 'Yen', 'JPY', '¥', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(54, 'Pounds', 'JEP', '£', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(55, 'Tenge', 'KZT', 'лв', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(56, 'Won', 'KPW', '₩', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(57, 'Won', 'KRW', '₩', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(58, 'Soms', 'KGS', 'лв', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(59, 'Kips', 'LAK', '₭', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(60, 'Lati', 'LVL', 'Ls', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(61, 'Pounds', 'LBP', '£', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(62, 'Dollars', 'LRD', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(63, 'Switzerland Francs', 'CHF', 'CHF', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(64, 'Litai', 'LTL', 'Lt', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(65, 'Denars', 'MKD', 'ден', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(66, 'Ringgits', 'MYR', 'RM', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(67, 'Rupees', 'MUR', '₨', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(68, 'Pesos', 'MXN', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(69, 'Tugriks', 'MNT', '₮', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(70, 'Meticais', 'MZN', 'MT', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(71, 'Dollars', 'NAD', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(72, 'Rupees', 'NPR', '₨', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(73, 'Guilders', 'ANG', 'ƒ', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(74, 'Dollars', 'NZD', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(75, 'Cordobas', 'NIO', 'C$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(76, 'Nairas', 'NGN', '₦', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(77, 'Krone', 'NOK', 'kr', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(78, 'Rials', 'OMR', '﷼', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(79, 'Rupees', 'PKR', '₨', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(80, 'Balboa', 'PAB', 'B/.', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(81, 'Guarani', 'PYG', 'Gs', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(82, 'Nuevos Soles', 'PEN', 'S/.', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(83, 'Pesos', 'PHP', 'Php', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(84, 'Zlotych', 'PLN', 'zł', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(85, 'Rials', 'QAR', '﷼', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(86, 'New Lei', 'RON', 'lei', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(87, 'Rubles', 'RUB', 'руб', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(88, 'Pounds', 'SHP', '£', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(89, 'Riyals', 'SAR', '﷼', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(90, 'Dinars', 'RSD', 'Дин.', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(91, 'Rupees', 'SCR', '₨', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(92, 'Dollars', 'SGD', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(93, 'Dollars', 'SBD', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(94, 'Shillings', 'SOS', 'S', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(95, 'Rand', 'ZAR', 'R', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(96, 'Rupees', 'LKR', '₨', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(97, 'Kronor', 'SEK', 'kr', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(98, 'Dollars', 'SRD', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(99, 'Pounds', 'SYP', '£', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(100, 'New Dollars', 'TWD', 'NT$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(101, 'Baht', 'THB', '฿', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(102, 'Dollars', 'TTD', 'TT$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(103, 'Lira', 'TRY', 'TL', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(104, 'Liras', 'TRL', '£', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(105, 'Dollars', 'TVD', '$', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(106, 'Hryvnia', 'UAH', '₴', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(107, 'Pesos', 'UYU', '$U', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(108, 'Sums', 'UZS', 'лв', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(109, 'Bolivares Fuertes', 'VEF', 'Bs', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(110, 'Dong', 'VND', '₫', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(111, 'Rials', 'YER', '﷼', '2023-09-06 12:58:29', '2023-09-06 12:58:29'),
(112, 'Zimbabwe Dollars', 'ZWD', 'Z$', '2023-09-06 12:58:29', '2023-09-06 12:58:29');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_items`
--

CREATE TABLE `inventory_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `assigned_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `responsible_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `identification` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_applications`
--

CREATE TABLE `leave_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `from_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `working_day` int(11) DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payslips`
--

CREATE TABLE `payslips` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `net_salary` double DEFAULT NULL,
  `bonus` double DEFAULT NULL,
  `penalty` double DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `month_of_salary` timestamp NULL DEFAULT NULL,
  `note` text COLLATE utf8_unicode_ci,
  `email_sent` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `performances`
--

CREATE TABLE `performances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `ratings` text COLLATE utf8mb4_unicode_ci,
  `remarks` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `performance_types`
--

CREATE TABLE `performance_types` (
  `id` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `page_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `route_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `type`, `description`, `created_at`, `updated_at`) VALUES
(1, 'system_currency', '2', '2023-09-06 10:07:17', '2023-09-21 09:00:53'),
(4, 'website_title', 'Creativeitem Workplace', '2023-09-06 12:50:26', '2023-09-21 09:00:53'),
(5, 'website_description', 'Totam distinctio La', '2023-09-06 12:50:26', '2023-09-21 09:00:53'),
(6, 'author', 'Tenetur unde explica', '2023-09-06 12:50:26', '2023-09-21 09:00:53'),
(7, 'system_email', 'myhux@mailinator.com', '2023-09-06 12:50:26', '2023-09-21 09:00:53'),
(8, 'phone', '+1 (566) 996-8764', '2023-09-06 12:50:26', '2023-09-21 09:00:53'),
(9, 'address', 'Eiusmod unde volupta', '2023-09-06 12:50:26', '2023-09-21 09:00:53'),
(10, 'system_language', NULL, '2023-09-06 12:50:26', '2023-09-06 13:33:26'),
(11, 'purchase_code', 'test', '2023-09-06 12:50:26', '2023-09-21 09:00:53'),
(12, 'system_name', 'Workplace', '2023-09-06 13:06:09', '2023-09-21 09:00:53'),
(14, 'timezone', 'Asia/Dhaka', '2023-09-06 13:06:09', '2023-09-21 09:00:53'),
(15, 'smtp_settings', '{\"protocol\":\"smtp\",\"security\":\"tls\",\"host\":\"smtp.gmail.com\",\"port\":\"587\",\"from_email\":\"pollobtesting@gmail.com\",\"username\":\"pollobtesting@gmail.com\",\"password\":\"atdeswbbfregelhw\"}', '2023-09-06 13:06:09', '2023-09-21 08:58:14'),
(16, 'version', '1.0', '2023-09-06 13:06:09', '2023-09-11 07:56:41'),
(17, 'light_logo', 'uploads/system/logo/1695296020-8mNsCXfEOwlQvPpDKWd7nHYFk.png', '2023-09-19 06:11:57', '2023-09-21 11:33:40'),
(18, 'dark_logo', 'uploads/system/logo/1695295997-kDfuhXHIbZGdPtpNELYawomMv.png', '2023-09-19 06:15:13', '2023-09-21 11:33:18'),
(19, 'favicon', 'uploads/system/logo/1695295977-1H8sdqSu2b4vMcCaywY65imGe.png', '2023-09-19 06:15:23', '2023-09-21 11:32:57');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_completed` int(11) DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timesheets`
--

CREATE TABLE `timesheets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `from_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `working_time` bigint(20) DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `location` text COLLATE utf8mb4_unicode_ci,
  `device` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alternative_phone` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rel_of_alternative_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_group` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `present_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permanent_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort` bigint(20) DEFAULT '0',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assessments`
--
ALTER TABLE `assessments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_items_branch_id_index` (`branch_id`),
  ADD KEY `inventory_items_type_id_index` (`type_id`),
  ADD KEY `inventory_items_assigned_user_id_index` (`assigned_user_id`),
  ADD KEY `inventory_items_responsible_user_id_index` (`responsible_user_id`);

--
-- Indexes for table `leave_applications`
--
ALTER TABLE `leave_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payslips`
--
ALTER TABLE `payslips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `performances`
--
ALTER TABLE `performances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `performance_types`
--
ALTER TABLE `performance_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timesheets`
--
ALTER TABLE `timesheets`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `assessments`
--
ALTER TABLE `assessments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_items`
--
ALTER TABLE `inventory_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_applications`
--
ALTER TABLE `leave_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payslips`
--
ALTER TABLE `payslips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `performances`
--
ALTER TABLE `performances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `performance_types`
--
ALTER TABLE `performance_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `timesheets`
--
ALTER TABLE `timesheets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
