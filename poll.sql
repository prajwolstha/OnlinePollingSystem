-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2024 at 08:15 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE `polls` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `polls`
--

INSERT INTO `polls` (`id`, `question`, `created_at`) VALUES
(1, 'what is your name', '2024-10-03 05:49:12'),
(2, 'what is your father name?', '2024-10-03 05:49:56'),
(3, 'what is your father name?', '2024-10-03 05:50:04'),
(4, 'what is your father name?', '2024-10-03 05:52:43'),
(5, 'abcd', '2024-10-03 05:53:07'),
(6, 'hello  its me', '2024-10-03 06:08:52'),
(7, 'hello  its me', '2024-10-03 06:09:11'),
(8, 'how are you?', '2024-10-03 06:10:59');

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
(1, 1, 'prajwol', 3),
(2, 1, 'suyog', 0),
(3, 1, 'rozan', 0),
(4, 1, 'ramu', 1),
(5, 2, 'ggg', 0),
(6, 2, 'fff', 0),
(7, 2, 'dddd', 0),
(8, 2, 'aaaa', 0),
(9, 3, 'ggg', 0),
(10, 3, 'fff', 0),
(11, 3, 'dddd', 0),
(12, 3, 'aaaa', 0),
(13, 4, 'ggg', 0),
(14, 4, 'fff', 0),
(15, 4, 'dddd', 0),
(16, 4, 'aaaa', 0),
(17, 5, 'aa', 1),
(18, 5, 'vv', 0),
(19, 5, 'cc', 0),
(20, 5, 'dd', 0),
(21, 6, 'adele', 0),
(22, 6, 'taylor', 0),
(23, 6, 'ed sheeran', 0),
(24, 6, 'eminem', 1),
(25, 7, 'adele', 0),
(26, 7, 'taylor', 0),
(27, 7, 'ed sheeran', 0),
(28, 7, 'eminem', 0),
(29, 8, 'good', 0),
(30, 8, 'not good', 0),
(31, 8, 'bad', 0),
(32, 8, 'angry', 0);

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
  `verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prayojan`
--

INSERT INTO `prayojan` (`id`, `name`, `phone`, `email`, `password`, `country`, `address`, `verified`) VALUES
(1, 'Prajwol Shrestha', 2147483647, 'prajwol@gmail.com', '$2y$10$1/c4CYrlCAq0kCjYnCUXUONUZpFoiA2H0nKIQJxkw2m', 'Nepal', 'Budhanilkantha - 10, Kathmandu', 0),
(2, 'aaa', 2147483647, 'aaa@admin.com', '$2y$10$0njV12.SN3JkHkhkhHnxouQ4XA.du.CPOIhFJ7PQzvK', 'Nepal', 'Budhanilkantha - 10, Kathmandu', 0),
(3, 'PRANJU SHRESTHA', 2147483647, 'pranju@admin.com', '$2y$10$abERYmZGDo8On4I8rTkVUegWZJOZYoxdky3tRPS9o2O', 'Nepal', 'Budhanilkantha - 10, Kathmandu', 0),
(4, 'sss', 2147483647, 'sss@gmail.com', 'sss', 'Nepal', 'Budhanilkantha - 10, Kathmandu', 0),
(5, '', 2147483647, '', '', 'Nepal', 'Budhanilkantha - 10, Kathmandu', 0),
(8, 'admin admin', 987654321, 'admin@a.com', '21232f297a57a5a743894a0e4a801fc3', 'adminland', 'adminland', 1),
(9, 'abc', 987654321, 'abc@abc.com', '900150983cd24fb0d6963f7d28e17f72', 'adminland', 'adminland', 1),
(10, 'SUYOG KADARIYA', 2147483647, '7suyog@gmail.com', '5c9e01573cef0ba08498875b98b02029', 'Nepal', 'Budhanilkantha - 10, Kathmandu', 1),
(11, 'prajwoldon', 2147483647, 'prajwol123@gamil.com', 'f0a72478bf1066fec30d729f0c547c4f', 'Nepal', 'Budhanilkantha - 10, Kathmandu', 1);

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
(6, 11, 'uploads/Screenshot 2024-08-27 235130.png', 'rejected', 'uploads/Screenshot 2024-10-03 111333.png');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `polls`
--
ALTER TABLE `polls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `poll_options`
--
ALTER TABLE `poll_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `prayojan`
--
ALTER TABLE `prayojan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `verification_documents`
--
ALTER TABLE `verification_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
