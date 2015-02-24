-- phpMyAdmin SQL Dump
-- version 4.1.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 13, 2015 at 10:12 PM
-- Server version: 5.5.34-cll-lve
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `badrater_terrabol`
--

-- --------------------------------------------------------

--
-- Table structure for table `debt`
--

DROP TABLE IF EXISTS `debt`;
CREATE TABLE IF NOT EXISTS `debt` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `shop_id` int(5) NOT NULL,
  `deptor_id` int(5) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `bs` decimal(10,2) DEFAULT NULL,
  `sus` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `deptor_id` (`deptor_id`),
  KEY `store_id` (`shop_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `debt`
--

INSERT INTO `debt` (`id`, `shop_id`, `deptor_id`, `date`, `description`, `bs`, `sus`) VALUES
(19, 1, 8, '2013-06-09', 'deudor de huayna', '0.00', '500.00'),
(20, 1, 8, '2013-06-09', 'prueba', '1000.00', '0.00'),
(21, 7, 8, '2013-06-09', 'cancelar', '1000.00', '0.00'),
(22, 7, 8, '2013-06-09', 'aaaaa', '0.00', '300.00');

-- --------------------------------------------------------

--
-- Table structure for table `deptor`
--

DROP TABLE IF EXISTS `deptor`;
CREATE TABLE IF NOT EXISTS `deptor` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `info` text,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `deptor`
--

INSERT INTO `deptor` (`id`, `name`, `info`) VALUES
(7, 'alex gay', ''),
(8, 'greco', '');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

DROP TABLE IF EXISTS `expense`;
CREATE TABLE IF NOT EXISTS `expense` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `shop_id` int(5) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `bs` decimal(10,2) DEFAULT NULL,
  `sus` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `store_id` (`shop_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
CREATE TABLE IF NOT EXISTS `invoice` (
  `invoice_id` int(5) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `invoice_number` text NOT NULL,
  PRIMARY KEY (`invoice_id`),
  UNIQUE KEY `invoice_id` (`invoice_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`invoice_id`, `date`, `invoice_number`) VALUES
(16, '2013-06-05', '0000'),
(17, '2013-06-09', '4444'),
(18, '2013-06-09', '111111'),
(19, '2013-10-17', '0001');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `user` int(5) NOT NULL,
  `permission` char(1) NOT NULL DEFAULT 'x',
  `store_v` char(1) NOT NULL DEFAULT 'x',
  `store_a` char(1) NOT NULL DEFAULT 'x',
  `store_d` char(1) NOT NULL DEFAULT 'x',
  `shop_v` char(1) NOT NULL DEFAULT 'x',
  `shop_a` char(1) NOT NULL DEFAULT 'x',
  `shop_d` char(1) NOT NULL DEFAULT 'x',
  `tyre_a` char(1) NOT NULL DEFAULT 'x',
  `tyre_d` char(1) NOT NULL DEFAULT 'x',
  `supplier_a` char(1) NOT NULL DEFAULT 'x',
  `supplier_d` char(1) NOT NULL DEFAULT 'x',
  `deptor_a` char(1) NOT NULL DEFAULT 'x',
  `deptor_d` char(1) NOT NULL DEFAULT 'x',
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `user`, `permission`, `store_v`, `store_a`, `store_d`, `shop_v`, `shop_a`, `shop_d`, `tyre_a`, `tyre_d`, `supplier_a`, `supplier_d`, `deptor_a`, `deptor_d`) VALUES
(2, 1, 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y'),
(11, 11, 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y'),
(12, 12, 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x'),
(13, 13, 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x');

-- --------------------------------------------------------

--
-- Table structure for table `role_shop`
--

DROP TABLE IF EXISTS `role_shop`;
CREATE TABLE IF NOT EXISTS `role_shop` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `user` int(5) NOT NULL,
  `shop_id` int(5) NOT NULL,
  `mov_v` char(1) NOT NULL DEFAULT 'x',
  `mov_a` char(1) NOT NULL DEFAULT 'x',
  `mov_d` char(1) NOT NULL DEFAULT 'x',
  `mov_o` char(1) NOT NULL DEFAULT 'x',
  PRIMARY KEY (`id`),
  KEY `user` (`user`,`shop_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `role_shop`
--

INSERT INTO `role_shop` (`id`, `user`, `shop_id`, `mov_v`, `mov_a`, `mov_d`, `mov_o`) VALUES
(2, 1, 1, 'y', 'y', 'y', 'y'),
(33, 1, 7, 'y', 'y', 'y', 'y'),
(38, 1, 8, 'y', 'y', 'y', 'y'),
(40, 1, 9, 'y', 'y', 'y', 'y'),
(42, 11, 1, 'y', 'y', 'y', 'y'),
(43, 11, 8, 'y', 'y', 'y', 'y'),
(44, 11, 9, 'y', 'y', 'y', 'y'),
(45, 11, 7, 'y', 'y', 'y', 'y'),
(46, 1, 10, 'x', 'x', 'x', 'x'),
(47, 11, 10, 'y', 'y', 'y', 'y'),
(52, 1, 12, 'y', 'y', 'y', 'y'),
(53, 11, 12, 'y', 'x', 'x', 'y'),
(55, 12, 1, 'x', 'x', 'x', 'x'),
(56, 12, 12, 'x', 'x', 'x', 'x'),
(57, 12, 8, 'x', 'x', 'x', 'x'),
(58, 12, 9, 'x', 'x', 'x', 'x'),
(59, 12, 10, 'x', 'x', 'x', 'x'),
(60, 12, 7, 'y', 'y', 'y', 'y'),
(61, 13, 1, 'x', 'x', 'x', 'x'),
(62, 13, 12, 'x', 'x', 'x', 'x'),
(63, 13, 8, 'x', 'x', 'x', 'x'),
(64, 13, 9, 'x', 'x', 'x', 'x'),
(65, 13, 10, 'x', 'x', 'x', 'x'),
(66, 13, 7, 'x', 'x', 'x', 'x');

-- --------------------------------------------------------

--
-- Table structure for table `role_store`
--

DROP TABLE IF EXISTS `role_store`;
CREATE TABLE IF NOT EXISTS `role_store` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `user` int(5) NOT NULL,
  `store_id` int(5) NOT NULL,
  `mov_v` char(1) NOT NULL DEFAULT 'x',
  `mov_a` char(1) NOT NULL DEFAULT 'x',
  `mov_d` char(1) NOT NULL DEFAULT 'x',
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `store_id` (`store_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=75 ;

--
-- Dumping data for table `role_store`
--

INSERT INTO `role_store` (`id`, `user`, `store_id`, `mov_v`, `mov_a`, `mov_d`) VALUES
(9, 1, 6, 'y', 'y', 'y'),
(46, 1, 7, 'y', 'y', 'y'),
(50, 1, 8, 'y', 'y', 'y'),
(52, 1, 9, 'y', 'y', 'x'),
(54, 1, 10, 'y', 'y', 'y'),
(56, 11, 9, 'y', 'y', 'y'),
(57, 11, 6, 'y', 'y', 'y'),
(58, 11, 7, 'y', 'y', 'y'),
(59, 11, 8, 'y', 'y', 'y'),
(60, 11, 10, 'y', 'y', 'y'),
(61, 12, 9, 'x', 'x', 'x'),
(62, 12, 6, 'x', 'x', 'x'),
(63, 12, 7, 'x', 'x', 'x'),
(64, 12, 8, 'x', 'x', 'x'),
(65, 12, 10, 'x', 'x', 'x'),
(66, 1, 11, 'y', 'y', 'y'),
(67, 11, 11, 'y', 'y', 'y'),
(68, 12, 11, 'y', 'x', 'x'),
(69, 13, 9, 'x', 'x', 'x'),
(70, 13, 6, 'x', 'x', 'x'),
(71, 13, 7, 'x', 'x', 'x'),
(72, 13, 8, 'x', 'x', 'x'),
(73, 13, 10, 'x', 'x', 'x'),
(74, 13, 11, 'x', 'x', 'x');

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

DROP TABLE IF EXISTS `shop`;
CREATE TABLE IF NOT EXISTS `shop` (
  `shop_id` int(5) NOT NULL AUTO_INCREMENT,
  `shop_name` varchar(25) NOT NULL,
  `shop_info` text NOT NULL,
  PRIMARY KEY (`shop_id`),
  UNIQUE KEY `shop_id` (`shop_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`shop_id`, `shop_name`, `shop_info`) VALUES
(1, 'BARRIENTOS', 'Av. Barrientos           Telf.: 4569531 , 4561218'),
(7, 'SERVITERRA', 'Av. Melchor Perez      Telf.: 4445025'),
(8, 'HUAYNA KAPAC', 'Av. Huayna Kapac  telf. 4583554'),
(9, 'QUILLACOLLO', 'Av. Blanco Galindo      Telf.: 4390750'),
(10, 'SANTA CRUZ', 'Av. 4to Anillo,     telf.: 71711169'),
(12, 'chiriguano', '');

-- --------------------------------------------------------

--
-- Table structure for table `shop_entries_outs`
--

DROP TABLE IF EXISTS `shop_entries_outs`;
CREATE TABLE IF NOT EXISTS `shop_entries_outs` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `shop_id` int(5) NOT NULL,
  `tyre_id` int(5) NOT NULL,
  `source_store` int(5) DEFAULT NULL,
  `source_shop` int(5) DEFAULT NULL,
  `date` date NOT NULL,
  `date_save` datetime NOT NULL,
  `entry_out` varchar(5) NOT NULL,
  `employee` text,
  `amount` int(10) NOT NULL DEFAULT '0',
  `deptor_id` int(5) DEFAULT NULL,
  `payment_bs` decimal(10,2) DEFAULT '0.00',
  `payment_sus` decimal(10,2) DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `tyre_id` (`tyre_id`),
  KEY `source_store` (`source_store`),
  KEY `source_shop` (`source_shop`),
  KEY `shop_id` (`shop_id`),
  KEY `shop_id_2` (`shop_id`),
  KEY `shop_id_3` (`shop_id`),
  KEY `deptor_id` (`deptor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=126 ;

--
-- Dumping data for table `shop_entries_outs`
--

INSERT INTO `shop_entries_outs` (`id`, `shop_id`, `tyre_id`, `source_store`, `source_shop`, `date`, `date_save`, `entry_out`, `employee`, `amount`, `deptor_id`, `payment_bs`, `payment_sus`) VALUES
(53, 1, 15, NULL, NULL, '2013-06-05', '2013-06-05 15:28:59', 'sale', '', 10, NULL, '0.00', '1000.00'),
(54, 1, 15, NULL, 7, '2013-06-05', '2013-06-05 15:29:35', 'out', '', 10, NULL, '0.00', '0.00'),
(55, 7, 53, NULL, 1, '2013-06-09', '2013-06-09 10:35:43', 'out', '', 20, NULL, '0.00', '0.00'),
(56, 1, 53, NULL, NULL, '2013-06-09', '2013-06-09 10:43:21', 'sale', '', 5, 7, '0.00', '500.00'),
(57, 7, 53, NULL, NULL, '2013-06-09', '2013-06-09 10:45:41', 'sale', '', 5, 8, '0.00', '500.00'),
(58, 7, 15, NULL, NULL, '2013-06-09', '2013-06-09 10:45:41', 'sale', '', 5, 7, '0.00', '550.00'),
(59, 1, 15, NULL, 7, '2013-06-09', '2013-06-09 11:28:58', 'out', '', 2, NULL, '0.00', '0.00'),
(60, 1, 53, NULL, 7, '2013-06-09', '2013-06-09 11:29:10', 'out', '', 2, NULL, '0.00', '0.00'),
(61, 1, 73, NULL, 7, '2013-06-09', '2013-06-09 11:30:37', 'out', '', 10, NULL, '0.00', '0.00'),
(62, 1, 15, NULL, 7, '2013-06-09', '2013-06-09 11:34:14', 'out', '', 2, NULL, '0.00', '0.00'),
(63, 1, 53, NULL, 7, '2013-06-09', '2013-06-09 11:34:15', 'out', '', 2, NULL, '0.00', '0.00'),
(64, 1, 53, NULL, 7, '2013-06-09', '2013-06-09 11:36:44', 'out', '', 10, NULL, '0.00', '0.00'),
(65, 1, 53, NULL, NULL, '2013-10-17', '2013-10-17 16:12:34', 'sale', '', 1, NULL, '0.00', '0.00'),
(66, 1, 53, NULL, NULL, '2013-10-17', '2013-10-17 16:12:46', 'sale', '', 1, NULL, '10.00', '0.00'),
(67, 1, 53, NULL, NULL, '2013-10-17', '2013-10-17 16:13:13', 'sale', '', 1, NULL, '10.00', '0.00'),
(68, 1, 73, NULL, NULL, '2013-10-17', '2013-10-17 16:13:14', 'sale', '', 40, NULL, '40.00', '0.00'),
(69, 1, 15, NULL, NULL, '2013-10-17', '2013-10-17 16:14:50', 'sale', '', 6, NULL, '60.00', '0.00'),
(70, 7, 53, NULL, NULL, '2013-10-17', '2013-10-17 16:17:24', 'sale', '', 38, 7, '0.00', '10000.00'),
(71, 7, 53, NULL, NULL, '2013-10-17', '2013-10-17 16:19:59', 'sale', '', 1, NULL, '0.00', '10.00'),
(72, 7, 73, NULL, NULL, '2013-10-17', '2013-10-17 16:23:58', 'sale', '', 10, NULL, '10.00', '0.00'),
(73, 7, 15, NULL, NULL, '2013-10-17', '2013-10-17 16:40:05', 'sale', '', 4, NULL, '0.00', '220.00'),
(74, 1, 53, NULL, NULL, '2013-10-17', '2013-10-17 17:23:23', 'sale', '', 2, NULL, '0.00', '400.00'),
(75, 8, 15, NULL, NULL, '2013-10-28', '2013-10-28 16:17:54', 'sale', '', 10, NULL, '2000.00', '0.00'),
(76, 8, 15, NULL, NULL, '2013-10-28', '2013-10-28 16:23:49', 'sale', '', 2, 7, '1000.00', '0.00'),
(77, 8, 15, NULL, NULL, '2013-10-28', '2013-10-28 16:24:52', 'sale', '', 2, NULL, '2000.00', '0.00'),
(78, 1, 15, NULL, NULL, '2013-10-28', '2013-10-28 18:23:40', 'sale', '', 2, NULL, '10.00', '0.00'),
(80, 8, 15, NULL, NULL, '2013-11-05', '2013-11-05 15:31:27', 'sale', '', 2, NULL, '1000.00', '0.00'),
(81, 8, 15, NULL, 1, '2013-11-05', '2013-11-05 15:32:15', 'out', '', 2, NULL, '0.00', '0.00'),
(82, 8, 15, NULL, NULL, '2013-11-05', '2013-11-05 16:51:00', 'sale', '', 2, NULL, '10.00', '0.00'),
(83, 7, 15, NULL, NULL, '2013-11-05', '2013-11-05 16:51:21', 'sale', '', 5, NULL, '10.00', '0.00'),
(84, 12, 53, NULL, 8, '2013-11-05', '2013-11-05 17:14:13', 'out', '', 2, NULL, '0.00', '0.00'),
(85, 12, 63, NULL, NULL, '2014-10-27', '2014-10-27 09:33:33', 'sale', '', 2, NULL, '2000.00', '0.00'),
(86, 7, 106, NULL, NULL, '2014-12-18', '2014-12-18 17:57:48', 'sale', '', 2, NULL, '0.00', '700.00'),
(87, 7, 106, NULL, NULL, '2014-12-18', '2014-12-18 17:57:48', 'sale', '', 2, NULL, '4900.00', '0.00'),
(88, 7, 119, NULL, NULL, '2014-12-19', '2014-12-19 16:23:07', 'sale', '', 2, NULL, '580.00', '0.00'),
(89, 7, 223, NULL, NULL, '2014-12-19', '2014-12-19 16:24:03', 'sale', '', 4, NULL, '0.00', '0.00'),
(90, 7, 228, NULL, NULL, '2014-12-19', '2014-12-19 18:01:54', 'sale', '', 2, NULL, '1010.00', '0.00'),
(91, 7, 43, NULL, NULL, '2015-01-02', '2015-01-02 16:34:33', 'sale', '', 2, NULL, '0.00', '0.00'),
(92, 7, 119, NULL, NULL, '2015-01-02', '2015-01-02 16:37:36', 'sale', '', 4, NULL, '0.00', '0.00'),
(93, 7, 53, NULL, NULL, '2015-01-02', '2015-01-02 16:39:54', 'sale', '', 2, NULL, '4850.00', '0.00'),
(94, 7, 125, NULL, NULL, '2015-01-02', '2015-01-02 16:40:21', 'sale', '', 2, NULL, '820.00', '0.00'),
(95, 7, 175, NULL, NULL, '2015-01-02', '2015-01-02 16:45:38', 'sale', '', 2, NULL, '100.00', '0.00'),
(96, 7, 119, NULL, NULL, '2015-01-02', '2015-01-02 16:47:35', 'sale', '', 2, NULL, '580.00', '0.00'),
(97, 7, 210, NULL, NULL, '2015-01-02', '2015-01-02 16:50:21', 'sale', '', 2, NULL, '120.00', '0.00'),
(98, 7, 209, NULL, NULL, '2015-01-02', '2015-01-02 16:51:28', 'sale', '', 2, NULL, '0.00', '0.00'),
(99, 7, 119, NULL, NULL, '2015-01-02', '2015-01-02 16:52:19', 'sale', '', 2, NULL, '200.00', '0.00'),
(100, 7, 216, NULL, NULL, '2015-01-02', '2015-01-02 16:53:20', 'sale', '', 2, NULL, '0.00', '0.00'),
(101, 7, 175, NULL, NULL, '2015-01-02', '2015-01-02 16:55:45', 'sale', '', 6, NULL, '2760.00', '0.00'),
(102, 8, 119, NULL, 7, '2014-12-17', '2015-01-02 16:57:07', 'out', '', 15, NULL, '0.00', '0.00'),
(103, 8, 155, NULL, 7, '2014-12-17', '2015-01-02 16:57:07', 'out', '', 4, NULL, '0.00', '0.00'),
(104, 7, 223, NULL, NULL, '2015-01-02', '2015-01-02 16:57:23', 'sale', '', 2, NULL, '0.00', '0.00'),
(105, 7, 155, NULL, NULL, '2015-01-02', '2015-01-02 16:58:17', 'sale', '', 1, NULL, '2400.00', '0.00'),
(106, 8, 187, NULL, 7, '2014-12-19', '2015-01-02 16:58:45', 'out', '', 4, NULL, '0.00', '0.00'),
(107, 8, 235, NULL, 7, '2014-12-19', '2015-01-02 16:58:45', 'out', '', 4, NULL, '0.00', '0.00'),
(108, 8, 234, NULL, 7, '2014-12-19', '2015-01-02 16:58:45', 'out', '', 2, NULL, '0.00', '0.00'),
(109, 8, 214, NULL, 7, '2014-12-19', '2015-01-02 17:05:46', 'out', '', 2, NULL, '0.00', '0.00'),
(110, 8, 128, NULL, 7, '2014-12-19', '2015-01-02 17:05:46', 'out', '', 2, NULL, '0.00', '0.00'),
(111, 8, 223, NULL, 7, '2014-12-22', '2015-01-02 17:07:08', 'out', '', 10, NULL, '0.00', '0.00'),
(112, 8, 185, NULL, 7, '2014-12-22', '2015-01-02 17:07:08', 'out', '', 2, NULL, '0.00', '0.00'),
(113, 8, 213, NULL, 7, '2014-12-22', '2015-01-02 17:07:08', 'out', '', 2, NULL, '0.00', '0.00'),
(114, 7, 53, NULL, 8, '2014-12-22', '2015-01-02 17:08:14', 'out', '', 6, NULL, '0.00', '0.00'),
(115, 7, 45, NULL, 8, '2014-12-22', '2015-01-02 17:08:14', 'out', '', 2, NULL, '0.00', '0.00'),
(116, 7, 45, NULL, 8, '2014-12-22', '2015-01-02 17:08:50', 'out', '', 2, NULL, '0.00', '0.00'),
(117, 7, 43, NULL, NULL, '2015-01-03', '2015-01-03 15:09:07', 'sale', '', 1, NULL, '410.00', '0.00'),
(118, 7, 230, NULL, NULL, '2015-01-03', '2015-01-03 15:09:07', 'sale', '', 2, NULL, '900.00', '0.00'),
(119, 7, 215, NULL, NULL, '2015-01-03', '2015-01-03 15:09:07', 'sale', '', 2, NULL, '0.00', '0.00'),
(120, 7, 155, NULL, NULL, '2015-01-03', '2015-01-03 15:09:07', 'sale', '', 2, NULL, '4800.00', '0.00'),
(121, 7, 221, NULL, NULL, '2015-01-03', '2015-01-03 15:09:07', 'sale', '', 1, NULL, '2300.00', '0.00'),
(122, 7, 119, NULL, NULL, '2015-01-03', '2015-01-03 15:12:09', 'sale', '', 4, NULL, '0.00', '0.00'),
(123, 7, 223, NULL, NULL, '2015-01-03', '2015-01-03 15:12:09', 'sale', '', 2, NULL, '0.00', '100.00'),
(124, 7, 223, NULL, NULL, '2015-01-03', '2015-01-03 15:12:09', 'sale', '', 4, NULL, '0.00', '0.00'),
(125, 7, 119, NULL, NULL, '2015-01-10', '2015-01-10 11:40:00', 'sale', '', 1, NULL, '0.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
CREATE TABLE IF NOT EXISTS `stock` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `tyre_id` int(5) NOT NULL,
  `store_id` int(5) DEFAULT NULL,
  `shop_id` int(5) DEFAULT NULL,
  `quantity` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tyre_id` (`tyre_id`,`store_id`,`shop_id`),
  KEY `store_id` (`store_id`),
  KEY `shop_id` (`shop_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=316 ;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `tyre_id`, `store_id`, `shop_id`, `quantity`) VALUES
(23, 15, 6, NULL, 0),
(24, 15, NULL, 1, 0),
(25, 15, NULL, 7, 0),
(26, 53, 6, NULL, 0),
(27, 53, NULL, 7, 2),
(28, 53, NULL, 1, 0),
(29, 73, 6, NULL, 0),
(30, 73, NULL, 1, 0),
(31, 73, NULL, 7, 2),
(32, 16, 8, NULL, 0),
(33, 106, 8, NULL, 106),
(34, 161, 8, NULL, 7),
(35, 29, 7, NULL, 8),
(36, 43, 7, NULL, 11),
(37, 18, 7, NULL, 76),
(38, 106, 7, NULL, 71),
(39, 177, 7, NULL, 30),
(40, 71, 7, NULL, 46),
(41, 179, 7, NULL, 50),
(42, 180, 7, NULL, 40),
(43, 112, 7, NULL, 23),
(44, 111, 7, NULL, 44),
(45, 162, 7, NULL, 42),
(46, 139, 7, NULL, 12),
(47, 138, 7, NULL, 60),
(48, 183, 7, NULL, 2),
(49, 182, 7, NULL, 9),
(50, 63, 6, NULL, 46),
(51, 179, 6, NULL, 154),
(52, 19, 6, NULL, 72),
(53, 78, 6, NULL, 108),
(54, 184, 6, NULL, 16),
(55, 164, 6, NULL, 66),
(56, 165, 6, NULL, 14),
(57, 166, 6, NULL, 16),
(58, 167, 6, NULL, 8),
(59, 168, 6, NULL, 44),
(60, 169, 6, NULL, 20),
(61, 170, 6, NULL, 156),
(62, 161, 6, NULL, 20),
(63, 162, 6, NULL, 90),
(64, 157, 6, NULL, 0),
(65, 158, 6, NULL, 98),
(66, 185, 6, NULL, 30),
(67, 159, 6, NULL, 16),
(68, 187, 6, NULL, 0),
(69, 189, 6, NULL, 20),
(70, 15, NULL, 8, 5),
(71, 53, 9, NULL, 0),
(72, 53, NULL, 12, 0),
(73, 53, NULL, 8, 8),
(74, 16, NULL, 12, 8),
(75, 106, NULL, 12, 16),
(76, 161, NULL, 12, 6),
(77, 29, NULL, 12, 10),
(78, 177, NULL, 12, 8),
(79, 18, NULL, 12, 20),
(80, 139, NULL, 12, 48),
(81, 44, 7, NULL, 9),
(82, 192, 7, NULL, 22),
(83, 63, NULL, 12, 16),
(84, 19, NULL, 12, 20),
(85, 165, NULL, 12, 4),
(86, 166, NULL, 12, 14),
(87, 170, NULL, 12, 20),
(88, 162, NULL, 12, 10),
(89, 158, NULL, 12, 26),
(90, 185, NULL, 12, 30),
(91, 3, 6, NULL, 20),
(92, 9, 6, NULL, 59),
(93, 27, 6, NULL, 38),
(94, 30, 6, NULL, 32),
(95, 118, 6, NULL, 60),
(96, 187, NULL, 12, 15),
(97, 157, NULL, 12, 83),
(98, 16, 10, NULL, 0),
(99, 15, 10, NULL, 0),
(100, 3, 10, NULL, 0),
(101, 9, 10, NULL, 0),
(102, 27, 10, NULL, 0),
(103, 30, 10, NULL, 0),
(104, 29, 10, NULL, 0),
(105, 33, 10, NULL, 0),
(106, 37, 10, NULL, 0),
(107, 34, 10, NULL, 0),
(108, 51, 10, NULL, 0),
(109, 42, 10, NULL, 0),
(110, 38, 10, NULL, 0),
(111, 43, 10, NULL, 0),
(112, 41, 10, NULL, 0),
(113, 40, 10, NULL, 0),
(114, 44, 10, NULL, 0),
(115, 194, 10, NULL, 0),
(116, 195, 10, NULL, 0),
(117, 193, 10, NULL, 0),
(118, 194, 8, NULL, 2),
(119, 33, 8, NULL, 2),
(120, 51, 8, NULL, 2),
(121, 195, 8, NULL, 2),
(122, 43, 8, NULL, 14),
(123, 41, 8, NULL, 4),
(124, 45, 8, NULL, 4),
(125, 47, 8, NULL, 2),
(126, 53, 8, NULL, 10),
(127, 194, 11, NULL, 0),
(128, 33, 11, NULL, 0),
(129, 51, 11, NULL, 0),
(130, 195, 11, NULL, 0),
(131, 43, 11, NULL, 0),
(132, 41, 11, NULL, 0),
(133, 45, 11, NULL, 0),
(134, 47, 11, NULL, 0),
(135, 53, 11, NULL, 0),
(136, 70, 11, NULL, 0),
(137, 19, 11, NULL, 0),
(138, 73, 11, NULL, 0),
(139, 18, 11, NULL, 0),
(140, 78, 11, NULL, 0),
(141, 196, 11, NULL, 0),
(142, 197, 11, NULL, 0),
(143, 198, 11, NULL, 0),
(144, 166, 11, NULL, 0),
(145, 170, 11, NULL, 0),
(146, 199, 11, NULL, 0),
(147, 200, 11, NULL, 0),
(148, 106, 11, NULL, 0),
(149, 111, 11, NULL, 0),
(150, 115, 11, NULL, 0),
(151, 116, 11, NULL, 0),
(152, 125, 11, NULL, 0),
(153, 129, 11, NULL, 0),
(154, 131, 11, NULL, 0),
(155, 127, 11, NULL, 0),
(156, 155, 11, NULL, 0),
(157, 154, 11, NULL, 0),
(158, 202, 11, NULL, 0),
(159, 203, 11, NULL, 0),
(160, 204, 11, NULL, 0),
(161, 205, 11, NULL, 0),
(162, 162, 11, NULL, 0),
(163, 158, 11, NULL, 0),
(164, 185, 11, NULL, 0),
(165, 173, 11, NULL, 0),
(166, 171, 11, NULL, 0),
(167, 206, 11, NULL, 0),
(168, 207, 11, NULL, 0),
(169, 208, 11, NULL, 0),
(170, 209, 11, NULL, 0),
(171, 210, 11, NULL, 0),
(172, 211, 11, NULL, 0),
(173, 212, 11, NULL, 0),
(174, 213, 11, NULL, 0),
(175, 215, 11, NULL, 0),
(176, 216, 11, NULL, 0),
(177, 218, 11, NULL, 0),
(178, 118, 11, NULL, 0),
(179, 219, 11, NULL, 0),
(180, 220, 11, NULL, 0),
(181, 221, 11, NULL, 0),
(182, 222, 11, NULL, 0),
(183, 175, 11, NULL, 0),
(184, 176, 11, NULL, 0),
(185, 119, 11, NULL, 0),
(186, 100, 11, NULL, 0),
(187, 223, 11, NULL, 0),
(188, 224, 11, NULL, 0),
(189, 226, 11, NULL, 0),
(190, 227, 11, NULL, 0),
(191, 228, 11, NULL, 0),
(192, 229, 11, NULL, 0),
(193, 230, 11, NULL, 0),
(194, 138, 11, NULL, 0),
(195, 139, 11, NULL, 0),
(196, 94, 11, NULL, 0),
(197, 194, NULL, 7, 2),
(198, 33, NULL, 7, 2),
(199, 51, NULL, 7, 2),
(200, 195, NULL, 7, 2),
(201, 43, NULL, 7, 11),
(202, 41, NULL, 7, 4),
(203, 45, NULL, 7, 0),
(204, 47, NULL, 7, 2),
(205, 70, NULL, 7, 2),
(206, 19, NULL, 7, 2),
(207, 18, NULL, 7, 4),
(208, 78, NULL, 7, 2),
(209, 196, NULL, 7, 4),
(210, 197, NULL, 7, 4),
(211, 198, NULL, 7, 2),
(212, 166, NULL, 7, 2),
(213, 170, NULL, 7, 2),
(214, 199, NULL, 7, 2),
(215, 200, NULL, 7, 3),
(216, 106, NULL, 7, 2),
(217, 111, NULL, 7, 4),
(218, 115, NULL, 7, 3),
(219, 116, NULL, 7, 1),
(220, 125, NULL, 7, 10),
(221, 129, NULL, 7, 2),
(222, 131, NULL, 7, 1),
(223, 127, NULL, 7, 4),
(224, 155, NULL, 7, 5),
(225, 154, NULL, 7, 4),
(226, 202, NULL, 7, 4),
(227, 203, NULL, 7, 6),
(228, 204, NULL, 7, 4),
(229, 205, NULL, 7, 10),
(230, 162, NULL, 7, 2),
(231, 158, NULL, 7, 1),
(232, 185, NULL, 7, 4),
(233, 173, NULL, 7, 2),
(234, 171, NULL, 7, 2),
(235, 206, NULL, 7, 2),
(236, 207, NULL, 7, 2),
(237, 208, NULL, 7, 2),
(238, 209, NULL, 7, 2),
(239, 210, NULL, 7, 0),
(240, 211, NULL, 7, 2),
(241, 212, NULL, 7, 2),
(242, 213, NULL, 7, 4),
(243, 215, NULL, 7, 0),
(244, 216, NULL, 7, 4),
(245, 218, NULL, 7, 4),
(246, 118, NULL, 7, 2),
(247, 219, NULL, 7, 4),
(248, 220, NULL, 7, 1),
(249, 221, NULL, 7, 4),
(250, 222, NULL, 7, 2),
(251, 175, NULL, 7, 1),
(252, 176, NULL, 7, 6),
(253, 119, NULL, 7, 3),
(254, 100, NULL, 7, 4),
(255, 223, NULL, 7, 6),
(256, 224, NULL, 7, 2),
(257, 226, NULL, 7, 4),
(258, 227, NULL, 7, 2),
(259, 228, NULL, 7, 2),
(260, 229, NULL, 7, 4),
(261, 230, NULL, 7, 4),
(262, 138, NULL, 7, 4),
(263, 139, NULL, 7, 2),
(264, 94, NULL, 7, 6),
(265, 231, 11, NULL, 0),
(266, 164, 11, NULL, 0),
(267, 233, 11, NULL, 0),
(268, 231, NULL, 7, 4),
(269, 164, NULL, 7, 4),
(270, 233, NULL, 7, 4),
(271, 119, 10, NULL, 0),
(272, 155, 10, NULL, 0),
(273, 187, 10, NULL, 0),
(274, 213, 10, NULL, 0),
(275, 185, 10, NULL, 0),
(276, 235, 10, NULL, 0),
(277, 234, 10, NULL, 0),
(278, 16, NULL, 8, 4),
(279, 3, NULL, 8, 22),
(280, 9, NULL, 8, 30),
(281, 27, NULL, 8, 16),
(282, 30, NULL, 8, 13),
(283, 29, NULL, 8, 15),
(284, 33, NULL, 8, 28),
(285, 37, NULL, 8, 2),
(286, 34, NULL, 8, 84),
(287, 51, NULL, 8, 1),
(288, 42, NULL, 8, 18),
(289, 38, NULL, 8, 2),
(290, 43, NULL, 8, 108),
(291, 41, NULL, 8, 127),
(292, 40, NULL, 8, 12),
(293, 44, NULL, 8, 19),
(294, 194, NULL, 8, 37),
(295, 195, NULL, 8, 94),
(296, 193, NULL, 8, 2),
(297, 119, NULL, 8, 5),
(298, 155, NULL, 8, 16),
(299, 187, NULL, 8, 16),
(300, 213, NULL, 8, 18),
(301, 185, NULL, 8, 18),
(302, 235, NULL, 8, 6),
(303, 234, NULL, 8, 8),
(304, 187, NULL, 7, 4),
(305, 235, NULL, 7, 4),
(306, 234, NULL, 7, 2),
(307, 214, 10, NULL, 0),
(308, 128, 10, NULL, 0),
(309, 223, 10, NULL, 0),
(310, 214, NULL, 8, 8),
(311, 128, NULL, 8, 8),
(312, 223, NULL, 8, 0),
(313, 214, NULL, 7, 2),
(314, 128, NULL, 7, 2),
(315, 45, NULL, 8, 4);

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

DROP TABLE IF EXISTS `store`;
CREATE TABLE IF NOT EXISTS `store` (
  `store_id` int(5) NOT NULL AUTO_INCREMENT,
  `store_name` varchar(25) NOT NULL,
  `store_virtual` int(5) DEFAULT NULL,
  `store_info` text NOT NULL,
  PRIMARY KEY (`store_id`),
  UNIQUE KEY `store_id` (`store_id`),
  KEY `store_id_2` (`store_id`),
  KEY `store_virtual` (`store_virtual`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`store_id`, `store_name`, `store_virtual`, `store_info`) VALUES
(6, 'Deposito CHACO', NULL, 'Chaco'),
(7, 'Deposito FILIMON', NULL, ''),
(8, 'Deposito GRECO', NULL, ''),
(9, 'Deposito ALEX', NULL, ''),
(10, 'Deposito Huayna K.', 8, ''),
(11, 'serviterra', 7, '');

-- --------------------------------------------------------

--
-- Table structure for table `store_entries_outs`
--

DROP TABLE IF EXISTS `store_entries_outs`;
CREATE TABLE IF NOT EXISTS `store_entries_outs` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `store_id` int(5) NOT NULL,
  `tyre_id` int(5) NOT NULL,
  `supplier_id` int(5) DEFAULT NULL,
  `invoice_id` int(5) DEFAULT NULL,
  `dest_store` int(5) DEFAULT NULL,
  `dest_shop` int(5) DEFAULT NULL,
  `date` date NOT NULL,
  `entry_out` varchar(5) NOT NULL,
  `employee` text NOT NULL,
  `amount` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `store_id` (`store_id`),
  KEY `tyre_id` (`tyre_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `dest_store` (`dest_store`),
  KEY `dest_shop` (`dest_shop`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=319 ;

--
-- Dumping data for table `store_entries_outs`
--

INSERT INTO `store_entries_outs` (`id`, `store_id`, `tyre_id`, `supplier_id`, `invoice_id`, `dest_store`, `dest_shop`, `date`, `entry_out`, `employee`, `amount`) VALUES
(27, 6, 15, 18, 16, NULL, NULL, '2013-06-05', 'entry', '', 50),
(28, 6, 15, NULL, NULL, NULL, 1, '2013-06-05', 'out', '', 30),
(29, 6, 53, 18, 17, NULL, NULL, '2013-06-09', 'entry', 'aaa', 50),
(30, 6, 53, NULL, NULL, NULL, 7, '2013-06-09', 'out', '', 50),
(31, 6, 73, 18, 18, NULL, NULL, '2013-06-09', 'entry', '', 50),
(32, 6, 73, NULL, NULL, NULL, 1, '2013-06-09', 'out', '', 50),
(33, 8, 16, 18, 19, NULL, NULL, '2013-10-16', 'entry', 'yop', 8),
(34, 8, 106, 18, 19, NULL, NULL, '2013-10-16', 'entry', 'yop', 122),
(35, 8, 161, 18, 19, NULL, NULL, '2013-10-16', 'entry', 'yop', 13),
(36, 7, 29, 18, 19, NULL, NULL, '2013-10-16', 'entry', 'yop', 18),
(37, 7, 43, 18, 19, NULL, NULL, '2013-10-16', 'entry', '0001', 11),
(38, 7, 18, 18, 19, NULL, NULL, '2013-10-16', 'entry', '0001', 96),
(39, 7, 106, 18, 19, NULL, NULL, '2013-10-16', 'entry', '0001', 71),
(40, 7, 177, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 38),
(41, 7, 71, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 46),
(42, 7, 179, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 50),
(43, 7, 180, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 40),
(44, 7, 112, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 23),
(45, 7, 111, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 44),
(46, 7, 162, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 42),
(47, 7, 139, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 60),
(48, 7, 138, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 12),
(49, 7, 183, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 2),
(50, 7, 182, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 9),
(51, 6, 63, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 64),
(52, 6, 179, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 154),
(53, 6, 19, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 92),
(54, 6, 78, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 108),
(55, 6, 184, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 16),
(56, 6, 164, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 66),
(57, 6, 165, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 18),
(58, 6, 166, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 30),
(59, 6, 167, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 8),
(60, 6, 168, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 44),
(61, 6, 169, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 20),
(62, 6, 170, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 176),
(63, 6, 161, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 20),
(64, 6, 162, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 100),
(65, 6, 157, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 83),
(66, 6, 158, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 124),
(67, 6, 185, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 60),
(68, 6, 159, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 16),
(69, 6, 187, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 15),
(70, 6, 189, 18, 19, NULL, NULL, '2013-10-16', 'entry', '', 20),
(71, 6, 15, NULL, NULL, NULL, 8, '2013-10-16', 'out', '', 20),
(72, 9, 53, 18, 18, NULL, NULL, '2013-08-12', 'entry', '', 4),
(73, 9, 53, NULL, NULL, NULL, 1, '2013-08-12', 'out', '', 4),
(74, 9, 53, 18, NULL, NULL, NULL, '2013-11-01', 'entry', '', 2),
(75, 9, 53, NULL, NULL, NULL, 12, '2013-11-01', 'out', '', 2),
(76, 8, 16, NULL, NULL, NULL, 12, '2013-11-05', 'out', '', 8),
(77, 8, 106, NULL, NULL, NULL, 12, '2013-11-05', 'out', '', 16),
(78, 8, 161, NULL, NULL, NULL, 12, '2013-11-05', 'out', '', 6),
(79, 7, 29, NULL, NULL, NULL, 12, '2013-11-05', 'out', '', 10),
(80, 7, 177, NULL, NULL, NULL, 12, '2013-11-05', 'out', '', 8),
(81, 7, 18, NULL, NULL, NULL, 12, '2013-11-05', 'out', '', 20),
(82, 7, 139, NULL, NULL, NULL, 12, '2013-11-05', 'out', '', 48),
(83, 7, 44, 18, NULL, NULL, NULL, '2013-11-05', 'entry', '', 9),
(84, 7, 192, 18, NULL, NULL, NULL, '2013-11-05', 'entry', '', 22),
(85, 7, 138, 18, NULL, NULL, NULL, '2013-11-05', 'entry', '', 48),
(86, 6, 63, NULL, NULL, NULL, 12, '2013-11-05', 'out', '', 18),
(87, 6, 19, NULL, NULL, NULL, 12, '2013-11-05', 'out', '', 20),
(88, 6, 165, NULL, NULL, NULL, 12, '2013-11-05', 'out', '', 4),
(89, 6, 166, NULL, NULL, NULL, 12, '2013-11-05', 'out', '', 14),
(90, 6, 170, NULL, NULL, NULL, 12, '2013-11-05', 'out', '', 20),
(91, 6, 162, NULL, NULL, NULL, 12, '2013-11-05', 'out', '', 10),
(92, 6, 158, NULL, NULL, NULL, 12, '2013-11-06', 'out', '', 26),
(93, 6, 185, NULL, NULL, NULL, 12, '2013-11-06', 'out', '', 30),
(94, 6, 3, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 20),
(95, 6, 9, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 59),
(96, 6, 27, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 38),
(97, 6, 30, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 32),
(98, 6, 118, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 60),
(99, 6, 187, NULL, NULL, NULL, 12, '2013-11-06', 'out', '', 15),
(100, 6, 157, NULL, NULL, NULL, 12, '2013-11-06', 'out', '', 83),
(101, 10, 16, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 4),
(102, 10, 15, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 5),
(103, 10, 3, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 22),
(104, 10, 9, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 30),
(105, 10, 27, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 16),
(106, 10, 30, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 13),
(107, 10, 29, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 15),
(108, 10, 33, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 28),
(109, 10, 37, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 2),
(110, 10, 34, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 84),
(111, 10, 51, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 1),
(112, 10, 42, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 18),
(113, 10, 38, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 2),
(114, 10, 43, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 108),
(115, 10, 41, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 127),
(116, 10, 40, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 12),
(117, 10, 44, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 19),
(118, 10, 194, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 37),
(119, 10, 195, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 94),
(120, 10, 193, 18, NULL, NULL, NULL, '2013-11-06', 'entry', '', 2),
(121, 8, 194, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 2),
(122, 8, 33, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 2),
(123, 8, 51, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 2),
(124, 8, 195, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 2),
(125, 8, 43, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 14),
(126, 8, 41, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 4),
(127, 8, 45, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 4),
(128, 8, 47, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 2),
(129, 8, 53, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 10),
(130, 11, 194, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 2),
(131, 11, 33, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 2),
(132, 11, 51, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 2),
(133, 11, 195, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 2),
(134, 11, 43, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 14),
(135, 11, 41, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 4),
(136, 11, 45, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 4),
(137, 11, 47, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 2),
(138, 11, 53, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 10),
(139, 11, 70, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 2),
(140, 11, 19, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 2),
(141, 11, 73, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 2),
(142, 11, 18, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 4),
(143, 11, 78, 18, NULL, NULL, NULL, '2014-12-17', 'entry', '', 2),
(144, 11, 196, 18, NULL, NULL, NULL, '2014-12-18', 'entry', '', 4),
(145, 11, 197, 18, NULL, NULL, NULL, '2014-12-18', 'entry', '', 4),
(146, 11, 198, 18, NULL, NULL, NULL, '2014-12-18', 'entry', '', 2),
(147, 11, 166, 18, NULL, NULL, NULL, '2014-12-18', 'entry', '', 2),
(148, 11, 170, 18, NULL, NULL, NULL, '2014-12-18', 'entry', '', 2),
(149, 11, 199, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(150, 11, 200, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 3),
(151, 11, 106, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(152, 11, 111, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(153, 11, 115, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 3),
(154, 11, 116, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 1),
(155, 11, 125, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 12),
(156, 11, 129, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(157, 11, 131, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 1),
(158, 11, 127, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 4),
(159, 11, 106, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(160, 11, 111, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(161, 11, 106, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(162, 11, 155, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 4),
(163, 11, 154, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 4),
(164, 11, 202, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 4),
(165, 11, 203, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 6),
(166, 11, 204, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 4),
(167, 11, 205, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 10),
(168, 11, 162, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(169, 11, 158, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 1),
(170, 11, 185, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(171, 11, 173, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(172, 11, 171, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(173, 11, 206, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(174, 11, 207, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(175, 11, 208, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(176, 11, 209, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 4),
(177, 11, 210, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(178, 11, 211, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(179, 11, 212, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(180, 11, 213, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(181, 11, 215, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(182, 11, 216, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 6),
(183, 11, 218, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 4),
(184, 11, 118, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(185, 11, 219, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 4),
(186, 11, 220, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 1),
(187, 11, 221, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 5),
(188, 11, 222, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(189, 11, 175, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 9),
(190, 11, 176, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 6),
(191, 11, 119, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 3),
(192, 11, 100, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 4),
(193, 11, 223, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 8),
(194, 11, 224, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(195, 11, 226, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 4),
(196, 11, 227, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(197, 11, 228, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 4),
(198, 11, 229, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 4),
(199, 11, 230, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 6),
(200, 11, 138, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 4),
(201, 11, 139, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 2),
(202, 11, 94, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 6),
(203, 11, 194, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(204, 11, 33, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(205, 11, 51, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(206, 11, 195, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(207, 11, 43, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 14),
(208, 11, 41, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(209, 11, 45, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(210, 11, 47, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(211, 11, 53, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 10),
(212, 11, 70, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(213, 11, 19, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(214, 11, 73, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(215, 11, 18, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(216, 11, 78, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(217, 11, 196, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(218, 11, 197, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(219, 11, 198, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(220, 11, 166, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(221, 11, 170, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(222, 11, 199, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(223, 11, 200, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 3),
(224, 11, 106, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 6),
(225, 11, 111, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(226, 11, 115, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 3),
(227, 11, 116, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 1),
(228, 11, 125, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 12),
(229, 11, 129, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(230, 11, 131, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 1),
(231, 11, 127, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(232, 11, 155, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(233, 11, 154, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(234, 11, 202, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(235, 11, 203, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 6),
(236, 11, 204, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(237, 11, 205, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 10),
(238, 11, 162, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(239, 11, 158, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 1),
(240, 11, 185, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(241, 11, 173, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(242, 11, 171, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(243, 11, 206, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(244, 11, 207, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(245, 11, 208, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(246, 11, 209, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(247, 11, 210, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(248, 11, 211, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(249, 11, 212, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(250, 11, 213, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(251, 11, 215, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(252, 11, 216, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 6),
(253, 11, 218, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(254, 11, 118, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(255, 11, 219, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(256, 11, 220, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 1),
(257, 11, 221, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 5),
(258, 11, 222, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(259, 11, 175, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 9),
(260, 11, 176, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 6),
(261, 11, 119, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 3),
(262, 11, 100, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(263, 11, 223, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 8),
(264, 11, 224, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(265, 11, 226, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(266, 11, 227, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(267, 11, 228, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(268, 11, 229, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(269, 11, 230, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 6),
(270, 11, 138, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(271, 11, 139, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 2),
(272, 11, 94, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 6),
(273, 11, 231, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 4),
(274, 11, 164, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 4),
(275, 11, 233, 18, NULL, NULL, NULL, '2014-12-19', 'entry', '', 4),
(276, 11, 231, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(277, 11, 164, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(278, 11, 233, NULL, NULL, NULL, 7, '2014-12-18', 'out', 'Ariel', 4),
(279, 10, 119, 18, NULL, NULL, NULL, '2014-12-16', 'entry', '', 20),
(280, 10, 155, 18, NULL, NULL, NULL, '2014-12-16', 'entry', '', 20),
(281, 10, 187, 18, NULL, NULL, NULL, '2014-12-16', 'entry', '', 20),
(282, 10, 213, 18, NULL, NULL, NULL, '2014-12-16', 'entry', '', 20),
(283, 10, 185, 18, NULL, NULL, NULL, '2014-12-16', 'entry', '', 20),
(284, 10, 235, 18, NULL, NULL, NULL, '2014-12-16', 'entry', '', 10),
(285, 10, 234, 18, NULL, NULL, NULL, '2014-12-16', 'entry', '', 10),
(286, 10, 16, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 4),
(287, 10, 15, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 5),
(288, 10, 3, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 22),
(289, 10, 9, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 30),
(290, 10, 27, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 16),
(291, 10, 30, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 13),
(292, 10, 29, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 15),
(293, 10, 33, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 28),
(294, 10, 37, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 2),
(295, 10, 34, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 84),
(296, 10, 51, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 1),
(297, 10, 42, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 18),
(298, 10, 38, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 2),
(299, 10, 43, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 108),
(300, 10, 41, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 127),
(301, 10, 40, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 12),
(302, 10, 44, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 19),
(303, 10, 194, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 37),
(304, 10, 195, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 94),
(305, 10, 193, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 2),
(306, 10, 119, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 20),
(307, 10, 155, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 20),
(308, 10, 187, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 20),
(309, 10, 213, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 20),
(310, 10, 185, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 20),
(311, 10, 235, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 10),
(312, 10, 234, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 10),
(313, 10, 214, 18, NULL, NULL, NULL, '2015-01-02', 'entry', '', 10),
(314, 10, 128, 18, NULL, NULL, NULL, '2015-01-02', 'entry', '', 10),
(315, 10, 223, 18, NULL, NULL, NULL, '2015-01-02', 'entry', '', 10),
(316, 10, 214, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 10),
(317, 10, 128, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 10),
(318, 10, 223, NULL, NULL, NULL, 8, '2015-01-02', 'out', 'Administrador', 10);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
CREATE TABLE IF NOT EXISTS `supplier` (
  `supplier_id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `info` text NOT NULL,
  PRIMARY KEY (`supplier_id`),
  UNIQUE KEY `supplier_id` (`supplier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supplier_id`, `name`, `info`) VALUES
(18, 'Ariel', '');

-- --------------------------------------------------------

--
-- Table structure for table `tyre`
--

DROP TABLE IF EXISTS `tyre`;
CREATE TABLE IF NOT EXISTS `tyre` (
  `tyre_id` int(5) NOT NULL AUTO_INCREMENT,
  `tyre_brand` varchar(25) NOT NULL,
  `tyre_size` varchar(25) NOT NULL,
  `tyre_code` varchar(25) NOT NULL,
  PRIMARY KEY (`tyre_id`),
  UNIQUE KEY `tyre_id` (`tyre_id`),
  KEY `tyre_id_2` (`tyre_id`),
  KEY `tyre_id_3` (`tyre_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=236 ;

--
-- Dumping data for table `tyre`
--

INSERT INTO `tyre` (`tyre_id`, `tyre_brand`, `tyre_size`, `tyre_code`) VALUES
(3, 'Kumho', '12R22.5', 'KRS15'),
(4, 'Kumho', '315/80R22.5', 'KRS15'),
(7, 'Bridgestone', '12R22.5', 'R250'),
(8, 'Kumho China', '12R22.5', 'KRA28'),
(9, 'Kumho', '12R22.5', 'KMA01'),
(13, 'Kumho', '12R22.5', 'KRD02'),
(15, 'Kumho', '12R22.5', 'KFD04'),
(16, 'Kumho', '315/80R22.5', 'KRS03'),
(18, 'Aeolus', '825x16', 'HN08'),
(19, 'Aeolus', '750x16', 'HN08'),
(20, 'Aeolus', '12R22.5', 'HN257'),
(22, 'Aeolus', '12R22.5', 'HN355'),
(23, 'Kumho China', '315/80R22.5', 'KRS28'),
(24, 'Kumho', '385/65R22.5', 'KRS03'),
(25, 'Kumho', '315/80R22.5', 'KRD02'),
(27, 'Kumho', '12R22.5', 'KMA11'),
(28, 'Kumho', '12R22.5', 'KMD21'),
(29, 'Kumho', '295/80R22.5', 'KRD02'),
(30, 'Kumho', '295/80R22.5', 'KRS15'),
(31, 'Kumho', '9.5R17.5', 'KRA11'),
(32, 'Kumho', '9.5R17.5', 'KRD02'),
(33, 'Kumho', '265/70R15', 'KH15'),
(34, 'Kumho', '265/70R16', 'KH15'),
(35, 'Kumho', '295/80R22.5', 'KRD50'),
(36, 'Kumho', '265/70R17', 'KH15'),
(37, 'Kumho', '235/60R16', 'KH15'),
(38, 'Kumho', '195R15', 'KL71'),
(39, 'Kumho', '195/65R15', 'KH17'),
(40, 'Kumho', '195/70R14', 'KH17'),
(41, 'Kumho', '195/65R14', 'KH17'),
(42, 'Kumho', '185/70R14', 'KH17'),
(43, 'Kumho', '185/65R14', 'KH17'),
(44, 'Aeolus', '385/65R22.5', 'HN809'),
(45, 'Aeolus', '315/80R22.5', 'ADR69'),
(46, 'Aeolus', '315/80R22.5', 'HN254'),
(47, 'Aeolus', '315/80R22.5', 'HN353'),
(48, 'Aeolus', '315/80R22.5', 'HN08'),
(49, 'Aeolus', '315/80R22.5', 'HN226'),
(50, 'Aeolus', '385/65R22.5', 'HN228'),
(51, 'Kumho', '31x10.5R15', 'KH17'),
(52, 'Aeolus', '12R22.5', 'HN08'),
(53, 'Aeolus', '12R22.5', 'HN10'),
(54, 'Aeolus', '12R22.5', 'HN353'),
(55, 'Aeolus', '12R22.5', 'HN324'),
(56, 'Aeolus', '295/80R22.5', 'ADR69'),
(57, 'Aeolus', '295/80R22.5', 'HN226'),
(58, 'Aeolus', '295/80R22.5', 'HN355'),
(59, 'Aeolus', '295/80R22.5', 'HN254'),
(60, 'Aeolus', '11R22.5', 'HN08'),
(61, 'Aeolus', '11R22.5', 'HN257'),
(62, 'Aeolus', '11R22.5', 'HN353'),
(63, 'Aeolus', '1200R20', 'HN10'),
(64, 'Aeolus', '1200R20', 'HN08'),
(65, 'Aeolus', '1000R20', 'HN08'),
(66, 'Aeolus', '900R20', 'HN08'),
(67, 'Aeolus', '275/70R22.5', 'HN226'),
(68, 'Aeolus', '285/70R19.5', 'HN309'),
(69, 'Aeolus', '285/70R19.5', 'HN257'),
(70, 'Aeolus', '265/70R19.5', 'HN228'),
(71, 'Aeolus', '265/70R19.5', 'HN257'),
(72, 'Aeolus', '245/75R19.5', 'HN366'),
(73, 'Aeolus', '825R16', 'HN09'),
(74, 'Aeolus', '235/70R17.5', 'HN235'),
(75, 'Aeolus', '235/70R17.5', 'HN309'),
(76, 'Aeolus', '215/70R17.5', 'HN235'),
(77, 'Aeolus', '215/70R17.5', 'HN309'),
(78, 'Aeolus', '700R16', 'HN08'),
(79, 'Aeolus', '1000R15', 'HN263'),
(80, 'Aeolus', '825R15', 'HN263'),
(81, 'Kumho China', '12R22.5', 'KRS28'),
(82, 'Kumho China', '12R22.5', 'KFD18'),
(83, 'Kumho China', '12R22.5', 'KRD28'),
(84, 'Kumho China', '295/80R22.5', 'KRS28'),
(85, 'Kumho China', '12R22.5', 'KMD18'),
(86, 'Deuribo', '315/80R22.5', 'DRB592'),
(87, 'Deuribo', '315/80R22.5', 'DRB662'),
(88, 'Deuribo', '12R22.5', 'DRB582'),
(89, 'Autostone', '315/80R22.5', 'FH168'),
(90, 'Autostone', '315/80R22.5', 'FH158'),
(91, 'Autostone', '12R22.5', 'FH166'),
(92, 'Autostone', '12R22.5', 'FH158'),
(93, 'Autostone', '295/80R22.5', 'FH158'),
(94, 'AutoStone', '11R22.5', 'FH158'),
(95, 'Boto', '315/80R22.5', 'BT219'),
(96, 'Boto', '315/80R22.5', 'BT388'),
(97, 'Boto', '12R22.5', 'BT219'),
(98, 'Boto', '12R22.5', 'BT369'),
(99, 'Boto', '1200R20', 'BT168'),
(100, 'Winda', '31x10R15', 'WL16'),
(101, 'Winda', '195/65R15', 'WP15'),
(102, 'Winda', '195R14', 'WL15'),
(103, 'Winda', '185R14', 'WL15'),
(104, 'Winda', '185/70R14', 'WP15'),
(105, 'Winda', '185/70R13', 'WP15'),
(106, 'Double Camel', '1200x20', 'ST703'),
(107, 'Double Camel', '1200x20', 'ST702'),
(108, 'Double Camel', '1100x20', 'ST702'),
(109, 'Double Camel', '1000x20', 'ST702'),
(110, 'Double Camel', '900x20', 'ST702'),
(111, 'Double Camel', '825x16', 'R501'),
(112, 'Double Camel', '825x16', 'L606'),
(113, 'Double Camel', '750x16', 'ST601'),
(114, 'Double Camel', '750x16', 'ST602'),
(115, 'Double Camel', '700x16', 'ST601'),
(116, 'Double Camel', '600x14', 'ST601'),
(117, 'Triangle', '315/80R22.5', 'TR688'),
(118, 'Triangle', '9.5R17.5', 'TR656'),
(119, 'Triangle', '175/70R13', 'tr'),
(120, 'Runway', '245/70R17', 'Enduro'),
(121, 'Runway', '235/65R17', 'Enduro'),
(122, 'Runway', '235/70R26', 'Enduro'),
(123, 'Runway', '31x10.5R15', 'Enduro'),
(124, 'Runway', '195/60R15', 'Enduro'),
(125, 'Runway', '195/50R15', 'Enduro'),
(126, 'Runway', '185/65R15', 'Enduro'),
(127, 'Runway', '205/50R15Z', 'Pistera'),
(128, 'Runway', '185/65R14', 'Enduro'),
(129, 'Runway', '175/70R14', 'Enduro'),
(130, 'Runway', '175/65R14', 'Enduro'),
(131, 'Runway', '155r13', 'Enduro'),
(132, 'GT', '425/65R22.5', 'GT876'),
(133, 'GT', '245/70R16', 'SAVERO'),
(134, 'GT', '245/75R16AT', 'GT'),
(135, 'GT', '215/70R16', 'Champiro'),
(136, 'GT', '185/60R14', 'Champiro'),
(137, 'Ling Long', '9.5R17.5', 'LLF26'),
(138, 'Ling Long', '825x16', 'LL59'),
(139, 'Ling Long', '825x16', 'LL47'),
(140, 'Ling Long', '825x16', 'LL89'),
(141, 'Prime Well', '295/80R22.5', 'PW210'),
(142, 'Prime Well', '315/80R22.5', 'PW215'),
(143, 'Prime Well', '1000R20', 'PW02'),
(144, 'Great Way', '1100x22', 'Great Way'),
(145, 'Birla', '750x16', 'BT168'),
(146, 'Donga', '1100x20', 'camara'),
(147, 'Donga', '1200x20', 'Camara'),
(148, 'Donga', 'R13', 'Camara'),
(149, 'Donga', 'R15', 'Camara'),
(150, 'Donga', 'R14', 'Camara'),
(151, 'India', '900x20', 'Camara'),
(152, 'India', '1000x20', 'Camara'),
(153, 'Bridgestone', '1100x22', 'Camara'),
(154, 'Wind Power', '315/80R22.5', 'ADR69'),
(155, 'Wind Power', '315/80R22.5', 'WSR36'),
(156, 'Wind Power', '12R22.5', 'HN10'),
(157, 'Wind Power', '825R16', 'HN09'),
(158, 'Wind Power', '825R16', 'HN08'),
(159, 'Wind Power', '235/75R17.5', 'WGC28'),
(160, 'Wind Power', '385/65R22.5', 'WGC28'),
(161, 'Wind Power', '385/55R22.5', 'WGC28'),
(162, 'Wind Power', '1200R20', 'HN10'),
(164, 'Aeolus', '265/70R17', 'AS01'),
(165, 'Aeolus', '265/65R17', 'AS01'),
(166, 'Aeolus', '265/70R16', 'AS01'),
(167, 'Aeolus', '235/70R16', 'AS02'),
(168, 'Aeolus', '225/70R16', 'AS02'),
(169, 'Aeolus', '215/70R16', 'AS02'),
(170, 'Aeolus', '185/70R14', 'AG02'),
(171, 'Aeolus', '185/70R13', 'AG02'),
(172, 'Aeolus', '175/70R13', 'AG02'),
(173, 'Aeolus', '235/75R15', 'AS01'),
(174, 'Triangle', '185/70R13', 'Triangle'),
(175, 'Triangle', '195/70R14', 'Triangle'),
(176, 'Triangle', '195/65R15', 'Triangle'),
(177, 'Aeolus', '385/65R22.5', 'AGC28'),
(178, 'Aeolus', '265/70R19.5', 'HN257'),
(179, 'Aeolus', '265/70R19.5', 'AGC28'),
(180, 'Aeolus', '10R22.5', 'HN257'),
(181, 'Triangle', '295/80R22.5', 'TR686'),
(182, 'AutoStone', '1200R20', 'FH185'),
(183, 'Triangle', '1100R22', 'TR679'),
(184, 'Aeolus', '215/75R17.5', 'AGC28'),
(185, 'Wind Power', '825R15', 'HN230'),
(186, 'Wind Power', '1000R15', 'HN230'),
(187, 'Wind Power', '295/80R22.5', 'ADR69'),
(188, 'Wind Power', '295/80R22.5', 'AGB20'),
(189, 'Wind Power', '275/70R22.5', 'WGC28'),
(190, 'Aeolus', '265/70R19.5', 'HN254'),
(191, 'Aeolus', '265/70R19.5', 'HN'),
(192, 'Aeolus', '315/80R22.5', 'ASR69'),
(193, 'Kumho', '175/70R13', 'KH15'),
(194, 'Kumho', '215/70R16', 'KH15'),
(195, 'Kumho', '235/75R15', 'KL78'),
(196, 'Wind Power', '9.5r17.5', 'ADR35'),
(197, 'Aeolus', '1000R20', 'HN09'),
(198, 'Aeolus', '900R20', 'HN09'),
(199, 'Aeolus', '285/75R24.5', 'HN06'),
(200, 'Aeolus', '195R14', 'AL01'),
(201, 'Runway', '245/75R16', 'Runway'),
(202, 'Wind power', '315/80R22.5', 'HN08'),
(203, 'Wind power', '315/80R22.5', 'WDR36'),
(204, 'Wind power', '12R22.5', 'HN08'),
(205, 'Wind power', '12R22.5', 'ADC53'),
(206, 'Wind Power', '12R22.5', 'WSR36'),
(207, 'Wind Power', '315/80R22.5', 'WDL60'),
(208, 'Aeolus', '195/65r15', 'AH01'),
(209, 'Aeolus', '195/65R14', 'AH01'),
(210, 'Aeolus', '185R14', 'AL01'),
(211, 'Wind Power', '275/80R22.5', 'HN06'),
(212, 'Wind power', '11R24.5', 'HN353'),
(213, 'Wind power', '285/70R19.5', 'WDR34'),
(214, 'Wind power', '295/80R22.5', 'ASR69'),
(215, 'Wind power', '295/80R22.5', 'ADC53'),
(216, 'Wind power', '255/70R22.5', 'WSR36'),
(217, 'Wind Power', '275/70R22.5', 'WSR36'),
(218, 'Wind Power', '285/70R19.5', 'WSR36'),
(219, 'Triangle', '315/80R22.5', 'TRD08'),
(220, 'Triangle', '315/80R22.5', 'TR601'),
(221, 'Triangle', '12R22.5', 'TR601'),
(222, 'Triangle', '12R22.5', 'TR688'),
(223, 'Triangle', '185/70R14', 'Triangle'),
(224, 'Triangle', '1100R22', 'TR600'),
(225, 'Triangle', '265/70R19.5', 'TR657'),
(226, 'Triangle', '235/75R17.5', 'TR689'),
(227, 'Triangle', '215/75R17.5', 'TR689'),
(228, 'Triangle', '235/75R15', 'TR246'),
(229, 'Triangle', '195R14', 'TR246'),
(230, 'Triangle', '195/70R15', 'TR645'),
(231, 'Wind power', '12R22.5', 'WSL60'),
(232, 'Aeolus', '265/70R17', 'Aeolus'),
(233, 'Aeolus', '215/65R15', 'Aeolus'),
(234, 'Wind Power', '315/80R22.5', 'WDC52'),
(235, 'Aeolus', '315/80R22.5', 'HN257');

-- --------------------------------------------------------

--
-- Table structure for table `usr`
--

DROP TABLE IF EXISTS `usr`;
CREATE TABLE IF NOT EXISTS `usr` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `login` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `usr`
--

INSERT INTO `usr` (`id`, `login`, `password`, `name`) VALUES
(1, 'joe', '16a9a54ddf4259952e3c118c763138e83693d7fd', 'Administrador'),
(11, 'arico999', 'e87a720bf2fcd628a9fa09020d4da144ea800366', 'Ariel'),
(12, 'carlos', '0f81c2baa761663988a332cacd2598448b593817', 'carlos'),
(13, 'ari', '7158a9e0f8e84a0a74ed148e0f652dfbd4913a18', 'ari');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `debt`
--
ALTER TABLE `debt`
  ADD CONSTRAINT `debt_ibfk_1` FOREIGN KEY (`deptor_id`) REFERENCES `deptor` (`id`),
  ADD CONSTRAINT `debt_ibfk_2` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`shop_id`);

--
-- Constraints for table `expense`
--
ALTER TABLE `expense`
  ADD CONSTRAINT `expense_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`shop_id`);

--
-- Constraints for table `role`
--
ALTER TABLE `role`
  ADD CONSTRAINT `role_ibfk_1` FOREIGN KEY (`user`) REFERENCES `usr` (`id`);

--
-- Constraints for table `role_shop`
--
ALTER TABLE `role_shop`
  ADD CONSTRAINT `role_shop_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`shop_id`),
  ADD CONSTRAINT `role_shop_ibfk_2` FOREIGN KEY (`user`) REFERENCES `usr` (`id`);

--
-- Constraints for table `role_store`
--
ALTER TABLE `role_store`
  ADD CONSTRAINT `role_store_ibfk_1` FOREIGN KEY (`user`) REFERENCES `usr` (`id`),
  ADD CONSTRAINT `role_store_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `store` (`store_id`);

--
-- Constraints for table `shop_entries_outs`
--
ALTER TABLE `shop_entries_outs`
  ADD CONSTRAINT `shop_entries_outs_ibfk_1` FOREIGN KEY (`tyre_id`) REFERENCES `tyre` (`tyre_id`),
  ADD CONSTRAINT `shop_entries_outs_ibfk_2` FOREIGN KEY (`source_store`) REFERENCES `store` (`store_id`),
  ADD CONSTRAINT `shop_entries_outs_ibfk_3` FOREIGN KEY (`source_shop`) REFERENCES `shop` (`shop_id`),
  ADD CONSTRAINT `shop_entries_outs_ibfk_4` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`shop_id`),
  ADD CONSTRAINT `shop_entries_outs_ibfk_5` FOREIGN KEY (`deptor_id`) REFERENCES `deptor` (`id`);

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`tyre_id`) REFERENCES `tyre` (`tyre_id`),
  ADD CONSTRAINT `stock_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `store` (`store_id`),
  ADD CONSTRAINT `stock_ibfk_3` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`shop_id`);

--
-- Constraints for table `store`
--
ALTER TABLE `store`
  ADD CONSTRAINT `store_ibfk_1` FOREIGN KEY (`store_virtual`) REFERENCES `shop` (`shop_id`);

--
-- Constraints for table `store_entries_outs`
--
ALTER TABLE `store_entries_outs`
  ADD CONSTRAINT `store_entries_outs_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `store` (`store_id`),
  ADD CONSTRAINT `store_entries_outs_ibfk_2` FOREIGN KEY (`tyre_id`) REFERENCES `tyre` (`tyre_id`),
  ADD CONSTRAINT `store_entries_outs_ibfk_3` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`supplier_id`),
  ADD CONSTRAINT `store_entries_outs_ibfk_4` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`invoice_id`),
  ADD CONSTRAINT `store_entries_outs_ibfk_5` FOREIGN KEY (`dest_shop`) REFERENCES `shop` (`shop_id`),
  ADD CONSTRAINT `store_entries_outs_ibfk_6` FOREIGN KEY (`dest_store`) REFERENCES `store` (`store_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
