-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2024 at 04:42 PM
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
-- Database: `uiuauction`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_logins`
--

CREATE TABLE IF NOT EXISTS `admin_logins` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `otp` double NOT NULL DEFAULT 0,
  `device` varchar(255) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `time_limit` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `path` varchar(255) NOT NULL DEFAULT 'Admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_logins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_logins`
--

INSERT INTO `admin_logins` (`id`, `name`, `email`, `otp`, `device`, `access_token`, `time_limit`, `status`, `path`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.0.0 Safari/537.36', 'y8BTZzzqBX7DmZbKkglhaGbhvo3b85jHSXzwH2pQY2hm9UV3HaM5zvg9zyGY', '2023-10-08 18:48:05', 'Active', 'Admin', '2023-07-13 20:05:42', '2023-09-28 12:48:41');

-- --------------------------------------------------------

--
-- Table structure for table `auction_items`
--

CREATE TABLE IF NOT EXISTS `auction_items` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `serial` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `time_limit` varchar(255) DEFAULT NULL,
  `bidding_staus` varchar(255) NOT NULL DEFAULT 'not-approved',
  `status` varchar(255) DEFAULT NULL,
  `price_collected` double NOT NULL DEFAULT 0,
  `bidder` varchar(255) DEFAULT NULL,
  `total_bid` longtext DEFAULT NULL,
  `current_price` double DEFAULT 0,
  `token` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `auction_items`
--

INSERT INTO `auction_items` (`id`, `serial`, `category`, `time_limit`, `bidding_staus`, `status`, `price_collected`, `bidder`, `total_bid`, `current_price`, `token`, `created_at`, `updated_at`) VALUES
(2, '00000004', 'Vehicle', '2023-09-17 07:43:25', 'closed', 'sold', 452500, 'User-00000001', '[{\"id\":\"20230916182109SCilU6NW8u\",\"user_id\":\"User-00000004\",\"name\":\"Jahid\",\"price\":\"452000\"},{\"id\":\"20230916183751JL6dVBOCTV\",\"user_id\":\"User-00000001\",\"name\":\"User 01\",\"price\":\"452500\"}]', 452500, 'hs5XSam6kfVkdwP6YlRKlSVKIg9j6Rz5uoxlh6XgCJ8TmHzsOe7mtk50RB9w', '2023-09-02 10:10:40', '2023-09-28 13:02:28');

-- --------------------------------------------------------

--
-- Table structure for table `balences`
--

CREATE TABLE IF NOT EXISTS `balences` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `serial` varchar(255) DEFAULT NULL,
  `balance` double NOT NULL DEFAULT 0,
  `bitting_expence` double NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `balences`
--

INSERT INTO `balences` (`id`, `serial`, `balance`, `bitting_expence`, `created_at`, `updated_at`) VALUES
(1, 'User-00000001', 49000, 452500, '2023-07-14 05:01:32', '2023-09-28 13:02:28'),
(2, 'User-00000004', 500000, 452000, '2023-07-15 01:49:50', '2023-09-16 12:21:09'),
(3, 'Seller-00000005', 452500, 0, '2023-09-28 13:02:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Vehicle', '/public/assets/images/category/1771412590520214.png', 'active', '2023-07-14 10:04:51', '2023-09-02 10:09:03'),
(2, 'Jewellery', '/public/assets/images/category/1771412920541209.png', 'active', '2023-07-14 10:10:06', '2023-09-02 10:09:17'),
(3, 'Apartment', '/public/assets/images/category/1771471685990962.png', 'active', '2023-07-15 01:44:09', '2023-09-02 10:09:26');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2023_07_13_191409_create_admin_logins_table', 1),
(2, '2014_10_12_000000_create_users_table', 2),
(3, '2014_10_12_100000_create_password_reset_tokens_table', 2),
(4, '2019_08_19_000000_create_failed_jobs_table', 2),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 2),
(6, '2023_07_14_043955_create_user_seller_i_p_locations_table', 3),
(7, '2023_07_14_070233_create_balences_table', 4),
(8, '2023_07_14_103419_create_money_transacs_table', 5),
(9, '2023_07_14_144310_create_categories_table', 6),
(10, '2023_07_15_051451_create_seller_product_lists_table', 7),
(12, '2023_09_02_125858_create_auction_items_table', 8),
(13, '2023_09_16_115950_create_mock_i_p_s_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `mock_i_p_s`
--

CREATE TABLE IF NOT EXISTS `mock_i_p_s` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `index` varchar(255) NOT NULL DEFAULT 'status',
  `value` varchar(255) NOT NULL DEFAULT 'on',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mock_i_p_s`
--

INSERT INTO `mock_i_p_s` (`id`, `index`, `value`, `created_at`, `updated_at`) VALUES
(1, 'status', 'on', '2023-09-16 12:02:38', '2023-09-16 08:28:36');

-- --------------------------------------------------------

--
-- Table structure for table `money_transacs`
--

CREATE TABLE IF NOT EXISTS `money_transacs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `identifier` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `amount` double NOT NULL DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'Incomplete',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `money_transacs`
--

INSERT INTO `money_transacs` (`id`, `identifier`, `token`, `description`, `amount`, `status`, `created_at`, `updated_at`) VALUES
(2, 'User-00000001', '8dWRv9t9AG', 'Balance', 500, 'succeeded', '2023-07-14 05:01:32', '2023-07-14 05:01:32'),
(3, 'User-00000001', 'lzR0ExJmvo', 'Balance', 1000, 'succeeded', '2023-07-14 05:05:46', '2023-07-14 05:05:46'),
(6, 'Seller-00000002', 'mTqwc7Fk10', 'Seller_reg_fee', 5000, 'succeeded', '2023-07-14 06:13:46', '2023-07-14 06:44:45'),
(7, 'Seller-00000003', 'trohofckBS', 'Seller_reg_fee', 5000, 'succeeded', '2023-07-14 07:52:56', '2023-07-14 07:53:08'),
(8, 'User-00000004', 'msNYUK43Lh', 'Balance', 500, 'succeeded', '2023-07-15 01:49:50', '2023-07-15 01:49:50'),
(9, 'Seller-00000005', 'JDQN8bdimR', 'Seller_reg_fee', 5000, 'succeeded', '2023-07-15 01:51:25', '2023-07-15 01:52:27'),
(10, 'User-00000001', 'aUuXWNBLGk', 'Balance', 500000, 'succeeded', '2023-09-16 10:18:17', '2023-09-16 10:18:17');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `seller_product_lists`
--

CREATE TABLE IF NOT EXISTS `seller_product_lists` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `serial` varchar(255) DEFAULT NULL,
  `seller_serial` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `short_des` varchar(255) DEFAULT NULL,
  `starting_price` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `seller_product_lists`
--

INSERT INTO `seller_product_lists` (`id`, `serial`, `seller_serial`, `image`, `name`, `short_des`, `starting_price`, `status`, `created_at`, `updated_at`) VALUES
(1, '00000001', 'Seller-00000002', '/public/assets/images/seller_product/1771469885901726.png', 'Apartment at Bashundhara', 'Well furnished apartment up for sale', '500000', 'Active', '2023-07-15 01:15:32', '2023-07-15 01:15:32'),
(2, '00000002', 'Seller-00000002', '/public/assets/images/seller_product/1771470993793797.png', 'Mitsubushi pajero sport 2023', 'New pajero sport 2023 up for sale', '8500000', 'Active', '2023-07-15 01:33:09', '2023-07-15 01:33:09'),
(3, '00000003', 'Seller-00000002', '/public/assets/images/seller_product/1771471822386118.png', 'Apartment at Uttara', 'Well furnished apartment', '650000', 'Active', '2023-07-15 01:46:19', '2023-07-15 01:46:19'),
(4, '00000004', 'Seller-00000005', '/public/assets/images/seller_product/1771472546024272.png', 'Yamaha R15', 'Used for 1 year', '450000', 'Active', '2023-07-15 01:57:49', '2023-09-02 10:10:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `serial` varchar(255) DEFAULT NULL,
  `sl_index` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `device` varchar(255) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `time_limit` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Active',
  `path` varchar(255) NOT NULL DEFAULT 'User',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `serial`, `sl_index`, `name`, `email`, `email_verified_at`, `password`, `device`, `access_token`, `time_limit`, `status`, `path`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'User-00000001', '00000001', 'User 01', 'user01@gmail.com', NULL, '$2y$10$svSY4aGtiftcLTx5Kpkueu.6hjWPqYAw5fF65Wd1xdA3Nlm49DmJ2', NULL, 'nMst2xb3oNzz0FCsJpHDoPmheF1nLHLwMPrg06RUrbQH2VUArGDKUf96PHec', '2023-10-08 19:41:36', 'Active', 'User', NULL, '2023-07-13 22:42:41', '2023-09-28 13:41:36'),
(5, 'Seller-00000002', '00000002', 'Seller 01', 'seller01@gmail.com', NULL, '$2y$10$RoA4intHkzdE4EScSZy7rO0uo1fJMTYiH6JieNSBgwiFIklAUvS2y', NULL, 'uIwiOmSabJknX3yQxS8pQovy1HIDLo2USAuU8BGjFgl2A0PqxLuy1REKsbA3', '2023-09-26 14:12:02', 'Active', 'Seller', NULL, '2023-07-14 06:13:46', '2023-09-16 08:12:15'),
(6, 'Seller-00000003', '00000003', 'Seller02', 'seller02@gmail.com', NULL, '$2y$10$PPE/luAKDc0O9kyxR/dXwuqcx4/pLhceYENaKqtUFEx/H4R5IQeUm', NULL, NULL, NULL, 'Active', 'Seller', NULL, '2023-07-14 07:52:56', '2023-07-15 01:39:58'),
(7, 'User-00000004', '00000004', 'Jahid', 'jahid@gmail.com', NULL, '$2y$10$jm9AGnKFLImDBGViX8fxn.9Z9f/WBWzxxVmZUooNd6zP3PN3gaFNy', NULL, 'GVY6kl2DgiHCye43qpxQHRLHTs86QM0UBBsApeJrf2hdy9SeMRm0Mv3yU1xB', '2023-09-26 18:19:44', 'Active', 'User', NULL, '2023-07-15 01:48:39', '2023-09-16 12:19:44'),
(8, 'Seller-00000005', '00000005', 'Mominul', 'seller03@gmail.com', NULL, '$2y$10$SzVhpEEpHbrIdRfwHdZpSu5FujHucYgQ/yB/Eeff03Jt1CYOIdlGS', NULL, 'HyKc2NaQhRSDff4OLwOmdSndbGaqedtLFguMsHn84bEfWkDdZLIi2KCuQ4l3', '2023-10-08 19:11:43', 'Active', 'Seller', NULL, '2023-07-15 01:51:25', '2023-09-28 13:11:43');

-- --------------------------------------------------------

--
-- Table structure for table `user_seller_i_p_locations`
--

CREATE TABLE IF NOT EXISTS `user_seller_i_p_locations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `serial` varchar(255) DEFAULT NULL,
  `long` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_seller_i_p_locations`
--

INSERT INTO `user_seller_i_p_locations` (`id`, `serial`, `long`, `lat`, `ip`, `created_at`, `updated_at`) VALUES
(6, 'User-00000001', '90.3820401', '23.8723811', '118.228.164.196', '2023-07-14 00:49:37', '2023-07-14 00:49:37'),
(7, 'User-00000001', '90.3820337', '23.8723765', '188.168.224.187', '2023-07-14 00:57:10', '2023-07-14 00:57:10'),
(8, 'User-00000001', '90.3820337', '23.8723765', '202.186.240.140', '2023-07-14 00:58:07', '2023-07-14 00:58:07'),
(9, 'User-00000001', '90.3820512', '23.8723833', '155.255.191.139', '2023-07-14 01:01:26', '2023-07-14 01:01:26'),
(10, 'User-00000001', '90.3820337', '23.8723765', '198.130.174.76', '2023-07-14 01:07:25', '2023-07-14 01:07:25'),
(11, 'User-00000001', '90.3820337', '23.8723765', '239.37.115.59', '2023-07-14 01:14:35', '2023-07-14 01:14:35'),
(12, 'Seller-00000002', '90.382057', '23.872278', '151.89.250.230', '2023-07-14 09:27:06', '2023-07-14 09:27:06'),
(13, 'Seller-00000002', '90.382042', '23.872303', '8.239.220.130', '2023-07-15 01:15:00', '2023-07-15 01:15:00'),
(14, 'Seller-00000002', '90.38196', '23.872259', '238.12.94.54', '2023-07-15 01:41:47', '2023-07-15 01:41:47'),
(15, 'User-00000001', '90.382139', '23.872418', '157.32.244.140', '2023-07-15 01:47:18', '2023-07-15 01:47:18'),
(16, 'User-00000004', '90.382151', '23.872419', '188.244.184.194', '2023-07-15 01:48:57', '2023-07-15 01:48:57'),
(17, 'Seller-00000005', '90.38205', '23.872328', '91.42.156.218', '2023-07-15 01:55:33', '2023-07-15 01:55:33'),
(18, 'Seller-00000005', '90.3820129', '23.8723844', '10.180.113.218', '2023-09-01 23:30:50', '2023-09-01 23:30:50'),
(19, 'Seller-00000005', '90.382085', '23.8723542', '26.20.156.47', '2023-09-01 23:50:47', '2023-09-01 23:50:47'),
(20, 'Seller-00000005', '90.3820341', '23.8723836', '150.248.119.181', '2023-09-02 10:10:15', '2023-09-02 10:10:15'),
(21, 'User-00000001', '90.3820218', '23.8723875', '::1', '2023-09-16 07:59:02', '2023-09-16 07:59:02'),
(22, 'Seller-00000002', '90.3820338', '23.8723955', '::1', '2023-09-16 08:12:02', '2023-09-16 08:12:02'),
(23, 'User-00000001', '90.3820273', '23.8724068', '::1', '2023-09-16 08:13:30', '2023-09-16 08:13:30'),
(24, 'User-00000001', '90.3820703', '23.8723775', '46.88.195.110', '2023-09-16 08:29:00', '2023-09-16 08:29:00'),
(25, 'User-00000001', '90.3820703', '23.8723775', '50.246.243.209', '2023-09-16 08:32:46', '2023-09-16 08:32:46'),
(26, 'User-00000004', '90.3820072', '23.8723949', '29.161.7.233', '2023-09-16 12:19:44', '2023-09-16 12:19:44'),
(27, 'Seller-00000005', '90.3820426', '23.8723819', '59.39.57.23', '2023-09-28 13:09:58', '2023-09-28 13:09:58'),
(28, 'Seller-00000005', '90.3820507', '23.8723791', '4.26.140.140', '2023-09-28 13:11:43', '2023-09-28 13:11:43'),
(29, 'User-00000001', '90.3820388', '23.8723876', '119.8.155.155', '2023-09-28 13:41:36', '2023-09-28 13:41:36');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
