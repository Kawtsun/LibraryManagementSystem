-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2025 at 05:48 AM
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
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$TC9gQISsSMhE0XvIfm4O.uU441PFtrX/wNeFRt1EoXxpva6TdRZ/.', '2025-03-26 05:56:46', '2025-03-26 05:56:46');

-- --------------------------------------------------------

--
-- Table structure for table `author_books`
--

CREATE TABLE `author_books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `publication_year` int(11) DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL,
  `Available` int(11) NOT NULL DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `author_books`
--

INSERT INTO `author_books` (`id`, `title`, `author`, `subject`, `publication_year`, `date_added`, `quantity`, `Available`) VALUES
(1, 'John Doe: The Quantum Paradox', 'John Doe', 'Science Fiction', 2023, '2025-03-22 21:32:24', 5, 5),
(2, 'John Doe: Echoes of Eternity', 'John Doe', 'Fantasy', 2022, '2025-03-20 14:46:07', 5, 5),
(3, 'John Doe: Silent Shadows', 'John Doe', 'Mystery', 2021, '2025-03-21 09:13:21', 5, 5),
(4, 'John Doe: Crimson Tide', 'John Doe', 'Thriller', 2020, '2025-03-25 01:48:26', 5, 5),
(5, 'John Doe: A Tale of Two Worlds', 'John Doe', 'Adventure', 2019, '2025-03-20 05:22:08', 5, 5),
(6, 'John Doe: The Lost City', 'John Doe', 'Historical Fiction', 2018, '2025-03-26 21:25:21', 5, 5),
(7, 'John Doe: Whispers of the Wind', 'John Doe', 'Poetry', 2023, '2025-03-25 19:00:22', 5, 5),
(8, 'John Doe: The Final Curtain', 'John Doe', 'Drama', 2022, '2025-03-21 06:45:47', 5, 5),
(9, 'John Doe: Starlight Symphony', 'John Doe', 'Romance', 2021, '2025-03-23 00:47:51', 5, 5),
(10, 'John Doe: Beyond the Horizon', 'John Doe', 'Science Fiction', 2020, '2025-03-24 07:41:53', 5, 5),
(11, 'Jane Smith: The Enigma Code', 'Jane Smith', 'Mystery', 2023, '2025-03-25 12:05:52', 5, 5),
(12, 'Jane Smith: Beneath the Surface', 'Jane Smith', 'Thriller', 2022, '2025-03-20 13:23:43', 5, 5),
(13, 'Jane Smith: The River\'s Secret', 'Jane Smith', 'Adventure', 2021, '2025-03-20 06:41:00', 5, 5),
(14, 'Jane Smith: A Journey Through Time', 'Jane Smith', 'Historical Fiction', 2020, '2025-03-26 17:13:51', 5, 5),
(15, 'Jane Smith: Melodies of the Heart', 'Jane Smith', 'Romance', 2023, '2025-03-24 18:06:14', 5, 5),
(16, 'Jane Smith: Galactic Explorers', 'Jane Smith', 'Science Fiction', 2022, '2025-03-23 14:49:39', 5, 5),
(17, 'Jane Smith: Realm of the Dragons', 'Jane Smith', 'Fantasy', 2021, '2025-03-23 19:49:32', 5, 5),
(18, 'Jane Smith: Poetry of the Soul', 'Jane Smith', 'Poetry', 2020, '2025-03-21 06:38:43', 5, 5),
(19, 'Jane Smith: The Stage is Set', 'Jane Smith', 'Drama', 2023, '2025-03-21 21:45:00', 5, 5),
(20, 'Jane Smith: Echoes of the Past', 'Jane Smith', 'Historical Fiction', 2022, '2025-03-25 16:48:53', 5, 5),
(21, 'Robert Brown: The Lost Artifact', 'Robert Brown', 'Adventure', 2023, '2025-03-21 18:49:23', 5, 5),
(22, 'Robert Brown: Shadows of Deception', 'Robert Brown', 'Mystery', 2022, '2025-03-25 19:40:20', 5, 5),
(23, 'Robert Brown: The Last Stand', 'Robert Brown', 'Thriller', 2021, '2025-03-22 17:53:29', 5, 5),
(24, 'Robert Brown: Symphony of Stars', 'Robert Brown', 'Science Fiction', 2020, '2025-03-23 06:26:25', 5, 5),
(25, 'Robert Brown: Tales of the Forgotten', 'Robert Brown', 'Fantasy', 2023, '2025-03-21 02:31:39', 5, 5),
(26, 'Robert Brown: The Poet\'s Muse', 'Robert Brown', 'Poetry', 2022, '2025-03-22 17:19:02', 5, 5),
(27, 'Robert Brown: Curtain Call', 'Robert Brown', 'Drama', 2021, '2025-03-23 07:00:11', 5, 5),
(28, 'Robert Brown: Heart\'s Desire', 'Robert Brown', 'Romance', 2020, '2025-03-21 07:03:50', 5, 5),
(29, 'Robert Brown: Chronicles of the Ancients', 'Robert Brown', 'Historical Fiction', 2023, '2025-03-23 14:18:38', 5, 5),
(30, 'Robert Brown: Voyage to the Unknown', 'Robert Brown', 'Science Fiction', 2022, '2025-03-20 02:21:42', 5, 5),
(31, 'Albert Newton: The Cosmic Equation', 'Albert Newton', 'Science Fiction', 2023, '2025-03-23 16:52:37', 5, 5),
(32, 'Albert Newton: Riddle of the Sphinx', 'Albert Newton', 'Mystery', 2022, '2025-03-24 05:18:00', 5, 5),
(33, 'Albert Newton: Edge of Tomorrow', 'Albert Newton', 'Thriller', 2021, '2025-03-22 23:52:10', 5, 5),
(34, 'Albert Newton: Saga of the Elven Lords', 'Albert Newton', 'Fantasy', 2020, '2025-03-22 07:26:50', 5, 5),
(35, 'Albert Newton: The Wanderer\'s Path', 'Albert Newton', 'Adventure', 2023, '2025-03-22 13:37:39', 5, 5),
(36, 'Albert Newton: Timeless Love', 'Albert Newton', 'Romance', 2022, '2025-03-25 21:47:44', 5, 5),
(37, 'Albert Newton: The Bard\'s Legacy', 'Albert Newton', 'Poetry', 2021, '2025-03-20 20:05:46', 5, 5),
(38, 'Albert Newton: The Stagehand\'s Dream', 'Albert Newton', 'Drama', 2020, '2025-03-20 11:05:39', 5, 5),
(39, 'Albert Newton: Secrets of the Pharaohs', 'Albert Newton', 'Historical Fiction', 2023, '2025-03-26 19:10:56', 5, 5),
(40, 'Albert Newton: Beyond the Stars', 'Albert Newton', 'Science Fiction', 2022, '2025-03-24 14:37:44', 5, 5),
(41, 'Marie Curie: The Radioactive Legacy', 'Marie Curie', 'Science Fiction', 2023, '2025-03-22 15:35:53', 5, 5),
(42, 'Marie Curie: The Alchemist\'s Secret', 'Marie Curie', 'Mystery', 2022, '2025-03-26 10:06:14', 5, 5),
(43, 'Marie Curie: Countdown to Zero', 'Marie Curie', 'Thriller', 2021, '2025-03-23 03:43:29', 5, 5),
(44, 'Marie Curie: Guardians of the Realm', 'Marie Curie', 'Fantasy', 2020, '2025-03-23 12:18:44', 5, 5),
(45, 'Marie Curie: The Explorer\'s Journal', 'Marie Curie', 'Adventure', 2023, '2025-03-21 02:23:15', 5, 5),
(46, 'Marie Curie: Love in the Time of Cholera', 'Marie Curie', 'Romance', 2022, '2025-03-21 23:00:01', 5, 5),
(47, 'Marie Curie: The Poet\'s Canvas', 'Marie Curie', 'Poetry', 2021, '2025-03-26 11:50:23', 5, 5),
(48, 'Marie Curie: The Actor\'s Journey', 'Marie Curie', 'Drama', 2020, '2025-03-25 14:11:50', 5, 5),
(49, 'Marie Curie: The Roman Empire', 'Marie Curie', 'Historical Fiction', 2023, '2025-03-21 11:28:03', 5, 5),
(50, 'Marie Curie: To the Edge of the Universe', 'Marie Curie', 'Science Fiction', 2022, '2025-03-24 14:44:45', 5, 5),
(51, 'Charles Darwin: The Evolutionary Enigma', 'Charles Darwin', 'Science Fiction', 2023, '2025-03-24 15:19:36', 5, 5),
(52, 'Charles Darwin: The Hidden Clues', 'Charles Darwin', 'Mystery', 2022, '2025-03-22 08:23:44', 5, 5),
(53, 'Charles Darwin: The Final Descent', 'Charles Darwin', 'Thriller', 2021, '2025-03-24 19:59:53', 5, 5),
(54, 'Charles Darwin: The Dragon\'s Lair', 'Charles Darwin', 'Fantasy', 2020, '2025-03-23 02:48:16', 5, 5),
(55, 'Charles Darwin: The Lost Expedition', 'Charles Darwin', 'Adventure', 2023, '2025-03-21 02:01:41', 5, 5),
(56, 'Charles Darwin: Love\'s Eternal Flame', 'Charles Darwin', 'Romance', 2022, '2025-03-23 01:43:36', 5, 5),
(57, 'Charles Darwin: The Poet\'s Quill', 'Charles Darwin', 'Poetry', 2021, '2025-03-25 02:32:59', 5, 5),
(58, 'Charles Darwin: The Director\'s Cut', 'Charles Darwin', 'Drama', 2020, '2025-03-22 07:34:09', 5, 5),
(59, 'Charles Darwin: The Age of Discovery', 'Charles Darwin', 'Historical Fiction', 2023, '2025-03-23 06:11:46', 5, 5),
(60, 'Charles Darwin: Journey to the Stars', 'Charles Darwin', 'Science Fiction', 2022, '2025-03-22 08:16:25', 5, 5),
(61, 'Emily White: The Vanishing Act', 'Emily White', 'Mystery', 2023, '2025-03-21 22:46:46', 5, 5),
(62, 'Emily White: The Silent Witness', 'Emily White', 'Thriller', 2022, '2025-03-22 17:04:36', 5, 5),
(63, 'Emily White: The Treasure Hunt', 'Emily White', 'Adventure', 2021, '2025-03-20 17:02:41', 5, 5),
(64, 'Emily White: A Love Story', 'Emily White', 'Romance', 2020, '2025-03-22 09:59:40', 5, 5),
(65, 'Emily White: The Poet\'s Heart', 'Emily White', 'Poetry', 2023, '2025-03-22 22:50:17', 5, 5),
(66, 'Emily White: The Playwright', 'Emily White', 'Drama', 2022, '2025-03-20 12:12:24', 5, 5),
(67, 'Emily White: The Viking Age', 'Emily White', 'Historical Fiction', 2021, '2025-03-20 16:31:12', 5, 5),
(68, 'Emily White: The Stellar Odyssey', 'Emily White', 'Science Fiction', 2020, '2025-03-21 21:58:46', 5, 5),
(69, 'Emily White: The Enchanted Forest', 'Emily White', 'Fantasy', 2023, '2025-03-20 12:20:17', 5, 5),
(70, 'Emily White: The Lost City of Gold', 'Emily White', 'Adventure', 2022, '2025-03-23 19:45:05', 5, 5),
(71, 'William S: The Shakespearean Mystery', 'William S', 'Mystery', 2023, '2025-03-23 13:44:34', 5, 5),
(72, 'William S: The Bard\'s Revenge', 'William S', 'Thriller', 2022, '2025-03-26 09:27:37', 5, 5),
(73, 'William S: The Globe Theatre', 'William S', 'Drama', 2021, '2025-03-20 06:04:22', 5, 5),
(74, 'William S: A Midsummer Night\'s Dream', 'William S', 'Romance', 2020, '2025-03-23 01:59:01', 5, 5),
(75, 'William S: The Poet\'s Sonnets', 'William S', 'Poetry', 2023, '2025-03-20 15:42:01', 5, 5),
(76, 'William S: The Elizabethan Era', 'William S', 'Historical Fiction', 2022, '2025-03-21 00:33:00', 5, 5),
(77, 'William S: The Tragedy of Hamlet, Prince of Denmark', 'William S', 'Drama', 2021, '2025-03-23 03:38:57', 5, 5),
(78, 'William S: Romeo and Juliet', 'William S', 'Romance', 2020, '2025-03-25 16:35:47', 5, 5),
(79, 'William S: Macbeth', 'William S', 'Drama', 2023, '2025-03-25 00:02:04', 5, 5),
(80, 'William S: Othello, the Moor of Venice', 'William S', 'Drama', 2022, '2025-03-20 22:23:01', 5, 5),
(81, 'William S: King Lear', 'William S', 'Drama', 2021, '2025-03-23 15:48:50', 5, 5),
(82, 'Ernest H: The Old Man and the Sea', 'Ernest H', 'Adventure', 2023, '2025-03-21 11:55:11', 5, 5),
(83, 'Ernest H: A Farewell to Arms', 'Ernest H', 'Romance', 2022, '2025-03-23 12:09:25', 5, 5),
(84, 'Ernest H: The Sun Also Rises', 'Ernest H', 'Historical Fiction', 2021, '2025-03-26 01:01:31', 5, 5),
(85, 'Ernest H: For Whom the Bell Tolls', 'Ernest H', 'Thriller', 2020, '2025-03-25 16:39:23', 5, 5),
(86, 'Ernest H: The Poet\'s War', 'Ernest H', 'Poetry', 2023, '2025-03-23 08:12:19', 5, 5),
(87, 'Ernest H: The Playwright\'s Life', 'Ernest H', 'Drama', 2020, '2025-03-26 15:03:29', 5, 5),
(88, 'Ernest H: The Spanish Civil War', 'Ernest H', 'Historical Fiction', 2023, '2025-03-22 02:40:29', 5, 5),
(89, 'Ernest H: The Lost Generation', 'Ernest H', 'Historical Fiction', 2022, '2025-03-24 16:11:58', 5, 5),
(90, 'Ernest H: To Have and Have Not', 'Ernest H', 'Adventure', 2021, '2025-03-23 00:58:23', 5, 5),
(91, 'Ernest H: Death in the Afternoon', 'Ernest H', 'Non-fiction', 2020, '2025-03-21 04:16:00', 5, 5),
(92, 'Jose Corazon: Ang Bayan Ko', 'Jose Corazon', 'Poetry', 2023, '2025-03-23 18:24:52', 5, 5),
(93, 'Jose Corazon: Isang Punongkahoy', 'Jose Corazon', 'Poetry', 2022, '2025-03-21 07:16:22', 5, 5),
(94, 'Jose Corazon: Ang Pagbabalik', 'Jose Corazon', 'Poetry', 2021, '2025-03-22 05:07:16', 5, 5),
(95, 'Jose Corazon: Mga Dahong Ginto', 'Jose Corazon', 'Poetry', 2020, '2025-03-20 03:47:13', 5, 5),
(96, 'Jose Corazon: Sa Dakong Silangan', 'Jose Corazon', 'Poetry', 2023, '2025-03-21 03:34:16', 5, 5),
(97, 'Jose Corazon: Ang Araw', 'Jose Corazon', 'Poetry', 2022, '2025-03-25 06:29:42', 5, 5),
(98, 'Jose Corazon: Ang Guryon', 'Jose Corazon', 'Poetry', 2021, '2025-03-21 21:45:42', 5, 5),
(99, 'Jose Corazon: Mga Tinik ng Puso', 'Jose Corazon', 'Poetry', 2020, '2025-03-20 17:19:25', 5, 5),
(100, 'Jose Corazon: Ang Mga Ibon', 'Jose Corazon', 'Poetry', 2023, '2025-03-24 21:20:00', 5, 5),
(101, 'Jose Corazon: Ang Pangarap', 'Jose Corazon', 'Poetry', 2022, '2025-03-21 06:41:47', 5, 5),
(102, 'Francisco Balagtas: Florante at Laura', 'Francisco Balagtas', 'Filipino', 2023, '2025-03-25 17:28:53', 5, 5),
(103, 'Francisco Balagtas: Orosman at Zafira', 'Francisco Balagtas', 'Filipino', 2022, '2025-03-23 19:19:07', 5, 5),
(104, 'Francisco Balagtas: Abdal at Misarela', 'Francisco Balagtas', 'Filipino', 2021, '2025-03-21 20:08:55', 5, 5),
(105, 'Francisco Balagtas: Clara Belmonte', 'Francisco Balagtas', 'Filipino', 2020, '2025-03-24 18:47:17', 5, 5),
(106, 'Francisco Balagtas: La India Elegante y el Negrito Amante', 'Francisco Balagtas', 'Filipino', 2023, '2025-03-24 09:29:38', 5, 5),
(107, 'Francisco Balagtas: Mahomet at Constanza', 'Francisco Balagtas', 'Filipino', 2022, '2025-03-20 15:06:20', 5, 5),
(108, 'Francisco Balagtas: Rodolfo at Rosamunda', 'Francisco Balagtas', 'Filipino', 2021, '2025-03-23 23:02:47', 5, 5),
(109, 'Francisco Balagtas: Almanzor at Rosalina', 'Francisco Balagtas', 'Filipino', 2020, '2025-03-23 21:54:55', 5, 5),
(110, 'Francisco Balagtas: Bayaceto at Dorlisca', 'Francisco Balagtas', 'Filipino', 2023, '2025-03-20 16:26:13', 5, 5),
(111, 'Francisco Balagtas: Don Nuño at Zelinda', 'Francisco Balagtas', 'Filipino', 2022, '2025-03-25 16:26:21', 5, 5),
(112, 'Andres Bonifacio: Pag-ibig sa Tinubuang Lupa', 'Andres Bonifacio', 'Filipino', 2023, '2025-03-25 08:53:09', 5, 5),
(113, 'Andres Bonifacio: Katapusang Hibik ng Pilipinas', 'Andres Bonifacio', 'Filipino', 2022, '2025-03-22 19:06:40', 5, 5),
(114, 'Andres Bonifacio: Ang Dapat Mabatid ng mga Tagalog', 'Andres Bonifacio', 'Filipino', 2021, '2025-03-24 20:53:55', 5, 5),
(115, 'Andres Bonifacio: Tapunan ng Lingap', 'Andres Bonifacio', 'Filipino', 2020, '2025-03-21 23:09:36', 5, 5),
(116, 'Andres Bonifacio: Katungkulan Gagawin ng mga Anak ng Bayan', 'Andres Bonifacio', 'Filipino', 2023, '2025-03-22 05:06:17', 5, 5),
(117, 'Andres Bonifacio: Dekalogo', 'Andres Bonifacio', 'Filipino', 2022, '2025-03-25 04:02:35', 5, 5),
(118, 'Andres Bonifacio: Mi Ultimo Adios', 'Andres Bonifacio', 'Filipino', 2021, '2025-03-25 04:54:06', 5, 5),
(119, 'Andres Bonifacio: Ang Mga Cazadores', 'Andres Bonifacio', 'Filipino', 2020, '2025-03-23 12:22:47', 5, 5),
(120, 'Andres Bonifacio: Huling Paalam', 'Andres Bonifacio', 'Filipino', 2023, '2025-03-21 23:11:34', 5, 5),
(121, 'Andres Bonifacio: Liwanag at Dilim', 'Andres Bonifacio', 'Filipino', 2022, '2025-03-26 06:49:31', 5, 5),
(122, 'Chef Gordon: Gordon Ramsay\'s Home Cooking', 'Chef Gordon', 'TLE', 2023, '2025-03-24 12:32:54', 5, 5),
(123, 'Chef Gordon: Humble Pie', 'Chef Gordon', 'TLE', 2022, '2025-03-23 18:15:59', 5, 5),
(124, 'Chef Gordon: Playing with Fire', 'Chef Gordon', 'TLE', 2021, '2025-03-25 05:41:11', 5, 5),
(125, 'Chef Gordon: Roasting in Hell\'s Kitchen', 'Chef Gordon', 'TLE', 2020, '2025-03-20 21:37:58', 5, 5),
(126, 'Chef Gordon: Fast Food', 'Chef Gordon', 'TLE', 2023, '2025-03-22 19:06:18', 5, 5),
(127, 'Chef Gordon: World Kitchen', 'Chef Gordon', 'TLE', 2022, '2025-03-24 06:37:36', 5, 5),
(128, 'Chef Gordon: Bread Street Kitchen', 'Chef Gordon', 'TLE', 2021, '2025-03-25 23:49:08', 5, 5),
(129, 'Chef Gordon: Ultimate Home Cooking', 'Chef Gordon', 'TLE', 2020, '2025-03-23 03:12:53', 5, 5),
(130, 'Chef Gordon: 3 Star Chef', 'Chef Gordon', 'TLE', 2023, '2025-03-24 16:37:01', 5, 5),
(131, 'Chef Gordon: Ramsay in 10', 'Chef Gordon', 'TLE', 2022, '2025-03-20 01:26:28', 5, 5),
(132, 'Mark Cuban: How to Win at the Sport of Business', 'Mark Cuban', 'TLE', 2023, '2025-03-20 05:21:17', 5, 5),
(133, 'Mark Cuban: Shark Tank Jump Start Your Business', 'Mark Cuban', 'TLE', 2022, '2025-03-20 22:27:02', 5, 5),
(134, 'Mark Cuban: The Mavericks Way', 'Mark Cuban', 'TLE', 2021, '2025-03-24 00:11:19', 5, 5),
(135, 'Mark Cuban: Be Your Own Boss', 'Mark Cuban', 'TLE', 2020, '2025-03-23 05:35:27', 5, 5),
(136, 'Mark Cuban: Entrepreneurial Mindset', 'Mark Cuban', 'TLE', 2023, '2025-03-24 03:23:22', 5, 5),
(137, 'Mark Cuban: 12 Rules for Startups', 'Mark Cuban', 'TLE', 2022, '2025-03-24 00:10:28', 5, 5),
(138, 'Mark Cuban: The Business of Sports', 'Mark Cuban', 'TLE', 2021, '2025-03-20 14:42:16', 5, 5),
(139, 'Mark Cuban: Investing for Dummies', 'Mark Cuban', 'TLE', 2020, '2025-03-25 00:59:54', 5, 5),
(140, 'Mark Cuban: The Billionaire Blueprint', 'Mark Cuban', 'TLE', 2023, '2025-03-22 08:52:45', 5, 5),
(141, 'Mark Cuban: From Rags to Riches', 'Mark Cuban', 'TLE', 2022, '2025-03-23 17:24:04', 5, 5),
(142, 'Steve Jobs: Steve Jobs', 'Steve Jobs', 'TLE', 2023, '2025-03-24 12:22:05', 5, 5),
(143, 'Steve Jobs: The Second Coming of Steve Jobs', 'Steve Jobs', 'TLE', 2022, '2025-03-24 09:38:15', 5, 5),
(144, 'Steve Jobs: iCon Steve Jobs', 'Steve Jobs', 'TLE', 2021, '2025-03-21 11:04:58', 5, 5),
(145, 'Steve Jobs: Becoming Steve Jobs', 'Steve Jobs', 'TLE', 2020, '2025-03-21 02:30:06', 5, 5),
(146, 'Steve Jobs: The Steve Jobs Way', 'Steve Jobs', 'TLE', 2023, '2025-03-21 03:15:36', 5, 5),
(147, 'Steve Jobs: Inside Steve\'s Brain', 'Steve Jobs', 'TLE', 2022, '2025-03-22 08:47:42', 5, 5),
(148, 'Steve Jobs: What Would Steve Jobs Do?', 'Steve Jobs', 'TLE', 2021, '2025-03-21 10:11:42', 5, 5),
(149, 'Steve Jobs: The Presentation Secrets of Steve Jobs', 'Steve Jobs', 'TLE', 2020, '2025-03-20 00:35:24', 5, 5),
(150, 'Steve Jobs: Steve Jobs and the Next Big Thing', 'Steve Jobs', 'TLE', 2023, '2025-03-22 20:21:53', 5, 5),
(151, 'Steve Jobs: The Innovation Secrets of Steve Jobs', 'Steve Jobs', 'TLE', 2022, '2025-03-20 04:03:17', 5, 5),
(152, 'Arnold Fitman: The Encyclopedia of Modern Bodybuilding', 'Arnold Fitman', 'Physical Education', 2023, '2025-03-26 07:10:47', 5, 5),
(153, 'Arnold Fitman: Total Recall', 'Arnold Fitman', 'Physical Education', 2022, '2025-03-22 23:44:02', 5, 5),
(154, 'Arnold Fitman: New Encyclopedia of Modern Bodybuilding', 'Arnold Fitman', 'Physical Education', 2021, '2025-03-23 01:07:52', 5, 5),
(155, 'Arnold Fitman: Education of a Bodybuilder', 'Arnold Fitman', 'Physical Education', 2020, '2025-03-26 06:27:14', 5, 5),
(156, 'Arnold Fitman: Pumping Iron', 'Arnold Fitman', 'Physical Education', 2023, '2025-03-21 04:52:35', 5, 5),
(157, 'Arnold Fitman: The Fitness Bible', 'Arnold Fitman', 'Physical Education', 2022, '2025-03-21 05:01:11', 5, 5),
(158, 'Arnold Fitman: Strength Training Anatomy', 'Arnold Fitman', 'Physical Education', 2021, '2025-03-22 10:28:13', 5, 5),
(159, 'Arnold Fitman: The 7-Minute Body', 'Arnold Fitman', 'Physical Education', 2020, '2025-03-21 13:17:33', 5, 5),
(160, 'Arnold Fitman: The Body Sculpting Bible for Women', 'Arnold Fitman', 'Physical Education', 2023, '2025-03-20 11:03:07', 5, 5),
(161, 'Arnold Fitman: The Encyclopedia of Modern Bodybuilding', 'Arnold Fitman', 'Physical Education', 2022, '2025-03-24 15:22:54', 5, 5),
(162, 'Michael Jordan: Driven from Within', 'Michael Jordan', 'Physical Education', 2023, '2025-03-20 19:45:13', 5, 5),
(163, 'Michael Jordan: I Can\'t Accept Not Trying', 'Michael Jordan', 'Physical Education', 2022, '2025-03-24 04:37:20', 5, 5),
(164, 'Michael Jordan: Rare Air', 'Michael Jordan', 'Physical Education', 2021, '2025-03-24 11:51:02', 5, 5),
(165, 'Michael Jordan: Playing for Keeps', 'Michael Jordan', 'Physical Education', 2020, '2025-03-22 21:23:12', 5, 5),
(166, 'Michael Jordan: Hang Time', 'Michael Jordan', 'Physical Education', 2023, '2025-03-20 23:22:53', 5, 5),
(167, 'Michael Jordan: Michael Jordan: The Life', 'Michael Jordan', 'Physical Education', 2022, '2025-03-23 04:44:48', 5, 5),
(168, 'Michael Jordan: Jumpman', 'Michael Jordan', 'Physical Education', 2021, '2025-03-26 01:35:24', 5, 5),
(169, 'Michael Jordan: The Last Dance', 'Michael Jordan', 'Physical Education', 2020, '2025-03-26 17:42:36', 5, 5),
(170, 'Michael Jordan: Be Like Mike', 'Michael Jordan', 'Physical Education', 2023, '2025-03-21 11:46:47', 5, 5),
(171, 'Michael Jordan: Winning', 'Michael Jordan', 'Physical Education', 2022, '2025-03-21 05:46:10', 5, 5),
(172, 'Carlos Garcia: Philippine History', 'Carlos Garcia', 'Araling Panlipunan', 2023, '2025-03-21 17:30:26', 5, 5),
(173, 'Carlos Garcia: A Nation for Our Children', 'Carlos Garcia', 'Araling Panlipunan', 2022, '2025-03-24 22:13:44', 5, 5),
(174, 'Carlos Garcia: The Filipino First Policy', 'Carlos Garcia', 'Araling Panlipunan', 2021, '2025-03-25 10:37:23', 5, 5),
(175, 'Carlos Garcia: The Austerity Program', 'Carlos Garcia', 'Araling Panlipunan', 2020, '2025-03-25 10:25:41', 5, 5),
(176, 'Carlos Garcia: The Bohlen-Serrano Agreement', 'Carlos Garcia', 'Araling Panlipunan', 2023, '2025-03-23 20:16:19', 5, 5),
(177, 'Carlos Garcia: The Laurel-Langley Agreement', 'Carlos Garcia', 'Araling Panlipunan', 2022, '2025-03-22 22:04:33', 5, 5),
(178, 'Carlos Garcia: The Garcia Doctrine', 'Carlos Garcia', 'Araling Panlipunan', 2021, '2025-03-23 01:33:48', 5, 5),
(179, 'Carlos Garcia: The Garcia Administration', 'Carlos Garcia', 'Araling Panlipunan', 2020, '2025-03-26 13:35:22', 5, 5),
(180, 'Carlos Garcia: The Philippine Economy', 'Carlos Garcia', 'Araling Panlipunan', 2023, '2025-03-22 15:15:26', 5, 5),
(181, 'Carlos Garcia: The Philippine Politics', 'Carlos Garcia', 'Araling Panlipunan', 2022, '2025-03-20 11:31:06', 5, 5),
(182, 'Marco Polo: The Travels of Marco Polo', 'Marco Polo', 'Araling Panlipunan', 2023, '2025-03-21 11:49:13', 5, 5),
(183, 'Marco Polo: Description of the World', 'Marco Polo', 'Araling Panlipunan', 2022, '2025-03-26 00:32:45', 5, 5),
(184, 'Marco Polo: The Silk Road', 'Marco Polo', 'Araling Panlipunan', 2021, '2025-03-24 15:16:09', 5, 5),
(185, 'Marco Polo: Kublai Khan', 'Marco Polo', 'Araling Panlipunan', 2020, '2025-03-25 02:42:29', 5, 5),
(186, 'Marco Polo: The Mongol Empire', 'Marco Polo', 'Araling Panlipunan', 2023, '2025-03-24 15:44:00', 5, 5),
(187, 'Marco Polo: The Venetian Merchant', 'Marco Polo', 'Araling Panlipunan', 2022, '2025-03-20 22:32:33', 5, 5),
(188, 'Marco Polo: The Asian Trade', 'Marco Polo', 'Araling Panlipunan', 2021, '2025-03-24 17:30:43', 5, 5),
(189, 'Marco Polo: The Exploration of the East', 'Marco Polo', 'Araling Panlipunan', 2020, '2025-03-26 19:56:00', 5, 5),
(190, 'Marco Polo: The Cultural Exchange', 'Marco Polo', 'Araling Panlipunan', 2023, '2025-03-25 23:07:49', 5, 5),
(191, 'Marco Polo: The Geographical Discoveries', 'Marco Polo', 'Araling Panlipunan', 2022, '2025-03-22 07:51:08', 5, 5),
(192, 'Dr. John Ethics: Ethics in the Modern World', 'Dr. John Ethics', 'ESP', 2023, '2025-03-20 17:52:12', 5, 5),
(193, 'Dr. John Ethics: The Principles of Morality', 'Dr. John Ethics', 'ESP', 2022, '2025-03-23 17:47:38', 5, 5),
(194, 'Dr. John Ethics: Moral Philosophy', 'Dr. John Ethics', 'ESP', 2021, '2025-03-22 11:21:35', 5, 5),
(195, 'Dr. John Ethics: Applied Ethics', 'Dr. John Ethics', 'ESP', 2020, '2025-03-21 03:25:00', 5, 5),
(196, 'Dr. John Ethics: Ethical Dilemmas', 'Dr. John Ethics', 'ESP', 2023, '2025-03-25 07:00:18', 5, 5),
(197, 'Dr. John Ethics: The Foundations of Ethics', 'Dr. John Ethics', 'ESP', 2022, '2025-03-22 00:46:27', 5, 5),
(198, 'Dr. John Ethics: Business Ethics', 'Dr. John Ethics', 'ESP', 2021, '2025-03-21 06:51:25', 5, 5),
(199, 'Dr. John Ethics: Environmental Ethics', 'Dr. John Ethics', 'ESP', 2020, '2025-03-20 07:57:41', 5, 5),
(200, 'Dr. John Ethics: Medical Ethics', 'Dr. John Ethics', 'ESP', 2023, '2025-03-24 19:14:14', 5, 5),
(201, 'Dr. John Ethics: Social Ethics', 'Dr. John Ethics', 'ESP', 2022, '2025-03-22 00:18:05', 5, 5),
(202, 'Xavier Morals: Moral Development', 'Xavier Morals', 'ESP', 2023, '2025-03-22 15:47:46', 5, 5),
(203, 'Xavier Morals: The Psychology of Morality', 'Xavier Morals', 'ESP', 2022, '2025-03-20 06:04:35', 5, 5),
(204, 'Xavier Morals: Moral Reasoning', 'Xavier Morals', 'ESP', 2021, '2025-03-20 06:59:37', 5, 5),
(205, 'Xavier Morals: Moral Education', 'Xavier Morals', 'ESP', 2020, '2025-03-20 16:44:22', 5, 5),
(206, 'Xavier Morals: Moral Values', 'Xavier Morals', 'ESP', 2023, '2025-03-22 14:42:58', 5, 5),
(207, 'Xavier Morals: The Development of Conscience', 'Xavier Morals', 'ESP', 2022, '2025-03-23 23:21:47', 5, 5),
(208, 'Xavier Morals: Moral Identity', 'Xavier Morals', 'ESP', 2021, '2025-03-25 00:39:58', 5, 5),
(209, 'Xavier Morals: Moral Character', 'Xavier Morals', 'ESP', 2020, '2025-03-26 05:14:32', 5, 5),
(210, 'Xavier Morals: Moral Competence', 'Xavier Morals', 'ESP', 2023, '2025-03-22 00:12:47', 5, 5),
(211, 'Xavier Morals: Moral Judgment', 'Xavier Morals', 'ESP', 2022, '2025-03-25 09:20:19', 5, 5);

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
  `cover_image` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL,
  `Available` int(11) NOT NULL DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `subject`, `author`, `publication_year`, `cover_image`, `category_id`, `date_added`, `quantity`, `Available`) VALUES
(35, 'Advanced Algebra', 'Mathematics', 'John Doe', 2020, '', NULL, '2025-03-20 22:02:14', 5, 5),
(36, 'Calculus Essentials', 'Mathematics', 'Jane Smith', 2019, '', NULL, '2025-03-21 23:31:29', 5, 5),
(37, 'Statistics for Beginners', 'Mathematics', 'Robert Brown', 2021, '', NULL, '2025-03-20 03:30:45', 5, 5),
(38, 'Physics for Everyone', 'Science', 'Albert Newton', 2018, '', NULL, '2025-03-21 18:59:18', 5, 5),
(39, 'The Wonders of Chemistry', 'Science', 'Marie Curie', 2022, '', NULL, '2025-03-21 12:24:14', 5, 5),
(40, 'Biology: The Living World', 'Science', 'Charles Darwin', 2023, '', NULL, '2025-03-22 05:03:18', 5, 5),
(41, 'Mastering Grammar', 'English', 'Emily White', 2020, '', NULL, '2025-03-26 12:03:46', 5, 5),
(42, 'Shakespeare’s Classics', 'English', 'William S.', 2017, '', NULL, '2025-03-24 21:09:00', 5, 5),
(43, 'Creative Writing Techniques', 'English', 'Ernest H.', 2021, '', NULL, '2025-03-24 21:33:41', 5, 5),
(44, 'Ibong Adarna', 'Filipino', 'Jose Corazon', 2015, '', NULL, '2025-03-22 20:21:27', 5, 5),
(45, 'Florante at Laura', 'Filipino', 'Francisco Balagtas', 2018, '', NULL, '2025-03-26 13:06:10', 5, 5),
(46, 'Mga Piling Tula', 'Filipino', 'Andres Bonifacio', 2022, '', NULL, '2025-03-23 04:26:31', 5, 5),
(47, 'Basic Cooking Techniques', 'TLE', 'Chef Gordon', 2020, '', NULL, '2025-03-23 06:54:05', 5, 5),
(48, 'Entrepreneurship 101', 'TLE', 'Mark Cuban', 2021, '', NULL, '2025-03-26 21:10:51', 5, 5),
(49, 'Computer Hardware Basics', 'TLE', 'Steve Jobs', 2022, '', NULL, '2025-03-23 13:12:00', 5, 5),
(50, 'Fitness and Health', 'Physical Education', 'Arnold Fitman', 2019, '', NULL, '2025-03-24 02:27:28', 5, 5),
(51, 'Sports Science Fundamentals', 'Physical Education', 'Michael Jordan', 2021, '', NULL, '2025-03-22 20:41:20', 5, 5),
(52, 'Philippine History', 'Araling Panlipunan', 'Carlos Garcia', 2016, '', NULL, '2025-03-22 00:04:18', 5, 5),
(53, 'World Geography', 'Araling Panlipunan', 'Marco Polo', 2020, '', NULL, '2025-03-21 10:17:30', 5, 5),
(54, 'Ethics and Morality', 'ESP', 'Dr. John Ethics', 2019, '', NULL, '2025-03-21 03:14:36', 5, 5),
(55, 'Character Development', 'ESP', 'Xavier Morals', 2022, '', NULL, '2025-03-21 09:20:30', 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Mathematics'),
(2, 'Science'),
(3, 'English'),
(4, 'Filipino'),
(5, 'TLE'),
(6, 'Physical Education'),
(7, 'Araling Panlipunan'),
(8, 'Edukasyon sa Pagpapakatao');

-- --------------------------------------------------------

--
-- Table structure for table `library_books`
--

CREATE TABLE `library_books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `topic` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `quantity` int(11) NOT NULL,
  `Available` int(11) NOT NULL DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `library_books`
