-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2024 at 11:53 AM
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
(56, 'User reported poll ID 39.', 1, '2024-12-02 02:32:06', 39, 12);

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
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `polls`
--

INSERT INTO `polls` (`id`, `question`, `created_at`, `category`, `poll_type`, `start_date`, `end_date`, `user_id`) VALUES
(30, 'what is your name', '2024-11-13 13:01:42', 'Entertainment', NULL, '2024-11-13', '2024-11-20', 24),
(31, 'who is best player?', '2024-11-13 13:02:18', 'Sports', NULL, '2024-11-13', '2024-11-21', 24),
(33, 'do u like anil?', '2024-11-14 03:39:28', 'Entertainment', NULL, '2024-11-14', '2024-11-21', 12),
(34, 'who is don?', '2024-11-14 08:23:31', 'Entertainment', NULL, '2024-11-21', '2024-11-28', 17),
(35, 'hello from the other side??', '2024-11-14 11:12:18', 'Entertainment', NULL, '2024-11-14', '2024-11-21', 12),
(36, 'who is topper?', '2024-11-19 12:21:53', '', NULL, '0000-00-00', '0000-00-00', 24),
(37, 'hello', '2024-11-20 02:16:52', 'Education', NULL, '2024-11-13', '2024-11-28', 24),
(38, 'which is the tallest mountain?', '2024-12-01 13:32:52', 'Education', NULL, '2024-12-01', '2024-12-02', 30),
(39, 'what is yoru fkjdsfhdsakfh/', '2024-12-02 02:29:23', 'Entertainment', NULL, '2024-12-02', '2024-12-10', 30);

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
(140, 30, 'ramu', 2),
(141, 30, 'shmu', 0),
(142, 30, 'prajwol', 1),
(143, 30, 'rojan', 0),
(144, 31, 'messi', 3),
(145, 31, 'ronaldo', 0),
(146, 31, 'neymar', 0),
(147, 31, 'pele', 0),
(150, 33, 'yes', 3),
(151, 33, 'no', 0),
(152, 33, 'idk', 1),
(153, 34, 'aa', 0),
(154, 34, 'dd', 2),
(155, 34, 'ff', 0),
(156, 34, 'tt', 0),
(157, 35, 'adele', 0),
(158, 35, 'taylor', 1),
(159, 35, 'beyonce', 2),
(160, 35, 'prajwol', 0),
(161, 36, 'ram', 0),
(162, 36, 'shyam', 0),
(163, 36, 'hari', 0),
(164, 36, 'ganesh', 0),
(165, 37, 'ee', 1),
(166, 37, 'rr', 0),
(167, 37, 'tt', 0),
(168, 37, 'yy', 0),
(169, 38, 'mt elburus', 0),
(170, 38, 'mt maklau', 0),
(171, 38, 'mt k2', 1),
(172, 38, 'mt everest', 0),
(173, 39, 'ff', 1),
(174, 39, 'gg', 1),
(175, 39, 'hh', 0),
(176, 39, 'ii', 0);

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
  `profile_pic` varchar(255) DEFAULT 'uploads/default_profile.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prayojan`
--

