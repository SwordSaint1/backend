-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2019 at 11:01 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sem_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `car_model`
--

CREATE TABLE `car_model` (
  `id` int(11) NOT NULL,
  `Car_Model_Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `car_model`
--

INSERT INTO `car_model` (`id`, `Car_Model_Name`) VALUES
(1, 'Toyota'),
(2, 'Suzuki'),
(3, 'Nissan'),
(4, 'Daihatsu'),
(5, 'Honda'),
(6, 'Subaru'),
(7, 'Mazda');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `Name_Category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `Name_Category`) VALUES
(1, 'FAS'),
(2, 'Maxim'),
(3, 'PKIMT'),
(4, 'Add Even'),
(5, 'Megatrend'),
(6, 'One Source');

-- --------------------------------------------------------

--
-- Table structure for table `cc_or_refresh`
--

CREATE TABLE `cc_or_refresh` (
  `id` int(11) NOT NULL,
  `id_no` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cc_or_refresh`
--

INSERT INTO `cc_or_refresh` (`id`, `id_no`, `status`) VALUES
(1, '123', 'Cancellation of Certificate'),
(2, '19-05078', 'Refresh Training');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `Name_Department` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `Name_Department`) VALUES
(1, 'Production'),
(2, 'Quality Assurance');

-- --------------------------------------------------------

--
-- Table structure for table `final_process`
--

CREATE TABLE `final_process` (
  `id` int(11) NOT NULL,
  `Name_Process` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `final_process`
--

INSERT INTO `final_process` (`id`, `Name_Process`) VALUES
(1, 'Sub Assembly (Normal)'),
(2, 'Sub Assembly (Manual)'),
(3, 'Layout'),
(4, 'Parts Distribution'),
(5, 'Taping'),
(6, 'Bando Gun'),
(7, 'Grommet Insertion'),
(8, 'Bukumi/Shiage'),
(9, 'Option Taping'),
(10, 'Grease Injection'),
(11, 'Material Handler - Distributor'),
(12, 'Long Grommet Insertion'),
(13, 'Tsumesen Insertion');

-- --------------------------------------------------------

--
-- Table structure for table `final_pt`
--

CREATE TABLE `final_pt` (
  `id` int(11) NOT NULL,
  `Name_PT` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `final_pt`
--

INSERT INTO `final_pt` (`id`, `Name_PT`) VALUES
(1, 'Sub Assembly'),
(2, 'Assembly'),
(3, 'Inspection'),
(4, 'All Process');

-- --------------------------------------------------------

--
-- Table structure for table `initial_process`
--

CREATE TABLE `initial_process` (
  `id` int(11) NOT NULL,
  `Name_Process` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `initial_process`
--

INSERT INTO `initial_process` (`id`, `Name_Process`) VALUES
(1, 'Quick Stripping'),
(2, 'Intermediate Stripping / Mid splicing'),
(3, 'Casting (wire cutting)'),
(4, 'Twisting (Primary/Secondary)'),
(5, 'Joint Insulation Taping (Joint)'),
(6, 'Gomusen Insertion'),
(7, 'Material Handler - Distributor'),
(8, 'Material Handler - ZAIHAI'),
(9, 'Shikakari Handler - Sorter\r\n'),
(10, 'Shikakari Handler - Picking\r\n'),
(11, 'Shikakari Handler - Setter'),
(12, 'Stripping (STMAC)'),
(13, 'Heat Shrink (Raychem)'),
(14, 'Heat Shrink (Blower)'),
(15, 'LA Molding'),
(16, 'Silicon Injection'),
(17, 'Shield Wire Taping'),
(18, 'Taping Efuco'),
(19, 'Weld Taping'),
(20, 'Shield Wire'),
(21, 'Shield Wire (with Joint)'),
(22, 'Point Marking');

-- --------------------------------------------------------

--
-- Table structure for table `initial_pt`
--

CREATE TABLE `initial_pt` (
  `id` int(11) NOT NULL,
  `Name_PT` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `initial_pt`
--

INSERT INTO `initial_pt` (`id`, `Name_PT`) VALUES
(1, 'First'),
(2, 'Secondary'),
(3, 'All Process');

-- --------------------------------------------------------

--
-- Table structure for table `ir_memo`
--

CREATE TABLE `ir_memo` (
  `id` int(11) NOT NULL,
  `id_no` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `car_model` varchar(255) NOT NULL,
  `no_of_days` varchar(255) NOT NULL,
  `date_suspended` varchar(255) NOT NULL,
  `date_returned` varchar(255) NOT NULL,
  `violation` varchar(255) NOT NULL,
  `details` varchar(255) NOT NULL,
  `process` varchar(255) NOT NULL,
  `date_report_tc` varchar(255) NOT NULL,
  `cancelation_of_certificate` varchar(255) NOT NULL,
  `ir_copy` longtext NOT NULL,
  `remarks` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ir_memo`
--

INSERT INTO `ir_memo` (`id`, `id_no`, `name`, `category`, `position`, `department`, `car_model`, `no_of_days`, `date_suspended`, `date_returned`, `violation`, `details`, `process`, `date_report_tc`, `cancelation_of_certificate`, `ir_copy`, `remarks`) VALUES
(1, '19-05078', 'Mark john tenorio', 'FAS', 'Jr. Staff', 'Production', '', '1', '2019-06-01', '2019-06-02', 'SOP', '123', 'Sub Assembly', '2019-06-12', '', '', '1234'),
(2, '19-05078', 'Mark John Tenorio', 'FAS', 'Jr. Staff', 'Production', '', '1', '2019-06-27', '2019-06-29', 'Sample', '12345', 'Sub Assembly', '2019-06-30', '', '', '123456'),
(3, '19-05078', 'Mark John Tenorio', 'FAS', 'Jr. Staff', 'Production', '', '1', '2019-07-02', '2019-07-03', 'SOP', '12', 'Sub Assembly', '2019-07-06', '', '', '123'),
(4, '123', 'Mark john tenorio', 'Maxim', 'Associate', 'Quality Assurance', '', '1', '2019-06-01', '2019-06-02', '1234', '123', 'Sub Assembly', '2019-06-12', '', '', '1234'),
(5, '12345', 'Hey', 'FAS', 'Associate', 'Production', '', '1', '2019-07-11', '2019-07-11', 'SOP', '12', 'Sub Assembly', '2019-07-11', '', '', '12'),
(6, '2154235', 'Mark John Tenorio', 'FAS', 'Associate', 'Production', '', '1', '2019-07-11', '2019-07-11', 'SOP', '1232', 'Sub Assembly', '2019-07-11', '', '', '123'),
(7, '123', 'Mark john tenorio', 'Maxim', 'Associate', 'Quality Assurance', '', '1', '2019-07-15', '2019-07-17', 'SOP', '1222', 'Sub Assembly', '2019-07-19', '', '', '123344');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` int(11) NOT NULL,
  `Name_Position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `Name_Position`) VALUES