--

INSERT INTO `library_books` (`id`, `title`, `category_id`, `topic`, `cover_image`, `date_added`, `quantity`, `Available`) VALUES
(1, 'Algebra Fundamentals', 1, 'Algebra', NULL, '2025-03-21 01:09:40', 5, 5),
(2, 'Geometry Basics', 1, 'Shapes and Theorems', NULL, '2025-03-22 10:02:04', 5, 5),
(3, 'Trigonometry Explained', 1, 'Angles and Functions', NULL, '2025-03-21 22:41:20', 5, 5),
(4, 'Probability & Statistics', 1, 'Data Analysis', NULL, '2025-03-22 11:20:28', 5, 5),
(5, 'Calculus for Beginners', 1, 'Derivatives and Integrals', NULL, '2025-03-26 12:38:20', 5, 5),
(6, 'Number Theory Essentials', 1, 'Prime Numbers and Patterns', NULL, '2025-03-24 05:10:18', 5, 5),
(7, 'Linear Algebra Concepts', 1, 'Vectors and Matrices', NULL, '2025-03-21 11:56:28', 5, 5),
(8, 'Mathematical Logic', 1, 'Proofs and Reasoning', NULL, '2025-03-21 20:11:30', 5, 5),
(9, 'Graph Theory Overview', 1, 'Networks and Paths', NULL, '2025-03-24 17:08:05', 5, 5),
(10, 'Advanced Calculus', 1, 'Multivariable Functions', NULL, '2025-03-24 01:05:54', 5, 5),
(11, 'Physics Fundamentals', 2, 'Motion and Forces', NULL, '2025-03-26 02:05:17', 5, 5),
(12, 'Chemistry Essentials', 2, 'Atoms and Molecules', NULL, '2025-03-24 07:08:41', 5, 5),
(13, 'Biology Overview', 2, 'Cells and Organisms', NULL, '2025-03-23 05:27:38', 5, 5),
(14, 'Earth Science', 2, 'Rocks and Minerals', NULL, '2025-03-23 05:52:06', 5, 5),
(15, 'Astronomy Basics', 2, 'Stars and Galaxies', NULL, '2025-03-26 12:57:38', 5, 5),
(16, 'Environmental Science', 2, 'Ecosystems and Conservation', NULL, '2025-03-21 23:11:51', 5, 5),
(17, 'Genetics and Evolution', 2, 'DNA and Heredity', NULL, '2025-03-24 05:06:22', 5, 5),
(18, 'Organic Chemistry', 2, 'Carbon Compounds', NULL, '2025-03-21 03:56:19', 5, 5),
(19, 'Electricity and Magnetism', 2, 'Current and Circuits', NULL, '2025-03-20 04:22:28', 5, 5),
(20, 'Thermodynamics', 2, 'Heat and Energy Transfer', NULL, '2025-03-24 10:03:23', 5, 5),
(21, 'Grammar and Composition', 3, 'Sentence Structure', NULL, '2025-03-20 13:09:33', 5, 5),
(22, 'Literature Classics', 3, 'Famous Novels', NULL, '2025-03-23 11:37:35', 5, 5),
(23, 'Creative Writing', 3, 'Poetry and Storytelling', NULL, '2025-03-21 18:39:16', 5, 5),
(24, 'Public Speaking', 3, 'Speech and Communication', NULL, '2025-03-25 10:23:37', 5, 5),
(25, 'Essay Writing', 3, 'Persuasive and Analytical Essays', NULL, '2025-03-20 20:00:18', 5, 5),
(26, 'Syntax and Semantics', 3, 'Language Analysis', NULL, '2025-03-21 20:50:39', 5, 5),
(27, 'English for Beginners', 3, 'Basic Vocabulary', NULL, '2025-03-26 20:12:19', 5, 5),
(28, 'Shakespearean Works', 3, 'Plays and Sonnets', NULL, '2025-03-20 14:29:41', 5, 5),
(29, 'Modern English Usage', 3, 'Idioms and Expressions', NULL, '2025-03-23 11:51:30', 5, 5),
(30, 'Critical Thinking in Literature', 3, 'Analyzing Texts', NULL, '2025-03-21 15:48:26', 5, 5),
(31, 'Panitikan ng Pilipinas', 4, 'Kwentong Bayan', NULL, '2025-03-24 19:27:40', 5, 5),
(32, 'Alamat at Mitolohiya', 4, 'Mga Sinaunang Kuwento', NULL, '2025-03-25 01:53:03', 5, 5),
(33, 'Balagtasan at Tula', 4, 'Pagsusuri ng Panitikan', NULL, '2025-03-23 23:02:14', 5, 5),
(34, 'Pagsulat ng Sanaysay', 4, 'Pagbuo ng Argumento', NULL, '2025-03-24 13:32:04', 5, 5),
(35, 'Wika at Gramatika', 4, 'Balarila at Kayarian ng Wika', NULL, '2025-03-23 22:33:39', 5, 5),
(36, 'Kasaysayan ng Wikang Filipino', 4, 'Pinagmulan at Pag-unlad', NULL, '2025-03-26 00:12:03', 5, 5),
(37, 'Maikling Kwento', 4, 'Mga Kwentong Bayan', NULL, '2025-03-24 05:19:19', 5, 5),
(38, 'Filipino Journalism', 4, 'Pamamahayag sa Filipino', NULL, '2025-03-23 02:00:27', 5, 5),
(39, 'Pagpapahalaga sa Panitikan', 4, 'Interpretasyon ng Akda', NULL, '2025-03-22 18:04:18', 5, 5),
(40, 'Modernong Panitikang Pilipino', 4, 'Mga Makabagong Akda', NULL, '2025-03-24 12:20:08', 5, 5),
(41, 'Basic Cooking', 5, 'Food Preparation', NULL, '2025-03-20 07:27:47', 5, 5),
(42, 'Entrepreneurship', 5, 'Starting a Business', NULL, '2025-03-22 00:18:31', 5, 5),
(43, 'Woodworking Techniques', 5, 'Carpentry Skills', NULL, '2025-03-22 03:09:17', 5, 5),
(44, 'Automotive Basics', 5, 'Car Maintenance', NULL, '2025-03-24 14:50:51', 5, 5),
(45, 'Information Technology', 5, 'Basic Coding', NULL, '2025-03-22 16:46:23', 5, 5),
(46, 'Electronics Fundamentals', 5, 'Circuits and Devices', NULL, '2025-03-26 15:19:23', 5, 5),
(47, 'Fashion and Textiles', 5, 'Sewing and Design', NULL, '2025-03-24 02:17:45', 5, 5),
(48, 'Graphic Design Essentials', 5, 'Visual Communication', NULL, '2025-03-20 13:30:40', 5, 5),
(49, 'Agriculture Basics', 5, 'Farming Techniques', NULL, '2025-03-24 12:40:02', 5, 5),
(50, 'Plumbing and House Repairs', 5, 'Home Maintenance', NULL, '2025-03-26 22:48:13', 5, 5),
(51, 'Sports Rules and Strategies', 6, 'Basketball, Soccer, etc.', NULL, '2025-03-20 04:00:59', 5, 5),
(52, 'Fitness and Wellness', 6, 'Exercise Routines', NULL, '2025-03-20 23:40:16', 5, 5),
(53, 'Yoga and Mindfulness', 6, 'Meditation and Relaxation', NULL, '2025-03-24 10:18:23', 5, 5),
(54, 'Anatomy for Athletes', 6, 'Muscles and Movements', NULL, '2025-03-25 04:31:10', 5, 5),
(55, 'Strength Training', 6, 'Weightlifting Basics', NULL, '2025-03-25 15:40:39', 5, 5),
(56, 'Cardiovascular Health', 6, 'Running and Aerobics', NULL, '2025-03-25 16:49:47', 5, 5),
(57, 'Martial Arts Guide', 6, 'Self-Defense Techniques', NULL, '2025-03-24 13:06:58', 5, 5),
(58, 'Nutrition for Athletes', 6, 'Diet and Performance', NULL, '2025-03-25 15:05:30', 5, 5),
(59, 'Outdoor Recreation', 6, 'Hiking and Camping', NULL, '2025-03-20 12:06:35', 5, 5),
(60, 'Teamwork in Sports', 6, 'Communication and Strategy', NULL, '2025-03-26 15:16:25', 5, 5),
(61, 'Kasaysayan ng Pilipinas', 7, 'Historical Events', NULL, '2025-03-23 16:02:20', 5, 5),
(62, 'Sibika at Kultura', 7, 'Traditions and Customs', NULL, '2025-03-25 10:22:25', 5, 5),
(63, 'World History', 7, 'Ancient Civilizations', NULL, '2025-03-22 03:45:08', 5, 5),
(64, 'Economic Development', 7, 'Trade and Industry', NULL, '2025-03-21 11:38:24', 5, 5),
(65, 'Political Science', 7, 'Government and Laws', NULL, '2025-03-20 22:56:37', 5, 5),
(66, 'Global Issues', 7, 'Poverty and Climate Change', NULL, '2025-03-20 07:47:54', 5, 5),
(67, 'Philippine Geography', 7, 'Regions and Provinces', NULL, '2025-03-25 18:09:39', 5, 5),
(68, 'Sociology and Culture', 7, 'Human Interactions', NULL, '2025-03-26 19:24:35', 5, 5),
(69, 'Social Movements', 7, 'Revolutions and Reforms', NULL, '2025-03-22 18:33:59', 5, 5),
(70, 'Contemporary Issues', 7, 'Modern Social Challenges', NULL, '2025-03-20 10:36:10', 5, 5),
(71, 'Values Formation', 8, 'Ethics and Morality', NULL, '2025-03-20 21:18:51', 5, 5),
(72, 'Character Development', 8, 'Building Integrity', NULL, '2025-03-23 02:45:48', 5, 5),
(73, 'Respect and Responsibility', 8, 'Social Ethics', NULL, '2025-03-25 21:52:26', 5, 5),
(74, 'Leadership and Service', 8, 'Helping Others', NULL, '2025-03-26 05:04:47', 5, 5),
(75, 'Family and Community', 8, 'Roles in Society', NULL, '2025-03-26 07:46:38', 5, 5),
(76, 'Decision Making and Consequences', 8, 'Ethical Choices', NULL, '2025-03-25 23:38:48', 5, 5),
(77, 'Love and Respect', 8, 'Healthy Relationships', NULL, '2025-03-23 22:54:05', 5, 5),
(78, 'Social Justice', 8, 'Fairness and Equality', NULL, '2025-03-21 19:34:04', 5, 5),
(79, 'Empathy and Kindness', 8, 'Understanding Others', NULL, '2025-03-24 05:08:06', 5, 5),
(80, 'Personal Growth', 8, 'Self-Improvement and Reflection', NULL, '2025-03-21 14:58:17', 5, 5);

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
(1, 'johnluizaustria@gmail.com', 'John Luiz S Austria', '670 Notanggi St. Darangan Binangonan, Rizal', '09362447121', 'M2022-0234', 'Emily White: The Sil', '2025-03-28', '2025-03-30', 'BSCS', 'Emily White'),
(2, 'johnluizaustria@gmail.com', 'John Luiz S Austria', '670 Notanggi St. Darangan Binangonan, Rizal', '09362447121', 'M2022-0234', 'Statistics for Begin', '2025-03-28', '2025-03-29', 'BSCS', 'Robert Brown'),
(3, 'dizon@gmail.com', 'Carlos Joseph Dizon', 'Teresa BANGBANG', '09224232424', 'B2022-0423', 'World Geography', '2025-03-28', '2025-03-29', 'BSIT', 'Marco Polo'),
(4, 'dizon@gmail.com', 'Carlos Joseph Dizon', 'Teresa BANGBANG', '09224232424', 'B2022-0423', 'Statistics for Begin', '2025-03-28', '2025-03-29', 'BSIT', 'Robert Brown'),
(5, 'kawtsun@gmail.com', 'Morpheus Francisco', 'Morong', '123', 'M2025-0005', 'Statistics for Begin', '2025-03-29', '2025-03-31', 'BSCS', 'Robert Brown');

