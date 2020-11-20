-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 28, 2020 at 06:04 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lab-all-four-learn`
--

-- --------------------------------------------------------

--
-- Table structure for table `booster_member_manage_schools`
--

DROP TABLE IF EXISTS `booster_member_manage_schools`;
CREATE TABLE `booster_member_manage_schools` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

ALTER  TABLE `booster_schools`
ADD member_id int(11) DEFAULT NULL COMMENT 'null when create form CMS (temp), not null when create form registration for validate' AFTER id,
ADD `contact_person` VARCHAR(255) NULL AFTER `member_id`,
ADD status int(11) NOT NULL DEFAULT '2' COMMENT '2: processing, 1: approved, 0: reject' AFTER enabled;

--
-- Table structure for table `booster_school_business_registrations`
--

DROP TABLE IF EXISTS `booster_school_business_registrations`;
CREATE TABLE `booster_school_business_registrations` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booster_member_manage_schools`
--
ALTER TABLE `booster_member_manage_schools`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booster_school_business_registrations`
--
ALTER TABLE `booster_school_business_registrations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booster_member_manage_schools`
--
ALTER TABLE `booster_member_manage_schools`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table `booster_school_business_registrations`
--
ALTER TABLE `booster_school_business_registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;