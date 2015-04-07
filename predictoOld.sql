-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.21 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.0.0.4865
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for predicto
DROP DATABASE IF EXISTS `predicto`;
CREATE DATABASE IF NOT EXISTS `predicto` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `predicto`;


-- Dumping structure for table predicto.accesslevel
DROP TABLE IF EXISTS `accesslevel`;
CREATE TABLE IF NOT EXISTS `accesslevel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table predicto.accesslevel: ~3 rows (approximately)
/*!40000 ALTER TABLE `accesslevel` DISABLE KEYS */;
INSERT INTO `accesslevel` (`id`, `name`) VALUES
	(1, 'admin'),
	(2, 'Operator'),
	(3, 'User');
/*!40000 ALTER TABLE `accesslevel` ENABLE KEYS */;


-- Dumping structure for table predicto.logintype
DROP TABLE IF EXISTS `logintype`;
CREATE TABLE IF NOT EXISTS `logintype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Dumping data for table predicto.logintype: ~4 rows (approximately)
/*!40000 ALTER TABLE `logintype` DISABLE KEYS */;
INSERT INTO `logintype` (`id`, `name`) VALUES
	(1, 'Facebook'),
	(2, 'Twitter'),
	(3, 'Email'),
	(4, 'Google');
/*!40000 ALTER TABLE `logintype` ENABLE KEYS */;


-- Dumping structure for table predicto.menu
DROP TABLE IF EXISTS `menu`;
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `linktype` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `isactive` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dumping data for table predicto.menu: ~11 rows (approximately)
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
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
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;


