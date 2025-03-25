-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2025 at 04:19 PM
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
-- Table structure for table `author_books`
--

CREATE TABLE `author_books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `publication_year` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `author_books`
--

INSERT INTO `author_books` (`id`, `title`, `author`, `subject`, `publication_year`) VALUES
(1, 'John Doe: The Quantum Paradox', 'John Doe', 'Science Fiction', 2023),
(2, 'John Doe: Echoes of Eternity', 'John Doe', 'Fantasy', 2022),
(3, 'John Doe: Silent Shadows', 'John Doe', 'Mystery', 2021),
(4, 'John Doe: Crimson Tide', 'John Doe', 'Thriller', 2020),
(5, 'John Doe: A Tale of Two Worlds', 'John Doe', 'Adventure', 2019),
(6, 'John Doe: The Lost City', 'John Doe', 'Historical Fiction', 2018),
(7, 'John Doe: Whispers of the Wind', 'John Doe', 'Poetry', 2023),
(8, 'John Doe: The Final Curtain', 'John Doe', 'Drama', 2022),
(9, 'John Doe: Starlight Symphony', 'John Doe', 'Romance', 2021),
(10, 'John Doe: Beyond the Horizon', 'John Doe', 'Science Fiction', 2020),
(11, 'Jane Smith: The Enigma Code', 'Jane Smith', 'Mystery', 2023),
(12, 'Jane Smith: Beneath the Surface', 'Jane Smith', 'Thriller', 2022),
(13, 'Jane Smith: The River\'s Secret', 'Jane Smith', 'Adventure', 2021),
(14, 'Jane Smith: A Journey Through Time', 'Jane Smith', 'Historical Fiction', 2020),
(15, 'Jane Smith: Melodies of the Heart', 'Jane Smith', 'Romance', 2023),
(16, 'Jane Smith: Galactic Explorers', 'Jane Smith', 'Science Fiction', 2022),
(17, 'Jane Smith: Realm of the Dragons', 'Jane Smith', 'Fantasy', 2021),
(18, 'Jane Smith: Poetry of the Soul', 'Jane Smith', 'Poetry', 2020),
(19, 'Jane Smith: The Stage is Set', 'Jane Smith', 'Drama', 2023),
(20, 'Jane Smith: Echoes of the Past', 'Jane Smith', 'Historical Fiction', 2022),
(21, 'Robert Brown: The Lost Artifact', 'Robert Brown', 'Adventure', 2023),
(22, 'Robert Brown: Shadows of Deception', 'Robert Brown', 'Mystery', 2022),
(23, 'Robert Brown: The Last Stand', 'Robert Brown', 'Thriller', 2021),
(24, 'Robert Brown: Symphony of Stars', 'Robert Brown', 'Science Fiction', 2020),
(25, 'Robert Brown: Tales of the Forgotten', 'Robert Brown', 'Fantasy', 2023),
(26, 'Robert Brown: The Poet\'s Muse', 'Robert Brown', 'Poetry', 2022),
(27, 'Robert Brown: Curtain Call', 'Robert Brown', 'Drama', 2021),
(28, 'Robert Brown: Heart\'s Desire', 'Robert Brown', 'Romance', 2020),
(29, 'Robert Brown: Chronicles of the Ancients', 'Robert Brown', 'Historical Fiction', 2023),
(30, 'Robert Brown: Voyage to the Unknown', 'Robert Brown', 'Science Fiction', 2022),
(31, 'Albert Newton: The Cosmic Equation', 'Albert Newton', 'Science Fiction', 2023),
(32, 'Albert Newton: Riddle of the Sphinx', 'Albert Newton', 'Mystery', 2022),
(33, 'Albert Newton: Edge of Tomorrow', 'Albert Newton', 'Thriller', 2021),
(34, 'Albert Newton: Saga of the Elven Lords', 'Albert Newton', 'Fantasy', 2020),
(35, 'Albert Newton: The Wanderer\'s Path', 'Albert Newton', 'Adventure', 2023),
(36, 'Albert Newton: Timeless Love', 'Albert Newton', 'Romance', 2022),
(37, 'Albert Newton: The Bard\'s Legacy', 'Albert Newton', 'Poetry', 2021),
(38, 'Albert Newton: The Stagehand\'s Dream', 'Albert Newton', 'Drama', 2020),
(39, 'Albert Newton: Secrets of the Pharaohs', 'Albert Newton', 'Historical Fiction', 2023),
(40, 'Albert Newton: Beyond the Stars', 'Albert Newton', 'Science Fiction', 2022),
(41, 'Marie Curie: The Radioactive Legacy', 'Marie Curie', 'Science Fiction', 2023),
(42, 'Marie Curie: The Alchemist\'s Secret', 'Marie Curie', 'Mystery', 2022),
(43, 'Marie Curie: Countdown to Zero', 'Marie Curie', 'Thriller', 2021),
(44, 'Marie Curie: Guardians of the Realm', 'Marie Curie', 'Fantasy', 2020),
(45, 'Marie Curie: The Explorer\'s Journal', 'Marie Curie', 'Adventure', 2023),
(46, 'Marie Curie: Love in the Time of Cholera', 'Marie Curie', 'Romance', 2022),
(47, 'Marie Curie: The Poet\'s Canvas', 'Marie Curie', 'Poetry', 2021),
(48, 'Marie Curie: The Actor\'s Journey', 'Marie Curie', 'Drama', 2020),
(49, 'Marie Curie: The Roman Empire', 'Marie Curie', 'Historical Fiction', 2023),
(50, 'Marie Curie: To the Edge of the Universe', 'Marie Curie', 'Science Fiction', 2022),
(51, 'Charles Darwin: The Evolutionary Enigma', 'Charles Darwin', 'Science Fiction', 2023),
(52, 'Charles Darwin: The Hidden Clues', 'Charles Darwin', 'Mystery', 2022),
(53, 'Charles Darwin: The Final Descent', 'Charles Darwin', 'Thriller', 2021),
(54, 'Charles Darwin: The Dragon\'s Lair', 'Charles Darwin', 'Fantasy', 2020),
(55, 'Charles Darwin: The Lost Expedition', 'Charles Darwin', 'Adventure', 2023),
(56, 'Charles Darwin: Love\'s Eternal Flame', 'Charles Darwin', 'Romance', 2022),
(57, 'Charles Darwin: The Poet\'s Quill', 'Charles Darwin', 'Poetry', 2021),
(58, 'Charles Darwin: The Director\'s Cut', 'Charles Darwin', 'Drama', 2020),
(59, 'Charles Darwin: The Age of Discovery', 'Charles Darwin', 'Historical Fiction', 2023),
(60, 'Charles Darwin: Journey to the Stars', 'Charles Darwin', 'Science Fiction', 2022),
(61, 'Emily White: The Vanishing Act', 'Emily White', 'Mystery', 2023),
(62, 'Emily White: The Silent Witness', 'Emily White', 'Thriller', 2022),
(63, 'Emily White: The Treasure Hunt', 'Emily White', 'Adventure', 2021),
(64, 'Emily White: A Love Story', 'Emily White', 'Romance', 2020),
(65, 'Emily White: The Poet\'s Heart', 'Emily White', 'Poetry', 2023),
(66, 'Emily White: The Playwright', 'Emily White', 'Drama', 2022),
(67, 'Emily White: The Viking Age', 'Emily White', 'Historical Fiction', 2021),
(68, 'Emily White: The Stellar Odyssey', 'Emily White', 'Science Fiction', 2020),
(69, 'Emily White: The Enchanted Forest', 'Emily White', 'Fantasy', 2023),
(70, 'Emily White: The Lost City of Gold', 'Emily White', 'Adventure', 2022),
(71, 'William S: The Shakespearean Mystery', 'William S', 'Mystery', 2023),
(72, 'William S: The Bard\'s Revenge', 'William S', 'Thriller', 2022),
(73, 'William S: The Globe Theatre', 'William S', 'Drama', 2021),
(74, 'William S: A Midsummer Night\'s Dream', 'William S', 'Romance', 2020),
(75, 'William S: The Poet\'s Sonnets', 'William S', 'Poetry', 2023),
(76, 'William S: The Elizabethan Era', 'William S', 'Historical Fiction', 2022),
(77, 'William S: The Tragedy of Hamlet, Prince of Denmark', 'William S', 'Drama', 2021),
(78, 'William S: Romeo and Juliet', 'William S', 'Romance', 2020),
(79, 'William S: Macbeth', 'William S', 'Drama', 2023),
(80, 'William S: Othello, the Moor of Venice', 'William S', 'Drama', 2022),
(81, 'William S: King Lear', 'William S', 'Drama', 2021),
(82, 'Ernest H: The Old Man and the Sea', 'Ernest H', 'Adventure', 2023),
(83, 'Ernest H: A Farewell to Arms', 'Ernest H', 'Romance', 2022),
(84, 'Ernest H: The Sun Also Rises', 'Ernest H', 'Historical Fiction', 2021),
(85, 'Ernest H: For Whom the Bell Tolls', 'Ernest H', 'Thriller', 2020),
(86, 'Ernest H: The Poet\'s War', 'Ernest H', 'Poetry', 2023),
(87, 'Ernest H: The Playwright\'s Life', 'Ernest H', 'Drama', 2020),
(88, 'Ernest H: The Spanish Civil War', 'Ernest H', 'Historical Fiction', 2023),
(89, 'Ernest H: The Lost Generation', 'Ernest H', 'Historical Fiction', 2022),
(90, 'Ernest H: To Have and Have Not', 'Ernest H', 'Adventure', 2021),
(91, 'Ernest H: Death in the Afternoon', 'Ernest H', 'Non-fiction', 2020),
(92, 'Jose Corazon: Ang Bayan Ko', 'Jose Corazon', 'Poetry', 2023),
(93, 'Jose Corazon: Isang Punongkahoy', 'Jose Corazon', 'Poetry', 2022),
(94, 'Jose Corazon: Ang Pagbabalik', 'Jose Corazon', 'Poetry', 2021),
(95, 'Jose Corazon: Mga Dahong Ginto', 'Jose Corazon', 'Poetry', 2020),
(96, 'Jose Corazon: Sa Dakong Silangan', 'Jose Corazon', 'Poetry', 2023),
(97, 'Jose Corazon: Ang Araw', 'Jose Corazon', 'Poetry', 2022),
(98, 'Jose Corazon: Ang Guryon', 'Jose Corazon', 'Poetry', 2021),
(99, 'Jose Corazon: Mga Tinik ng Puso', 'Jose Corazon', 'Poetry', 2020),
(100, 'Jose Corazon: Ang Mga Ibon', 'Jose Corazon', 'Poetry', 2023),
(101, 'Jose Corazon: Ang Pangarap', 'Jose Corazon', 'Poetry', 2022),
(102, 'Francisco Balagtas: Florante at Laura', 'Francisco Balagtas', 'Filipino', 2023),
(103, 'Francisco Balagtas: Orosman at Zafira', 'Francisco Balagtas', 'Filipino', 2022),
(104, 'Francisco Balagtas: Abdal at Misarela', 'Francisco Balagtas', 'Filipino', 2021),
(105, 'Francisco Balagtas: Clara Belmonte', 'Francisco Balagtas', 'Filipino', 2020),
(106, 'Francisco Balagtas: La India Elegante y el Negrito Amante', 'Francisco Balagtas', 'Filipino', 2023),
(107, 'Francisco Balagtas: Mahomet at Constanza', 'Francisco Balagtas', 'Filipino', 2022),
(108, 'Francisco Balagtas: Rodolfo at Rosamunda', 'Francisco Balagtas', 'Filipino', 2021),
(109, 'Francisco Balagtas: Almanzor at Rosalina', 'Francisco Balagtas', 'Filipino', 2020),
(110, 'Francisco Balagtas: Bayaceto at Dorlisca', 'Francisco Balagtas', 'Filipino', 2023),
(111, 'Francisco Balagtas: Don Nuño at Zelinda', 'Francisco Balagtas', 'Filipino', 2022),
(112, 'Andres Bonifacio: Pag-ibig sa Tinubuang Lupa', 'Andres Bonifacio', 'Filipino', 2023),
(113, 'Andres Bonifacio: Katapusang Hibik ng Pilipinas', 'Andres Bonifacio', 'Filipino', 2022),
(114, 'Andres Bonifacio: Ang Dapat Mabatid ng mga Tagalog', 'Andres Bonifacio', 'Filipino', 2021),
(115, 'Andres Bonifacio: Tapunan ng Lingap', 'Andres Bonifacio', 'Filipino', 2020),
(116, 'Andres Bonifacio: Katungkulan Gagawin ng mga Anak ng Bayan', 'Andres Bonifacio', 'Filipino', 2023),
(117, 'Andres Bonifacio: Dekalogo', 'Andres Bonifacio', 'Filipino', 2022),
(118, 'Andres Bonifacio: Mi Ultimo Adios', 'Andres Bonifacio', 'Filipino', 2021),
(119, 'Andres Bonifacio: Ang Mga Cazadores', 'Andres Bonifacio', 'Filipino', 2020),
(120, 'Andres Bonifacio: Huling Paalam', 'Andres Bonifacio', 'Filipino', 2023),
(121, 'Andres Bonifacio: Liwanag at Dilim', 'Andres Bonifacio', 'Filipino', 2022),
(122, 'Chef Gordon: Gordon Ramsay\'s Home Cooking', 'Chef Gordon', 'TLE', 2023),
(123, 'Chef Gordon: Humble Pie', 'Chef Gordon', 'TLE', 2022),
(124, 'Chef Gordon: Playing with Fire', 'Chef Gordon', 'TLE', 2021),
(125, 'Chef Gordon: Roasting in Hell\'s Kitchen', 'Chef Gordon', 'TLE', 2020),
(126, 'Chef Gordon: Fast Food', 'Chef Gordon', 'TLE', 2023),
(127, 'Chef Gordon: World Kitchen', 'Chef Gordon', 'TLE', 2022),
(128, 'Chef Gordon: Bread Street Kitchen', 'Chef Gordon', 'TLE', 2021),
(129, 'Chef Gordon: Ultimate Home Cooking', 'Chef Gordon', 'TLE', 2020),
(130, 'Chef Gordon: 3 Star Chef', 'Chef Gordon', 'TLE', 2023),
(131, 'Chef Gordon: Ramsay in 10', 'Chef Gordon', 'TLE', 2022),
(132, 'Mark Cuban: How to Win at the Sport of Business', 'Mark Cuban', 'TLE', 2023),
(133, 'Mark Cuban: Shark Tank Jump Start Your Business', 'Mark Cuban', 'TLE', 2022),
(134, 'Mark Cuban: The Mavericks Way', 'Mark Cuban', 'TLE', 2021),
(135, 'Mark Cuban: Be Your Own Boss', 'Mark Cuban', 'TLE', 2020),
(136, 'Mark Cuban: Entrepreneurial Mindset', 'Mark Cuban', 'TLE', 2023),
(137, 'Mark Cuban: 12 Rules for Startups', 'Mark Cuban', 'TLE', 2022),
(138, 'Mark Cuban: The Business of Sports', 'Mark Cuban', 'TLE', 2021),
(139, 'Mark Cuban: Investing for Dummies', 'Mark Cuban', 'TLE', 2020),
(140, 'Mark Cuban: The Billionaire Blueprint', 'Mark Cuban', 'TLE', 2023),
(141, 'Mark Cuban: From Rags to Riches', 'Mark Cuban', 'TLE', 2022),
(142, 'Steve Jobs: Steve Jobs', 'Steve Jobs', 'TLE', 2023),
(143, 'Steve Jobs: The Second Coming of Steve Jobs', 'Steve Jobs', 'TLE', 2022),
(144, 'Steve Jobs: iCon Steve Jobs', 'Steve Jobs', 'TLE', 2021),
(145, 'Steve Jobs: Becoming Steve Jobs', 'Steve Jobs', 'TLE', 2020),
(146, 'Steve Jobs: The Steve Jobs Way', 'Steve Jobs', 'TLE', 2023),
(147, 'Steve Jobs: Inside Steve\'s Brain', 'Steve Jobs', 'TLE', 2022),
(148, 'Steve Jobs: What Would Steve Jobs Do?', 'Steve Jobs', 'TLE', 2021),
(149, 'Steve Jobs: The Presentation Secrets of Steve Jobs', 'Steve Jobs', 'TLE', 2020),
(150, 'Steve Jobs: Steve Jobs and the Next Big Thing', 'Steve Jobs', 'TLE', 2023),
(151, 'Steve Jobs: The Innovation Secrets of Steve Jobs', 'Steve Jobs', 'TLE', 2022),
(152, 'Arnold Fitman: The Encyclopedia of Modern Bodybuilding', 'Arnold Fitman', 'Physical Education', 2023),
(153, 'Arnold Fitman: Total Recall', 'Arnold Fitman', 'Physical Education', 2022),
(154, 'Arnold Fitman: New Encyclopedia of Modern Bodybuilding', 'Arnold Fitman', 'Physical Education', 2021),
(155, 'Arnold Fitman: Education of a Bodybuilder', 'Arnold Fitman', 'Physical Education', 2020),
(156, 'Arnold Fitman: Pumping Iron', 'Arnold Fitman', 'Physical Education', 2023),
(157, 'Arnold Fitman: The Fitness Bible', 'Arnold Fitman', 'Physical Education', 2022),
(158, 'Arnold Fitman: Strength Training Anatomy', 'Arnold Fitman', 'Physical Education', 2021),
(159, 'Arnold Fitman: The 7-Minute Body', 'Arnold Fitman', 'Physical Education', 2020),
(160, 'Arnold Fitman: The Body Sculpting Bible for Women', 'Arnold Fitman', 'Physical Education', 2023),
(161, 'Arnold Fitman: The Encyclopedia of Modern Bodybuilding', 'Arnold Fitman', 'Physical Education', 2022),
(162, 'Michael Jordan: Driven from Within', 'Michael Jordan', 'Physical Education', 2023),
(163, 'Michael Jordan: I Can\'t Accept Not Trying', 'Michael Jordan', 'Physical Education', 2022),
(164, 'Michael Jordan: Rare Air', 'Michael Jordan', 'Physical Education', 2021),
(165, 'Michael Jordan: Playing for Keeps', 'Michael Jordan', 'Physical Education', 2020),
(166, 'Michael Jordan: Hang Time', 'Michael Jordan', 'Physical Education', 2023),
(167, 'Michael Jordan: Michael Jordan: The Life', 'Michael Jordan', 'Physical Education', 2022),
(168, 'Michael Jordan: Jumpman', 'Michael Jordan', 'Physical Education', 2021),
(169, 'Michael Jordan: The Last Dance', 'Michael Jordan', 'Physical Education', 2020),
(170, 'Michael Jordan: Be Like Mike', 'Michael Jordan', 'Physical Education', 2023),
(171, 'Michael Jordan: Winning', 'Michael Jordan', 'Physical Education', 2022),
(172, 'Carlos Garcia: Philippine History', 'Carlos Garcia', 'Araling Panlipunan', 2023),
(173, 'Carlos Garcia: A Nation for Our Children', 'Carlos Garcia', 'Araling Panlipunan', 2022),
(174, 'Carlos Garcia: The Filipino First Policy', 'Carlos Garcia', 'Araling Panlipunan', 2021),
(175, 'Carlos Garcia: The Austerity Program', 'Carlos Garcia', 'Araling Panlipunan', 2020),
(176, 'Carlos Garcia: The Bohlen-Serrano Agreement', 'Carlos Garcia', 'Araling Panlipunan', 2023),
(177, 'Carlos Garcia: The Laurel-Langley Agreement', 'Carlos Garcia', 'Araling Panlipunan', 2022),
(178, 'Carlos Garcia: The Garcia Doctrine', 'Carlos Garcia', 'Araling Panlipunan', 2021),
(179, 'Carlos Garcia: The Garcia Administration', 'Carlos Garcia', 'Araling Panlipunan', 2020),
(180, 'Carlos Garcia: The Philippine Economy', 'Carlos Garcia', 'Araling Panlipunan', 2023),
(181, 'Carlos Garcia: The Philippine Politics', 'Carlos Garcia', 'Araling Panlipunan', 2022),
(182, 'Marco Polo: The Travels of Marco Polo', 'Marco Polo', 'Araling Panlipunan', 2023),
(183, 'Marco Polo: Description of the World', 'Marco Polo', 'Araling Panlipunan', 2022),
(184, 'Marco Polo: The Silk Road', 'Marco Polo', 'Araling Panlipunan', 2021),
(185, 'Marco Polo: Kublai Khan', 'Marco Polo', 'Araling Panlipunan', 2020),
(186, 'Marco Polo: The Mongol Empire', 'Marco Polo', 'Araling Panlipunan', 2023),
(187, 'Marco Polo: The Venetian Merchant', 'Marco Polo', 'Araling Panlipunan', 2022),
(188, 'Marco Polo: The Asian Trade', 'Marco Polo', 'Araling Panlipunan', 2021),
(189, 'Marco Polo: The Exploration of the East', 'Marco Polo', 'Araling Panlipunan', 2020),
(190, 'Marco Polo: The Cultural Exchange', 'Marco Polo', 'Araling Panlipunan', 2023),
(191, 'Marco Polo: The Geographical Discoveries', 'Marco Polo', 'Araling Panlipunan', 2022),
(192, 'Dr. John Ethics: Ethics in the Modern World', 'Dr. John Ethics', 'ESP', 2023),
(193, 'Dr. John Ethics: The Principles of Morality', 'Dr. John Ethics', 'ESP', 2022),
(194, 'Dr. John Ethics: Moral Philosophy', 'Dr. John Ethics', 'ESP', 2021),
(195, 'Dr. John Ethics: Applied Ethics', 'Dr. John Ethics', 'ESP', 2020),
(196, 'Dr. John Ethics: Ethical Dilemmas', 'Dr. John Ethics', 'ESP', 2023),
(197, 'Dr. John Ethics: The Foundations of Ethics', 'Dr. John Ethics', 'ESP', 2022),
(198, 'Dr. John Ethics: Business Ethics', 'Dr. John Ethics', 'ESP', 2021),
(199, 'Dr. John Ethics: Environmental Ethics', 'Dr. John Ethics', 'ESP', 2020),
(200, 'Dr. John Ethics: Medical Ethics', 'Dr. John Ethics', 'ESP', 2023),
(201, 'Dr. John Ethics: Social Ethics', 'Dr. John Ethics', 'ESP', 2022),
(202, 'Xavier Morals: Moral Development', 'Xavier Morals', 'ESP', 2023),
(203, 'Xavier Morals: The Psychology of Morality', 'Xavier Morals', 'ESP', 2022),
(204, 'Xavier Morals: Moral Reasoning', 'Xavier Morals', 'ESP', 2021),
(205, 'Xavier Morals: Moral Education', 'Xavier Morals', 'ESP', 2020),
(206, 'Xavier Morals: Moral Values', 'Xavier Morals', 'ESP', 2023),
(207, 'Xavier Morals: The Development of Conscience', 'Xavier Morals', 'ESP', 2022),
(208, 'Xavier Morals: Moral Identity', 'Xavier Morals', 'ESP', 2021),
(209, 'Xavier Morals: Moral Character', 'Xavier Morals', 'ESP', 2020),
(210, 'Xavier Morals: Moral Competence', 'Xavier Morals', 'ESP', 2023),
(211, 'Xavier Morals: Moral Judgment', 'Xavier Morals', 'ESP', 2022);

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
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `subject`, `author`, `publication_year`, `cover_image`, `category_id`) VALUES
(35, 'Advanced Algebra', 'Mathematics', 'John Doe', 2020, '', NULL),
(36, 'Calculus Essentials', 'Mathematics', 'Jane Smith', 2019, '', NULL),
(37, 'Statistics for Beginners', 'Mathematics', 'Robert Brown', 2021, '', NULL),
(38, 'Physics for Everyone', 'Science', 'Albert Newton', 2018, '', NULL),
(39, 'The Wonders of Chemistry', 'Science', 'Marie Curie', 2022, '', NULL),
(40, 'Biology: The Living World', 'Science', 'Charles Darwin', 2023, '', NULL),
(41, 'Mastering Grammar', 'English', 'Emily White', 2020, '', NULL),
(42, 'Shakespeare’s Classics', 'English', 'William S.', 2017, '', NULL),
(43, 'Creative Writing Techniques', 'English', 'Ernest H.', 2021, '', NULL),
(44, 'Ibong Adarna', 'Filipino', 'Jose Corazon', 2015, '', NULL),
(45, 'Florante at Laura', 'Filipino', 'Francisco Balagtas', 2018, '', NULL),
(46, 'Mga Piling Tula', 'Filipino', 'Andres Bonifacio', 2022, '', NULL),
(47, 'Basic Cooking Techniques', 'TLE', 'Chef Gordon', 2020, '', NULL),
(48, 'Entrepreneurship 101', 'TLE', 'Mark Cuban', 2021, '', NULL),
(49, 'Computer Hardware Basics', 'TLE', 'Steve Jobs', 2022, '', NULL),
(50, 'Fitness and Health', 'Physical Education', 'Arnold Fitman', 2019, '', NULL),
(51, 'Sports Science Fundamentals', 'Physical Education', 'Michael Jordan', 2021, '', NULL),
(52, 'Philippine History', 'Araling Panlipunan', 'Carlos Garcia', 2016, '', NULL),
(53, 'World Geography', 'Araling Panlipunan', 'Marco Polo', 2020, '', NULL),
(54, 'Ethics and Morality', 'ESP', 'Dr. John Ethics', 2019, '', NULL),
(55, 'Character Development', 'ESP', 'Xavier Morals', 2022, '', NULL);

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
  `cover_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `library_books`
