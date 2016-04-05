-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2016 at 04:54 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `getCounterSequence`(tipe INT) RETURNS varchar(255) CHARSET utf8 COLLATE utf8_bin
BEGIN
  DECLARE COUNTER_FOUND VARCHAR(255);
	UPDATE pos_counter SET sequence=(sequence+1) WHERE type= tipe;
    SELECT CONCAT(prefix,"-",LPAD(sequence,10,'0')) INTO COUNTER_FOUND FROM pos_counter WHERE type = tipe;
  RETURN COUNTER_FOUND;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `updateAvailableStock`(stockId BIGINT,quantity INT,notes TEXT, updatedBy VARCHAR(255)) RETURNS varchar(255) CHARSET utf8 COLLATE utf8_bin
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
  `id` bigint(20) NOT NULL,
  `stock_id` bigint(20) NOT NULL,
  `booking_code` varchar(255) COLLATE utf8_bin NOT NULL,
  `quantity` int(255) NOT NULL,
  `notes` text COLLATE utf8_bin NOT NULL,
  `created_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `pos_booking`
--

INSERT INTO `pos_booking` (`id`, `stock_id`, `booking_code`, `quantity`, `notes`, `created_by`, `created_date`, `updated_by`, `updated_date`, `active`) VALUES
(7, 5, 'BOK-0000000007', 3, 'asd;lkas dkas ;dk', NULL, '2016-03-28 01:34:13', NULL, NULL, 0),
(10, 5, 'BOK-0000000010', 10, 'test aja ya', 'febryo', '2016-03-28 02:47:39', 'febryo', '2016-03-28 02:47:39', 0),
(14, 5, 'BOK-0000000014', 10, 'asdasd', 'febryo', '2016-03-28 02:58:02', 'febryo', '2016-03-28 02:58:02', 0),
(15, 5, 'BOK-0000000015', 2, '1', 'febryo', '2016-03-28 03:09:04', 'febryo', '2016-03-28 03:09:04', 0),
(16, 5, 'BOK-0000000016', 4, 'asdasd', 'febryo', '2016-03-28 03:12:57', 'febryo', '2016-03-28 03:12:57', 0),
(17, 5, 'BOK-0000000017', 1, 'sad', 'febryo', '2016-03-28 03:36:11', 'febryo', '2016-03-28 03:36:11', 0),
(18, 5, 'BOK-0000000018', 30, 'buat iims', 'febryo', '2016-03-28 03:52:23', 'febryo', '2016-03-28 03:52:23', 0),
(19, 5, 'BOK-0000000019', 30, '1234', 'febryo', '2016-03-28 03:53:16', 'febryo', '2016-03-28 03:53:16', 0),
(20, 5, 'BOK-0000000020', 1, 'tes', 'febryo', '2016-03-28 03:54:15', 'febryo', '2016-03-28 03:54:15', 0),
(21, 5, 'BOK-0000000021', 9, 'test', 'febryo', '2016-03-28 03:55:29', 'febryo', '2016-03-28 03:55:29', 0),
(22, 5, 'BOK-0000000022', 1, '1', '1', '2016-03-28 04:22:22', '1', '2016-03-28 04:22:22', 0),
(23, 5, 'BOK-0000000023', 1, '1', '1', '2016-03-28 04:25:30', '1', '2016-03-28 04:25:30', 0),
(24, 5, 'BOK-0000000024', 1, '10', 'febryo', '2016-03-28 04:30:52', 'febryo', '2016-03-28 04:30:52', 0),
(25, 5, 'BOK-0000000025', 1, '10', 'febryo', '2016-03-28 04:31:08', 'febryo', '2016-03-28 04:31:08', 0),
(26, 5, 'BOK-0000000026', 1, 'test', 'febryo', '2016-03-28 04:32:16', 'febryo', '2016-03-28 04:32:16', 0),
(27, 5, 'BOK-0000000027', 1, 'test', 'febryo', '2016-03-28 04:36:48', 'febryo', '2016-03-28 04:36:48', 1),
(28, 5, 'BOK-0000000028', 2, 'test', 'febryo', '2016-03-28 04:37:01', 'febryo', '2016-03-28 04:37:01', 1),
(29, 5, 'BOK-0000000029', 1, 'test', 'febryo', '2016-03-28 04:37:50', 'febryo', '2016-03-28 04:37:50', 1),
(30, 5, 'BOK-0000000030', 3, 'test', 'febryo', '2016-03-28 04:37:58', 'febryo', '2016-03-28 04:37:58', 0),
(31, 6, 'BOK-0000000031', 10, 'booking ya', 'febryo', '2016-03-30 13:01:53', 'febryo', '2016-03-30 13:01:53', 0),
(32, 6, 'BOK-0000000032', 10, 'booking ya', 'febryo', '2016-03-30 13:03:07', 'febryo', '2016-03-30 13:03:07', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pos_brand`
--

