-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2025 at 05:28 AM
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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `author_books`
--
ALTER TABLE `author_books`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `author_books`
--
ALTER TABLE `author_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
