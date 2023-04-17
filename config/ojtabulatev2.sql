-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2023 at 04:15 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ojtabulatev2`
--

-- --------------------------------------------------------

--
-- Table structure for table `ojt_admin`
--

CREATE TABLE `ojt_admin` (
  `ojt_admin_id` int(255) NOT NULL,
  `ojt_admin_username` varchar(255) NOT NULL,
  `ojt_admin_password` varchar(255) NOT NULL,
  `ojt_admin_created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ojt_admin`
--

INSERT INTO `ojt_admin` (`ojt_admin_id`, `ojt_admin_username`, `ojt_admin_password`, `ojt_admin_created_date`) VALUES
(1, 'wexler_admin', 'Ice4sale!', '2023-03-09 01:04:49');

-- --------------------------------------------------------

--
-- Table structure for table `ojt_employee`
--

CREATE TABLE `ojt_employee` (
  `ojt_employee_id` int(255) NOT NULL,
  `ojt_employee_status` varchar(255) NOT NULL DEFAULT 'New Contact',
  `ojt_employee_name` varchar(255) NOT NULL,
  `ojt_employee_supervisor` varchar(255) NOT NULL,
  `ojt_employee_phone` varchar(255) NOT NULL,
  `ojt_employee_email` varchar(255) NOT NULL,
  `ojt_employee_address` varchar(255) NOT NULL,
  `ojt_employee_created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `ojt_teachers_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ojt_employee`
--

INSERT INTO `ojt_employee` (`ojt_employee_id`, `ojt_employee_status`, `ojt_employee_name`, `ojt_employee_supervisor`, `ojt_employee_phone`, `ojt_employee_email`, `ojt_employee_address`, `ojt_employee_created_date`, `ojt_teachers_id`) VALUES
(16, 'New Contact', 'Ren Employer', 'Juan Dela Cruz', '+17174605819', 'Hunterbur129@gmail.com', 'Philippines', '2023-04-01 15:00:04', 19),
(17, 'New Contact', 'School District 1', 'John Doe', '44324', 'tssst2@gmail.com', 'USA', '2023-04-08 12:24:40', 19),
(18, 'New Contact', 'Mike Wexler', 'Ren Chap', '5765656', 'test@yopmail.com', 'USA', '2023-04-08 12:57:23', 19),
(19, 'New Contact', 'TNC New', 'Company TCT', '221323132131', 'reniemedia@gmail.com', 'PH', '2023-04-16 11:34:32', 19),
(20, 'New Contact', 'TNC New 55', 'Company TCT55', '221323132131', 'reniewordpress@gmail.com', 'PH', '2023-04-16 11:40:40', 19),
(21, 'New Contact', 'TNC New 55', 'Company TCT55', '221323132131', 'reniewordpress@gmail.com', 'PH', '2023-04-16 11:41:36', 19),
(22, 'New Contact', 'TNC New 55', 'Company TCT55', '221323132131', 'reniewordpress@gmail.com', 'PH', '2023-04-16 11:42:36', 19),
(23, 'New Contact', '233', '323', 'rnamocot', 'michaelgwexler@gmail.com', '23q3', '2023-04-16 11:43:24', 19);

-- --------------------------------------------------------

--
-- Table structure for table `ojt_students`
--

CREATE TABLE `ojt_students` (
  `ojt_students_id` int(255) NOT NULL,
  `ojt_students_username` varchar(255) NOT NULL,
  `ojt_students_password` varchar(255) NOT NULL,
  `ojt_students_name` varchar(255) NOT NULL,
  `ojt_students_email` varchar(255) NOT NULL,
  `ojt_students_phone` varchar(255) NOT NULL,
  `ojt_teacher_id_fk` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ojt_teachers`
--

CREATE TABLE `ojt_teachers` (
  `ojt_teachers_id` int(11) NOT NULL,
  `ojt_full_name` varchar(255) NOT NULL,
  `ojt_teachers_username` varchar(255) NOT NULL,
  `ojt_teachers_password` varchar(255) NOT NULL,
  `ojt_teachers_email` varchar(255) NOT NULL,
  `ojt_teachers_phone` varchar(255) NOT NULL,
  `ojt_teachers_created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ojt_teachers`
--

INSERT INTO `ojt_teachers` (`ojt_teachers_id`, `ojt_full_name`, `ojt_teachers_username`, `ojt_teachers_password`, `ojt_teachers_email`, `ojt_teachers_phone`, `ojt_teachers_created_date`) VALUES
(17, 'Renie Namocot', 'admin12', '$2y$10$R83DcdZ/tD0lIetqXe5Dg./rtf6ZpuQGBzzYch3Pusi2EoI/H3aVC', 'admin@gmail.com', '43454', '2023-04-01 14:56:47'),
(18, 'ew', 'radmin', '$2y$10$Ld0bLkdkvFoyttu/lbyJ2uQULUzra7ba.TKM6M3K12wfM6Gg0FB6i', 'reniewordpress@gmail.com', '3434', '2023-04-08 12:23:38'),
(19, 'test', 'admin', '$2y$10$1/DPJIux8F5aK0kVVTOe0O6UACaPKbTXRqzZCIXJCqypOLA/ZjWm6', 'admin@gmaillcom', 'radmin', '2023-04-16 05:37:48'),
(20, 'Renie', 'adminren', '$2y$10$hHfSEly23CyFrIKIgwXoUePq.wEkigXlNcR30Yz1zvhyBByP4DfWC', 'renienamocot@yahoo.com', '221323132131', '2023-04-16 05:40:47');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ojt_admin`
--
ALTER TABLE `ojt_admin`
  ADD PRIMARY KEY (`ojt_admin_id`);

--
-- Indexes for table `ojt_employee`
--
ALTER TABLE `ojt_employee`
  ADD PRIMARY KEY (`ojt_employee_id`),
  ADD KEY `ojt_employee_fk_id` (`ojt_teachers_id`);

--
-- Indexes for table `ojt_students`
--
ALTER TABLE `ojt_students`
  ADD PRIMARY KEY (`ojt_students_id`),
  ADD KEY `ojt_teacher_id_fk` (`ojt_teacher_id_fk`);

--
-- Indexes for table `ojt_teachers`
--
ALTER TABLE `ojt_teachers`
  ADD PRIMARY KEY (`ojt_teachers_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ojt_admin`
--
ALTER TABLE `ojt_admin`
  MODIFY `ojt_admin_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ojt_employee`
--
ALTER TABLE `ojt_employee`
  MODIFY `ojt_employee_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ojt_students`
--
ALTER TABLE `ojt_students`
  MODIFY `ojt_students_id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ojt_teachers`
--
ALTER TABLE `ojt_teachers`
  MODIFY `ojt_teachers_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ojt_employee`
--
ALTER TABLE `ojt_employee`
  ADD CONSTRAINT `ojt_employee_ibfk_1` FOREIGN KEY (`ojt_teachers_id`) REFERENCES `ojt_teachers` (`ojt_teachers_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