(1, 'Associate'),
(2, 'Associate/Expert'),
(3, 'Jr. Staff'),
(4, 'Staff'),
(5, 'Supervisor');

-- --------------------------------------------------------

--
-- Table structure for table `process`
--

CREATE TABLE `process` (
  `id` int(11) NOT NULL,
  `Name_Process` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `process`
--

INSERT INTO `process` (`id`, `Name_Process`) VALUES
(1, 'Sub Assembly'),
(2, 'Assembly');

-- --------------------------------------------------------

--
-- Table structure for table `sem_account`
--

CREATE TABLE `sem_account` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sem_account`
--

INSERT INTO `sem_account` (`id`, `username`, `name`, `password`) VALUES
(1, '19-05078', 'Mark John Tenorio', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `car_model`
--
ALTER TABLE `car_model`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cc_or_refresh`
--
ALTER TABLE `cc_or_refresh`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `final_process`
--
ALTER TABLE `final_process`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `final_pt`
--
ALTER TABLE `final_pt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `initial_process`
--
ALTER TABLE `initial_process`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `initial_pt`
--
ALTER TABLE `initial_pt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ir_memo`
--
ALTER TABLE `ir_memo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `process`
--
ALTER TABLE `process`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sem_account`
--
ALTER TABLE `sem_account`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `car_model`
--
ALTER TABLE `car_model`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `cc_or_refresh`
--
ALTER TABLE `cc_or_refresh`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `final_process`
--
ALTER TABLE `final_process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `final_pt`
--
ALTER TABLE `final_pt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `initial_process`
--
ALTER TABLE `initial_process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `initial_pt`
--
ALTER TABLE `initial_pt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `ir_memo`
--
ALTER TABLE `ir_memo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `process`
--
ALTER TABLE `process`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sem_account`
--
ALTER TABLE `sem_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
