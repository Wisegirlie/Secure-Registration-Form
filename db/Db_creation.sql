-- 1. Account Types 
CREATE TABLE `account_types` (
  `account_type_id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `account_description` varchar(15) NOT NULL,
  KEY `account_type_id_idx` (`account_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Users 
CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `account_type` tinyint(3) UNSIGNED NOT NULL,
  `username` varchar(60) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `username_unique` (`username`),
  UNIQUE KEY `email_unique` (`email`),
  KEY `account_type_idx` (`account_type`),
  CONSTRAINT `fk_user_account_type` 
    FOREIGN KEY (`account_type`) REFERENCES `account_types` (`account_type_id`) 
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. User Titles + Company
-- If necessary, the "company name" field can be separated into a new table for normalizing and create a new foreign key. 

CREATE TABLE `user_titles` (
  `user_id` int(10) UNSIGNED NOT NULL PRIMARY KEY,
  `title` varchar(60) NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  CONSTRAINT `fk_user_title_user` 
    FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) 
    ON DELETE CASCADE
    ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample data for account_types
INSERT INTO `account_types` (`account_description`) VALUES ('Individual');
INSERT INTO `account_types` (`account_description`) VALUES ('Company');