-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2020 at 05:15 PM
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
-- Database: `UKSHOP_DEV`
--

-- --------------------------------------------------------

--
-- Table structure for table `ACC_VAT_CLASS`
--

CREATE TABLE `ACC_VAT_CLASS` (
  `PK_NO` int(11) NOT NULL,
  `CODE` varchar(4) DEFAULT NULL,
  `NAME` varchar(20) DEFAULT NULL,
  `RATE` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `ACC_VAT_CLASS`
--

INSERT INTO `ACC_VAT_CLASS` (`PK_NO`, `CODE`, `NAME`, `RATE`) VALUES
(1, '001', 'CLASS ONE', 10),
(2, '002', 'CLASS TWO', 12);

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_id` bigint(20) UNSIGNED NOT NULL,
  `profile_pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_pic_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pic_mime_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `first_name`, `last_name`, `designation`, `auth_id`, `profile_pic`, `profile_pic_url`, `pic_mime_type`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'Super', 'Admin', 'Super', 1, NULL, NULL, NULL, 1, NULL, NULL, NULL),
(4, 'Admin', 'General', 'General Admin', 2, 'profile_04102020_1601816795.jpg', 'http://www.boilerplate-admin.local/media/images/profile/profile_04102020_1601816795.jpg', NULL, 1, '2020-10-04 07:06:35', '2020-10-04 07:06:35', NULL),
(6, 'Sale', 'Manager', 'Sales', 16, 'profile_10102020_1602327568.jpg', 'http://www.boilerplate-admin.local/media/images/profile/profile_10102020_1602327568.jpg', NULL, 1, '2020-10-10 04:59:28', '2020-10-10 04:59:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auths`
--

CREATE TABLE `auths` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_no` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salt` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL COMMENT '1 = Admin',
  `gender` tinyint(4) NOT NULL DEFAULT 1,
  `dob` date DEFAULT NULL,
  `facebook_id` bigint(20) DEFAULT NULL,
  `google_id` bigint(20) DEFAULT NULL,
  `activation_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activation_code_expire` datetime DEFAULT NULL,
  `is_first_login` tinyint(4) NOT NULL DEFAULT 1,
  `user_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Admin',
  `can_login` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = Can login, 0 = Can not login',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = Active, 0 = Inactive',
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `updated_by` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `auths`
--

INSERT INTO `auths` (`id`, `username`, `email`, `mobile_no`, `password`, `salt`, `model_id`, `gender`, `dob`, `facebook_id`, `google_id`, `activation_code`, `activation_code_expire`, `is_first_login`, `user_type`, `can_login`, `status`, `created_by`, `updated_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'sadmin', 'admin@admin.com', '0171682457', '$2y$10$pgUbaikD7i6KRxghQ6DQH.GrgzvY26BC7nC00tVTHz5rcWxt/i242', NULL, 0, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 0, NULL, NULL, NULL),
(2, 'admin', 'gadmin@admin.com', '01716824758', '$2y$10$aAANKQzyqfRinNTVZ1tlfesvIGYHWa4.Hg5IER24IiykshzpqhZeC', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 0, NULL, '2020-10-04 07:06:35', '2020-10-04 07:06:35'),
(16, 'sales', 'sales@admin.com', '01716824760', '$2y$10$JTCFFw9aT5Pnl3zHK3jk/OOcM2ZvFkSK1RIBMmR9BqH7Q07kI5Ou.', NULL, 1, 0, NULL, NULL, NULL, NULL, NULL, 1, 0, 1, 1, 0, 0, NULL, '2020-10-10 04:59:28', '2020-10-10 05:04:33');

-- --------------------------------------------------------

--
-- Table structure for table `auth_role`
--

CREATE TABLE `auth_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `auth_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `USER_GROUP_ID` int(11) DEFAULT NULL,
  `CUSTOM_PERMISSION` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `auth_role`
--

INSERT INTO `auth_role` (`id`, `auth_id`, `role_id`, `USER_GROUP_ID`, `CUSTOM_PERMISSION`, `created_at`, `updated_at`) VALUES
(1, 2, 8, 3, NULL, '2020-10-04 07:06:35', '2020-10-10 04:31:06'),
(2, 16, 0, 0, NULL, '2020-10-10 04:59:28', '2020-10-10 04:59:28');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gyms`
--

CREATE TABLE `gyms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `moto` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `established` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `updated_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `deleted_by` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gyms`
--

