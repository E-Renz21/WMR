  -- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 10:53 AM
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
-- Database: `wmr`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `Booking_ID` int(11) NOT NULL,
  `Client_ID` int(11) DEFAULT NULL,
  `Driver_ID` int(11) DEFAULT NULL,
  `Staff_ID` int(11) DEFAULT NULL,
  `Truck_ID` int(11) DEFAULT NULL,
  `Cargo_ID` int(11) DEFAULT NULL,
  `Transaction_ID` int(11) DEFAULT NULL,
  `Transaction_Location` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cargos`
--

CREATE TABLE `cargos` (
  `Cargo_ID` int(11) NOT NULL,
  `Transaction_ID` int(11) DEFAULT NULL,
  `Cargo_Type` varchar(255) NOT NULL,
  `Cargo_Weight` decimal(10,2) NOT NULL,
  `Transaction_Date` date NOT NULL,
  `Transaction_Location` varchar(255) NOT NULL,
  `Payment` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `cargos`
--
DELIMITER $$
CREATE TRIGGER `Update_Payment_After_Cargo_Insert` AFTER INSERT ON `cargos` FOR EACH ROW BEGIN
    UPDATE TRANSACTIONS
    SET Payment_Amount = Payment_Amount + NEW.Payment
    WHERE Transaction_ID = NEW.Transaction_ID;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `Client_ID` int(11) NOT NULL,
  `Client_Name` varchar(255) DEFAULT NULL,
  `Client_Email` varchar(255) DEFAULT NULL,
  `Client_Phone` varchar(20) NOT NULL,
  `Client_Address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `DeliveryID` int(11) DEFAULT NULL,
  `DriverID` int(11) DEFAULT NULL,
  `TruckID` int(11) DEFAULT NULL,
  `Products` varchar(990) DEFAULT NULL,
  `Weight` decimal(10,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Stand-in structure for view `delivery_completions`
-- (See below for the actual view)
--
CREATE TABLE `delivery_completions` (
`Transaction_ID` int(11)
,`Client_ID` int(11)
,`Cargo_ID` int(11)
,`Driver_ID` int(11)
,`Truck_ID` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `Driver_ID` int(11) NOT NULL,
  `Driver_Name` varchar(255) NOT NULL,
  `Driver_Phone` varchar(20) NOT NULL,
  `Driver_License_Number` varchar(100) NOT NULL,
  `Driver_Vehicle_Assignment` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

CREATE TABLE `staffs` (
  `Staff_ID` int(11) NOT NULL,
  `Staff_Name` varchar(255) NOT NULL,
  `Staff_Phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `Transaction_ID` int(11) NOT NULL,
  `Transaction_Location` varchar(255) NOT NULL,
  `Transaction_Date` date NOT NULL,
  `Payment_Amount` decimal(10,2) NOT NULL,
  `Payment_Status` enum('Pending','Paid','Failed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `transactions`
--
DELIMITER $$
CREATE TRIGGER `Mark_Transaction_Paid` AFTER UPDATE ON `transactions` FOR EACH ROW BEGIN
    IF NEW.Payment_Amount >= (
        SELECT SUM(Payment) FROM CARGOS WHERE Transaction_ID = NEW.Transaction_ID
    ) THEN
        UPDATE TRANSACTIONS
        SET Payment_Status = 'Paid'
        WHERE Transaction_ID = NEW.Transaction_ID;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `Prevent_Transaction_Delete` BEFORE DELETE ON `transactions` FOR EACH ROW BEGIN
    IF EXISTS (
        SELECT 1 FROM BOOKINGS WHERE Transaction_ID = OLD.Transaction_ID
    ) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot delete transaction; it is referenced in BOOKINGS.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `trucks`
--

CREATE TABLE `trucks` (
  `Truck_ID` int(11) NOT NULL,
  `Driver_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Triggers `trucks`
--
DELIMITER $$
CREATE TRIGGER `Prevent_Truck_Assignment_Duplication` BEFORE INSERT ON `trucks` FOR EACH ROW BEGIN
    IF EXISTS (
        SELECT 1 FROM TRUCKS WHERE Driver_ID = NEW.Driver_ID
    ) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Driver is already assigned to another truck.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `truck_dispatches`
-- (See below for the actual view)
--
CREATE TABLE `truck_dispatches` (
`Transaction_ID` int(11)
,`Driver_ID` int(11)
,`Truck_ID` int(11)
,`Cargo_ID` int(11)
,`Transaction_Location` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure for view `delivery_completions`
--
DROP TABLE IF EXISTS `delivery_completions`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `delivery_completions`  AS SELECT `b`.`Transaction_ID` AS `Transaction_ID`, `b`.`Client_ID` AS `Client_ID`, `b`.`Cargo_ID` AS `Cargo_ID`, `b`.`Driver_ID` AS `Driver_ID`, `b`.`Truck_ID` AS `Truck_ID` FROM `bookings` AS `b` ;

-- --------------------------------------------------------

--
-- Structure for view `truck_dispatches`
--
DROP TABLE IF EXISTS `truck_dispatches`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `truck_dispatches`  AS SELECT `t`.`Transaction_ID` AS `Transaction_ID`, `d`.`Driver_ID` AS `Driver_ID`, `tr`.`Truck_ID` AS `Truck_ID`, `c`.`Cargo_ID` AS `Cargo_ID`, `t`.`Transaction_Location` AS `Transaction_Location` FROM ((((`transactions` `t` join `bookings` `b` on(`t`.`Transaction_ID` = `b`.`Transaction_ID`)) join `drivers` `d` on(`b`.`Driver_ID` = `d`.`Driver_ID`)) join `trucks` `tr` on(`b`.`Truck_ID` = `tr`.`Truck_ID`)) join `cargos` `c` on(`b`.`Cargo_ID` = `c`.`Cargo_ID`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`Booking_ID`),
  ADD KEY `Client_ID` (`Client_ID`),
  ADD KEY `Driver_ID` (`Driver_ID`),
  ADD KEY `Staff_ID` (`Staff_ID`),
  ADD KEY `Truck_ID` (`Truck_ID`),
  ADD KEY `Cargo_ID` (`Cargo_ID`),
  ADD KEY `Transaction_ID` (`Transaction_ID`);

--
-- Indexes for table `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`Cargo_ID`),
  ADD KEY `Transaction_ID` (`Transaction_ID`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`Client_ID`),
  ADD UNIQUE KEY `Client_Name` (`Client_Name`),
  ADD UNIQUE KEY `Client_Email` (`Client_Email`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`Driver_ID`),
  ADD UNIQUE KEY `Driver_License_Number` (`Driver_License_Number`);

--
-- Indexes for table `staffs`
--
ALTER TABLE `staffs`
  ADD PRIMARY KEY (`Staff_ID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`Transaction_ID`);

--
-- Indexes for table `trucks`
--
ALTER TABLE `trucks`
  ADD PRIMARY KEY (`Truck_ID`),
  ADD KEY `Driver_ID` (`Driver_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `Booking_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cargos`
--
ALTER TABLE `cargos`
  MODIFY `Cargo_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `Client_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `Driver_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staffs`
--
ALTER TABLE `staffs`
  MODIFY `Staff_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `Transaction_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trucks`
--
ALTER TABLE `trucks`
  MODIFY `Truck_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`Client_ID`) REFERENCES `clients` (`Client_ID`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`Driver_ID`) REFERENCES `drivers` (`Driver_ID`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`Staff_ID`) REFERENCES `staffs` (`Staff_ID`),
  ADD CONSTRAINT `bookings_ibfk_4` FOREIGN KEY (`Truck_ID`) REFERENCES `trucks` (`Truck_ID`),
  ADD CONSTRAINT `bookings_ibfk_5` FOREIGN KEY (`Cargo_ID`) REFERENCES `cargos` (`Cargo_ID`),
  ADD CONSTRAINT `bookings_ibfk_6` FOREIGN KEY (`Transaction_ID`) REFERENCES `transactions` (`Transaction_ID`);

--
-- Constraints for table `cargos`
--
ALTER TABLE `cargos`
  ADD CONSTRAINT `cargos_ibfk_1` FOREIGN KEY (`Transaction_ID`) REFERENCES `transactions` (`Transaction_ID`);

--
-- Constraints for table `trucks`
--
ALTER TABLE `trucks`
  ADD CONSTRAINT `trucks_ibfk_1` FOREIGN KEY (`Driver_ID`) REFERENCES `drivers` (`Driver_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
