-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2024 at 03:36 PM
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
-- Database: `poll`
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `is_read`, `created_at`) VALUES
(1, 'New verification document submitted by user ID: 16', 1, '2024-11-11 12:02:07'),
(2, 'New verification document submitted by user ID: 16', 1, '2024-11-11 12:02:39');

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
(23, 'who lets the dog out?', '2024-11-11 13:50:00', 'Entertainment', NULL, '2024-11-12', '2024-11-21', 16),
(24, 'K CHA KHABAR?', '2024-11-11 14:15:36', 'Entertainment', NULL, '2024-11-18', '2024-11-28', 12);

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
(112, 23, 'amir khan', 0),
(113, 23, 'rr', 0),
(114, 23, 'tt', 0),
(115, 23, 'yy', 0),
(116, 24, 'THIK CHA', 0),
(117, 24, 'ALL GOOD', 0),
(118, 24, 'NOT GOOD', 0),
(119, 24, 'HAWA', 0);

-- --------------------------------------------------------

--
-- Table structure for table `prayojan`
--

CREATE TABLE `prayojan` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` int(255) NOT NULL,
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
(15, 'sir', 2147483647, 'sir@gmail.com', 'dcff57c9a964f83fbf81cc75ec2e413a', 'Nepal', 'Budhanilkantha - 10, Kathmandu', 0, 'uploads/logo.jpg'),
(16, 'samosa', 777777777, 'samosa@gmail.com', 'b0c39b2b615a250c8ebf9a4a0d323686', 'japan', 'jjjjjjjjjjjj', 1, 'uploads/Prajwol Shrestha.jpg'),
(17, 'pratix', 0, 'pratik@gmail.com', '0cb2b62754dfd12b6ed0161d4b447df7', 'nepal', 'fdsafdsafdsaf', 1, 'uploads/default_profile.png');

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
(11, 16, 'uploads/biriyani.jpg', 'approved', 'uploads/biriyani.jpg');

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
(12, 24, 116, 0, '2024-11-11 14:17:25');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `polls`
--
ALTER TABLE `polls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `poll_options`
--
ALTER TABLE `poll_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `prayojan`
--
ALTER TABLE `prayojan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `verification_documents`
--
ALTER TABLE `verification_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `poll_options`
--
ALTER TABLE `poll_options`
  ADD CONSTRAINT `poll_options_ibfk_1` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `verification_documents`
--
ALTER TABLE `verification_documents`
  ADD CONSTRAINT `verification_documents_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `prayojan` (`id`);

--
-- Constraints for table `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`option_id`) REFERENCES `poll_options` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
