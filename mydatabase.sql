-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2022 at 12:56 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `dates`
--

CREATE TABLE `dates` (
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dates`
--

INSERT INTO `dates` (`date`) VALUES
('2022-08-30 23:08:00');

-- --------------------------------------------------------

--
-- Table structure for table `haircuts`
--

CREATE TABLE `haircuts` (
  `id` varchar(30) NOT NULL,
  `title` text NOT NULL,
  `description` mediumtext NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `haircuts`
--

INSERT INTO `haircuts` (`id`, `title`, `description`, `price`) VALUES
('630b8cbda7f93', 'Mohican', 'This is a mohican haircut...', 50);

-- --------------------------------------------------------

--
-- Table structure for table `homepage`
--

CREATE TABLE `homepage` (
  `about` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `homepage`
--

INSERT INTO `homepage` (`about`) VALUES
('About Text...');

-- --------------------------------------------------------

--
-- Table structure for table `rpkeys`
--

CREATE TABLE `rpkeys` (
  `secretKey` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rpkeys`
--

INSERT INTO `rpkeys` (`secretKey`) VALUES
('630b87fcabbd0'),
('630b88973e405'),
('630b88ed85dbf'),
('630b892355b51'),
('630b89b1ad235'),
('630b89f022f68'),
('630b8ab755389'),
('630b8bbf8d8cc'),
('630e6e8ce53c0');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` varchar(30) NOT NULL,
  `uid` mediumtext NOT NULL,
  `type` text NOT NULL,
  `haircut` text NOT NULL,
  `time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `uid`, `type`, `haircut`, `time`) VALUES
('630b8eb5391c7', '630b8579507ec', 'single', '630b8cbda7f93', '2022-09-10 18:49:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` varchar(30) NOT NULL,
  `fullname` text NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `phone` text NOT NULL,
  `password` text NOT NULL,
  `admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `fullname`, `username`, `email`, `phone`, `password`, `admin`) VALUES
('630b8579507ec', 'Admin', 'admin', 'admin@gmail.com', '+972523855598', 'admin', 1),
('630b87f7e1241', 'Matan Vinkler', 'matan', 'matanvinkler@gmail.com', '+972523855598', '12345', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dates`
--
ALTER TABLE `dates`
  ADD PRIMARY KEY (`date`);

--
-- Indexes for table `haircuts`
--
ALTER TABLE `haircuts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rpkeys`
--
ALTER TABLE `rpkeys`
  ADD PRIMARY KEY (`secretKey`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
