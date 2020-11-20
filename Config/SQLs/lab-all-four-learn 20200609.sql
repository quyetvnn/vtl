-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 09, 2020 at 05:38 AM
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
-- Table structure for table `booster_credit_types`
--

DROP TABLE IF EXISTS `booster_credit_types`;
CREATE TABLE `booster_credit_types` (
  `id` int(11) NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_add_point` tinyint(1) NOT NULL DEFAULT '1' COMMENT '= 1 => add point ;  = 0 => deduct point',
  `enabled` tinyint(1) DEFAULT '1',
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booster_credit_types`
--

INSERT INTO `booster_credit_types` (`id`, `slug`, `is_add_point`, `enabled`, `updated`, `updated_by`, `created`, `created_by`) VALUES
(1, 'credit-add-cms', 1, 1, '2020-06-08 14:29:02', 3, '2020-06-08 17:14:46', NULL),
(2, 'credit-add-payment-gate', 1, 1, '2020-06-08 14:28:25', 5, '2020-06-08 17:15:54', NULL),
(3, 'credit-reduct-cms', 0, 1, '2020-06-08 14:28:25', 3, '2020-06-08 17:16:57', NULL),
(4, 'credit-reduct-visit-zoom-link', 0, 1, '2020-06-08 14:28:25', 3, '2020-06-08 17:16:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `booster_credit_type_languages`
--

DROP TABLE IF EXISTS `booster_credit_type_languages`;
CREATE TABLE `booster_credit_type_languages` (
  `id` int(11) NOT NULL,
  `credit_type_id` int(11) DEFAULT NULL,
  `alias` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booster_credit_type_languages`
--

INSERT INTO `booster_credit_type_languages` (`id`, `credit_type_id`, `alias`, `name`, `description`) VALUES
(1, 1, 'zho', '系統增加', ''),
(2, 1, 'eng', 'System Increase', ''),
(3, 2, 'zho', '系統增加-支付網關', ''),
(4, 2, 'eng', 'System Increase By Payment gate', ''),
(5, 3, 'zho', '系統減少', ''),
(6, 3, 'eng', 'System Reduct', ''),
(7, 4, 'zho', '系統扣除（有學生参加zoom link）', ''),
(8, 4, 'eng', 'System Reduct when student visit zoom link', '');

-- --------------------------------------------------------

--
-- Table structure for table `booster_student_join_live_logs`
--

DROP TABLE IF EXISTS `booster_student_join_live_logs`;
CREATE TABLE `booster_student_join_live_logs` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `teacher_create_lesson_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `visit_day` datetime NOT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booster_credit_types`
--
ALTER TABLE `booster_credit_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booster_credit_type_languages`
--
ALTER TABLE `booster_credit_type_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booster_student_join_live_logs`
--
ALTER TABLE `booster_student_join_live_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booster_credit_types`
--
ALTER TABLE `booster_credit_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `booster_credit_type_languages`
--
ALTER TABLE `booster_credit_type_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `booster_student_join_live_logs`
--
ALTER TABLE `booster_student_join_live_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;