CREATE TABLE IF NOT EXISTS `pos_brand` (
  `id` bigint(20) NOT NULL,
  `brand_code` varchar(255) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `pos_brand`
--

INSERT INTO `pos_brand` (`id`, `brand_code`, `name`, `created_by`, `created_date`, `updated_by`, `updated_date`, `active`) VALUES
(2, 'BRN-0000000001', 'Kit', NULL, '0000-00-00 00:00:00', NULL, NULL, 1),
(3, 'BRN-0000000002', 'Meguiar''s', NULL, '0000-00-00 00:00:00', NULL, NULL, 1),
(4, 'BRN-0000000003', '3M', NULL, '0000-00-00 00:00:00', NULL, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pos_counter`
--

CREATE TABLE IF NOT EXISTS `pos_counter` (
  `id` bigint(20) NOT NULL,
  `type` int(11) NOT NULL,
  `sequence` bigint(20) NOT NULL,
  `prefix` varchar(255) COLLATE utf8_bin NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `pos_counter`
--

INSERT INTO `pos_counter` (`id`, `type`, `sequence`, `prefix`, `updated_date`) VALUES
(1, 1, 16, 'CST', '0000-00-00 00:00:00'),
(3, 2, 3, 'BRN', '2016-03-19 00:00:00'),
(4, 3, 4, 'PRD', '2016-03-19 00:00:00'),
(5, 4, 7, 'STC', '2016-03-23 00:00:00'),
(6, 5, 32, 'BOK', '2016-03-25 22:50:06');

-- --------------------------------------------------------

--
-- Table structure for table `pos_customer`
--

CREATE TABLE IF NOT EXISTS `pos_customer` (
  `id` bigint(20) NOT NULL,
  `nama` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `telepon` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `alamat` text COLLATE utf8_bin,
  `customer_code` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `pos_customer`
--

INSERT INTO `pos_customer` (`id`, `nama`, `telepon`, `alamat`, `customer_code`, `created_date`, `created_by`, `updated_by`, `updated_date`, `active`) VALUES
(1, 'test', '123', '3121', NULL, '0000-00-00 00:00:00', '', '', '0000-00-00 00:00:00', 0),
(2, 'test', '123', '3121', NULL, '0000-00-00 00:00:00', '', '', '0000-00-00 00:00:00', 0),
(3, 'test', '123', '3121', NULL, '0000-00-00 00:00:00', '', '', '0000-00-00 00:00:00', 0),
(4, 'test', '123', '3121', NULL, '0000-00-00 00:00:00', '', '', '0000-00-00 00:00:00', 0),
(5, 'test', '123', '3121', 'CST-0000000012', '0000-00-00 00:00:00', '', '', '0000-00-00 00:00:00', 1),
(6, 'test', '123', '3121', 'CST-0000000013', '0000-00-00 00:00:00', '', '', '0000-00-00 00:00:00', 1),
(7, 'indogravure', '123123', 'adasdas', 'CST-0000000014', '0000-00-00 00:00:00', '', '', '0000-00-00 00:00:00', 1),
(8, 'hondad', '123', 'asdasd', 'CST-0000000015', '0000-00-00 00:00:00', '', '', '0000-00-00 00:00:00', 1),
(9, 'rio', '1234', 'testi ias dnaslkd n', 'CST-0000000016', '0000-00-00 00:00:00', '', '', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pos_invoice`
--

CREATE TABLE IF NOT EXISTS `pos_invoice` (
  `id` bigint(20) NOT NULL,
  `invoice_code` varchar(255) COLLATE utf8_bin NOT NULL,
  `billing_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `billing_address` text COLLATE utf8_bin NOT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `billing_phone` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `billing_email` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `location_id` bigint(20) NOT NULL,
  `notes` text COLLATE utf8_bin NOT NULL,
  `state` tinyint(4) NOT NULL,
  `created_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `pos_invoice_detail`
--

CREATE TABLE IF NOT EXISTS `pos_invoice_detail` (
  `id` bigint(20) NOT NULL,
  `product_id` bigint(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `invoice_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
  `executed_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `pos_permission`
--

CREATE TABLE IF NOT EXISTS `pos_permission` (
  `id` bigint(20) NOT NULL,
  `permission_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `code` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `pos_permission`
--

INSERT INTO `pos_permission` (`id`, `permission_name`, `code`) VALUES
(1, 'administrator', 'ADM'),
(2, 'invoice', 'INV'),
(3, 'stock', 'STC'),
(4, 'invoice & stock', 'INVSTC'),
(5, 'manager', 'MNG');

-- --------------------------------------------------------

--
-- Table structure for table `pos_product`
--

CREATE TABLE IF NOT EXISTS `pos_product` (
  `id` bigint(20) NOT NULL,
  `product_code` varchar(255) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `brand_id` bigint(20) NOT NULL,
  `created_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `pos_product`
--

INSERT INTO `pos_product` (`id`, `product_code`, `name`, `brand_id`, `created_by`, `created_date`, `updated_by`, `updated_date`, `active`) VALUES
(1, 'getCounterSequence(3)', 'tes', 3, NULL, NULL, NULL, NULL, 0),
(2, 'PRD-0000000001', 'car wash', 4, NULL, '0000-00-00 00:00:00', NULL, NULL, 0),
(3, 'PRD-0000000002', 'Cleaner Spray', 3, NULL, '2016-03-20 20:36:49', NULL, '2016-03-20 20:41:05', 1),
(4, 'PRD-0000000003', 'Rim Black', 2, NULL, '2016-03-20 20:42:08', NULL, NULL, 1),
(5, 'PRD-0000000004', 'Car wash 300ml', 4, NULL, '2016-03-24 22:50:20', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pos_stock`
--

CREATE TABLE IF NOT EXISTS `pos_stock` (
  `id` bigint(20) NOT NULL,
  `stock_code` varchar(255) COLLATE utf8_bin NOT NULL,
  `product_id` bigint(20) NOT NULL,
  `location_id` bigint(20) NOT NULL,
  `stock` bigint(20) NOT NULL DEFAULT '0',
  `harga_beli` double NOT NULL DEFAULT '0',
  `harga_bengkel` double NOT NULL DEFAULT '0',
  `harga_dist_area` double NOT NULL DEFAULT '0',
  `harga_dealer` double NOT NULL DEFAULT '0',
  `harga_retail` double NOT NULL DEFAULT '0',
  `created_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `pos_stock`
--

INSERT INTO `pos_stock` (`id`, `stock_code`, `product_id`, `location_id`, `stock`, `harga_beli`, `harga_bengkel`, `harga_dist_area`, `harga_dealer`, `harga_retail`, `created_by`, `created_date`, `updated_by`, `updated_date`, `active`) VALUES
(1, 'STC-0000000001', 3, 1, 0, 0, 0, 0, 0, 0, NULL, '2016-03-23 22:54:40', NULL, '2016-03-24 22:54:14', 0),
(2, 'STC-0000000002', 3, 3, 0, 0, 0, 0, 0, 0, NULL, '2016-03-24 18:13:49', NULL, '2016-03-24 22:54:18', 0),
(3, 'STC-0000000003', 3, 1, 0, 0, 0, 0, 0, 0, NULL, '2016-03-24 18:14:10', NULL, '2016-03-24 22:54:22', 0),
(4, 'STC-0000000004', 3, 3, 100, 0, 0, 0, 0, 0, NULL, '2016-03-24 18:15:21', NULL, '2016-03-24 22:54:26', 0),
(5, 'STC-0000000005', 3, 1, 100, 0, 2000, 1100, 1250, 1200, NULL, '2016-03-24 22:48:24', NULL, '2016-03-25 01:13:58', 1),
(6, 'STC-0000000007', 5, 3, 100, 0, 100, 100, 100, 100, NULL, '2016-03-30 12:57:41', NULL, '2016-04-04 17:39:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pos_user`
--

CREATE TABLE IF NOT EXISTS `pos_user` (
  `id` bigint(20) NOT NULL,
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
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `pos_user`
--

INSERT INTO `pos_user` (`id`, `username`, `password`, `full_name`, `address`, `telepon`, `permission`, `created_by`, `created_date`, `updated_by`, `updated_date`, `active`) VALUES
(1, 'febryo', '0c3284b8ba5dcc2e84e55786ee9e7a70', 'febryo agung', 'test text alamat', '082818221', 1, NULL, NULL, NULL, NULL, 0),
(2, 'mey', '1234', 'meyli', 'tets addr', '1234', 2, NULL, NULL, NULL, NULL, 0),
(3, 'rendi', '213123', 'rendi testing', 'test', '02010120', 4, NULL, NULL, NULL, NULL, 0),
(4, 'test1', '1234', 'test1-full', 'addr-test', '12345', 1, NULL, NULL, NULL, NULL, 0),
(5, 'test2', '1234', 'test2-full', 'addr-test', '12345', 1, NULL, NULL, NULL, NULL, 0),
(6, 'test3', '1234', 'test3-full', 'addr-test', '12345', 1, NULL, NULL, NULL, NULL, 1),
(7, 'test4', '1234', 'test4-full', 'addr-test', '12345', 1, NULL, NULL, NULL, NULL, 1),
(8, 'test5', '1234', 'test5-full', 'addr-test', '12345', 1, NULL, NULL, NULL, NULL, 1),
(9, 'test6', '1234', 'test6-full', 'addr-test', '12345', 1, NULL, NULL, NULL, NULL, 1),
(10, 'test7', '1234', 'test7-full', 'addr-test', '12345', 1, NULL, NULL, NULL, NULL, 1),
(11, 'test8', '1234', 'test8-full', 'addr-test', '12345', 1, NULL, NULL, NULL, NULL, 1),
(12, 'test9', '1234', 'test9-full', 'addr-test', '12345', 1, NULL, NULL, NULL, NULL, 0),
(13, 'test10', '1234', 'test10-full', 'addr-test', '12345', 1, NULL, NULL, NULL, NULL, 0),
(14, 'test11', '1234', 'test11-full', 'addr-test', '12345', 1, NULL, NULL, NULL, NULL, 0),
(15, '', '', '', 'addr-test', NULL, 0, NULL, NULL, NULL, NULL, 0),
(16, 'test13', '', 'test13-full sss', 'addr-test', '12345', 1, NULL, NULL, NULL, NULL, 0),
(17, 'test14', '54321', 'test14-full udatess', 'addr-test', '12345', 1, NULL, NULL, NULL, NULL, 0),
(18, 'test15', '1234', 'test15-fullS', 'addr-test', '12345', 1, NULL, NULL, NULL, NULL, 0),
(19, 'test16', '1234', 'test16-full', 'addr-test', '12345', 1, NULL, NULL, NULL, NULL, 1),
(20, 'febryolesmana', '12345', 'febryo lesmana', '', '1234', 2, NULL, NULL, NULL, NULL, 0),
(21, 'febryolesmana', '12345', 'febryo lesmana', '', '1234', 2, NULL, NULL, NULL, NULL, 0),
(22, 'febryolesmana', '12345', 'febryo lesmana', '', '1234', 2, NULL, NULL, NULL, NULL, 0),
(23, '21323', '213123', 'meyyy', '', '34567', 1, NULL, NULL, NULL, NULL, 0),
(24, '123', '123', 'test se se se s', '', '123', 3, NULL, NULL, NULL, NULL, 0),
(25, 'asjkdhasd', 'asjkdhasjkdh', 'jkashdjkashd', '', 'asjkdhasjkdh', 1, NULL, NULL, NULL, NULL, 1),
(26, 'kjhasdjkashdjkh', 'kjhasjkdhasjkdhasd', 'jsdjkashjkdh', '', 'jkhasdjkhasd', 4, NULL, NULL, NULL, NULL, 1),
(27, 'asjkdaskbd', 'jkbasdjkbasjkdbaskdb', 'kashabsbda', '', 'asjkdhasjkdh', 2, NULL, NULL, NULL, NULL, 1),
(28, 'kjsadnasjknd', 'asjkndasjkdn', 'jshjkshdjkashdjkasdh', '', '1202019', 5, NULL, NULL, NULL, NULL, 1),
(29, 'h', 'jkh', 'tet ete te tset', '', 'jkhjk', 1, NULL, NULL, NULL, NULL, 1),
(30, 'iousioasuiodu', 'oiuasioudasiodu', 'wteutioeutiou', '', 'asiodasiodu', 1, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pos_warehouse`
--

CREATE TABLE IF NOT EXISTS `pos_warehouse` (
  `id` bigint(20) NOT NULL,
  `warehouse_code` varchar(255) COLLATE utf8_bin NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `created_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_by` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `pos_warehouse`
--

INSERT INTO `pos_warehouse` (`id`, `warehouse_code`, `name`, `created_by`, `created_date`, `updated_by`, `updated_date`, `active`) VALUES
(1, 'WH-00000001', 'Gudang', NULL, NULL, NULL, NULL, 1),
(2, 'WH-00000002', 'Pinjam', NULL, NULL, NULL, NULL, 1),
(3, 'WH-00000003', 'showroom', NULL, NULL, NULL, NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pos_booking`
--
ALTER TABLE `pos_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_brand`
--
ALTER TABLE `pos_brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_counter`
--
ALTER TABLE `pos_counter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_customer`
--
ALTER TABLE `pos_customer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_code` (`customer_code`);

--
-- Indexes for table `pos_invoice`
--
ALTER TABLE `pos_invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_code` (`invoice_code`);

--
-- Indexes for table `pos_invoice_detail`
--
ALTER TABLE `pos_invoice_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_id` (`invoice_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `pos_invoice_status_history`
--
ALTER TABLE `pos_invoice_status_history`
  ADD KEY `invoice_id` (`invoice_id`);

--
-- Indexes for table `pos_permission`
--
ALTER TABLE `pos_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_product`
--
ALTER TABLE `pos_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_stock`
--
ALTER TABLE `pos_stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pos_user`
--
ALTER TABLE `pos_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`password`),
  ADD KEY `username_2` (`username`);

--
-- Indexes for table `pos_warehouse`
--
ALTER TABLE `pos_warehouse`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pos_booking`
--
ALTER TABLE `pos_booking`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `pos_brand`
--
ALTER TABLE `pos_brand`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `pos_counter`
--
ALTER TABLE `pos_counter`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pos_customer`
--
ALTER TABLE `pos_customer`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `pos_invoice`
--
ALTER TABLE `pos_invoice`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_invoice_detail`
--
ALTER TABLE `pos_invoice_detail`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pos_permission`
--
ALTER TABLE `pos_permission`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `pos_product`
--
ALTER TABLE `pos_product`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `pos_stock`
--
ALTER TABLE `pos_stock`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `pos_user`
--
ALTER TABLE `pos_user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `pos_warehouse`
--
ALTER TABLE `pos_warehouse`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
