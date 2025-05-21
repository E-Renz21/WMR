-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 06:42 PM
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
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `first_name`, `last_name`, `phone_number`, `email`, `message`, `submitted_at`, `updated_at`) VALUES
(1, 'adsf', 'asdf', '343', 'asdf@sdaf', 'asdf', '2025-05-21 15:01:08', '2025-05-21 23:01:08');

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
  `client_id` int(10) UNSIGNED DEFAULT NULL,
  `contact_number` varchar(50) DEFAULT NULL,
  `departure_address` text DEFAULT NULL,
  `arrival_address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_requests`
--

INSERT INTO `delivery_requests` (`id`, `product_description`, `estimated_boxes`, `estimated_weight`, `pickup_city`, `pickup_address`, `delivery_city`, `delivery_address`, `pickup_date`, `estimated_arrival_date`, `client_id`, `contact_number`, `departure_address`, `arrival_address`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'a', 3, 3.00, '123abc', '123abc', 'abv', 'abc', '2025-05-22', '2025-05-30', 2, '123', NULL, NULL, '2025-05-21 15:06:28', '2025-05-21 23:06:28', NULL, NULL),
(2, 's, s, a', 2, 1.00, 'sdf', 'sdf', 'fd', 'fd', '2025-05-22', '2025-05-31', 2, '4334', NULL, NULL, '2025-05-21 15:39:48', '2025-05-21 23:39:48', NULL, NULL),
(3, '1, 2, 3', 1, 1.00, 'sdf', 'sdf', 'fd', 'fd', '2025-05-13', '2025-06-07', 2, '4334', NULL, NULL, '2025-05-21 15:48:06', '2025-05-21 23:48:06', NULL, NULL),
(4, 'ad', 12, 123.00, 'sdf', 'sdf', 'dfs', 'dfs', '2025-05-31', '2025-05-30', 2, '4334', NULL, NULL, '2025-05-21 15:50:04', '2025-05-21 23:50:04', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `delivery_status`
--

CREATE TABLE `delivery_status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `delivery_request_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('Pending','In Transit','Arrived','Rejected') NOT NULL DEFAULT 'Pending',
  `driver_name` varchar(255) DEFAULT NULL,
  `driver_assistant` varchar(255) DEFAULT NULL,
  `driver_contact_number` varchar(50) DEFAULT NULL,
  `assistant_contact_number` varchar(50) DEFAULT NULL,
  `plate_number` varchar(50) DEFAULT NULL,
  `departure_date` date DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `current_location` varchar(255) DEFAULT NULL,
  `expected_arrival` date DEFAULT NULL,
  `admin_note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `arrival_date` date DEFAULT NULL,
  `arrival_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `residence` text DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `business_name` varchar(150) DEFAULT NULL,
  `type_of_business` varchar(150) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `nickname`, `residence`, `birthday`, `email`, `phone_number`, `business_name`, `type_of_business`, `profile_picture`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$t7ZPMD06wuAxsfxLIoU.P.X95LyOHjr.V8nZ9TwGQkY3HoYkmad/S', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-21 04:09:20', '2025-05-21 12:09:20'),
(2, 'jomm31', '$2y$10$Ze2QtA4jrvrA8JSLU2eCFOdpU/WPnV4KurLzLLHm0a2UH31xdVAGG', 'jomm', '3months ago', 'bago', '2008-04-29', 'jommwapo@gmail.com', '091234567', 'abx', NULL, '682dea3e2b4f2_494358699_735413878813436_2992733080820663742_n.png', '2025-05-21 14:54:50', '2025-05-21 22:59:10');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `delivery_status`
--
ALTER TABLE `delivery_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_request_id` (`delivery_request_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `delivery_requests`
--
ALTER TABLE `delivery_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `delivery_status`
--
ALTER TABLE `delivery_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `delivery_requests`
--
ALTER TABLE `delivery_requests`
  ADD CONSTRAINT `delivery_requests_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `delivery_requests_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `delivery_requests_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `delivery_status`
--
ALTER TABLE `delivery_status`
  ADD CONSTRAINT `delivery_status_ibfk_1` FOREIGN KEY (`delivery_request_id`) REFERENCES `delivery_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `delivery_status_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `delivery_status_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
