-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: May 02, 2016 at 11:03 PM
-- Server version: 5.5.48-cll
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `febryoa1_inventory`
--

DELIMITER $$
--
-- Functions
--
CREATE FUNCTION `getCounterSequence`(`tipe` INT) RETURNS varchar(255) CHARSET utf8 COLLATE utf8_bin
BEGIN
  DECLARE COUNTER_FOUND VARCHAR(255);
  DECLARE LAST_MONTH INT;
  DECLARE CURRENT_MONTH INT;
  
  SELECT MONTH(updated_date) INTO LAST_MONTH FROM pos_counter WHERE type = tipe;
  SELECT MONTH(now()) INTO CURRENT_MONTH FROM pos_counter WHERE type = tipe;
  
  IF LAST_MONTH = CURRENT_MONTH THEN 
  	UPDATE pos_counter SET sequence=(sequence+1), updated_date=now() WHERE type= tipe;
  ELSE
  	UPDATE pos_counter SET sequence=1, updated_date=now() WHERE type= tipe;
  END IF;
  
  SELECT CONCAT(prefix,"/",MONTH(now()),"-",YEAR(NOW()),"/",LPAD(sequence,5,'0')) INTO COUNTER_FOUND FROM pos_counter WHERE type = tipe;
  RETURN COUNTER_FOUND;
  
  RETURN COUNTER_FOUND;
END$$

CREATE FUNCTION `updateAvailableStock`(`stockId` BIGINT, `quantity` INT, `notes` TEXT, `updatedBy` VARCHAR(255)) RETURNS varchar(255) CHARSET utf8 COLLATE utf8_bin
BEGIN
  DECLARE AVAILABLE INT;
  DECLARE SUCCESS BOOL;
  DECLARE RESULT VARCHAR(255);
  SET SUCCESS = false;
  SET AVAILABLE = 0;
  SET RESULT = "";
  SELECT ((ps.stock-(SELECT COALESCE(SUM(pb.quantity),0) FROM pos_booking pb WHERE pb.stock_id=ps.id and pb.active=true))-quantity) INTO AVAILABLE FROM pos_stock ps WHERE ps.id=stockId;
  IF AVAILABLE <0 THEN
  	SET SUCCESS = FALSE;
  ELSE
   	INSERT INTO `pos_booking`(`stock_id`,`booking_code`, `quantity`, `notes`, `created_by`, `created_date`, `updated_by`, `updated_date`, `active`) VALUES (stockId,getCounterSequence(5),quantity,notes,updatedBy,now(),updatedBy,now(),true);
  	SET SUCCESS = TRUE;
	SET RESULT = CONCAT(SUCCESS,',',AVAILABLE);
  END IF;
    
  RETURN RESULT;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pos_booking`
--

CREATE TABLE IF NOT EXISTS `pos_booking` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `stock_id` bigint(20) NOT NULL,
  `booking_code` varchar(255) COLLATE utf8_bin NOT NULL,
  `quantity` int(255) NOT NULL,
  `notes` text COLLATE utf8_bin NOT NULL,
  `created_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pos_brand`
--

CREATE TABLE IF NOT EXISTS `pos_brand` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `brand_code` varchar(255) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pos_brand`
--

