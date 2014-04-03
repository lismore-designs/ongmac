-- phpMyAdmin SQL Dump
-- version 2.8.0.1
-- http://www.phpmyadmin.net
-- 
-- Host: custsql-ipg47.eigbox.net
-- Generation Time: Mar 28, 2014 at 01:23 AM
-- Server version: 5.5.32
-- PHP Version: 4.4.9
-- 
-- Database: `honda_parts1`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `sym_address`
-- 

CREATE TABLE `sym_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer` int(11) NOT NULL,
  `name` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `region` int(10) NOT NULL,
  `zip` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `sym_address`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `sym_coupons`
-- 

CREATE TABLE `sym_coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `off` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `off_type` int(11) NOT NULL,
  `order_min` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `sym_coupons`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `sym_customers`
-- 

CREATE TABLE `sym_customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `sym_customers`
-- 

INSERT INTO `sym_customers` VALUES (1, 'business@relaxcode.com', 'NjYzOTgyOQ==', 1);
INSERT INTO `sym_customers` VALUES (2, 'michealm@lismore-designs.com.au', 'YnJlZTEzMTI=', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `sym_options`
-- 

CREATE TABLE `sym_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `name` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `sym_options`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `sym_orders`
-- 

CREATE TABLE `sym_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `items` text COLLATE utf8_unicode_ci NOT NULL,
  `net` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `tax` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `shipping` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `discount` varchar(99) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `coupon` varchar(99) COLLATE utf8_unicode_ci DEFAULT NULL,
  `payment` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `customer` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `address` int(11) NOT NULL,
  `gateway` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `track` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `track_url` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `remarks` text COLLATE utf8_unicode_ci NOT NULL,
  `callback` int(11) NOT NULL DEFAULT '0',
  `seen` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- 
-- Dumping data for table `sym_orders`
-- 


-- --------------------------------------------------------

-- 
-- Table structure for table `sym_products`
-- 

CREATE TABLE `sym_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `price` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `shipping` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `stock` int(20) NOT NULL,
  `region` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL,
  `partinfo` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `partid` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

-- 
-- Dumping data for table `sym_products`
-- 

INSERT INTO `sym_products` VALUES (1, 'Test Product', '15.00', '5ff7be24219481c8f347b491946bfb39.jpg', 'This is test product', '5.00', 100, '0', 0, '', '');
INSERT INTO `sym_products` VALUES (2, 'COVER ASSY., CYLINDER HEAD', '73.79', '', 'COVER ASSY., CYLINDER HEAD', '0.00', 13, '1', 1, '12300-MGZ-J00', '2185448');
INSERT INTO `sym_products` VALUES (3, 'CAP, CYLINDER HEAD COVER', '12.89', '', 'CAP, CYLINDER HEAD COVER', '0.00', 1, '1', 1, '12331-MGZ-J00', '2185449');
INSERT INTO `sym_products` VALUES (4, 'GASKET COMP., CYLINDER HEAD COVER', '41.14', '', 'GASKET COMP., CYLINDER HEAD COVER', '0.00', 2, '1', 1, '12391-MGZ-J00', '2185451');
INSERT INTO `sym_products` VALUES (5, 'BOLT, HEAD COVER', '5.93', '', 'BOLT, HEAD COVER', '0.00', 1, '1', 1, '90002-MY5-850', '2185454');
INSERT INTO `sym_products` VALUES (6, 'DOWEL PIN, 10X16', '3.19', '', 'DOWEL PIN, 10X16', '0.00', 1, '1', 1, '94301-10160', '2185457');
INSERT INTO `sym_products` VALUES (7, 'COVER, REED VALVE', '5.96', '', 'COVER, REED VALVE', '0.00', 1, '1', 1, '18612-MGZ-J00', '2185453');
INSERT INTO `sym_products` VALUES (8, 'GASKET, WATER PUMP COVER', '1.20', '', 'GASKET, WATER PUMP COVER', '0.00', 1, '1', 1, '19226-KGH-900', '1987667');
INSERT INTO `sym_products` VALUES (9, 'BOLT, FLANGE, 6X65', '2.62', '', 'BOLT, FLANGE, 6X65', '0.00', 1, '1', 1, '90010-GHB-760', '1987672');
INSERT INTO `sym_products` VALUES (10, 'GASKET, CYLINDER HEAD', '77.79', '', 'GASKET, CYLINDER HEAD', '0.00', 1, '1', 1, '12251-MFL-003', '2248747');
INSERT INTO `sym_products` VALUES (11, 'PUMP ASSY., OIL', '56.01', '', 'PUMP ASSY., OIL', '0.00', 1, '1', 1, '15100-KYJ-900', '2141857');
INSERT INTO `sym_products` VALUES (12, 'CYLINDER', '1515.27', '', 'CYLINDER', '15.00', 1, '1', 1, '12100-MGP-000', '2248869');
INSERT INTO `sym_products` VALUES (13, 'DOWEL PIN, 10X16', '9.36', '', 'DOWEL PIN, 10X16', '15.00', 1, '1', 1, '90701-MV9-670', '2248874');
INSERT INTO `sym_products` VALUES (14, 'BOLT, FLANGE, 8X30', '1.93', '', 'BOLT, FLANGE, 8X30', '15.00', 1, '1', 1, '95701-08030-00', '2248876');
INSERT INTO `sym_products` VALUES (15, 'PROTECTOR, CASE', '9.05', '', 'PROTECTOR, CASE', '0.00', 1, '1', 1, '11365-MFM-000', '2096410');

-- --------------------------------------------------------

-- 
-- Table structure for table `sym_settings`
-- 

CREATE TABLE `sym_settings` (
  `setting` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  KEY `setting` (`setting`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 
-- Dumping data for table `sym_settings`
-- 

INSERT INTO `sym_settings` VALUES ('website_url', 'http://parts.relaxcode.com');
INSERT INTO `sym_settings` VALUES ('web_email', 'munzoor95@hotmail.com');
INSERT INTO `sym_settings` VALUES ('invoice_email', 'munzoor95@hotmail.com');
INSERT INTO `sym_settings` VALUES ('currency', 'USD');
INSERT INTO `sym_settings` VALUES ('currency_symbol', '$');
INSERT INTO `sym_settings` VALUES ('secret', 'symbiotic');
INSERT INTO `sym_settings` VALUES ('g_dis', '0');
INSERT INTO `sym_settings` VALUES ('fb_dis', '0');
INSERT INTO `sym_settings` VALUES ('shipping_min_items', '1');
INSERT INTO `sym_settings` VALUES ('max_order_total', '5000');
INSERT INTO `sym_settings` VALUES ('shipping_mode', '1');
INSERT INTO `sym_settings` VALUES ('free_shipping', '0');
INSERT INTO `sym_settings` VALUES ('tax', '');
INSERT INTO `sym_settings` VALUES ('fb_app_id', '');
INSERT INTO `sym_settings` VALUES ('fb_app_secret', '');
INSERT INTO `sym_settings` VALUES ('fb_url', '');
INSERT INTO `sym_settings` VALUES ('g_url', '');
INSERT INTO `sym_settings` VALUES ('mode', '1');
INSERT INTO `sym_settings` VALUES ('rc_private', '');
INSERT INTO `sym_settings` VALUES ('rc_public', '');

-- --------------------------------------------------------

-- 
-- Table structure for table `sym_shipping_regions`
-- 

CREATE TABLE `sym_shipping_regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `shipping` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- 
-- Dumping data for table `sym_shipping_regions`
-- 

INSERT INTO `sym_shipping_regions` VALUES (1, 'National', '0', 1);
INSERT INTO `sym_shipping_regions` VALUES (2, 'International', '0', 1);

-- --------------------------------------------------------

-- 
-- Table structure for table `sym_users`
-- 

CREATE TABLE `sym_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(99) COLLATE utf8_unicode_ci NOT NULL,
  `role` int(11) NOT NULL,
  `latest_login` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

-- 
-- Dumping data for table `sym_users`
-- 

INSERT INTO `sym_users` VALUES (1, 'munzoor95@hotmail.com', 'YWRtaW5hZG1pbg==', 1, '28 Mar 2014', '28 Mar 2014', 1);
