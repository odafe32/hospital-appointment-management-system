-- Add cancellation_reason column to appointment table
-- Run this SQL query in phpMyAdmin or your MySQL client

ALTER TABLE `appointment` 
ADD COLUMN `cancellation_reason` TEXT NULL AFTER `appointment_status`;
