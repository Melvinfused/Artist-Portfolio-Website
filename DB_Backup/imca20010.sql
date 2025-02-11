-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 20, 2024 at 02:02 PM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `imca20010`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
CREATE TABLE IF NOT EXISTS `bookings` (
  `bid` int NOT NULL AUTO_INCREMENT,
  `bprice` int NOT NULL,
  `cid` int NOT NULL,
  `qty` int NOT NULL,
  `showid` int NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`bid`),
  KEY `fk_cid` (`cid`),
  KEY `fk_showid` (`showid`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`bid`, `bprice`, `cid`, `qty`, `showid`, `status`) VALUES
(1, 8000, 2, 2, 1, 0),
(2, 8000, 2, 2, 1, 0),
(3, 3000, 2, 1, 2, 0),
(4, 6000, 2, 2, 2, 0),
(5, 3000, 2, 1, 2, 0),
(6, 16000, 2, 4, 1, 0),
(7, 8000, 2, 2, 1, 0),
(8, 16000, 2, 4, 1, 0),
(9, 16000, 1, 4, 1, 0),
(10, 3000, 1, 1, 2, 0),
(11, 9000, 1, 3, 2, 0),
(12, 16000, 1, 4, 1, 0),
(13, 8000, 2, 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `cid` int NOT NULL AUTO_INCREMENT,
  `username` varchar(35) NOT NULL,
  `password` varchar(35) NOT NULL,
  `email` varchar(30) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`cid`, `username`, `password`, `email`) VALUES
