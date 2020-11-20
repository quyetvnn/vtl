
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
(3, 'credit-reduct-cms', 0, 1, '2020-06-08 14:28:25', 3, '2020-06-08 17:16:57', NULL);

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
(1, 1, 'zho', '系統增加', 'v'),
(2, 1, 'eng', 'System Increase', ''),
(3, 2, 'zho', '系統增加-支付網關', 'v'),
(4, 2, 'eng', 'System Increase By Payment gate', ''),
(5, 3, 'zho', '系統減少', 'v'),
(6, 3, 'eng', 'System Reduct', '');

-- --------------------------------------------------------

--
-- Table structure for table `booster_members_credits`
--

DROP TABLE IF EXISTS `booster_members_credits`;
CREATE TABLE `booster_members_credits` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `credit_type_id` int(11) DEFAULT NULL,
  `pay_dollar_ref` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `credit` decimal(12,2) DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci,
  `school_id` int(11) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for table `booster_members_credits`
--
ALTER TABLE `booster_members_credits`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booster_credit_types`
--
ALTER TABLE `booster_credit_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `booster_credit_type_languages`
--
ALTER TABLE `booster_credit_type_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `booster_members_credits`
--
ALTER TABLE `booster_members_credits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;