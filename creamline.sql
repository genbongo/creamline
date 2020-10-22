-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 21, 2020 at 06:16 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `creamline`
--

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ads_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `ads_image`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, '752514387.jpg', 0, '2020-10-21 07:22:57', '2020-10-21 07:22:57'),
(2, '436991684.jpg', 0, '2020-10-21 07:23:02', '2020-10-21 07:23:02');

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `area_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `area_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `area_name`, `area_code`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Cebu City', '6000', 0, '2020-06-06 12:44:12', '2020-06-06 12:45:36'),
(2, 'Alcantara City', '6033', 0, '2020-06-06 12:44:12', '2020-06-06 12:45:36'),
(3, 'Boljoon', '6024', 0, '2020-06-06 12:44:12', '2020-06-06 12:45:36'),
(4, 'Danao City', '6004', 0, '2020-06-06 12:44:12', '2020-06-06 12:45:36'),
(5, 'Moalboal', '6032', 0, '2020-06-06 12:44:12', '2020-06-06 12:45:36'),
(6, 'Santander', '6026', 0, '2020-06-06 12:44:12', '2020-06-06 12:45:36'),
(7, 'Naga City', '6037', 0, '2020-06-06 12:44:12', '2020-06-06 12:45:36'),
(8, 'Dumanjug', '6035', 0, '2020-06-06 12:44:12', '2020-06-06 12:45:36'),
(9, 'Carcar', '6019', 0, '2020-06-06 12:44:12', '2020-06-06 12:45:36'),
(10, 'Mandaue', '6014', 0, '2020-06-06 12:44:12', '2020-06-06 12:45:36'),
(11, 'Compostela', '6003', 0, '2020-06-06 12:44:12', '2020-06-06 12:45:36'),
(12, 'Talisay City', '6045', 0, '2020-06-06 12:44:12', '2020-06-06 12:45:36');

-- --------------------------------------------------------

--
-- Table structure for table `carousels`
--

CREATE TABLE `carousels` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `carousel_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_new_arrival` tinyint(1) NOT NULL,
  `is_best_sellers` tinyint(1) NOT NULL,
  `is_carousel` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `flavor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fridges`
--

