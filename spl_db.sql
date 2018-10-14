-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2018 at 07:10 PM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spl_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`department_id`, `department_name`, `created_at`, `updated_at`) VALUES
(5, 'Computer Science', NULL, NULL),
(6, 'Chemistry', NULL, NULL),
(7, 'Economics', NULL, NULL),
(8, 'Development Studies', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `location_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `school_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`location_id`, `user_id`, `school_id`, `department_id`, `created_at`, `updated_at`) VALUES
(13, 48, 1, 5, '2018-09-13 11:36:40', '2018-09-17 11:23:09'),
(20, 54, 2, 7, '2018-09-14 07:35:13', '2018-09-17 10:48:37'),
(21, 55, 1, 5, '2018-09-14 13:17:20', '2018-09-17 15:17:51'),
(22, 56, 1, 5, '2018-09-17 10:05:14', '2018-09-17 10:05:14'),
(23, 57, 1, 5, '2018-09-17 15:19:47', '2018-09-17 15:19:47'),
(24, 58, 1, 6, '2018-09-18 15:49:31', '2018-09-18 15:49:31'),
(25, 59, 1, 5, '2018-09-19 11:01:04', '2018-09-19 11:01:04');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `project_description` text,
  `project_cat_id` int(11) DEFAULT NULL,
  `project_type_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`project_id`, `project_name`, `project_description`, `project_cat_id`, `project_type_id`, `created_at`, `updated_at`) VALUES
(3, 'Student Project Logbook', 'Web based system that will help students and supervisors keep track of student project activities efficiently \r\n', 3, 1, NULL, '2018-09-29 23:00:11'),
(4, 'OCSAMS Web Iwe', 'Web based application that helps students easily locate boarding houses', 3, 1, NULL, '2018-09-20 14:57:51');

-- --------------------------------------------------------

--
-- Table structure for table `project_categories`
--

CREATE TABLE `project_categories` (
  `project_cat_id` int(11) NOT NULL,
  `project_category` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_categories`
--

