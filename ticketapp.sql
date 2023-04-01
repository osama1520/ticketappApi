-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 31, 2023 at 06:02 AM
-- Server version: 8.0.31
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticketapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
CREATE TABLE IF NOT EXISTS `ticket` (
  `ticketID` int NOT NULL AUTO_INCREMENT,
  `Priority` varchar(32) DEFAULT NULL,
  `userID` int DEFAULT NULL,
  `asigneeId` varchar(512) DEFAULT NULL,
  `building` varchar(64) DEFAULT NULL,
  `time` varchar(64) DEFAULT NULL,
  `duration` varchar(128) DEFAULT NULL,
  `room` varchar(63) DEFAULT NULL,
  `dateEvent` date DEFAULT NULL,
  `description` varchar(128) DEFAULT NULL,
  `additional` varchar(512) DEFAULT NULL,
  `ticketType` varchar(256) DEFAULT NULL,
  `ticketTopic` varchar(128) DEFAULT NULL,
  `status` varchar(128) DEFAULT NULL,
  `files` varchar(512) DEFAULT NULL,
  `createdOn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `counter` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`ticketID`),
  UNIQUE KEY `createdOn` (`createdOn`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`ticketID`, `Priority`, `userID`, `asigneeId`, `building`, `time`, `duration`, `room`, `dateEvent`, `description`, `additional`, `ticketType`, `ticketTopic`, `status`, `files`, `createdOn`, `counter`) VALUES
(6, '1', 5, 'tom.wilson@example.com', NULL, NULL, NULL, NULL, NULL, '<p>123</p>', 'Site is not available', 'Software', 'D2L Issues', '0', NULL, '2023-03-31 04:52:15', 0),
(8, NULL, 5, NULL, 'Building 10', '', '8:30 AM - 9:00 AM', '10.1.3', '2023-04-08', NULL, NULL, 'Reservation', NULL, NULL, NULL, '2023-03-31 04:52:53', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `phone` varchar(32) DEFAULT NULL,
  `profileImage` varchar(256) DEFAULT NULL,
  `firstName` varchar(128) DEFAULT NULL,
  `lastName` varchar(128) DEFAULT NULL,
  `username` varchar(64) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `password` varchar(256) DEFAULT NULL,
  `universityID` varchar(128) DEFAULT NULL,
  `occupation` varchar(32) DEFAULT NULL,
  `timeRegistered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `phone`, `profileImage`, `firstName`, `lastName`, `username`, `email`, `password`, `universityID`, `occupation`, `timeRegistered`) VALUES
(5, '6543211', 'http://localhost/ticketAppAPI/user/5/profilePhoto/44e9c2fb54048d37a431d2e8aa5b9fa7.jpeg', 'Mohammad1', 'Qunaybi1', 'qunaybi', 'mohamad.rm93q@gmail.com', '111', '60041087', 'Admin', '2023-01-25 20:31:20'),
(6, 'null', 'http://localhost/ticketAppAPI/images/user.png', 'Ahmad', 'Ali', '60037555', 'me@gmail.com', 'password', '60037555', 'Instructor', '2023-01-26 06:10:33'),
(9, '000000', 'http://localhost/ticketAppAPI/images/user.png', 'Bruce', 'Lee', '60055555', 'lee@gmail.com', '111', '60055555', NULL, '2023-03-30 01:08:35'),
(19, '000000', 'http://localhost/ticketAppAPI/images/manager.png', 'Mohammad', 'Ali', '60000000', 'al@gmail.com', '111', 'moali', NULL, '2023-03-30 04:26:25'),
(20, '000000', 'http://localhost/ticketAppAPI/images/user.png', 'Mike', 'Tyson', 'tyson', 'tyson@gmail.com', '111', 'tyson', NULL, '2023-03-30 04:27:49'),
(21, '000000', 'http://localhost/ticketAppAPI/images/user.png', 'bruce', 'lee', '61000000', 'lee@gmail.com', '111', 'lee', 'User', '2023-03-30 04:55:41'),
(22, '111110', 'http://localhost/ticketAppAPI/user/ali/profilePhoto/6027261fef91b94ed1c592a5b25264ba.jpeg', 'hamad', 'ali', 'ali', 'ha@gmail.com', '000', 'ali', 'Admin', '2023-03-30 04:58:15'),
(23, '000000', 'http://localhost/ticketAppAPI/images/user.png', 'mohammadAsh', 'ashud1', 'ashud', 'mrone47474@gmail.com', '555', 'ashud', 'User', '2023-03-30 05:59:03'),
(24, '00000000', 'http://localhost/ticketAppAPI/images/manager.png', 'Amal', 'saad', '60096748', 'amal@gmail.com', '000', '67777777', 'Admin', '2023-03-31 04:57:24');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
