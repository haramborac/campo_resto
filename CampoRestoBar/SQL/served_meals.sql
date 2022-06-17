-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2022 at 08:13 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `campo`
--

-- --------------------------------------------------------

--
-- Table structure for table `served_meals`
--

CREATE TABLE `served_meals` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `serving` int(11) NOT NULL,
  `base_cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `served_meals`
--

INSERT INTO `served_meals` (`id`, `name`, `serving`, `base_cost`) VALUES
(1, 'asd', 23, 23423),
(2, 'dinuguan', 10, 200),
(3, 'asd', 23, 23423),
(4, 'dinuguan', 10, 200),
(5, 'asd', 23, 23423),
(6, 'dinuguan', 10, 200),
(7, 'asd', 23, 23423),
(8, 'dinuguan', 10, 200),
(9, 'asd', 23, 23423),
(10, 'dinuguan', 10, 200),
(11, 'asd', 23, 23423),
(12, 'dinuguan', 10, 200),
(13, 'asd', 23, 23423),
(14, 'dinuguan', 10, 200),
(15, 'asd', 23, 23423),
(16, 'dinuguan', 10, 200),
(17, 'asd', 23, 23423),
(18, 'dinuguan', 10, 200),
(19, 'asd', 23, 23423),
(20, 'dinuguan', 10, 200),
(21, 'asd', 23, 23423),
(22, 'dinuguan', 10, 200),
(23, 'tite', 1, 150),
(24, 'asd', 1, 333);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `served_meals`
--
ALTER TABLE `served_meals`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `served_meals`
--
ALTER TABLE `served_meals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
