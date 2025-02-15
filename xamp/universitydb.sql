-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2024 at 08:12 AM
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
-- Database: `universitydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`username`, `password`) VALUES
('admin1', 'admin1_password'),
('admin2', 'admin2_password');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_no` varchar(20) NOT NULL,
  `department_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_no`, `department_name`) VALUES
('ISE', ' Information Science and Engineering'),
('AIML', 'Artificial Intelligence & Machine Learning'),
('CIVE', 'Civil and Environmental Engineering'),
('CSE', 'Computer Science And Engineering'),
('EEE', 'Electrical and Electronics Engineering'),
('ECE', 'Electronics and Communication Engineering'),
('ME', 'Mechanical Engineering');

-- --------------------------------------------------------

--
-- Table structure for table `department_login`
--

CREATE TABLE `department_login` (
  `department_no` varchar(20) NOT NULL,
  `department_name` varchar(100) NOT NULL,
  `department_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department_login`
--

INSERT INTO `department_login` (`department_no`, `department_name`, `department_password`) VALUES
('AIML', 'Artificial Intelligence & Machine Learning', 'AIML_123'),
('CIVE', 'Civil and Environmental Engineering', 'CIVE_123'),
('ISE', ' Information Science and Engineering', 'ISE_123');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `student_usn` varchar(20) NOT NULL,
  `student_name` varchar(100) NOT NULL,
  `student_phone` varchar(15) NOT NULL,
  `semester` varchar(20) NOT NULL,
  `department_no` varchar(20) DEFAULT NULL,
  `student_image` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_usn`, `student_name`, `student_phone`, `semester`, `department_no`, `student_image`) VALUES
('1VK21IS001', 'Abhishek G', '9110498586', 'Semester 6', 'ISE', 0x75706c6f6164732f31564b323149533030312e706e67),
('1VK21IS020', 'Lakshmi prasad v', '9113522849', 'Semester 8', 'ISE', 0x75706c6f6164732f31564b323149533032302e706e67),
('1VK21IS042', 'Rohan T Y', '8088826910', 'Semester 6', 'ISE', 0x75706c6f6164732f31564b323149533034322e706e67);

-- --------------------------------------------------------

--
-- Table structure for table `student_attendance`
--

CREATE TABLE `student_attendance` (
  `attendance_id` int(11) NOT NULL,
  `student_usn` varchar(20) DEFAULT NULL,
  `student_name` varchar(100) DEFAULT NULL,
  `attendance_date` date NOT NULL,
  `attendance_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_attendance`
--

INSERT INTO `student_attendance` (`attendance_id`, `student_usn`, `student_name`, `attendance_date`, `attendance_time`) VALUES
(160, '1VK21IS020', 'Lakshmi prasad v', '2024-07-19', '10:37:47');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `teacher_id` varchar(20) NOT NULL,
  `teacher_name` varchar(100) NOT NULL,
  `teacher_post` varchar(100) NOT NULL,
  `teacher_phone` varchar(15) NOT NULL,
  `department_no` varchar(20) DEFAULT NULL,
  `teacher_image` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacher_id`, `teacher_name`, `teacher_post`, `teacher_phone`, `department_no`, `teacher_image`) VALUES
('ISE_01', 'Anusha P B', 'Professor', '86603213052', 'ISE', 0x75706c6f6164732f4953455f30312e706e67),
('ISE_02', 'mahesh A V ', 'Assistant Professor', '8904644069', 'ISE', 0x75706c6f6164732f4953455f30322e706e67);

-- --------------------------------------------------------

--
-- Table structure for table `teacher_attendance`
--

CREATE TABLE `teacher_attendance` (
  `attendance_id` int(11) NOT NULL,
  `teacher_id` varchar(20) DEFAULT NULL,
  `teacher_name` varchar(100) DEFAULT NULL,
  `attendance_date` date NOT NULL,
  `attendance_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_attendance`
--

INSERT INTO `teacher_attendance` (`attendance_id`, `teacher_id`, `teacher_name`, `attendance_date`, `attendance_time`) VALUES
(75, 'ISE_02', 'mahesh A V ', '2024-07-19', '10:37:40');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_login`
--

CREATE TABLE `teacher_login` (
  `teacher_id` varchar(20) NOT NULL,
  `teacher_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_login`
--

INSERT INTO `teacher_login` (`teacher_id`, `teacher_password`) VALUES
('ISE_01', '123'),
('ISE_02', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_no`),
  ADD UNIQUE KEY `department_name` (`department_name`);

--
-- Indexes for table `department_login`
--
ALTER TABLE `department_login`
  ADD PRIMARY KEY (`department_no`),
  ADD KEY `department_name` (`department_name`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`student_usn`),
  ADD KEY `department_no` (`department_no`);

--
-- Indexes for table `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `student_usn` (`student_usn`),
  ADD KEY `attendance_date` (`attendance_date`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `department_no` (`department_no`);

--
-- Indexes for table `teacher_attendance`
--
ALTER TABLE `teacher_attendance`
  ADD PRIMARY KEY (`attendance_id`),
  ADD KEY `teacher_id` (`teacher_id`),
  ADD KEY `attendance_date` (`attendance_date`);

--
-- Indexes for table `teacher_login`
--
ALTER TABLE `teacher_login`
  ADD PRIMARY KEY (`teacher_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student_attendance`
--
ALTER TABLE `student_attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT for table `teacher_attendance`
--
ALTER TABLE `teacher_attendance`
  MODIFY `attendance_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `department_login`
--
ALTER TABLE `department_login`
  ADD CONSTRAINT `department_login_ibfk_1` FOREIGN KEY (`department_no`) REFERENCES `department` (`department_no`) ON DELETE CASCADE,
  ADD CONSTRAINT `department_login_ibfk_2` FOREIGN KEY (`department_name`) REFERENCES `department` (`department_name`) ON DELETE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`department_no`) REFERENCES `department` (`department_no`) ON DELETE CASCADE;

--
-- Constraints for table `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD CONSTRAINT `student_attendance_ibfk_1` FOREIGN KEY (`student_usn`) REFERENCES `student` (`student_usn`) ON DELETE CASCADE;

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`department_no`) REFERENCES `department` (`department_no`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_attendance`
--
ALTER TABLE `teacher_attendance`
  ADD CONSTRAINT `teacher_attendance_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`) ON DELETE CASCADE;

--
-- Constraints for table `teacher_login`
--
ALTER TABLE `teacher_login`
  ADD CONSTRAINT `teacher_login_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teacher` (`teacher_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
