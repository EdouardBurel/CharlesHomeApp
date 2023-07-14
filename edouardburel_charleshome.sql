-- phpMyAdmin SQL Dump
-- version 5.1.4
-- https://www.phpmyadmin.net/
--
-- Host: mysql-edouardburel.alwaysdata.net
-- Generation Time: Jul 13, 2023 at 02:01 PM
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

-- --------------------------------------------------------

--
-- Table structure for table `CleaningService`
--

CREATE TABLE `CleaningService` (
  `CleaningID` int(11) NOT NULL,
  `Frequency` varchar(255) DEFAULT NULL,
  `TenantID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `firstName` varchar(255) DEFAULT NULL,
  `lastName` varchar(255) DEFAULT NULL,
  `Month` varchar(50) DEFAULT NULL,
  `Year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `name`, `firstName`, `lastName`, `Month`, `Year`) VALUES
(12, 'Facture 202301-015 (jan-fev 2023) - Vleurgat 1 - UMEDIA Funny bird.pdf', 'John', 'Doe', NULL, NULL),
(14, 'Loyer (Fev 2023) - Studio Amazone 1  Charles Home.pdf', 'John', 'Doe', NULL, NULL),
(15, 'Loyer (jan-fev 2023) Montagne 3 - M. Andronov.pdf', 'Mary', 'Jeanne', 'July', 2023);

-- --------------------------------------------------------

--
-- Table structure for table `MonthlyInvoice`
--

