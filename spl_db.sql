-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 06, 2018 at 02:00 PM
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
(1, 36, NULL, 5, '2018-08-09 10:23:38', '2018-08-09 10:23:38'),
(2, 37, 1, 6, '2018-08-09 10:27:48', '2018-08-09 10:27:48'),
(3, 38, 1, 5, '2018-08-09 10:33:12', '2018-08-09 10:33:12');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(255) DEFAULT NULL,
  `project_cat_id` int(11) DEFAULT NULL,
  `project_type_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `project_objectives`
--

CREATE TABLE `project_objectives` (
  `po_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `project_objective` text,
  `is_completed` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `student_cat_id` int(11) NOT NULL,
  `project_id` int(11) DEFAULT NULL,
  `project_start_date` datetime DEFAULT NULL,
  `project_end_date` datetime DEFAULT NULL,
  `project_aims` text,
  `final_project_report` mediumblob,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

-- --------------------------------------------------------

--
-- Table structure for table `supervisory_meetings`
--

CREATE TABLE `supervisory_meetings` (
  `supervisory_meeting_id` int(11) NOT NULL,
  `supervision_id` int(11) DEFAULT NULL,
  `date_of_meeting` date DEFAULT NULL,
  `duration` time DEFAULT NULL,
  `student_progress_comments` text,
  `is_completed` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supervisor_interests`
--

CREATE TABLE `supervisor_interests` (
  `interest_id` int(11) NOT NULL,
  `supervisor_id` int(11) DEFAULT NULL,
  `interest` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_id` int(11) NOT NULL,
  `supervisory_meeting_id` int(11) DEFAULT NULL,
  `task_description` text,
  `is_completed` tinyint(1) DEFAULT NULL,
  `file_attachements` mediumblob,
  `student_comments` text,
  `supervisor_comments` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(26, '14', 'Michelo', 'Mulenga', 'Jones', 'tonyyung21@gmail.com', '$2y$10$6T6BTOPit4q/fb6ms9UwWumJOmL3HEQVwyPVXu.k4VyD5EGuJYkCe', NULL, 1, NULL, NULL, NULL, NULL, '2018-08-08 09:06:12', '2018-08-08 09:06:12'),
(30, '13', 'Tony', 'Chibesakunda', 'Mulenga', 'tonymchibesakunda@gmail.com', '$2y$10$evgaqMPOs6.LQZsBCnmKTOJg0oOBjSWH855NpJWtMtxCApOuh8WBK', NULL, 1, NULL, NULL, NULL, NULL, '2018-09-06 09:55:04', '2018-09-06 09:55:04'),
(31, '15', 'John', 'Doe', '', 't.chibesakunda@yahoo.com', '$2y$10$a3Bz/xTGy3qUGzyVFCQJ9u3Na1q.h1QwvK/DuSbGZez/0JDmcX7vO', NULL, 1, NULL, 'de212cf6c92897444df90d1cf6c10c38cfea1ad7cb4805c6b3211974e13d77f2', NULL, NULL, '2018-09-04 06:57:56', '2018-09-04 06:57:56'),
(33, '11', 'Alfred', 'Mbewe', '', 'tc1a15@cs.unza.zm', '$2y$10$/MK/Y0BC8t2HVLP0wCYZP.Dyrdcy.yahVZdUq9k.jnaRJvOeKCb5W', NULL, 1, NULL, NULL, NULL, NULL, '2018-09-06 09:56:48', '2018-09-06 09:56:48'),
(34, '10', 'Mary', 'Moe', '', 'tonymulenga214.tc@gmail.com', '$2y$10$Is3Wf9g8VJVoS8biY.mgbeWvPh7Glq6ky/WtrTdpE6bzmrJh3nMRu', NULL, 1, NULL, NULL, 'bfEK3C04GH15vLzC2U16M1p4TT6S7ZSoHJq9p+aLL3ndvmvUqetjMCZH7OW6nGRZJ6+Rj6lpgbJ8IfTZF08IvpsbNTAqDfMelHdLq8OS9IPjzd7jEOF9vdfR+OGUi8Dp', 'fb4f52d5cff9e2209e05bcd02357992189476540f6da53ae93bf287dbb18cada', '2018-09-06 09:57:47', '2018-09-06 09:57:47'),
(36, '17', 'James', 'Smith', '', 'th@dc.xc', '$2y$10$sJNU3Eo/W9OHdozZlJmQP.zb6ZaEdWdQkrkGzk4tB7lS/ZaQ9un6.', NULL, 0, '386bae3d6ccbafa73b0face24de2b039c8b16fb5e44c1d0a3fe1d237cf76cbdf', NULL, NULL, NULL, '2018-08-09 10:23:38', '2018-08-09 10:23:38'),
(37, '18', 'Wayne', 'Rooney', '', 'sd@sd.xc', '$2y$10$AQ.beMU2H4ScVBsnbyQL.eamAejxRgWw4hkMhyyjHaaGTzb7sCOyS', NULL, 0, 'd85098747cde26edf2c7838cb0fe2d93e7ed0a588705192e08d4bc345ddfcdba', NULL, NULL, NULL, '2018-08-09 10:27:48', '2018-08-09 10:27:48'),
(38, '19', 'dsed', 'ew', '', 'as@dsf.sd', '$2y$10$vwtXnTFoINNRsE9oBDk2V.BRsLnWL2aHOezD5tYfHcAukYBwgjlZm', NULL, 0, 'f928a8345854efaca7b2f54a8f917311c47a1e4d31ba269a1ef0f65ccfb91cd9', NULL, NULL, NULL, '2018-08-09 10:33:12', '2018-08-09 10:33:12');

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_permissions`
--

INSERT INTO `users_permissions` (`id`, `user_id`, `is_hod`, `is_coordinator`, `is_supervisor`, `is_student`, `created_at`, `updated_at`) VALUES
(4, 30, 0, 0, 0, 1, '2018-08-03 16:42:23', '2018-08-03 16:42:23'),
(5, 31, 0, 1, 0, 0, '2018-08-03 16:48:26', '2018-08-03 16:48:26'),
(6, 33, 0, 0, 1, 0, '2018-08-04 18:05:07', '2018-08-04 18:05:07'),
(7, 34, 1, 0, 0, 0, '2018-08-04 18:10:43', '2018-08-04 18:10:43'),
(9, 36, 0, 0, 0, 1, '2018-08-09 10:23:38', '2018-08-09 10:23:38'),
(10, 37, 0, 0, 0, 1, '2018-08-09 10:27:48', '2018-08-09 10:27:48'),
(11, 38, 0, 0, 0, 1, '2018-08-09 10:33:12', '2018-08-09 10:33:12');

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
  ADD KEY `user_id` (`user_id`),
  ADD KEY `department_id` (`department_id`);

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
  ADD KEY `supervision_id` (`supervision_id`);

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
  ADD KEY `user_id` (`user_id`),
  ADD KEY `project_id` (`project_id`),
  ADD KEY `student_cat_id` (`student_cat_id`);

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
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `supervisory_meetings`
--
ALTER TABLE `supervisory_meetings`
  ADD PRIMARY KEY (`supervisory_meeting_id`),
  ADD KEY `supervision_id` (`supervision_id`);

--
-- Indexes for table `supervisor_interests`
--
ALTER TABLE `supervisor_interests`
  ADD PRIMARY KEY (`interest_id`),
  ADD KEY `supervisor_id` (`supervisor_id`);

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
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_categories`
--
ALTER TABLE `project_categories`
  MODIFY `project_cat_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_objectives`
--
ALTER TABLE `project_objectives`
  MODIFY `po_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `project_types`
--
ALTER TABLE `project_types`
  MODIFY `project_type_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `scheduled_meetings`
--
ALTER TABLE `scheduled_meetings`
  MODIFY `scheduled_meeting_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `school_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_categories`
--
ALTER TABLE `student_categories`
  MODIFY `student_cat_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supervisions`
--
ALTER TABLE `supervisions`
  MODIFY `supervision_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supervisors`
--
ALTER TABLE `supervisors`
  MODIFY `supervisor_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supervisory_meetings`
--
ALTER TABLE `supervisory_meetings`
  MODIFY `supervisory_meeting_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supervisor_interests`
--
ALTER TABLE `supervisor_interests`
  MODIFY `interest_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `users_permissions`
--
ALTER TABLE `users_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`school_id`) REFERENCES `schools` (`school_id`),
  ADD CONSTRAINT `locations_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
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
  ADD CONSTRAINT `scheduled_meetings_ibfk_1` FOREIGN KEY (`supervision_id`) REFERENCES `supervisions` (`supervision_id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
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
  ADD CONSTRAINT `supervisors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `supervisory_meetings`
--
ALTER TABLE `supervisory_meetings`
  ADD CONSTRAINT `supervisory_meetings_ibfk_1` FOREIGN KEY (`supervision_id`) REFERENCES `supervisions` (`supervision_id`);

--
-- Constraints for table `supervisor_interests`
--
ALTER TABLE `supervisor_interests`
  ADD CONSTRAINT `supervisor_interests_ibfk_1` FOREIGN KEY (`supervisor_id`) REFERENCES `supervisors` (`supervisor_id`);

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`supervisory_meeting_id`) REFERENCES `supervisory_meetings` (`supervisory_meeting_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
