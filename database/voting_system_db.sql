-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2022 at 08:18 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voting_system_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account`
--

CREATE TABLE `tbl_account` (
  `account_id` int(11) NOT NULL,
  `person_id` int(11) DEFAULT NULL,
  `username` mediumtext,
  `password` mediumtext,
  `mpin` varchar(45) DEFAULT NULL,
  `account_status` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_account`
--

INSERT INTO `tbl_account` (`account_id`, `person_id`, `username`, `password`, `mpin`, `account_status`) VALUES
(1, 1, 'daine_silva@gmail.com', '$2y$10$MR6g.MlcxZ9NQzdgzinLguojQCgW0R5f3M5.3IjWhkYIVSXheWG6.', '0000', 'Activated');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_candidate_position`
--

CREATE TABLE `tbl_candidate_position` (
  `candidate_position_id` int(11) NOT NULL,
  `candidate_position_code` mediumtext,
  `candidate_position_name` mediumtext,
  `candidate_position_description` mediumtext,
  `candidate_position_created_at` varchar(255) DEFAULT NULL,
  `candidate_position_status` varchar(255) DEFAULT NULL,
  `candidate_position_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_college_program`
--

CREATE TABLE `tbl_college_program` (
  `college_program_id` int(11) NOT NULL,
  `college_program_code` mediumtext,
  `college_program_name` mediumtext,
  `college_program_description` mediumtext,
  `college_program_created_at` varchar(255) DEFAULT NULL,
  `college_program_status` varchar(255) DEFAULT NULL,
  `college_program_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_college_program`
--

INSERT INTO `tbl_college_program` (`college_program_id`, `college_program_code`, `college_program_name`, `college_program_description`, `college_program_created_at`, `college_program_status`, `college_program_added_by`) VALUES
(1, 'PROGRAM-000001', 'CBHTM', 'College of Business Hospitality abd Tourism Management', '2022-05-03 @ 01:59:38pm', 'Activated', 1),
(2, 'PROGRAM-000002', 'CEITE', 'College of Engineering and Information Technology Education', '2022-05-03 @ 01:59:38pm', 'Activated', 1),
(3, 'PROGRAM-000003', 'CEAS', 'College of Education, Arts and Science', '2022-05-03 @ 01:59:38pm', 'Activated', 1),
(4, 'PROGRAM-000004', 'COA', 'College of Accountancy', '2022-05-03 @ 01:59:39pm', 'Activated', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_filling_of_candidacy`
--

