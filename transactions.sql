-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2025 at 01:38 PM
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
-- Database: `libarry`
--

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `book_id` varchar(20) NOT NULL,
  `date_borrowed` date NOT NULL,
  `return_date` date NOT NULL,
  `course` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `email`, `name`, `address`, `contact_number`, `student_id`, `book_id`, `date_borrowed`, `return_date`, `course`, `author`) VALUES
(90, 'johnluizaustria@gmail.com', 'John Luiz S Austria', '670 Notanggi St. Darangan Binangonan, Rizal', '09362447121', 'M2022-0234', 'Emily White: The Sil', '2025-03-28', '2025-03-30', 'BSCS', 'Emily White'),
(91, 'johnluizaustria@gmail.com', 'John Luiz S Austria', '670 Notanggi St. Darangan Binangonan, Rizal', '09362447121', 'M2022-0234', 'Statistics for Begin', '2025-03-28', '2025-03-29', 'BSCS', 'Robert Brown'),
(93, 'dizon@gmail.com', 'Carlos Joseph Dizon', 'Teresa BANGBANG', '09224232424', 'B2022-0423', 'World Geography', '2025-03-28', '2025-03-29', 'BSIT', 'Marco Polo'),
(94, 'dizon@gmail.com', 'Carlos Joseph Dizon', 'Teresa BANGBANG', '09224232424', 'B2022-0423', 'Statistics for Begin', '2025-03-28', '2025-03-29', 'BSIT', 'Robert Brown');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
