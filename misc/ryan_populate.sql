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
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Dumping data for table `query_history`
--

INSERT INTO `query_history`(`User_ID`, `Query_ID`, `Date_Time`) VALUES
("1232", 0001, NULL),
("3895", 0002, NULL),
("3095", 0003, NULL),
("2906", 0004, NULL),
("5693", 0005, NULL);

--
-- Dumping data for table `query_history_airbnb`
--

INSERT INTO `query_history_airbnb`(`User_ID`, `Query_ID`, `Date_Time`, `Host_ID`, `Listing_ID`) VALUES
(4756, 0002, '2020-03-24 01:36:49', 47517, 65041),
(3875, 0003, '2020-03-24 03:49:21', 58458, 72890),
(8725, 0004, '2020-03-24 04:01:19', 451315, 436145),
(7865, 0005, '2020-03-24 05:32:22', 452487, 769053);

--
-- Dumping data for table `query_history_airbnb_amenities`
--

INSERT INTO `query_history_airbnb_amenities`(`User_ID`, `Query_ID`, `Listing_ID`, `Amenity`) VALUES
(1236, 0001, 47517, "Wifi,Wheelchair accessible"),
(3467, 0002, 451315, "Wifi,Wheelchair accessible,Kitchen,Heating"),
(2679, 0003, 65041, "Wifi,Kitchen,dishwasher,Heating"),
(3467, 0004, 58458, "Wifi,Heating");

--
-- Dumping data for table `query_history_airline`
--

INSERT INTO `query_history_airline`(`User_ID`, `Query_ID`, `Date_Time`, `Name`) VALUES
(47517, 0001, '2020-03-24 01:36:49', "John Smith"),
(263888, 0002, '2020-03-24 03:49:21', "Johnny Appleseed"),
(278253, 0003, '2020-03-24 04:01:19', "Random Name"),
(1250756, 0004, '2020-03-24 05:32:22', "Random Name");

--
-- Dumping data for table `query_history_crime`
--

INSERT INTO `query_history_crime`(`User_ID`, `Query_ID`, `Date_Time`, `ArrestID`) VALUES
("1232", 0001, NULL, 2959378),
("3895", 0002, NULL, 2948563),
("3095", 0003, NULL, 5693837),
("2906", 0004, NULL, 2832300),
("5693", 0005, NULL, 384371);
