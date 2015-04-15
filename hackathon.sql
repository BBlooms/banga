-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 19, 2013 at 07:26 PM
-- Server version: 5.5.29
-- PHP Version: 5.4.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hackathon`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_item`
--

CREATE TABLE `cart_item` (
  `ciid` int(16) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `iid` int(16) NOT NULL,
  `quantity` int(3) NOT NULL,
  `tid` int(16) NOT NULL,
  `amount` varchar(10) NOT NULL,
  PRIMARY KEY (`ciid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `cart_item`
--

INSERT INTO `cart_item` (`ciid`, `uid`, `iid`, `quantity`, `tid`, `amount`) VALUES
(1, 5, 1, 1, 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `usd` float NOT NULL,
  `eur` float NOT NULL,
  `inr` float NOT NULL,
  `pkr` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`usd`, `eur`, `inr`, `pkr`) VALUES
(158.4, 115.9, 9704, 16810);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `iid` int(16) NOT NULL,
  `uid` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `price` varchar(30) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `photo` varchar(100) NOT NULL,
  `description` varchar(320) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`iid`, `uid`, `name`, `price`, `unit`, `photo`, `description`) VALUES
(1, 5, 'Tomato', '0.70', 'lbs', 'images/items/tomato.jpeg', 'Organic tomato produced from Derik''s farm.');

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `uid` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `photo` blob NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`uid`, `name`, `photo`) VALUES
(2, 'ABC Grocery', ''),
(5, 'Akash''s Grocery', ''),
(1, 'Bungalow Electronics', ''),
(4, 'Home Supply', ''),
(6, 'Indu''s Bookstore', ''),
(3, 'Jay Haircut', '');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `tid` int(16) NOT NULL,
  `uid_from` int(16) NOT NULL,
  `uid_to` int(16) NOT NULL,
  `amount` varchar(30) NOT NULL,
  `send_date` datetime NOT NULL,
  `receive_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` int(10) NOT NULL AUTO_INCREMENT,
  `cell_number` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `deposit` varchar(30) NOT NULL DEFAULT '0',
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(30) DEFAULT NULL,
  `state` varchar(30) DEFAULT NULL,
  `zipcode` varchar(10) DEFAULT NULL,
  `country` varchar(20) DEFAULT NULL,
  `card_number` varchar(16) DEFAULT NULL,
  `card_expiration` varchar(5) DEFAULT NULL,
  `card_secret` varchar(4) DEFAULT NULL,
  `currency` varchar(4) NOT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `cell_number`, `password`, `first_name`, `last_name`, `deposit`, `address`, `city`, `state`, `zipcode`, `country`, `card_number`, `card_expiration`, `card_secret`, `currency`) VALUES
(1, '4156870581', 'e7356a60999ecf64cdea8b875f8899ae', 'Dirk', 'de Wit', '5093.2', '2299 Piedmont Ave', 'Berkeley', 'California', '94720', '', '1234123412341234', '08/1', '399', 'usd'),
(2, '+1-4151234567', '9cdfb439c7876e703e307864c9167a15', 'Bob', 'Johnson', '116.8', '', '', '', '', '', '', '', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
