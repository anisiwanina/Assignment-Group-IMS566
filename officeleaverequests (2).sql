-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2025 at 07:52 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `officeleaverequests`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `full_name`, `email`, `password_hash`) VALUES
(1, 'nur farzana', 'bibi@gmail.com', '$2y$10$FoS8NVAI12YGrWcD0HJFQu4HKELGBAsMmdiQjkL80j.3h7rrYyfSC');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `employee_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `position` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `full_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`employee_id`, `user_id`, `position`, `department`, `supervisor_id`, `phone`, `address`, `full_name`) VALUES
(1, 1, 'Staff', 'Marketing Department', 1, '0175920035', 'johor bahru', 'Anis Iwanina Binti Zakaria'),
(2, 2, 'Staff', 'accounting', 1, '0174923359', 'seoul,korea', 'Nur Zawani Ainin Binti Zabidi'),
(3, 3, 'Staff', 'Marketing', 1, '908765430', 'alor setar, Kedah', 'Nur Lydia Binti Rahman'),
(4, 4, 'Staff', 'Design', 1, '0124758901', 'alor setar, Kedah', 'aliff najmi bin shafie'),
(5, 5, 'Staff', 'Design', 1, '0197430025', 'putrajaya', ' ahmad umar faliq bin radzi'),
(6, 6, 'Staff', 'human resource', 1, '0139126601', 'melaka', 'zayn malik a/l firaj');

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `request_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `purpose` text NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `request_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `approval_date` timestamp NULL DEFAULT NULL,
  `date_of_leave` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`request_id`, `employee_id`, `admin_id`, `purpose`, `start_time`, `end_time`, `status`, `request_date`, `approval_date`, `date_of_leave`) VALUES
(1, 1, NULL, 'my daughter need to go to the emergency as soon as possible.', '11:30:00', '14:30:00', 'approved', '2025-02-02 14:38:03', '2025-02-04 10:22:54', '2025-02-04'),
(2, 2, NULL, 'Sick Leave:\r\n\"I am requesting leave due to illness and need time to recover.\"', '09:00:00', '17:30:00', 'rejected', '2025-02-03 17:17:03', '2025-02-06 12:53:29', '2025-02-24'),
(3, 3, NULL, 'Medical Appointment:\r\n\"I have a scheduled medical appointment and need time off to attend it.\"', '11:30:00', '14:00:00', 'pending', '2025-02-03 17:31:32', NULL, '2025-02-10'),
(4, 4, NULL, 'Bereavement Leave:\r\n\"I need to take leave due to the unfortunate passing of a close family member.\"', '15:30:00', '18:00:00', 'pending', '2025-02-03 17:55:56', NULL, '2025-02-05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password_hash`) VALUES
(1, 'anis iwanina ', 'nina@gmail.com', '$2y$10$VinO3ScAtigpLOCkx974He6PC4JBcmny5bGSRJ3Rp3dk4tHfXELtC'),
(2, 'nur zawani ainin', 'wanijk99@gmail.com', '$2y$10$RUbnKpWBCq7qmxVIxzwz0OUYBqycVbtzyv.HkbZn8dvJNW22QAriS'),
(3, 'nur lydia', 'sjh@gmail.com', '$2y$10$0I8ArkSF3t6rZmYyFMVGdeuymkJt8Wxq3Ycn9FvMIsiBCUj7Vky2i'),
(4, 'aliff najmi', 'aliffnajmi@gmail.com', '$2y$10$i1QAHbyKZUu24OjgA/jLxOx3wWhgurl9f/5zXswuei26sIm4brIFe'),
(5, ' ahmad umar faliq ', 'auf@gmail.com', '$2y$10$xkYyXY/8uZMbmUQh70Z72eVCK7CFSnexzIUMJ0PNq6Zs8L35h9iEC'),
(6, 'zayn malik', 'zm97@gmail.com', '$2y$10$8x6pAdHMX/h2ofQu8pQTPOVnPWgDX3KzejsEvX0SW46x4FletpoXC'),
(10, 'mia zara', 'miazara@gmail.com', '$2y$10$jJz/AgWiOK6zWbpxc0f/Yu16OOqic.P4GivWqJ3SHAJ89yW9iUwEO');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`employee_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `supervisor_id` (`supervisor_id`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `employee_id` (`employee_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `employee_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`supervisor_id`) REFERENCES `admins` (`admin_id`) ON DELETE SET NULL;

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`employee_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leave_requests_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
