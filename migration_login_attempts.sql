-- Migration: Create login_attempts table for brute-force protection
-- Run this SQL in phpMyAdmin on your production database

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `ip_address` VARCHAR(45) NOT NULL,
  `attempted_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `idx_ip_time` (`ip_address`, `attempted_at`),
  INDEX `idx_email_time` (`email`, `attempted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
