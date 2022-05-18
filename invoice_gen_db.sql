-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2022 at 08:08 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `invoice_gen_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_table`
--

CREATE TABLE `customer_table` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer_table`
--

INSERT INTO `customer_table` (`id`, `customer_id`, `customer_name`, `created_at`, `updated_at`, `created_by`) VALUES
(1, 100001, 'Lambert Electromec Ltd', '2022-03-03 14:55:38', '2022-04-07 14:58:12', 'admin'),
(2, 100002, 'Project Debbas Nig Ltd', '2022-04-07 14:55:38', '2022-04-07 14:58:12', 'admin'),
(3, 100003, 'Supprium Nigeria Ltd', '2022-04-18 14:39:48', '2022-04-18 14:39:48', 'iphyze');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_table`
--

CREATE TABLE `invoice_table` (
  `id` int(11) NOT NULL,
  `invoice_number` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `project` varchar(255) NOT NULL,
  `po_number` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'uncleared',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoice_table`
--

INSERT INTO `invoice_table` (`id`, `invoice_number`, `customer_name`, `project`, `po_number`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1101, 'Lambert Electromec Ltd', 'Head Office', 'LEM/PO/2022/0055', 'cleared', '2022-03-30 14:46:09', 'admin', '2022-05-03 01:06:01', 'iphyze'),
(2, 1102, 'Project Debbas Nig Ltd', 'Victoria Island', 'LEM/PO/2022/0332', 'uncleared', '2022-04-01 21:00:31', 'admin', '2022-04-01 21:00:31', 'admin'),
(3, 1103, 'Project Debbas Nig Ltd', 'Victoria Island', 'LEM/PO/2022/0332', 'cleared', '2022-04-01 21:06:03', 'admin', '2022-05-03 01:03:12', 'iphyze'),
(4, 1104, 'Lambert Electromec Ltd', 'Head Office', 'LEM/PO/2022/0454', 'uncleared', '2022-04-06 13:20:23', 'admin', '2022-04-06 13:20:23', 'admin'),
(5, 1105, 'Lambert Electromec Ltd', 'Victoria Island', 'LEM/PO/2022/2012', 'uncleared', '2022-04-18 17:16:34', 'admin', '2022-04-18 17:16:34', 'admin'),
(6, 1106, 'Supprium Nigeria Ltd', 'Victoria Island', 'LEM/PO/2022/1038', 'uncleared', '2022-05-03 09:33:46', 'admin', '2022-05-03 09:33:46', 'admin'),
(7, 1107, 'Supprium Nigeria Ltd', 'Victoria Island', 'LEM/PO/2022/2350', 'uncleared', '2022-05-17 15:33:28', 'iphyze', '2022-05-17 15:33:28', ''),
(8, 1108, 'Project Debbas Nig Ltd', 'Victoria Island', 'LEM/PO/2022/2145', 'uncleared', '2022-05-17 17:53:50', 'iphyze', '2022-05-17 17:53:50', '');

-- --------------------------------------------------------

--
-- Table structure for table `new_invoice_table`
--

CREATE TABLE `new_invoice_table` (
  `id` int(11) NOT NULL,
  `invoice_number` int(11) NOT NULL,
  `po_number` varchar(255) NOT NULL,
  `project` varchar(255) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_price` varchar(255) NOT NULL,
  `product_quantity` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `vat` float NOT NULL,
  `discount` float NOT NULL,
  `vat_figure` float NOT NULL,
  `discount_figure` float NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'uncleared',
  `customer` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `new_invoice_table`
--

INSERT INTO `new_invoice_table` (`id`, `invoice_number`, `po_number`, `project`, `product_code`, `product_description`, `product_price`, `product_quantity`, `total`, `vat`, `discount`, `vat_figure`, `discount_figure`, `status`, `customer`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 1101, 'LEM/PO/2022/0055', 'Head Office', 'PR-1', 'Pieces of 15 watts bulb warm white', '1400', '30', 42000, 7.5, 2, 3087, 840, 'cleared', 'Lambert Electromec Ltd', '2022-01-30 05:20:14', 'admin', '2022-05-03 01:06:01', 'iphyze'),
(2, 1101, 'LEM/PO/2022/0055', 'Head Office', 'SNL-036', '5 way APC Bulb with surg ', '10500', '3', 31500, 7.5, 2, 2315.25, 630, 'cleared', 'Lambert Electromec Ltd', '2022-01-30 12:22:27', 'admin', '2022-05-03 01:06:01', 'iphyze'),
(3, 1102, 'LEM/PO/2022/0332', 'Victoria Island', 'PR-1', 'Pieces of 15 watts bulb warm white', '1400', '4', 5600, 7.5, 1, 415.8, 56, 'uncleared', 'Project Debbas Nig Ltd', '2022-02-01 08:45:23', 'admin', '2022-02-01 08:45:23', 'admin'),
(4, 1102, 'LEM/PO/2022/0332', 'Victoria Island', 'SNL-036', '5 way APC Bulb with surg ', '10500', '15', 157500, 7.5, 1, 11694.4, 1575, 'uncleared', 'Project Debbas Nig Ltd', '2022-02-01 03:26:39', 'admin', '2022-04-14 11:50:26', 'admin'),
(5, 1103, 'LEM/PO/2022/0332', 'Victoria Island', 'PR-1', 'Pieces of 15 watts bulb warm white', '1400', '10', 14000, 7.5, 0, 1050, 0, 'cleared', 'Project Debbas Nig Ltd', '2022-03-01 21:06:03', 'admin', '2022-05-03 01:03:12', 'iphyze'),
(6, 1103, 'LEM/PO/2022/0332', 'Victoria Island', 'SNL-036', '5 way APC Bulb with surg ', '10500', '20', 210000, 7.5, 0, 15750, 0, 'cleared', 'Project Debbas Nig Ltd', '2022-03-01 21:06:03', 'admin', '2022-05-03 01:03:12', 'iphyze'),
(7, 1104, 'LEM/PO/2022/0454', 'Head Office', 'SNL-036', '5 way APC Bulb with surg ', '10500', '2', 21000, 7.5, 0, 1575, 0, 'uncleared', 'Lambert Electromec Ltd', '2022-04-06 13:20:23', 'admin', '2022-04-14 11:52:19', 'admin'),
(8, 1104, 'LEM/PO/2022/0454', 'Head Office', 'TP-S', 'Transportation', '10000', '1', 10000, 0, 0, 0, 0, 'uncleared', 'Lambert Electromec Ltd', '2022-04-06 13:20:23', 'admin', '2022-04-06 13:20:23', 'admin'),
(9, 1105, 'LEM/PO/2022/2012', 'Victoria Island', 'PR-1', 'Pieces of 15 watts bulb warm white', '1400', '10', 14000, 7.5, 2, 1029, 280, 'uncleared', 'Lambert Electromec Ltd', '2022-04-18 17:16:34', 'admin', '2022-04-18 17:16:34', ''),
(10, 1105, 'LEM/PO/2022/2012', 'Victoria Island', 'SNL-036', '5 way APC Bulb with surg ', '10500', '10', 105000, 7.5, 0, 7875, 0, 'uncleared', 'Lambert Electromec Ltd', '2022-04-18 17:16:34', 'admin', '2022-04-18 17:16:34', ''),
(11, 1105, 'LEM/PO/2022/2012', 'Victoria Island', 'TP-S', 'Other Charges (Transportation)', '10000', '1', 10000, 0, 0, 0, 0, 'uncleared', 'Lambert Electromec Ltd', '2022-04-18 17:16:35', 'admin', '2022-04-18 17:16:35', ''),
(12, 1106, 'LEM/PO/2022/1038', 'Victoria Island', 'PR-1', 'Pieces of 15 watts bulb warm white', '1400', '20', 28000, 7.5, 2, 2058, 560, 'uncleared', 'Supprium Nigeria Ltd', '2022-05-03 09:33:46', 'admin', '2022-05-03 09:33:46', ''),
(13, 1107, 'LEM/PO/2022/2350', 'Victoria Island', 'ME-DP-LOC-0850-NR-DP', 'Galvanized Steel Non-Return Gravity Damper Size: 850x850mm (Flanged)', '55000', '2', 110000, 7.5, 0, 8250, 0, 'uncleared', 'Supprium Nigeria Ltd', '2022-05-17 15:33:28', 'iphyze', '2022-05-17 15:33:28', ''),
(14, 1107, 'LEM/PO/2022/2350', 'Victoria Island', 'ME-SG-HEN_0261-ST-MA', 'Straight Male Adaptor 26mm x 1 Henco - REF:17PK-2606 ', '6500', '5', 32500, 7.5, 0, 2437.5, 0, 'uncleared', 'Supprium Nigeria Ltd', '2022-05-17 15:33:28', 'iphyze', '2022-05-17 15:33:28', ''),
(15, 1108, 'LEM/PO/2022/2145', 'Victoria Island', 'PR-1', 'Pieces of 15 watts bulb warm white', '1400', '5', 7000, 7.5, 0, 525, 0, 'uncleared', 'Project Debbas Nig Ltd', '2022-05-17 17:53:50', 'iphyze', '2022-05-17 17:53:50', ''),
(18, 1108, 'LEM/PO/2022/2145', 'Victoria Island', 'ME-SG-HEN_0261-ST-MA', 'Straight Male Adaptor 26mm x 1 Henco - REF:17PK-2606 ', '6500', '10', 65000, 7.5, 2, 4777.5, 1300, 'uncleared', 'Project Debbas Nig Ltd', '2022-05-17 17:53:51', 'iphyze', '2022-05-17 17:53:51', ''),
(19, 1108, 'LEM/PO/2022/2145', 'Victoria Island', 'ARS KZN0885A/W', 'Nano Plastic Down Light white', '15000', '2', 30000, 7.5, 0, 2250, 0, 'uncleared', 'Project Debbas Nig Ltd', '2022-05-17 17:53:51', 'iphyze', '2022-05-17 17:53:51', ''),
(20, 1108, 'LEM/PO/2022/2145', 'Victoria Island', 'CO-CU-HIL-0115-ST-01', 'Steel Cutting Disc AC-D SPX 115 x 1.0 Hilti (Premium)', '936.83', '12', 11242, 7.5, 1, 834.716, 112.42, 'uncleared', 'Project Debbas Nig Ltd', '2022-05-17 17:53:51', 'iphyze', '2022-05-17 17:53:51', ''),
(21, 1108, 'LEM/PO/2022/2145', 'Victoria Island', 'ME-DP-LOC-0850-NR-DP', 'Galvanized Steel Non-Return Gravity Damper Size: 850x850mm (Flanged)', '55000', '2', 110000, 7.5, 0, 8250, 0, 'uncleared', 'Project Debbas Nig Ltd', '2022-05-17 17:53:51', 'iphyze', '2022-05-17 17:53:51', '');

-- --------------------------------------------------------

--
-- Table structure for table `products_table`
--

CREATE TABLE `products_table` (
  `id` int(11) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` float NOT NULL,
  `vat_status` varchar(255) NOT NULL,
  `disc_status` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) NOT NULL,
  `updated_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products_table`
--

INSERT INTO `products_table` (`id`, `product_code`, `product_name`, `product_price`, `vat_status`, `disc_status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'PR-1', 'Pieces of 15 watts bulb warm white', 1400, 'Yes', 'Yes', '2022-03-30 14:52:29', '2022-04-07 14:58:54', 'admin', 'admin'),
(2, 'SNL-036', '5 way APC Bulb with surg ', 10500, 'Yes', 'Yes', '2022-03-30 14:53:09', '2022-04-07 14:58:54', 'admin', 'admin'),
(3, 'TP-S', 'Other Charges (Transportation)', 10000, 'No', 'No', '2022-04-06 09:49:42', '2022-04-15 09:25:06', 'admin', 'admin'),
(4, 'ME-SG-HEN_0261-ST-MA', 'Straight Male Adaptor 26mm x 1 Henco - REF:17PK-2606 ', 6500, 'Yes', 'Yes', '2022-05-12 07:23:09', '2022-05-12 07:26:36', 'iphyze', 'iphyze'),
(5, 'ARS KZN0885A/W', 'Nano Plastic Down Light white', 15000, 'Yes', 'Yes', '2022-05-12 07:38:50', '2022-05-12 07:38:50', 'iphyze', 'iphyze'),
(6, 'CO-CU-HIL-0115-ST-01', 'Steel Cutting Disc AC-D SPX 115 x 1.0 Hilti (Premium)', 936.83, 'Yes', 'Yes', '2022-05-12 07:42:06', '2022-05-12 07:44:27', 'iphyze', 'iphyze'),
(7, 'ME-DP-LOC-0850-NR-DP', 'Galvanized Steel Non-Return Gravity Damper Size: 850x850mm (Flanged)', 55000, 'Yes', 'Yes', '2022-05-17 15:32:23', '2022-05-17 15:32:23', 'iphyze', 'iphyze');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL DEFAULT 'staff'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `designation`) VALUES
(1, 'admin', 'i.nzekwue@lambertelectromec', '608f72eb95bfaefe1a826a7dc97b3cfe ', 'Manager'),
(2, 'iphyze', 'iphyze@gmail.com', '608f72eb95bfaefe1a826a7dc97b3cfe ', 'Account');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_table`
--
ALTER TABLE `customer_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice_table`
--
ALTER TABLE `invoice_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_invoice_table`
--
ALTER TABLE `new_invoice_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_table`
--
ALTER TABLE `products_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_table`
--
ALTER TABLE `customer_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoice_table`
--
ALTER TABLE `invoice_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `new_invoice_table`
--
ALTER TABLE `new_invoice_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `products_table`
--
ALTER TABLE `products_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
