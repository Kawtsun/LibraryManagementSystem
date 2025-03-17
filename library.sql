-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 17, 2025 at 07:18 AM
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
-- Database: `library`
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
  `return_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `email`, `name`, `address`, `contact_number`, `student_id`, `book_id`, `date_borrowed`, `return_date`) VALUES
(1, 'mj@fa.com', 'dada', 'dadsa', 'dasd', 'adas', 'dasda', '2025-03-20', '2025-03-22'),
(2, 'setsu@gmail.com', 'setsu', 'jpan', '2323', '32323', '22323', '2025-03-21', '2025-03-31'),
(3, 'test@gmail.com', 'daad', 'dadad', '32323', '0000', '0101', '2025-03-17', '2025-03-27'),
(4, 'test@gmail.com', 'sdsdsds', 'dsdsd', '233324', '32', '323', '2025-03-17', '2025-03-21'),
(5, 'limpante@gmail.com', 'Andrei Limpante', 'Calumpang Bin., Rizal', '0912345678', 'M001-1111', 'B123', '2025-03-17', '2025-03-30'),
(6, 'test3@gmail.com', 'Test3', 'Test3', '232323', '443242', '434141', '2025-03-17', '2025-03-27');

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
  `student_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `course`, `student_id`) VALUES
(1, 'setsu', '$2y$10$dyH3LvpxdUetz4wUkHxGqeUp8YYHp5R3naVJHpCLxzIzxRmIXp4u6', 'setsu@gmail.com', 'BSCS', '2025-0001'),
(2, 'morpheus', '$2y$10$ZIt/8G.Qx3t9kokHK8B0RO6YqU6Q8nbwl3k11Pg2twaAGuR9lPztu', 'morpheus@gmail.com', 'BSCS', '2025-0002'),
(3, 'test', '$2y$10$wDxcK1Z2eaQ7gYYDVHnsF.n00ERZDiq1P25W5DdFTJLgl82SgYs9u', 'test@gmail.com', 'BSCS', '2025-0002');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
