ALTER TABLE `zt_story` ADD `source` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `plan` ;
ALTER TABLE `zt_bug` ADD `activatedCount` SMALLINT( 6 ) NOT NULL AFTER `status` ;
ALTER TABLE `zt_bug` CHANGE `status` `status` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ;
ALTER TABLE `zt_bug` ADD `confirm` BOOL NOT NULL DEFAULT '0' AFTER `activatedCount` ;
ALTER TABLE `zt_bug` ADD `confirmedBy` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `closedDate` , ADD `confirmedDate` DATETIME NOT NULL AFTER `confirmedBy` ;
