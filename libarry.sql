-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2025 at 01:25 PM
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
(1, 'John Doe: The Quantum Paradox', 'John Doe', 'Science Fiction', 2023, '2025-03-31 05:21:29', 5, 5),
(2, 'John Doe: Echoes of Eternity', 'John Doe', 'Fantasy', 2022, '2025-04-01 16:30:37', 5, 5),
(3, 'John Doe: Silent Shadows', 'John Doe', 'Mystery', 2021, '2025-04-01 01:28:18', 5, 5),
(4, 'John Doe: Crimson Tide', 'John Doe', 'Thriller', 2020, '2025-04-01 23:22:24', 5, 4),
(5, 'John Doe: A Tale of Two Worlds', 'John Doe', 'Adventure', 2019, '2025-03-29 22:50:52', 5, 5),
(6, 'John Doe: The Lost City', 'John Doe', 'Historical Fiction', 2018, '2025-03-31 07:45:01', 5, 5),
(7, 'John Doe: Whispers of the Wind', 'John Doe', 'Poetry', 2023, '2025-03-31 13:37:26', 5, 5),
(8, 'John Doe: The Final Curtain', 'John Doe', 'Drama', 2022, '2025-03-31 21:06:18', 5, 5),
(9, 'John Doe: Starlight Symphony', 'John Doe', 'Romance', 2021, '2025-03-29 14:22:57', 5, 5),
(10, 'John Doe: Beyond the Horizon', 'John Doe', 'Science Fiction', 2020, '2025-03-29 11:19:15', 5, 5),
(11, 'Jane Smith: The Enigma Code', 'Jane Smith', 'Mystery', 2023, '2025-03-30 13:39:25', 5, 5),
(12, 'Jane Smith: Beneath the Surface', 'Jane Smith', 'Thriller', 2022, '2025-03-28 13:35:41', 5, 5),
(13, 'Jane Smith: The River\'s Secret', 'Jane Smith', 'Adventure', 2021, '2025-03-31 15:23:18', 5, 5),
(14, 'Jane Smith: A Journey Through Time', 'Jane Smith', 'Historical Fiction', 2020, '2025-03-29 02:01:35', 5, 4),
(15, 'Jane Smith: Melodies of the Heart', 'Jane Smith', 'Romance', 2023, '2025-04-01 20:00:32', 5, 5),
(16, 'Jane Smith: Galactic Explorers', 'Jane Smith', 'Science Fiction', 2022, '2025-03-31 01:56:03', 5, 5),
(17, 'Jane Smith: Realm of the Dragons', 'Jane Smith', 'Fantasy', 2021, '2025-03-29 00:40:06', 5, 5),
(18, 'Jane Smith: Poetry of the Soul', 'Jane Smith', 'Poetry', 2020, '2025-03-29 19:17:38', 5, 5),
(19, 'Jane Smith: The Stage is Set', 'Jane Smith', 'Drama', 2023, '2025-04-01 00:34:08', 5, 5),
(20, 'Jane Smith: Echoes of the Past', 'Jane Smith', 'Historical Fiction', 2022, '2025-03-30 05:10:02', 5, 5),
(21, 'Robert Brown: The Lost Artifact', 'Robert Brown', 'Adventure', 2023, '2025-03-31 21:03:31', 5, 5),
(22, 'Robert Brown: Shadows of Deception', 'Robert Brown', 'Mystery', 2022, '2025-03-29 17:36:43', 5, 5),
(23, 'Robert Brown: The Last Stand', 'Robert Brown', 'Thriller', 2021, '2025-04-01 01:05:50', 5, 5),
(24, 'Robert Brown: Symphony of Stars', 'Robert Brown', 'Science Fiction', 2020, '2025-03-31 06:20:35', 5, 5),
(25, 'Robert Brown: Tales of the Forgotten', 'Robert Brown', 'Fantasy', 2023, '2025-03-29 14:38:41', 5, 5),
(26, 'Robert Brown: The Poet\'s Muse', 'Robert Brown', 'Poetry', 2022, '2025-03-29 05:09:54', 5, 5),
(27, 'Robert Brown: Curtain Call', 'Robert Brown', 'Drama', 2021, '2025-03-30 14:19:52', 5, 5),
(28, 'Robert Brown: Heart\'s Desire', 'Robert Brown', 'Romance', 2020, '2025-03-31 09:48:21', 5, 5),
(29, 'Robert Brown: Chronicles of the Ancients', 'Robert Brown', 'Historical Fiction', 2023, '2025-03-28 09:20:07', 5, 5),
(30, 'Robert Brown: Voyage to the Unknown', 'Robert Brown', 'Science Fiction', 2022, '2025-03-30 17:07:02', 5, 5),
(31, 'Albert Newton: The Cosmic Equation', 'Albert Newton', 'Science Fiction', 2023, '2025-04-01 01:12:42', 5, 5),
(32, 'Albert Newton: Riddle of the Sphinx', 'Albert Newton', 'Mystery', 2022, '2025-03-31 12:58:12', 5, 5),
(33, 'Albert Newton: Edge of Tomorrow', 'Albert Newton', 'Thriller', 2021, '2025-03-30 19:31:37', 5, 5),
(34, 'Albert Newton: Saga of the Elven Lords', 'Albert Newton', 'Fantasy', 2020, '2025-03-31 14:17:00', 5, 5),
(35, 'Albert Newton: The Wanderer\'s Path', 'Albert Newton', 'Adventure', 2023, '2025-03-28 23:38:26', 5, 5),
(36, 'Albert Newton: Timeless Love', 'Albert Newton', 'Romance', 2022, '2025-03-30 08:37:27', 5, 5),
(37, 'Albert Newton: The Bard\'s Legacy', 'Albert Newton', 'Poetry', 2021, '2025-03-30 23:05:37', 5, 5),
(38, 'Albert Newton: The Stagehand\'s Dream', 'Albert Newton', 'Drama', 2020, '2025-03-30 01:09:46', 5, 5),
(39, 'Albert Newton: Secrets of the Pharaohs', 'Albert Newton', 'Historical Fiction', 2023, '2025-03-30 06:15:01', 5, 5),
(40, 'Albert Newton: Beyond the Stars', 'Albert Newton', 'Science Fiction', 2022, '2025-04-01 12:17:27', 5, 5),
(41, 'Marie Curie: The Radioactive Legacy', 'Marie Curie', 'Science Fiction', 2023, '2025-04-01 09:16:30', 5, 5),
(42, 'Marie Curie: The Alchemist\'s Secret', 'Marie Curie', 'Mystery', 2022, '2025-04-01 17:36:36', 5, 5),
(43, 'Marie Curie: Countdown to Zero', 'Marie Curie', 'Thriller', 2021, '2025-03-31 11:06:58', 5, 5),
(44, 'Marie Curie: Guardians of the Realm', 'Marie Curie', 'Fantasy', 2020, '2025-03-28 04:43:06', 5, 5),
(45, 'Marie Curie: The Explorer\'s Journal', 'Marie Curie', 'Adventure', 2023, '2025-03-31 13:36:11', 5, 5),
(46, 'Marie Curie: Love in the Time of Cholera', 'Marie Curie', 'Romance', 2022, '2025-04-01 23:59:43', 5, 5),
(47, 'Marie Curie: The Poet\'s Canvas', 'Marie Curie', 'Poetry', 2021, '2025-03-28 21:29:03', 5, 5),
(48, 'Marie Curie: The Actor\'s Journey', 'Marie Curie', 'Drama', 2020, '2025-04-01 00:14:36', 5, 5),
(49, 'Marie Curie: The Roman Empire', 'Marie Curie', 'Historical Fiction', 2023, '2025-03-29 03:15:52', 5, 5),
(50, 'Marie Curie: To the Edge of the Universe', 'Marie Curie', 'Science Fiction', 2022, '2025-04-01 11:50:04', 5, 5),
(51, 'Charles Darwin: The Evolutionary Enigma', 'Charles Darwin', 'Science Fiction', 2023, '2025-03-30 03:28:41', 5, 5),
(52, 'Charles Darwin: The Hidden Clues', 'Charles Darwin', 'Mystery', 2022, '2025-03-28 07:34:16', 5, 5),
(53, 'Charles Darwin: The Final Descent', 'Charles Darwin', 'Thriller', 2021, '2025-03-28 16:33:11', 5, 5),
(54, 'Charles Darwin: The Dragon\'s Lair', 'Charles Darwin', 'Fantasy', 2020, '2025-03-28 06:22:08', 5, 5),
(55, 'Charles Darwin: The Lost Expedition', 'Charles Darwin', 'Adventure', 2023, '2025-03-28 20:01:53', 5, 5),
(56, 'Charles Darwin: Love\'s Eternal Flame', 'Charles Darwin', 'Romance', 2022, '2025-03-31 11:16:40', 5, 5),
(57, 'Charles Darwin: The Poet\'s Quill', 'Charles Darwin', 'Poetry', 2021, '2025-04-01 09:59:46', 5, 5),
(58, 'Charles Darwin: The Director\'s Cut', 'Charles Darwin', 'Drama', 2020, '2025-03-28 16:25:41', 5, 5),
(59, 'Charles Darwin: The Age of Discovery', 'Charles Darwin', 'Historical Fiction', 2023, '2025-04-01 06:10:03', 5, 5),
(60, 'Charles Darwin: Journey to the Stars', 'Charles Darwin', 'Science Fiction', 2022, '2025-03-31 17:19:57', 5, 5),
(61, 'Emily White: The Vanishing Act', 'Emily White', 'Mystery', 2023, '2025-03-30 09:48:42', 5, 5),
(62, 'Emily White: The Silent Witness', 'Emily White', 'Thriller', 2022, '2025-03-30 06:25:43', 5, 5),
(63, 'Emily White: The Treasure Hunt', 'Emily White', 'Adventure', 2021, '2025-04-01 09:50:34', 5, 5),
(64, 'Emily White: A Love Story', 'Emily White', 'Romance', 2020, '2025-03-30 09:09:26', 5, 5),
(65, 'Emily White: The Poet\'s Heart', 'Emily White', 'Poetry', 2023, '2025-03-29 13:24:09', 5, 5),
(66, 'Emily White: The Playwright', 'Emily White', 'Drama', 2022, '2025-03-31 04:14:09', 5, 5),
(67, 'Emily White: The Viking Age', 'Emily White', 'Historical Fiction', 2021, '2025-03-30 07:51:28', 5, 5),
(68, 'Emily White: The Stellar Odyssey', 'Emily White', 'Science Fiction', 2020, '2025-04-01 15:10:46', 5, 5),
(69, 'Emily White: The Enchanted Forest', 'Emily White', 'Fantasy', 2023, '2025-03-29 01:41:23', 5, 5),
(70, 'Emily White: The Lost City of Gold', 'Emily White', 'Adventure', 2022, '2025-03-28 15:29:19', 5, 5),
(71, 'William S: The Shakespearean Mystery', 'William S', 'Mystery', 2023, '2025-03-31 15:04:35', 5, 5),
(72, 'William S: The Bard\'s Revenge', 'William S', 'Thriller', 2022, '2025-03-28 03:03:19', 5, 5),
(73, 'William S: The Globe Theatre', 'William S', 'Drama', 2021, '2025-03-31 18:21:49', 5, 5),
(74, 'William S: A Midsummer Night\'s Dream', 'William S', 'Romance', 2020, '2025-04-01 09:24:51', 5, 5),
(75, 'William S: The Poet\'s Sonnets', 'William S', 'Poetry', 2023, '2025-03-28 13:35:59', 5, 5),
(76, 'William S: The Elizabethan Era', 'William S', 'Historical Fiction', 2022, '2025-03-29 05:40:09', 5, 5),
(77, 'William S: The Tragedy of Hamlet, Prince of Denmark', 'William S', 'Drama', 2021, '2025-03-28 09:18:55', 5, 5),
(78, 'William S: Romeo and Juliet', 'William S', 'Romance', 2020, '2025-04-01 05:58:17', 5, 5),
(79, 'William S: Macbeth', 'William S', 'Drama', 2023, '2025-03-30 05:37:09', 5, 5),
(80, 'William S: Othello, the Moor of Venice', 'William S', 'Drama', 2022, '2025-03-29 05:01:14', 5, 5),
(81, 'William S: King Lear', 'William S', 'Drama', 2021, '2025-04-01 20:49:20', 5, 5),
(82, 'Ernest H: The Old Man and the Sea', 'Ernest H', 'Adventure', 2023, '2025-03-31 14:26:16', 5, 5),
(83, 'Ernest H: A Farewell to Arms', 'Ernest H', 'Romance', 2022, '2025-03-28 14:55:06', 5, 5),
(84, 'Ernest H: The Sun Also Rises', 'Ernest H', 'Historical Fiction', 2021, '2025-04-01 09:30:44', 5, 5),
(85, 'Ernest H: For Whom the Bell Tolls', 'Ernest H', 'Thriller', 2020, '2025-03-30 22:27:57', 5, 5),
(86, 'Ernest H: The Poet\'s War', 'Ernest H', 'Poetry', 2023, '2025-03-30 05:14:43', 5, 5),
(87, 'Ernest H: The Playwright\'s Life', 'Ernest H', 'Drama', 2020, '2025-04-01 17:28:05', 5, 5),
(88, 'Ernest H: The Spanish Civil War', 'Ernest H', 'Historical Fiction', 2023, '2025-03-28 20:41:04', 5, 5),
(89, 'Ernest H: The Lost Generation', 'Ernest H', 'Historical Fiction', 2022, '2025-03-29 19:47:39', 5, 5),
(90, 'Ernest H: To Have and Have Not', 'Ernest H', 'Adventure', 2021, '2025-03-29 21:55:56', 5, 5),
(91, 'Ernest H: Death in the Afternoon', 'Ernest H', 'Non-fiction', 2020, '2025-03-31 22:33:48', 5, 5),
(92, 'Jose Corazon: Ang Bayan Ko', 'Jose Corazon', 'Poetry', 2023, '2025-03-30 15:18:56', 5, 5),
(93, 'Jose Corazon: Isang Punongkahoy', 'Jose Corazon', 'Poetry', 2022, '2025-03-31 15:55:33', 5, 5),
(94, 'Jose Corazon: Ang Pagbabalik', 'Jose Corazon', 'Poetry', 2021, '2025-03-28 20:45:08', 5, 5),
(95, 'Jose Corazon: Mga Dahong Ginto', 'Jose Corazon', 'Poetry', 2020, '2025-04-01 10:57:39', 5, 5),
(96, 'Jose Corazon: Sa Dakong Silangan', 'Jose Corazon', 'Poetry', 2023, '2025-04-01 21:29:07', 5, 5),
(97, 'Jose Corazon: Ang Araw', 'Jose Corazon', 'Poetry', 2022, '2025-04-01 21:34:34', 5, 5),
(98, 'Jose Corazon: Ang Guryon', 'Jose Corazon', 'Poetry', 2021, '2025-03-31 00:34:41', 5, 5),
(99, 'Jose Corazon: Mga Tinik ng Puso', 'Jose Corazon', 'Poetry', 2020, '2025-04-01 08:48:08', 5, 5),
(100, 'Jose Corazon: Ang Mga Ibon', 'Jose Corazon', 'Poetry', 2023, '2025-03-28 18:02:23', 5, 5),
(101, 'Jose Corazon: Ang Pangarap', 'Jose Corazon', 'Poetry', 2022, '2025-03-29 23:32:12', 5, 5),
(102, 'Francisco Balagtas: Florante at Laura', 'Francisco Balagtas', 'Filipino', 2023, '2025-03-28 20:50:26', 5, 5),
(103, 'Francisco Balagtas: Orosman at Zafira', 'Francisco Balagtas', 'Filipino', 2022, '2025-04-01 16:08:27', 5, 5),
(104, 'Francisco Balagtas: Abdal at Misarela', 'Francisco Balagtas', 'Filipino', 2021, '2025-03-31 23:06:39', 5, 5),
(105, 'Francisco Balagtas: Clara Belmonte', 'Francisco Balagtas', 'Filipino', 2020, '2025-03-30 05:50:20', 5, 5),
(106, 'Francisco Balagtas: La India Elegante y el Negrito Amante', 'Francisco Balagtas', 'Filipino', 2023, '2025-04-01 22:56:32', 5, 5),
(107, 'Francisco Balagtas: Mahomet at Constanza', 'Francisco Balagtas', 'Filipino', 2022, '2025-04-01 23:21:12', 5, 5),
(108, 'Francisco Balagtas: Rodolfo at Rosamunda', 'Francisco Balagtas', 'Filipino', 2021, '2025-04-01 21:14:11', 5, 5),
(109, 'Francisco Balagtas: Almanzor at Rosalina', 'Francisco Balagtas', 'Filipino', 2020, '2025-03-30 01:18:39', 5, 5),
(110, 'Francisco Balagtas: Bayaceto at Dorlisca', 'Francisco Balagtas', 'Filipino', 2023, '2025-03-31 01:46:52', 5, 5),
(111, 'Francisco Balagtas: Don Nuño at Zelinda', 'Francisco Balagtas', 'Filipino', 2022, '2025-03-30 22:02:35', 5, 5),
(112, 'Andres Bonifacio: Pag-ibig sa Tinubuang Lupa', 'Andres Bonifacio', 'Filipino', 2023, '2025-03-29 18:47:17', 5, 5),
(113, 'Andres Bonifacio: Katapusang Hibik ng Pilipinas', 'Andres Bonifacio', 'Filipino', 2022, '2025-04-01 14:35:19', 5, 5),
(114, 'Andres Bonifacio: Ang Dapat Mabatid ng mga Tagalog', 'Andres Bonifacio', 'Filipino', 2021, '2025-03-28 12:05:35', 5, 5),
(115, 'Andres Bonifacio: Tapunan ng Lingap', 'Andres Bonifacio', 'Filipino', 2020, '2025-03-29 02:28:08', 5, 5),
(116, 'Andres Bonifacio: Katungkulan Gagawin ng mga Anak ng Bayan', 'Andres Bonifacio', 'Filipino', 2023, '2025-03-30 10:04:31', 5, 5),
(117, 'Andres Bonifacio: Dekalogo', 'Andres Bonifacio', 'Filipino', 2022, '2025-03-30 01:12:42', 5, 5),
(118, 'Andres Bonifacio: Mi Ultimo Adios', 'Andres Bonifacio', 'Filipino', 2021, '2025-04-01 04:20:33', 5, 5),
(119, 'Andres Bonifacio: Ang Mga Cazadores', 'Andres Bonifacio', 'Filipino', 2020, '2025-03-29 23:36:20', 5, 5),
(120, 'Andres Bonifacio: Huling Paalam', 'Andres Bonifacio', 'Filipino', 2023, '2025-03-28 01:25:24', 5, 5),
(121, 'Andres Bonifacio: Liwanag at Dilim', 'Andres Bonifacio', 'Filipino', 2022, '2025-03-29 06:35:40', 5, 5),
(122, 'Chef Gordon: Gordon Ramsay\'s Home Cooking', 'Chef Gordon', 'TLE', 2023, '2025-03-30 16:29:08', 5, 5),
(123, 'Chef Gordon: Humble Pie', 'Chef Gordon', 'TLE', 2022, '2025-04-01 13:52:36', 5, 5),
(124, 'Chef Gordon: Playing with Fire', 'Chef Gordon', 'TLE', 2021, '2025-03-28 19:17:10', 5, 5),
(125, 'Chef Gordon: Roasting in Hell\'s Kitchen', 'Chef Gordon', 'TLE', 2020, '2025-03-31 01:32:48', 5, 5),
(126, 'Chef Gordon: Fast Food', 'Chef Gordon', 'TLE', 2023, '2025-03-29 23:48:50', 5, 5),
(127, 'Chef Gordon: World Kitchen', 'Chef Gordon', 'TLE', 2022, '2025-03-29 06:32:40', 5, 5),
(128, 'Chef Gordon: Bread Street Kitchen', 'Chef Gordon', 'TLE', 2021, '2025-03-31 06:01:21', 5, 5),
(129, 'Chef Gordon: Ultimate Home Cooking', 'Chef Gordon', 'TLE', 2020, '2025-03-30 07:31:39', 5, 5),
(130, 'Chef Gordon: 3 Star Chef', 'Chef Gordon', 'TLE', 2023, '2025-03-29 16:49:16', 5, 5),
(131, 'Chef Gordon: Ramsay in 10', 'Chef Gordon', 'TLE', 2022, '2025-03-30 11:51:21', 5, 5),
(132, 'Mark Cuban: How to Win at the Sport of Business', 'Mark Cuban', 'TLE', 2023, '2025-04-01 01:52:13', 5, 5),
(133, 'Mark Cuban: Shark Tank Jump Start Your Business', 'Mark Cuban', 'TLE', 2022, '2025-03-31 00:50:13', 5, 5),
(134, 'Mark Cuban: The Mavericks Way', 'Mark Cuban', 'TLE', 2021, '2025-03-29 23:04:12', 5, 5),
(135, 'Mark Cuban: Be Your Own Boss', 'Mark Cuban', 'TLE', 2020, '2025-03-28 22:47:55', 5, 5),
(136, 'Mark Cuban: Entrepreneurial Mindset', 'Mark Cuban', 'TLE', 2023, '2025-03-29 09:32:42', 5, 5),
(137, 'Mark Cuban: 12 Rules for Startups', 'Mark Cuban', 'TLE', 2022, '2025-03-29 00:10:05', 5, 5),
(138, 'Mark Cuban: The Business of Sports', 'Mark Cuban', 'TLE', 2021, '2025-03-29 13:17:26', 5, 5),
(139, 'Mark Cuban: Investing for Dummies', 'Mark Cuban', 'TLE', 2020, '2025-04-01 11:00:37', 5, 5),
(140, 'Mark Cuban: The Billionaire Blueprint', 'Mark Cuban', 'TLE', 2023, '2025-04-01 17:34:52', 5, 5),
(141, 'Mark Cuban: From Rags to Riches', 'Mark Cuban', 'TLE', 2022, '2025-03-28 18:56:58', 5, 5),
(142, 'Steve Jobs: Steve Jobs', 'Steve Jobs', 'TLE', 2023, '2025-03-29 09:48:44', 5, 5),
(143, 'Steve Jobs: The Second Coming of Steve Jobs', 'Steve Jobs', 'TLE', 2022, '2025-04-01 15:53:15', 5, 5),
(144, 'Steve Jobs: iCon Steve Jobs', 'Steve Jobs', 'TLE', 2021, '2025-03-29 21:33:16', 5, 5),
(145, 'Steve Jobs: Becoming Steve Jobs', 'Steve Jobs', 'TLE', 2020, '2025-03-29 02:32:58', 5, 5),
(146, 'Steve Jobs: The Steve Jobs Way', 'Steve Jobs', 'TLE', 2023, '2025-03-30 22:27:06', 5, 5),
(147, 'Steve Jobs: Inside Steve\'s Brain', 'Steve Jobs', 'TLE', 2022, '2025-03-29 19:38:15', 5, 5),
(148, 'Steve Jobs: What Would Steve Jobs Do?', 'Steve Jobs', 'TLE', 2021, '2025-03-28 03:02:54', 5, 5),
(149, 'Steve Jobs: The Presentation Secrets of Steve Jobs', 'Steve Jobs', 'TLE', 2020, '2025-03-29 01:10:54', 5, 5),
(150, 'Steve Jobs: Steve Jobs and the Next Big Thing', 'Steve Jobs', 'TLE', 2023, '2025-03-29 19:01:03', 5, 5),
(151, 'Steve Jobs: The Innovation Secrets of Steve Jobs', 'Steve Jobs', 'TLE', 2022, '2025-03-31 14:41:54', 5, 5),
(152, 'Arnold Fitman: The Encyclopedia of Modern Bodybuilding', 'Arnold Fitman', 'Physical Education', 2023, '2025-03-31 12:06:53', 5, 5),
(153, 'Arnold Fitman: Total Recall', 'Arnold Fitman', 'Physical Education', 2022, '2025-03-30 01:53:47', 5, 5),
(154, 'Arnold Fitman: New Encyclopedia of Modern Bodybuilding', 'Arnold Fitman', 'Physical Education', 2021, '2025-04-01 22:59:53', 5, 5),
(155, 'Arnold Fitman: Education of a Bodybuilder', 'Arnold Fitman', 'Physical Education', 2020, '2025-03-29 11:53:58', 5, 5),
(156, 'Arnold Fitman: Pumping Iron', 'Arnold Fitman', 'Physical Education', 2023, '2025-03-31 19:06:23', 5, 5),
(157, 'Arnold Fitman: The Fitness Bible', 'Arnold Fitman', 'Physical Education', 2022, '2025-03-28 15:55:44', 5, 5),
(158, 'Arnold Fitman: Strength Training Anatomy', 'Arnold Fitman', 'Physical Education', 2021, '2025-03-29 10:41:38', 5, 5),
(159, 'Arnold Fitman: The 7-Minute Body', 'Arnold Fitman', 'Physical Education', 2020, '2025-03-29 11:49:22', 5, 5),
(160, 'Arnold Fitman: The Body Sculpting Bible for Women', 'Arnold Fitman', 'Physical Education', 2023, '2025-03-29 08:23:19', 5, 5),
(161, 'Arnold Fitman: The Encyclopedia of Modern Bodybuilding', 'Arnold Fitman', 'Physical Education', 2022, '2025-03-31 04:58:43', 5, 5),
(162, 'Michael Jordan: Driven from Within', 'Michael Jordan', 'Physical Education', 2023, '2025-03-28 19:05:45', 5, 5),
(163, 'Michael Jordan: I Can\'t Accept Not Trying', 'Michael Jordan', 'Physical Education', 2022, '2025-03-31 06:01:00', 5, 5),
(164, 'Michael Jordan: Rare Air', 'Michael Jordan', 'Physical Education', 2021, '2025-03-28 14:27:16', 5, 5),
(165, 'Michael Jordan: Playing for Keeps', 'Michael Jordan', 'Physical Education', 2020, '2025-03-31 04:29:04', 5, 5),
(166, 'Michael Jordan: Hang Time', 'Michael Jordan', 'Physical Education', 2023, '2025-03-30 03:07:08', 5, 5),
(167, 'Michael Jordan: Michael Jordan: The Life', 'Michael Jordan', 'Physical Education', 2022, '2025-03-28 18:53:52', 5, 5),
(168, 'Michael Jordan: Jumpman', 'Michael Jordan', 'Physical Education', 2021, '2025-04-01 18:59:21', 5, 5),
(169, 'Michael Jordan: The Last Dance', 'Michael Jordan', 'Physical Education', 2020, '2025-03-30 22:43:01', 5, 5),
(170, 'Michael Jordan: Be Like Mike', 'Michael Jordan', 'Physical Education', 2023, '2025-03-29 20:43:20', 5, 5),
(171, 'Michael Jordan: Winning', 'Michael Jordan', 'Physical Education', 2022, '2025-03-29 21:16:19', 5, 5),
(172, 'Carlos Garcia: Philippine History', 'Carlos Garcia', 'Araling Panlipunan', 2023, '2025-03-30 01:40:11', 5, 5),
(173, 'Carlos Garcia: A Nation for Our Children', 'Carlos Garcia', 'Araling Panlipunan', 2022, '2025-03-31 08:16:29', 5, 5),
(174, 'Carlos Garcia: The Filipino First Policy', 'Carlos Garcia', 'Araling Panlipunan', 2021, '2025-03-30 22:11:44', 5, 5),
(175, 'Carlos Garcia: The Austerity Program', 'Carlos Garcia', 'Araling Panlipunan', 2020, '2025-04-01 11:14:35', 5, 5),
(176, 'Carlos Garcia: The Bohlen-Serrano Agreement', 'Carlos Garcia', 'Araling Panlipunan', 2023, '2025-03-31 13:51:33', 5, 5),
(177, 'Carlos Garcia: The Laurel-Langley Agreement', 'Carlos Garcia', 'Araling Panlipunan', 2022, '2025-03-30 18:08:13', 5, 5),
(178, 'Carlos Garcia: The Garcia Doctrine', 'Carlos Garcia', 'Araling Panlipunan', 2021, '2025-03-29 03:52:16', 5, 5),
(179, 'Carlos Garcia: The Garcia Administration', 'Carlos Garcia', 'Araling Panlipunan', 2020, '2025-04-01 06:19:20', 5, 5),
(180, 'Carlos Garcia: The Philippine Economy', 'Carlos Garcia', 'Araling Panlipunan', 2023, '2025-03-30 13:16:51', 5, 5),
(181, 'Carlos Garcia: The Philippine Politics', 'Carlos Garcia', 'Araling Panlipunan', 2022, '2025-03-29 03:26:24', 5, 5),
(182, 'Marco Polo: The Travels of Marco Polo', 'Marco Polo', 'Araling Panlipunan', 2023, '2025-03-31 17:50:00', 5, 5),
(183, 'Marco Polo: Description of the World', 'Marco Polo', 'Araling Panlipunan', 2022, '2025-04-01 19:52:29', 5, 5),
(184, 'Marco Polo: The Silk Road', 'Marco Polo', 'Araling Panlipunan', 2021, '2025-03-31 01:07:21', 5, 5),
(185, 'Marco Polo: Kublai Khan', 'Marco Polo', 'Araling Panlipunan', 2020, '2025-03-28 10:27:16', 5, 5),
(186, 'Marco Polo: The Mongol Empire', 'Marco Polo', 'Araling Panlipunan', 2023, '2025-04-01 20:32:06', 5, 5),
(187, 'Marco Polo: The Venetian Merchant', 'Marco Polo', 'Araling Panlipunan', 2022, '2025-03-31 08:04:35', 5, 5),
(188, 'Marco Polo: The Asian Trade', 'Marco Polo', 'Araling Panlipunan', 2021, '2025-03-29 16:38:21', 5, 5),
(189, 'Marco Polo: The Exploration of the East', 'Marco Polo', 'Araling Panlipunan', 2020, '2025-03-30 03:27:23', 5, 5),
(190, 'Marco Polo: The Cultural Exchange', 'Marco Polo', 'Araling Panlipunan', 2023, '2025-03-29 11:55:06', 5, 5),
(191, 'Marco Polo: The Geographical Discoveries', 'Marco Polo', 'Araling Panlipunan', 2022, '2025-03-29 03:20:40', 5, 5),
(192, 'Dr. John Ethics: Ethics in the Modern World', 'Dr. John Ethics', 'ESP', 2023, '2025-03-31 04:16:44', 5, 5),
(193, 'Dr. John Ethics: The Principles of Morality', 'Dr. John Ethics', 'ESP', 2022, '2025-03-31 03:12:03', 5, 5),
(194, 'Dr. John Ethics: Moral Philosophy', 'Dr. John Ethics', 'ESP', 2021, '2025-03-30 22:18:26', 5, 5),
(195, 'Dr. John Ethics: Applied Ethics', 'Dr. John Ethics', 'ESP', 2020, '2025-03-29 11:01:56', 5, 5),
(196, 'Dr. John Ethics: Ethical Dilemmas', 'Dr. John Ethics', 'ESP', 2023, '2025-03-30 08:50:56', 5, 5),
(197, 'Dr. John Ethics: The Foundations of Ethics', 'Dr. John Ethics', 'ESP', 2022, '2025-03-28 20:50:28', 5, 5),
(198, 'Dr. John Ethics: Business Ethics', 'Dr. John Ethics', 'ESP', 2021, '2025-03-31 04:20:31', 5, 5),
(199, 'Dr. John Ethics: Environmental Ethics', 'Dr. John Ethics', 'ESP', 2020, '2025-03-31 14:55:47', 5, 5),
(200, 'Dr. John Ethics: Medical Ethics', 'Dr. John Ethics', 'ESP', 2023, '2025-03-29 04:35:13', 5, 5),
(201, 'Dr. John Ethics: Social Ethics', 'Dr. John Ethics', 'ESP', 2022, '2025-03-29 00:47:09', 5, 5),
(202, 'Xavier Morals: Moral Development', 'Xavier Morals', 'ESP', 2023, '2025-03-29 21:39:01', 5, 5),
(203, 'Xavier Morals: The Psychology of Morality', 'Xavier Morals', 'ESP', 2022, '2025-04-01 20:17:09', 5, 5),
(204, 'Xavier Morals: Moral Reasoning', 'Xavier Morals', 'ESP', 2021, '2025-03-30 22:34:36', 5, 5),
(205, 'Xavier Morals: Moral Education', 'Xavier Morals', 'ESP', 2020, '2025-03-29 06:23:14', 5, 5),
(206, 'Xavier Morals: Moral Values', 'Xavier Morals', 'ESP', 2023, '2025-03-31 14:10:13', 5, 5),
(207, 'Xavier Morals: The Development of Conscience', 'Xavier Morals', 'ESP', 2022, '2025-04-01 19:44:52', 5, 5),
(208, 'Xavier Morals: Moral Identity', 'Xavier Morals', 'ESP', 2021, '2025-03-29 07:40:48', 5, 5),
(209, 'Xavier Morals: Moral Character', 'Xavier Morals', 'ESP', 2020, '2025-03-30 16:11:33', 5, 5),
(210, 'Xavier Morals: Moral Competence', 'Xavier Morals', 'ESP', 2023, '2025-03-31 22:32:16', 5, 5),
(211, 'Xavier Morals: Moral Judgment', 'Xavier Morals', 'ESP', 2022, '2025-03-29 18:29:20', 5, 5);

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
(35, 'Advanced Algebra', 'Mathematics', 'John Doe', 2020, '', NULL, '2025-03-28 10:31:43', 5, 3),
(36, 'Calculus Essentials', 'Mathematics', 'Jane Smith', 2019, '', NULL, '2025-03-28 00:22:42', 5, 3),
(37, 'Statistics for Beginners', 'Mathematics', 'Robert Brown', 2021, '', NULL, '2025-04-01 08:25:59', 5, 4),
(38, 'Physics for Everyone', 'Science', 'Albert Newton', 2018, '', NULL, '2025-03-28 12:49:31', 5, 3),
(39, 'The Wonders of Chemistry', 'Science', 'Marie Curie', 2022, '', NULL, '2025-03-29 23:47:10', 5, 4),
(40, 'Biology: The Living World', 'Science', 'Charles Darwin', 2023, '', NULL, '2025-04-01 00:30:29', 5, 5),
(41, 'Mastering Grammar', 'English', 'Emily White', 2020, '', NULL, '2025-03-28 11:34:46', 5, 5),
(42, 'Shakespeare’s Classics', 'English', 'William S.', 2017, '', NULL, '2025-03-28 23:26:21', 5, 5),
(43, 'Creative Writing Techniques', 'English', 'Ernest H.', 2021, '', NULL, '2025-03-31 05:07:44', 5, 5),
(44, 'Ibong Adarna', 'Filipino', 'Jose Corazon', 2015, '', NULL, '2025-03-28 06:29:52', 5, 5),
(45, 'Florante at Laura', 'Filipino', 'Francisco Balagtas', 2018, '', NULL, '2025-04-01 05:18:02', 5, 5),
(46, 'Mga Piling Tula', 'Filipino', 'Andres Bonifacio', 2022, '', NULL, '2025-03-31 18:13:55', 5, 5),
(47, 'Basic Cooking Techniques', 'TLE', 'Chef Gordon', 2020, '', NULL, '2025-03-31 10:42:19', 5, 5),
(48, 'Entrepreneurship 101', 'TLE', 'Mark Cuban', 2021, '', NULL, '2025-04-01 15:18:45', 5, 5),
(49, 'Computer Hardware Basics', 'TLE', 'Steve Jobs', 2022, '', NULL, '2025-03-29 02:35:34', 5, 5),
(50, 'Fitness and Health', 'Physical Education', 'Arnold Fitman', 2019, '', NULL, '2025-04-01 07:27:03', 5, 5),
(51, 'Sports Science Fundamentals', 'Physical Education', 'Michael Jordan', 2021, '', NULL, '2025-03-31 22:13:55', 5, 4),
(52, 'Philippine History', 'Araling Panlipunan', 'Carlos Garcia', 2016, '', NULL, '2025-03-29 19:20:58', 5, 3),
(53, 'World Geography', 'Araling Panlipunan', 'Marco Polo', 2020, '', NULL, '2025-03-28 23:33:09', 5, 5),
(54, 'Ethics and Morality', 'ESP', 'Dr. John Ethics', 2019, '', NULL, '2025-03-31 09:21:20', 5, 4),
(55, 'Character Development', 'ESP', 'Xavier Morals', 2022, '', NULL, '2025-04-01 13:47:00', 5, 4);

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
(1, 'Algebra Fundamentals', 1, 'Algebra', NULL, '2025-03-28 09:41:03', 5, 4),
(2, 'Geometry Basics', 1, 'Shapes and Theorems', NULL, '2025-04-01 11:56:55', 5, 5),
(3, 'Trigonometry Explained', 1, 'Angles and Functions', NULL, '2025-03-31 19:52:08', 5, 5),
(4, 'Probability & Statistics', 1, 'Data Analysis', NULL, '2025-03-28 05:58:27', 5, 5),
(5, 'Calculus for Beginners', 1, 'Derivatives and Integrals', NULL, '2025-04-01 06:41:22', 5, 5),
(6, 'Number Theory Essentials', 1, 'Prime Numbers and Patterns', NULL, '2025-04-01 01:20:01', 5, 5),
(7, 'Linear Algebra Concepts', 1, 'Vectors and Matrices', NULL, '2025-03-29 13:08:04', 5, 5),
(8, 'Mathematical Logic', 1, 'Proofs and Reasoning', NULL, '2025-03-31 21:33:14', 5, 5),
(9, 'Graph Theory Overview', 1, 'Networks and Paths', NULL, '2025-03-29 03:18:46', 5, 5),
(10, 'Advanced Calculus', 1, 'Multivariable Functions', NULL, '2025-03-30 12:57:35', 5, 5),
(11, 'Physics Fundamentals', 2, 'Motion and Forces', NULL, '2025-04-01 00:25:09', 5, 5),
(12, 'Chemistry Essentials', 2, 'Atoms and Molecules', NULL, '2025-03-29 11:19:43', 5, 5),
(13, 'Biology Overview', 2, 'Cells and Organisms', NULL, '2025-03-30 19:28:27', 5, 5),
(14, 'Earth Science', 2, 'Rocks and Minerals', NULL, '2025-03-31 04:03:13', 5, 5),
(15, 'Astronomy Basics', 2, 'Stars and Galaxies', NULL, '2025-03-31 21:45:05', 5, 5),
(16, 'Environmental Science', 2, 'Ecosystems and Conservation', NULL, '2025-03-30 16:47:39', 5, 5),
(17, 'Genetics and Evolution', 2, 'DNA and Heredity', NULL, '2025-03-28 03:19:49', 5, 5),
(18, 'Organic Chemistry', 2, 'Carbon Compounds', NULL, '2025-03-30 08:07:46', 5, 5),
(19, 'Electricity and Magnetism', 2, 'Current and Circuits', NULL, '2025-03-28 04:29:10', 5, 5),
(20, 'Thermodynamics', 2, 'Heat and Energy Transfer', NULL, '2025-04-01 12:04:20', 5, 5),
(21, 'Grammar and Composition', 3, 'Sentence Structure', NULL, '2025-03-28 20:59:58', 5, 5),
(22, 'Literature Classics', 3, 'Famous Novels', NULL, '2025-03-28 02:20:29', 5, 5),
(23, 'Creative Writing', 3, 'Poetry and Storytelling', NULL, '2025-03-28 23:29:40', 5, 5),
(24, 'Public Speaking', 3, 'Speech and Communication', NULL, '2025-03-31 17:19:23', 5, 5),
(25, 'Essay Writing', 3, 'Persuasive and Analytical Essays', NULL, '2025-03-30 21:41:13', 5, 5),
(26, 'Syntax and Semantics', 3, 'Language Analysis', NULL, '2025-03-29 16:08:52', 5, 5),
(27, 'English for Beginners', 3, 'Basic Vocabulary', NULL, '2025-03-30 15:37:36', 5, 4),
(28, 'Shakespearean Works', 3, 'Plays and Sonnets', NULL, '2025-03-31 07:34:47', 5, 5),
(29, 'Modern English Usage', 3, 'Idioms and Expressions', NULL, '2025-03-31 03:22:34', 5, 5),
(30, 'Critical Thinking in Literature', 3, 'Analyzing Texts', NULL, '2025-04-01 19:55:49', 5, 5),
(31, 'Panitikan ng Pilipinas', 4, 'Kwentong Bayan', NULL, '2025-03-31 12:17:30', 5, 5),
(32, 'Alamat at Mitolohiya', 4, 'Mga Sinaunang Kuwento', NULL, '2025-03-31 06:10:09', 5, 5),
(33, 'Balagtasan at Tula', 4, 'Pagsusuri ng Panitikan', NULL, '2025-03-28 06:35:36', 5, 5),
(34, 'Pagsulat ng Sanaysay', 4, 'Pagbuo ng Argumento', NULL, '2025-03-29 21:45:01', 5, 5),
(35, 'Wika at Gramatika', 4, 'Balarila at Kayarian ng Wika', NULL, '2025-03-30 17:55:08', 5, 5),
(36, 'Kasaysayan ng Wikang Filipino', 4, 'Pinagmulan at Pag-unlad', NULL, '2025-03-29 00:42:31', 5, 5),
(37, 'Maikling Kwento', 4, 'Mga Kwentong Bayan', NULL, '2025-03-29 20:11:43', 5, 5),
(38, 'Filipino Journalism', 4, 'Pamamahayag sa Filipino', NULL, '2025-03-28 17:20:00', 5, 5),
(39, 'Pagpapahalaga sa Panitikan', 4, 'Interpretasyon ng Akda', NULL, '2025-03-30 03:34:32', 5, 5),
(40, 'Modernong Panitikang Pilipino', 4, 'Mga Makabagong Akda', NULL, '2025-03-29 07:56:10', 5, 5),
(41, 'Basic Cooking', 5, 'Food Preparation', NULL, '2025-03-30 22:36:25', 5, 5),
(42, 'Entrepreneurship', 5, 'Starting a Business', NULL, '2025-04-01 22:06:34', 5, 5),
(43, 'Woodworking Techniques', 5, 'Carpentry Skills', NULL, '2025-03-31 00:37:12', 5, 5),
(44, 'Automotive Basics', 5, 'Car Maintenance', NULL, '2025-04-01 04:47:47', 5, 5),
(45, 'Information Technology', 5, 'Basic Coding', NULL, '2025-03-30 13:33:05', 5, 5),
(46, 'Electronics Fundamentals', 5, 'Circuits and Devices', NULL, '2025-03-30 22:18:39', 5, 5),
(47, 'Fashion and Textiles', 5, 'Sewing and Design', NULL, '2025-03-28 13:56:42', 5, 5),
(48, 'Graphic Design Essentials', 5, 'Visual Communication', NULL, '2025-03-31 16:09:24', 5, 5),
(49, 'Agriculture Basics', 5, 'Farming Techniques', NULL, '2025-03-29 13:28:18', 5, 5),
(50, 'Plumbing and House Repairs', 5, 'Home Maintenance', NULL, '2025-04-01 14:33:17', 5, 5),
(51, 'Sports Rules and Strategies', 6, 'Basketball, Soccer, etc.', NULL, '2025-03-30 11:17:44', 5, 5),
(52, 'Fitness and Wellness', 6, 'Exercise Routines', NULL, '2025-04-01 11:37:35', 5, 5),
(53, 'Yoga and Mindfulness', 6, 'Meditation and Relaxation', NULL, '2025-03-30 23:14:32', 5, 5),
(54, 'Anatomy for Athletes', 6, 'Muscles and Movements', NULL, '2025-03-29 00:57:53', 5, 5),
(55, 'Strength Training', 6, 'Weightlifting Basics', NULL, '2025-03-28 01:09:05', 5, 5),
(56, 'Cardiovascular Health', 6, 'Running and Aerobics', NULL, '2025-03-28 13:11:41', 5, 5),
(57, 'Martial Arts Guide', 6, 'Self-Defense Techniques', NULL, '2025-03-29 00:20:16', 5, 5),
(58, 'Nutrition for Athletes', 6, 'Diet and Performance', NULL, '2025-03-28 07:40:04', 5, 5),
(59, 'Outdoor Recreation', 6, 'Hiking and Camping', NULL, '2025-03-29 22:39:02', 5, 5),
(60, 'Teamwork in Sports', 6, 'Communication and Strategy', NULL, '2025-03-30 01:21:11', 5, 5),
(61, 'Kasaysayan ng Pilipinas', 7, 'Historical Events', NULL, '2025-03-30 13:51:19', 5, 5),
(62, 'Sibika at Kultura', 7, 'Traditions and Customs', NULL, '2025-03-29 11:04:27', 5, 5),
(63, 'World History', 7, 'Ancient Civilizations', NULL, '2025-03-30 13:42:49', 5, 5),
(64, 'Economic Development', 7, 'Trade and Industry', NULL, '2025-03-28 16:53:30', 5, 5),
(65, 'Political Science', 7, 'Government and Laws', NULL, '2025-03-29 05:31:12', 5, 5),
(66, 'Global Issues', 7, 'Poverty and Climate Change', NULL, '2025-03-29 00:51:25', 5, 5),
(67, 'Philippine Geography', 7, 'Regions and Provinces', NULL, '2025-03-28 14:36:18', 5, 5),
(68, 'Sociology and Culture', 7, 'Human Interactions', NULL, '2025-03-31 05:46:50', 5, 5),
(69, 'Social Movements', 7, 'Revolutions and Reforms', NULL, '2025-03-29 02:23:25', 5, 5),
(70, 'Contemporary Issues', 7, 'Modern Social Challenges', NULL, '2025-03-30 17:23:24', 5, 5),
(71, 'Values Formation', 8, 'Ethics and Morality', NULL, '2025-03-30 20:53:53', 5, 5),
(72, 'Character Development', 8, 'Building Integrity', NULL, '2025-03-28 00:33:18', 5, 5),
(73, 'Respect and Responsibility', 8, 'Social Ethics', NULL, '2025-03-31 14:27:58', 5, 5),
(74, 'Leadership and Service', 8, 'Helping Others', NULL, '2025-04-01 05:51:33', 5, 5),
(75, 'Family and Community', 8, 'Roles in Society', NULL, '2025-03-31 05:07:50', 5, 5),
(76, 'Decision Making and Consequences', 8, 'Ethical Choices', NULL, '2025-03-31 20:45:03', 5, 5),
(77, 'Love and Respect', 8, 'Healthy Relationships', NULL, '2025-03-29 12:05:37', 5, 5),
(78, 'Social Justice', 8, 'Fairness and Equality', NULL, '2025-04-01 19:01:23', 5, 5),
(79, 'Empathy and Kindness', 8, 'Understanding Others', NULL, '2025-03-29 12:35:51', 5, 5),
(80, 'Personal Growth', 8, 'Self-Improvement and Reflection', NULL, '2025-03-30 20:08:38', 5, 5);

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
  `book_title` varchar(255) NOT NULL,
  `date_borrowed` datetime NOT NULL,
  `return_date` date NOT NULL,
  `date_returned` datetime DEFAULT NULL,
  `course` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `source` varchar(20) NOT NULL DEFAULT '',
  `barcode` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `email`, `name`, `address`, `contact_number`, `student_id`, `book_title`, `date_borrowed`, `return_date`, `date_returned`, `course`, `author`, `completed`, `source`, `barcode`) VALUES