--

INSERT INTO `library_books` (`id`, `title`, `category_id`, `topic`, `cover_image`) VALUES
(1, 'Algebra Fundamentals', 1, 'Algebra', NULL),
(2, 'Geometry Basics', 1, 'Shapes and Theorems', NULL),
(3, 'Trigonometry Explained', 1, 'Angles and Functions', NULL),
(4, 'Probability & Statistics', 1, 'Data Analysis', NULL),
(5, 'Calculus for Beginners', 1, 'Derivatives and Integrals', NULL),
(6, 'Number Theory Essentials', 1, 'Prime Numbers and Patterns', NULL),
(7, 'Linear Algebra Concepts', 1, 'Vectors and Matrices', NULL),
(8, 'Mathematical Logic', 1, 'Proofs and Reasoning', NULL),
(9, 'Graph Theory Overview', 1, 'Networks and Paths', NULL),
(10, 'Advanced Calculus', 1, 'Multivariable Functions', NULL),
(11, 'Physics Fundamentals', 2, 'Motion and Forces', NULL),
(12, 'Chemistry Essentials', 2, 'Atoms and Molecules', NULL),
(13, 'Biology Overview', 2, 'Cells and Organisms', NULL),
(14, 'Earth Science', 2, 'Rocks and Minerals', NULL),
(15, 'Astronomy Basics', 2, 'Stars and Galaxies', NULL),
(16, 'Environmental Science', 2, 'Ecosystems and Conservation', NULL),
(17, 'Genetics and Evolution', 2, 'DNA and Heredity', NULL),
(18, 'Organic Chemistry', 2, 'Carbon Compounds', NULL),
(19, 'Electricity and Magnetism', 2, 'Current and Circuits', NULL),
(20, 'Thermodynamics', 2, 'Heat and Energy Transfer', NULL),
(21, 'Grammar and Composition', 3, 'Sentence Structure', NULL),
(22, 'Literature Classics', 3, 'Famous Novels', NULL),
(23, 'Creative Writing', 3, 'Poetry and Storytelling', NULL),
(24, 'Public Speaking', 3, 'Speech and Communication', NULL),
(25, 'Essay Writing', 3, 'Persuasive and Analytical Essays', NULL),
(26, 'Syntax and Semantics', 3, 'Language Analysis', NULL),
(27, 'English for Beginners', 3, 'Basic Vocabulary', NULL),
(28, 'Shakespearean Works', 3, 'Plays and Sonnets', NULL),
(29, 'Modern English Usage', 3, 'Idioms and Expressions', NULL),
(30, 'Critical Thinking in Literature', 3, 'Analyzing Texts', NULL),
(31, 'Panitikan ng Pilipinas', 4, 'Kwentong Bayan', NULL),
(32, 'Alamat at Mitolohiya', 4, 'Mga Sinaunang Kuwento', NULL),
(33, 'Balagtasan at Tula', 4, 'Pagsusuri ng Panitikan', NULL),
(34, 'Pagsulat ng Sanaysay', 4, 'Pagbuo ng Argumento', NULL),
(35, 'Wika at Gramatika', 4, 'Balarila at Kayarian ng Wika', NULL),
(36, 'Kasaysayan ng Wikang Filipino', 4, 'Pinagmulan at Pag-unlad', NULL),
(37, 'Maikling Kwento', 4, 'Mga Kwentong Bayan', NULL),
(38, 'Filipino Journalism', 4, 'Pamamahayag sa Filipino', NULL),
(39, 'Pagpapahalaga sa Panitikan', 4, 'Interpretasyon ng Akda', NULL),
(40, 'Modernong Panitikang Pilipino', 4, 'Mga Makabagong Akda', NULL),
(41, 'Basic Cooking', 5, 'Food Preparation', NULL),
(42, 'Entrepreneurship', 5, 'Starting a Business', NULL),
(43, 'Woodworking Techniques', 5, 'Carpentry Skills', NULL),
(44, 'Automotive Basics', 5, 'Car Maintenance', NULL),
(45, 'Information Technology', 5, 'Basic Coding', NULL),
(46, 'Electronics Fundamentals', 5, 'Circuits and Devices', NULL),
(47, 'Fashion and Textiles', 5, 'Sewing and Design', NULL),
(48, 'Graphic Design Essentials', 5, 'Visual Communication', NULL),
(49, 'Agriculture Basics', 5, 'Farming Techniques', NULL),
(50, 'Plumbing and House Repairs', 5, 'Home Maintenance', NULL),
(51, 'Sports Rules and Strategies', 6, 'Basketball, Soccer, etc.', NULL),
(52, 'Fitness and Wellness', 6, 'Exercise Routines', NULL),
(53, 'Yoga and Mindfulness', 6, 'Meditation and Relaxation', NULL),
(54, 'Anatomy for Athletes', 6, 'Muscles and Movements', NULL),
(55, 'Strength Training', 6, 'Weightlifting Basics', NULL),
(56, 'Cardiovascular Health', 6, 'Running and Aerobics', NULL),
(57, 'Martial Arts Guide', 6, 'Self-Defense Techniques', NULL),
(58, 'Nutrition for Athletes', 6, 'Diet and Performance', NULL),
(59, 'Outdoor Recreation', 6, 'Hiking and Camping', NULL),
(60, 'Teamwork in Sports', 6, 'Communication and Strategy', NULL),
(61, 'Kasaysayan ng Pilipinas', 7, 'Historical Events', NULL),
(62, 'Sibika at Kultura', 7, 'Traditions and Customs', NULL),
(63, 'World History', 7, 'Ancient Civilizations', NULL),
(64, 'Economic Development', 7, 'Trade and Industry', NULL),
(65, 'Political Science', 7, 'Government and Laws', NULL),
(66, 'Global Issues', 7, 'Poverty and Climate Change', NULL),
(67, 'Philippine Geography', 7, 'Regions and Provinces', NULL),
(68, 'Sociology and Culture', 7, 'Human Interactions', NULL),
(69, 'Social Movements', 7, 'Revolutions and Reforms', NULL),
(70, 'Contemporary Issues', 7, 'Modern Social Challenges', NULL),
(71, 'Values Formation', 8, 'Ethics and Morality', NULL),
(72, 'Character Development', 8, 'Building Integrity', NULL),
(73, 'Respect and Responsibility', 8, 'Social Ethics', NULL),
(74, 'Leadership and Service', 8, 'Helping Others', NULL),
(75, 'Family and Community', 8, 'Roles in Society', NULL),
(76, 'Decision Making and Consequences', 8, 'Ethical Choices', NULL),
(77, 'Love and Respect', 8, 'Healthy Relationships', NULL),
(78, 'Social Justice', 8, 'Fairness and Equality', NULL),
(79, 'Empathy and Kindness', 8, 'Understanding Others', NULL),
(80, 'Personal Growth', 8, 'Self-Improvement and Reflection', NULL);

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
  `student_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `course`, `student_id`) VALUES
(1, 'setsu', '$2y$10$dyH3LvpxdUetz4wUkHxGqeUp8YYHp5R3naVJHpCLxzIzxRmIXp4u6', 'setsu@gmail.com', 'BSCS', '2025-0001'),
(2, 'morpheus', '$2y$10$ZIt/8G.Qx3t9kokHK8B0RO6YqU6Q8nbwl3k11Pg2twaAGuR9lPztu', 'morpheus@gmail.com', 'BSCS', '2025-0002'),
(4, 'austria', '$2y$10$LeiLX.QVWkL7QP.eyFQwKuSl3R7Aq5LET1YWSQg4xAjgJ/XlqiGIm', 'johnluizaustria@gmail.com', 'BSCS', 'M2022-0234'),
(5, 'JohnAustria', '$2y$10$tn8iGO6dRmAUKwRpRu8A0eOSw7Bdm3Zb4R8d/an.aAPw5M1gAT/sC', 'john121@gmail.com', 'BSCS', 'M2022-0234'),
(8, 'austrialuiz', '$2y$10$13PnjFzDcQczOTF1HuqbFODg7EAp0qLdBavvb/ZS4jzQntESlQAxm', 'johnluiiz123@gmail.com', 'BSCS', 'M2022-0244'),
(9, 'austria', '$2y$10$IpLz4Q/6VJ38ltX8PZ1U8e/T4HZPZG0YWvGR2.avAhYNqwv.vESra', '123133232@gmaill.com', 'abad', 'M2022-0234'),
(10, '123austria', '$2y$10$/eTGtZcI/fyPWll0oJ59F.6MpgW9lhy/JYxrUco97NWMGQhA33in6', 'Johnbenedictaustria@gmail.com', 'BSCS', 'M2022-2034'),
(11, 'austria', '$2y$10$kJ0kgZCjM1AxwDUNdfSFMunMKF2RDWSk.PZfZT1IRtOoxGRGoJRQ6', 'johnluiz1234@gmail.com', 'BSCS', 'M2022-0334'),
(12, 'Kawtsun', '$2y$10$qpedbbZhRdDO.HF.ViVv4ucEZ8Sr1ufld2nG4u4QF4aqCc.jxjM2q', 'kawtsun@gmail.com', 'BSCS', '2025-0005');

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
-- AUTO_INCREMENT for table `author_books`
--
ALTER TABLE `author_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `library_books`
--
ALTER TABLE `library_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
