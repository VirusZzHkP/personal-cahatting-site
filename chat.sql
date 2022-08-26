-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 09, 2021 at 02:32 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cpmvj`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat_message_cpmvj`
--

CREATE TABLE `chat_message_cpmvj` (
  `chat_message_id` int(11) NOT NULL,
  `chat_message_sender_id` int(11) NOT NULL,
  `chat_message_receiver_id` int(11) NOT NULL,
  `chat_message` text COLLATE utf8_unicode_ci NOT NULL,
  `chat_message_status` enum('No','Yes') COLLATE utf8_unicode_ci NOT NULL,
  `chat_message_datetime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_request_cpmvj`
--

CREATE TABLE `chat_request_cpmvj` (
  `chat_request_id` int(11) NOT NULL,
  `chat_request_sender_id` int(11) NOT NULL,
  `chat_request_receiver_id` int(11) NOT NULL,
  `chat_request_status` enum('Send','Accept','Reject') COLLATE utf8_unicode_ci NOT NULL,
  `chat_request_datetime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_cpmvj`
--

CREATE TABLE `user_cpmvj` (
  `user_id` int(11) NOT NULL,
  `user_first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_image` varchar(1080) COLLATE utf8_unicode_ci NOT NULL,
  `user_status` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_datetime` datetime NOT NULL,
  `user_verification_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat_message_cpmvj`
--
ALTER TABLE `chat_message_cpmvj`
  ADD PRIMARY KEY (`chat_message_id`);

--
-- Indexes for table `chat_request_cpmvj`
--
ALTER TABLE `chat_request_cpmvj`
  ADD PRIMARY KEY (`chat_request_id`);

--
-- Indexes for table `user_cpmvj`
--
ALTER TABLE `user_cpmvj`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat_message_cpmvj`
--
ALTER TABLE `chat_message_cpmvj`
  MODIFY `chat_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `chat_request_cpmvj`
--
ALTER TABLE `chat_request_cpmvj`
  MODIFY `chat_request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_cpmvj`
--
ALTER TABLE `user_cpmvj`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
