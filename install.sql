CREATE TABLE `logbook` (
  `id` INT NOT NULL,
  `text` VARCHAR(255) NOT NULL,
  `create_time` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id`));
ALTER TABLE `logbook` 
CHANGE COLUMN `id` `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT ;
ALTER TABLE `logbook` add COLUMN user_id int unsigned not null;
ALTER TABLE `logbook` add COLUMN is_show tinyint unsigned not null;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(145) NOT NULL,
  `password` varchar(255) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
