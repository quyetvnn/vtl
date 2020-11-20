ALTER TABLE `booster_member_login_methods` ADD `original_member_id` INT NULL AFTER `id`;
ALTER TABLE `booster_member_roles` ADD `original_member_id` INT NULL AFTER `id`;
ALTER TABLE `booster_member_roles` CHANGE `original_member_id` `original_member_id` INT(11) NULL DEFAULT NULL COMMENT 'for stored current member id after mapping new member id';

-- set value original_member_id = value member_id columns
update `booster_member_login_methods`
set `original_member_id` = `member_id`;

update `booster_member_roles`
set `original_member_id` = `member_id`;


-- add list teacher for assignments
CREATE TABLE `booster_teacher_assignments_participants` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `assignment_id` int(11) DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `booster_teacher_assignments_participants`
ADD PRIMARY KEY (`id`);

ALTER TABLE `booster_teacher_assignments_participants`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `booster_teacher_create_assignments` ADD `group_id` INT NULL AFTER `class_id`;