CREATE TABLE `fridges` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fridges`
--

INSERT INTO `fridges` (`id`, `user_id`, `model`, `description`, `location`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 4, 'Panasonic - 0000000001', 'This fridge is intended for backup', 'NA', 1, 0, '2020-10-21 05:50:00', '2020-10-21 05:50:10');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_05_30_144612_create_ads_table', 1),
(5, '2020_05_30_144944_create_areas_table', 1),
(6, '2020_05_30_145123_create_stores_table', 1),
(7, '2020_05_30_145220_create_fridges_table', 1),
(8, '2020_05_30_145242_create_products_table', 1),
(9, '2020_05_30_145257_create_variations_table', 1),
(10, '2020_05_30_145319_create_stocks_table', 1),
(11, '2020_05_30_145331_create_promos_table', 1),
(12, '2020_05_30_145343_create_orders_table', 1),
(13, '2020_05_30_145432_create_product_file_reports_table', 1),
(14, '2020_06_28_082050_create_carts_table', 1),
(15, '2020_07_31_071139_create_sales_report_table', 1),
(16, '2020_08_02_060748_create_notifications_table', 1),
(17, '2020_08_02_060905_create_quotas_table', 1),
(18, '2020_08_24_124726_create_carousels_table', 1),
(19, '2020_08_24_125734_create_product_reports_table', 1),
(20, '2020_10_21_130102_create_product_damages_table', 1),
(21, '2020_10_21_130637_create_product_file_damages_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `note_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `note_description`, `order_id`, `stock_id`, `user_id`, `customer_id`, `created_at`, `updated_at`) VALUES
(1, 'Thank you for ordering Creamline Products. Your Order # 1 has been accepted. Total amount purchased of PHP 1500. Please expect it to be delivered on October 23 2020.', 0, 0, 0, 4, '2020-10-21 06:00:12', '2020-10-21 06:00:12'),
(2, 'Your Replacement request # 1 has been disaproved. Please be advise accordingly', 0, 0, 0, 4, '2020-10-21 06:16:07', '2020-10-21 06:16:07'),
(3, 'Your Replacement request # 1 has been disapproved. Please be advised accordingly', 0, 0, 0, 4, '2020-10-21 06:17:51', '2020-10-21 06:17:51'),
(4, 'Your Replacement request # 1 has been accepted. Please be advised accordingly', 0, 0, 0, 4, '2020-10-21 06:18:02', '2020-10-21 06:18:02'),
(5, 'Your Replacement request # 3 has been accepted. Please be advised accordingly', 0, 0, 0, 3, '2020-10-21 07:01:52', '2020-10-21 07:01:52'),
(6, 'Your Replacement request # 2 has been accepted. Please be advised accordingly', 0, 0, 0, 4, '2020-10-21 07:02:06', '2020-10-21 07:02:06'),
(7, 'Your Replacement request # 1 has been accepted. Please be advised accordingly', 0, 0, 0, 4, '2020-10-21 07:03:28', '2020-10-21 07:03:28'),
(8, 'Your Replacement request # 1 has been accepted. Please be advised accordingly', 0, 0, 0, 4, '2020-10-21 07:03:45', '2020-10-21 07:03:45'),
(9, 'Your Replacement request # 1 has been accepted. Please be advised accordingly', 0, 0, 0, 4, '2020-10-21 07:06:26', '2020-10-21 07:06:26'),
(10, 'Your Replacement request # 1 has been disapproved. Please be advised accordingly', 0, 0, 0, 4, '2020-10-21 07:06:29', '2020-10-21 07:06:29'),
(11, 'Your Replacement request # 1 has been disapproved. Please be advised accordingly', 0, 0, 0, 4, '2020-10-21 07:07:44', '2020-10-21 07:07:44'),
(12, 'Your Replacement request # 1 has been accepted. Please be advised accordingly', 0, 0, 0, 4, '2020-10-21 07:07:48', '2020-10-21 07:07:48'),
(13, 'Your Replacement request # 1 has been accepted. Please be advised accordingly', 0, 0, 0, 4, '2020-10-21 07:08:18', '2020-10-21 07:08:18'),
(14, 'Your Replacement request # 1 has been disapproved. Please be advised accordingly', 0, 0, 0, 4, '2020-10-21 07:08:23', '2020-10-21 07:08:23'),
(15, 'Your Replacement request # 1 has been accepted. Please be advised accordingly', 0, 0, 0, 4, '2020-10-21 07:08:46', '2020-10-21 07:08:46'),
(16, 'Your Damage request # 2 has been accepted. Please be advised accordingly', 0, 0, 0, 4, '2020-10-21 07:12:55', '2020-10-21 07:12:55'),
(17, 'Your Damage request # 3 has been disapproved. Please be advised accordingly', 0, 0, 0, 3, '2020-10-21 07:14:13', '2020-10-21 07:14:13'),
(18, 'Thank you for ordering Creamline Products. Your Order # 2 has been accepted. Total amount purchased of PHP 12000. Please expect it to be delivered on October 23 2020.', 0, 0, 0, 5, '2020-10-21 07:24:19', '2020-10-21 07:24:19'),
(19, 'Thank you for ordering Creamline Products. Your Order # 3 has been accepted. Total amount purchased of PHP 4000. Please expect it to be delivered on October 26 2020.', 0, 0, 0, 5, '2020-10-21 07:24:26', '2020-10-21 07:24:26'),
(20, 'Thank you for ordering Creamline Products. Your Order # 4 has been accepted. Total amount purchased of PHP 2000. Please expect it to be delivered on October 27 2020.', 0, 0, 0, 4, '2020-10-21 08:04:49', '2020-10-21 08:04:49');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `store_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `flavor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity_ordered` int(11) NOT NULL,
  `ordered_total_price` double(8,2) NOT NULL,
  `quantity_received` int(11) NOT NULL,
  `received_total_price` double(8,2) NOT NULL,
  `is_replacement` tinyint(1) NOT NULL,
  `is_approved` tinyint(1) NOT NULL,
  `is_cancelled` tinyint(1) NOT NULL,
  `is_rescheduled` tinyint(1) NOT NULL,
  `is_completed` tinyint(1) NOT NULL,
  `attempt` int(11) NOT NULL,
  `reason` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `client_id`, `delivery_date`, `store_id`, `product_id`, `size`, `flavor`, `quantity_ordered`, `ordered_total_price`, `quantity_received`, `received_total_price`, `is_replacement`, `is_approved`, `is_cancelled`, `is_rescheduled`, `is_completed`, `attempt`, `reason`, `created_at`, `updated_at`) VALUES
(1, 4, '2020-10-23', 2, 1, '130ml', 'Ube Pandan', 100, 1500.00, 0, 0.00, 0, 1, 0, 0, 1, 0, '', '2020-10-21 05:59:50', '2020-10-21 06:00:12'),
(2, 5, '2020-10-23', 2, 3, '300ml', 'Mocha', 400, 12000.00, 0, 0.00, 0, 1, 0, 0, 0, 0, '', '2020-10-21 07:24:10', '2020-10-21 07:24:19'),
(3, 5, '2020-10-26', 2, 2, '200ml', 'Rocky Road', 200, 4000.00, 0, 0.00, 0, 1, 0, 0, 0, 0, '', '2020-10-21 07:24:10', '2020-10-21 07:24:26'),
(4, 4, '2020-10-27', 2, 2, '200ml', 'Rocky Road', 100, 2000.00, 0, 0.00, 1, 1, 0, 0, 1, 0, '', '2020-10-21 08:04:39', '2020-10-21 08:04:49');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `product_image`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Ube Pandan', 'Ube Pandan Description', '459992395.jpg', 0, '2020-10-21 05:38:40', '2020-10-21 05:58:24'),
(2, 'Chocolate Ice Cream', 'Chocolate Ice Cream Description', '457799364.jpg', 0, '2020-10-21 05:40:22', '2020-10-21 05:58:20'),
(3, 'Mocha Ice Cream', 'Mocha Ice Cream Description', '710556383.jpg', 0, '2020-10-21 05:40:42', '2020-10-21 05:58:26');

-- --------------------------------------------------------

--
-- Table structure for table `product_damages`
--

CREATE TABLE `product_damages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `flavor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `client_id` int(11) NOT NULL,
  `is_replaced` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_damages`
