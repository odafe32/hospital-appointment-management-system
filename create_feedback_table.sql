-- Create feedback table for hospital appointment management system
-- Run this SQL query in phpMyAdmin or your MySQL client

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `appointment_id` varchar(255) DEFAULT NULL,
  `feedback_type` enum('FEEDBACK','COMPLAINT','SUGGESTION','BUG_REPORT','FEATURE_REQUEST') NOT NULL DEFAULT 'FEEDBACK',
  `category` enum('APPOINTMENT','WEBSITE','STAFF','FACILITY','TECHNICAL','OTHER') DEFAULT NULL,
  `priority` enum('LOW','MEDIUM','HIGH','URGENT') DEFAULT 'MEDIUM',
  `rating` int(1) DEFAULT NULL CHECK (`rating` >= 1 AND `rating` <= 5),
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `feedback_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0,
  `response` text DEFAULT NULL,
  `response_date` timestamp NULL DEFAULT NULL,
  `admin_response` text DEFAULT NULL,
  `admin_response_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`feedback_id`),
  KEY `student_id` (`student_id`),
  KEY `doctor_id` (`doctor_id`),
  KEY `appointment_id` (`appointment_id`),
  CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`) ON DELETE SET NULL,
  CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `doctor` (`doctor_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
