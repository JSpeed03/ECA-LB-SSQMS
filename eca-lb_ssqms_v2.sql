-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2024 at 09:26 AM
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
-- Database: `eca-lb_ssqms_v2`
--

-- --------------------------------------------------------

--
-- Table structure for table `authority`
--

CREATE TABLE `authority` (
  `authorityID` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `authority`
--

INSERT INTO `authority` (`authorityID`, `description`) VALUES
(1, 'Staff'),
(2, 'Department Head'),
(3, 'MIS Admin'),
(4, 'Executives'),
(5, 'Developer Admin');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `departmentID` int(11) NOT NULL,
  `Department_code` varchar(20) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`departmentID`, `Department_code`, `Description`, `status`) VALUES
(1, 'Acctg', 'Accounting Department', 1),
(2, 'Reg', 'Registrar Department', 1),
(3, 'VPAA', 'VPAA Office', 0),
(4, 'IS', 'IS Department', 1),
(5, 'Mar', 'Maritime Department', 1),
(7, 'CBA', 'College of Business Administration', 0),
(8, 'TM', 'Tourism Department', 0),
(9, 'N', 'Nursing department', 0),
(10, 'ECEd', 'Early Childhood Education Department', 0),
(11, 'TVTEd', 'Technical-Vocational Teacher Education Department', 0),
(13, 'MIS', 'MIS Departmen', 0),
(14, 'Pub', 'Publication Office', 0),
(20, 'NSTP', 'NSTP Department', 0);

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE `program` (
  `programID` int(11) NOT NULL,
  `Course` varchar(20) NOT NULL,
  `Program Description` varchar(255) NOT NULL,
  `transaction_ID` int(11) DEFAULT NULL,
  `department_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`programID`, `Course`, `Program Description`, `transaction_ID`, `department_ID`) VALUES
(1, 'BSIS', 'Bachelor Of Science in Information System', 17, 4),
(2, 'BSMT', 'Bachelor Of Science in Marine Transportation', 17, 5),
(3, 'BSMarE', 'Bachelor Of Science in Marine Engineering', 17, 5),
(5, 'BSTM', 'Bachelor of science in Tourism Management', 17, 8),
(6, 'BSMA', 'Bachelor of science in Management accounting', 17, 7),
(7, 'BSEntrep', 'Bachelor of science in Entrepreneur', 17, 7),
(8, 'BTVTED', 'Bachelor of Technical Vocational Teacher Education', 17, 11),
(9, 'BECED', 'Bachelor of Early childhood education', 17, 10),
(10, 'BSN', 'Bachelor of science in Nursing', 17, 9);

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `Queue identifier` int(11) NOT NULL,
  `Queue Number` varchar(15) NOT NULL,
  `User Type ID` int(11) NOT NULL,
  `Student ID` int(11) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Department_ID` int(11) NOT NULL,
  `Transaction ID` int(11) NOT NULL,
  `Transaction Step` int(11) DEFAULT NULL,
  `Window_ID` int(11) DEFAULT NULL,
  `Time Created` datetime NOT NULL DEFAULT current_timestamp(),
  `Time Called` datetime DEFAULT NULL,
  `Time Finnished` datetime DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `enrollment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queue`
--

INSERT INTO `queue` (`Queue identifier`, `Queue Number`, `User Type ID`, `Student ID`, `Name`, `Department_ID`, `Transaction ID`, `Transaction Step`, `Window_ID`, `Time Created`, `Time Called`, `Time Finnished`, `Status`, `enrollment`) VALUES
(462, '1', 1, 2022008403, NULL, 1, 1, 1, 2, '2024-06-15 15:24:21', '2024-06-15 15:24:32', '2024-06-15 15:24:37', 'Finish', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `queue_number_tracker`
--

CREATE TABLE `queue_number_tracker` (
  `departmentID` int(11) NOT NULL,
  `queue_date` date NOT NULL,
  `last_number` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queue_number_tracker`
--

INSERT INTO `queue_number_tracker` (`departmentID`, `queue_date`, `last_number`) VALUES
(1, '2024-06-15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `staff-window`
--

CREATE TABLE `staff-window` (
  `staffwindowID` int(11) NOT NULL,
  `Department id` int(11) NOT NULL,
  `Window_ID` int(11) NOT NULL,
  `Staff ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff-window`
--

INSERT INTO `staff-window` (`staffwindowID`, `Department id`, `Window_ID`, `Staff ID`) VALUES
(7, 1, 1, 16),
(8, 2, 5, 14),
(9, 4, 9, 15),
(14, 1, 2, 20);

-- --------------------------------------------------------

--
-- Table structure for table `staff_account`
--

CREATE TABLE `staff_account` (
  `accountID` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Authority_ID` int(11) NOT NULL,
  `Department_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_account`
--

INSERT INTO `staff_account` (`accountID`, `Username`, `Password`, `Authority_ID`, `Department_ID`) VALUES
(13, 'Jeren', '$2y$10$OjXAZzDdTGSnazaYgPueZ.M5wN6gwKXMDYJkVhSSocBarbpH3uAGq', 5, NULL),
(14, 'Registrar', '$2y$10$7AX5lMUosoPDLHAoIiJhauaZLMb.b5XAdMtdJpaUInfzO9pXPkSP6', 1, 2),
(15, 'BSIS', '$2y$10$hWP.faN8UFHyVf1oa9ewBeZdN0CWSSTiy/wtrbX84pmNFLlKTLbg.', 2, 4),
(16, 'Accounting', '$2y$10$TqLFBzf6SNWuStaQDIJEHeDBJVHmZTicfDjTxw6relU2bhnaYPpLi', 2, 1),
(17, 'Joshua', '$2y$10$7TfOUsXoiOdD8QjOMwf7q.D7SlTqHkSHyAw2.WbpgWsTlnoUfU6m2', 5, NULL),
(18, 'Admin', '$2y$10$lhHPNfSem6qLPkFfPVvLcewQE0rDYOKsygYwvhNfGllwqGR3leVRa', 3, NULL),
(19, 'Maritime', '$2y$10$1Alp4OqkFFC7SbztB31.g.CVqLR8vIfSmxc/VmIioosBXdWblAZ3e', 2, 5),
(20, 'Accounting2', '$2y$10$vK7SA3kq5AsJy11t3K5ILOTby6.N49Xiq0Xz5/XPgvPu.rWqNfH0q', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studID` int(20) NOT NULL,
  `Lastname` varchar(255) NOT NULL,
  `Firstname` varchar(255) NOT NULL,
  `Program ID` int(20) NOT NULL,
  `Year` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studID`, `Lastname`, `Firstname`, `Program ID`, `Year`) VALUES
(2022007368, 'DePaula', 'Joshua', 1, 2),
(2022007808, 'Palomares', 'John Michael', 1, 2),
(2022007888, 'Kabigting', 'Diana', 1, 2),
(2022008403, 'Pangan', 'Jeren Josh', 1, 2),
(2022008694, 'Victorio', 'Ysa', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `transactionID` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `DepartmentID` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`transactionID`, `code`, `Description`, `DepartmentID`) VALUES
(1, 'SOA', 'Statement Of Account', 1),
(2, 'TF', 'Tuition Fee Payment', 1),
(3, 'RS', 'Requirements Submission', 2),
(4, 'SAD C', 'SAD Checking', 4),
(8, 'CAP C', 'Capstone Checking', 4),
(17, 'Enrollment', 'Enrollment', 2),
(18, 'TOR', 'TOR Release', 2),
(19, 'Cons', 'Consultation', 5);

-- --------------------------------------------------------

--
-- Table structure for table `user type`
--

CREATE TABLE `user type` (
  `usetypeID` int(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `Description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user type`
--

INSERT INTO `user type` (`usetypeID`, `code`, `Description`) VALUES
(1, 'Old', 'Old Student with Student ID'),
(2, 'New', 'New Student for Admission'),
(3, 'Visitor', 'Visitor/s');

-- --------------------------------------------------------

--
-- Table structure for table `window`
--

CREATE TABLE `window` (
  `windowID` int(11) NOT NULL,
  `window` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `window`
--

INSERT INTO `window` (`windowID`, `window`) VALUES
(1, 'ACCTG'),
(2, 'ACCTG2'),
(3, 'ACCTG3'),
(4, 'ACCTG4'),
(5, 'REG'),
(6, 'REG2'),
(9, 'IS'),
(10, 'Mar'),
(11, 'Crim'),
(12, 'NSTP'),
(14, 'DEPCON');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authority`
--
ALTER TABLE `authority`
  ADD PRIMARY KEY (`authorityID`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`departmentID`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`programID`),
  ADD KEY `department_ID` (`department_ID`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`Queue identifier`),
  ADD KEY `Department` (`Department_ID`),
  ADD KEY `Student ID` (`Student ID`),
  ADD KEY `Transaction` (`Transaction ID`),
  ADD KEY `User Type` (`User Type ID`),
  ADD KEY `Staff Window` (`Window_ID`),
  ADD KEY `enrollment` (`enrollment`);

--
-- Indexes for table `queue_number_tracker`
--
ALTER TABLE `queue_number_tracker`
  ADD PRIMARY KEY (`departmentID`,`queue_date`);

--
-- Indexes for table `staff-window`
--
ALTER TABLE `staff-window`
  ADD PRIMARY KEY (`staffwindowID`),
  ADD KEY `Department id` (`Department id`),
  ADD KEY `Window ID` (`Window_ID`),
  ADD KEY `Staff ID` (`Staff ID`);

--
-- Indexes for table `staff_account`
--
ALTER TABLE `staff_account`
  ADD PRIMARY KEY (`accountID`),
  ADD KEY `Authority` (`Authority_ID`),
  ADD KEY `Department_ID` (`Department_ID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studID`),
  ADD KEY `Course ID` (`Program ID`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transactionID`),
  ADD KEY `Department ID` (`DepartmentID`);

--
-- Indexes for table `user type`
--
ALTER TABLE `user type`
  ADD PRIMARY KEY (`usetypeID`);

--
-- Indexes for table `window`
--
ALTER TABLE `window`
  ADD PRIMARY KEY (`windowID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authority`
--
ALTER TABLE `authority`
  MODIFY `authorityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `departmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `programID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `Queue identifier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=463;

--
-- AUTO_INCREMENT for table `staff-window`
--
ALTER TABLE `staff-window`
  MODIFY `staffwindowID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `staff_account`
--
ALTER TABLE `staff_account`
  MODIFY `accountID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `transactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user type`
--
ALTER TABLE `user type`
  MODIFY `usetypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `window`
--
ALTER TABLE `window`
  MODIFY `windowID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `program`
--
ALTER TABLE `program`
  ADD CONSTRAINT `program_ibfk_1` FOREIGN KEY (`department_ID`) REFERENCES `departments` (`departmentID`);

--
-- Constraints for table `queue`
--
ALTER TABLE `queue`
  ADD CONSTRAINT `Department` FOREIGN KEY (`Department_ID`) REFERENCES `departments` (`departmentID`),
  ADD CONSTRAINT `Student ID` FOREIGN KEY (`Student ID`) REFERENCES `student` (`studID`),
  ADD CONSTRAINT `Transaction` FOREIGN KEY (`Transaction ID`) REFERENCES `transaction` (`transactionID`),
  ADD CONSTRAINT `User Type` FOREIGN KEY (`User Type ID`) REFERENCES `user type` (`usetypeID`),
  ADD CONSTRAINT `queue_ibfk_1` FOREIGN KEY (`enrollment`) REFERENCES `program` (`programID`),
  ADD CONSTRAINT `queue_ibfk_2` FOREIGN KEY (`Window_ID`) REFERENCES `window` (`windowID`);

--
-- Constraints for table `queue_number_tracker`
--
ALTER TABLE `queue_number_tracker`
  ADD CONSTRAINT `queue_number_tracker_ibfk_1` FOREIGN KEY (`departmentID`) REFERENCES `departments` (`departmentID`);

--
-- Constraints for table `staff-window`
--
ALTER TABLE `staff-window`
  ADD CONSTRAINT `staff-window_ibfk_1` FOREIGN KEY (`Department id`) REFERENCES `departments` (`departmentID`),
  ADD CONSTRAINT `staff-window_ibfk_2` FOREIGN KEY (`Window_ID`) REFERENCES `window` (`windowID`),
  ADD CONSTRAINT `staff-window_ibfk_3` FOREIGN KEY (`Staff ID`) REFERENCES `staff_account` (`accountID`);

--
-- Constraints for table `staff_account`
--
ALTER TABLE `staff_account`
  ADD CONSTRAINT `staff_account_ibfk_1` FOREIGN KEY (`Authority_ID`) REFERENCES `authority` (`authorityID`),
  ADD CONSTRAINT `staff_account_ibfk_2` FOREIGN KEY (`Department_ID`) REFERENCES `departments` (`departmentID`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`Program ID`) REFERENCES `program` (`programID`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`DepartmentID`) REFERENCES `departments` (`departmentID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