--

INSERT INTO `product_damages` (`id`, `order_id`, `product_id`, `size`, `flavor`, `client_id`, `is_replaced`, `created_at`, `updated_at`) VALUES
(1, 123, 2, '200ml', 'Rocky Road', 4, 1, '2020-10-21 06:46:14', '2020-10-21 07:12:09'),
(2, 981, 3, '300ml', 'Mocha', 4, 1, '2020-10-21 06:47:39', '2020-10-21 07:12:55'),
(3, 9823, 1, '130ml', 'Pandan', 3, 2, '2020-10-21 07:01:27', '2020-10-21 07:14:13');

-- --------------------------------------------------------

--
-- Table structure for table `product_file_damages`
--

CREATE TABLE `product_file_damages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_damage_id` int(11) NOT NULL,
  `file_damage_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_file_damages`
--

INSERT INTO `product_file_damages` (`id`, `product_damage_id`, `file_damage_image`, `created_at`, `updated_at`) VALUES
(1, 1, '2035176110.jpg', '2020-10-21 06:46:14', '2020-10-21 06:46:14'),
(2, 1, '496434400.jpg', '2020-10-21 06:46:14', '2020-10-21 06:46:14'),
(3, 1, '1520558426.jpg', '2020-10-21 06:46:14', '2020-10-21 06:46:14'),
(4, 2, '1072114572.jpg', '2020-10-21 06:47:39', '2020-10-21 06:47:39'),
(5, 2, '896836704.jpg', '2020-10-21 06:47:39', '2020-10-21 06:47:39'),
(6, 3, '1718847876.jpg', '2020-10-21 07:01:28', '2020-10-21 07:01:28'),
(7, 3, '1848703389.jpg', '2020-10-21 07:01:28', '2020-10-21 07:01:28');

