-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2026 at 12:45 PM
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
-- Database: `lol_sms`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcementid` int(5) NOT NULL,
  `title` varchar(20) NOT NULL,
  `message` varchar(30) NOT NULL,
  `publicationdate` varchar(30) NOT NULL,
  `postedby` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcementid`, `title`, `message`, `publicationdate`, `postedby`) VALUES
(1, 'kwinjira', 'good student', '2026-10-12', 'david'),
(2, 'hello', 'zxcvbn', '2026-10-14', 'david');

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attendanceid` int(5) NOT NULL,
  `studentid` int(5) NOT NULL,
  `date` varchar(30) NOT NULL,
  `attendancestatus` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attendanceid`, `studentid`, `date`, `attendancestatus`) VALUES
(1, 1, '2026-10-06', 'yaje'),
(2, 2, '2026-10-21', 'yaje'),
(3, 2, '2026-11-28', 'present'),
(4, 2, '2026-11-28', 'present'),
(5, 2, '2026-11-18', 'present');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `classid` int(5) NOT NULL,
  `classname` varchar(20) NOT NULL,
  `academicyear` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`classid`, `classname`, `academicyear`) VALUES
(5, 'civil', '2025_206'),
(6, 'ict', '2025_206'),
(7, 'mechanical', '2026_2027'),
(8, 'mechanical', '456677ddd');

-- --------------------------------------------------------

--
-- Table structure for table `fruits`
--

CREATE TABLE `fruits` (
  `fruit_id` int(5) NOT NULL,
  `fruit_name` varchar(30) NOT NULL,
  `price` int(3) NOT NULL,
  `status` text NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fruits`
--

INSERT INTO `fruits` (`fruit_id`, `fruit_name`, `price`, `status`, `date`) VALUES
(2, 'vegetables', 1000, 'out', '0000-00-00'),
(3, 'mango', 2000, 'stockin', '2026-11-08'),
(5, 'pinaple', 5000, 'out', '2026-01-03'),
(6, 'vocando', 7000, 'out', '2026-03-10');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `gradeid` int(5) NOT NULL,
  `studentid` int(5) NOT NULL,
  `subjectid` int(5) NOT NULL,
  `assessmenttype` varchar(30) NOT NULL,
  `marks` varchar(3) NOT NULL,
  `academicyear` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`gradeid`, `studentid`, `subjectid`, `assessmenttype`, `marks`, `academicyear`) VALUES
(1, 1, 1, 'formative', '78', '2025_206'),
(2, 2, 3, 'formative', '70', '2026_2027');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `salesid` int(5) NOT NULL,
  `sale_campany` varchar(30) NOT NULL,
  `quantity` int(5) NOT NULL,
  `date` date NOT NULL,
  `fruit_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `studentid` int(5) NOT NULL,
  `admissionnumber` varchar(20) NOT NULL,
  `names` varchar(30) NOT NULL,
  `gender` varchar(30) NOT NULL,
  `dateofbirth` varchar(20) NOT NULL,
  `classid` int(5) NOT NULL,
  `phonenumber` varchar(15) NOT NULL,
  `address` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`studentid`, `admissionnumber`, `names`, `gender`, `dateofbirth`, `classid`, `phonenumber`, `address`) VALUES
(6, '23', 'yvette Celerine006', 'Male', '2026-10-10', 5, '0788888888888', 'nyagatare'),
(7, '1', 'yvette celerine', 'Female', '2026-11-26', 2, '1234567333', 'kigali'),
(8, '23', 'dudu', 'female', '2026-12-01', 1, '0788888888888', 'kigali');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subjectid` int(5) NOT NULL,
  `subjectname` varchar(20) NOT NULL,
  `subjectcode` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subjectid`, `subjectname`, `subjectcode`) VALUES
(1, 'backend', 'itl008d'),
(2, 'backend', 'dfghjjhuh');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(5) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(10) NOT NULL,
  `role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `username`, `password`, `role`) VALUES
(5, 'cece', 'uuu', 'manager'),
(9, 'alice', 'qwerty', 'manager'),
(10, 'cece', '123', 'manager'),
(19, 'nshimiye', 'asade', 'Administrator'),
(21, 'yve', 'www', 'daf'),
(22, 'urukundo', 'qqqq', 'daf'),
(23, 'nana', 'dddd', 'hod'),
(24, 'fifi', 'rrrr', 'Administrator');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcementid`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attendanceid`),
  ADD KEY `zero` (`studentid`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`classid`);

--
-- Indexes for table `fruits`
--
ALTER TABLE `fruits`
  ADD PRIMARY KEY (`fruit_id`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`gradeid`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`salesid`),
  ADD KEY `hhhh` (`fruit_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`studentid`),
  ADD KEY `need` (`classid`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subjectid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcementid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attendanceid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `classid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `fruits`
--
ALTER TABLE `fruits`
  MODIFY `fruit_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `gradeid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `salesid` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `studentid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subjectid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
