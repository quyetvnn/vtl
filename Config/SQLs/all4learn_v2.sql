
ALTER TABLE `booster_import_histories` ADD `role_id` INT NULL AFTER `type`;

UPDATE `booster_import_histories` 
SET `role_id`=2
WHERE `type` = 1;

UPDATE `booster_import_histories` 
SET `role_id`=1
WHERE `type` = 2;

/* note: remove type from import histories */


-- Modified structure
ALTER TABLE `booster_member_login_methods` ADD `display_name` VARCHAR(255) NULL COMMENT ' = nick name' AFTER `token`;
ALTER TABLE `booster_members` ADD `phone_verified` VARCHAR(255) NULL AFTER `phone_number`, ADD `facebook_id` VARCHAR(255) NULL AFTER `phone_verified`, ADD `google_id` VARCHAR(255) NULL AFTER `facebook_id`;
ALTER TABLE `booster_member_login_methods` CHANGE `login_method_id` `school_id` INT(11) NULL DEFAULT NULL;


-- remove login methods
DROP TABLE `booster_login_methods`;
DROP TABLE `booster_teacher_classes`;

-- Add role languages --
DROP TABLE IF EXISTS `booster_role_languages`;
CREATE TABLE `booster_role_languages` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


INSERT INTO `booster_role_languages` (`id`, `role_id`, `name`, `alias`) VALUES
(1, 0, '登記', 'zho'),
(2, 0, 'Self register', 'eng'),
(3, 2, '學生', 'zho'),
(4, 2, 'Student', 'eng'),
(5, 0, '登記', 'chi'),
(6, 2, '学生', 'chi'),
(7, 1, '導師', 'zho'),
(8, 1, 'Teacher', 'eng'),
(9, 1, '導師', 'chi'),
(10, 3, '學校管理員', 'zho'),
(11, 3, 'School Admin', 'eng'),
(12, 3, '学校管理圆', 'chi'),
(13, 4, '家長', 'zho'),
(14, 4, 'Parent', 'eng'),
(15, 4, '家長', 'chi'),
(16, 5, '客人', 'zho'),
(17, 5, 'Guest', 'eng'),
(18, 5, '客人', 'chi'),
(19, 6, '系統管理員', 'zho'),
(20, 6, 'System Admin', 'eng'),
(21, 6, '系統管理員', 'chi'),
(22, 10, 'VTL 管理員', 'zho'),
(23, 10, 'VTL Admin', 'eng'),
(24, 10, 'VTL 管理員', 'chi');

ALTER TABLE `booster_role_languages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `booster_role_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

-- change role_register = 100 for selfregister instead of 0 -> because 0 cannot get from DB

UPDATE `booster_roles` SET `id` = 100 WHERE `booster_roles`.`id` = 0;
UPDATE `booster_member_roles` SET `role_id` = 100 WHERE `booster_member_roles`.`role_id` = 0;
UPDATE `booster_role_languages` SET `role_id` = '100' WHERE `booster_role_languages`.`role_id` = 0;



--
-- Table structure for table `booster_teacher_lessons_participants`
--

DROP TABLE IF EXISTS `booster_teacher_lessons_participants`;
CREATE TABLE `booster_teacher_lessons_participants` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) NOT NULL,
  `group_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `booster_teacher_lessons_schedules`
--

DROP TABLE IF EXISTS `booster_teacher_lessons_schedules`;
CREATE TABLE `booster_teacher_lessons_schedules` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `duration_hour` int(11) DEFAULT NULL,
  `duration_minute` int(11) DEFAULT NULL,
  `attend` tinyint(1) NOT NULL DEFAULT '0',
  `paid` tinyint(1) NOT NULL DEFAULT '0',
  `attend_start` datetime DEFAULT NULL,
  `attend_end` datetime DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table will store all schedule of each student, teacher, we cannot store group because the group will change anytime';


--
-- Table structure for table `booster_teacher_lessons_schedules_histories`
--

DROP TABLE IF EXISTS `booster_teacher_lessons_schedules_histories`;
CREATE TABLE `booster_teacher_lessons_schedules_histories` (
  `id` int(11) NOT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `duration_hour` int(11) DEFAULT NULL,
  `duration_minute` int(11) DEFAULT NULL,
  `attend` tinyint(1) NOT NULL DEFAULT '0',
  `paid` tinyint(1) NOT NULL DEFAULT '0',
  `attend_start` datetime DEFAULT NULL,
  `attend_end` datetime DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='This table will store all schedule of each student, teacher, we cannot store group because the group will change anytime';


DROP TABLE IF EXISTS `booster_members_groups`;
CREATE TABLE `booster_members_groups` (
  `id` int(11) NOT NULL,
  `member_id` int(11) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `booster_schools_groups`
--

DROP TABLE IF EXISTS `booster_schools_groups`;
CREATE TABLE `booster_schools_groups` (
  `id` int(11) NOT NULL,
  `school_id` int(11) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `booster_schools_groups_languages` (
  `id` int(11) NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `category_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `booster_schools_groups_languages`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `booster_teacher_lessons_participants`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `booster_teacher_lessons_schedules`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `booster_teacher_lessons_schedules_histories`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `booster_members_groups`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `booster_schools_groups`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `booster_schools_groups_languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `booster_teacher_lessons_participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `booster_teacher_lessons_schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `booster_teacher_lessons_schedules_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `booster_members_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `booster_schools_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
  




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