-- Dumping structure for table predicto.menuaccess
DROP TABLE IF EXISTS `menuaccess`;
CREATE TABLE IF NOT EXISTS `menuaccess` (
  `menu` int(11) NOT NULL,
  `access` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table predicto.menuaccess: ~15 rows (approximately)
/*!40000 ALTER TABLE `menuaccess` DISABLE KEYS */;
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
/*!40000 ALTER TABLE `menuaccess` ENABLE KEYS */;


-- Dumping structure for table predicto.predicto_prediction
DROP TABLE IF EXISTS `predicto_prediction`;
CREATE TABLE IF NOT EXISTS `predicto_prediction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `predictiongroup` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `predictionteam` int(11) NOT NULL,
  `endtime` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `starttime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `venue` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table predicto.predicto_prediction: ~2 rows (approximately)
/*!40000 ALTER TABLE `predicto_prediction` DISABLE KEYS */;
INSERT INTO `predicto_prediction` (`id`, `predictiongroup`, `name`, `status`, `predictionteam`, `endtime`, `order`, `starttime`, `venue`) VALUES
	(1, 1, 'Prediction 1', 1, 1, '10 AM', 1, '2015-04-08 01:40:17', ''),
	(2, 1, 'demo', 0, 1, '9Am', 2, '2015-04-08 01:40:17', '');
/*!40000 ALTER TABLE `predicto_prediction` ENABLE KEYS */;


-- Dumping structure for table predicto.predicto_predictiongroup
DROP TABLE IF EXISTS `predicto_predictiongroup`;
CREATE TABLE IF NOT EXISTS `predicto_predictiongroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `endtime` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table predicto.predicto_predictiongroup: ~2 rows (approximately)
/*!40000 ALTER TABLE `predicto_predictiongroup` DISABLE KEYS */;
INSERT INTO `predicto_predictiongroup` (`id`, `name`, `order`, `status`, `endtime`) VALUES
	(1, 'Group 1', 1, 1, '11 AM'),
	(2, 'Prediction Group 2', 2, 0, '6PM');
/*!40000 ALTER TABLE `predicto_predictiongroup` ENABLE KEYS */;


-- Dumping structure for table predicto.predicto_predictionhash
DROP TABLE IF EXISTS `predicto_predictionhash`;
CREATE TABLE IF NOT EXISTS `predicto_predictionhash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prediction` int(11) NOT NULL,
  `hashtag` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table predicto.predicto_predictionhash: ~2 rows (approximately)
/*!40000 ALTER TABLE `predicto_predictionhash` DISABLE KEYS */;
INSERT INTO `predicto_predictionhash` (`id`, `prediction`, `hashtag`) VALUES
	(1, 1, 'Hash Value'),
	(2, 2, 'hashtag prediction demo');
/*!40000 ALTER TABLE `predicto_predictionhash` ENABLE KEYS */;


-- Dumping structure for table predicto.predicto_predictionteam
DROP TABLE IF EXISTS `predicto_predictionteam`;
CREATE TABLE IF NOT EXISTS `predicto_predictionteam` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prediction` int(11) NOT NULL,
  `teamgroup` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table predicto.predicto_predictionteam: ~2 rows (approximately)
/*!40000 ALTER TABLE `predicto_predictionteam` DISABLE KEYS */;
INSERT INTO `predicto_predictionteam` (`id`, `prediction`, `teamgroup`, `order`) VALUES
	(1, 1, 1, 1),
	(2, 2, 2, 3);
/*!40000 ALTER TABLE `predicto_predictionteam` ENABLE KEYS */;


-- Dumping structure for table predicto.predicto_sociallogin
DROP TABLE IF EXISTS `predicto_sociallogin`;
CREATE TABLE IF NOT EXISTS `predicto_sociallogin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table predicto.predicto_sociallogin: ~3 rows (approximately)
/*!40000 ALTER TABLE `predicto_sociallogin` DISABLE KEYS */;
INSERT INTO `predicto_sociallogin` (`id`, `name`) VALUES
	(1, 'Facebook'),
	(2, 'Twitter'),
	(3, 'Google');
/*!40000 ALTER TABLE `predicto_sociallogin` ENABLE KEYS */;


-- Dumping structure for table predicto.predicto_teamgroup
DROP TABLE IF EXISTS `predicto_teamgroup`;
CREATE TABLE IF NOT EXISTS `predicto_teamgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `predictiongroup` int(11) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table predicto.predicto_teamgroup: ~3 rows (approximately)
/*!40000 ALTER TABLE `predicto_teamgroup` DISABLE KEYS */;
INSERT INTO `predicto_teamgroup` (`id`, `name`, `predictiongroup`, `order`) VALUES
	(1, 'Team Group 1', 1, 0),
	(2, 'Team Group 2', 1, 1),
	(3, 'Team Group 3', 2, 1);
/*!40000 ALTER TABLE `predicto_teamgroup` ENABLE KEYS */;


-- Dumping structure for table predicto.predicto_userpointlog
DROP TABLE IF EXISTS `predicto_userpointlog`;
CREATE TABLE IF NOT EXISTS `predicto_userpointlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `point` varchar(255) NOT NULL,
  `for` int(11) NOT NULL,
  `prediction` int(11) NOT NULL,
  `shareid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table predicto.predicto_userpointlog: ~2 rows (approximately)
/*!40000 ALTER TABLE `predicto_userpointlog` DISABLE KEYS */;
INSERT INTO `predicto_userpointlog` (`id`, `point`, `for`, `prediction`, `shareid`) VALUES
	(1, '10', 1, 1, '1235'),
	(2, '100', 0, 1, '123333');
/*!40000 ALTER TABLE `predicto_userpointlog` ENABLE KEYS */;


-- Dumping structure for table predicto.predicto_userprediction
DROP TABLE IF EXISTS `predicto_userprediction`;
CREATE TABLE IF NOT EXISTS `predicto_userprediction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `teamgroup` int(11) NOT NULL,
  `prediction` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table predicto.predicto_userprediction: ~0 rows (approximately)
/*!40000 ALTER TABLE `predicto_userprediction` DISABLE KEYS */;
INSERT INTO `predicto_userprediction` (`id`, `user`, `teamgroup`, `prediction`) VALUES
	(1, 4, 2, 1);
/*!40000 ALTER TABLE `predicto_userprediction` ENABLE KEYS */;


-- Dumping structure for table predicto.predicto_usershare
DROP TABLE IF EXISTS `predicto_usershare`;
CREATE TABLE IF NOT EXISTS `predicto_usershare` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `sharecontent` text NOT NULL,
  `total` varchar(255) NOT NULL,
  `prediction` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table predicto.predicto_usershare: ~3 rows (approximately)
/*!40000 ALTER TABLE `predicto_usershare` DISABLE KEYS */;
INSERT INTO `predicto_usershare` (`id`, `user`, `sharecontent`, `total`, `prediction`) VALUES
	(1, 1, 'share Content', '100', 1),
	(2, 4, 'demo content', '1000', 1),
	(3, 5, 'Demo share content', '1666', 1);
/*!40000 ALTER TABLE `predicto_usershare` ENABLE KEYS */;


-- Dumping structure for table predicto.predicto_usersharehash
DROP TABLE IF EXISTS `predicto_usersharehash`;
CREATE TABLE IF NOT EXISTS `predicto_usersharehash` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usershare` int(11) NOT NULL,
  `predictionhash` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Dumping data for table predicto.predicto_usersharehash: ~4 rows (approximately)
/*!40000 ALTER TABLE `predicto_usersharehash` DISABLE KEYS */;
INSERT INTO `predicto_usersharehash` (`id`, `usershare`, `predictionhash`) VALUES
	(1, 1, 1),
	(2, 2, 2),
	(8, 3, 1),
	(9, 3, 2);
/*!40000 ALTER TABLE `predicto_usersharehash` ENABLE KEYS */;


-- Dumping structure for table predicto.statuses
DROP TABLE IF EXISTS `statuses`;
CREATE TABLE IF NOT EXISTS `statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table predicto.statuses: ~5 rows (approximately)
/*!40000 ALTER TABLE `statuses` DISABLE KEYS */;
INSERT INTO `statuses` (`id`, `name`) VALUES
	(1, 'inactive'),
	(2, 'Active'),
	(3, 'Waiting'),
	(4, 'Active Waiting'),
	(5, 'Blocked');
/*!40000 ALTER TABLE `statuses` ENABLE KEYS */;


-- Dumping structure for table predicto.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `points` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- Dumping data for table predicto.user: ~7 rows (approximately)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `name`, `password`, `email`, `accesslevel`, `timestamp`, `status`, `image`, `username`, `socialid`, `logintype`, `json`, `points`) VALUES
	(1, 'wohlig', 'a63526467438df9566c508027d9cb06b', 'wohlig@wohlig.com', 1, '0000-00-00 00:00:00', 1, NULL, '', '', 0, '', ''),
	(4, 'pratik', '0cb2b62754dfd12b6ed0161d4b447df7', 'pratik@wohlig.com', 1, '2014-05-12 12:22:44', 1, NULL, 'pratik', '1', 1, '', ''),
	(5, 'wohlig123', 'wohlig123', 'wohlig1@wohlig.com', 1, '2014-05-12 12:22:44', 1, NULL, '', '', 0, '', ''),
	(6, 'wohlig1', 'a63526467438df9566c508027d9cb06b', 'wohlig2@wohlig.com', 1, '2014-05-12 12:22:44', 1, NULL, '', '', 0, '', ''),
	(7, 'Avinash', '7b0a80efe0d324e937bbfc7716fb15d3', 'avinash@wohlig.com', 1, '2014-10-17 11:52:29', 1, NULL, '', '', 0, '', ''),
	(9, 'avinash', 'a208e5837519309129fa466b0c68396b', 'a@email.com', 2, '2014-12-03 16:36:19', 3, '', '', '123', 1, 'demojson', ''),
	(13, 'aaa', 'a208e5837519309129fa466b0c68396b', 'aaa3@email.com', 3, '2014-12-04 12:25:42', 3, NULL, '', '1', 2, 'userjson', ''),
	(14, 'chintanhappines', '', '', 2, '2015-04-08 00:42:05', 1, 'http://pbs.twimg.com/profile_images/465790248304115712/s0WXS5Si_normal.png', 'Chintan Shah', '121427044', 2, '', '');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;


-- Dumping structure for table predicto.userlog
DROP TABLE IF EXISTS `userlog`;
CREATE TABLE IF NOT EXISTS `userlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `onuser` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

-- Dumping data for table predicto.userlog: ~32 rows (approximately)
/*!40000 ALTER TABLE `userlog` DISABLE KEYS */;
INSERT INTO `userlog` (`id`, `onuser`, `status`, `description`, `timestamp`) VALUES
	(1, 1, 1, 'User Address Edited', '2014-05-12 12:20:21'),
	(2, 1, 1, 'User Details Edited', '2014-05-12 12:21:43'),
	(3, 1, 1, 'User Details Edited', '2014-05-12 12:21:53'),
	(4, 4, 1, 'User Created', '2014-05-12 12:22:44'),
	(5, 4, 1, 'User Address Edited', '2014-05-12 18:01:48'),
	(6, 23, 2, 'User Created', '2014-10-07 12:16:55'),
	(7, 24, 2, 'User Created', '2014-10-07 12:18:25'),
	(8, 25, 2, 'User Created', '2014-10-07 12:19:04'),
	(9, 26, 2, 'User Created', '2014-10-07 12:19:16'),
	(10, 27, 2, 'User Created', '2014-10-07 12:22:18'),
	(11, 28, 2, 'User Created', '2014-10-07 12:22:45'),
	(12, 29, 2, 'User Created', '2014-10-07 12:23:10'),
	(13, 30, 2, 'User Created', '2014-10-07 12:23:33'),
	(14, 31, 2, 'User Created', '2014-10-07 12:25:03'),
	(15, 32, 2, 'User Created', '2014-10-07 12:25:33'),
	(16, 33, 2, 'User Created', '2014-10-07 12:29:32'),
	(17, 34, 2, 'User Created', '2014-10-07 12:31:18'),
	(18, 35, 2, 'User Created', '2014-10-07 12:31:50'),
	(19, 34, 2, 'User Details Edited', '2014-10-07 12:34:34'),
	(20, 18, 2, 'User Details Edited', '2014-10-07 12:35:11'),
	(21, 18, 2, 'User Details Edited', '2014-10-07 12:35:45'),
	(22, 18, 2, 'User Details Edited', '2014-10-07 12:36:03'),
	(23, 7, 6, 'User Created', '2014-10-17 11:52:29'),
	(24, 7, 6, 'User Details Edited', '2014-10-17 12:02:22'),
	(25, 7, 6, 'User Details Edited', '2014-10-17 12:02:37'),
	(26, 8, 6, 'User Created', '2014-11-15 17:35:52'),
	(27, 9, 6, 'User Created', '2014-12-02 16:16:36'),
	(28, 9, 6, 'User Details Edited', '2014-12-02 16:17:34'),
	(29, 4, 6, 'User Details Edited', '2014-12-03 16:04:49'),
	(30, 4, 6, 'User Details Edited', '2014-12-03 16:06:34'),
	(31, 4, 6, 'User Details Edited', '2014-12-03 16:06:49'),
	(32, 8, 6, 'User Details Edited', '2014-12-03 16:17:16');
/*!40000 ALTER TABLE `userlog` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
