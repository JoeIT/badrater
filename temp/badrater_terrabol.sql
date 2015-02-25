-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2015 at 06:54 AM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `badrater_terrabol`
--
CREATE DATABASE IF NOT EXISTS `badrater_terrabol` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `badrater_terrabol`;

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
  `kardex_io` char(1) NOT NULL DEFAULT 'x',
  `kardex_entries` char(1) NOT NULL DEFAULT 'x',
  `kardex_outs` char(1) NOT NULL DEFAULT 'x',
  `kardex_stock` char(1) NOT NULL DEFAULT 'x',
  `kardex_imports` char(1) NOT NULL DEFAULT 'x',
  `kardex_invoices` char(1) NOT NULL DEFAULT 'x',
  `kardex_debts` char(1) NOT NULL DEFAULT 'x',
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `user`, `permission`, `store_v`, `store_a`, `store_d`, `shop_v`, `shop_a`, `shop_d`, `tyre_a`, `tyre_d`, `supplier_a`, `supplier_d`, `deptor_a`, `deptor_d`, `kardex_io`, `kardex_entries`, `kardex_outs`, `kardex_stock`, `kardex_imports`, `kardex_invoices`, `kardex_debts`) VALUES
(2, 1, 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y'),
(11, 11, 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'y', 'x', 'x', 'x', 'x', 'x', 'x', 'x'),
(12, 12, 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'y', 'x', 'x', 'x', 'x', 'x', 'y'),
(13, 13, 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x', 'x');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=136 ;

--
-- Dumping data for table `shop_entries_outs`
--

INSERT INTO `shop_entries_outs` (`id`, `shop_id`, `tyre_id`, `source_store`, `source_shop`, `date`, `date_save`, `entry_out`, `employee`, `amount`, `deptor_id`, `payment_bs`, `payment_sus`) VALUES
(132, 7, 172, 7, NULL, '2015-02-20', '2015-02-20 00:33:43', 'entry', 'pp', 5, NULL, '0.00', '0.00'),
(133, 7, 172, NULL, 1, '2015-02-20', '2015-02-20 00:57:34', 'out', 'otro', 3, NULL, '0.00', '0.00'),
(134, 1, 172, NULL, 7, '2015-02-20', '2015-02-20 00:57:34', 'entry', 'otro', 3, NULL, '0.00', '0.00'),
(135, 1, 165, 7, NULL, '2015-02-20', '2015-02-20 01:40:19', 'entry', '', 15, NULL, '0.00', '0.00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=335 ;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `tyre_id`, `store_id`, `shop_id`, `quantity`) VALUES
(330, 172, 7, NULL, 1),
(331, 172, NULL, 7, 2),
(332, 172, NULL, 1, 3),
(333, 165, 7, NULL, 37),
(334, 165, NULL, 1, 15);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=337 ;

--
-- Dumping data for table `store_entries_outs`
--

INSERT INTO `store_entries_outs` (`id`, `store_id`, `tyre_id`, `supplier_id`, `invoice_id`, `dest_store`, `dest_shop`, `date`, `entry_out`, `employee`, `amount`) VALUES
(333, 7, 172, 18, NULL, NULL, NULL, '2015-02-20', 'entry', 'yop dep', 6),
(334, 7, 172, NULL, NULL, NULL, 7, '2015-02-20', 'out', 'pp', 5),
(335, 7, 165, 18, NULL, NULL, NULL, '2015-02-20', 'entry', '', 52),
(336, 7, 165, NULL, NULL, NULL, 1, '2015-02-20', 'out', '', 15);

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
(1, 'TRASPASO', 'NO MODIFICAR ESTE DATO, PUES ES USADO POR EL SISTEMA.'),
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
(12, 'carlos', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'carlos'),
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
