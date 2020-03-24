-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2020 at 12:59 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cs4750project`
--

-- --------------------------------------------------------

--
-- Table structure for table `airline`
--

CREATE TABLE `airline` (
  `Name` varchar(255) NOT NULL,
  `Incidents` int(11) DEFAULT NULL,
  `Fatal_Accidents` int(11) DEFAULT NULL,
  `Fatalities` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `airline`
--

INSERT INTO `airline` (`Name`, `Incidents`, `Fatal_Accidents`, `Fatalities`) VALUES
('Aer Lingus', 2, 0, 0),
('Aeroflot', 76, 14, 128),
('Aerolineas Argentinas', 6, 0, 0),
('Aeromexico', 3, 1, 64),
('Air Canada', 2, 0, 0),
('Air France', 14, 4, 79),
('Air India', 2, 1, 329),
('Air New Zealand', 3, 0, 0),
('Alaska Airlines', 5, 0, 0),
('Alitalia', 7, 2, 50),
('All Nippon Airways', 3, 1, 1),
('American', 21, 5, 101),
('Austrian Airlines', 1, 0, 0),
('Avianca', 5, 3, 323),
('British Airways', 4, 0, 0),
('Cathay Pacific', 0, 0, 0),
('China Airlines', 12, 6, 535),
('Condor', 2, 1, 16),
('COPA', 3, 1, 47),
('Delta / Northwest', 24, 12, 407),
('Egyptair', 8, 3, 282),
('El Al', 1, 1, 4),
('Ethiopian Airlines', 25, 5, 167),
('Finnair', 1, 0, 0),
('Garuda Indonesia', 10, 3, 260),
('Gulf Air', 1, 0, 0),
('Hawaiian Airlines', 0, 0, 0),
('Iberia', 4, 1, 148),
('Japan Airlines', 3, 1, 520),
('Kenya Airways', 2, 0, 0),
('KLM', 7, 1, 3),
('Korean Air', 12, 5, 425),
('LAN Airlines', 3, 2, 21),
('Lufthansa', 6, 1, 2),
('Malaysia Airlines', 3, 1, 34),
('Pakistan International', 8, 3, 234),
('Philippine Airlines', 7, 4, 74),
('Qantas', 1, 0, 0),
('Royal Air Maroc', 5, 3, 51),
('SAS', 5, 0, 0),
('Saudi Arabian', 7, 2, 313),
('Singapore Airlines', 2, 2, 6),
('South African', 2, 1, 159),
('Southwest Airlines', 1, 0, 0),
('Sri Lankan / AirLanka', 2, 1, 14),
('SWISS', 2, 1, 229),
('TACA', 3, 1, 3),
('TAM', 8, 3, 98),
('TAP - Air Portugal', 0, 0, 0),
('Thai Airways', 8, 4, 308),
('Turkish Airlines', 8, 3, 64),
('United / Continental', 19, 8, 319),
('US Airways / America West', 16, 7, 224),
('Vietnam Airlines', 7, 3, 171),
('Virgin Atlantic', 1, 0, 0),
('Xiamen Airlines', 9, 1, 82);

-- --------------------------------------------------------

--
-- Table structure for table `followup`
--

CREATE TABLE `followup` (
  `User_Name` varchar(255) NOT NULL,
  `Review_ID` int(11) NOT NULL,
  `FollowUp_ID` int(11) NOT NULL,
  `Text_` varchar(255) DEFAULT NULL,
  `Date_` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `followup`
--

INSERT INTO `followup` (`User_Name`, `Review_ID`, `FollowUp_ID`, `Text_`, `Date_`) VALUES
('loganhylton', 1, 1, 'followup to first review', '2020-03-23'),
('uvastudent', 6, 2, 'thanks for the feedback', '2020-03-23');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `Review_ID` int(11) NOT NULL,
  `User_Name` varchar(255) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Text` varchar(255) DEFAULT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`Review_ID`, `User_Name`, `Rating`, `Title`, `Text`, `Date`) VALUES
(1, 'loganhylton', 5, 'First Review', 'testing first review user logan hylton', '2020-03-23 23:29:40'),
(5, 'loganhylton', 6, 'test2', 'test2 text', '2020-03-23 23:31:41'),
(6, 'uvastudent', 8, 'new review', 'great site i give it an 8', '2020-03-23 23:42:30');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_Name` varchar(255) NOT NULL,
  `First_Name` varchar(255) DEFAULT NULL,
  `Last_Name` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_Name`, `First_Name`, `Last_Name`, `Password`) VALUES
('johndoe', 'John', 'Doe', 'john-doe-password'),
('loganhylton', 'Logan', 'Hylton', 'logan-password'),
('uvastudent', 'uva', 'student', 'uva-student-password');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `airline`
--
ALTER TABLE `airline`
  ADD PRIMARY KEY (`Name`);

--
-- Indexes for table `followup`
--
ALTER TABLE `followup`
  ADD PRIMARY KEY (`FollowUp_ID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`Review_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_Name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `followup`
--
ALTER TABLE `followup`
  MODIFY `FollowUp_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `Review_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
