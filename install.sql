CREATE TABLE `logbook`.`logbook` (
  `id` INT NOT NULL,
  `text` VARCHAR(255) NOT NULL,
  `create_time` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`));
ALTER TABLE `logbook`.`logbook` 
CHANGE COLUMN `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ;
