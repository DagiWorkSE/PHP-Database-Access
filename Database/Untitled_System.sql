-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 08, 2023 at 08:10 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Untitled_System`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `employee_id` varchar(20) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `FirstName` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `LastName` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `phone` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `password` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `company` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `department` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `type` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT 'user',
  `role` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `status` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT 'waiting',
  `creation_date` timestamp NOT NULL,
  PRIMARY KEY (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`employee_id`, `FirstName`, `LastName`, `phone`, `email`, `password`, `company`, `department`, `type`, `role`, `status`, `creation_date`) VALUES
('1', 'Adugna', 'Chombe', '+251911474028', 'Adugna.Chombe@gmail.com', '202cb962ac59075b964b07152d234b70', 'Head Office', 'IT', 'Admin', 'Admin', 'active', '2023-03-18 19:45:59'),
('2', 'Dagem', 'Adugna', '+251911474028', 'dagem.adugna@hagbes.com', '202cb962ac59075b964b07152d234b70', 'Head Office', 'IT', 'Manager', 'Manager', 'active', '2022-07-15 07:02:34'),
('3', 'Nathnael', 'Chombe', '+251911474028', 'Nathnael.Chombe@gmail.com', '202cb962ac59075b964b07152d234b70', 'Head Office', 'IT', 'Admin', 'Admin', 'active', '2023-03-18 19:46:37'),
('4', 'Project', 'Manager', '+251911474028', 'dagem.adugna@hagbes.com', '202cb962ac59075b964b07152d234b70', 'Head Office', 'General Manager', 'Manager', 'Project Manager', 'active', '2023-03-26 08:37:19'),
('5', 'Manager', 'Manager', '+251911474028', 'dagem.adugna@hagbes.com', '202cb962ac59075b964b07152d234b70', 'Head Office', 'General Manager', 'Manager', 'Manager', 'active', '2023-07-28 16:49:41');

-- --------------------------------------------------------

--
-- Table structure for table `catagory`
--

DROP TABLE IF EXISTS `catagory`;
CREATE TABLE IF NOT EXISTS `catagory` (
  `catagory` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `image` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `path` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT 'requests/request_form.php',
  `replacements` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`catagory`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `catagory`
--

INSERT INTO `catagory` (`catagory`, `image`, `path`, `replacements`) VALUES
('Manufacturing', 'ConsumerGoods.jpg', 'requests/project_list.php', 0),
('Maintainace', 'SpareandLubricant.jpeg', 'requests/spare_jobs.php', 0),
('Building', 'StationaryandToiletaries.jfif', 'requests/request_form.php', 0);

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
CREATE TABLE IF NOT EXISTS `company` (
  `Name` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `type` varchar(30) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `main` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT 'Hagbes HQ.',
  `logo` varchar(1000) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`Name`, `type`, `main`, `logo`) VALUES
('Branch', 'Branch', 'Head Office', 'logo.jpg'),
('Head Office', 'Sister', 'Head Office', 'logo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `dbs_edits`
--

DROP TABLE IF EXISTS `dbs_edits`;
CREATE TABLE IF NOT EXISTS `dbs_edits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user` varchar(300) NOT NULL,
  `dbs` varchar(400) NOT NULL,
  `tbl` varchar(300) NOT NULL,
  `pri-value` varchar(1000) NOT NULL,
  `att` varchar(300) NOT NULL,
  `value` varchar(600) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dbs_edits`
--

INSERT INTO `dbs_edits` (`id`, `user`, `dbs`, `tbl`, `pri-value`, `att`, `value`) VALUES
(1, 'Nathnael Chombe', 'CMS', 'banks', 'id-1', 'account_number', '1000222222222->100022222');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
  `Name` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `special` tinyint(1) NOT NULL DEFAULT '0',
  `inserted_by` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `date_inserted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`Name`, `special`, `inserted_by`, `date_inserted`) VALUES
('Finance', 0, 'Dagem Adugna', '2023-03-19 08:14:05'),
('Procurement', 0, 'Dagem Adugna', '2023-03-19 08:14:05'),
('Property', 0, 'Dagem Adugna', '2023-03-19 08:14:05');

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

DROP TABLE IF EXISTS `records`;
CREATE TABLE IF NOT EXISTS `records` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(20) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `tbl` varchar(50) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `primary_value` varchar(40) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `operation` varchar(30) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `status` varchar(20) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=161 DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `records`
--

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

DROP TABLE IF EXISTS `site_settings`;
CREATE TABLE IF NOT EXISTS `site_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `presets` varchar(500) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `user` varchar(100) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_bin;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `presets`, `user`, `timestamp`) VALUES
(1, 'check:-:15:-:checked::-::select:-:selects_4:-:bg-navy::-::select:-:selects_5:-:bg-navy', '3', '2023-05-26 15:56:28'),
(2, 'check:-:15:-:unchecked::-::check:-:20:-:checked::-::select:-:selects_4:-:bg-navy::-::select:-:selects_5:-:bg-navy', '1', '2023-05-26 16:07:31'),
(3, 'check:-:15:-:unchecked::-::check:-:20:-:checked::-::select:-:selects_2:-:bg-primary::-::select:-:selects_4:-:bg-navy::-::select:-:selects_5:-:bg-navy', '1', '2023-05-26 17:48:09');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
