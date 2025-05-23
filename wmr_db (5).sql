-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2025 at 08:26 AM
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

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_delivery_request` (IN `p_product_description` TEXT, IN `p_estimated_boxes` INT, IN `p_estimated_weight` DOUBLE, IN `p_pickup_city` VARCHAR(255), IN `p_pickup_address` VARCHAR(255), IN `p_delivery_city` VARCHAR(255), IN `p_delivery_address` VARCHAR(255), IN `p_pickup_date` DATE, IN `p_arrival_date` DATE, IN `p_contact_number` VARCHAR(20), IN `p_client_id` INT)   BEGIN
    INSERT INTO delivery_requests (
        product_description, estimated_boxes, estimated_weight,
        pickup_city, pickup_address,
        delivery_city, delivery_address,
        pickup_date, estimated_arrival_date, contact_number,
        client_id
    )
    VALUES (
        p_product_description, p_estimated_boxes, p_estimated_weight,
        p_pickup_city, p_pickup_address,
        p_delivery_city, p_delivery_address,
        p_pickup_date, p_arrival_date, p_contact_number,
        p_client_id
    );
END$$

DELIMITER ;

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

--
-- Triggers `delivery_status`
--
DELIMITER $$
CREATE TRIGGER `log_status_change` AFTER UPDATE ON `delivery_status` FOR EACH ROW BEGIN
    IF (OLD.status IS NULL AND NEW.status IS NOT NULL)
        OR (OLD.status IS NOT NULL AND NEW.status IS NULL)
        OR (OLD.status <> NEW.status)
        OR (OLD.current_location IS NULL AND NEW.current_location IS NOT NULL)
        OR (OLD.current_location IS NOT NULL AND NEW.current_location IS NULL)
        OR (OLD.current_location <> NEW.current_location)
    THEN
        INSERT INTO delivery_status_log (
            delivery_request_id,
            old_status,
            new_status,
            old_location,
            new_location
        ) VALUES (
            OLD.delivery_request_id,
            OLD.status,
            NEW.status,
            OLD.current_location,
            NEW.current_location
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_status_log`
--

CREATE TABLE `delivery_status_log` (
  `log_id` int(11) NOT NULL,
  `delivery_request_id` bigint(20) UNSIGNED DEFAULT NULL,
  `old_status` varchar(50) DEFAULT NULL,
  `new_status` varchar(50) DEFAULT NULL,
  `old_location` varchar(255) DEFAULT NULL,
  `new_location` varchar(255) DEFAULT NULL,
  `change_time` datetime DEFAULT current_timestamp()
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

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_delivery_requests_with_status`
-- (See below for the actual view)
--
CREATE TABLE `vw_delivery_requests_with_status` (
`id` bigint(20) unsigned
,`client_id` int(10) unsigned
,`product_description` text
,`estimated_boxes` int(11)
,`estimated_weight` decimal(10,2)
,`pickup_city` varchar(100)
,`delivery_city` varchar(100)
,`pickup_address` text
,`delivery_address` text
,`pickup_date` date
,`estimated_arrival_date` date
,`created_at` timestamp
,`contact_number` varchar(50)
,`user_name` varchar(150)
,`driver_name` varchar(255)
,`driver_assistant` varchar(255)
,`plate_number` varchar(50)
,`driver_contact_number` varchar(50)
,`current_location` varchar(255)
,`departure_date` date
,`departure_time` time
,`arrival_date` date
,`arrival_time` time
,`expected_arrival` date
,`admin_notes` text
,`status` enum('Pending','In Transit','Arrived','Rejected')
);

-- --------------------------------------------------------

--
-- Structure for view `vw_delivery_requests_with_status`
--
DROP TABLE IF EXISTS `vw_delivery_requests_with_status`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_delivery_requests_with_status`  AS SELECT `dr`.`id` AS `id`, `dr`.`client_id` AS `client_id`, `dr`.`product_description` AS `product_description`, `dr`.`estimated_boxes` AS `estimated_boxes`, `dr`.`estimated_weight` AS `estimated_weight`, `dr`.`pickup_city` AS `pickup_city`, `dr`.`delivery_city` AS `delivery_city`, `dr`.`pickup_address` AS `pickup_address`, `dr`.`delivery_address` AS `delivery_address`, `dr`.`pickup_date` AS `pickup_date`, `dr`.`estimated_arrival_date` AS `estimated_arrival_date`, `dr`.`created_at` AS `created_at`, `dr`.`contact_number` AS `contact_number`, `u`.`full_name` AS `user_name`, `ds`.`driver_name` AS `driver_name`, `ds`.`driver_assistant` AS `driver_assistant`, `ds`.`plate_number` AS `plate_number`, `ds`.`driver_contact_number` AS `driver_contact_number`, `ds`.`current_location` AS `current_location`, `ds`.`departure_date` AS `departure_date`, `ds`.`departure_time` AS `departure_time`, `ds`.`arrival_date` AS `arrival_date`, `ds`.`arrival_time` AS `arrival_time`, `ds`.`expected_arrival` AS `expected_arrival`, `ds`.`admin_note` AS `admin_notes`, `ds`.`status` AS `status` FROM ((`delivery_requests` `dr` left join `users` `u` on(`dr`.`created_by` = `u`.`id`)) left join `delivery_status` `ds` on(`dr`.`id` = `ds`.`delivery_request_id`)) ;

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
-- Indexes for table `delivery_status_log`
--
ALTER TABLE `delivery_status_log`
  ADD PRIMARY KEY (`log_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `delivery_requests`
--
ALTER TABLE `delivery_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `delivery_status`
--
ALTER TABLE `delivery_status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `delivery_status_log`
--
ALTER TABLE `delivery_status_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