-- --------------------------------------------------------

--
-- Stand-in structure for view `unified_books`
-- (See below for the actual view)
--
CREATE TABLE `unified_books` (
`id` int(11)
,`title` varchar(255)
,`source` varchar(13)
);

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
(2, 'morpheus', '$2y$10$ZIt/8G.Qx3t9kokHK8B0RO6YqU6Q8nbwl3k11Pg2twaAGuR9lPztu', 'morpheus@gmail.com', 'BSCS', 'M2025-0002', 'Morpheus', 'Morong', '123'),
(3, 'austria', '$2y$10$FfIfsHKTe20mPifUr5Hhaeh9GiMYUhV0iXd.v4seyf/GpPTOuA20.', 'johnluizaustria@gmail.com', 'BSCS', 'M2022-0234', 'John Luiz S Austria', '670 Notanggi St. Darangan Binangonan, Rizal', '09362447121'),
(4, 'dizon', '$2y$10$nJSJ0BVD0RB9Rlad5dsDYevFM5E16.XJNwHusCNLMDf5t8uPtKIcm', 'dizon@gmail.com', 'BSIT', 'B2022-0423', 'Carlos Joseph Dizon', 'Teresa BANGBANG', '09224232424'),
(5, 'Kawtsun', '$2y$10$qpedbbZhRdDO.HF.ViVv4ucEZ8Sr1ufld2nG4u4QF4aqCc.jxjM2q', 'kawtsun@gmail.com', 'BSCS', 'M2025-0005', 'Morpheus Francisco', 'Morong', '123'),
(6, 'Kita', '$2y$10$4Ci5NvVWudIPJQN38bTABuTBrBowIc3v/okMOkJOCr6avChzVmlZ.', 'kita@gmail.com', 'BSCS', 'M2025-0006', 'Ikuyo Kita', 'Japan', '123'),
(7, 'Chisato', '$2y$10$8HBOXBMvC1DFproX.dMYa.zA65JzMcHvwXWqJzOUTNjI7N3jxTSpq', 'chisato@gmail.com', 'BSCS', 'M2025-0007', 'Chisato Arashi', 'Japan', '123'),
(8, 'Momoka', '$2y$10$MviHDL/gXmTbBK89ofZ7peAknbEsYticaCy1QxfNR6J09O6xk//vq', 'momoka@gmail.com', 'BSCS', 'M2025-0008', 'Momoka Sakurai', 'Japan', '123'),
(9, 'Rika', '$2y$10$XiYJdIID2jcBxgjTOC6vZe9ieY43rjOVD/8mV4K1xNol.uVUbkpxu', 'rika@gmail.com', 'BSCS', 'M2025-0009', 'Rika Furude', 'Japan', '123');

-- --------------------------------------------------------

--
-- Structure for view `unified_books`
--
DROP TABLE IF EXISTS `unified_books`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `unified_books`  AS SELECT `books`.`id` AS `id`, `books`.`title` AS `title`, 'Books' AS `source` FROM `books`union all select `library_books`.`id` AS `id`,`library_books`.`title` AS `title`,'Library Books' AS `source` from `library_books`  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `author_books`
--
ALTER TABLE `author_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `library_books`
--
ALTER TABLE `library_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `author_books`
--
ALTER TABLE `author_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `library_books`
--
ALTER TABLE `library_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `library_books`
--
ALTER TABLE `library_books`
  ADD CONSTRAINT `library_books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
