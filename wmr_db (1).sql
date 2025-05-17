-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2025 at 02:22 AM
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
-- Database: `wmr_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `first_name`, `last_name`, `phone_number`, `email`, `message`, `submitted_at`) VALUES
(1, '', '', '', '', '', '2025-05-16 19:04:43'),
(2, '', '', '', '', '', '2025-05-16 19:05:02'),
(3, 'sdf', 'fds', 'fds', 'sdf@sfd', 'afds', '2025-05-16 19:07:32'),
(4, 'sdf', 'fds', 'fds', 'sdf@sfd', 'afdssdf', '2025-05-16 19:08:38');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_requests`
--

CREATE TABLE `delivery_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_description` text DEFAULT NULL,
  `estimated_boxes` int(11) DEFAULT NULL,
  `estimated_weight` decimal(10,2) DEFAULT NULL,
  `pickup_city` varchar(100) DEFAULT NULL,
  `pickup_address` text DEFAULT NULL,
  `delivery_city` varchar(100) DEFAULT NULL,
  `delivery_address` text DEFAULT NULL,
  `pickup_date` date DEFAULT NULL,
  `estimated_arrival_date` date DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('Pending','In Transit','Arrived','Rejected') NOT NULL DEFAULT 'Pending',
  `driver_name` varchar(255) DEFAULT NULL,
  `driver_assistant` varchar(255) DEFAULT NULL,
  `plate_number` varchar(50) DEFAULT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `departure_date` date DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `current_location` varchar(255) DEFAULT NULL,
  `departure_address` text DEFAULT NULL,
  `arrival_address` text DEFAULT NULL,
  `expected_arrival` date DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_requests`
--

INSERT INTO `delivery_requests` (`id`, `product_description`, `estimated_boxes`, `estimated_weight`, `pickup_city`, `pickup_address`, `delivery_city`, `delivery_address`, `pickup_date`, `estimated_arrival_date`, `client_id`, `created_at`, `status`, `driver_name`, `driver_assistant`, `plate_number`, `contact_number`, `departure_date`, `departure_time`, `current_location`, `departure_address`, `arrival_address`, `expected_arrival`, `updated_at`) VALUES
(18, '', 12, 12.00, '12', 'jkb', '21', '12', '2025-05-18', '2025-06-05', 14, '2025-05-16 22:04:39', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, '', 34, 43.00, 'fds', 'sdf', 'df', 'df', '2025-05-06', '2025-05-23', 17, '2025-05-16 22:47:25', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'sdf', 34, 43.00, 'sdf', 'dsf', 'fds', 'fds', '2025-05-01', '2025-05-16', 14, '2025-05-16 22:54:14', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'sdf, sfdfsdfds, ffdsfdsf, fsdfsd, fdsfdsf, fsdfds, sdfdsf, fsdfds, sfsdfs, fsdsfd', 43, 43.00, 'fsd', 'sdf', 'sfd', 'fsd', '2025-05-02', '2025-05-21', 14, '2025-05-16 23:06:44', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `username` varchar(100) DEFAULT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `residence` text DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `business_name` varchar(150) DEFAULT NULL,
  `type_of_business` varchar(150) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `password`, `created_at`, `username`, `full_name`, `nickname`, `residence`, `birthday`, `email`, `phone_number`, `business_name`, `type_of_business`, `profile_picture`) VALUES
(3, '$2y$10$7tsgBzkNK5gUTNuw7LOyeuBd8P5tWUKRzo9ClxkeFj1aQEa59b3rK', '2025-05-16 17:16:11', 'jomm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(14, '$2y$10$ueY/PrhXpjPI2oLuy/TE5..YQ9.j3yWzwWG11QJxlu..HE4t615vq', '2025-05-16 17:30:31', 'jomm31', 'Joemire Dave Loremas', 'Jomm', 'japanacan', '2004-03-17', 'wapo@gmail.com', '0912345678', 'sheshable inc.', NULL, 'profile_14_b9b1eba78eb05a138b364dd306370bea.png'),
(15, '$2y$10$jy/wgHaLBRnTMzODpG8dPeXCOEQOd/.wGmnf6LCWiZg8AoaUxpMZG', '2025-05-16 17:31:16', 'jomm2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(16, '$2y$10$Fr670bjvKCYCWlDd5kB.GO8DBbilbkv1EDcmdLw.R5dXR42.596dC', '2025-05-16 20:17:33', 'jomm17', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '$2y$10$M9K/zL8LVbfxlu77Df6BH.JVk.oR62mXmmeUlet3NiMBbnvv0JvqK', '2025-05-16 22:47:09', 'jomm177', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_requests`
--
ALTER TABLE `delivery_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `delivery_requests`
--
ALTER TABLE `delivery_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
