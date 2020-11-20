/* feature edit, delete create assignment */

ALTER TABLE `booster_teacher_create_assignments` ADD `enabled` TINYINT(1) NOT NULL DEFAULT '1' AFTER `deadline`;
ALTER TABLE `booster_member_manage_schools` ADD `administrator_id` INT NULL AFTER `member_id`;

-- We had a day long meeting with client yesterday
-- and they had some critical comments on the LITE version that would like you to help fixing
-- 1a/ issue 156 ---> in frontend, allow users to change their own password (DONE)
-- 1b/ issue 157 ---> in CMS, allow A4L / VTL admin to force reset any users’ password
-- 1c/ issue 192 ---> in CMS, allow A4L / VTL admin to disable any users’ account ---> simply mark the record as DISABLED and add a prefix  void. in the email address ---> e.g. original email address is ricky.lam@vtl-vtl.com ---> change to void.ricky.lam@vtl-vtl.com . This help to “release” the email address and allow to be registered again.

-- 2/ issue 178 ---> in frontend (Teacher portal), teachers should be allowed to edit / delete assignments. (DONE)

-- 3/ issue 193 ---> in CMS, there should be a place for A4L admin to know which lesson can have the Playback ---> allow A4L admin to update the Playback video URL
-- 3a/ A4L admin is able to set the “number of days” that the playback video would be shown, e.g. 14 days before (DONE)
-- 3b/ in frontend (Teacher portal), teachers are allowed to change the “yes / no” to have the playback video BEFORE the lesson starts
-- 4/ @Han Tran for the Samsung tablet cannot login issue, we found there is a CSS style left: unset is used in the password field which IS NOT supported by the Samsung Internet (internal browser maybe). Please try to use another CSS style and we can ask the user to check


-- test one acc email manage multi school

TRUNCATE `booster_member_manage_schools`;