-- --------------------------------------------------------

--
-- Table structure for table `product_file_reports`
--

CREATE TABLE `product_file_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_report_id` int(11) NOT NULL,
  `file_report_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_file_reports`
--

INSERT INTO `product_file_reports` (`id`, `product_report_id`, `file_report_image`, `created_at`, `updated_at`) VALUES
(1, 1, '2079676241.jpg', '2020-10-21 06:15:46', '2020-10-21 06:15:46'),
(2, 1, '565525583.jpg', '2020-10-21 06:15:46', '2020-10-21 06:15:46'),
(3, 1, '36114262.jpg', '2020-10-21 06:15:46', '2020-10-21 06:15:46'),
(4, 2, '207229098.jpg', '2020-10-21 06:36:29', '2020-10-21 06:36:29'),
(5, 2, '1031182858.jpg', '2020-10-21 06:36:29', '2020-10-21 06:36:29');

-- --------------------------------------------------------

--
-- Table structure for table `product_reports`
--

CREATE TABLE `product_reports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `flavor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `store_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `is_replaced` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_reports`
--

INSERT INTO `product_reports` (`id`, `product_id`, `size`, `flavor`, `store_id`, `client_id`, `is_replaced`, `created_at`, `updated_at`) VALUES
(1, 1, '140ml', 'Ube', 2, 4, 1, '2020-10-21 06:15:46', '2020-10-21 07:08:46'),
(2, 3, '330ml', 'Mocha', 2, 4, 1, '2020-10-21 06:36:29', '2020-10-21 07:02:06');

-- --------------------------------------------------------

--
-- Table structure for table `promos`
--

CREATE TABLE `promos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `promo_start_date` date NOT NULL,
  `promo_end_date` date NOT NULL,
  `promo_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `discount` double(8,2) NOT NULL,
  `product_id` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotas`
--

CREATE TABLE `quotas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `year` int(11) NOT NULL,
  `jan` int(11) NOT NULL,
  `feb` int(11) NOT NULL,
  `mar` int(11) NOT NULL,
  `apr` int(11) NOT NULL,
  `may` int(11) NOT NULL,
  `jun` int(11) NOT NULL,
  `jul` int(11) NOT NULL,
  `aug` int(11) NOT NULL,
  `sep` int(11) NOT NULL,
  `oct` int(11) NOT NULL,
  `nov` int(11) NOT NULL,
  `dev` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_report`
--

CREATE TABLE `sales_report` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `threshold` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `product_id`, `quantity`, `threshold`, `created_at`, `updated_at`) VALUES
(1, 1, 900, 100, '2020-10-21 05:38:40', '2020-10-21 06:00:12'),
(2, 2, 1700, 100, '2020-10-21 05:40:22', '2020-10-21 08:04:48'),
(3, 3, 2600, 200, '2020-10-21 05:40:42', '2020-10-21 07:24:19');

-- --------------------------------------------------------

--
-- Table structure for table `stores`
--

CREATE TABLE `stores` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `store_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `store_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `area_id` int(11) NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `stores`
--

INSERT INTO `stores` (`id`, `store_name`, `store_address`, `user_id`, `area_id`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, '', '', 3, 1, 0, '2020-10-21 05:34:27', '2020-10-21 05:34:27'),
(2, 'TonTon Store', 'Pardo Cebu City', 4, 1, 0, '2020-10-21 05:59:32', '2020-10-21 05:59:32'),
(3, 'something', 'somewhere', 5, 1, 0, '2020-10-21 07:21:08', '2020-10-21 07:21:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact_num` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_role` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_pending` tinyint(1) NOT NULL,
  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `mname`, `lname`, `address`, `contact_num`, `email`, `email_verified_at`, `password`, `user_role`, `is_active`, `is_pending`, `img`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'NA', 'NA', 'Pardo Cebu', '0912312321', 'act.dcatindoy@gmail.com', '2020-06-07 23:57:47', '$2y$10$EN8DMgNgmRlqVPmSOAvmJO9vM/VJHWvgsXkBg9A2wgLnwidiOpWDO', 99, 1, 0, 'NA', 'NA', '2020-06-06 18:42:21', '2020-06-07 23:57:47'),
