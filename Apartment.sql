-- phpMyAdmin SQL Dump
-- version 5.1.4
-- https://www.phpmyadmin.net/
--
-- Host: mysql-edouardburel.alwaysdata.net
-- Generation Time: Jul 13, 2023 at 02:08 PM
-- Server version: 10.6.11-MariaDB
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `edouardburel_charleshome`
--

-- --------------------------------------------------------

--
-- Table structure for table `Apartment`
--

CREATE TABLE `Apartment` (
  `ApartmentID` int(11) NOT NULL,
  `ApartmentName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Apartment`
--

INSERT INTO `Apartment` (`ApartmentID`, `ApartmentName`) VALUES
(1, 'Montagne 1'),
(2, 'Montagne 2'),
(3, 'Montagne 3'),
(4, 'Montagne 4'),
(5, 'Palmerston 1'),
(6, 'Palmerston 2'),
(7, 'Palmerston 3'),
(8, 'Palmerston 4'),
(9, 'Paul Lauters 1'),
(10, 'Paul Lauters 2'),
(11, 'Paul Lauters 3'),
(12, 'Paul Lauters 4'),
(13, 'Paul Lauters 5'),
(14, 'Vleurgat 1'),
(15, 'Vleurgat 2'),
(16, 'Vleurgat 3'),
(17, 'Vleurgat 4'),
(18, 'Amazone 1'),
(19, 'Amazone 2'),
(20, 'Amazone 3'),
(21, 'Amazone 4'),
(22, 'Amazone 5'),
(23, 'Aqueduc 1'),
(24, 'Aqueduc 2'),
(25, 'Aqueduc 3'),
(26, 'Aqueduc 4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Apartment`
--
ALTER TABLE `Apartment`
  ADD PRIMARY KEY (`ApartmentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Apartment`
--
ALTER TABLE `Apartment`
  MODIFY `ApartmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
