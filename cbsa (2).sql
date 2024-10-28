-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2024 at 06:55 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cbsa`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `fullname`, `email`, `password`) VALUES
(1, 'Ibrahim Nurudeen Shehu', 'admin@gmail.com', '{+234admin}'),
(2, 'Sidi Samaila Agya', 'sidi@gmail.com', '{+234admin}');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `appointment_id` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `appointment_status` varchar(255) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `booking_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `appointment`
--

INSERT INTO `appointment` (`appointment_id`, `fullname`, `email`, `phone_number`, `appointment_date`, `appointment_time`, `appointment_status`, `student_id`, `booking_time`) VALUES
('APPT132e5e', 'Oklo Oklo ', 'oklo@gmail.ciom', '08062585624', '2024-06-05', '08:00:00', 'APPROVED', 13, '2024-05-14 14:16:14'),
('APPT13930a', 'Oklo Oklo ', 'oklo@gmail.ciom', '08062585624', '2024-05-31', '08:00:00', 'DECLINED', 13, '2024-05-15 09:08:35'),
('APPT143b55', 'Mustapha Michael ', 'mustapha@gmail.com', '345678767665656', '2024-05-16', '08:00:00', 'APPROVED', 14, '2024-05-15 11:32:11'),
('APPT14aeb0', 'Mustapha Michael ', 'mustapha@gmail.com', '08062585624', '2024-05-30', '08:00:00', 'DECLINED', 14, '2024-05-15 11:38:22'),
('APPT154329', 'Raff Raff ', 'raf@gmail.com', '08062585624', '2024-05-21', '13:00:00', 'DECLINED', 15, '2024-05-16 11:25:55'),
('APPT158ecf', 'Raff Raff ', 'raf@gmail.com', '123456789', '2024-05-23', '08:00:00', 'APPROVED', 15, '2024-05-16 11:27:10'),
('APPT162b13', 'Isreal Israel isreal@gmail.com', 'isreal@gmail.com', '08062585624', '2024-05-30', '11:00:00', 'DECLINED', 16, '2024-05-20 12:20:59'),
('APPT170558', 'Raf Raf ', 'raf23@gmail.com', '08062585624', '2024-05-15', '11:00:00', 'DECLINED', 17, '2024-05-21 09:44:37'),
('APPT18bc3e', 'Mathew Mathew ', 'mathew@gmail.com', '08062585624', '2024-06-11', '08:00:00', 'APPROVED', 18, '2024-06-10 07:01:16');

-- --------------------------------------------------------

--
-- Table structure for table `cbsa_info`
--

CREATE TABLE `cbsa_info` (
  `secret_no` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cbsa_info`
--

INSERT INTO `cbsa_info` (`secret_no`) VALUES
('[123456]');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `doctor_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `othername` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `blood_group` varchar(255) DEFAULT NULL,
  `genotype` varchar(255) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`doctor_id`, `firstname`, `lastname`, `othername`, `email`, `password`, `blood_group`, `genotype`, `specialization`, `time`) VALUES
