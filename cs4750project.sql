-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2020 at 12:21 AM
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
-- Table structure for table `airbnbhost`
--

CREATE TABLE `airbnbhost` (
  `Host_ID` int(11) NOT NULL,
  `Host_location` varchar(255) DEFAULT NULL,
  `Is_superhost` tinyint(1) DEFAULT NULL,
  `First_name` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Response_time` varchar(255) DEFAULT NULL,
  `Is_verified` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `airbnblist`
--

CREATE TABLE `airbnblist` (
  `Listing_ID` int(11) NOT NULL,
  `Host_ID` int(11) DEFAULT NULL,
  `Location` text DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Bed_type` varchar(55) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `Room_type` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `airbnblisting_amenities`
--

CREATE TABLE `airbnblisting_amenities` (
  `Listing_ID` int(11) NOT NULL,
  `Amenity` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `arrest`
--

CREATE TABLE `arrest` (
  `ArrestID` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Type` varchar(100) DEFAULT NULL,
  `Gender` varchar(1) DEFAULT NULL,
  `Age_group` varchar(5) DEFAULT NULL,
  `Race` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `has`
--

CREATE TABLE `has` (
  `User_name` varchar(255) NOT NULL,
  `Query_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `query_history`
--

CREATE TABLE `query_history` (
  `User_ID` varchar(255) NOT NULL,
  `Query_ID` int(11) NOT NULL,
  `Date_Time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `query_history_airbnb`
--

CREATE TABLE `query_history_airbnb` (
  `User_ID` int(11) NOT NULL,
  `Query_ID` int(11) NOT NULL,
  `Date_Time` datetime DEFAULT NULL,
  `Host_ID` int(11) NOT NULL,
  `Listing_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `query_history_airbnb_amenities`
--

CREATE TABLE `query_history_airbnb_amenities` (
  `User_ID` int(11) NOT NULL,
  `Query_ID` int(11) NOT NULL,
  `Listing_ID` int(11) NOT NULL,
  `Amenity` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `query_history_airline`
--

CREATE TABLE `query_history_airline` (
  `User_ID` int(11) NOT NULL,
  `Query_ID` int(11) NOT NULL,
  `Date_Time` datetime DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `query_history_crime`
--

CREATE TABLE `query_history_crime` (
  `User_ID` varchar(255) NOT NULL,
  `Query_ID` int(11) NOT NULL,
  `Date_Time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ArrestID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
-- Indexes for dumped tables
--

--
-- Indexes for table `airbnbhost`
--
ALTER TABLE `airbnbhost`
  ADD PRIMARY KEY (`Host_ID`);

--
-- Indexes for table `airbnblist`
--
ALTER TABLE `airbnblist`
  ADD PRIMARY KEY (`Listing_ID`),
  ADD KEY `Host_ID` (`Host_ID`);

--
-- Indexes for table `airbnblisting_amenities`
--
ALTER TABLE `airbnblisting_amenities`
  ADD PRIMARY KEY (`Listing_ID`);

--
-- Indexes for table `airline`
--
ALTER TABLE `airline`
  ADD PRIMARY KEY (`Name`);

--
-- Indexes for table `arrest`
--
ALTER TABLE `arrest`
  ADD PRIMARY KEY (`ArrestID`);

--
-- Indexes for table `followup`
--
ALTER TABLE `followup`
  ADD PRIMARY KEY (`FollowUp_ID`);

--
-- Indexes for table `has`
--
ALTER TABLE `has`
  ADD PRIMARY KEY (`User_name`,`Query_ID`);

--
-- Indexes for table `query_history`
--
ALTER TABLE `query_history`
  ADD PRIMARY KEY (`User_ID`,`Query_ID`);

--
-- Indexes for table `query_history_airbnb`
--
ALTER TABLE `query_history_airbnb`
  ADD PRIMARY KEY (`User_ID`);

--
-- Indexes for table `query_history_airbnb_amenities`
--
ALTER TABLE `query_history_airbnb_amenities`
  ADD PRIMARY KEY (`User_ID`);

--
-- Indexes for table `query_history_airline`
--
ALTER TABLE `query_history_airline`
  ADD PRIMARY KEY (`User_ID`);

--
-- Indexes for table `query_history_crime`
--
ALTER TABLE `query_history_crime`
  ADD PRIMARY KEY (`User_ID`,`Query_ID`);

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
-- AUTO_INCREMENT for table `airbnbhost`
--
ALTER TABLE `airbnbhost`
  MODIFY `Host_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `airbnblist`
--
ALTER TABLE `airbnblist`
  MODIFY `Listing_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `arrest`
--
ALTER TABLE `arrest`
  MODIFY `ArrestID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `followup`
--
ALTER TABLE `followup`
  MODIFY `FollowUp_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `query_history_airbnb`
--
ALTER TABLE `query_history_airbnb`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `query_history_airbnb_amenities`
--
ALTER TABLE `query_history_airbnb_amenities`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `query_history_airline`
--
ALTER TABLE `query_history_airline`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `Review_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `airbnblist`
--
ALTER TABLE `airbnblist`
  ADD CONSTRAINT `airbnblist_ibfk_1` FOREIGN KEY (`Host_ID`) REFERENCES `airbnbhost` (`Host_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