INSERT INTO `project_categories` (`project_cat_id`, `project_category`, `created_at`, `updated_at`) VALUES
(3, 'Web Application', NULL, NULL),
(4, 'Mobile Application', NULL, NULL),
(5, 'Electronics', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_objectives`
--

CREATE TABLE `project_objectives` (
  `po_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `project_objective` text,
  `is_completed` tinyint(1) DEFAULT NULL,
  `sent_for_approval` tinyint(1) DEFAULT NULL,
  `supervisor_comments` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_objectives`
--

INSERT INTO `project_objectives` (`po_id`, `student_id`, `project_objective`, `is_completed`, `sent_for_approval`, `supervisor_comments`, `created_at`, `updated_at`) VALUES
(5, 9, 'Develop requirements and specifications', 0, 1, NULL, NULL, '2018-09-25 08:20:13'),
(9, 9, 'Deploy System', 0, 1, NULL, NULL, '2018-09-26 07:45:15'),
(10, 9, 'Test the System', 0, 1, NULL, NULL, '2018-10-14 12:02:10'),
(11, 9, 'Complete Methodology', 0, 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `project_types`
--

CREATE TABLE `project_types` (
  `project_type_id` int(11) NOT NULL,
  `project_type` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project_types`
--

INSERT INTO `project_types` (`project_type_id`, `project_type`, `created_at`, `updated_at`) VALUES
(1, 'Taught', '2018-09-15 20:18:06', '0000-00-00 00:00:00'),
(2, 'Research', '2018-09-15 20:18:23', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `scheduled_meetings`
--

CREATE TABLE `scheduled_meetings` (
  `scheduled_meeting_id` int(11) NOT NULL,
  `supervision_id` int(11) DEFAULT NULL,
  `scheduled_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scheduled_meetings`
--

INSERT INTO `scheduled_meetings` (`scheduled_meeting_id`, `supervision_id`, `scheduled_date`, `created_at`, `updated_at`) VALUES
(14, 64, '2018-10-17 00:00:00', NULL, NULL),
(15, 64, '2018-10-12 00:00:00', NULL, NULL),
(16, 64, '2018-10-22 00:00:00', NULL, NULL),
(18, 64, '2018-10-07 00:00:00', NULL, NULL),
(19, 64, '2018-10-09 00:00:00', NULL, NULL),
(20, 64, '2018-10-08 00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `school_id` int(11) NOT NULL,
  `school_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`school_id`, `school_name`, `created_at`, `updated_at`) VALUES
(1, 'Natural Sciences', NULL, NULL),
(2, 'Humanities', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `student_cat_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL,
  `project_start_date` datetime DEFAULT NULL,
  `project_end_date` datetime DEFAULT NULL,
  `project_aims` text,
  `final_project_report_file` mediumblob,
  `final_project_report_file_name` varchar(255) DEFAULT NULL,
  `is_final_project_report_approved` tinyint(1) DEFAULT NULL,
  `supervisor_comments` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `user_id`, `student_cat_id`, `project_id`, `project_start_date`, `project_end_date`, `project_aims`, `final_project_report_file`, `final_project_report_file_name`, `is_final_project_report_approved`, `supervisor_comments`, `created_at`, `updated_at`) VALUES
(6, 54, NULL, 4, '2018-09-20 00:00:00', '2018-10-26 00:00:00', 'Develop web system to achieve this\r\n', NULL, NULL, NULL, NULL, '2018-10-08 19:23:21', '2018-09-20 14:57:51'),
(7, 56, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-09-17 10:05:14', '2018-09-17 10:05:14'),
(8, 58, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2018-09-18 15:49:31', '2018-09-18 15:49:31'),
(9, 59, NULL, 3, '2018-09-20 00:00:00', '2018-12-15 00:00:00', 'Develop a web based student project log\r\n', 0x43534320343633302041535349474e4d454e5420342e706466, 'CSC 4630 ASSIGNMENT 4.pdf', NULL, NULL, '2018-10-14 12:21:32', '2018-10-14 12:21:32');

-- --------------------------------------------------------

--
-- Table structure for table `student_categories`
--

CREATE TABLE `student_categories` (
  `student_cat_id` int(11) NOT NULL,
  `student_type` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supervisions`
--

CREATE TABLE `supervisions` (
  `supervision_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supervisions`
--

INSERT INTO `supervisions` (`supervision_id`, `student_id`, `supervisor_id`, `created_at`, `updated_at`) VALUES
(20, 7, 2, NULL, NULL),
(23, 6, 2, NULL, NULL),
(64, 9, 1, NULL, NULL),
(65, 8, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supervisors`
--

CREATE TABLE `supervisors` (
  `supervisor_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supervisors`
--

INSERT INTO `supervisors` (`supervisor_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 55, '2018-09-14 13:17:20', '2018-09-14 13:17:20'),
(2, 57, '2018-09-17 15:19:47', '2018-09-17 15:19:47');

-- --------------------------------------------------------

--
-- Table structure for table `supervisory_meetings`
--

CREATE TABLE `supervisory_meetings` (
  `supervisory_meeting_id` int(11) NOT NULL,
  `scheduled_meeting_id` int(11) DEFAULT NULL,
  `duration` time DEFAULT NULL,
  `student_progress_comments` text,
  `is_completed` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supervisory_meetings`
--

INSERT INTO `supervisory_meetings` (`supervisory_meeting_id`, `scheduled_meeting_id`, `duration`, `student_progress_comments`, `is_completed`, `created_at`, `updated_at`) VALUES
(7, 18, '02:00:00', NULL, NULL, NULL, NULL),
(8, 20, '00:45:00', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `supervisor_interests`
--

CREATE TABLE `supervisor_interests` (
  `interest_id` int(11) NOT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `project_cat_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supervisor_interests`
--

INSERT INTO `supervisor_interests` (`interest_id`, `supervisor_id`, `project_cat_id`, `created_at`, `updated_at`) VALUES
(4, 1, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `supervisory_meeting_id` int(11) DEFAULT NULL,
  `task_description` text,
  `sent_for_approval` tinyint(1) DEFAULT NULL,
  `sent_for_completion` tinyint(1) DEFAULT NULL,
  `is_approved` tinyint(1) DEFAULT NULL,
  `is_completed` tinyint(1) DEFAULT NULL,
  `file_attachments` mediumblob,
  `file_name` varchar(255) DEFAULT NULL,
  `student_comments` text,
  `supervisor_approval_comments` text,
  `supervisor_completion_comments` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_id`, `supervisory_meeting_id`, `task_description`, `sent_for_approval`, `sent_for_completion`, `is_approved`, `is_completed`, `file_attachments`, `file_name`, `student_comments`, `supervisor_approval_comments`, `supervisor_completion_comments`, `created_at`, `updated_at`) VALUES
(1, 7, 'Develop Databases', 1, 1, NULL, NULL, 0x43534320343633302041535349474e4d454e5420342e706466, 'CSC 4630 ASSIGNMENT 4.pdf', 'Completed my methodology ', 'You forgot to add developing the interface for the supervisor module', NULL, '2018-10-14 09:59:06', '2018-10-14 09:59:06'),
(2, 8, 'Complete supervisor module', 1, 1, 0, 0, 0x50524f4752414d20434f4d50524548454e53494f4e2e70707478, 'PROGRAM COMPREHENSION.pptx', 'Program Comprehension\r\n', NULL, NULL, '2018-10-14 10:06:06', '2018-10-14 10:06:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `other_names` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` mediumblob,
  `active` tinyint(1) NOT NULL,
  `active_hash` varchar(255) DEFAULT NULL,
  `recover_hash` varchar(255) DEFAULT NULL,
  `remember_identifier` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `first_name`, `last_name`, `other_names`, `email`, `password`, `photo`, `active`, `active_hash`, `recover_hash`, `remember_identifier`, `remember_token`, `created_at`, `updated_at`) VALUES
(34, '10', 'Mary', 'Moe', '', 'tonymulenga214.tc@gmail.com', '$2y$10$Is3Wf9g8VJVoS8biY.mgbeWvPh7Glq6ky/WtrTdpE6bzmrJh3nMRu', NULL, 1, NULL, NULL, NULL, NULL, '2018-09-30 22:23:31', '2018-09-30 22:23:31'),
(48, 'projectCoordinator', NULL, NULL, NULL, 'tonymchibesakunda@gmail.com', '$2y$10$pZQTfYVdjwxHBM/ZHecLOOttDYAi9p0a6G9HYU8Q5XJ24XfWg0y3u', NULL, 1, NULL, NULL, NULL, NULL, '2018-10-07 07:46:41', '2018-10-07 07:46:41'),
(54, '15', 'Musonda', 'Lombe', 'Denning', 'denninglombe1@gmail.com', '$2y$10$a1zlBFeBOesk5PnUazo0Te.x3zbsZ6K4QKiyoGM948JF/6RfIPN7S', NULL, 1, NULL, NULL, NULL, NULL, '2018-10-08 13:28:10', '2018-10-08 13:28:10'),
(55, '16', 'Mofya', 'Phiri', '', 'tonyyung21@gmail.com', '$2y$10$EH7wB/2NcII0v1LQaUvlfur7UdSFRbfBqJkeNVe1gnb0gTyYWEfzW', NULL, 1, NULL, NULL, 'RkJ1XGbTCDqrVyw94T9W1sjRgHgb47Mx/PVwxnhw39qpxLK5eW86Vs+TKIcrtt43rYJWTB0lbMQRrf3A3HcriZ1YM7E5FRzSq4G47UIpW8LFYJG30eWHUkTzX2Eo9Dyi', '535079595d5643565e46c54c06402d410be419acb5d818656a2cf9cfe9493de8', '2018-10-14 12:31:13', '2018-10-14 12:31:13'),
(56, '14029049', 'Reuben', 'Shumba', '', 'shumbareuben@gmail.com', '$2y$10$CvZR4FouMXukLDBpkYaDOOSAyqxdFM2iB2/L6f5lAyc2My93Djkj2', NULL, 1, NULL, NULL, NULL, NULL, '2018-09-17 15:30:51', '2018-09-17 15:30:51'),
(57, 'hg', 'Tony', 'Chibesakunda', '', 's@dfd.hj', '$2y$10$Gks..511.HpshEBVJuFHKuVXqucU7eZsJTx5HYRSNwKG2NMqetiXS', NULL, 0, 'c3caecb6898d27bc7e5bb83d178639a44d9cc40ddaf6810bf89f9ff82ae31ec5', NULL, NULL, NULL, '2018-09-17 15:19:47', '2018-09-17 15:19:47'),
(58, '17', 'Chipo', 'Mwandila', '', 'cs@xs.zx', '$2y$10$3WL/2DnCjhUra0c4v8.Leekd5hMt0ZU/nlVXXLMKZiWLTJp/iKQa.', NULL, 1, NULL, NULL, NULL, NULL, '2018-10-03 09:55:51', '2018-10-03 09:55:51'),
(59, '1234', 'Tony', 'Mulenga', '', 't.chibesakunda@yahoo.com', '$2y$10$ZtegbDBCvj.McSENuplpWeN95nf9Rmxi3yJDXQRb8NtyeI93Favwm', NULL, 1, NULL, NULL, 'hDNO0/W3ZFDNs7W+XlIR3n+AXs22ebIqye7gE/Lk200J+ozws3h94PaAK23TEBG2EwrHWhJage9OSD1gGvyc6Dh3Cf/Fbe/qok2oFLLx4DipbFjrX7i4KInQQkswkMKO', '25d3090ab2548dc5b9a8d5ae93542fa3a8abf54755d669f800f28cf7ac375ff0', '2018-10-12 08:32:23', '2018-10-12 08:32:23');

-- --------------------------------------------------------

--
-- Table structure for table `users_permissions`
--

CREATE TABLE `users_permissions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_hod` tinyint(1) NOT NULL,
  `is_coordinator` tinyint(1) NOT NULL,
  `is_supervisor` tinyint(1) NOT NULL,
  `is_student` tinyint(1) NOT NULL,
  `is_assigned` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_permissions`
--

INSERT INTO `users_permissions` (`id`, `user_id`, `is_hod`, `is_coordinator`, `is_supervisor`, `is_student`, `is_assigned`, `created_at`, `updated_at`) VALUES
(7, 34, 1, 0, 0, 0, 0, '2018-08-04 18:10:43', '2018-08-04 18:10:43'),
(21, 47, 0, 0, 0, 1, 0, '2018-09-12 19:52:57', '2018-09-12 19:52:57'),
(22, 48, 0, 1, 0, 0, 0, '2018-09-13 11:36:40', '2018-09-13 11:36:40'),
(28, 54, 0, 0, 0, 1, 1, '2018-09-14 07:35:13', '2018-09-19 09:26:58'),
(29, 55, 0, 0, 1, 0, 1, '2018-09-14 13:17:20', '2018-10-07 07:42:31'),
(30, 56, 0, 0, 0, 1, 1, '2018-09-17 10:05:14', '2018-09-19 09:22:47'),
(31, 57, 0, 0, 1, 0, 1, '2018-09-17 15:19:47', '2018-09-19 09:22:47'),
(32, 58, 0, 0, 0, 1, 1, '2018-09-18 15:49:31', '2018-10-05 12:24:19'),
(33, 59, 0, 0, 0, 1, 1, '2018-09-19 11:01:04', '2018-10-07 07:42:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`location_id`),
  ADD KEY `school_id` (`school_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `locations_ibfk_2` (`user_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`project_id`),
  ADD KEY `project_cat_id` (`project_cat_id`),
  ADD KEY `project_type_id` (`project_type_id`);

--
-- Indexes for table `project_categories`
--
ALTER TABLE `project_categories`
  ADD PRIMARY KEY (`project_cat_id`);

--
-- Indexes for table `project_objectives`
--
ALTER TABLE `project_objectives`
  ADD PRIMARY KEY (`po_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `project_types`
--
ALTER TABLE `project_types`
  ADD PRIMARY KEY (`project_type_id`);

--
-- Indexes for table `scheduled_meetings`
--
ALTER TABLE `scheduled_meetings`
  ADD PRIMARY KEY (`scheduled_meeting_id`),
  ADD KEY `scheduled_meetings_ibfk_1` (`supervision_id`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`school_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `student_cat_id` (`student_cat_id`),
  ADD KEY `students_ibfk_1` (`user_id`);

--
-- Indexes for table `student_categories`
--
ALTER TABLE `student_categories`
  ADD PRIMARY KEY (`student_cat_id`);

--
-- Indexes for table `supervisions`
--
ALTER TABLE `supervisions`
  ADD PRIMARY KEY (`supervision_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `supervisor_id` (`supervisor_id`);

--
-- Indexes for table `supervisors`
--
ALTER TABLE `supervisors`
  ADD PRIMARY KEY (`supervisor_id`),
  ADD KEY `supervisors_ibfk_1` (`user_id`);

--
-- Indexes for table `supervisory_meetings`
--
ALTER TABLE `supervisory_meetings`
  ADD PRIMARY KEY (`supervisory_meeting_id`),
  ADD KEY `supervisory_meetings_ibfk_1` (`scheduled_meeting_id`);

--
-- Indexes for table `supervisor_interests`
--
ALTER TABLE `supervisor_interests`
  ADD PRIMARY KEY (`interest_id`),
  ADD KEY `supervisor_id` (`supervisor_id`),
  ADD KEY `project_cat_id` (`project_cat_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `supervisory_meeting_id` (`supervisory_meeting_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_permissions`
--
ALTER TABLE `users_permissions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `project_categories`
--
ALTER TABLE `project_categories`
  MODIFY `project_cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `project_objectives`
--
ALTER TABLE `project_objectives`
  MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `project_types`
--
ALTER TABLE `project_types`
  MODIFY `project_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `scheduled_meetings`
--
ALTER TABLE `scheduled_meetings`
  MODIFY `scheduled_meeting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `school_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `student_categories`
--
ALTER TABLE `student_categories`
  MODIFY `student_cat_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supervisions`
--
ALTER TABLE `supervisions`
  MODIFY `supervision_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `supervisors`
--
ALTER TABLE `supervisors`
  MODIFY `supervisor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `supervisory_meetings`
--
ALTER TABLE `supervisory_meetings`
  MODIFY `supervisory_meeting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `supervisor_interests`
--
ALTER TABLE `supervisor_interests`
  MODIFY `interest_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;
--
-- AUTO_INCREMENT for table `users_permissions`
--
ALTER TABLE `users_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`school_id`),
  ADD CONSTRAINT `locations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `locations_ibfk_3` FOREIGN KEY (`department_id`) REFERENCES `departments` (`department_id`);

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`project_cat_id`) REFERENCES `project_categories` (`project_cat_id`),
  ADD CONSTRAINT `projects_ibfk_2` FOREIGN KEY (`project_type_id`) REFERENCES `project_types` (`project_type_id`);

--
-- Constraints for table `project_objectives`
--
ALTER TABLE `project_objectives`
  ADD CONSTRAINT `project_objectives_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`);

--
-- Constraints for table `scheduled_meetings`
--
ALTER TABLE `scheduled_meetings`
  ADD CONSTRAINT `scheduled_meetings_ibfk_1` FOREIGN KEY (`supervision_id`) REFERENCES `supervisions` (`supervision_id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`project_id`),
  ADD CONSTRAINT `students_ibfk_3` FOREIGN KEY (`student_cat_id`) REFERENCES `student_categories` (`student_cat_id`);

--
-- Constraints for table `supervisions`
--
ALTER TABLE `supervisions`
  ADD CONSTRAINT `supervisions_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`),
  ADD CONSTRAINT `supervisions_ibfk_2` FOREIGN KEY (`supervisor_id`) REFERENCES `supervisors` (`supervisor_id`);

--
-- Constraints for table `supervisors`
--
ALTER TABLE `supervisors`
  ADD CONSTRAINT `supervisors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `supervisory_meetings`
--
ALTER TABLE `supervisory_meetings`
  ADD CONSTRAINT `supervisory_meetings_ibfk_1` FOREIGN KEY (`scheduled_meeting_id`) REFERENCES `scheduled_meetings` (`scheduled_meeting_id`) ON DELETE CASCADE;

--
-- Constraints for table `supervisor_interests`
--
ALTER TABLE `supervisor_interests`
  ADD CONSTRAINT `supervisor_interests_ibfk_1` FOREIGN KEY (`supervisor_id`) REFERENCES `supervisors` (`supervisor_id`),
  ADD CONSTRAINT `supervisor_interests_ibfk_2` FOREIGN KEY (`project_cat_id`) REFERENCES `project_categories` (`project_cat_id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`supervisory_meeting_id`) REFERENCES `supervisory_meetings` (`supervisory_meeting_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
