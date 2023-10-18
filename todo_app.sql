-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2023 at 02:23 PM
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
-- Database: `todo_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'admin', 'admin@mail.com', '$2y$10$pJP1fxMtchxdZYC52SLU8eNL3Q2VPjxPtrNifPT2tfWiN6fH5oN1O', '2023-10-18 11:26:23'),
(2, 'admin', 'admin2@mail.com', '$2y$10$ALPvjTtwKjoDI6Rak/R6N.VMbL7LjS9gULY5a2/CbfKvm6ETrvjv6', '2023-10-18 11:35:24');

-- --------------------------------------------------------

--
-- Table structure for table `todos`
--

CREATE TABLE `todos` (
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `todos`
--

INSERT INTO `todos` (`title`, `description`, `status`, `created_at`, `updated_at`, `user_id`) VALUES
('work hard', 'wake up early at 7', 0, '2023-10-16 16:32:51', '2023-10-16 16:32:51', 4),
('hi', '', 0, '2023-10-17 23:45:28', '2023-10-18 09:33:07', 8),
('la', '', 0, '2023-10-17 23:13:48', '2023-10-17 23:13:48', 8),
('late', '', 0, '2023-10-17 23:43:02', '2023-10-17 23:43:02', 8),
('later', '', 1, '2023-10-17 22:48:31', '2023-10-17 22:48:38', 8),
('now', '', 0, '2023-10-17 22:41:55', '2023-10-17 22:41:55', 8),
('sleep', 'I want to sleep now', 0, '2023-10-18 00:07:03', '2023-10-18 00:07:03', 8),
('work ', 'wake up early at 7', 0, '2023-10-16 21:45:47', '2023-10-17 13:39:45', 8),
('work again', 'wake up early at 7', 1, '2023-10-16 21:45:52', '2023-10-17 13:31:22', 8),
('work hard', 'wake up early at 7', 0, '2023-10-16 21:45:41', '2023-10-17 13:39:49', 8);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_img` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `profile_img`, `created_at`) VALUES
(4, 'name', 'mail@fgh.com', '$2y$10$xlWxUCHahg8FoJvNr1c.ZucGluKOi2oy.LcYWcdQHRGjM6CA2kiau', NULL, '2023-10-16 13:39:49'),
(5, 'mustafa', 'ahoo@mail.com', '$2y$10$VLlpzByo1.vGzYZMA7eHweiFlilgxBv5pbcTNvUzwGqaXUdGW31Gi', NULL, '2023-10-16 13:41:15'),
(6, 'aa', 'a@mail.com', '$2y$10$EXpLC/o0MDYKh.GPTE7h0.U4gmYFQhu05NoalRrJ46acTg.irSQHi', NULL, '2023-10-16 15:43:46'),
(7, 'mustafa', 'mustafaaaa@mail.com', '$2y$10$igHE9PcrQi40ciaryRKGduejPWU0MOUAmzTtzIV3tj55vrPijqFkW', NULL, '2023-10-16 15:50:20'),
(8, 'mustafa', 'mustafa@mail.com', '$2y$10$BLyUs1jUT5Ky84Y38my5H.7kSineaPGAV60bXn1tpSYPPcek1XkYG', NULL, '2023-10-16 16:34:57'),
(9, 'aly', 'aly1@mail.com', '$2y$10$yPqd27xiZmtfLNMEeag2nu1/5JtPgmXjBwgwTja2VtaREAyl6FIca', NULL, '2023-10-17 20:29:05'),
(10, 'aly', 'aly2@mail.com', '$2y$10$iDR7pbuAa2O12lPWFkG6TeuFfOf7Wm0COqIGkEqQNvlOl9CGbkQ9W', NULL, '2023-10-17 20:52:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `todos`
--
ALTER TABLE `todos`
  ADD PRIMARY KEY (`user_id`,`title`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `todos`
--
ALTER TABLE `todos`
  ADD CONSTRAINT `todos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