INSERT INTO `pos_brand` (`id`, `brand_code`, `name`, `created_by`, `created_date`, `updated_by`, `updated_date`, `active`) VALUES
(1, 'BRN/4-2016/00003', 'Polish Angel', NULL, '0000-00-00 00:00:00', NULL, NULL, 1),
(2, 'BRN/4-2016/00004', 'Modesta', NULL, '0000-00-00 00:00:00', NULL, NULL, 1),
(3, 'BRN/4-2016/00005', 'Gyeon', NULL, '0000-00-00 00:00:00', NULL, NULL, 1),
(4, 'BRN/4-2016/00006', 'test', NULL, '0000-00-00 00:00:00', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pos_counter`
--

CREATE TABLE IF NOT EXISTS `pos_counter` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `sequence` bigint(20) NOT NULL,
  `prefix` varchar(255) COLLATE utf8_bin NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=8 ;

--
-- Dumping data for table `pos_counter`
--

INSERT INTO `pos_counter` (`id`, `type`, `sequence`, `prefix`, `updated_date`) VALUES
(1, 1, 12, 'CST', '2016-04-28 22:47:30'),
(3, 2, 6, 'BRN', '2016-04-25 20:40:42'),
(4, 3, 8, 'PRD', '2016-04-25 20:41:26'),
(5, 4, 10, 'STC', '2016-04-25 20:41:13'),
(6, 5, 10, 'BOK', '2016-04-28 22:39:18'),
(7, 6, 10, 'INV', '2016-04-28 21:52:57');

-- --------------------------------------------------------

--
-- Table structure for table `pos_customer`
--

CREATE TABLE IF NOT EXISTS `pos_customer` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `telepon` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `alamat` text COLLATE utf8_bin,
  `pic` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `hash` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `customer_code` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_code` (`customer_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=13 ;

--
-- Dumping data for table `pos_customer`
--

INSERT INTO `pos_customer` (`id`, `nama`, `telepon`, `alamat`, `pic`, `hash`, `customer_code`, `created_date`, `created_by`, `updated_by`, `updated_date`, `active`, `email`) VALUES
(1, 'David / Solid Garage', '', 'CT', NULL, NULL, 'CST/4-2016/00001', NULL, NULL, NULL, NULL, 1, NULL),
(2, 'RKUM', '', 'RK', '', '1802db2aba0ab6b83bdb0595a822b761', 'CST/4-2016/00002', NULL, NULL, NULL, NULL, 1, ''),
(3, 'OMOM', '', 'OM', '', 'b7d3d46816144865c1c989b5b49b2e03', 'CST/4-2016/00003', NULL, NULL, NULL, NULL, 1, ''),
(4, 'CT3', '', 'CT3', NULL, '304fb3c857d1022984ebca9a2ea682c4', 'CST/4-2016/00004', NULL, NULL, NULL, NULL, 1, ''),
(5, 'Rendi kumala', '021', 'RK', NULL, 'e386c8aa81a27bfbac27a9715074f8dc', 'CST/4-2016/00005', NULL, NULL, NULL, NULL, 1, 'Jshshsh@sjjs.com'),
(6, 'Lifetimesys', '123', 'jalan', 'test', '19ceffa6d77f4f0b987b3d0268d1ba6c', 'CST/4-2016/00006', NULL, NULL, NULL, NULL, 1, ''),
(7, 'STA', '777', 'lol', 'apa aja', 'd94ecc81248292af7393153f98b32067', 'CST/4-2016/00007', NULL, NULL, NULL, NULL, 1, ''),
(8, 'muara', '1111', 'iyiyiy', 'joni', '7e2219278947fbba391270573ed86177', 'CST/4-2016/00008', NULL, NULL, NULL, NULL, 1, ''),
(9, 'johny', '166', '', '', '05da9d587437a3f58cf91a8694448793', 'CST/4-2016/00009', NULL, NULL, NULL, NULL, 1, ''),
(10, 'johnny', '', '', '', 'f4eb27cea7255cea4d1ffabf593372e8', 'CST/4-2016/00010', NULL, NULL, NULL, NULL, 1, ''),
(11, 'jo', '', '', '', '674f33841e2309ffdd24c85dc3b999de', 'CST/4-2016/00011', NULL, NULL, NULL, NULL, 1, ''),
(12, 'sta', '', 'woi', '', '9ff70f907dccf50882f2c6c530519eac', 'CST/4-2016/00012', NULL, NULL, NULL, NULL, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `pos_history_stock`
--

CREATE TABLE IF NOT EXISTS `pos_history_stock` (
  `id` bigint(20) NOT NULL,
  `stock_id` bigint(20) NOT NULL,
  `stock_in` bigint(20) NOT NULL DEFAULT '0',
  `stock_out` bigint(20) NOT NULL DEFAULT '0',
  `notes` text COLLATE utf8_bin,
  `created_date` datetime DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `pos_history_stock`
--

INSERT INTO `pos_history_stock` (`id`, `stock_id`, `stock_in`, `stock_out`, `notes`, `created_date`, `created_by`) VALUES
(0, 1, 10, 0, 'addStock', '2016-04-25 19:17:20', 'ryan'),
(0, 2, 17, 0, 'addStock', '2016-04-25 19:18:43', 'ryan'),
(0, 3, 100, 0, 'addStock', '2016-04-25 20:31:09', 'ryan'),
(0, 1, 10, 0, 'addStock', '2016-04-25 20:31:14', 'super.admin'),
(0, 2, 0, 2, 'PAID Invoice INV/4-2016/00002', '2016-04-25 20:38:13', 'ryan'),
(0, 1, 0, 3, 'PAID Invoice INV/4-2016/00002', '2016-04-25 20:38:13', 'ryan'),
(0, 4, 1000, 0, 'addStock', '2016-04-25 20:39:40', 'ryan'),
(0, 5, 190, 0, 'addStock', '2016-04-25 20:41:14', 'ryan'),
(0, 2, 1000, 0, 'addStock', '2016-04-25 20:44:02', 'ryan'),
(0, 2, 2000, 0, 'addStock', '2016-04-25 20:44:35', 'ryan'),
(0, 5, 2, 0, 'updateStock', '2016-04-25 21:14:42', 'ryan'),
(0, 1, 0, 0, 'updateStock', '2016-04-25 21:15:51', 'ryan'),
(0, 3, 0, 0, 'updateStock', '2016-04-25 22:14:07', 'ryan'),
(0, 1, 20, 0, 'addStock', '2016-04-25 23:37:37', 'super.admin'),
(0, 1, 10, 0, 'updateStock', '2016-04-25 23:37:50', 'super.admin'),
(0, 1, 10, 0, 'updateStock', '2016-04-25 23:38:07', 'super.admin'),
(0, 2, 0, 7, 'PAID Invoice INV/4-2016/00006', '2016-04-28 20:54:57', 'super.admin'),
(0, 2, 0, 2, 'PAID Invoice INV/4-2016/00010', '2016-04-28 21:53:17', 'super.admin'),
(0, 1, 0, 2, 'PAID Invoice INV/4-2016/00010', '2016-04-28 21:53:17', 'super.admin');

-- --------------------------------------------------------

--
-- Table structure for table `pos_invoice`
--

CREATE TABLE IF NOT EXISTS `pos_invoice` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `invoice_code` varchar(255) COLLATE utf8_bin NOT NULL,
  `booking_code` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `billing_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `billing_address` text COLLATE utf8_bin NOT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `billing_phone` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `billing_email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `freight` double NOT NULL DEFAULT '0',
  `term_of_payment` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `location_id` bigint(20) NOT NULL,
  `notes` text COLLATE utf8_bin NOT NULL,
  `state` tinyint(4) NOT NULL,
  `finalize_date` datetime DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_code` (`invoice_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=7 ;

--
-- Dumping data for table `pos_invoice`
--

INSERT INTO `pos_invoice` (`id`, `invoice_code`, `booking_code`, `billing_name`, `billing_address`, `customer_id`, `billing_phone`, `billing_email`, `freight`, `term_of_payment`, `location_id`, `notes`, `state`, `finalize_date`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(1, 'INV/4-2016/00002', 'BOK/4-2016/00005', 'CT', 'CT', NULL, '', '', 5, '30 D', 0, '', 2, '2016-04-20 00:00:00', 'ryan', '2016-04-25 19:21:33', 'ryan', '2016-04-25 20:38:12'),
(2, 'INV/4-2016/00010', 'BOK/4-2016/00006', 'Rendi kumala', 'RK', NULL, '021', 'Jshshsh@sjjs.com', 20, '15 D', 0, '', 2, '2016-04-01 00:00:00', 'ryan', '2016-04-25 20:25:26', 'super.admin', '2016-04-28 21:53:17'),
(3, '', 'BOK/4-2016/00007', 'CT', 'CT', NULL, '', '', 10, '', 0, '', 3, '0000-00-00 00:00:00', 'ryan', '2016-04-25 20:36:29', 'ryan', '2016-04-25 20:36:38'),
(4, 'INV/4-2016/00006', 'BOK/4-2016/00008', 'CT3', 'CT3', NULL, '', '', 10, '', 0, '', 2, '2016-04-02 00:00:00', 'ryan', '2016-04-25 20:37:54', 'super.admin', '2016-04-28 20:54:57'),
(5, 'INV/4-2016/00004', 'BOK/4-2016/00009', 'CT4', 'CT4', NULL, '', '', 0, '', 0, '', 1, '0000-00-00 00:00:00', 'ryan', '2016-04-25 21:01:44', 'ryan', '2016-04-25 21:16:48'),
(6, '', 'BOK/4-2016/00010', 'muara', 'iyiyiy', NULL, '1111', '', 200, '', 0, '', 0, '0000-00-00 00:00:00', 'rendy', '2016-04-28 22:39:18', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pos_invoice_detail`
--

CREATE TABLE IF NOT EXISTS `pos_invoice_detail` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `invoice_id` bigint(20) NOT NULL,
  `location_id` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=34 ;

--
-- Dumping data for table `pos_invoice_detail`
--

INSERT INTO `pos_invoice_detail` (`id`, `product_id`, `quantity`, `price`, `active`, `invoice_id`, `location_id`) VALUES
(7, 3, 20, 1300, 1, 3, 1),
(8, 1, 6, 500000, 1, 3, 1),
(12, 2, 2, 27, 1, 1, 2),
(13, 1, 3, 20, 1, 1, 1),
(17, 2, 1, 30, 1, 5, 2),
(18, 1, 5, 2300000, 1, 5, 1),
(23, 2, 7, 27, 1, 4, 2),
(30, 2, 2, 27, 1, 2, 2),
(31, 1, 2, 11, 1, 2, 1),
(32, 3, 3, 1700, 1, 6, 1),
(33, 2, 4, 27, 1, 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `pos_invoice_status_history`
--

CREATE TABLE IF NOT EXISTS `pos_invoice_status_history` (
  `id` bigint(20) NOT NULL,
  `invoice_id` bigint(20) NOT NULL,
  `notes` text COLLATE utf8_bin,
  `state` tinyint(4) NOT NULL,
  `executed_by` varchar(255) COLLATE utf8_bin NOT NULL,
  `executed_date` datetime NOT NULL,
  KEY `invoice_id` (`invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `pos_permission`
--

CREATE TABLE IF NOT EXISTS `pos_permission` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `permission_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `code` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Dumping data for table `pos_permission`
--

INSERT INTO `pos_permission` (`id`, `permission_name`, `code`) VALUES
(1, 'Super Admin', 'ADM'),
(2, 'Admin', 'INV'),
(3, 'Marketing', 'STC');

-- --------------------------------------------------------

--
-- Table structure for table `pos_permission_map`
--

CREATE TABLE IF NOT EXISTS `pos_permission_map` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `allowed` tinyint(1) NOT NULL DEFAULT '1',
  `action` varchar(255) NOT NULL,
  `permission` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `pos_permission_map`
--

INSERT INTO `pos_permission_map` (`id`, `allowed`, `action`, `permission`) VALUES
(1, 1, 'ADD_INVOICE', 2),
(2, 1, 'VIEW_INVENTORY', 2),
(3, 1, 'VIEW_INVOICE', 2),
(5, 1, 'VIEW_INVENTORY', 3),
(7, 1, 'VIEW_STOCK', 3),
(8, 1, 'VIEW_STOCK', 2),
(9, 1, 'SUPER_ADMIN', 1),
(10, 1, 'VIEW_SELL_PRICE', 2),
(11, 1, 'VIEW_LOCATION', 2),
(12, 1, 'VIEW_BUY_PRICE', 2),
(13, 1, 'VIEW_DASHBOARD', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pos_product`
--

CREATE TABLE IF NOT EXISTS `pos_product` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_code` varchar(255) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `brand_id` bigint(20) NOT NULL,
  `created_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Dumping data for table `pos_product`
--

INSERT INTO `pos_product` (`id`, `product_code`, `name`, `brand_id`, `created_by`, `created_date`, `updated_by`, `updated_date`, `active`) VALUES
(1, 'PRD/4-2016/00004', 'Wax 100ml', 2, NULL, '2016-04-25 18:55:03', NULL, NULL, 1),
(2, 'PRD/4-2016/00005', 'Spray 1000ml', 1, NULL, '2016-04-25 18:55:17', NULL, NULL, 1),
(3, 'PRD/4-2016/00006', 'Coat 1000ml', 3, NULL, '2016-04-25 18:57:42', NULL, NULL, 1),
(4, 'PRD/4-2016/00007', 'test', 3, NULL, '2016-04-25 20:40:29', NULL, NULL, 0),
(5, 'PRD/4-2016/00008', 'a', 3, NULL, '2016-04-25 20:41:26', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `pos_stock`
--

CREATE TABLE IF NOT EXISTS `pos_stock` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `stock_code` varchar(255) COLLATE utf8_bin NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `location_id` bigint(20) NOT NULL,
  `stock` bigint(20) NOT NULL DEFAULT '0',
  `reserved_stock` int(11) NOT NULL DEFAULT '0',
  `harga_beli` double NOT NULL DEFAULT '0',
  `harga_bengkel` double NOT NULL DEFAULT '0',
  `harga_dist_area` double NOT NULL DEFAULT '0',
  `harga_dealer` double NOT NULL DEFAULT '0',
  `harga_retail` double NOT NULL DEFAULT '0',
  `created_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_id` (`product_id`,`location_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Dumping data for table `pos_stock`
--

INSERT INTO `pos_stock` (`id`, `stock_code`, `product_id`, `location_id`, `stock`, `reserved_stock`, `harga_beli`, `harga_bengkel`, `harga_dist_area`, `harga_dealer`, `harga_retail`, `created_by`, `created_date`, `updated_by`, `updated_date`, `active`) VALUES
(1, 'STC/4-2016/00006', 1, 1, 55, 0, 1500000, 1700000, 1900000, 2100000, 2300000, 'ryan', '2016-04-25 19:17:20', 'super.admin', '2016-04-28 21:53:17', 1),
(2, 'STC/4-2016/00007', 2, 2, 3006, 0, 20, 21, 25, 27, 30, 'ryan', '2016-04-25 19:18:43', 'super.admin', '2016-04-28 21:53:17', 1),
(3, 'STC/4-2016/00008', 3, 1, 100, 0, 1000, 1100, 1300, 1500, 1700, 'ryan', '2016-04-25 20:31:09', 'ryan', '2016-04-25 22:14:07', 1),
(4, 'STC/4-2016/00009', 3, 3, 1000, 0, 100000, 100000, 100000, 100000, 100000, 'ryan', '2016-04-25 20:39:40', NULL, '2016-04-25 22:21:48', 0),
(5, 'STC/4-2016/00010', 1, 4, 192, 0, 1000000, 1100000, 1300000, 1500000, 1700000, 'ryan', '2016-04-25 20:41:13', 'ryan', '2016-04-25 21:14:42', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pos_user`
--

CREATE TABLE IF NOT EXISTS `pos_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(32) COLLATE utf8_bin NOT NULL,
  `full_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `address` text COLLATE utf8_bin NOT NULL,
  `telepon` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `permission` bigint(20) NOT NULL,
  `created_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `username` (`username`,`password`),
  KEY `username_2` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=40 ;

--
-- Dumping data for table `pos_user`
--

INSERT INTO `pos_user` (`id`, `username`, `password`, `full_name`, `address`, `telepon`, `permission`, `created_by`, `created_date`, `updated_by`, `updated_date`, `active`) VALUES
(1, 'super.admin', '4263c97091145ba071a4f8a872e22646', 'super admin', 'test text alamat', '082818221', 1, NULL, NULL, NULL, NULL, 1),
(36, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin', '', '', 2, NULL, NULL, NULL, NULL, 1),
(37, 'marketing', 'c769c2bd15500dd906102d9be97fdceb', 'marketing', '', '01293', 3, NULL, NULL, NULL, NULL, 1),
(38, 'ryan', '10c7ccc7a4f0aff03c915c485565b9da', 'ryan', '', '', 1, NULL, NULL, NULL, NULL, 1),
(39, 'rendy', '88ad32a14f7f7964d03dad411ffcc59b', 'Rendy Kumala', '', '', 1, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pos_warehouse`
--

CREATE TABLE IF NOT EXISTS `pos_warehouse` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `warehouse_code` varchar(255) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Dumping data for table `pos_warehouse`
--

INSERT INTO `pos_warehouse` (`id`, `warehouse_code`, `name`, `created_by`, `created_date`, `updated_by`, `updated_date`, `active`) VALUES
(1, 'WH-00000001', 'Gudang Ryan', NULL, NULL, NULL, NULL, 1),
(2, 'WH-00000002', 'Gudang Willy', NULL, NULL, NULL, NULL, 1),
(3, 'WH-00000003', 'Gudang Showroom', NULL, NULL, NULL, NULL, 1),
(4, 'WH-00000004', 'Gudang Pinjaman', NULL, NULL, NULL, NULL, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
