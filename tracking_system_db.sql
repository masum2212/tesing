-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 11, 2022 at 10:56 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tracking_system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `track`
--

CREATE TABLE `track` (
  `id` int(100) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `line` varchar(255) NOT NULL,
  `point` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `img_path` varchar(255) NOT NULL,
  `created_at` varchar(255) DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `track`
--

INSERT INTO `track` (`id`, `user_id`, `product`, `line`, `point`, `barcode`, `img_path`, `created_at`) VALUES
(1, 'I-148', 'ac_ind', 'ac_ind_prod_1', 'packaging_point', '222555', 'http://localhost/hasibur/all_svn/SVN_hasibur/tracking_system_ac/upload/222555-2022_10_11_10_41_15.jpeg', '2022-10-11 10:41:15'),
(2, 'I-148', 'ac_ind', 'ac_ind_prod_1', 'packaging_point', '55225525', 'http://localhost/hasibur/all_svn/SVN_hasibur/tracking_system_ac/upload/55225525-2022_10_11_10_42_37.jpeg', '2022-10-11 10:42:37'),
(3, 'I-148', 'ac_out', 'ac_out_prod_1', 'packaging_point', '4f4r52', 'http://localhost/hasibur/all_svn/SVN_hasibur/tracking_system_ac/upload/4f4r52-2022_10_11_10_43_48.jpeg', '2022-10-11 10:43:48'),
(4, 'I-148', 'ac_out', 'ac_out_prod_1', 'packaging_point', 'ss555', 'http://localhost/hasibur/all_svn/SVN_hasibur/tracking_system_ac/upload/ss555-2022_10_11_10_51_09.jpeg', '2022-10-11 10:51:09'),
(5, 'I-148', 'ac_out', 'ac_out_prod_1', 'packaging_point', '25552', 'http://localhost/hasibur/all_svn/SVN_hasibur/tracking_system_ac/upload/25552-2022_10_11_10_53_49.jpeg', '2022-10-11 10:53:49'),
(6, 'I-148', 'ac_out', 'ac_out_prod_1', 'packaging_point', '55555', 'http://localhost/hasibur/all_svn/SVN_hasibur/tracking_system_ac/upload/55555-2022_10_11_10_53_57.jpeg', '2022-10-11 10:53:57'),
(7, 'I-148', 'ac_out', 'ac_out_prod_1', 'packaging_point', '44444', 'http://localhost/hasibur/all_svn/SVN_hasibur/tracking_system_ac/upload/44444-2022_10_11_10_54_12.jpeg', '2022-10-11 10:54:12');

-- --------------------------------------------------------

--
-- Table structure for table `user_prod`
--

CREATE TABLE `user_prod` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `is_active` int(2) NOT NULL DEFAULT 1,
  `short_code` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_prod`
--

INSERT INTO `user_prod` (`id`, `user_id`, `product`, `is_active`, `short_code`) VALUES
(1, 'I-167', 'Refrigerator', 1, 'ref'),
(2, 'I-167', 'Television', 1, 'tv'),
(3, 'I-167', 'AC ( InDoor)', 1, 'ac_ind'),
(4, 'I-167', 'AC ( Outdoor )', 1, 'ac_out'),
(5, 'I-168', 'AC ( InDoor)', 1, 'ac_ind'),
(6, 'I-168', 'AC ( Outdoor )', 1, 'ac_out');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`id`, `user_id`, `role`, `is_active`) VALUES
(1, 'I-148', 'super_admin', 1),
(2, 'I-167', 'admin', 1),
(3, 'I-168', 'user', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `track`
--
ALTER TABLE `track`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_prod`
--
ALTER TABLE `user_prod`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `track`
--
ALTER TABLE `track`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_prod`
--
ALTER TABLE `user_prod`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