(1, 'Melvin Francy', '123', 'melvin@gmail.com'),
(2, 'Carl Johnson', '123', 'cj@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `discography`
--

DROP TABLE IF EXISTS `discography`;
CREATE TABLE IF NOT EXISTS `discography` (
  `tid` int NOT NULL AUTO_INCREMENT,
  `tname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `album` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `artist` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rdate` date NOT NULL,
  `art` varchar(500) NOT NULL,
  `url` varchar(2048) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `discography`
--

INSERT INTO `discography` (`tid`, `tname`, `album`, `artist`, `rdate`, `art`, `url`, `status`) VALUES
(14, 'Foxy Little Things', 'Foxy Little Things - Single', 'Infution', '2022-03-30', 'f690385835fc9c14be973e0ae55ec7ed_ec88ba8fabd7f20c51.jpg', 'https://open.spotify.com/track/3KDC9ecTeo2bGQvmMHlHTe?si=ecd608d5b3104225', 1),
(15, 'Mental Realm', 'Mental Realm - Single', 'Infution', '2022-09-19', '603b2f57139b3bc242e4e87aa98da36c_be3d3d23bf57.jpg', 'https://open.spotify.com/track/0QlikWYhMqazw6lwoQ0zjg?si=afbfa606412848bf', 1),
(17, 'Emergence', 'Emergence - Single', 'Infution', '2022-11-25', '12d3b01156008aa6389df344afd61e85_08509c97f9fea78e4.jpg', 'https://open.spotify.com/track/1W4LW1LEE0fDEI2E2Nxucj?si=c08baed63c804e79', 1),
(18, 'Nocturna', 'Nocturna - Single', 'Infution', '2023-01-16', '59c682799925a7c845e3593e5c788e10_7f31461c9d789.jpg', 'https://open.spotify.com/track/29BN6PEllY7MNP6un0qi3I?si=8bc8acb2893649b8', 1),
(19, 'Synaptic', 'Synaptic - Single', 'Infution', '2023-02-14', 'b23619c47eafe8c431ace2b5e10ee385_eb9b7f6c71.jpg', 'https://open.spotify.com/track/5kHwCK3xtTAWc7ldmAx0KY?si=94c5b1aa288046ba', 1),
(20, 'Ripple Effect', 'Ripple Effect - Single', 'Infution', '2023-08-28', 'f8b7f87d59b4f5d94ccd78355e0f6a49_8ef51d971d.jpg', 'https://open.spotify.com/track/3G9LNpLUauE6ITD3TpRRpg?si=385a02e985ba4c1a', 1),
(21, 'From Above', 'From Above - Single', 'Infution', '2024-01-23', 'de751393f40f02f9489a47e339efe5c8_7bbe0a1b3ac.jpg', 'https://open.spotify.com/track/02CNozgbisMYXqkKnOIeNU?si=bb3f420624f245f7', 1),
(22, 'Origins', 'Departure EP', 'Infution', '2024-05-22', 'f2847744b8f17f74c5b48327f1fd69dc_66a04243eae91.jpg', 'https://push.fm/fl/tly8mbon', 1),
(23, 'Exodus', 'Departure EP', 'Infution', '2024-05-22', '679a14652a537a6a6e8d952feee56b19_7c430b1ca5.jpg', 'https://push.fm/fl/tly8mbon', 1),
(24, 'Midjourney', 'Departure EP', 'Infution', '2024-05-22', '27c637325acaf52eee93c3c07a4116eb_870f9d8e2f05802.jpg', 'https://push.fm/fl/tly8mbon', 1),
(25, 'Cosmic Vibrato', 'Departure EP', 'Infution', '2024-05-22', 'fab74a674ad884a3f2c9d4b91193bd3f_806f2967c0b33abb.jpg', 'https://push.fm/fl/tly8mbon', 1);

-- --------------------------------------------------------

--
-- Table structure for table `highlight`
--

DROP TABLE IF EXISTS `highlight`;
CREATE TABLE IF NOT EXISTS `highlight` (
  `hid` int NOT NULL AUTO_INCREMENT,
  `background` varchar(1000) NOT NULL,
  `description` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `tid` int NOT NULL,
  PRIMARY KEY (`hid`),
  KEY `fk_foreign_key_name` (`tid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `highlight`
--

INSERT INTO `highlight` (`hid`, `background`, `description`, `tid`) VALUES
(1, '../customer/highlight/bg-1727622124.jpg', 'Departure EP is an electrifying journey through the DnB genre, featuring pulsating beats and intricate melodies that push the boundaries of electronic music. Each track invites listeners to explore new sonic landscapes, capturing the thrill of adventure and the essence of transformation. Experience the rhythm of departure and embrace the limitless possibilities of sound.', 22);

-- --------------------------------------------------------

--
-- Table structure for table `highlight2`
--

DROP TABLE IF EXISTS `highlight2`;
CREATE TABLE IF NOT EXISTS `highlight2` (
  `hid` int NOT NULL AUTO_INCREMENT,
  `background` varchar(1000) NOT NULL,
  `sid` int NOT NULL,
  PRIMARY KEY (`hid`),
  KEY `fk_highlight2_shows` (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `highlight2`
--

INSERT INTO `highlight2` (`hid`, `background`, `sid`) VALUES
(1, '../customer/highlight2/bg-1728922856.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `shows`
--

DROP TABLE IF EXISTS `shows`;
CREATE TABLE IF NOT EXISTS `shows` (
  `sid` int NOT NULL AUTO_INCREMENT,
  `sname` varchar(35) NOT NULL,
  `venue` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `price` int NOT NULL,
  `sdate` date NOT NULL,
  `blimit` int NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `shows`
--

INSERT INTO `shows` (`sid`, `sname`, `venue`, `price`, `sdate`, `blimit`, `status`) VALUES
(1, 'Hospitality At The Beach', 'Tisnoe, Croatia', 4000, '2024-09-28', 2000, 1),
(2, 'Hospitality At The Beach', 'Armada, Goa', 3000, '2024-10-31', 2000, 1);

-- --------------------------------------------------------

--
-- Table structure for table `visit_log`
--

DROP TABLE IF EXISTS `visit_log`;
CREATE TABLE IF NOT EXISTS `visit_log` (
  `vid` int NOT NULL AUTO_INCREMENT,
  `vcount` int NOT NULL,
  `ip` varchar(45) NOT NULL,
  `vdate` datetime NOT NULL,
  `vdevice` varchar(100) NOT NULL,
  PRIMARY KEY (`vid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `visit_log`
--

INSERT INTO `visit_log` (`vid`, `vcount`, `ip`, `vdate`, `vdevice`) VALUES
(1, 6, '127.0.0.1', '2024-10-19 04:07:05', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:130.0) Gecko/20100101 Firefox/130.0');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