CREATE TABLE `MonthlyInvoice` (
  `InvoiceID` int(11) NOT NULL,
  `TenantID` int(11) DEFAULT NULL,
  `InvoiceNumber` varchar(255) DEFAULT NULL,
  `Month` int(11) DEFAULT NULL,
  `Year` int(11) DEFAULT NULL,
  `FileInvoice` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `MonthlyInvoice`
--

INSERT INTO `MonthlyInvoice` (`InvoiceID`, `TenantID`, `InvoiceNumber`, `Month`, `Year`, `FileInvoice`) VALUES
(2, 8, '4', 1, 2023, 'Loyer (Mars 2023) Paul Lauters 1 - Charles Home.pdf'),
(3, 6, '5', 10, 2023, 'Loyer (Fev 2023) - Studio Amazone 1  Charles Home.pdf'),
(5, 12, '202307-100', 7, 2023, 'Rental Invoice (Jan-Feb 2023)  RES-220022917.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `RentalLease`
--

CREATE TABLE `RentalLease` (
  `LeaseID` int(11) NOT NULL,
  `TenantID` int(11) DEFAULT NULL,
  `LeaseName` varchar(255) DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `Rent` int(11) DEFAULT NULL,
  `Deposit` int(11) DEFAULT NULL,
  `ApartmentID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `RentalLease`
--

INSERT INTO `RentalLease` (`LeaseID`, `TenantID`, `LeaseName`, `StartDate`, `EndDate`, `Rent`, `Deposit`, `ApartmentID`) VALUES
(5, 7, NULL, '2023-02-16', '2023-12-15', 3898, 1545, 1),
(6, 8, NULL, '2023-07-06', '2024-06-05', 1650, 1650, 8),
(7, 9, NULL, '2023-07-14', '2024-01-14', 4440, 0, 2),
(8, 10, NULL, '2023-07-05', '2023-08-21', 4800, 900, 10),
(9, 11, NULL, '2023-08-01', '2023-11-01', 2052, 0, 16),
(10, 12, NULL, '2023-07-15', '2023-10-15', 2000, 1000, 15),
(11, 13, NULL, '2023-02-24', '2023-07-15', 1850, 1850, 7),
(12, 14, NULL, '2022-08-28', '2023-07-15', 1500, 1500, 18),
(13, 15, NULL, '2022-07-25', '2023-07-16', 1650, 1650, 21),
(14, 16, NULL, '2023-07-19', '2024-01-10', 1800, 1800, 21),
(15, 17, NULL, '2023-01-01', '2023-07-21', 1650, 1635, 16),
(16, 18, NULL, '2023-08-01', '2023-12-01', 3800, 2500, 23),
(17, 19, NULL, '2023-03-14', '2023-07-26', 1600, 0, 25),
(18, 20, NULL, '2023-08-07', '2023-12-12', 3180, 0, 22);

-- --------------------------------------------------------

--
-- Table structure for table `Tenant`
--

CREATE TABLE `Tenant` (
  `TenantID` int(11) NOT NULL,
  `FirstName` varchar(255) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `ApartmentID` int(11) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Role` varchar(255) DEFAULT 'user',
  `Number` varchar(144) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Tenant`
--

INSERT INTO `Tenant` (`TenantID`, `FirstName`, `LastName`, `ApartmentID`, `Email`, `Password`, `Role`, `Number`) VALUES
(1, 'John', 'Doe', 2, 'john@doe.com', 'John1', 'user', NULL),
(2, 'Mary', 'Jeanne', 9, 'm@j.com', 'Mj1', 'user', NULL),
(3, NULL, 'Admin', NULL, 'admin@admin.com', 'Admin1', 'admin', NULL),
(6, 'Alexandra', 'Serban', 11, 'alex@serban.com', 'Serban1', 'user', ''),
(7, 'Aron', 'Fellegi', 1, 'A.Fellegi', '1234', 'user', '+36305995959'),
(8, 'Christina', 'Tepper', 8, 'C.Tepper-P4', '1234', 'user', '+49 1577 1988211 '),
(9, 'Neha', 'Zamvar', 2, 'N.Zamvar-M2', '140723', 'user', ''),
(10, 'Nathalie', 'Smitz', 10, 'N.Smitz-PL2', '050723', 'user', '+243 81 605 00 65'),
(11, 'Mariam', 'Dahleh', 16, 'M.Daleh-VL3', '010823', 'user', '+20 101 802 3444'),
(12, 'Linda', 'Pierce', 15, 'L.Pierce-VL2', '150723', 'user', '+61 409 098 129'),
(13, 'Olga', 'Minguillan', 7, 'O.Minguillan-P3', '240223', 'user', '+34 669 24 88 75'),
(14, 'Eric', 'Grabli', 18, 'E.Grabli-AM1', '280822', 'user', '+32 4 71 20 09 41'),
(15, 'Elisabet', 'Thorhallsdottir', 21, 'E.Thorhallsdottir-AM4', '250722', 'user', '0491 16 01 07'),
(16, 'Alice', 'Semino', 21, 'A.Semino-AM4', '190723', 'user', '+41795001998'),
(17, 'Laury', 'Haytayan', 16, 'L.Haytayan-VL3', '010123', 'user', '0491 59 49 27'),
(18, 'Tyssia', 'Toku', 23, 'T.Toku-AQ1', '010823', 'user', '0489273809'),
(19, 'Ingvild', 'Henni', 25, 'I.Henni-AQ3', '140323', 'user', ''),
(20, 'Vincente', 'Torres Bustos', 22, 'V.Bustos-AM5', '070823', 'user', '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `firstName` varchar(225) NOT NULL,
  `lastName` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `role` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `email`, `password`, `role`) VALUES
(1, 'John', 'Doe', 'john@doe.com', 'doe1', 'user'),
(2, 'Mary', 'Jeanne', 'm@j.com', 'mj1', 'user'),
(3, 'admin', 'admin', 'admin@admin.com', 'Admin1', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Apartment`
--
ALTER TABLE `Apartment`
  ADD PRIMARY KEY (`ApartmentID`);

--
-- Indexes for table `CleaningService`
--
ALTER TABLE `CleaningService`
  ADD PRIMARY KEY (`CleaningID`),
  ADD KEY `TenantID` (`TenantID`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `MonthlyInvoice`
--
ALTER TABLE `MonthlyInvoice`
  ADD PRIMARY KEY (`InvoiceID`),
  ADD KEY `TenantID` (`TenantID`);

--
-- Indexes for table `RentalLease`
--
ALTER TABLE `RentalLease`
  ADD PRIMARY KEY (`LeaseID`),
  ADD KEY `RentalLease_ibfk_1` (`TenantID`),
  ADD KEY `ApartmentID` (`ApartmentID`);

--
-- Indexes for table `Tenant`
--
ALTER TABLE `Tenant`
  ADD PRIMARY KEY (`TenantID`),
  ADD KEY `ApartmentID` (`ApartmentID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Apartment`
--
ALTER TABLE `Apartment`
  MODIFY `ApartmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `CleaningService`
--
ALTER TABLE `CleaningService`
  MODIFY `CleaningID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `MonthlyInvoice`
--
ALTER TABLE `MonthlyInvoice`
  MODIFY `InvoiceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `RentalLease`
--
ALTER TABLE `RentalLease`
  MODIFY `LeaseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `Tenant`
--
ALTER TABLE `Tenant`
  MODIFY `TenantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `CleaningService`
--
ALTER TABLE `CleaningService`
  ADD CONSTRAINT `CleaningService_ibfk_1` FOREIGN KEY (`TenantID`) REFERENCES `Tenant` (`TenantID`);

--
-- Constraints for table `MonthlyInvoice`
--
ALTER TABLE `MonthlyInvoice`
  ADD CONSTRAINT `MonthlyInvoice_ibfk_1` FOREIGN KEY (`TenantID`) REFERENCES `Tenant` (`TenantID`);

--
-- Constraints for table `RentalLease`
--
ALTER TABLE `RentalLease`
  ADD CONSTRAINT `RentalLease_ibfk_1` FOREIGN KEY (`TenantID`) REFERENCES `Tenant` (`TenantID`) ON DELETE CASCADE,
  ADD CONSTRAINT `RentalLease_ibfk_2` FOREIGN KEY (`ApartmentID`) REFERENCES `Apartment` (`ApartmentID`);

--
-- Constraints for table `Tenant`
--
ALTER TABLE `Tenant`
  ADD CONSTRAINT `Tenant_ibfk_1` FOREIGN KEY (`ApartmentID`) REFERENCES `Apartment` (`ApartmentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


CREATE TABLE MonthlyInvoice (
    InvoiceID INT PRIMARY KEY AUTO_INCREMENT,
    TenantID INT,
    InvoiceNumber VARCHAR(255),
    Month INT,
    Year INT,
    FOREIGN KEY (TenantID) REFERENCES Tenant(TenantID)
);

ALTER TABLE RentalLease
DROP FOREIGN KEY RentalLease_ibfk_1;

ALTER TABLE RentalLease
ADD CONSTRAINT RentalLease_ibfk_1
FOREIGN KEY (TenantID)
REFERENCES Tenant(TenantID)
ON DELETE CASCADE;

ALTER TABLE Tenant
ALTER COLUMN Role SET DEFAULT 'user';

CREATE TABLE IF NOT EXISTS Invoices (
    InvoiceID INT PRIMARY KEY AUTO_INCREMENT,
    TenantID INT,
    InvoiceNumber INT,
    InvoiceMonth VARCHAR(255),
    InvoiceYear INT,
    FOREIGN KEY (TenantID) REFERENCES Tenant(TenantID)
);




CREATE TABLE IF NOT EXISTS Apartment (
    ApartmentID INT PRIMARY KEY AUTO_INCREMENT,
    ApartmentName VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS Tenant (
    TenantID INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(255),
    LastName VARCHAR(255),
    ApartmentID INT,
    Email VARCHAR(255),
    Password VARCHAR(255),
    Role VARCHAR(255),
    FOREIGN KEY (ApartmentID) REFERENCES Apartment(ApartmentID)
);

CREATE TABLE IF NOT EXISTS RentalLease (
    LeaseID INT PRIMARY KEY AUTO_INCREMENT,
    TenantID INT,
    LeaseName VARCHAR(255),
    StartDate DATE,
    EndDate DATE,
    Rent INT,
    Deposit INT,
    FOREIGN KEY (TenantID) REFERENCES Tenant(TenantID) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS CurrentTenant (
    CurrentTenantID INT PRIMARY KEY AUTO_INCREMENT,
    TenantID INT,
    ApartmentID INT,
    Rent INT,
    Deposit INT,
    CleaningID INT,
    FOREIGN KEY (TenantID) REFERENCES Tenant(TenantID),
    FOREIGN KEY (ApartmentID) REFERENCES Apartment(ApartmentID),
    FOREIGN KEY (Rent) REFERENCES RentalLease(LeaseID),
    FOREIGN KEY (Deposit) REFERENCES RentalLease(LeaseID),
    FOREIGN KEY (CleaningID) REFERENCES CleaningService(CleaningID)
);

CREATE TABLE IF NOT EXISTS CleaningService (
    CleaningID INT PRIMARY KEY AUTO_INCREMENT,
    Frequency VARCHAR(255)
);