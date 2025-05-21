-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2025 at 11:37 AM
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
-- Database: `eggseller`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(50) NOT NULL,
  `es_id` int(40) NOT NULL,
  `buyer_user` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `eggstock`
--

CREATE TABLE `eggstock` (
  `es_id` int(50) NOT NULL,
  `es_number` int(40) NOT NULL,
  `es_price` int(255) NOT NULL,
  `es_picture` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eggstock`
--

INSERT INTO `eggstock` (`es_id`, `es_number`, `es_price`, `es_picture`) VALUES
(1, 1, 100, 'images/eggnumber1.jpg'),
(2, 2, 120, 'images/eggnumber2.jpg'),
(3, 3, 140, 'images/eggnumber3.jpg'),
(4, 4, 160, 'images/eggnumber4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `his_id` int(50) NOT NULL,
  `state_id` int(40) NOT NULL,
  `cart_id` int(40) NOT NULL,
  `his_user` varchar(40) NOT NULL,
  `his_price` int(40) NOT NULL,
  `status` enum('checking','checked') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE `members` (
  `m_id` varchar(50) NOT NULL,
  `m_user` varchar(40) NOT NULL,
  `m_pass` varchar(40) NOT NULL,
  `m_tell` varchar(10) NOT NULL,
  `m_status` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`m_id`, `m_user`, `m_pass`, `m_tell`, `m_status`) VALUES
('admin@admin.com', 'admin', 'admin', '0111111111', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `statement`
--

CREATE TABLE `statement` (
  `state_id` int(50) NOT NULL,
  `es_id` int(40) NOT NULL,
  `payment_user` varchar(40) NOT NULL,
  `payment_picture` varchar(40) NOT NULL,
  `status` enum('checking','checked') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `es_id` (`es_id`);

--
-- Indexes for table `eggstock`
--
ALTER TABLE `eggstock`
  ADD PRIMARY KEY (`es_id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`his_id`),
  ADD KEY `state_id` (`state_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `his_user` (`his_user`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `statement`
--
ALTER TABLE `statement`
  ADD PRIMARY KEY (`state_id`),
  ADD KEY `es_id` (`es_id`),
  ADD KEY `payment_user` (`payment_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `eggstock`
--
ALTER TABLE `eggstock`
  MODIFY `es_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `his_id` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statement`
--
ALTER TABLE `statement`
  MODIFY `state_id` int(50) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