CREATE TABLE `tbl_filling_of_candidacy` (
  `filling_of_candidacy_id` int(11) NOT NULL,
  `filling_of_candidacy_code` mediumtext,
  `person_id` int(11) DEFAULT NULL,
  `candidate_position_id` int(11) DEFAULT NULL,
  `candidacy_platforms` mediumtext,
  `candidacy_created_at` varchar(255) DEFAULT NULL,
  `candidacy_status` varchar(255) DEFAULT NULL,
  `candidacy_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_logs`
--

CREATE TABLE `tbl_logs` (
  `logs_id` int(11) NOT NULL,
  `logs_code` mediumtext,
  `category` mediumtext,
  `id` int(11) DEFAULT NULL,
  `code` mediumtext,
  `status` mediumtext,
  `description` mediumtext,
  `created_at` varchar(255) DEFAULT NULL,
  `logs_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_logs`
--

INSERT INTO `tbl_logs` (`logs_id`, `logs_code`, `category`, `id`, `code`, `status`, `description`, `created_at`, `logs_added_by`) VALUES
(1, '032022050028021', 'ACCOUNT LOGIN', 1, 'CODE-000001', 'LOGIN', 'Date and Time of Login: 2022-05-03 @ 02:00:28 PM<br>IP ADDRESS: ::1<br>Sign in through Email', '2022-05-03 @ 02:00:28 PM', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_party_list`
--

CREATE TABLE `tbl_party_list` (
  `party_list_id` int(11) NOT NULL,
  `party_list_code` mediumtext,
  `college_program_id` int(11) DEFAULT NULL,
  `party_list_name` mediumtext,
  `party_list_description` mediumtext,
  `party_list_created_at` varchar(255) DEFAULT NULL,
  `party_list_status` varchar(255) DEFAULT NULL,
  `party_list_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_party_list_platform`
--

CREATE TABLE `tbl_party_list_platform` (
  `party_list_platform_id` int(11) NOT NULL,
  `party_list_platform_code` mediumtext,
  `party_list_id` int(11) DEFAULT NULL,
  `party_list_platform_title` mediumtext,
  `party_list_platform_content` mediumtext,
  `party_list_platform_created_at` varchar(255) DEFAULT NULL,
  `party_list_platform_status` varchar(255) DEFAULT NULL,
  `party_list_platform_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_person`
--

CREATE TABLE `tbl_person` (
  `person_id` int(11) NOT NULL,
  `person_code` mediumtext,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `affiliation_name` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `sex` varchar(45) DEFAULT NULL,
  `civil_status` varchar(45) DEFAULT NULL,
  `house_no` mediumtext,
  `street` mediumtext,
  `barangay` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `telephone_number` varchar(45) DEFAULT NULL,
  `person_created_at` varchar(255) DEFAULT NULL,
  `person_status` varchar(255) DEFAULT NULL,
  `user_type_id` int(11) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_person`
--

INSERT INTO `tbl_person` (`person_id`, `person_code`, `first_name`, `middle_name`, `last_name`, `affiliation_name`, `date_of_birth`, `sex`, `civil_status`, `house_no`, `street`, `barangay`, `city`, `province`, `region`, `email_address`, `contact_number`, `telephone_number`, `person_created_at`, `person_status`, `user_type_id`, `added_by`) VALUES
(1, 'CODE-000001', 'Daine', '', 'Silva', '', '0000-00-00', '', '', '', '', '', '', '', '', 'daine_silva@gmail.com', '', '', '2022-05-03 @ 01:59:38pm', 'Saved', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_person_candidate_party_list`
--

CREATE TABLE `tbl_person_candidate_party_list` (
  `person_candidate_party_list_id` int(11) NOT NULL,
  `person_candidate_party_list_code` mediumtext,
  `person_program_id` int(11) DEFAULT NULL,
  `candidate_position_id` int(11) DEFAULT NULL,
  `party_list_id` int(11) DEFAULT NULL,
  `person_candidate_party_list_remarks` varchar(45) DEFAULT NULL,
  `person_candidate_party_list_created_at` varchar(255) DEFAULT NULL,
  `person_candidate_party_list_status` varchar(255) DEFAULT NULL,
  `person_candidate_party_list_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_person_program`
--

CREATE TABLE `tbl_person_program` (
  `person_program_id` int(11) NOT NULL,
  `person_program_code` mediumtext,
  `person_id` int(11) DEFAULT NULL,
  `college_program_id` int(11) DEFAULT NULL,
  `person_program_remarks` mediumtext,
  `person_program_created_at` varchar(255) DEFAULT NULL,
  `person_program_status` varchar(255) DEFAULT NULL,
  `person_program_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_type`
--

CREATE TABLE `tbl_user_type` (
  `user_type_id` int(11) NOT NULL,
  `type_description` varchar(255) DEFAULT NULL,
  `type_status` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_type`
--

INSERT INTO `tbl_user_type` (`user_type_id`, `type_description`, `type_status`) VALUES
(1, 'Administrator', 'Activated'),
(2, 'Staff', 'Activated'),
(3, 'Student', 'Activated');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vote`
--

CREATE TABLE `tbl_vote` (
  `vote_id` int(11) NOT NULL,
  `vote_code` mediumtext,
  `voting_program_id` int(11) DEFAULT NULL,
  `person_candidate_party_list_id` int(11) DEFAULT NULL,
  `vote_created_at` varchar(255) DEFAULT NULL,
  `vote_status` varchar(255) DEFAULT NULL,
  `vote_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_voting_program`
--

CREATE TABLE `tbl_voting_program` (
  `voting_program_id` int(11) NOT NULL,
  `voting_program_code` mediumtext,
  `voting_program_name` mediumtext,
  `voting_program_description` mediumtext,
  `voting_program_starting_date` date DEFAULT NULL,
  `voting_program_starting_time` varchar(45) DEFAULT NULL,
  `voting_program_ending_date` date DEFAULT NULL,
  `voting_program_ending_time` varchar(45) DEFAULT NULL,
  `voting_status` varchar(255) DEFAULT NULL,
  `voting_program_created_at` varchar(255) DEFAULT NULL,
  `voting_program_status` varchar(255) DEFAULT NULL,
  `voting_program_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_voting_program_has_party_list`
--

CREATE TABLE `tbl_voting_program_has_party_list` (
  `voting_program_has_party_list_id` int(11) NOT NULL,
  `voting_program_has_party_list_code` mediumtext,
  `voting_program_id` int(11) DEFAULT NULL,
  `party_list_id` int(11) DEFAULT NULL,
  `voting_program_has_party_list_created_at` varchar(255) DEFAULT NULL,
  `voting_program_has_party_list_status` varchar(255) DEFAULT NULL,
  `voting_program_has_party_list_added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_account`
--
ALTER TABLE `tbl_account`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `tbl_candidate_position`
--
ALTER TABLE `tbl_candidate_position`
  ADD PRIMARY KEY (`candidate_position_id`);

--
-- Indexes for table `tbl_college_program`
--
ALTER TABLE `tbl_college_program`
  ADD PRIMARY KEY (`college_program_id`);

--
-- Indexes for table `tbl_filling_of_candidacy`
--
ALTER TABLE `tbl_filling_of_candidacy`
  ADD PRIMARY KEY (`filling_of_candidacy_id`);

--
-- Indexes for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  ADD PRIMARY KEY (`logs_id`);

--
-- Indexes for table `tbl_party_list`
--
ALTER TABLE `tbl_party_list`
  ADD PRIMARY KEY (`party_list_id`);

--
-- Indexes for table `tbl_party_list_platform`
--
ALTER TABLE `tbl_party_list_platform`
  ADD PRIMARY KEY (`party_list_platform_id`);

--
-- Indexes for table `tbl_person`
--
ALTER TABLE `tbl_person`
  ADD PRIMARY KEY (`person_id`);

--
-- Indexes for table `tbl_person_candidate_party_list`
--
ALTER TABLE `tbl_person_candidate_party_list`
  ADD PRIMARY KEY (`person_candidate_party_list_id`);

--
-- Indexes for table `tbl_person_program`
--
ALTER TABLE `tbl_person_program`
  ADD PRIMARY KEY (`person_program_id`);

--
-- Indexes for table `tbl_user_type`
--
ALTER TABLE `tbl_user_type`
  ADD PRIMARY KEY (`user_type_id`);

--
-- Indexes for table `tbl_vote`
--
ALTER TABLE `tbl_vote`
  ADD PRIMARY KEY (`vote_id`);

--
-- Indexes for table `tbl_voting_program`
--
ALTER TABLE `tbl_voting_program`
  ADD PRIMARY KEY (`voting_program_id`);

--
-- Indexes for table `tbl_voting_program_has_party_list`
--
ALTER TABLE `tbl_voting_program_has_party_list`
  ADD PRIMARY KEY (`voting_program_has_party_list_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
