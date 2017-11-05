# 10-30-2017
ALTER TABLE `go_menu_items` 
ADD INDEX `menu_items__MenuItemURL` (`MenuItemURL` ASC);

ALTER TABLE `go_users` 
ADD INDEX `users__username` (`Username` ASC);

ALTER TABLE `go-cms`.`go_users` 
CHANGE COLUMN `Username` `Username` VARCHAR(255) CHARACTER SET 'utf8' NOT NULL ,
ADD UNIQUE INDEX `Username_UNIQUE` (`Username` ASC);
