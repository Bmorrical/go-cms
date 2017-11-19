# 10-30-2017

CREATE TABLE `go_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `go_menu_items` 
ADD INDEX `menu_items__MenuItemURL` (`MenuItemURL` ASC);

ALTER TABLE `go_users` 
ADD INDEX `users__username` (`Username` ASC);

ALTER TABLE `go_users` 
CHANGE COLUMN `Username` `Username` VARCHAR(255) CHARACTER SET 'utf8' NOT NULL ,
ADD UNIQUE INDEX `Username_UNIQUE` (`Username` ASC);

ALTER TABLE `go_users` 
ADD COLUMN `Email` VARCHAR(255) NULL AFTER `Status`;

ALTER TABLE `go_users` 
ADD COLUMN `UpdatedBy` DATETIME NULL AFTER `LastLogin`;
