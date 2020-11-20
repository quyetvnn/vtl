

DROP TABLE IF EXISTS `booster_schools_categories`;
CREATE TABLE `booster_schools_categories` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `enabled` tinyint(4) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booster_schools_categories_languages`
--

DROP TABLE IF EXISTS `booster_schools_categories_languages`;
CREATE TABLE `booster_schools_categories_languages` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booster_schools_groups`
--

DROP TABLE IF EXISTS `booster_schools_groups`;
CREATE TABLE `booster_schools_groups` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booster_schools_groups_languages`
--

DROP TABLE IF EXISTS `booster_schools_groups_languages`;
CREATE TABLE `booster_schools_groups_languages` (
  `id` int(11) NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `booster_schools_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booster_schools_categories_languages`
--
ALTER TABLE `booster_schools_categories_languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booster_schools_groups`
--
ALTER TABLE `booster_schools_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booster_schools_groups_languages`
--
ALTER TABLE `booster_schools_groups_languages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booster_schools_categories`
--
ALTER TABLE `booster_schools_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booster_schools_categories_languages`
--
ALTER TABLE `booster_schools_categories_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booster_schools_groups`
--
ALTER TABLE `booster_schools_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booster_schools_groups_languages`
--
ALTER TABLE `booster_schools_groups_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;