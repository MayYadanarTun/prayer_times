-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2024 at 02:25 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coding_test_pray`
--

-- --------------------------------------------------------

--
-- Table structure for table `boxes`
--

CREATE TABLE `boxes` (
  `box_id` int(11) NOT NULL,
  `box_name` varchar(225) NOT NULL,
  `prayerzone` varchar(225) NOT NULL,
  `sbus_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `boxes`
--

INSERT INTO `boxes` (`box_id`, `box_name`, `prayerzone`, `sbus_id`) VALUES
(1, 'Orchard Tower', 'WLY01', 1),
(2, 'United Square', 'SWK02', 1),
(3, 'Thompson Plaza', 'JHR01', 2),
(4, 'Peranakan Place', 'KDH01', 2),
(5, 'Marina Boulevard', 'MLK01', 2);

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `song_id` int(11) NOT NULL,
  `song_title` varchar(225) NOT NULL,
  `subs_id` int(11) NOT NULL,
  `box_id` int(11) NOT NULL,
  `prayerazone` varchar(225) NOT NULL,
  `prayertimeseq` tinyint(4) NOT NULL,
  `prayertimedate` date NOT NULL,
  `prayertime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`song_id`, `song_title`, `subs_id`, `box_id`, `prayerazone`, `prayertimeseq`, `prayertimedate`, `prayertime`) VALUES
(1, 'ghost.mp3', 1, 101, 'JHR01', 1, '2024-04-12', '10:57:44'),
(2, 'ghost.mp3', 1, 101, 'JHR01', 2, '2024-04-12', '12:12:22'),
(3, 'ghost.mp3', 1, 101, 'JHR01', 3, '2024-04-12', '13:24:22'),
(4, 'ghost.mp3', 1, 101, 'JHR01', 4, '2024-04-12', '14:50:22'),
(5, 'ghost.mp3', 1, 101, 'JHR01', 5, '2024-04-12', '13:50:22'),
(6, 'ghost.mp3', 1, 101, 'JHR01', 6, '2024-04-12', '18:20:22'),
(7, 'ghost.mp3', 1, 101, 'JHR01', 7, '2024-04-12', '20:45:22'),
(8, 'cheating_on_you.mp3', 1, 101, 'JHR03', 8, '2024-04-12', '07:31:22'),
(9, 'cheating_on_you.mp3', 1, 101, 'JHR03', 9, '2024-04-12', '09:24:22'),
(10, 'cheating_on_you.mp3', 1, 101, 'JHR03', 10, '2024-04-12', '10:30:00'),
(11, 'cheating_on_you.mp3', 1, 101, 'JHR03', 11, '2024-04-12', '11:45:22'),
(12, 'cheating_on_you.mp3', 1, 101, 'JHR03', 12, '2024-04-12', '12:45:22'),
(13, 'cheating_on_you.mp3', 1, 101, 'JHR03', 13, '2024-04-12', '16:45:22'),
(14, 'cheating_on_you.mp3', 1, 101, 'JHR03', 14, '2024-04-12', '17:24:22'),
(15, 'cheeleader.mp3', 1, 101, 'JHR02', 15, '2024-04-12', '05:54:20'),
(16, 'cheeleader.mp3', 1, 101, 'JHR02', 16, '2024-04-12', '06:54:20'),
(17, 'cheeleader.mp3', 1, 101, 'JHR02', 17, '2024-04-12', '10:40:00'),
(18, 'cheeleader.mp3', 1, 101, 'JHR02', 18, '2024-04-12', '13:58:00'),
(19, 'cheeleader.mp3', 1, 101, 'JHR02', 19, '2024-04-12', '14:31:22'),
(20, 'cheeleader.mp3', 1, 101, 'JHR02', 20, '2024-04-12', '18:50:22'),
(21, 'cheeleader.mp3', 1, 101, 'JHR02', 21, '2024-04-12', '21:30:10');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `subs_id` int(11) NOT NULL,
  `subs_name` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`subs_id`, `subs_name`) VALUES
(1, 'The Cafe'),
(2, 'My Restaurant');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boxes`
--
ALTER TABLE `boxes`
  ADD PRIMARY KEY (`box_id`);

--
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`song_id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`subs_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boxes`
--
ALTER TABLE `boxes`
  MODIFY `box_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `song_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `subs_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
