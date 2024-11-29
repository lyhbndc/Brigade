-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 05:17 PM
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
-- Database: `brigade`
--

-- --------------------------------------------------------

--
-- Table structure for table `cancel_order`
--

CREATE TABLE `cancel_order` (
  `OrderID` varchar(40) NOT NULL,
  `Customer` varchar(100) NOT NULL,
  `Product` varchar(100) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cancel_order`
--

INSERT INTO `cancel_order` (`OrderID`, `Customer`, `Product`, `Quantity`, `Status`, `Total`, `Date`) VALUES
('1778', 'asdfsadfa sdfafdadsf', 'Brigade Clothing - Let\'s Get High (Black', 1, 'Order Cancelled', 520.00, '2024-11-12'),
('2257', 'asdfsadfa sdfafdadsf', 'Brigade Clothing - Let\'s Get High (Black', 1, 'Order Cancelled', 520.00, '2024-11-14'),
('6701', 'asdfsadfa sdfafdadsf', 'Brigade Clothing - Let\'s Get High (Black', 1, 'Order Cancelled', 520.00, '2024-11-14'),
('8586', 'adsasdas dasdasd', 'Brigade Clothing - Let\'s Get High (Black', 1, 'Cancelled', 520.00, '2024-11-09');

-- --------------------------------------------------------

--
-- Table structure for table `complete_order`
--

CREATE TABLE `complete_order` (
  `OrderID` varchar(40) NOT NULL,
  `Customer` varchar(100) NOT NULL,
  `Product` varchar(100) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `complete_order`
--

INSERT INTO `complete_order` (`OrderID`, `Customer`, `Product`, `Quantity`, `Status`, `Total`, `Date`) VALUES
('0331', 'adsasdas dasdasd', 'Brigade Clothing - Chase Dream (Blue)', 1, 'Order Completed', 520.00, '2024-11-12'),
('1820', 'asdfsadfa sdfafdadsf', 'Brigade Clothing - Let\'s Get High (Black', 1, 'Order Completed', 520.00, '2024-11-14'),
('2257', 'asdfsadfa sdfafdadsf', 'Brigade Clothing - Let\'s Get High (Black', 1, 'Order Completed', 520.00, '2024-11-14'),
('3352', 'asdfsadfa sdfafdadsf', 'Brigade Clothing - Let\'s Get High (Black', 1, 'Order Completed', 520.00, '2024-11-14'),
('4173', 'adsasdas dasdasd', 'Brigade Clothing - Chase Dream (Blue)', 1, 'Order Completed', 520.00, '2024-11-08'),
('5019', 'asdfsadfa sdfafdadsf', 'Brigade Clothing - Chase Dream (Blue)', 3, 'Order Completed', 1560.00, '2024-11-13'),
('5121', 'adsasdas dasdasd', 'Brigade Clothing - Chase Dream (White)', 1, 'Order Completed', 520.00, '2024-11-11'),
('5940', 'adsasdas dasdasd', 'Brigade Clothing - Coldest (Blue)', 1, 'Order Completed', 520.00, '2024-11-10'),
('6701', 'asdfsadfa sdfafdadsf', 'Brigade Clothing - Let\'s Get High (Black', 1, 'Order Completed', 520.00, '2024-11-14'),
('7682', 'asdfsadfa sdfafdadsf', 'Brigade Clothing - Let\'s Get High (Black', 1, 'Order Completed', 520.00, '2024-11-13'),
('8092', 'asdfsadfa sdfafdadsf', 'Brigade Clothing - Chase Dream (Blue)', 1, 'Order Completed', 520.00, '2024-11-13');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `ID` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(30) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`ID`, `username`, `first_name`, `last_name`, `email`, `password`, `role`) VALUES
(2, 'rajhi.sangcopan', 'Rajhi', 'Sangcopan', 'rajhi.sangcopan@brigade.com', 'password123', 'admin'),
(4, 'johnlexer.calleja', 'John Lexer', 'Calleja', 'johnlexer.calleja@brigade.com', 'Password123@', 'user'),
(5, 'aaliyah.bondoc', 'Aaliyah', 'Bondoc', 'aaliyah.bondoc@brigade.com', 'Password123?', 'user'),
(6, 'adrienneberlin.delacruz', 'Adrienne Berlin', 'Dela Cruz', 'adrienneberlin.delacruz@brigade.com', 'Password1', 'admin'),
(7, 'aizheelyn.limit', 'Aizheelyn', 'Limit', 'aizheelyn.limit@brigade.com', 'Password123?', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `OrderID` varchar(40) NOT NULL,
  `Customer` varchar(40) NOT NULL,
  `Product` varchar(40) NOT NULL,
  `Quantity` varchar(40) NOT NULL,
  `Size` varchar(40) NOT NULL,
  `Status` varchar(40) NOT NULL,
  `Total` int(40) NOT NULL,
  `Date` date NOT NULL,
  `Address` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`OrderID`, `Customer`, `Product`, `Quantity`, `Size`, `Status`, `Total`, `Date`, `Address`) VALUES
('8074', 'asdfsadfa sdfafdadsf', 'Brigade Clothing - Let\'s Get High (Black', '1', 'M', 'Out for Delivery', 520, '2024-11-15', 'sdfasdfa'),
('9943', 'Berlin Dela Cruz', 'Brigade Clothing - Let\'s Get High (Black', '1', 'M', 'On Process', 520, '2024-11-21', 'SAHFSAHGJDFSA'),
('9973', 'Berlin Dela Cruz', 'Brigade Clothing - Let\'s Get High (Black', '1', 'S', 'On Process', 520, '2024-11-21', 'SAHFSAHGJDFSA'),
('0904', 'Berlin Dela Cruz', 'Brigade Clothing - Let\'s Get High (Black', '1', 'S', 'On Process', 520, '2024-11-21', 'SAHFSAHGJDFSA'),
('8452', 'Rajhi Sangcopan', 'Brigade Clothing - Let\'s Get High (Black', '1', 'XL', 'On Process', 520, '2024-11-29', '53 MINDANAO AVENUA, MAHARLIKA VILLAGE'),
('9024', 'Rajhi Sangcopan', 'Brigade Clothing - Let\'s Get High (Black', '1', 'XL', 'On Process', 520, '2024-11-29', '53 MINDANAO AVENUA, MAHARLIKA VILLAGE'),
('3765', 'Rajhi Sangcopan', 'Brigade Clothing - Let\'s Get High (Red)', '1', 'M', 'On Process', 520, '2024-11-29', '53 MINDANAO AVENUA, MAHARLIKA VILLAGE');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(7) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `small_stock` int(40) NOT NULL,
  `medium_stock` int(40) NOT NULL,
  `large_stock` int(40) NOT NULL,
  `xl_stock` int(40) NOT NULL,
  `xxl_stock` int(40) NOT NULL,
  `xxxl_stock` int(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `quantity`, `image`, `price`, `small_stock`, `medium_stock`, `large_stock`, `xl_stock`, `xxl_stock`, `xxxl_stock`) VALUES
(1002, 'Brigade Clothing - Let\'s Get High (Red)', 101, 't2.png', 520.00, 12, 33, 0, 0, 12, 43),
(1003, 'Brigade Clothing - Let\'s Get High (Black)', 98, 't3.png', 520.00, 12, 54, 0, 0, 0, 32),
(1004, 'Brigade Clothing - Let\'s Get High (Grey)', 143, 't1.png', 520.00, 12, 4, 32, 0, 63, 32),
(1005, 'Brigade Clothing - Let\'s Get High (Blue)', 36, NULL, 520.00, 12, 0, 12, 12, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `refund_order`
--

CREATE TABLE `refund_order` (
  `OrderID` varchar(40) NOT NULL,
  `Customer` varchar(100) NOT NULL,
  `Product` varchar(100) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Status` varchar(50) NOT NULL,
  `Total` decimal(10,2) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `refund_order`
--

INSERT INTO `refund_order` (`OrderID`, `Customer`, `Product`, `Quantity`, `Status`, `Total`, `Date`) VALUES
('3352', 'asdfsadfa sdfafdadsf', 'Brigade Clothing - Let\'s Get High (Black', 1, 'Order Refunded', 520.00, '2024-11-14'),
('4173', 'adsasdas dasdasd', 'BBrigade Clothing - Lucky (Black)', 1, 'Order Refunded', 520.00, '2024-11-08');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(40) NOT NULL,
  `FirstName` varchar(40) NOT NULL,
  `LastName` varchar(40) NOT NULL,
  `Address` varchar(40) NOT NULL,
  `City` varchar(40) NOT NULL,
  `Zip` varchar(40) NOT NULL,
  `Contact` varchar(40) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Username` varchar(40) NOT NULL,
  `Password` varchar(40) NOT NULL,
  `verification_code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `FirstName`, `LastName`, `Address`, `City`, `Zip`, `Contact`, `Email`, `Username`, `Password`, `verification_code`) VALUES
