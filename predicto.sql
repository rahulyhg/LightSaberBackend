-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2015 at 03:14 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `predicto`
--

-- --------------------------------------------------------

--
-- Table structure for table `accesslevel`
--

CREATE TABLE IF NOT EXISTS `accesslevel` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `accesslevel`
--

INSERT INTO `accesslevel` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'Operator'),
(3, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `logintype`
--

CREATE TABLE IF NOT EXISTS `logintype` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `logintype`
--

INSERT INTO `logintype` (`id`, `name`) VALUES
(1, 'Facebook'),
(2, 'Twitter'),
(3, 'Email'),
(4, 'Google');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `linktype` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `isactive` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `description`, `keyword`, `url`, `linktype`, `parent`, `isactive`, `order`, `icon`) VALUES
(1, 'Users', '', '', 'site/viewusers', 1, 0, 1, 1, 'icon-user'),
(4, 'Dashboard', '', '', 'site/index', 1, 0, 1, 0, 'icon-dashboard'),
(5, 'Prediction', '', '', 'site/viewprediction', 1, 0, 1, 2, 'icon-user'),
(6, 'Prediction Group', '', '', 'site/viewpredictiongroup', 1, 0, 1, 3, 'icon-user'),
(7, 'Prediction Hash', '', '', 'site/viewpredictionhash', 1, 0, 1, 4, 'icon-user'),
(8, 'Prediction Team', '', '', 'site/viewpredictionteam', 1, 0, 1, 5, 'icon-user'),
(9, 'Team Group', '', '', 'site/viewteamgroup', 1, 0, 1, 6, 'icon-user'),
(10, 'User Points Log', '', '', 'site/viewuserpointlog', 1, 0, 1, 7, 'icon-user'),
(11, 'User Prediction', '', '', 'site/viewuserprediction', 1, 0, 1, 8, 'icon-user'),
(12, 'User Share', '', '', 'site/viewusershare', 1, 0, 1, 9, 'icon-user'),
(14, 'Social Login', '', '', 'site/viewsociallogin', 1, 0, 1, 11, 'icon-user');

-- --------------------------------------------------------

--
-- Table structure for table `menuaccess`
--

