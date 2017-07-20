-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2017 at 07:16 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `midterm`
--

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `SID` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `time_slot` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`SID`, `first_name`, `last_name`, `email`, `time_slot`) VALUES
('bc3396', 'Yuth', 'Ken', 'yken@gmail.com', 'Wednesday, August 2nd, 2:00pm - 4:00pm'),
('bp1234', 'sisi', 'wu', 'vw52930@gmail.com', 'Wednesday, August 2nd, 2:00pm - 4:00pm'),
('fx5528', 'Timo', 'Courtuwa', 'timo@yahoo.com', 'Wednesday, July 19th, 2:00pm - 4:00pm'),
('gg4400', 'Noah', 'Winston', 'nwinston@gmail.com', 'Wednesday, August 2nd, 2:00pm - 4:00pm'),
('hy9928', 'Harry', 'Poter', 'hpp@gmail.com', 'Wednesday, July 19th, 2:00pm - 4:00pm'),
('io8763', 'Jane', 'Smith', 'jsmith@gmail.com', 'Wednesday, August 16th, 2:00pm - 4:00pm'),
('lf3006', 'Jerry', 'Yang', 'jerryy@hotmail.com', 'Wednesday, July 19th, 2:00pm - 4:00pm'),
('nt4210', 'Brad', 'Pete', 'bpete@hotmail.com', 'Wednesday, July 5th, 2:00pm - 4:00pm'),
('rq6620', 'Yoda', 'Amashi', 'yams@hotmail.com', 'Wednesday, July 5th, 2:00pm - 4:00pm'),
('rv3315', 'Frank', 'Wang', 'fwang@gmail.com', 'Wednesday, July 5th, 2:00pm - 4:00pm'),
('tb3392', 'Lucy', 'Alice', 'lalice@gmail.com', 'Wednesday, July 19th, 2:00pm - 4:00pm'),
('ub2169', 'Brandon', 'Lars', 'blars@yahoo.com', 'Wednesday, July 19th, 2:00pm - 4:00pm'),
('xx7596', 'John', 'Doe', 'jdoe@gmail.com', 'Wednesday, July 19th, 2:00pm - 4:00pm'),
('yy2901', 'Pane', 'Max', 'pmax@gmail.com', 'Wednesday, July 19th, 2:00pm - 4:00pm'),
('yy6251', 'Peter', 'Jeremy', 'pjm@yahoo.com', 'Wednesday, July 19th, 2:00pm - 4:00pm'),
('zp3320', 'Alice', 'Christine', 'achris@yahoo.com', 'Wednesday, August 2nd, 2:00pm - 4:00pm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`SID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
