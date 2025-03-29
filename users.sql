-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2025 at 01:39 PM
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
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `course` varchar(100) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--
INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `course`, `student_id`, `name`, `address`, `contact_number`) VALUES
(1, 'setsu', '$2y$10$dyH3LvpxdUetz4wUkHxGqeUp8YYHp5R3naVJHpCLxzIzxRmIXp4u6', 'setsu@gmail.com', 'BSCS', 'M2025-0001', 'Setsuna Yuki', 'Japan', '123'),
(2, 'morpheus', '$2y$10$ZIt/8G.Qx3t9kokHK8B0RO6YqU6Q8nbwl3k11Pg2twaAGuR9lPztu', 'morpheus@gmail.com', 'BSCS', 'M2025-0002', 'Morpheus', 'Morong','123'),
(3, 'austria', '$2y$10$FfIfsHKTe20mPifUr5Hhaeh9GiMYUhV0iXd.v4seyf/GpPTOuA20.', 'johnluizaustria@gmail.com', 'BSCS', 'M2022-0234', 'John Luiz S Austria', '670 Notanggi St. Darangan Binangonan, Rizal', '09362447121'),
(4, 'dizon', '$2y$10$nJSJ0BVD0RB9Rlad5dsDYevFM5E16.XJNwHusCNLMDf5t8uPtKIcm', 'dizon@gmail.com', 'BSIT', 'B2022-0423', 'Carlos Joseph Dizon', 'Teresa BANGBANG', '09224232424'),
(5, 'Kawtsun', '$2y$10$qpedbbZhRdDO.HF.ViVv4ucEZ8Sr1ufld2nG4u4QF4aqCc.jxjM2q', 'kawtsun@gmail.com', 'BSCS', 'M2025-0005', 'Morpheus Francisco', 'Morong', '123'),
(6, 'Kita', '$2y$10$4Ci5NvVWudIPJQN38bTABuTBrBowIc3v/okMOkJOCr6avChzVmlZ.', 'kita@gmail.com', 'BSCS', 'M2025-0006', 'Ikuyo Kita', 'Japan', '123'),
(7, 'Chisato', '$2y$10$8HBOXBMvC1DFproX.dMYa.zA65JzMcHvwXWqJzOUTNjI7N3jxTSpq', 'chisato@gmail.com', 'BSCS', 'M2025-0007', 'Chisato Arashi', 'Japan', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