INSERT INTO `prayojan` (`id`, `name`, `phone`, `email`, `password`, `country`, `address`, `verified`, `profile_pic`) VALUES
(8, 'admin', 987654321, 'admin@a.com', '21232f297a57a5a743894a0e4a801fc3', 'adminland', 'adminland', 1, 'uploads/image.png'),
(9, 'abc', 987654321, 'abc@abc.com', '900150983cd24fb0d6963f7d28e17f72', 'adminland', 'adminland', 1, 'uploads/heroimg.jpg'),
(10, 'SUYOG KADARIYA', 2147483647, '7suyog@gmail.com', '5c9e01573cef0ba08498875b98b02029', 'Nepal', 'Budhanilkantha - 10, Kathmandu', 1, 'uploads/pizza-pizza-filled-with-tomatoes-salami-olives.jpg'),
(11, 'prajwoldon', 2147483647, 'prajwol123@gamil.com', 'f0a72478bf1066fec30d729f0c547c4f', 'Nepal', 'Budhanilkantha - 10, Kathmandu', 1, 'uploads/default_profile.png'),
(12, 'Rojan Thami', 2147483647, 'rojan@gmail.com', '0ed8d98967c0cb60a39fd225803e0dfb', 'Nepal', 'Budhanilkantha - 10, Kathmandu', 1, 'uploads/Prajwol Shrestha (1).jpg'),
(13, 'PRANJU SHRESTHA', 2147483647, 'pranju@gmail.com', '75097016e0e2cda52eb4535a4b5ac7ff', 'Nepal', 'Budhanilkantha - 10, Kathmandu', 0, 'uploads/activity.png'),
(14, 'ram thapa', 2147483647, 'ramthapa@gmail.com', '4641999a7679fcaef2df0e26d11e3c72', 'Nepal', 'ramuland', 0, 'uploads/Screenshot 2024-09-04 165855.png'),
(15, 'sir', 2147483647, 'sir@gmail.com', 'dcff57c9a964f83fbf81cc75ec2e413a', 'Nepal', 'Budhanilkantha - 10, Kathmandu', 1, 'uploads/logo.jpg'),
(16, 'samosa', 777777777, 'samosa@gmail.com', 'b0c39b2b615a250c8ebf9a4a0d323686', 'japan', 'jjjjjjjjjjjj', 1, 'uploads/Prajwol Shrestha.jpg'),
(17, 'pratix', 0, 'pratik@gmail.com', '0cb2b62754dfd12b6ed0161d4b447df7', 'nepal', 'fdsafdsafdsaf', 1, 'uploads/momo.jpg'),
(18, 'Prajwol Shrestha', 2147483647, '7suyog@gmail.com', '5c9e01573cef0ba08498875b98b02029', 'Nepal', 'Galyang', 0, 'uploads/default_profile.png'),
(19, 'aa', 2147483647, 'aa@gmail.com', '4124bc0a9335c27f086f24ba207a4912', 'Nepal', 'Galyang', 0, 'uploads/default_profile.png'),
(20, 'bb', 90000000, 'bb@gmail.com', '21ad0bd836b90d08f4cf640b4c298e7c', 'Nepal', 'Galyang', 0, 'uploads/default_profile.png'),
(21, 'ww', 2147483647, 'ww@gmail.com', 'ww', 'Nepal', 'Galyang', 0, 'uploads/default_profile.png'),
(22, 'a', 1, 'a@a.com', '0cc175b9c0f1b6a831c399e269772661', 'a', 'a', 0, 'uploads/default_profile.png'),
(23, 'mandip', 3333333, 'mandip@gmail.com', '847ae2bef98a01bf5c12a7b7d053ae5f', 'Nepal', 'gaushala', 1, 'uploads/default_profile.png'),
(24, 'ram karki', 987654321, 'ramkarki@gmail.com', '48cc2afa9781bd59887ea3c1f5ab9b4e', 'Nepal', 'gaushala', 1, 'uploads/Screenshot 2024-08-27 232949.png'),
(25, 'hari thapa', 1234567891, 'harithapa@gmail.com', 'a9bcf1e4d7b95a22e2975c812d938889', 'Nepal', 'kapan', 0, 'uploads/default_profile.png'),
(26, 'komal', 2147483647, 'komal@gmail.com', '690b4bac6ca9fb81814128a294470f92', 'Nepal', 'Budhanilkantha - 10, Kathmandu', 1, 'uploads/Screenshot 2024-08-31 234011.png'),
(29, 'Prajwol Shrestha', 2147483647, 'prazolstha12345@gmail.com', '0192023a7bbd73250516f069df18b500', 'Nepal', 'Galyang', 0, 'uploads/default_profile.png'),
(30, 'Prajwol Shrestha', 2147483647, 'prajwol1@gmail.com', '80bd50c15f693f95b78807ecefee980b', 'Nepal', 'Galyang', 1, 'uploads/Prajwol Shrestha (1).jpg'),
(31, 'ankit thapa', 987657899, 'ankit@gmail.com', '447d2c8dc25efbc493788a322f1a00e7', 'Nepal', 'kapan', 1, 'uploads/biriyani.jpg');

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
(1, 24, 'k ho bhayena hai', '2024-11-19 12:16:10'),
(2, 24, 'k ho bhayena hai', '2024-11-19 12:19:42'),
(3, 24, 'k ho bhayena hai', '2024-11-19 12:19:56'),
(4, 24, 'k pollhalis mula', '2024-11-20 02:06:34'),
(5, 30, 'this poll is restricted because of violating the rules and regulation.', '2024-12-01 13:37:45'),
(6, 30, 'delete this poll', '2024-12-02 02:32:47');

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
(1, 8, 'uploads/heroimg.jpg', 'approved', 'uploads/heroimg.jpg'),
(2, 9, 'uploads/pizza-pizza-filled-with-tomatoes-salami-olives.jpg', 'approved', 'uploads/heroimg.jpg'),
(3, 10, 'uploads/heroimg.jpg', 'approved', 'uploads/heroimg.jpg'),
(4, 10, 'uploads/heroimg.jpg', 'rejected', 'uploads/heroimg.jpg'),
(5, 11, 'uploads/Screenshot 2024-08-27 235130.png', 'approved', 'uploads/Screenshot 2024-10-03 111333.png'),
(6, 11, 'uploads/Screenshot 2024-08-27 235130.png', 'rejected', 'uploads/Screenshot 2024-10-03 111333.png'),
(7, 10, 'uploads/verification_docs/verified.png', 'rejected', 'uploads/verification_docs/Approval.png'),
(8, 12, 'uploads/verification_docs/LUCK.jpg', 'approved', 'uploads/verification_docs/Prajwol Shrestha.jpg'),
(9, 12, 'uploads/verification_docs/LUCK.jpg', 'rejected', 'uploads/verification_docs/Prajwol Shrestha.jpg'),
(10, 16, 'uploads/biriyani.jpg', 'approved', 'uploads/biriyani.jpg'),
(11, 16, 'uploads/biriyani.jpg', 'approved', 'uploads/biriyani.jpg'),
(12, 23, 'uploads/Prajwol Shrestha (1).jpg', 'approved', 'uploads/Prajwol Shrestha (1).jpg'),
(13, 26, 'uploads/6734b7bbe4425_Screenshot 2024-08-31 220802.png', 'approved', 'uploads/6734b7bbe4431_Screenshot 2024-08-31 230652.png'),
(14, 15, 'uploads/6735717f02cfe_Pranju Resume (2).pdf', 'approved', 'uploads/6735717f02d07_Pranju Resume (1).pdf'),
(15, 15, 'uploads/6735719d9b69b_Pranju Resume (2).pdf', 'rejected', 'uploads/6735719d9b6a7_Pranju Resume (1).pdf'),
(16, 30, 'uploads/6735eb08f02b6_Prajwol Shrestha (1).jpg', 'approved', 'uploads/6735eb08f02c4_Prajwol Shrestha (1).jpg'),
(17, 31, 'uploads/67386edca82c8_verified-icon.png', 'approved', 'uploads/67386edca82d5_heroimg.jpg'),
(18, 31, 'uploads/67386f0aeb19f_verified-icon.png', 'approved', 'uploads/67386f0aeb1a7_heroimg.jpg');

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
(45, 39, 174, 30, '2024-12-02 09:55:00');

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
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `otp_verification`
--
ALTER TABLE `otp_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `polls`
--
ALTER TABLE `polls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `poll_options`
--
ALTER TABLE `poll_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT for table `prayojan`
--
ALTER TABLE `prayojan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `verification_documents`
--
ALTER TABLE `verification_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

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
