/*01/02/2023**/
ALTER TABLE `userpermissionmaster` ADD `changeIP` TINYINT(2) NOT NULL DEFAULT '0' AFTER `Kayako`, ADD `ManageUsers` TINYINT(2) NOT NULL DEFAULT '0' AFTER `changeIP`;
ALTER TABLE `ip_access` ADD `addedBy` VARCHAR(100) NULL AFTER `ip_address`;

/**02/02/2023*/
ALTER TABLE `userpermissionmaster` ADD `LoginHistory` TINYINT(2) NOT NULL DEFAULT '0' AFTER `ManageUsers`, ADD `UserPermission` TINYINT(2) NOT NULL DEFAULT '0' AFTER `LoginHistory`;
UPDATE `userpermissionmaster` SET `UserPermission` = '1' WHERE `userpermissionmaster`.`tbl_id` = 2;
ALTER TABLE `userpermissionmaster` ADD `modifiedAt` DATETIME NULL AFTER `ReactReq`;
ALTER TABLE `userpermissionmaster` ADD `modifiedBy` VARCHAR(100) NULL AFTER `modifiedAt`;
CREATE TABLE `userinfologin`.`login_history` (`id` INT(11) NULL AUTO_INCREMENT , `User_Name` VARCHAR(255) NULL , `activity` VARCHAR(255) NULL , `InDate` DATETIME NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
