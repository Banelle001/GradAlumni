-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 07, 2024 at 06:08 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gradalumni_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `student_number` varchar(255) NOT NULL,
  `graduation_year` varchar(4) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`id`, `name`, `surname`, `email`, `student_number`, `graduation_year`, `password`, `created_at`) VALUES
(1, 'kmk', 'fg', 'ft@gmail.com', '12121212', '1212', '$2y$10$43LQzDO0c.B4/ri8cY3mMOfLPxfU4ml2FDRR162pOCps7Jj9pI6s.', '2024-07-22 11:20:11');

--
-- Triggers `alumni`
--
DELIMITER $$
CREATE TRIGGER `after_alumni_insert` AFTER INSERT ON `alumni` FOR EACH ROW BEGIN
  INSERT INTO alumnus_bio (firstname, lastname, email, year, course, status, date_created)
  VALUES (NEW.name, NEW.surname, NEW.email, NEW.graduation_year, NEW.student_number, 0, CURRENT_DATE);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `careers`
--

CREATE TABLE `careers` (
  `id` int(30) NOT NULL,
  `company` varchar(250) NOT NULL,
  `location` text NOT NULL,
  `job_title` text NOT NULL,
  `description` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `careers`
--

INSERT INTO `careers` (`id`, `company`, `location`, `job_title`, `description`, `date_created`) VALUES
(1, 'UMP ', 'Mbombela Main campus', 'Developer', 'Developer , developing Project 300 (BICT)', '2024-06-27 16:47:32'),
(2, 'HITECH', 'Mbombela', 'WI_FI', 'work as a wi-fi specialist', '2024-06-27 17:18:52'),
(3, 'GradConnect', 'UMP', 'Back-end Developer', 'Leader of back-end developers', '2024-07-11 09:34:51'),
(4, 'mina', 'Campus', 'cleaner', 'cleaner', '2024-08-06 14:47:36');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(30) NOT NULL,
  `title` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `schedule` datetime NOT NULL,
  `banner` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `content`, `schedule`, `banner`, `date_created`) VALUES
(1, 'BICT ', 'project300', '2024-06-27 17:09:00', 'Screenshot 2024-06-16 140738.png', '2024-06-27 14:04:52'),
(3, 'FRESHERS PARY', 'freshers', '2024-07-24 10:23:00', 'Screenshot 2024-06-25 142913.png', '2024-06-27 17:21:19');

-- --------------------------------------------------------

--
-- Table structure for table `forum_comments`
--

CREATE TABLE `forum_comments` (
  `id` int(30) NOT NULL,
  `topic_id` int(30) NOT NULL,
  `comment` text NOT NULL,
  `tbl_user_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forum_topics`
--

CREATE TABLE `forum_topics` (
  `id` int(30) NOT NULL,
  `title` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `tbl_user_id` int(30) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forum_topics`
--

INSERT INTO `forum_topics` (`id`, `title`, `description`, `tbl_user_id`, `date_created`) VALUES
(1, 'Strike', 'Is there a strike there ?', 1, '2024-07-17 15:07:10'),
(2, 'HI', 'HI', 1, '2024-07-17 15:10:14'),
(3, 'hello ', 'hello', 1, '2024-07-17 15:11:05'),
(4, 'hello hen ', 'hello hen  ', 1, '2024-07-17 15:13:54'),
(5, 'comment ', 'how to coment', 1, '2024-07-17 15:16:40'),
(8, 'HYY', 'hy', 0, '2024-07-24 12:36:49');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(30) NOT NULL,
  `filename` text NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `filename`, `description`, `created`) VALUES
(45, 'download (1).jpeg', 'GRADUATION 2023', '2024-07-24 10:15:14'),
(46, 'download.jpeg', 'ALUMNI TEXT', '2024-07-24 10:15:33'),
(47, 'images (1).jpeg', 'ALUMNI LOGO_LIKEE', '2024-07-24 10:19:03'),
(50, 'Screenshot 2024-07-26 080406.png', '', '2024-08-07 11:46:53'),
(51, 'Screenshot 2024-07-30 095942.png', '', '2024-08-07 11:47:03');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(30) NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `media` text NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `media`, `date_created`) VALUES
(1, 'Soccer ', 'Our soccer team won', 'Screenshot 2024-06-18 103300.png', '2024-06-28 20:29:42'),
(2, 'Graduation', 'Graduation', 'images (1).jpeg', '2024-07-24 11:30:20'),
(3, 'HIV and AIDS awareness', 'Be aware of what you are doing,', 'post.png', '2024-07-26 09:26:17'),
(4, 'Presenter', 'Tumi will be our presenter', 'download.jpeg', '2024-08-06 14:38:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `contact_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `first_name`, `last_name`, `contact_number`, `email`, `username`, `password`) VALUES
(17, 'admin', 'admin', '123123', 'admin@admin', 'admin', '$2y$10$iT2QRO7MWial6/GT0avOZODvgu8Lsz03k0zRgO.lZydd25drMEzt2');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `careers`
--
ALTER TABLE `careers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_comments`
--
ALTER TABLE `forum_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forum_topics`
--
ALTER TABLE `forum_topics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `careers`
--
ALTER TABLE `careers`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `forum_comments`
--
ALTER TABLE `forum_comments`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forum_topics`
--
ALTER TABLE `forum_topics`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
