# 10-30-2017
ALTER TABLE `go_menu_items` 
ADD INDEX `menu_items__MenuItemURL` (`MenuItemURL` ASC);

ALTER TABLE `go_users` 
ADD INDEX `users__username` (`Username` ASC);