(2, 'Super', 'Name', 'Admin', 'NA', '09123213123', 'admin@creamline.com', '2020-06-07 23:57:47', '$2y$10$FbbuyBRiQLrHbtXfJYl1j.uMj5cGl1yuT7kuhsamt9q7hXRHkDi8G', 99, 1, 0, 'NA', 'NA', '2020-06-06 18:45:27', '2020-06-06 18:45:27'),
(3, 'staff', 'test', 'testing', 'NA', '09123456789', 'testingstaff1@gmail.com', NULL, '$2y$10$N4MRExQt/KvuORobC.MJO.t8oh5FX5s8VxEWXHluTFcPPSpzIN12e', 1, 1, 0, 'NA', NULL, '2020-10-21 05:34:16', '2020-10-21 05:34:20'),
(4, 'Daniel', 'Torawan', 'Catindoy', 'Pardo Cebu City', '09232415169', 'testingclient1@gmail.com', NULL, '$2y$10$7/Cf8Ru8ryeCZntUlZPjleygSnlP8bLHcrdsmOUPjTAVPBONZ5rui', 2, 1, 0, 'NA', NULL, '2020-10-21 05:34:50', '2020-10-21 07:16:04'),
(5, 'dan', 'test', '2', 'somewhere', '09232415169', 'testingclient2@gmail.com', NULL, '$2y$10$yBTA58zvkdIApTxX.frAgeDClug1E3U08GDXrWWgD9stmmbGbos3W', 2, 1, 0, '', NULL, '2020-10-21 07:21:08', '2020-10-21 07:24:45');

-- --------------------------------------------------------

--
-- Table structure for table `variations`
--

CREATE TABLE `variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `flavor` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `variations`
--

INSERT INTO `variations` (`id`, `product_id`, `size`, `flavor`, `price`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 1, '120ml, 130ml, 140ml,', 'Ube, Ube Pandan, Pandan,', '10,15,20,', 0, '2020-10-21 05:38:40', '2020-10-21 05:39:51'),
(2, 2, '200ml, 220ml, 230ml,', 'Rocky Road, Chocolate,', '20,24,28,', 0, '2020-10-21 05:40:22', '2020-10-21 05:41:37'),
(3, 3, '300ml, 320ml, 330ml,', 'Mocha, Choco Mocha,', '30,35,40,', 0, '2020-10-21 05:40:43', '2020-10-21 05:42:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carousels`
--
ALTER TABLE `carousels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fridges`
--
ALTER TABLE `fridges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_damages`
--
ALTER TABLE `product_damages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_file_damages`
--
ALTER TABLE `product_file_damages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_file_reports`
--
ALTER TABLE `product_file_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_reports`
--
ALTER TABLE `product_reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promos`
--
ALTER TABLE `promos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quotas`
--
ALTER TABLE `quotas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_report`
--
ALTER TABLE `sales_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stores`
--
ALTER TABLE `stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `variations`
--
ALTER TABLE `variations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `carousels`
--
ALTER TABLE `carousels`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fridges`
--
ALTER TABLE `fridges`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_damages`
--
ALTER TABLE `product_damages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_file_damages`
--
ALTER TABLE `product_file_damages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product_file_reports`
--
ALTER TABLE `product_file_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_reports`
--
ALTER TABLE `product_reports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `promos`
--
ALTER TABLE `promos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quotas`
--
ALTER TABLE `quotas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_report`
--
ALTER TABLE `sales_report`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `stores`
--
ALTER TABLE `stores`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `variations`
--
ALTER TABLE `variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
