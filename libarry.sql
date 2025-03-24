-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 02:50 AM
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
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `author` varchar(255) DEFAULT NULL,
  `publication_year` int(4) DEFAULT NULL,
  `cover_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `subject`, `author`, `publication_year`, `cover_image`) VALUES
(35, 'Advanced Algebra', 'Mathematics', 'John Doe', 2020, ''),
(36, 'Calculus Essentials', 'Mathematics', 'Jane Smith', 2019, ''),
(37, 'Statistics for Beginners', 'Mathematics', 'Robert Brown', 2021, ''),
(38, 'Physics for Everyone', 'Science', 'Albert Newton', 2018, ''),
(39, 'The Wonders of Chemistry', 'Science', 'Marie Curie', 2022, ''),
(40, 'Biology: The Living World', 'Science', 'Charles Darwin', 2023, ''),
(41, 'Mastering Grammar', 'English', 'Emily White', 2020, ''),
(42, 'Shakespeare’s Classics', 'English', 'William S.', 2017, ''),
(43, 'Creative Writing Techniques', 'English', 'Ernest H.', 2021, ''),
(44, 'Ibong Adarna', 'Filipino', 'Jose Corazon', 2015, ''),
(45, 'Florante at Laura', 'Filipino', 'Francisco Balagtas', 2018, ''),
(46, 'Mga Piling Tula', 'Filipino', 'Andres Bonifacio', 2022, ''),
(47, 'Basic Cooking Techniques', 'TLE', 'Chef Gordon', 2020, ''),
(48, 'Entrepreneurship 101', 'TLE', 'Mark Cuban', 2021, ''),
(49, 'Computer Hardware Basics', 'TLE', 'Steve Jobs', 2022, ''),
(50, 'Fitness and Health', 'Physical Education', 'Arnold Fitman', 2019, ''),
(51, 'Sports Science Fundamentals', 'Physical Education', 'Michael Jordan', 2021, ''),
(52, 'Philippine History', 'Araling Panlipunan', 'Carlos Garcia', 2016, ''),
(53, 'World Geography', 'Araling Panlipunan', 'Marco Polo', 2020, ''),
(54, 'Ethics and Morality', 'ESP', 'Dr. John Ethics', 2019, ''),
(55, 'Character Development', 'ESP', 'Xavier Morals', 2022, '');

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
(3, 'test', '$2y$10$wDxcK1Z2eaQ7gYYDVHnsF.n00ERZDiq1P25W5DdFTJLgl82SgYs9u', 'test@gmail.com', 'BSCS', '2025-0002'),
(4, 'austria', '$2y$10$LeiLX.QVWkL7QP.eyFQwKuSl3R7Aq5LET1YWSQg4xAjgJ/XlqiGIm', 'johnluizaustria@gmail.com', 'BSCS', 'M2022-0234'),
(5, 'JohnAustria', '$2y$10$tn8iGO6dRmAUKwRpRu8A0eOSw7Bdm3Zb4R8d/an.aAPw5M1gAT/sC', 'john121@gmail.com', 'BSCS', 'M2022-0234'),
(6, 'ausss', '$2y$10$R7pfy.LvuCwOByc6mEwIj.DnjfVsnwqxdtSXCrZd92WpCmzU9wpwq', 'joheaweew@gmail.com', 'BSCS', 'M2022-0234'),
(7, 'austria3232', '$2y$10$0ncrihogkCyvi.z/8aRro.W74vJwkFL.ylGWOtzVh36rW9CTM5Ue2', 'eqeqeew@gmail.com', 'BSCS', 'M2022-0234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
