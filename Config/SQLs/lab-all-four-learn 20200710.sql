-- -------------------------------
-- FORGOT PASSWORD
-- -------------------------------
ALTER TABLE `booster_members` ADD `forgot_key` TEXT NULL AFTER `register_code`;
ALTER TABLE `booster_members` CHANGE `forgot_key` `forgot_key` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL;

-- -------------------------------
-- EMAIL CONFIRM KEY
-- -------------------------------
ALTER TABLE `booster_members` ADD `email_confirm_key` VARCHAR(255) NULL AFTER `forgot_key`;