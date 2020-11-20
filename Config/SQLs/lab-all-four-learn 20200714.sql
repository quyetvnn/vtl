

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
(8, 4, 'eng', 'System Reduct when student visit zoom link', ''),
(9, 1, 'chi', '系统增加', ''),
(10, 2, 'chi', '系统增加-支付网关', ''),
(11, 3, 'chi', '系统减少', ''),
(12, 4, 'chi', '系统扣除（有学生参加zoom link）', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booster_credit_type_languages`
--
ALTER TABLE `booster_credit_type_languages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booster_credit_type_languages`
--
ALTER TABLE `booster_credit_type_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

INSERT INTO `booster_image_type_languages` (`id`, `image_type_id`, `alias`, `name`, `description`) VALUES 
(NULL, '1', 'chi', '学校的logo', '学校的logo'), 
(NULL, '2', 'chi', '会员图像', '会员图像'), 
(NULL, '3', 'chi', '学校的banner', '學校的banner');