CREATE DATABASE `ask-nicely`;
USE `ask-nicely`
CREATE TABLE `employees` (
	`id` INT(10) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(250) NOT NULL COLLATE 'utf8mb4_general_ci',
	`company` VARCHAR(250) NOT NULL COLLATE 'utf8mb4_general_ci',
	`email` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_general_ci',
	`salary` DOUBLE NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`) USING BTREE
)
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB;