(1, 'chisato@gmail.com', 'Chisato Arashi', 'Japan', '123', 'M2025-0007', 'Advanced Algebra', '2025-03-31 19:20:38', '2025-04-30', '2025-03-31 20:09:49', 'BSCS', 'John Doe', 1, 'books', ''),
(2, 'chisato@gmail.com', 'Chisato Arashi', 'Japan', '123', 'M2025-0007', 'Statistics for Beginners', '2025-03-31 07:23:10', '2025-04-16', '2025-03-31 21:11:12', 'BSCS', 'Robert Brown', 1, 'books', ''),
(3, 'kawtsun@gmail.com', 'Morpheus Francisco', 'Morong', '123', 'M2025-0005', 'Statistics for Beginners', '2025-03-31 02:53:55', '2025-04-09', '2025-03-31 16:05:25', 'BSCS', 'Robert Brown', 1, 'books', ''),
(4, 'rika@gmail.com', 'Rika Furude', 'Japan', '123', 'M2025-0009', 'Advanced Algebra', '2025-03-31 16:20:05', '2025-05-02', '2025-03-31 21:11:34', 'BSCS', 'John Doe', 1, 'books', ''),
(5, 'rika@gmail.com', 'Rika Furude', 'Japan', '123', 'M2025-0009', 'Statistics for Beginners', '2025-03-31 00:58:40', '2025-04-28', '2025-03-31 07:44:09', 'BSCS', 'Robert Brown', 1, 'books', ''),
(6, 'kita@gmail.com', 'Ikuyo Kita', 'Japan', '123', 'M2025-0006', 'Advanced Algebra', '2025-03-31 03:53:08', '2025-05-15', '2025-03-31 15:16:37', 'BSCS', 'John Doe', 1, 'books', ''),
(7, 'kita@gmail.com', 'Ikuyo Kita', 'Japan', '123', 'M2025-0006', 'Statistics for Beginners', '2025-03-31 16:29:41', '2025-05-08', '2025-03-31 23:37:56', 'BSCS', 'Robert Brown', 1, 'books', ''),
(8, 'mikoto@gmail.com', 'Mikoto Misaka', 'Japan', '123', 'M2025-0010', 'Advanced Algebra', '2025-03-31 22:48:59', '2025-04-16', '2025-03-31 22:52:57', 'BSCS', 'John Doe', 1, 'books', ''),
(9, 'mikoto@gmail.com', 'Mikoto Misaka', 'Japan', '123', 'M2025-0010', 'Statistics for Beginners', '2025-03-31 16:35:54', '2025-04-19', '2025-03-31 19:45:39', 'BSCS', 'Robert Brown', 1, 'books', ''),
(60, 'migs123@gmail.com', 'Miguel Badtrip', 'Tanay, Rizal', '09362347131', 'B2023-2034', 'The Wonders of Chemistry', '2025-04-02 00:00:00', '2025-04-24', '2025-04-02 00:00:00', 'BSA', 'Marie Curie', 1, 'books', '67ed0bdeaa988'),
(62, 'migs123@gmail.com', 'Miguel Badtrip', 'Tanay, Rizal', '09362347131', 'B2023-2034', 'Algebra Fundamentals', '2025-04-02 00:00:00', '2025-04-25', '2025-04-02 00:00:00', 'BSA', '', 1, 'library_books', '67ed0e526d088'),
(64, 'johnluizaustria@gmail.com', 'John Luiz S Austria', '670 Notanggi St. Darangan Binangonan, Rizal', '09362447121', 'M2022-0234', 'Calculus Essentials', '2025-04-02 00:00:00', '2025-04-25', '2025-04-02 18:20:11', 'BSCS', 'Jane Smith', 1, 'books', '67ed0f22705ef'),
(65, 'johnluizaustria@gmail.com', 'John Luiz S Austria', '670 Notanggi St. Darangan Binangonan, Rizal', '09362447121', 'M2022-0234', 'World Geography', '2025-04-02 00:00:00', '2025-04-25', '2025-04-02 18:20:52', 'BSCS', 'Marco Polo', 1, 'books', '67ed0f66c76a9'),
(66, 'migs123@gmail.com', 'Miguel Badtrip', 'Tanay, Rizal', '09362347131', 'B2023-2034', 'John Doe: Crimson Tide', '2025-04-02 00:00:00', '2025-04-24', '2025-04-02 18:22:01', 'BSA', 'John Doe', 1, 'author_books', '67ed0faccee8d'),
(67, 'billy12@gmail.com', 'Billy Crowford', 'Angono', '093425233415', 'T2023-2323', 'Statistics for Beginners', '2025-04-02 00:00:00', '2025-05-01', '2025-04-02 18:25:02', 'BSIT', 'Robert Brown', 1, 'books', '67ed103f42626'),
(68, 'billy12@gmail.com', 'Billy Crowford', 'Angono', '093425233415', 'T2023-2323', 'Character Development', '2025-04-02 00:00:00', '2025-04-24', '2025-04-02 18:25:16', 'BSIT', 'Xavier Morals', 1, 'books', '67ed10534dd26');

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
(7, 'Chisato', '$2y$10$8HBOXBMvC1DFproX.dMYa.zA65JzMcHvwXWqJzOUTNjI7N3jxTSpq', 'chisato@gmail.com', 'BSCS', 'M2025-0007', 'Chisato Arashi', 'Japan', '123'),
(8, 'Momoka', '$2y$10$MviHDL/gXmTbBK89ofZ7peAknbEsYticaCy1QxfNR6J09O6xk//vq', 'momoka@gmail.com', 'BSCS', 'M2025-0008', 'Momoka Sakurai', 'Japan', '123'),
(9, 'Rika', '$2y$10$XiYJdIID2jcBxgjTOC6vZe9ieY43rjOVD/8mV4K1xNol.uVUbkpxu', 'rika@gmail.com', 'BSCS', 'M2025-0009', 'Rika Furude', 'Japan', '123'),
(10, 'Mikoto', '$2y$10$HBZP5RGPwpEOUxiuaHkX1uhOGTWOOe14hgX5WFd.a7i2HLZC8AsgS', 'mikoto@gmail.com', 'BSCS', 'M2025-0010', 'Mikoto Misaka', 'Japan', '123'),
(11, 'Anon', '$2y$10$VmarTr/5XKTlbJPrL8SOxu8pNFBmckK0jfKQ6o3DsRjoKTklGYbHm', 'anon@gmail.com', 'BSCS', 'M2025-0011', 'Anon Chihaya', 'Japan', '123'),
(12, 'migs', '$2y$10$0KRHwdxOaQZR2E3aJMnRZ.1Y44xchaBTF09hPmQkY6T4.N7602asa', 'migs123@gmail.com', 'BSA', 'B2023-2034', 'Miguel Badtrip', 'Tanay, Rizal', '09362347131'),
(13, 'billy', '$2y$10$dk.U2p1.QjN5Pm.37AIO3.hyT/0LuNi3zLYNuA2kVYW.bLeNH30qO', 'billy12@gmail.com', 'BSIT', 'T2023-2323', 'Billy Crowford', 'Angono', '093425233415');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

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
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