(1, 'asda', 'asd', 'asdasd', 'asdsada', 'sdasd', 'asdasd', 'asdasd@gmail.com', 'asda', 'asdasd', ''),
(2, 'dasdasd', 'dasdasd', 'asdasd', 'asdas', 'dasd', 'asdasd', 'dddd@gmail.com', 're', 'asd', ''),
(3, 'asdfsadfa', 'sdfafdadsf', 'sdfasdfa', 'ddsdf', 'asdasd', 'asdasdad', 'asfsdf@gmail.com', 'cuteko213', 'angcuteko213', ''),
(4, 'afasdasd', 'asdas', 'dasdas', 'dasda', 'dasda', 'sdasda', 'dasdasda@gmail.com', 'fsajhgfasjdf', 'gfsajdgfasdf', ''),
(5, 'asda', 'sdasd', 'asdasd', 'asda', 'sdasda', 'sdasda', 'angcuteko213@gmail.com', 'angcuteko213', 'angcuteko213', ''),
(6, 'Berlin', 'Dela Cruz', 'SAHFSAHGJDFSA', 'Makati', 'dsfasdf', '09123123', 'adelacruz.k12043430@umak.edu.ph', 'berlin', 'berlin', '395444'),
(7, 'Rajhi', 'Sangcopan', '53 MINDANAO AVENUA, MAHARLIKA VILLAGE', 'New York', '1630', '09823489092', 'rajhi.sangcopan@gmail.com', 'rajhi', 'Password1?', '269488');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cancel_order`
--
ALTER TABLE `cancel_order`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `complete_order`
--
ALTER TABLE `complete_order`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refund_order`
--
ALTER TABLE `refund_order`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1006;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
