-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2021 at 01:22 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `question_number` int(11) NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `coption` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `question_number`, `is_correct`, `coption`) VALUES
(1, 1, 0, 'Atlantic'),
(2, 1, 1, 'Pacific'),
(3, 1, 0, 'Arctic'),
(4, 1, 0, 'Indian '),
(5, 2, 0, '75'),
(6, 2, 0, '25'),
(7, 2, 0, '100'),
(8, 2, 1, '50'),
(9, 3, 0, 'China'),
(10, 3, 1, 'Russia'),
(11, 3, 0, 'Canda'),
(12, 3, 0, 'USA'),
(13, 4, 1, '3'),
(14, 4, 0, '8'),
(15, 4, 0, '1'),
(16, 4, 0, '5'),
(17, 5, 0, 'Asian elephant'),
(18, 5, 0, 'White rhinoceros'),
(19, 5, 1, 'Blue whale'),
(20, 5, 0, 'Humpback whale');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_number` int(11) NOT NULL,
  `question_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_number`, `question_text`) VALUES
(1, 'Name the world’s largest ocean.'),
(2, 'How long is an Olympic swimming pool (in meters)?'),
(3, 'Which country borders 14 nations and crosses 8 time zones?'),
(4, 'How many hearts does an octopus have?'),
(5, 'What is the largest known animal?');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