(2, 'Samaila', 'Sidi', 'cmp', 'drsidi@gmail.com', '$2y$10$omKykav3c3xFnToPABYBTu/Q.T.ZvvH3sWTrw/YW/d.uz7l63Lpoy', NULL, NULL, NULL, '2024-05-13 12:35:05'),
(4, 'Sidi', 'Samaila', 'Agya', 'sam1@gmail.com', '$2y$10$Nxor18fS4kD5JJB/12lXFebJVz0XATuX4SQrvuc9LFPb8vrQUFD0i', NULL, NULL, NULL, '2024-06-08 13:03:11'),
(5, 'Mark', 'Mathew', 'Orogu', 'mk1@gmail.com', '$2y$10$x7Ia5mpEp7RZPxQRGHoeg.FnT7J8LuCviZBoZJFVzsful8mIzSXB.', NULL, NULL, NULL, '2024-06-08 13:04:56');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `othername` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `matric` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `blood_group` varchar(255) DEFAULT NULL,
  `genotype` varchar(255) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_id`, `firstname`, `lastname`, `othername`, `email`, `matric`, `password`, `blood_group`, `genotype`, `time`) VALUES
(1, 'Nuru', 'Ibrahim', 'Shehu', 'nur@gmail.com', '0219047000204', '$2y$10$/Qnl2hP1rIJOLFO6GhDWdOUsnysdNfaqFH1.52WpaJQ/WmGIIXXwC', 'B+', 'AA', '2023-12-04 12:03:46'),
(2, 'Benita', 'Joseph', 'Dogo', 'benitadogo@gmail.com', '0219047000204', '$2y$10$11u8.nqdkdPF2FEoYJctNOzbJvl1i8VGM2tcCnQ8LHF59TVhLISQW', 'A+', 'AA', '2023-12-06 18:48:53'),
(3, 'Mark', 'Mathew', '', 'mark@gmail.com', '0219047004101', '$2y$10$6.d91MqH8kAq/IGXEGCvNeM9RwC4Cg3uxPgncat55CGka.bu3jxYK', NULL, NULL, '2023-12-07 14:05:39'),
(4, 'dfg', 'guh', 'gh', 'nuru@gmail.com', '4556', '$2y$10$53evpt3aik..X91rPZk8MezgT5vQW5TYI8tfv0w8nqiPk3bQoitjm', NULL, NULL, '2023-12-08 10:15:27'),
(5, 'Nuru', 'Orog', '', 'maryabel@gmail.com', '0219047004101', '$2y$10$vGWDSgrRGWSE7CVdemsM9eUGrskUA8u5UUkZyMNUAKskxwTaGLtFe', NULL, NULL, '2023-12-08 10:17:07'),
(6, 'Course', 'Rep', '', 'rep@gmail.com', '1234567890', '$2y$10$dFN/y7uG/ODDzvRKtUSk/Om3/2WcFRmwNefk4ESkyZawERcJC6cpa', NULL, NULL, '2023-12-08 10:34:15'),
(7, 'NURU', 'IBRO', 'SHEHU', 'ibro@gmail.com', '1234567890', '$2y$10$ioiR9tQdk3RM/GcTY.uu6OQf9OB7xu8mKx.1C65CEy2CCLViAUrk6', NULL, NULL, '2023-12-08 11:25:31'),
(8, 'Moses', 'Ochepo', '', 'moses@gmail.com', '123456', '$2y$10$6eIR4GgkgKeRJ506VtOjjeMrWPCxx8zzZJ/0bBjTFDNP1zMilfp7q', NULL, NULL, '2023-12-08 11:30:36'),
(9, 'Jibrin', 'Abdullahi', 'Jibrin', 'jb@gmail.com', '0219047000177', '$2y$10$aGtLOG6yJZpVjDQRlo3xg.2ETNKbY.wBYK.W3lRNeiLKvZAQoLxzO', NULL, NULL, '2023-12-08 11:31:38'),
(10, 'Peace', 'Sidi', 'Agya', 'peacesidi@gmai.com', '0219047001234', '$2y$10$h.mmPuaJIwgpHU46PZTaz.mMgg2NvRS3UFNl4X4o537LfskWTafFq', NULL, NULL, '2023-12-08 17:46:20'),
(11, 'Samaila', 'Sidi', 'Agya', 'samaila1999@gmail.com', '02190470000847', '$2y$10$Aqa8QURYEzcVmcjgx7EMkOmQ5zA6gwvage2YxOfYNxAOGhMuuPURq', NULL, NULL, '2024-01-23 10:28:16'),
(12, 'Sam', 'sidi', 'Agya', 'sidisama111@gmail.com', '111', '$2y$10$wcBq3UoUN557gRC04iKvhOMZeiad6p9DAw.FTZIJJ9nio/EUODTmu', NULL, NULL, '2024-04-16 09:21:17'),
(13, 'Oklo', 'Oklo', '', 'oklo@gmail.ciom', '1244', '$2y$10$VVHQra62nzzhvxzm9KnoRuAbfl681r6e3HUzj.YIL32CKQNgEsVtO', NULL, NULL, '2024-05-14 12:41:12'),
(14, 'Mustapha', 'Michael', '', 'mustapha@gmail.com', '02190477777', '$2y$10$gr1jtwA4qaD5NbfZkTqZ7e1wG/4UJPWqKxY8PHQ0oAHQ0FK8IXvdy', NULL, NULL, '2024-05-15 11:22:16'),
(15, 'Raff', 'Raff', '', 'raf@gmail.com', '0020202323', '$2y$10$g2flSboGaZBX6d.SaaggeOheb3ze8ZrvtcombPOoryeW526jZu5Ny', NULL, NULL, '2024-05-16 11:24:45'),
(16, 'Isreal', 'Israel', 'isreal@gmail.com', 'isreal@gmail.com', '1111', '$2y$10$0mJBqGD7fM5NT4OLsP2qWexblt2UMNDDtU17uq74TlKX.oxsRrjlu', NULL, NULL, '2024-05-20 12:20:33'),
(17, 'Raf', 'Raf', '', 'raf23@gmail.com', '12233444', '$2y$10$ghhXzpj.mJZ2AKmwVh7jQuBzB/Tpz.snlREBn7iTmVXfTBaS5t/g.', NULL, NULL, '2024-05-21 09:41:56'),
(18, 'Mathew', 'Mathew', '', 'mathew@gmail.com', '1234567', '$2y$10$VtDiAwbhX2yoBXo47zS7nOUKKahQouXImSZybbv6TW3r7fBqwYdRa', NULL, NULL, '2024-06-10 07:00:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`doctor_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
