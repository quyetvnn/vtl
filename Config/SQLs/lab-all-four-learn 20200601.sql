ALTER TABLE `booster_administrators` CHANGE `password` `password` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;
ALTER TABLE `booster_schools` ADD `member_login_method_id` INT NULL AFTER `member_id`;
ALTER TABLE `booster_member_roles` ADD `school_id` INT NULL AFTER `role_id`;