CREATE TABLE IF NOT EXISTS `menuaccess` (
  `menu` int(11) NOT NULL,
  `access` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menuaccess`
--

INSERT INTO `menuaccess` (`menu`, `access`) VALUES
(1, 1),
(4, 1),
(2, 1),
(3, 1),
(5, 1),
(6, 1),
(7, 1),
(7, 3),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `predicto_prediction`
--

CREATE TABLE IF NOT EXISTS `predicto_prediction` (
`id` int(11) NOT NULL,
  `predictiongroup` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `predictionteam` int(11) NOT NULL,
  `endtime` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `starttime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `venue` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `predicto_prediction`
--

INSERT INTO `predicto_prediction` (`id`, `predictiongroup`, `name`, `status`, `predictionteam`, `endtime`, `order`, `starttime`, `venue`) VALUES
(1, 1, 'Match 1', 1, 0, '08-04-15 20:00', 1, '2008-04-15 14:30:00', 'Eden Gardens, Kolkata'),
(2, 1, 'Match 2', 1, 0, '09-04-15 20:00', 1, '2009-04-15 14:30:00', 'M. A. Chidambaram Stadium, Chennai'),
(3, 1, 'Match 3', 1, 0, '10-04-15 20:00', 1, '2010-04-15 14:30:00', 'MCA International Stadium, Pune'),
(4, 1, 'Match 4', 1, 0, '11-04-15 20:00', 1, '2011-04-15 14:30:00', 'M. A. Chidambaram Stadium, Chennai'),
(5, 1, 'Match 5', 0, 0, '12-04-15 20:00', 1, '2012-04-15 14:30:00', 'Eden Gardens, Kolkata'),
(6, 1, 'Match 6', 0, 0, '13-04-15 20:00', 1, '2013-04-15 14:30:00', 'Ferozeshah Kotla, Delhi'),
(7, 1, 'Match 7', 0, 0, '14-04-15 20:00', 1, '2014-04-15 14:30:00', 'Wankhede Stadium, Mumbai'),
(8, 1, 'Match 8', 0, 0, '15-04-15 20:00', 1, '2015-04-15 14:30:00', 'M. Chinnaswamy Stadium, Bengaluru'),
(9, 1, 'Match 9', 0, 0, '16-04-15 20:00', 1, '2016-04-15 14:30:00', 'Sardar Patel Stadium, Ahmedabad'),
(10, 1, 'Match 10', 0, 0, '17-04-15 20:00', 1, '2017-04-15 14:30:00', 'MCA International Stadium, Pune'),
(11, 1, 'Match 11', 0, 0, '18-04-15 20:00', 1, '2018-04-15 14:30:00', 'ACA-VDCA Stadium, Visakhapatnam'),
(12, 1, 'Match 12', 0, 0, '19-04-15 20:00', 1, '2019-04-15 14:30:00', 'Wankhede Stadium, Mumbai'),
(13, 1, 'Match 13', 0, 0, '20-04-15 20:00', 1, '2020-04-15 14:30:00', 'ACA-VDCA Stadium, Visakhapatnam'),
(14, 1, 'Match 14', 0, 0, '21-04-15 20:00', 1, '2021-04-15 14:30:00', 'MCA International Stadium, Pune'),
(15, 1, 'Match 15', 0, 0, '22-04-15 20:00', 1, '2022-04-15 14:30:00', 'Sardar Patel Stadium, Ahmedabad'),
(16, 1, 'Match 16', 0, 0, '23-04-15 20:00', 1, '2023-04-15 14:30:00', 'M. Chinnaswamy Stadium, Bengaluru'),
(17, 1, 'Match 17', 0, 0, '24-04-15 20:00', 1, '2024-04-15 14:30:00', 'Ferozeshah Kotla, Delhi'),
(18, 1, 'Match 18', 0, 0, '25-04-15 20:00', 1, '2025-04-15 14:30:00', 'Sardar Patel Stadium, Ahmedabad'),
(19, 1, 'Match 19', 0, 0, '26-04-15 20:00', 1, '2026-04-15 14:30:00', 'ACA-VDCA Stadium, Visakhapatnam'),
(20, 1, 'Match 20', 0, 0, '27-04-15 20:00', 1, '2027-04-15 14:30:00', 'M. Chinnaswamy Stadium, Bengaluru'),
(21, 1, 'Match 21', 0, 0, '28-04-15 20:00', 1, '2028-04-15 14:30:00', 'Ferozeshah Kotla, Delhi'),
(22, 1, 'Match 22', 0, 0, '29-04-15 20:00', 1, '2029-04-15 14:30:00', 'Sardar Patel Stadium, Ahmedabad'),
(23, 1, 'Match 23', 0, 0, '30-04-15 20:00', 1, '2030-04-15 14:30:00', 'Wankhede Stadium, Mumbai'),
(24, 1, 'Match 24', 0, 0, '01-05-15 20:00', 1, '2001-05-15 14:30:00', 'M. A. Chidambaram Stadium, Chennai'),
(25, 1, 'Match 25', 0, 0, '02-05-15 20:00', 1, '2002-05-15 14:30:00', 'Eden Gardens, Kolkata'),
(26, 1, 'Match 26', 0, 0, '03-05-15 20:00', 1, '2003-05-15 14:30:00', 'Ferozeshah Kotla, Delhi'),
(27, 1, 'Match 27', 0, 0, '04-05-15 20:00', 1, '2004-05-15 14:30:00', 'Punjab Cricket Association Stadium, Mohali'),
(28, 1, 'Match 28', 0, 0, '05-05-15 20:00', 1, '2005-05-15 14:30:00', 'M. A. Chidambaram Stadium, Chennai'),
(29, 1, 'Match 29', 0, 0, '06-05-15 20:00', 1, '2006-05-15 14:30:00', 'M. Chinnaswamy Stadium, Bengaluru'),
(30, 1, 'Match 30', 0, 0, '07-05-15 20:00', 1, '2007-05-15 14:30:00', 'Eden Gardens, Kolkata'),
(31, 1, 'Match 31', 0, 0, '08-05-15 20:00', 1, '2008-05-15 14:30:00', 'Ferozeshah Kotla, Delhi'),
(32, 1, 'Match 32', 0, 0, '09-05-15 20:00', 1, '2009-05-15 14:30:00', 'Wankhede Stadium, Mumbai'),
(33, 1, 'Match 33', 0, 0, '10-05-15 20:00', 1, '2010-05-15 14:30:00', 'M. Chinnaswamy Stadium, Bengaluru'),
(34, 1, 'Match 34', 0, 0, '11-05-15 20:00', 1, '2011-05-15 14:30:00', 'Rajiv Gandhi International Cricket Stadium, Hyderabad'),
(35, 1, 'Match 35', 0, 0, '12-05-15 20:00', 1, '2012-05-15 14:30:00', 'Punjab Cricket Association Stadium, Mohali'),
(36, 1, 'Match 36', 0, 0, '13-05-15 20:00', 1, '2013-05-15 14:30:00', 'Brabourne Stadium, Mumbai'),
(37, 1, 'Match 37', 0, 0, '14-05-15 20:00', 1, '2014-05-15 14:30:00', 'M. A. Chidambaram Stadium, Chennai'),
(38, 1, 'Match 38', 0, 0, '15-05-15 20:00', 1, '2015-05-15 14:30:00', 'Eden Gardens, Kolkata'),
(39, 1, 'Match 39', 0, 0, '16-05-15 20:00', 1, '2016-05-15 14:30:00', 'Wankhede Stadium, Mumbai'),
(40, 1, 'Match 40', 0, 0, '17-05-15 20:00', 1, '2017-05-15 14:30:00', 'M. Chinnaswamy Stadium, Bengaluru'),
(41, 1, 'Match 41', 0, 0, '18-05-15 20:00', 1, '2018-05-15 14:30:00', 'Brabourne Stadium, Mumbai'),
(42, 1, 'Match 42', 0, 0, '19-05-15 20:00', 1, '2019-05-15 14:30:00', 'Eden Gardens, Kolkata'),
(43, 1, 'Match 43', 0, 0, '20-05-15 20:00', 1, '2020-05-15 14:30:00', 'M. A. Chidambaram Stadium, Chennai'),
(44, 1, 'Match 44', 0, 0, '21-05-15 20:00', 1, '2021-05-15 14:30:00', 'Eden Gardens, Kolkata'),
(45, 1, 'Match 45', 0, 0, '22-05-15 20:00', 1, '2022-05-15 14:30:00', 'Chhattisgarh International Cricket Stadium, Raipur'),
(46, 1, 'Match 46', 0, 0, '23-05-15 20:00', 1, '2023-05-15 14:30:00', 'Wankhede Stadium, Mumbai'),
(47, 1, 'Match 47', 0, 0, '24-05-15 20:00', 1, '2024-05-15 14:30:00', 'M. A. Chidambaram Stadium, Chennai'),
(48, 1, 'Match 48', 0, 0, '25-05-15 20:00', 1, '2025-05-15 14:30:00', 'Rajiv Gandhi International Cricket Stadium, Hyderabad'),
(49, 1, 'Match 49', 0, 0, '26-05-15 20:00', 1, '2026-05-15 14:30:00', 'Chhattisgarh International Cricket Stadium, Raipur'),
(50, 1, 'Match 50', 0, 0, '27-05-15 20:00', 1, '2027-05-15 14:30:00', 'Punjab Cricket Association Stadium, Mohali'),
(51, 1, 'Match 51', 0, 0, '28-05-15 20:00', 1, '2028-05-15 14:30:00', 'Wankhede Stadium, Mumbai'),
(52, 1, 'Match 52', 0, 0, '29-05-15 20:00', 1, '2029-05-15 14:30:00', 'Rajiv Gandhi International Cricket Stadium, Hyderabad'),
(53, 1, 'Match 53', 0, 0, '30-05-15 20:00', 1, '2030-05-15 14:30:00', 'Punjab Cricket Association Stadium, Mohali'),
(54, 1, 'Match 54', 0, 0, '31-05-15 20:00', 1, '2031-05-15 14:30:00', 'Brabourne Stadium, Mumbai'),
(55, 1, 'Match 55', 0, 0, '01-06-15 20:00', 1, '2001-06-15 14:30:00', 'M. Chinnaswamy Stadium, Bengaluru'),
(56, 1, 'Match 56', 0, 0, '02-06-15 20:00', 1, '2002-06-15 14:30:00', 'Rajiv Gandhi International Cricket Stadium, Hyderabad'),
(57, 1, 'Qualifier 1', 0, 0, '03-06-15 20:00', 1, '2003-06-15 14:30:00', 'TBD'),
(58, 1, 'Eliminator', 0, 0, '04-06-15 20:00', 1, '2004-06-15 14:30:00', 'TBD'),
(59, 1, 'Qualifier 2', 0, 0, '05-06-15 20:00', 1, '2005-06-15 14:30:00', 'TBD'),
(60, 1, 'Final', 0, 0, '06-06-15 20:00', 1, '2006-06-15 14:30:00', 'Eden Gardens, Kolkata');

-- --------------------------------------------------------

--
-- Table structure for table `predicto_predictiongroup`
--

CREATE TABLE IF NOT EXISTS `predicto_predictiongroup` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `endtime` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `predicto_predictiongroup`
--

INSERT INTO `predicto_predictiongroup` (`id`, `name`, `order`, `status`, `endtime`) VALUES
(1, 'IPL', 1, 1, '24th May 2015');

-- --------------------------------------------------------

--
-- Table structure for table `predicto_predictionhash`
--

CREATE TABLE IF NOT EXISTS `predicto_predictionhash` (
`id` int(11) NOT NULL,
  `prediction` int(11) NOT NULL,
  `hashtag` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `predicto_predictionhash`
--

INSERT INTO `predicto_predictionhash` (`id`, `prediction`, `hashtag`) VALUES
(1, 1, '#ipl'),
(2, 1, '#aap');

-- --------------------------------------------------------

--
-- Table structure for table `predicto_predictionteam`
--

CREATE TABLE IF NOT EXISTS `predicto_predictionteam` (
`id` int(11) NOT NULL,
  `prediction` int(11) NOT NULL,
  `teamgroup` int(11) NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `predicto_predictionteam`
--

INSERT INTO `predicto_predictionteam` (`id`, `prediction`, `teamgroup`, `order`) VALUES
(11, 1, 2, 1),
(12, 1, 4, 2),
(13, 2, 1, 1),
(14, 2, 6, 2),
(15, 3, 5, 1),
(16, 3, 7, 2),
(17, 5, 1, 1),
(18, 5, 8, 2),
(19, 6, 2, 1),
(20, 6, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `predicto_sociallogin`
--

CREATE TABLE IF NOT EXISTS `predicto_sociallogin` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `predicto_sociallogin`
--

INSERT INTO `predicto_sociallogin` (`id`, `name`) VALUES
(1, 'Facebook'),
(2, 'Twitter'),
(3, 'Google');

-- --------------------------------------------------------

--
-- Table structure for table `predicto_teamgroup`
--

CREATE TABLE IF NOT EXISTS `predicto_teamgroup` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `predictiongroup` int(11) NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `predicto_teamgroup`
--

INSERT INTO `predicto_teamgroup` (`id`, `name`, `predictiongroup`, `order`) VALUES
(1, 'Chennai Super Kings', 1, 1),
(2, 'Kolkata Knight Riders', 1, 2),
(3, 'Royal Challengers Bangalore', 1, 3),
(4, 'Mumbai Indians', 1, 4),
(5, 'Kings XI Punjab', 1, 5),
(6, 'Delhi Daredevils', 1, 6),
(7, 'Rajasthan Royals', 1, 7),
(8, 'Sunrisers Hyderabad', 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `predicto_userpointlog`
--

CREATE TABLE IF NOT EXISTS `predicto_userpointlog` (
`id` int(11) NOT NULL,
  `point` varchar(255) NOT NULL,
  `for` int(11) NOT NULL,
  `prediction` int(11) NOT NULL,
  `shareid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `predicto_userprediction`
--

CREATE TABLE IF NOT EXISTS `predicto_userprediction` (
`id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `teamgroup` int(11) NOT NULL,
  `prediction` int(11) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `predicto_userprediction`
--

INSERT INTO `predicto_userprediction` (`id`, `user`, `teamgroup`, `prediction`) VALUES
(7, 15, 2, 1),
(9, 15, 2, 1),
(10, 15, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `predicto_usershare`
--

CREATE TABLE IF NOT EXISTS `predicto_usershare` (
`id` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `sharecontent` text NOT NULL,
  `total` varchar(255) NOT NULL,
  `prediction` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `predicto_usersharehash`
--

CREATE TABLE IF NOT EXISTS `predicto_usersharehash` (
`id` int(11) NOT NULL,
  `usershare` int(11) NOT NULL,
  `predictionhash` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE IF NOT EXISTS `statuses` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'inactive'),
(2, 'Active'),
(3, 'Waiting'),
(4, 'Active Waiting'),
(5, 'Blocked');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `accesslevel` int(11) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `socialid` varchar(255) NOT NULL,
  `logintype` int(11) NOT NULL,
  `json` text NOT NULL,
  `points` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `password`, `email`, `accesslevel`, `timestamp`, `status`, `image`, `username`, `socialid`, `logintype`, `json`, `points`) VALUES
(1, 'wohlig', 'a63526467438df9566c508027d9cb06b', 'wohlig@wohlig.com', 1, '0000-00-00 00:00:00', 1, NULL, '', '', 0, '', 0),
(4, 'pratik', '0cb2b62754dfd12b6ed0161d4b447df7', 'pratik@wohlig.com', 1, '2014-05-12 06:52:44', 1, NULL, 'pratik', '1', 1, '', 0),
(5, 'wohlig123', 'wohlig123', 'wohlig1@wohlig.com', 1, '2014-05-12 06:52:44', 1, NULL, '', '', 0, '', 0),
(6, 'wohlig1', 'a63526467438df9566c508027d9cb06b', 'wohlig2@wohlig.com', 1, '2014-05-12 06:52:44', 1, NULL, '', '', 0, '', 0),
(7, 'Avinash', '7b0a80efe0d324e937bbfc7716fb15d3', 'avinash@wohlig.com', 1, '2014-10-17 06:22:29', 1, NULL, '', '', 0, '', 0),
(9, 'avinash', 'a208e5837519309129fa466b0c68396b', 'a@email.com', 2, '2014-12-03 11:06:19', 3, '', '', '123', 1, 'demojson', 0),
(13, 'aaa', 'a208e5837519309129fa466b0c68396b', 'aaa3@email.com', 3, '2014-12-04 06:55:42', 3, NULL, '', '1', 2, 'userjson', 0),
(14, 'chintanhappines', '', '', 2, '2015-04-07 19:12:05', 1, 'http://pbs.twimg.com/profile_images/465790248304115712/s0WXS5Si_normal.png', 'Chintan Shah', '121427044', 2, '', 0),
(15, 'aminAbhay', '', '', 2, '2015-04-07 22:01:11', 1, 'http://pbs.twimg.com/profile_images/585536031530872832/TSb0uQjV_normal.jpg', 'Abhay Amin', '1709476142', 2, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE IF NOT EXISTS `userlog` (
`id` int(11) NOT NULL,
  `onuser` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`id`, `onuser`, `status`, `description`, `timestamp`) VALUES
(1, 1, 1, 'User Address Edited', '2014-05-12 06:50:21'),
(2, 1, 1, 'User Details Edited', '2014-05-12 06:51:43'),
(3, 1, 1, 'User Details Edited', '2014-05-12 06:51:53'),
(4, 4, 1, 'User Created', '2014-05-12 06:52:44'),
(5, 4, 1, 'User Address Edited', '2014-05-12 12:31:48'),
(6, 23, 2, 'User Created', '2014-10-07 06:46:55'),
(7, 24, 2, 'User Created', '2014-10-07 06:48:25'),
(8, 25, 2, 'User Created', '2014-10-07 06:49:04'),
(9, 26, 2, 'User Created', '2014-10-07 06:49:16'),
(10, 27, 2, 'User Created', '2014-10-07 06:52:18'),
(11, 28, 2, 'User Created', '2014-10-07 06:52:45'),
(12, 29, 2, 'User Created', '2014-10-07 06:53:10'),
(13, 30, 2, 'User Created', '2014-10-07 06:53:33'),
(14, 31, 2, 'User Created', '2014-10-07 06:55:03'),
(15, 32, 2, 'User Created', '2014-10-07 06:55:33'),
(16, 33, 2, 'User Created', '2014-10-07 06:59:32'),
(17, 34, 2, 'User Created', '2014-10-07 07:01:18'),
(18, 35, 2, 'User Created', '2014-10-07 07:01:50'),
(19, 34, 2, 'User Details Edited', '2014-10-07 07:04:34'),
(20, 18, 2, 'User Details Edited', '2014-10-07 07:05:11'),
(21, 18, 2, 'User Details Edited', '2014-10-07 07:05:45'),
(22, 18, 2, 'User Details Edited', '2014-10-07 07:06:03'),
(23, 7, 6, 'User Created', '2014-10-17 06:22:29'),
(24, 7, 6, 'User Details Edited', '2014-10-17 06:32:22'),
(25, 7, 6, 'User Details Edited', '2014-10-17 06:32:37'),
(26, 8, 6, 'User Created', '2014-11-15 12:05:52'),
(27, 9, 6, 'User Created', '2014-12-02 10:46:36'),
(28, 9, 6, 'User Details Edited', '2014-12-02 10:47:34'),
(29, 4, 6, 'User Details Edited', '2014-12-03 10:34:49'),
(30, 4, 6, 'User Details Edited', '2014-12-03 10:36:34'),
(31, 4, 6, 'User Details Edited', '2014-12-03 10:36:49'),
(32, 8, 6, 'User Details Edited', '2014-12-03 10:47:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accesslevel`
--
ALTER TABLE `accesslevel`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `logintype`
--
ALTER TABLE `logintype`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `predicto_prediction`
--
ALTER TABLE `predicto_prediction`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `predicto_predictiongroup`
--
ALTER TABLE `predicto_predictiongroup`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `predicto_predictionhash`
--
ALTER TABLE `predicto_predictionhash`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `predicto_predictionteam`
--
ALTER TABLE `predicto_predictionteam`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `predicto_sociallogin`
--
ALTER TABLE `predicto_sociallogin`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `predicto_teamgroup`
--
ALTER TABLE `predicto_teamgroup`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `predicto_userpointlog`
--
ALTER TABLE `predicto_userpointlog`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `predicto_userprediction`
--
ALTER TABLE `predicto_userprediction`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `predicto_usershare`
--
ALTER TABLE `predicto_usershare`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `predicto_usersharehash`
--
ALTER TABLE `predicto_usersharehash`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userlog`
--
ALTER TABLE `userlog`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accesslevel`
--
ALTER TABLE `accesslevel`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `logintype`
--
ALTER TABLE `logintype`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `predicto_prediction`
--
ALTER TABLE `predicto_prediction`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `predicto_predictiongroup`
--
ALTER TABLE `predicto_predictiongroup`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `predicto_predictionhash`
--
ALTER TABLE `predicto_predictionhash`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `predicto_predictionteam`
--
ALTER TABLE `predicto_predictionteam`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `predicto_sociallogin`
--
ALTER TABLE `predicto_sociallogin`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `predicto_teamgroup`
--
ALTER TABLE `predicto_teamgroup`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `predicto_userpointlog`
--
ALTER TABLE `predicto_userpointlog`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `predicto_userprediction`
--
ALTER TABLE `predicto_userprediction`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `predicto_usershare`
--
ALTER TABLE `predicto_usershare`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `predicto_usersharehash`
--
ALTER TABLE `predicto_usersharehash`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `userlog`
--
ALTER TABLE `userlog`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
