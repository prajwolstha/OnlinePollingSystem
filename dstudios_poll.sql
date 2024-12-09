-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2024 at 01:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dstudios_poll`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `poll_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `is_read`, `created_at`, `poll_id`, `user_id`) VALUES
(1, 'New verification document submitted by user ID: 16', 1, '2024-11-11 12:02:07', NULL, NULL),
(2, 'New verification document submitted by user ID: 16', 1, '2024-11-11 12:02:39', NULL, NULL),
(3, 'New verification request from user ID 23', 1, '2024-11-12 14:26:02', NULL, NULL),
(4, 'New document submission for verification from user ID: 26', 1, '2024-11-13 14:29:15', NULL, NULL),
(5, 'New document submission for verification from user ID: 15', 1, '2024-11-14 03:41:51', NULL, NULL),
(6, 'New document submission for verification from user ID: 15', 1, '2024-11-14 03:42:21', NULL, NULL),
(7, 'User reported poll ID 29.', 1, '2024-11-14 11:45:57', 29, 12),
(8, 'User reported poll ID 34.', 1, '2024-11-14 11:48:46', 34, 17),
(9, 'User reported poll ID 35.', 1, '2024-11-14 11:56:30', 35, 17),
(10, 'User reported poll ID 35.', 1, '2024-11-14 12:02:28', 35, 17),
(11, 'User reported poll ID 35.', 1, '2024-11-14 12:04:10', 35, 17),
(12, 'User reported poll ID 30.', 1, '2024-11-14 12:04:57', 30, 17),
(13, 'User reported poll ID 35.', 1, '2024-11-14 12:10:00', 35, 17),
(14, 'User reported poll ID 35.', 1, '2024-11-14 12:18:37', 35, 17),
(15, 'New document submission for verification from user ID: 30', 1, '2024-11-14 12:20:24', NULL, NULL),
(16, 'New document submission for verification from user ID: 31', 1, '2024-11-16 10:07:24', NULL, NULL),
(17, 'New document submission for verification from user ID: 31', 1, '2024-11-16 10:08:10', NULL, NULL),
(18, 'User reported poll ID 30.', 1, '2024-11-17 09:01:09', 30, 30),
(19, 'User reported poll ID 30.', 1, '2024-11-17 09:01:41', 30, 30),
(20, 'User reported poll ID 30.', 1, '2024-11-17 09:44:11', 30, 30),
(21, 'User reported poll ID 33.', 1, '2024-11-17 09:44:34', 33, 30),
(22, 'User reported poll ID 30.', 1, '2024-11-17 09:47:02', 30, 30),
(23, 'User reported poll ID 30.', 1, '2024-11-17 09:48:19', 30, 30),
(24, 'User reported poll ID 30.', 1, '2024-11-17 09:48:49', 30, 30),
(25, 'User reported poll ID 33.', 1, '2024-11-17 09:51:22', 33, 30),
(26, 'User reported poll ID 30.', 1, '2024-11-17 09:51:25', 30, 30),
(27, 'User reported poll ID 30.', 1, '2024-11-17 10:07:26', 30, 30),
(28, 'User reported poll ID 30.', 1, '2024-11-17 10:08:15', 30, 30),
(29, 'User reported poll ID 30.', 1, '2024-11-17 10:08:27', 30, 30),
(30, 'User reported poll ID 35.', 1, '2024-11-17 10:09:08', 35, 30),
(31, 'User reported poll ID 30.', 1, '2024-11-17 10:11:46', 30, 30),
(32, 'User reported poll ID 31.', 1, '2024-11-17 10:11:57', 31, 30),
(33, 'User reported poll ID 30.', 1, '2024-11-17 10:44:40', 30, 30),
(34, 'User reported poll ID 30.', 1, '2024-11-17 11:01:53', 30, 17),
(35, 'hey ram this poll u have created so,dont create any poll that is violiting.', 1, '2024-11-17 11:02:52', NULL, 24),
(36, 'hey ram this poll u have created so,dont create any poll that is violiting.', 1, '2024-11-17 11:03:09', NULL, 24),
(37, 'ddfadsfda', 1, '2024-11-17 11:04:17', NULL, 0),
(38, 'User reported poll ID 30.', 1, '2024-11-17 11:05:11', 30, 30),
(39, 'dont create', 1, '2024-11-17 11:05:26', NULL, 24),
(40, 'dont create', 1, '2024-11-17 11:05:44', NULL, 0),
(41, 'dont create', 1, '2024-11-17 11:05:47', NULL, 0),
(42, 'User reported poll ID 30.', 1, '2024-11-17 11:06:00', 30, 30),
(43, 'fafdsaadsf', 1, '2024-11-17 11:06:09', NULL, 24),
(44, 'User reported poll ID 30.', 1, '2024-11-19 01:45:54', 30, 30),
(45, 'oe dhaka', 1, '2024-11-19 01:47:23', NULL, 24),
(46, 'User reported poll ID 33.', 1, '2024-11-19 01:47:43', 33, 30),
(47, 'oe daka del gara mula', 1, '2024-11-19 01:48:17', NULL, 12),
(48, 'User reported poll ID 30.', 1, '2024-11-19 04:06:20', 30, 30),
(49, 'User reported poll ID 30.', 1, '2024-11-19 08:36:25', 30, 30),
(50, 'User reported poll ID 30.', 1, '2024-11-19 08:36:47', 30, 30),
(51, 'User reported poll ID 30.', 1, '2024-11-19 08:37:13', 30, 30),
(52, 'dsafdsfafdasdf', 1, '2024-11-19 08:38:19', NULL, 24),
(53, 'User reported poll ID 30.', 1, '2024-11-19 12:15:43', 30, 30),
(54, 'User reported poll ID 30.', 1, '2024-11-20 02:06:11', 30, 30),
(55, 'User reported poll ID 38.', 1, '2024-12-01 13:36:13', 38, 15),
(56, 'User reported poll ID 39.', 1, '2024-12-02 02:32:06', 39, 12),
(57, 'User reported poll ID 39.', 1, '2024-12-03 02:01:48', 39, 12),
(58, 'New document submission for verification from user ID: 41', 1, '2024-12-04 08:56:06', NULL, NULL),
(59, 'New document submission for verification from user ID: 41', 1, '2024-12-04 08:58:28', NULL, NULL),
(60, 'New document submission for verification from user ID: 41', 1, '2024-12-04 09:00:05', NULL, NULL),
(61, 'User reported poll ID 40.', 1, '2024-12-05 01:29:51', 40, 10),
(62, 'User reported poll ID 41.', 1, '2024-12-05 11:55:25', 41, 10),
(63, 'New document submission for verification from user ID: 45', 1, '2024-12-06 13:00:42', NULL, NULL),
(64, 'New document submission for verification from user ID: 45', 1, '2024-12-06 13:01:17', NULL, NULL),
(65, 'New document submission for verification from user ID: 48', 1, '2024-12-07 03:20:47', NULL, NULL),
(66, 'New document submission for verification from user ID: 48', 1, '2024-12-07 03:21:20', NULL, NULL),
(67, 'New document submission for verification from user ID: 51', 1, '2024-12-07 03:56:59', NULL, NULL),
(68, 'User reported poll ID 49.', 1, '2024-12-07 04:28:22', 49, 48),
(69, 'New document submission for verification from user ID: 52', 1, '2024-12-07 04:34:56', NULL, NULL),
(70, 'New document submission for verification from user ID: 50', 1, '2024-12-09 10:41:03', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `otp_verification`
--

CREATE TABLE `otp_verification` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `otp_expiry` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE `polls` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(255) DEFAULT NULL,
  `poll_type` varchar(50) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `unique_link` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `polls`
--

INSERT INTO `polls` (`id`, `question`, `created_at`, `category`, `poll_type`, `start_date`, `end_date`, `user_id`, `unique_link`, `created_by`) VALUES
(49, 'who is best player?', '2024-12-07 03:58:26', 'Sports', NULL, '2024-12-07', '2024-12-08', 51, 'poll_6753c7e2dfeba5.00714009', 0),
(50, 'who is the fastest footballer in the world?', '2024-12-07 04:14:26', 'Sports', NULL, '2024-12-07', '2024-12-08', 51, 'poll_6753cba2145c19.95680667', 0),
(51, 'In which continent Nepal lies?', '2024-12-09 10:50:51', 'Education', NULL, '2024-12-09', '2024-12-10', 50, 'poll_6756cb8b703e67.58591762', 0),
(52, 'Which is the national game of the Nepal?', '2024-12-09 10:56:33', 'Sports', NULL, '2024-12-10', '2024-12-11', 48, 'poll_6756cce10f7801.52812688', 0);

-- --------------------------------------------------------

--
-- Table structure for table `poll_options`
--

CREATE TABLE `poll_options` (
  `id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `option_text` varchar(255) NOT NULL,
  `votes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `poll_options`
--

INSERT INTO `poll_options` (`id`, `poll_id`, `option_text`, `votes`) VALUES
(217, 49, 'Messi', 1),
(218, 49, 'Ronaldo', 0),
(219, 49, 'Pele', 1),
(220, 49, 'Maradona', 0),
(221, 50, 'Kyle Wlaker', 1),
(222, 50, 'Ronaldo', 0),
(223, 50, 'Pele', 0),
(224, 50, 'Maradona', 0),
(225, 51, 'Europe', 0),
(226, 51, 'Asia', 1),
(227, 51, 'South America', 0),
(228, 51, 'Africa', 0),
(229, 52, 'VolleyBall', 1),
(230, 52, 'DandiBiyo', 0),
(231, 52, 'Kabbadi', 0),
(232, 52, 'Karate', 0);

-- --------------------------------------------------------

--
-- Table structure for table `prayojan`
--

CREATE TABLE `prayojan` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `country` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `verified` tinyint(1) DEFAULT 0,
  `profile_pic` varchar(255) DEFAULT 'uploads/default_profile.png',
  `last_active` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prayojan`
--

INSERT INTO `prayojan` (`id`, `name`, `phone`, `email`, `password`, `country`, `address`, `verified`, `profile_pic`, `last_active`) VALUES
(48, 'Prajwol Shrestha', 2147483647, 'prajwolbca22@oic.edu.np', 'd11b0e594756c95007b5e29b9a429640', 'Nepal', 'Budhanilkantha - 10, Kathmandu', 1, 'uploads/wallpaperflare.com_wallpaper (1).jpg', NULL),
(49, 'rozan thami', 2147483647, 'knoxx799@gmail.com', '69b48de3850dd5193ed6859fb5788583', 'Nepal', 'Budhanilkantha - 10, Kathmandu', 0, 'uploads/default_profile.png', NULL),
(50, 'SUYOG KADARIYA', 2147483647, '7suyog@gmail.com', '5c9e01573cef0ba08498875b98b02029', 'Nepal', 'Budhanilkantha - 10, Kathmandu', 1, 'uploads/wallpaperflare.com_wallpaper (1).jpg', NULL),
(51, 'prajwol don', 980000000, 'prazolstha12345@gmail.com', '9e01454a2a4d5114b4e8c67d21e0cdd7', 'Nepal', 'Budhanilkantha - 10, Kathmandu', 1, 'uploads/Prajwol Shrestha (1).jpg', NULL),
(52, 'Ankit Dahal', 0, 'dahal.ankit7@gmail.com', '447d2c8dc25efbc493788a322f1a00e7', 'test', 'test', 1, 'uploads/front.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`id`, `user_id`, `message`, `created_at`) VALUES
(9, 51, 'change this', '2024-12-07 04:29:14');

-- --------------------------------------------------------

--
-- Table structure for table `verification_documents`
--

CREATE TABLE `verification_documents` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `document` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `photo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verification_documents`
--

INSERT INTO `verification_documents` (`id`, `user_id`, `document`, `status`, `photo`) VALUES
(24, 48, 'uploads/6753bf0f64c41_WhatsApp Image 2024-11-16 at 4.39.25 PM (1).jpeg', 'approved', 'uploads/6753bf0f64c58_wallpaperflare.com_wallpaper.jpg'),
(25, 48, 'uploads/6753bf30bac15_WhatsApp Image 2024-11-16 at 4.39.25 PM (1).jpeg', 'rejected', 'uploads/6753bf30bac23_wallpaperflare.com_wallpaper.jpg'),
(26, 51, 'uploads/6753c78b40b92_WhatsApp Image 2024-11-16 at 4.39.25 PM.jpeg', 'approved', 'uploads/6753c78b40bac_wallpaperflare.com_wallpaper (1).jpg'),
(27, 52, 'uploads/6753d07008975_WhatsApp Image 2024-11-16 at 4.39.25 PM.jpeg', 'approved', 'uploads/6753d0700897e_verified-icon.png'),
(28, 50, 'uploads/6756c93f95b70_wallpaperflare.com_wallpaper (1).jpg', 'approved', 'uploads/6756c93f95d30_wallpaperflare.com_wallpaper.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `poll_id`, `option_id`, `user_id`, `created_at`) VALUES
(11, 23, 112, 0, '2024-11-11 13:55:58'),
(12, 24, 116, 0, '2024-11-11 14:17:25'),
(13, 25, 120, 12, '2024-11-12 13:15:13'),
(14, 26, 126, 12, '2024-11-12 13:36:06'),
(15, 27, 128, 23, '2024-11-12 14:44:23'),
(16, 26, 124, 10, '2024-11-12 14:46:36'),
(17, 27, 131, 10, '2024-11-12 14:46:40'),
(18, 26, 124, 17, '2024-11-12 14:47:19'),
(19, 27, 128, 17, '2024-11-12 14:47:21'),
(20, 26, 124, 24, '2024-11-12 16:09:54'),
(21, 27, 128, 24, '2024-11-12 16:09:58'),
(22, 28, 132, 24, '2024-11-12 16:10:01'),
(23, 29, 136, 24, '2024-11-13 03:15:48'),
(24, 31, 144, 24, '2024-11-13 13:51:37'),
(25, 32, 148, 26, '2024-11-13 14:31:02'),
(26, 29, 139, 26, '2024-11-13 15:58:13'),
(27, 33, 150, 12, '2024-11-14 03:39:49'),
(28, 34, 154, 17, '2024-11-14 08:24:41'),
(29, 29, 138, 12, '2024-11-14 11:05:58'),
(30, 30, 142, 30, '2024-11-17 08:48:44'),
(31, 31, 144, 30, '2024-11-17 08:48:52'),
(32, 33, 150, 30, '2024-11-17 08:48:59'),
(33, 35, 159, 30, '2024-11-17 08:49:04'),
(34, 30, 140, 17, '2024-11-17 10:45:23'),
(35, 31, 144, 17, '2024-11-17 10:45:26'),
(36, 33, 150, 17, '2024-11-17 10:45:28'),
(37, 35, 158, 17, '2024-11-17 10:45:34'),
(38, 33, 152, 24, '2024-11-19 12:23:27'),
(39, 34, 154, 24, '2024-11-19 12:23:30'),
(40, 35, 159, 24, '2024-11-19 12:23:34'),
(41, 30, 140, 24, '2024-11-19 12:23:36'),
(42, 37, 165, 24, '2024-11-20 02:17:32'),
(43, 38, 171, 30, '2024-12-01 13:35:02'),
(44, 39, 173, 12, '2024-12-02 02:31:30'),
(45, 39, 174, 30, '2024-12-02 09:55:00'),
(46, 39, 174, 0, '2024-12-04 01:47:15'),
(47, 40, 179, 12, '2024-12-04 09:40:48'),
(48, 40, 177, 24, '2024-12-04 09:41:26'),
(49, 40, 178, 17, '2024-12-04 09:42:14'),
(50, 40, 180, 15, '2024-12-04 09:42:49'),
(51, 40, 179, 10, '2024-12-04 10:17:15'),
(52, 41, 186, 10, '2024-12-04 10:34:42'),
(53, 41, 185, 17, '2024-12-04 11:11:59'),
(54, 42, 189, 17, '2024-12-04 12:13:06'),
(55, 40, 177, 16, '2024-12-04 13:20:03'),
(56, 41, 187, 16, '2024-12-04 13:20:08'),
(57, 42, 191, 16, '2024-12-04 13:20:11'),
(58, 42, 191, 10, '2024-12-05 03:08:03'),
(59, 44, 197, 0, '2024-12-05 12:27:15'),
(60, 46, 207, 10, '2024-12-05 14:41:35'),
(61, 46, 206, 12, '2024-12-05 14:45:23'),
(62, 46, 206, 45, '2024-12-06 13:04:48'),
(63, 49, 219, 48, '2024-12-07 04:25:00'),
(64, 50, 221, 48, '2024-12-07 04:25:10'),
(65, 49, 217, 52, '2024-12-07 04:35:43'),
(66, 51, 226, 48, '2024-12-09 10:54:25'),
(67, 52, 229, 50, '2024-12-09 10:57:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `otp_verification`
--
ALTER TABLE `otp_verification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `polls`
--
ALTER TABLE `polls`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_link` (`unique_link`);

--
-- Indexes for table `poll_options`
--
ALTER TABLE `poll_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poll_id` (`poll_id`);

--
-- Indexes for table `prayojan`
--
ALTER TABLE `prayojan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `verification_documents`
--
ALTER TABLE `verification_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poll_id` (`poll_id`),
  ADD KEY `option_id` (`option_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `otp_verification`
--
ALTER TABLE `otp_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `polls`
--
ALTER TABLE `polls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `poll_options`
--
ALTER TABLE `poll_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT for table `prayojan`
--
ALTER TABLE `prayojan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `verification_documents`
--
ALTER TABLE `verification_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `otp_verification`
--
ALTER TABLE `otp_verification`
  ADD CONSTRAINT `otp_verification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `prayojan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `poll_options`
--
ALTER TABLE `poll_options`
  ADD CONSTRAINT `poll_options_ibfk_1` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD CONSTRAINT `user_notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `prayojan` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `verification_documents`
--
ALTER TABLE `verification_documents`
  ADD CONSTRAINT `verification_documents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `prayojan` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
