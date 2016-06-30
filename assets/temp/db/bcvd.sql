-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jun 30, 2016 at 09:42 AM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bcvd`
--

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
`item_id` int(11) NOT NULL,
  `item_type_id` int(11) NOT NULL,
  `item_date_added` datetime NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `item_type_id`, `item_date_added`, `status`) VALUES
(1, 1, '2016-06-29 08:30:00', 1),
(2, 1, '2016-06-30 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `item_attribute`
--

CREATE TABLE `item_attribute` (
`item_attribute_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_attribute_type_id` int(11) NOT NULL,
  `item_attribute_value` text NOT NULL,
  `item_attribute_date_added` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_attribute`
--

INSERT INTO `item_attribute` (`item_attribute_id`, `item_id`, `item_attribute_type_id`, `item_attribute_value`, `item_attribute_date_added`) VALUES
(1, 1, 5, 'Nimbin Drug Raids', '2016-06-29 00:00:00'),
(2, 1, 3, '7 News (North Coast)', '2016-06-29 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `item_attribute_type`
--

CREATE TABLE `item_attribute_type` (
`item_attribute_type_id` int(11) NOT NULL,
  `item_attribute_type_name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_attribute_type`
--

INSERT INTO `item_attribute_type` (`item_attribute_type_id`, `item_attribute_type_name`) VALUES
(1, 'video_file'),
(2, 'youtube_id'),
(3, 'source'),
(4, 'description'),
(5, 'title');

-- --------------------------------------------------------

--
-- Table structure for table `item_type`
--

CREATE TABLE `item_type` (
`item_type_id` int(11) NOT NULL,
  `item_type_name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item_type`
--

INSERT INTO `item_type` (`item_type_id`, `item_type_name`) VALUES
(1, 'video'),
(2, 'video_youtube');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `item`
--
ALTER TABLE `item`
 ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `item_attribute`
--
ALTER TABLE `item_attribute`
 ADD PRIMARY KEY (`item_attribute_id`), ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `item_attribute_type`
--
ALTER TABLE `item_attribute_type`
 ADD PRIMARY KEY (`item_attribute_type_id`);

--
-- Indexes for table `item_type`
--
ALTER TABLE `item_type`
 ADD PRIMARY KEY (`item_type_id`), ADD UNIQUE KEY `item_type_id` (`item_type_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `item_attribute`
--
ALTER TABLE `item_attribute`
MODIFY `item_attribute_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `item_attribute_type`
--
ALTER TABLE `item_attribute_type`
MODIFY `item_attribute_type_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `item_type`
--
ALTER TABLE `item_type`
MODIFY `item_type_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;