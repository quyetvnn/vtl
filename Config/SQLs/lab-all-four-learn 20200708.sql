UPDATE `booster_login_methods` SET `id` = '900002', `name` = '@SOCIAL-FACEBOOK-NETWORK@'    WHERE `booster_login_methods`.`id` = '1000';
UPDATE `booster_login_methods` SET `id` = '900001', `name` = '@SOCIAL-GOOGLE-NETWORK@'      WHERE `booster_login_methods`.`id` = '1001';

ALTER TABLE `booster_member_login_methods` CHANGE `password` `password` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;

-- -------------------------------
-- ENHANCE LANGUAGE TABLE: ADD MORE LANGUAGE --
-- -------------------------------
UPDATE `booster_languages` SET `name` = '简体中文', `enabled` = true  WHERE `booster_languages`.`id` = 2;

-- -------------------------------
-- ENHANCE ADMINISTRATOR TABLE --
-- -------------------------------
-- NO NEED RUN ON PRODUCTION
ALTER TABLE `booster_administrators` CHANGE `school_id` `member_id` INT(11) NULL DEFAULT NULL;