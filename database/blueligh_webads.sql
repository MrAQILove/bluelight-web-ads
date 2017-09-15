-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 15, 2017 at 12:14 PM
-- Server version: 5.5.48-cll
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `blueligh_webads`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_additional_contacts`
--

CREATE TABLE IF NOT EXISTS `tbl_additional_contacts` (
  `additional_contacts_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contacts_id` int(10) NOT NULL,
  `additional_contacts_title` varchar(250) NOT NULL DEFAULT '',
  `additional_contacts_first_name` varchar(250) NOT NULL DEFAULT '',
  `additional_contacts_last_name` varchar(250) NOT NULL DEFAULT '',
  `additional_contacts_branch_id` int(10) NOT NULL,
  `additional_contacts_phone` varchar(32) NOT NULL DEFAULT '',
  `additional_contacts_fax` varchar(32) NOT NULL DEFAULT '',
  `additional_contacts_email` varchar(255) NOT NULL DEFAULT '',
  `additional_contacts_active` int(4) NOT NULL,
  PRIMARY KEY (`additional_contacts_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_advert`
--

CREATE TABLE IF NOT EXISTS `tbl_advert` (
  `ct_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pd_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ct_qty` mediumint(8) unsigned NOT NULL DEFAULT '1',
  `ct_session_id` char(32) NOT NULL DEFAULT '',
  `ct_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`ct_id`),
  KEY `ad_id` (`pd_id`),
  KEY `ct_session_id` (`ct_session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_branch`
--

CREATE TABLE IF NOT EXISTS `tbl_branch` (
  `branch_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `state_id` int(10) unsigned NOT NULL DEFAULT '0',
  `branch_name` varchar(250) NOT NULL DEFAULT '',
  `branch_description` text NOT NULL,
  `contacts_id` int(10) unsigned NOT NULL DEFAULT '0',
  `branch_active` smallint(6) NOT NULL DEFAULT '1',
  `branch_created_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `branch_last_update` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`branch_id`),
  KEY `state_id` (`state_id`),
  KEY `branch_name` (`branch_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=72 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE IF NOT EXISTS `tbl_category` (
  `cat_id` int(10) unsigned NOT NULL,
  `cat_parent_id` int(11) NOT NULL DEFAULT '0',
  `cat_name` varchar(50) NOT NULL DEFAULT '',
  `cat_description` varchar(200) NOT NULL DEFAULT '',
  `cat_image` varchar(255) NOT NULL DEFAULT '',
  `cat_year_created` smallint(6) NOT NULL,
  `cat_active` tinyint(4) NOT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `cat_parent_id` (`cat_parent_id`),
  KEY `cat_name` (`cat_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contacts`
--

CREATE TABLE IF NOT EXISTS `tbl_contacts` (
  `contacts_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `contacts_title` varchar(250) NOT NULL DEFAULT '',
  `contacts_first_name` varchar(250) NOT NULL DEFAULT '',
  `contacts_last_name` varchar(250) NOT NULL DEFAULT '',
  `contacts_address1` varchar(250) NOT NULL DEFAULT '',
  `contacts_address2` varchar(250) NOT NULL DEFAULT '',
  `contacts_suburb` varchar(250) NOT NULL DEFAULT '',
  `state_id` int(10) unsigned NOT NULL DEFAULT '0',
  `contacts_postal_code` varchar(10) NOT NULL DEFAULT '',
  `contacts_postal_address1` varchar(250) NOT NULL,
  `contacts_postal_address2` varchar(250) NOT NULL DEFAULT '',
  `contacts_postal_suburb` varchar(250) NOT NULL DEFAULT '',
  `contacts_postal_state_id` int(10) NOT NULL,
  `contacts_postal_code1` varchar(10) NOT NULL DEFAULT '',
  `contacts_phone` varchar(32) NOT NULL DEFAULT '',
  `contacts_fax` varchar(32) NOT NULL DEFAULT '',
  `contacts_email` varchar(50) NOT NULL DEFAULT '',
  `contacts_branch_id` int(10) NOT NULL DEFAULT '0',
  `additional_contacts` smallint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`contacts_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_currency`
--

CREATE TABLE IF NOT EXISTS `tbl_currency` (
  `cy_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cy_code` char(3) NOT NULL DEFAULT '',
  `cy_symbol` varchar(8) NOT NULL DEFAULT '',
  PRIMARY KEY (`cy_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gallery`
--

CREATE TABLE IF NOT EXISTS `tbl_gallery` (
  `gallery_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gallery_title` varchar(250) NOT NULL DEFAULT '',
  `branch_id` int(10) unsigned NOT NULL DEFAULT '0',
  `state_id` int(10) unsigned NOT NULL DEFAULT '0',
  `gallery_event_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `gallery_no_photos` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`gallery_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpline`
--

CREATE TABLE IF NOT EXISTS `tbl_helpline` (
  `helpline_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `helpline_title` varchar(250) NOT NULL DEFAULT '',
  `helpline_text` text NOT NULL,
  `helpline_link` varchar(250) DEFAULT NULL,
  `helpline_image` varchar(250) DEFAULT NULL,
  `helpline_thumbnail` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`helpline_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_location`
--

CREATE TABLE IF NOT EXISTS `tbl_location` (
  `location_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location_name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`location_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE IF NOT EXISTS `tbl_product` (
  `pd_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pd_booking_no` char(10) NOT NULL,
  `pd_name` varchar(100) NOT NULL DEFAULT '',
  `pd_link` varchar(255) NOT NULL,
  `pd_description` text NOT NULL,
  `pd_state_id` int(10) unsigned NOT NULL,
  `pd_location_id` int(10) unsigned NOT NULL,
  `pd_image` varchar(200) DEFAULT NULL,
  `pd_thumbnail` varchar(200) DEFAULT NULL,
  `pd_start_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `pd_end_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`pd_id`),
  KEY `cat_id` (`cat_id`),
  KEY `pd_name` (`pd_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1216 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_shop_config`
--

CREATE TABLE IF NOT EXISTS `tbl_shop_config` (
  `sc_name` varchar(50) NOT NULL DEFAULT '',
  `sc_address` varchar(100) NOT NULL DEFAULT '',
  `sc_phone` varchar(30) NOT NULL DEFAULT '',
  `sc_email` varchar(30) NOT NULL DEFAULT '',
  `sc_shipping_cost` decimal(5,2) NOT NULL DEFAULT '0.00',
  `sc_currency` int(10) unsigned NOT NULL DEFAULT '1',
  `sc_order_email` enum('y','n') NOT NULL DEFAULT 'n'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_state`
--

CREATE TABLE IF NOT EXISTS `tbl_state` (
  `state_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `state_abbr` varchar(20) NOT NULL DEFAULT '',
  `state_name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`state_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_timetable`
--

CREATE TABLE IF NOT EXISTS `tbl_timetable` (
  `timetable_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `timetable_day` varchar(250) NOT NULL DEFAULT '',
  `timetable_date` date NOT NULL DEFAULT '0000-00-00',
  `timetable_start_time` time NOT NULL DEFAULT '00:00:00',
  `timetable_end_time` time NOT NULL DEFAULT '00:00:00',
  `timetable_age` varchar(50) NOT NULL,
  `venues_id` int(10) unsigned NOT NULL DEFAULT '0',
  `timetable_note` text NOT NULL,
  `timetable_price` decimal(9,2) NOT NULL DEFAULT '0.00',
  `branch_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`timetable_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_fullname` varchar(255) NOT NULL,
  `user_name` varchar(20) NOT NULL DEFAULT '',
  `user_password` varchar(32) NOT NULL DEFAULT '',
  `user_regdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_venues`
--

CREATE TABLE IF NOT EXISTS `tbl_venues` (
  `venues_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `venues_name` varchar(250) NOT NULL DEFAULT '',
  `venues_address1` varchar(250) NOT NULL DEFAULT '',
  `venues_address2` varchar(250) NOT NULL DEFAULT '',
  `venues_suburb` varchar(250) NOT NULL DEFAULT '',
  `state_id` int(10) unsigned NOT NULL DEFAULT '0',
  `venues_postal_code` varchar(10) NOT NULL DEFAULT '',
  `branch_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`venues_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
