-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2023 at 11:54 AM
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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`, `profile_img`) VALUES
(1, 'admin', 'admin@mail.com', '$2y$10$pJP1fxMtchxdZYC52SLU8eNL3Q2VPjxPtrNifPT2tfWiN6fH5oN1O', '2023-10-18 11:26:23', NULL),
(2, 'admin', 'admin2@mail.com', '$2y$10$ALPvjTtwKjoDI6Rak/R6N.VMbL7LjS9gULY5a2/CbfKvm6ETrvjv6', '2023-10-18 11:35:24', NULL),
(3, 'admin', 'admin1@mail.com', '$2y$10$DqzXgdEYEpc0m8utxtKTYeWzeDBXKx7zT77rPi5H8qLjtYjYKlKVm', '2023-10-18 12:33:17', NULL),
(4, 'ad', 'admin12@mail.com', '$2y$10$nLZXL4yJH1oYrjH4ectcFO1b6TapnRU4ZzK.BVl3HUpCuEoRtjKGy', '2023-10-18 14:17:38', NULL),
(5, 'adminn', 'admin77@mail.com', '$2y$10$Ga8LEdc5QgCXOT/wia/0s.pekFhyu10Ow6BiLvUI5gCHTsAcHq/Rq', '2023-10-30 19:15:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `todos`
--

CREATE TABLE `todos` (
  `id` int(11) NOT NULL,
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

INSERT INTO `todos` (`id`, `title`, `description`, `status`, `created_at`, `updated_at`, `user_id`) VALUES
(5, 'study', 'help', 0, '2023-10-30 15:11:04', '2023-10-30 15:18:34', 19),
(6, 'dsgsdgs', 'tagv', 0, '2023-10-30 15:11:16', '2023-10-30 15:18:34', 19),
(8, 'study', 'later', 0, '2023-10-30 15:20:27', '2023-10-30 15:21:11', 8),
(9, 'work', '', 0, '2023-10-30 15:21:05', '2023-10-30 15:21:05', 8),
(10, 'working', 'day and night', 0, '2023-10-30 18:55:25', '2023-10-30 18:55:25', 21),
(11, 'sleeping', 'never', 0, '2023-10-30 18:56:09', '2023-10-30 18:56:09', 21);

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
(10, 'aly', 'aly2@mail.com', '$2y$10$iDR7pbuAa2O12lPWFkG6TeuFfOf7Wm0COqIGkEqQNvlOl9CGbkQ9W', NULL, '2023-10-17 20:52:34'),
(11, 'mustafa', 'mustafa54@mail.com', '$2y$10$PsdrKqt.FvVdbrmnYFWSj.D9xSleZRBjd182K.Wxm29aXAElvMp9G', NULL, '2023-10-18 13:55:03'),
(12, 'mustafa', 'mustafa33@mail.com', '$2y$10$02pevW342lEGR9oRVtVnWOp3mMnt8NH9Yv9YBrmN2jEayM8/vugji', '../Storage/UserProfileImg/mustafa33@mail.com_profileImg.jpg', '2023-10-22 12:38:23'),
(13, 'mustafa', 'mustafa34@mail.com', '$2y$10$TAVQUAw8GxbZyHdH8qU4mOf1IQjX/qmFwJHhwEGkXKNeme/QpmAJu', '../Storage/UserProfileImg/default_profileImg.png', '2023-10-22 12:56:08'),
(14, 'mustafa', 'mustafa35@mail.com', '$2y$10$FOIVLb70O7LIYZZti5OEfOgYWm99vuRkBofLLfmUpeC/5Yq56E5/i', '../Storage/UserProfileImg/default_profileImg.png', '2023-10-22 12:57:00'),
(15, 'mustafa', 'mustafa36@mail.com', '$2y$10$gUZxDw0igD0nwrjhYYJiCOhajKhqZqQdEN2E68T/FqinIsZH/XOVG', '../Storage/UserProfileImg/mustafa36@mail.com_profileImg.jpg', '2023-10-22 12:57:37'),
(16, 'mustafa', 'mustafa40@mail.com', '$2y$10$bl1982t9/Aou54X./VPbpu2mp716aXMUzjyKkjs5DJhHdquCFNi6q', 'http://localhost/todoapp/app/Storage/UserProfileImg/1697981451_profileImg.jpg', '2023-10-22 13:30:51'),
(17, 'mustafa', 'mustafa39@mail.com', '$2y$10$afYrZOOmfeRhTn1ntiiGteI0b0UjM/MkmjLk1oK57N0IAZT/YATAi', 'http://localhost/todoapp/app/Storage/UserProfileImg/mustafa39@mail.com_profileImg.jpg', '2023-10-22 13:35:44'),
(18, 'mustafa', 'mustafa41@mail.com', '$2y$10$IiHNZ22nQ/M5zUhGrM9bTeKY9TkSf49lBfrT5SzhngT0K706WjXa6', 'http://localhost/todoapp/app/Storage/UserProfileImg/1697984864_profileImg.jpg', '2023-10-22 14:27:44'),
(19, 'mustafa', 'mustafa52@mail.com', '$2y$10$WIW3FOlYlujRoEoDl1MafeeeN7llCO2rndFW6IzaZrx4RRHNdrwcC', 'http://localhost/todoapp/app/Storage/UserProfileImg/1697985768_profileImg.jpg', '2023-10-22 14:42:48'),
(20, 'mustafa', 'mustafa100@mail.com', '$2y$10$MajqfGNPYtfCwrcGNGjgvun9Rrze6PmAO9dAGzt2v4BInJE14UC1u', 'http://localhost/todoapp/app/Storage/UserProfileImg/default_profileImg.png', '2023-10-22 14:55:40'),
(21, 'aly', 'aly@mail.com', '$2y$10$gOcydq30ZZhFl/Em4lDIR.h44Ncjmr3iEA2QLbaCuppxbcwb7aZ6.', 'http://localhost/todoapp/app/Storage/UserProfileImg/1698692082_profileImg.jpg', '2023-10-30 18:54:42'),
(22, 'mo', 'mo@mail.com', '$2y$10$hpIMtxFKBWgc12ePa5Esz.FBL1YzL7c2lvJsE34JJPr7YTXjkA/O2', 'http://localhost/todoapp/app/Storage/UserProfileImg/1698693019_profileImg.jpg', '2023-10-30 19:10:20');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `todos`
--
ALTER TABLE `todos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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