INSERT INTO `gyms` (`id`, `name`, `code`, `moto`, `address`, `established`, `logo`, `logo_url`, `banner`, `banner_url`, `status`, `created_by`, `updated_by`, `deleted_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Banani', '001', 'We Build', 'Banani', '1999', 'logo_04102020_1601816194.png', 'http://www.boilerplate-admin.local/media/images/gym/logo_04102020_1601816194.png', 'banner_04102020_1601816194.jpg', 'http://www.boilerplate-admin.local/media/images/gym/banner_04102020_1601816194.jpg', 1, 0, 0, 0, '2020-10-04 06:56:34', '2020-10-04 06:56:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `INV_STOCK`
--

CREATE TABLE `INV_STOCK` (
  `PK_NO` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `INV_WAREHOUSE`
--

CREATE TABLE `INV_WAREHOUSE` (
  `PK_NO` int(11) NOT NULL,
  `CODE` varchar(4) DEFAULT NULL,
  `NAME` varchar(200) DEFAULT NULL,
  `LOCATION` varchar(200) DEFAULT NULL,
  `ADDRESS` varchar(200) DEFAULT NULL,
  `MANAGER` varchar(200) DEFAULT NULL,
  `CONTACT_PHONE` varchar(50) DEFAULT NULL,
  `COUNTRY_NAME` varchar(50) DEFAULT NULL,
  `F_COUNTRY_NO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_100000_create_password_resets_table', 1),
(2, '2019_08_19_000000_create_failed_jobs_table', 1),
(3, '2019_09_30_123517_create_permission_groups_table', 1),
(4, '2019_09_30_123523_create_permissions_table', 1),
(5, '2019_09_30_123524_create_roles_table', 1),
(6, '2019_09_30_123525_create_group_role_permission_table', 1),
(7, '2019_09_30_123526_create_models_table', 1),
(8, '2019_09_30_123527_create_auths_table', 1),
(9, '2019_09_30_123528_create_auth_group_role_table', 1),
(10, '2019_10_01_073858_create_admin_users_table', 1),
(11, '2019_10_02_073857_create_users_table', 1),
(12, '2020_01_21_060402_create_tokens_table', 1),
(13, '2020_01_22_190558_create_verify_mobile_no_table', 1),
(14, '2020_01_28_173236_create_table_workout_body_part', 1),
(15, '2020_01_28_173340_create_table_workout_items', 1),
(16, '2020_02_12_064858_create_gyms_table', 1),
(17, '2020_02_18_102849_add_gym_id_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `models`
--

CREATE TABLE `models` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_key` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_class_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission_group_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `permission_group_id`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(10, 'view_dashboard', 'View', 7, 1, NULL, '2020-10-08 00:25:12', '2020-10-08 00:25:12'),
(11, 'view_admin_user', 'View', 9, 1, NULL, '2020-10-08 00:27:01', '2020-10-08 00:27:01'),
(12, 'add_admin_user', 'Add', 9, 1, NULL, '2020-10-08 00:27:23', '2020-10-08 00:27:23'),
(13, 'edit_admin_user', 'Edit', 9, 1, NULL, '2020-10-08 00:27:38', '2020-10-08 00:27:38'),
(14, 'delete_admin_user', 'Delete', 9, 1, NULL, '2020-10-08 00:27:57', '2020-10-08 00:27:57'),
(15, 'execute_admin_user', 'Execute', 9, 1, NULL, '2020-10-08 00:28:13', '2020-10-08 00:28:13'),
(16, 'view_role', 'View', 8, 1, NULL, '2020-10-08 00:30:09', '2020-10-08 00:30:09'),
(17, 'add_role', 'Add', 8, 1, NULL, '2020-10-08 00:30:20', '2020-10-08 00:30:20'),
(18, 'edit_role', 'Edit', 8, 1, NULL, '2020-10-08 00:30:30', '2020-10-08 00:30:30'),
(19, 'delete_role', 'Delete', 8, 1, NULL, '2020-10-08 00:30:43', '2020-10-08 00:30:43'),
(20, 'execute_role', 'Execute', 8, 1, NULL, '2020-10-08 00:30:53', '2020-10-08 00:30:53'),
(21, 'view_menu', 'View', 10, 1, NULL, '2020-10-08 02:46:54', '2020-10-08 03:17:16'),
(22, 'new_menu', 'Add', 10, 1, NULL, '2020-10-08 02:47:09', '2020-10-08 03:17:26'),
(23, 'edit_menu', 'Edit', 10, 1, NULL, '2020-10-08 02:47:30', '2020-10-08 03:17:34'),
(24, 'delete_menu', 'Delete', 10, 1, NULL, '2020-10-08 02:48:04', '2020-10-08 03:17:48'),
(25, 'view_action', 'View', 11, 1, NULL, '2020-10-08 03:18:47', '2020-10-08 03:18:47'),
(26, 'new_action', 'Add', 11, 1, NULL, '2020-10-08 03:19:23', '2020-10-08 03:19:23'),
(27, 'edit_action', 'Edit', 11, 1, NULL, '2020-10-08 03:19:43', '2020-10-08 03:19:43'),
(28, 'delete_action', 'Delete', 11, 1, NULL, '2020-10-08 03:19:52', '2020-10-08 03:19:52'),
(29, 'assign_user_access', 'Can Assign User Access', 12, 1, NULL, '2020-10-10 05:51:48', '2020-10-10 05:51:48'),
(30, 'view_product', 'View', 10, 1, NULL, '2020-10-17 11:48:56', '2020-10-17 11:48:56'),
(31, 'new_prodcut', 'New', 10, 1, NULL, '2020-10-17 11:51:32', '2020-10-17 11:51:32');

-- --------------------------------------------------------

--
-- Table structure for table `permission_groups`
--

CREATE TABLE `permission_groups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_groups`
--

INSERT INTO `permission_groups` (`id`, `group_name`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(4, 'Gym1', 1, NULL, '2020-10-04 06:44:24', '2020-10-07 07:05:29'),
(5, 'Workout Items', 1, NULL, '2020-10-04 07:19:15', '2020-10-04 07:19:15'),
(6, 'Body Parts', 1, NULL, '2020-10-04 07:42:50', '2020-10-04 07:42:50'),
(7, 'Dashboard', 1, NULL, '2020-10-08 00:22:11', '2020-10-08 00:22:11'),
(8, 'User role', 1, NULL, '2020-10-08 00:22:35', '2020-10-08 00:22:35'),
(9, 'Admin User', 1, NULL, '2020-10-08 00:23:50', '2020-10-08 00:23:50'),
(10, 'Menu', 1, NULL, '2020-10-08 02:36:05', '2020-10-08 02:36:05'),
(11, 'Action', 1, NULL, '2020-10-08 03:15:36', '2020-10-08 03:15:36'),
(12, 'Assign Access', 1, NULL, '2020-10-10 05:51:17', '2020-10-10 05:51:17');

-- --------------------------------------------------------

--
-- Table structure for table `PRC_IMG_LIBRARY`
--

CREATE TABLE `PRC_IMG_LIBRARY` (
  `PK_NO` int(11) NOT NULL,
  `F_INV_STOCK_IN_NO` int(11) DEFAULT NULL,
  `F_FILE_TYPE_NO` int(11) DEFAULT NULL,
  `FILE_EXT` varchar(20) DEFAULT NULL,
  `RELATIVE_PATH` varchar(200) DEFAULT NULL,
  `SERIAL_NO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Table structure for table `PRC_STOCK_IN`
--

CREATE TABLE `PRC_STOCK_IN` (
  `PK_NO` int(11) NOT NULL,
  `CODE` varchar(20) DEFAULT NULL,
  `INVOICE_NO` varchar(200) DEFAULT NULL,
  `INVOICE_DATE` date DEFAULT NULL,
  `INVOICE_CURRENCY` varchar(20) DEFAULT NULL,
  `F_SS_CURRENCY_NO` int(11) DEFAULT NULL,
  `TOTAL_QTY` int(11) DEFAULT NULL,
  `DISCOUNT_PERCENTAGE` float DEFAULT NULL,
  `DISCOUNT_AMOUNT` float DEFAULT NULL,
  `RECIEVED_QTY` int(11) DEFAULT NULL,
  `VENDOR_NAME` varchar(200) DEFAULT NULL,
  `F_PURCHASER_USER_NO` int(11) DEFAULT NULL,
  `F_VENDOR_NO` int(11) DEFAULT NULL,
  `INVOICE_TOTAL_EXCEPT_VAT_RM` float DEFAULT NULL,
  `INVOICE_TOTAL_VAT_RM` float DEFAULT NULL,
  `INVOICE_TOTAL_RM` float DEFAULT NULL,
  `INVOICE_TOTAL_EXCEPT_VAT_GBP` float DEFAULT NULL,
  `INVOICE_TOTAL_VAT_GBP` float DEFAULT NULL,
  `INVOICE_TOTAL_GBP` float DEFAULT NULL,
  `INVOICE_TOTAL_EXCEPT_VAT_AC` float DEFAULT NULL,
  `INVOICE_TOTAL_VAT_AC` float DEFAULT NULL,
  `INVOICE_TOTAL_AC` int(11) DEFAULT NULL,
  `HAS_VAT_REFUND` int(11) DEFAULT NULL,
  `GBP_TO_MR_RATE` float DEFAULT NULL,
  `AC_TO_GBP_RATE` float DEFAULT NULL,
  `VAT_CLAIMED` int(11) DEFAULT 0,
  `HAS_LOYALTY` int(11) DEFAULT NULL,
  `LOYALTY_CLAIMED` int(11) DEFAULT NULL,
  `INV_STOCK_RECORD_GENERATED` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `PRC_STOCK_IN`
--

INSERT INTO `PRC_STOCK_IN` (`PK_NO`, `CODE`, `INVOICE_NO`, `INVOICE_DATE`, `INVOICE_CURRENCY`, `F_SS_CURRENCY_NO`, `TOTAL_QTY`, `DISCOUNT_PERCENTAGE`, `DISCOUNT_AMOUNT`, `RECIEVED_QTY`, `VENDOR_NAME`, `F_PURCHASER_USER_NO`, `F_VENDOR_NO`, `INVOICE_TOTAL_EXCEPT_VAT_RM`, `INVOICE_TOTAL_VAT_RM`, `INVOICE_TOTAL_RM`, `INVOICE_TOTAL_EXCEPT_VAT_GBP`, `INVOICE_TOTAL_VAT_GBP`, `INVOICE_TOTAL_GBP`, `INVOICE_TOTAL_EXCEPT_VAT_AC`, `INVOICE_TOTAL_VAT_AC`, `INVOICE_TOTAL_AC`, `HAS_VAT_REFUND`, `GBP_TO_MR_RATE`, `AC_TO_GBP_RATE`, `VAT_CLAIMED`, `HAS_LOYALTY`, `LOYALTY_CLAIMED`, `INV_STOCK_RECORD_GENERATED`) VALUES
(4, '541', 'invoice#number', '2020-10-19', 'Ringgit', 2, 20, 2, 300, 15, 'ABCD Vendor', 6, 39, 4800, 200, 5000, 960, 40, 1000, NULL, NULL, NULL, 1, 5, NULL, 0, 1, NULL, 0),
(5, 'sdf', 'invoice#number', '2020-10-20', 'Ringgit', 2, 30, 5, 200, 20, 'Vendor Name Two', 4, 31, NULL, NULL, NULL, 0, 0, 0, NULL, NULL, NULL, 1, 5, NULL, 0, 1, NULL, 0),
(6, '414', 'invoice#2514', '2020-10-20', 'Pound', 1, 20, 2, 198, 10, 'ABCD Vendor', 4, 39, 10500, 1500, 12000, 1750, 250, 2000, NULL, NULL, NULL, 1, 6, NULL, 0, 1, NULL, 0),
(7, '5142', 'invoice#9584', '2020-10-20', 'TAKA', 3, 10, 2, 50, 5, 'ABCD Vendor', 6, 39, 20.6422, 2.29358, 22.9358, 4.12844, 0.458716, 4.58716, 450, 50, 500, 0, 5, 109, 0, 0, NULL, 0),
(8, 'Test invoice', '011', '2020-10-21', 'Pound', 1, 10, 0, 0, 1, 'Vendor Name Two', 4, 31, 20450, 50, 25000, 4090, 10, 5000, NULL, NULL, NULL, 1, 5, NULL, 0, 1, NULL, 0),
(9, '12312', '123123', '2020-10-21', 'Pound', 1, 10, 10, 10, 8, 'ABCD Vendor', 6, 39, 5400, 600, 6000, 1080, 120, 1200, NULL, NULL, NULL, 1, 5, NULL, 0, 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `PRC_STOCK_IN_DETAILS`
--

CREATE TABLE `PRC_STOCK_IN_DETAILS` (
  `PK_NO` int(11) NOT NULL,
  `F_PRC_STOCK_IN` int(11) DEFAULT NULL,
  `CODE` varchar(20) DEFAULT NULL,
  `F_PRD_VARIANT_NO` int(11) DEFAULT NULL,
  `PRD_VARIANT_NAME` varchar(200) DEFAULT NULL,
  `INVOICE_NAME` varchar(200) DEFAULT NULL,
  `HS_CODE` varchar(20) DEFAULT NULL,
  `BAR_CODE` varchar(200) DEFAULT NULL,
  `UNIT_PRICE_MR` float DEFAULT NULL,
  `UNIT_VAT_MR` float DEFAULT NULL,
  `UNIT_TOTAL_MR` float DEFAULT NULL,
  `SUB_TOTAL_MR` float DEFAULT NULL,
  `UNIT_PRICE_GBP` float DEFAULT NULL,
  `UNIT_VAT_GBP` float DEFAULT NULL,
  `UNIT_TOTAL_GBP` float DEFAULT NULL,
  `SUB_TOTAL_GBP` float DEFAULT NULL,
  `UNIT_PRICE_AC` float DEFAULT NULL,
  `UNIT_VAT_AC` float DEFAULT NULL,
  `UNIT_TOTAL_AC` float DEFAULT NULL,
  `SUB_TOTAL_AC` float DEFAULT NULL,
  `QTY` int(11) DEFAULT NULL,
  `RECIEVED_QTY` int(11) DEFAULT NULL,
  `FAULTY_QTY` int(11) DEFAULT NULL,
  `CURRENCY` varchar(20) DEFAULT NULL,
  `SERIAL_NO` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `PRC_STOCK_IN_DETAILS`
--

INSERT INTO `PRC_STOCK_IN_DETAILS` (`PK_NO`, `F_PRC_STOCK_IN`, `CODE`, `F_PRD_VARIANT_NO`, `PRD_VARIANT_NAME`, `INVOICE_NAME`, `HS_CODE`, `BAR_CODE`, `UNIT_PRICE_MR`, `UNIT_VAT_MR`, `UNIT_TOTAL_MR`, `SUB_TOTAL_MR`, `UNIT_PRICE_GBP`, `UNIT_VAT_GBP`, `UNIT_TOTAL_GBP`, `SUB_TOTAL_GBP`, `UNIT_PRICE_AC`, `UNIT_VAT_AC`, `UNIT_TOTAL_AC`, `SUB_TOTAL_AC`, `QTY`, `RECIEVED_QTY`, `FAULTY_QTY`, `CURRENCY`, `SERIAL_NO`) VALUES
(4, 4, NULL, 11, 'New Furniture red', 'invName1', '101', '101', 10.4, 5, 104.2, 90.8, 52, 25, 521, 454, NULL, NULL, NULL, NULL, 12, 1, 2, 'MY Ringit', NULL),
(5, 5, NULL, 11, 'New Furniture red', 'invName4', '101', '101', 50.2, 0.4, 249, 2502.4, 251, 2, 1245, 12512, NULL, NULL, NULL, NULL, 14, 4, 1, 'MY Ringit', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `PRC_VENDORS`
--

CREATE TABLE `PRC_VENDORS` (
  `PK_NO` int(11) NOT NULL,
  `CODE` varchar(4) DEFAULT NULL,
  `NAME` varchar(200) DEFAULT NULL,
  `ADDRESS` varchar(200) DEFAULT NULL,
  `PHONE` varchar(100) DEFAULT NULL,
  `F_COUNTRY` int(11) DEFAULT NULL,
  `COUNTRY` varchar(100) DEFAULT NULL,
  `F_ACC_CODE` varchar(100) DEFAULT NULL,
  `ACC_CODE` varchar(100) DEFAULT NULL,
  `HAS_LOYALITY` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `PRC_VENDORS`
--

INSERT INTO `PRC_VENDORS` (`PK_NO`, `CODE`, `NAME`, `ADDRESS`, `PHONE`, `F_COUNTRY`, `COUNTRY`, `F_ACC_CODE`, `ACC_CODE`, `HAS_LOYALITY`) VALUES
(31, '413', 'Vendor Name Two', 'Vendor Address', '01744894452', 2, 'Malaysia', NULL, NULL, 1),
(39, '9584', 'ABCD Vendor', 'Dhaka', '01937106466', 1, 'United Kingdom ', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `PRD_BRAND`
--

CREATE TABLE `PRD_BRAND` (
  `PK_NO` int(11) NOT NULL,
  `CODE` varchar(100) DEFAULT NULL,
  `NAME` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Brand Master Setup Table' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `PRD_BRAND`
--

INSERT INTO `PRD_BRAND` (`PK_NO`, `CODE`, `NAME`) VALUES
(36, 'GAP', 'GAP'),
(37, 'RFL', 'RFL'),
(38, 'S', 'SQUARE');

--
-- Triggers `PRD_BRAND`
--
DELIMITER $$
CREATE TRIGGER `BEFORE_PRD_BRAND_INSERT` BEFORE INSERT ON `PRD_BRAND` FOR EACH ROW BEGIN
declare PKCODE varchar(20) default 0;

IF NEW.CODE IS NULL THEN

select auto_increment into PKCODE
from information_schema.tables
where table_name = 'PRD_BRAND'
and table_schema = database();
SET NEW.CODE = PKCODE ;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `PRD_CATEGORY`
--

CREATE TABLE `PRD_CATEGORY` (
  `PK_NO` int(11) NOT NULL,
  `CODE` varchar(4) DEFAULT NULL,
  `NAME` varchar(20) DEFAULT NULL,
  `HS_PREFIX` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='CATEGORY Master Setup Table' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `PRD_CATEGORY`
--

INSERT INTO `PRD_CATEGORY` (`PK_NO`, `CODE`, `NAME`, `HS_PREFIX`) VALUES
(36, '46', 'House Holds', NULL),
(37, '47', 'Clothes', NULL),
(38, '48', 'Health', NULL);

--
-- Triggers `PRD_CATEGORY`
--
DELIMITER $$
CREATE TRIGGER `BEFORE_PRD_CATEGORY_INSERT` BEFORE INSERT ON `PRD_CATEGORY` FOR EACH ROW BEGIN
declare PKCODE int(2) default 0;

IF NEW.CODE IS NULL THEN

select auto_increment into PKCODE
from information_schema.tables
where table_name = 'PRD_CATEGORY'
and table_schema = database();
	SET NEW.CODE = PKCODE+10 ;
END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `PRD_COLOR`
--

CREATE TABLE `PRD_COLOR` (
  `PK_NO` int(11) NOT NULL,
  `CODE` varchar(100) DEFAULT NULL,
  `NAME` varchar(20) DEFAULT NULL,
  `F_BRAND` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Size Master Setup Table' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `PRD_COLOR`
--

INSERT INTO `PRD_COLOR` (`PK_NO`, `CODE`, `NAME`, `F_BRAND`) VALUES
(77, 'GR', 'Red', 36),
(78, 'GB', 'BLACK', 36),
(79, 'RR', 'RED', 37),
(80, 'RB', 'BLACK', 37);

-- --------------------------------------------------------

--
-- Table structure for table `PRD_IMG_LIBRARY`
--

CREATE TABLE `PRD_IMG_LIBRARY` (
  `PK_NO` int(11) NOT NULL,
  `F_PRD_MASTER_NO` int(11) DEFAULT NULL,
  `F_PRD_VARIANT_NO` int(11) DEFAULT NULL,
  `IS_MASTER` int(11) DEFAULT NULL,
  `F_FILE_TYPE` int(11) DEFAULT NULL,
  `FILE_EXT` varchar(20) DEFAULT NULL,
  `RELATIVE_PATH` varchar(200) DEFAULT NULL,
  `SERIAL_NO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `PRD_IMG_LIBRARY`
--

INSERT INTO `PRD_IMG_LIBRARY` (`PK_NO`, `F_PRD_MASTER_NO`, `F_PRD_VARIANT_NO`, `IS_MASTER`, `F_FILE_TYPE`, `FILE_EXT`, `RELATIVE_PATH`, `SERIAL_NO`) VALUES
(8, 48, NULL, 1, 1, 'png', '/media/images/products/48/prod_22102020_5f9181b699963.png', 0),
(9, NULL, 11, 0, 1, 'jpg', '/media/images/products/48/prod_22102020_5f91822870582.jpg', 0),
(10, NULL, 12, 0, 1, 'jpg', '/media/images/products/50/prod_22102020_5f91912a0b83c.jpg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `PRD_MASTER_SETUP`
--

CREATE TABLE `PRD_MASTER_SETUP` (
  `PK_NO` int(11) NOT NULL,
  `F_PRD_SUB_CATEGORY_ID` int(11) DEFAULT NULL,
  `CODE` varchar(40) DEFAULT NULL,
  `COMPOSITE_CODE` varchar(100) DEFAULT NULL,
  `DEFAULT_NAME` varchar(200) DEFAULT NULL,
  `DEFAULT_CUSTOMS_NAME` varchar(200) DEFAULT NULL,
  `DEFAULT_HS_CODE` varchar(20) DEFAULT NULL,
  `F_BRAND` int(11) DEFAULT NULL,
  `BRAND_NAME` varchar(20) DEFAULT NULL,
  `F_MODEL` int(11) DEFAULT NULL,
  `MODEL_NAME` varchar(20) DEFAULT NULL,
  `DEFAULT_PRICE` float DEFAULT NULL,
  `DEFAULT_INSTALLMENT_PRICE` float DEFAULT NULL,
  `IS_BARCODE_BY_MFG` int(11) DEFAULT NULL,
  `PRIMARY_IMG_RELATIVE_PATH` varchar(200) DEFAULT NULL,
  `DEFAULT_NARRATION` varchar(2000) DEFAULT NULL,
  `F_DEFAULT_VAT_CLASS` int(11) DEFAULT NULL,
  `DEFAULT_VAT_AMOUNT` float DEFAULT NULL,
  `DEFAULT_SEA_FREIGHT_CHARGE` float DEFAULT NULL,
  `DEFAULT_AIR_FREIGHT_CHARGE` float DEFAULT NULL,
  `DEFAULT_PREFERRED_SHIPPING_METHOD` enum('AIR','SEA') DEFAULT NULL,
  `DEFAULT_LOCAL_POSTAGE` float DEFAULT NULL,
  `DEFAULT_INTERDISTRICT_POSTAGE` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `PRD_MASTER_SETUP`
--

INSERT INTO `PRD_MASTER_SETUP` (`PK_NO`, `F_PRD_SUB_CATEGORY_ID`, `CODE`, `COMPOSITE_CODE`, `DEFAULT_NAME`, `DEFAULT_CUSTOMS_NAME`, `DEFAULT_HS_CODE`, `F_BRAND`, `BRAND_NAME`, `F_MODEL`, `MODEL_NAME`, `DEFAULT_PRICE`, `DEFAULT_INSTALLMENT_PRICE`, `IS_BARCODE_BY_MFG`, `PRIMARY_IMG_RELATIVE_PATH`, `DEFAULT_NARRATION`, `F_DEFAULT_VAT_CLASS`, `DEFAULT_VAT_AMOUNT`, `DEFAULT_SEA_FREIGHT_CHARGE`, `DEFAULT_AIR_FREIGHT_CHARGE`, `DEFAULT_PREFERRED_SHIPPING_METHOD`, `DEFAULT_LOCAL_POSTAGE`, `DEFAULT_INTERDISTRICT_POSTAGE`) VALUES
(45, 14, '1006', '461011006', '8BqTvhBRVW', NULL, 'V6OxGGARDj', 36, 'GAP', 35, 'New Model', 880375, 66816, 1, '', 'VoPbPYsjG6', 1, 10, 376828, 99944, 'AIR', 706080, 233455),
(48, 14, '1002', '461011002', 'New Furniture', NULL, '101', 37, 'RFL', 36, 'NEW MAG', 100, 110, 1, '/media/images/products/48/prod_22102020_5f9181b699963.png', 'test', 2, 12, 10, 10, 'AIR', 10, 10),
(49, 14, '1003', '461011003', 'testttttttttt', NULL, NULL, 37, 'RFL', 36, 'NEW MAG', NULL, NULL, 1, '', NULL, NULL, NULL, NULL, NULL, 'AIR', NULL, NULL),
(50, 16, '1001', '471011001', 'YXoLaAU7k9', 'new custom', '1jt1LddJPQ', 36, 'GAP', 35, 'New Model', 694722, 147716, 1, '', '63NXh7EfoX', 1, 10, 159893, 483074, 'AIR', 420804, 209331);

--
-- Triggers `PRD_MASTER_SETUP`
--
DELIMITER $$
CREATE TRIGGER `BEFORE_PRD_MASTER_SETUP_INSERT` BEFORE INSERT ON `PRD_MASTER_SETUP` FOR EACH ROW BEGIN
			declare PKCODE int(5) default 0 ;
			declare VARCOMPOSITE_CODE varchar(80) default null ;

			select PRD_SUB_CATEGORY.COMPOSITE_CODE into VARCOMPOSITE_CODE
				from PRD_SUB_CATEGORY
				where PRD_SUB_CATEGORY.PK_NO = NEW.F_PRD_SUB_CATEGORY_ID ;

			IF NEW.CODE IS NULL THEN

				select count(1) as counter into PKCODE
					from PRD_MASTER_SETUP
					where F_PRD_SUB_CATEGORY_ID = NEW.F_PRD_SUB_CATEGORY_ID;
					SET NEW.CODE = 1000+PKCODE+1 ;
					SET NEW.COMPOSITE_CODE = CONCAT(VARCOMPOSITE_CODE,1000+PKCODE+1) ;
			ELSE
				SET NEW.COMPOSITE_CODE = CONCAT(VARCOMPOSITE_CODE,NEW.CODE) ;
			END IF;


END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `PRD_MODEL`
--

CREATE TABLE `PRD_MODEL` (
  `PK_NO` int(11) NOT NULL,
  `F_PRD_BRAND_NO` int(11) DEFAULT NULL,
  `CODE` varchar(50) DEFAULT NULL,
  `COMPOSITE_CODE` varchar(50) DEFAULT NULL,
  `NAME` varchar(100) DEFAULT NULL,
  `PRD_MODELcol` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Model Master Setup Table' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `PRD_MODEL`
--

INSERT INTO `PRD_MODEL` (`PK_NO`, `F_PRD_BRAND_NO`, `CODE`, `COMPOSITE_CODE`, `NAME`, `PRD_MODELcol`) VALUES
(35, 36, 'GN', 'GAPGN', 'New Model', NULL),
(36, 37, 'RM', 'RFLRM', 'NEW MAG', NULL),
(37, 38, 'QC', 'SQC', 'Quick Check Sugar', NULL);

--
-- Triggers `PRD_MODEL`
--
DELIMITER $$
CREATE TRIGGER `BEFORE_PRD_MODEL_INSERT` BEFORE INSERT ON `PRD_MODEL` FOR EACH ROW BEGIN
			declare PKCODE varchar(20) default 0 ;
			declare BRAND_CODE varchar(20) default 0 ;

			select CODE into BRAND_CODE
				from PRD_BRAND
				where PK_NO = NEW.F_PRD_BRAND_NO;

			IF NEW.CODE IS NULL THEN

				select auto_increment into PKCODE
					from information_schema.tables
					where table_name = 'PRD_MODEL'
					and table_schema = database() ;
					SET NEW.CODE = PKCODE ;
					SET NEW.COMPOSITE_CODE = CONCAT(BRAND_CODE,PKCODE) ;
			ELSE
				SET NEW.COMPOSITE_CODE = CONCAT(BRAND_CODE,NEW.CODE) ;
			END IF;


END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `PRD_SIZE`
--

CREATE TABLE `PRD_SIZE` (
  `PK_NO` int(11) NOT NULL,
  `CODE` varchar(40) DEFAULT NULL,
  `NAME` varchar(200) DEFAULT NULL,
  `F_BRAND_NO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Size Master Setup Table' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `PRD_SIZE`
--

INSERT INTO `PRD_SIZE` (`PK_NO`, `CODE`, `NAME`, `F_BRAND_NO`) VALUES
(42, 'GL', 'LL', 36),
(43, 'SG', 'SM', 36),
(44, 'BR', 'BIG', 37),
(45, 'SR', 'SMALL', 37);

-- --------------------------------------------------------

--
-- Table structure for table `PRD_SUB_CATEGORY`
--

CREATE TABLE `PRD_SUB_CATEGORY` (
  `PK_NO` int(11) NOT NULL,
  `F_PRD_CATEGORY_NO` int(11) DEFAULT NULL,
  `CODE` varchar(40) DEFAULT NULL,
  `COMPOSITE_CODE` varchar(80) DEFAULT NULL,
  `NAME` varchar(200) DEFAULT NULL,
  `HS_PREIX` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='SUB_CATEGORY Master Setup Table' ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `PRD_SUB_CATEGORY`
--

INSERT INTO `PRD_SUB_CATEGORY` (`PK_NO`, `F_PRD_CATEGORY_NO`, `CODE`, `COMPOSITE_CODE`, `NAME`, `HS_PREIX`) VALUES
(14, 36, '101', '46101', 'Furniture', NULL),
(15, 36, '102', '46102', 'Lighting', NULL),
(16, 37, '101', '47101', 'PANTS', NULL),
(17, 37, '102', '47102', 'SHIRTS', NULL),
(18, 38, '101', '48101', 'Herbal', NULL);

--
-- Triggers `PRD_SUB_CATEGORY`
--
DELIMITER $$
CREATE TRIGGER `BEFORE_PRD_SUB_CATEGORY_INSERT` BEFORE INSERT ON `PRD_SUB_CATEGORY` FOR EACH ROW BEGIN
			declare PKCODE int(2) default 0 ;
			declare CATEGORY_CODE int(2) default 0 ;

			select CODE into CATEGORY_CODE
				from PRD_CATEGORY
				where PK_NO = NEW.F_PRD_CATEGORY_NO ;

			IF NEW.CODE IS NULL THEN

				select count(1) as counter into PKCODE
					from PRD_SUB_CATEGORY
					where F_PRD_CATEGORY_NO = NEW.F_PRD_CATEGORY_NO;
					SET NEW.CODE = 100+PKCODE+1 ;
					SET NEW.COMPOSITE_CODE = CONCAT(CATEGORY_CODE,100+PKCODE+1) ;
			ELSE
				SET NEW.COMPOSITE_CODE = CONCAT(CATEGORY_CODE,NEW.CODE) ;
			END IF;


END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `PRD_VARIANT_SETUP`
--

CREATE TABLE `PRD_VARIANT_SETUP` (
  `PK_NO` int(11) NOT NULL,
  `F_PRD_MASTER_SETUP_NO` int(11) DEFAULT NULL,
  `CODE` varchar(40) DEFAULT NULL,
  `COMPOSITE_CODE` varchar(160) DEFAULT NULL,
  `VARIANT_NAME` varchar(200) DEFAULT NULL,
  `VARIANT_CUSTOMS_NAME` varchar(200) DEFAULT NULL,
  `F_SIZE_NO` int(16) DEFAULT NULL,
  `SIZE_NAME` varchar(100) DEFAULT NULL,
  `F_COLOR_NO` int(11) DEFAULT NULL,
  `COLOR` varchar(100) DEFAULT NULL,
  `HS_CODE` varchar(100) DEFAULT NULL,
  `BARCODE` varchar(100) DEFAULT NULL,
  `IS_BARCODE_BY_MFG` int(11) DEFAULT NULL,
  `NARRATION` varchar(2000) DEFAULT NULL,
  `F_PRIMARY_IMG_VARIANT_ID` int(11) DEFAULT NULL,
  `PRIMARY_IMG_RELATIVE_PATH` varchar(200) DEFAULT NULL,
  `REGULAR_PRICE` float DEFAULT NULL,
  `INSTALLMENT_PRICE` float DEFAULT NULL,
  `SEA_FREIGHT_CHARGE` float DEFAULT NULL,
  `AIR_FREIGHT_CHARGE` float DEFAULT NULL,
  `PREFERRED_SHIPPING_METHOD` enum('AIR','SEA') DEFAULT NULL,
  `LOCAL_POSTAGE` float DEFAULT NULL,
  `INTER_DISTRICT_POSTAGE` float DEFAULT NULL,
  `F_VAT_CLASS` int(11) DEFAULT NULL,
  `VAT_AMOUNT` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `PRD_VARIANT_SETUP`
--

INSERT INTO `PRD_VARIANT_SETUP` (`PK_NO`, `F_PRD_MASTER_SETUP_NO`, `CODE`, `COMPOSITE_CODE`, `VARIANT_NAME`, `VARIANT_CUSTOMS_NAME`, `F_SIZE_NO`, `SIZE_NAME`, `F_COLOR_NO`, `COLOR`, `HS_CODE`, `BARCODE`, `IS_BARCODE_BY_MFG`, `NARRATION`, `F_PRIMARY_IMG_VARIANT_ID`, `PRIMARY_IMG_RELATIVE_PATH`, `REGULAR_PRICE`, `INSTALLMENT_PRICE`, `SEA_FREIGHT_CHARGE`, `AIR_FREIGHT_CHARGE`, `PREFERRED_SHIPPING_METHOD`, `LOCAL_POSTAGE`, `INTER_DISTRICT_POSTAGE`, `F_VAT_CLASS`, `VAT_AMOUNT`) VALUES
(11, 48, '1002', '4610110021002', 'New Furniture red', NULL, 44, 'BIG', 79, 'RED', '101', '101', 1, 'test', NULL, NULL, 100, 110, 10, 10, 'AIR', 10, 10, 2, 12),
(12, 50, '101', '471011001101', 'YXoLaAU7k9', 'new custom', 42, 'LL', 78, 'BLACK', '1jt1LddJPQ', NULL, 1, '63NXh7EfoX', NULL, NULL, 694722, 147716, 159893, 483074, 'AIR', 420804, 209331, 1, 10);

--
-- Triggers `PRD_VARIANT_SETUP`
--
DELIMITER $$
CREATE TRIGGER `BEFORE_PRD_VARIANT_SETUP_INSERT` BEFORE INSERT ON `PRD_VARIANT_SETUP` FOR EACH ROW BEGIN
			declare PKCODE int(5) default 0 ;
			declare VARCOMPOSITE_CODE varchar(80) default null ;

			select COMPOSITE_CODE into VARCOMPOSITE_CODE
				from PRD_MASTER_SETUP
				where PK_NO = NEW.F_PRD_MASTER_SETUP_NO ;

			IF NEW.CODE IS NULL THEN

				select count(1) as counter into PKCODE
					from PRD_VARIANT_SETUP
					where F_PRD_MASTER_SETUP_NO = NEW.F_PRD_MASTER_SETUP_NO;
					SET NEW.CODE = 100+PKCODE+1 ;
					SET NEW.COMPOSITE_CODE = CONCAT(VARCOMPOSITE_CODE,100+PKCODE+1) ;
			ELSE
				SET NEW.COMPOSITE_CODE = CONCAT(VARCOMPOSITE_CODE,NEW.CODE) ;
			END IF;


END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_by` int(11) NOT NULL,
  `edited_by` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `status`, `created_by`, `edited_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Super admin', 1, 1, 0, '2020-03-04 06:42:11', '2020-03-04 06:42:11', '2017-03-12 16:42:11'),
(8, 'Admin', 1, 1, 0, '2020-03-04 06:42:11', '2020-03-04 06:42:11', NULL),
(12, 'Maneger1', 1, 1, 1, NULL, '2020-10-07 05:02:37', '2020-10-07 07:21:35');

-- --------------------------------------------------------

--
-- Table structure for table `role_permission`
--

CREATE TABLE `role_permission` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permissions` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_permission`
--

INSERT INTO `role_permission` (`id`, `permissions`, `role_id`, `created_at`, `updated_at`) VALUES
(1, ',view_dashboard,', 1, NULL, NULL),
(2, ',view_dashboard,view_role,edit_role,view_action,delete_action,', 12, '2020-10-07 05:02:37', '2020-10-08 06:52:19'),
(3, ',view_dashboard,add_user_report,execute_dashboard,view_role,', 8, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `SLS_STOCK_OUT`
--

CREATE TABLE `SLS_STOCK_OUT` (
  `PK_NO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `SLS_STOCK_OUT_DETAILS`
--

CREATE TABLE `SLS_STOCK_OUT_DETAILS` (
  `PK_NO` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `SS_COUNTRY`
--

CREATE TABLE `SS_COUNTRY` (
  `PK_NO` int(11) NOT NULL,
  `CODE` varchar(3) DEFAULT NULL,
  `NAME` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `SS_COUNTRY`
--

INSERT INTO `SS_COUNTRY` (`PK_NO`, `CODE`, `NAME`) VALUES
(1, 'UK', 'United Kingdom '),
(2, 'MY', 'Malaysia');

-- --------------------------------------------------------

--
-- Table structure for table `SS_CURRENCY`
--

CREATE TABLE `SS_CURRENCY` (
  `PK_NO` int(11) NOT NULL,
  `CODE` varchar(4) DEFAULT NULL,
  `NAME` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `SS_CURRENCY`
--

INSERT INTO `SS_CURRENCY` (`PK_NO`, `CODE`, `NAME`) VALUES
(1, 'GBP', 'GB Pound'),
(2, 'RM', 'MY Ringit'),
(3, 'BDT', 'Bangladesh');

-- --------------------------------------------------------

--
-- Table structure for table `SS_IMG_FILE_TYPE`
--

CREATE TABLE `SS_IMG_FILE_TYPE` (
  `PK_NO` int(11) NOT NULL,
  `NAME` varchar(20) DEFAULT NULL,
  `EXT` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Dumping data for table `SS_IMG_FILE_TYPE`
--

INSERT INTO `SS_IMG_FILE_TYPE` (`PK_NO`, `NAME`, `EXT`) VALUES
(1, 'png', 'png');

-- --------------------------------------------------------

--
-- Table structure for table `t`
--

CREATE TABLE `t` (
  `i` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `t`
--

INSERT INTO `t` (`i`) VALUES
(1),
(2),
(3);

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `auth_id` bigint(20) UNSIGNED NOT NULL,
  `user_type` tinyint(4) NOT NULL DEFAULT 0,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_expire` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Alive, 0 = Expire',
  `started_at` datetime NOT NULL,
  `expire_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_mobile_no` varchar(14) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `auth_id` bigint(20) UNSIGNED NOT NULL,
  `gym_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_pic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_pic_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pic_mime_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_groups`
--

CREATE TABLE `user_groups` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `ROLE_ID` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_groups`
--

INSERT INTO `user_groups` (`id`, `group_name`, `ROLE_ID`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Super User', 1, 1, NULL, NULL, '2020-10-10 02:45:46'),
(3, 'General Admin Group', 8, 1, NULL, '2020-10-10 02:33:26', '2020-10-10 02:45:57'),
(4, 'Sales Manger Group', 12, 1, NULL, '2020-10-10 02:34:06', '2020-10-10 02:46:01');

-- --------------------------------------------------------

--
-- Table structure for table `verify_mobile_no`
--

CREATE TABLE `verify_mobile_no` (
  `id` int(10) UNSIGNED NOT NULL,
  `mobile_no` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Admin, 1 = User',
  `purpose` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = Verify-mobile,  1 = Reset-password 2= Forgot-password',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 = Last-one, 0 = Used, 2 = Unused',
  `expire_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workout_body_parts`
--

CREATE TABLE `workout_body_parts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workout_body_parts`
--

INSERT INTO `workout_body_parts` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Arm', 1, '2020-10-04 07:20:40', '2020-10-04 07:20:40'),
(3, 'qweqe', 1, '2020-10-07 06:57:11', '2020-10-07 06:57:11'),
(4, '1231231', 1, '2020-10-07 06:57:31', '2020-10-07 06:57:31'),
(5, 'asd', 1, '2020-10-07 06:58:41', '2020-10-07 06:58:41');

-- --------------------------------------------------------

--
-- Table structure for table `workout_items`
--

CREATE TABLE `workout_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `workout_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo_url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body_parts_id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `workout_items`
--

INSERT INTO `workout_items` (`id`, `workout_name`, `photo`, `photo_url`, `body_parts_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Test 1', 'workout_item_04102020_1601817674.png', 'http://www.boilerplate-admin.local/media/images/workout-item/workout_item_04102020_1601817674.png', 2, 1, '2020-10-04 07:21:14', '2020-10-04 07:21:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ACC_VAT_CLASS`
--
ALTER TABLE `ACC_VAT_CLASS`
  ADD PRIMARY KEY (`PK_NO`),
  ADD UNIQUE KEY `u_ACC_VAT_CLASS` (`CODE`);

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_users_auth_id_foreign` (`auth_id`);

--
-- Indexes for table `auths`
--
ALTER TABLE `auths`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `auths_mobile_no_unique` (`mobile_no`),
  ADD UNIQUE KEY `auths_username_unique` (`username`),
  ADD UNIQUE KEY `auths_email_unique` (`email`);

--
-- Indexes for table `auth_role`
--
ALTER TABLE `auth_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gyms`
--
ALTER TABLE `gyms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `INV_STOCK`
--
ALTER TABLE `INV_STOCK`
  ADD PRIMARY KEY (`PK_NO`);

--
-- Indexes for table `INV_WAREHOUSE`
--
ALTER TABLE `INV_WAREHOUSE`
  ADD PRIMARY KEY (`PK_NO`),
  ADD UNIQUE KEY `u_inv_warehouse` (`CODE`),
  ADD KEY `fk_INV_WAREHOUSE_SS_COUNTRY` (`F_COUNTRY_NO`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `models`
--
ALTER TABLE `models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permissions_permission_group_id_foreign` (`permission_group_id`);

--
-- Indexes for table `permission_groups`
--
ALTER TABLE `permission_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `PRC_IMG_LIBRARY`
--
ALTER TABLE `PRC_IMG_LIBRARY`
  ADD PRIMARY KEY (`PK_NO`),
  ADD KEY `fk_PRC_IMG_LIBRARY_PRC_STOCK_IN` (`F_INV_STOCK_IN_NO`),
  ADD KEY `fk_PRC_IMG_LIBRARY_SS_IMG_FILE_TYPE` (`F_FILE_TYPE_NO`);

--
-- Indexes for table `PRC_STOCK_IN`
--
ALTER TABLE `PRC_STOCK_IN`
  ADD PRIMARY KEY (`PK_NO`),
  ADD UNIQUE KEY `u_prc_stock_in` (`CODE`),
  ADD KEY `fk_PRC_STOCK_IN_SS_CURRENCY` (`F_SS_CURRENCY_NO`),
  ADD KEY `fk_PRC_STOCK_IN_PRC_VENDORS` (`F_VENDOR_NO`);

--
-- Indexes for table `PRC_STOCK_IN_DETAILS`
--
ALTER TABLE `PRC_STOCK_IN_DETAILS`
  ADD PRIMARY KEY (`PK_NO`),
  ADD UNIQUE KEY `u_prc_stock_in_details` (`CODE`),
  ADD KEY `fk_PRC_STOCK_IN_DETAILS_PRC_STOCK_IN` (`F_PRC_STOCK_IN`),
  ADD KEY `fk_PRC_STOCK_IN_DETAILS_PRD_VARIANT_SETUP` (`F_PRD_VARIANT_NO`);

--
-- Indexes for table `PRC_VENDORS`
--
ALTER TABLE `PRC_VENDORS`
  ADD PRIMARY KEY (`PK_NO`),
  ADD UNIQUE KEY `u_prc_vendors` (`CODE`),
  ADD KEY `fk_PRC_VENDORS_SS_COUNTRY` (`F_COUNTRY`);

--
-- Indexes for table `PRD_BRAND`
--
ALTER TABLE `PRD_BRAND`
  ADD PRIMARY KEY (`PK_NO`),
  ADD UNIQUE KEY `CODE` (`CODE`);

--
-- Indexes for table `PRD_CATEGORY`
--
ALTER TABLE `PRD_CATEGORY`
  ADD PRIMARY KEY (`PK_NO`),
  ADD UNIQUE KEY `CODE` (`CODE`);

--
-- Indexes for table `PRD_COLOR`
--
ALTER TABLE `PRD_COLOR`
  ADD PRIMARY KEY (`PK_NO`),
  ADD UNIQUE KEY `u_prd_color` (`CODE`,`F_BRAND`),
  ADD KEY `fk_PRD_COLOR_PRD_BRAND` (`F_BRAND`);

--
-- Indexes for table `PRD_IMG_LIBRARY`
--
ALTER TABLE `PRD_IMG_LIBRARY`
  ADD PRIMARY KEY (`PK_NO`),
  ADD KEY `fk_PRD_IMG_LIBRARY_PRD_MASTER_SETUP` (`F_PRD_MASTER_NO`),
  ADD KEY `fk_PRD_IMG_LIBRARY_PRD_VARIANT_SETUP` (`F_PRD_VARIANT_NO`),
  ADD KEY `fk_PRD_IMG_LIBRARY_SS_IMG_FILE_TYPE` (`F_FILE_TYPE`);

--
-- Indexes for table `PRD_MASTER_SETUP`
--
ALTER TABLE `PRD_MASTER_SETUP`
  ADD PRIMARY KEY (`PK_NO`),
  ADD UNIQUE KEY `u_PRD_MASTER_SETUP_cc` (`CODE`,`F_PRD_SUB_CATEGORY_ID`),
  ADD UNIQUE KEY `u_PRD_MASTER_SETUP` (`COMPOSITE_CODE`),
  ADD KEY `fk_PRD_MASTER_SETUP_PRD_SUB_CATEGORY` (`F_PRD_SUB_CATEGORY_ID`),
  ADD KEY `fk_PRD_MASTER_SETUP_PRD_BRAND` (`F_BRAND`),
  ADD KEY `fk_PRD_MASTER_SETUP_PRD_MODEL` (`F_MODEL`),
  ADD KEY `fk_PRD_MASTER_SETUP_ACC_VAT_CLASS` (`F_DEFAULT_VAT_CLASS`);

--
-- Indexes for table `PRD_MODEL`
--
ALTER TABLE `PRD_MODEL`
  ADD PRIMARY KEY (`PK_NO`),
  ADD UNIQUE KEY `u_PRD_MODEL` (`CODE`,`F_PRD_BRAND_NO`),
  ADD UNIQUE KEY `u_PRD_MODEL_cc` (`COMPOSITE_CODE`),
  ADD KEY `fk_PRD_MODEL_PRD_BRAND` (`F_PRD_BRAND_NO`);

--
-- Indexes for table `PRD_SIZE`
--
ALTER TABLE `PRD_SIZE`
  ADD PRIMARY KEY (`PK_NO`),
  ADD UNIQUE KEY `u_prd_size` (`CODE`,`F_BRAND_NO`),
  ADD KEY `fk_PRD_SIZE_PRD_BRAND` (`F_BRAND_NO`);

--
-- Indexes for table `PRD_SUB_CATEGORY`
--
ALTER TABLE `PRD_SUB_CATEGORY`
  ADD PRIMARY KEY (`PK_NO`),
  ADD UNIQUE KEY `u_PRD_SUB_CATEGORY` (`CODE`,`F_PRD_CATEGORY_NO`),
  ADD UNIQUE KEY `u_PRD_SUB_CATEGORY_cc` (`COMPOSITE_CODE`),
  ADD KEY `fk_PRD_SUB_CATEGORY_PRD_CATEGORY` (`F_PRD_CATEGORY_NO`);

--
-- Indexes for table `PRD_VARIANT_SETUP`
--
ALTER TABLE `PRD_VARIANT_SETUP`
  ADD PRIMARY KEY (`PK_NO`),
  ADD UNIQUE KEY `u_PRD_VARIANT_SETUP` (`COMPOSITE_CODE`),
  ADD UNIQUE KEY `u_prd_variant_setup_01` (`F_PRD_MASTER_SETUP_NO`,`CODE`),
  ADD KEY `fk_PRD_VARIANT_SETUP_PRD_SIZE` (`F_SIZE_NO`),
  ADD KEY `fk_PRD_VARIANT_SETUP_PRD_COLOR` (`F_COLOR_NO`),
  ADD KEY `fk_PRD_VARIANT_SETUP_ACC_VAT_CLASS` (`F_VAT_CLASS`),
  ADD KEY `fk_PRD_VARIANT_SETUP_PRD_MASTER_SETUP` (`F_PRD_MASTER_SETUP_NO`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_permission_role_id_foreign` (`role_id`);

--
-- Indexes for table `SS_COUNTRY`
--
ALTER TABLE `SS_COUNTRY`
  ADD PRIMARY KEY (`PK_NO`),
  ADD UNIQUE KEY `u_ss_country` (`CODE`);

--
-- Indexes for table `SS_CURRENCY`
--
ALTER TABLE `SS_CURRENCY`
  ADD PRIMARY KEY (`PK_NO`),
  ADD UNIQUE KEY `u_ss_currency` (`CODE`);

--
-- Indexes for table `SS_IMG_FILE_TYPE`
--
ALTER TABLE `SS_IMG_FILE_TYPE`
  ADD PRIMARY KEY (`PK_NO`),
  ADD UNIQUE KEY `u_SS_IMG_FILE_TYPE` (`EXT`);

--
-- Indexes for table `t`
--
ALTER TABLE `t`
  ADD PRIMARY KEY (`i`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tokens_auth_id_foreign` (`auth_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_auth_id_foreign` (`auth_id`),
  ADD KEY `users_gym_id_foreign` (`gym_id`);

--
-- Indexes for table `user_groups`
--
ALTER TABLE `user_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verify_mobile_no`
--
ALTER TABLE `verify_mobile_no`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workout_body_parts`
--
ALTER TABLE `workout_body_parts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workout_items`
--
ALTER TABLE `workout_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `workout_items_body_parts_id_foreign` (`body_parts_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ACC_VAT_CLASS`
--
ALTER TABLE `ACC_VAT_CLASS`
  MODIFY `PK_NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `auths`
--
ALTER TABLE `auths`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `auth_role`
--
ALTER TABLE `auth_role`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gyms`
--
ALTER TABLE `gyms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `INV_STOCK`
--
ALTER TABLE `INV_STOCK`
  MODIFY `PK_NO` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `INV_WAREHOUSE`
--
ALTER TABLE `INV_WAREHOUSE`
  MODIFY `PK_NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `models`
--
ALTER TABLE `models`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `permission_groups`
--
ALTER TABLE `permission_groups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `PRC_IMG_LIBRARY`
--
ALTER TABLE `PRC_IMG_LIBRARY`
  MODIFY `PK_NO` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `PRC_STOCK_IN`
--
ALTER TABLE `PRC_STOCK_IN`
  MODIFY `PK_NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `PRC_STOCK_IN_DETAILS`
--
ALTER TABLE `PRC_STOCK_IN_DETAILS`
  MODIFY `PK_NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `PRC_VENDORS`
--
ALTER TABLE `PRC_VENDORS`
  MODIFY `PK_NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `PRD_BRAND`
--
ALTER TABLE `PRD_BRAND`
  MODIFY `PK_NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `PRD_CATEGORY`
--
ALTER TABLE `PRD_CATEGORY`
  MODIFY `PK_NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `PRD_COLOR`
--
ALTER TABLE `PRD_COLOR`
  MODIFY `PK_NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `PRD_IMG_LIBRARY`
--
ALTER TABLE `PRD_IMG_LIBRARY`
  MODIFY `PK_NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `PRD_MASTER_SETUP`
--
ALTER TABLE `PRD_MASTER_SETUP`
  MODIFY `PK_NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `PRD_MODEL`
--
ALTER TABLE `PRD_MODEL`
  MODIFY `PK_NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `PRD_SIZE`
--
ALTER TABLE `PRD_SIZE`
  MODIFY `PK_NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `PRD_SUB_CATEGORY`
--
ALTER TABLE `PRD_SUB_CATEGORY`
  MODIFY `PK_NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `PRD_VARIANT_SETUP`
--
ALTER TABLE `PRD_VARIANT_SETUP`
  MODIFY `PK_NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `role_permission`
--
ALTER TABLE `role_permission`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `SS_COUNTRY`
--
ALTER TABLE `SS_COUNTRY`
  MODIFY `PK_NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `SS_CURRENCY`
--
ALTER TABLE `SS_CURRENCY`
  MODIFY `PK_NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `SS_IMG_FILE_TYPE`
--
ALTER TABLE `SS_IMG_FILE_TYPE`
  MODIFY `PK_NO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_groups`
--
ALTER TABLE `user_groups`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `verify_mobile_no`
--
ALTER TABLE `verify_mobile_no`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `workout_body_parts`
--
ALTER TABLE `workout_body_parts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `workout_items`
--
ALTER TABLE `workout_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD CONSTRAINT `admin_users_auth_id_foreign` FOREIGN KEY (`auth_id`) REFERENCES `auths` (`id`);

--
-- Constraints for table `INV_WAREHOUSE`
--
ALTER TABLE `INV_WAREHOUSE`
  ADD CONSTRAINT `fk_INV_WAREHOUSE_SS_COUNTRY` FOREIGN KEY (`F_COUNTRY_NO`) REFERENCES `SS_COUNTRY` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `permissions`
--
ALTER TABLE `permissions`
  ADD CONSTRAINT `permissions_permission_group_id_foreign` FOREIGN KEY (`permission_group_id`) REFERENCES `permission_groups` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `PRC_IMG_LIBRARY`
--
ALTER TABLE `PRC_IMG_LIBRARY`
  ADD CONSTRAINT `fk_PRC_IMG_LIBRARY_PRC_STOCK_IN` FOREIGN KEY (`F_INV_STOCK_IN_NO`) REFERENCES `PRC_STOCK_IN` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_PRC_IMG_LIBRARY_SS_IMG_FILE_TYPE` FOREIGN KEY (`F_FILE_TYPE_NO`) REFERENCES `SS_IMG_FILE_TYPE` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `PRC_STOCK_IN`
--
ALTER TABLE `PRC_STOCK_IN`
  ADD CONSTRAINT `fk_PRC_STOCK_IN_PRC_VENDORS` FOREIGN KEY (`F_VENDOR_NO`) REFERENCES `PRC_VENDORS` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_PRC_STOCK_IN_SS_CURRENCY` FOREIGN KEY (`F_SS_CURRENCY_NO`) REFERENCES `SS_CURRENCY` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `PRC_STOCK_IN_DETAILS`
--
ALTER TABLE `PRC_STOCK_IN_DETAILS`
  ADD CONSTRAINT `fk_PRC_STOCK_IN_DETAILS_PRC_STOCK_IN` FOREIGN KEY (`F_PRC_STOCK_IN`) REFERENCES `PRC_STOCK_IN` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_PRC_STOCK_IN_DETAILS_PRD_VARIANT_SETUP` FOREIGN KEY (`F_PRD_VARIANT_NO`) REFERENCES `PRD_VARIANT_SETUP` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `PRC_VENDORS`
--
ALTER TABLE `PRC_VENDORS`
  ADD CONSTRAINT `fk_PRC_VENDORS_SS_COUNTRY` FOREIGN KEY (`F_COUNTRY`) REFERENCES `SS_COUNTRY` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `PRD_COLOR`
--
ALTER TABLE `PRD_COLOR`
  ADD CONSTRAINT `fk_PRD_COLOR_PRD_BRAND` FOREIGN KEY (`F_BRAND`) REFERENCES `PRD_BRAND` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `PRD_IMG_LIBRARY`
--
ALTER TABLE `PRD_IMG_LIBRARY`
  ADD CONSTRAINT `fk_PRD_IMG_LIBRARY_PRD_MASTER_SETUP` FOREIGN KEY (`F_PRD_MASTER_NO`) REFERENCES `PRD_MASTER_SETUP` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_PRD_IMG_LIBRARY_PRD_VARIANT_SETUP` FOREIGN KEY (`F_PRD_VARIANT_NO`) REFERENCES `PRD_VARIANT_SETUP` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_PRD_IMG_LIBRARY_SS_IMG_FILE_TYPE` FOREIGN KEY (`F_FILE_TYPE`) REFERENCES `SS_IMG_FILE_TYPE` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `PRD_MASTER_SETUP`
--
ALTER TABLE `PRD_MASTER_SETUP`
  ADD CONSTRAINT `fk_PRD_MASTER_SETUP_ACC_VAT_CLASS` FOREIGN KEY (`F_DEFAULT_VAT_CLASS`) REFERENCES `ACC_VAT_CLASS` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_PRD_MASTER_SETUP_PRD_BRAND` FOREIGN KEY (`F_BRAND`) REFERENCES `PRD_BRAND` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_PRD_MASTER_SETUP_PRD_MODEL` FOREIGN KEY (`F_MODEL`) REFERENCES `PRD_MODEL` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_PRD_MASTER_SETUP_PRD_SUB_CATEGORY` FOREIGN KEY (`F_PRD_SUB_CATEGORY_ID`) REFERENCES `PRD_SUB_CATEGORY` (`PK_NO`) ON DELETE CASCADE ON UPDATE SET NULL;

--
-- Constraints for table `PRD_MODEL`
--
ALTER TABLE `PRD_MODEL`
  ADD CONSTRAINT `fk_PRD_MODEL_PRD_BRAND` FOREIGN KEY (`F_PRD_BRAND_NO`) REFERENCES `PRD_BRAND` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `PRD_SIZE`
--
ALTER TABLE `PRD_SIZE`
  ADD CONSTRAINT `fk_PRD_SIZE_PRD_BRAND` FOREIGN KEY (`F_BRAND_NO`) REFERENCES `PRD_BRAND` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `PRD_SUB_CATEGORY`
--
ALTER TABLE `PRD_SUB_CATEGORY`
  ADD CONSTRAINT `fk_PRD_SUB_CATEGORY_PRD_CATEGORY` FOREIGN KEY (`F_PRD_CATEGORY_NO`) REFERENCES `PRD_CATEGORY` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `PRD_VARIANT_SETUP`
--
ALTER TABLE `PRD_VARIANT_SETUP`
  ADD CONSTRAINT `fk_PRD_VARIANT_SETUP_ACC_VAT_CLASS` FOREIGN KEY (`F_VAT_CLASS`) REFERENCES `ACC_VAT_CLASS` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_PRD_VARIANT_SETUP_PRD_COLOR` FOREIGN KEY (`F_COLOR_NO`) REFERENCES `PRD_COLOR` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_PRD_VARIANT_SETUP_PRD_MASTER_SETUP` FOREIGN KEY (`F_PRD_MASTER_SETUP_NO`) REFERENCES `PRD_MASTER_SETUP` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_PRD_VARIANT_SETUP_PRD_SIZE` FOREIGN KEY (`F_SIZE_NO`) REFERENCES `PRD_SIZE` (`PK_NO`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_permission`
--
ALTER TABLE `role_permission`
  ADD CONSTRAINT `role_permission_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `tokens_auth_id_foreign` FOREIGN KEY (`auth_id`) REFERENCES `auths` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_auth_id_foreign` FOREIGN KEY (`auth_id`) REFERENCES `auths` (`id`),
  ADD CONSTRAINT `users_gym_id_foreign` FOREIGN KEY (`gym_id`) REFERENCES `gyms` (`id`);

--
-- Constraints for table `workout_items`
--
ALTER TABLE `workout_items`
  ADD CONSTRAINT `workout_items_body_parts_id_foreign` FOREIGN KEY (`body_parts_id`) REFERENCES `workout_body_parts` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
