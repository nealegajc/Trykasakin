-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2025 at 12:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tric_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `driver_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `or_cr_path` varchar(255) NOT NULL,
  `license_path` varchar(255) NOT NULL,
  `picture_path` varchar(255) NOT NULL,
  `verification_status` enum('pending','verified','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`driver_id`, `user_id`, `or_cr_path`, `license_path`, `picture_path`, `verification_status`, `created_at`) VALUES
(1, 2, 'uploads/or_cr/1761469364_Screenshot 2025-02-19 214935.png', 'uploads/licenses/1761469364_Screenshot 2025-02-20 062524.png', 'uploads/pictures/1761469364_Screenshot 2025-02-20 094807.png', 'pending', '2025-10-26 09:02:44'),
(2, 4, 'uploads/or_cr/1761628701_Screenshot 2025-02-20 063519.png', 'uploads/licenses/1761628701_Screenshot 2025-03-14 183150.png', 'uploads/pictures/1761628701_Screenshot 2025-03-15 055538.png', 'pending', '2025-10-28 05:18:21');

-- --------------------------------------------------------

--
-- Table structure for table `tricycle_bookings`
--

CREATE TABLE `tricycle_bookings` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `booking_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `driver_id` int(11) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tricycle_bookings`
--

INSERT INTO `tricycle_bookings` (`id`, `name`, `location`, `destination`, `booking_time`, `driver_id`, `status`) VALUES
(1, 'Vincent', 'sabang', 'sm', '2025-10-28 04:59:52', 2, 'completed'),
(2, 'jerick', 'lumbang', 'kanto', '2025-10-28 05:14:38', 2, 'completed'),
(3, 'vincent', 'dagatan', 'sm', '2025-10-28 05:18:59', 4, 'accepted'),
(4, 'vincent', 'sabang', 'sm', '2025-10-28 08:25:30', 2, 'completed'),
(5, 'marion', 'inosluban', 'lumbang', '2025-10-28 08:56:54', 2, 'completed'),
(6, 'marion', 'sabang', 'sm', '2025-10-28 10:02:29', 2, 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_type` enum('passenger','driver') NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','inactive','suspended') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_type`, `name`, `email`, `phone`, `password`, `created_at`, `status`) VALUES
(1, 'passenger', 'John Vincent B. Dipasupil', 'vincent@gmail.com', 'vincent@gmail.com', '$2y$10$9ja4XEiL2.4tJqvuUbSWt.3kcC7tCdcRofT/xaognloot2NGeRKBS', '2025-10-26 09:01:10', 'active'),
(2, 'driver', 'mark', 'mark@gmail.com', '09876543211', '$2y$10$rzCL9cgm5dn3aewQ4NUP1es3sIAu1.uukdVcVk6qpHwGmrzpJXSxu', '2025-10-26 09:02:44', 'active'),
(3, 'passenger', 'jerk', 'jerk@gmail.com', '09382938131', '$2y$10$pcE8dUMT8bBsKnSBDG5srODO6Ca/hq9B3FMsjM8Kt8R5HPIp1w3Ie', '2025-10-27 11:41:34', 'active'),
(4, 'driver', 'jc', 'jc@gmail.com', '09667168601', '$2y$10$0P5grDqCqubqWkcoJAeg0.BELFM2qbJdcV8Plr5BumaZ0bTu.05Ka', '2025-10-28 05:18:21', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`driver_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tricycle_bookings`
--
ALTER TABLE `tricycle_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_driver_id` (`driver_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tricycle_bookings`
--
ALTER TABLE `tricycle_bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `drivers`
--
ALTER TABLE `drivers`
  ADD CONSTRAINT `drivers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
