-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2020 at 10:00 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `stc_logkeeper`
--

-- --------------------------------------------------------

--
-- Table structure for table `idcode_gen`
--

CREATE TABLE IF NOT EXISTS `idcode_gen` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dept` varchar(25) NOT NULL,
  `prefix` varchar(10) NOT NULL,
  `last_idNum` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `idcode_gen`
--

INSERT INTO `idcode_gen` (`id`, `dept`, `prefix`, `last_idNum`) VALUES
(1, 'Visitor', '20-', 4);

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` varchar(7) NOT NULL DEFAULT '-',
  `lname` varchar(55) NOT NULL DEFAULT '-',
  `fname` varchar(55) NOT NULL DEFAULT '-',
  `mname` varchar(55) NOT NULL DEFAULT '-',
  `birth_date` varchar(10) NOT NULL DEFAULT '-',
  `age` int(2) NOT NULL,
  `sex` varchar(6) NOT NULL DEFAULT 'Male',
  `phone_num` varchar(13) NOT NULL DEFAULT '+63**********',
  `zip_code` int(4) NOT NULL DEFAULT '0',
  `city_municipal` varchar(55) NOT NULL DEFAULT '-',
  `brgy` varchar(55) NOT NULL DEFAULT '-',
  `street` varchar(55) NOT NULL DEFAULT '-',
  `member_class` varchar(25) NOT NULL DEFAULT 'Visitor',
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_attendance`
--

CREATE TABLE IF NOT EXISTS `tbl_attendance` (
  `attend_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `body_temp` decimal(5,2) NOT NULL DEFAULT '0.00',
  `date_mm` varchar(2) NOT NULL,
  `date_dd` varchar(2) NOT NULL,
  `date_yyyy` varchar(4) NOT NULL,
  `log_time` varchar(12) NOT NULL DEFAULT '00:00:00 AM',
  `action` varchar(3) NOT NULL DEFAULT '-',
  `ref_log_id` int(11) NOT NULL,
  PRIMARY KEY (`attend_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_daily_hdf`
--

CREATE TABLE IF NOT EXISTS `tbl_daily_hdf` (
  `hdf_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `date_mm` int(11) NOT NULL,
  `date_dd` int(11) NOT NULL,
  `date_yyyy` int(11) NOT NULL,
  `q1` varchar(3) NOT NULL DEFAULT 'No',
  `q2` varchar(3) NOT NULL DEFAULT 'No',
  `q3` varchar(3) NOT NULL DEFAULT 'No',
  `q4` varchar(3) NOT NULL DEFAULT 'No',
  `q5_fever` varchar(4) NOT NULL DEFAULT 'None',
  `q5_cough` varchar(4) NOT NULL DEFAULT 'None',
  `q5_dbreath` varchar(4) NOT NULL DEFAULT 'None',
  `q5_bpains` varchar(4) NOT NULL DEFAULT 'None',
  `q5_sthroat` varchar(4) NOT NULL DEFAULT 'None',
  PRIMARY KEY (`hdf_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `useraccounts`
--

CREATE TABLE IF NOT EXISTS `useraccounts` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `reg_id` int(11) NOT NULL,
  `lname` varchar(55) NOT NULL,
  `fname` varchar(55) NOT NULL,
  `username` varchar(55) NOT NULL,
  `password` varchar(55) NOT NULL,
  `access` varchar(55) NOT NULL,
  `status` varchar(55) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `useraccounts`
--

INSERT INTO `useraccounts` (`user_id`, `reg_id`, `lname`, `fname`, `username`, `password`, `access`, `status`) VALUES
(1, 0, 'Magtolis', 'Emiloi', 'emiloi', 'a1Bz20ydqelm8m1wql21232f297a57a5a743894a0e4a801fc3', 'Administrator', 'Active');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
