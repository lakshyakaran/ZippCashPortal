-- phpMyAdmin SQL Dump
-- version 4.4.15.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 27, 2016 at 07:45 PM
-- Server version: 5.5.44-MariaDB
-- PHP Version: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lottery`
--

-- --------------------------------------------------------

--
-- Table structure for table `lottery_details`
--

CREATE TABLE IF NOT EXISTS `lottery_details` (
  `lottery_id` bigint(20) NOT NULL,
  `lottery_name` text,
  `lottery_description` text,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lottery_date_time` datetime NOT NULL,
  `result_date_time` datetime NOT NULL,
  `timezone` text NOT NULL,
  `status` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lottery_details`
--

INSERT INTO `lottery_details` (`lottery_id`, `lottery_name`, `lottery_description`, `created_on`, `lottery_date_time`, `result_date_time`, `timezone`, `status`) VALUES
(1, 'Morning Lottery', 'This is just a description', '2016-02-15 12:23:31', '2016-02-15 00:00:00', '0000-00-00 00:00:00', '', 'inactive'),
(2, 'Evening Lottery', 'This is just a description', '2016-02-18 02:37:05', '2016-02-17 14:00:00', '0000-00-00 00:00:00', '', 'inactive'),
(5, 'Morning Lottery', NULL, '2016-02-18 06:50:02', '2016-02-18 01:50:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(6, 'Evening Lottery', NULL, '2016-02-19 08:22:28', '2016-02-18 17:00:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(7, 'Evening Lottery', NULL, '2016-02-27 15:06:26', '2016-02-19 17:00:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(8, 'Evening Lottery', NULL, '2016-02-27 15:06:26', '2016-02-27 17:00:00', '0000-00-00 00:00:00', 'America/New_York', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `lottery_result`
--

CREATE TABLE IF NOT EXISTS `lottery_result` (
  `result_id` bigint(20) NOT NULL,
  `lottery_id` bigint(20) NOT NULL,
  `lottery_number_1` int(11) DEFAULT NULL,
  `lottery_number_2` int(11) DEFAULT NULL,
  `lottery_number_3` int(11) DEFAULT NULL,
  `amount_received` decimal(6,2) DEFAULT NULL,
  `amount_paid` decimal(6,2) DEFAULT NULL,
  `published_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lottery_result`
--

INSERT INTO `lottery_result` (`result_id`, `lottery_id`, `lottery_number_1`, `lottery_number_2`, `lottery_number_3`, `amount_received`, `amount_paid`, `published_on`) VALUES
(1, 1, 10, 17, 15, 73.00, 90.00, '2016-02-15 01:53:31'),
(2, 2, 12, 56, 36, 384.00, 180.00, '2016-02-17 16:07:05'),
(3, 5, 12, 15, 18, 0.00, 0.00, '2016-02-17 20:20:02'),
(4, 6, 12, 54, 96, 0.00, 0.00, '2016-02-18 21:52:27'),
(5, 7, 12, 58, 96, 0.00, 0.00, '2016-02-27 04:36:26'),
(6, 8, NULL, NULL, NULL, NULL, NULL, '2016-02-27 15:06:26');

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE IF NOT EXISTS `payment_details` (
  `transaction_id` bigint(20) NOT NULL,
  `ticket_id` bigint(20) NOT NULL,
  `total_amount` decimal(6,2) NOT NULL,
  `payment_type` text NOT NULL,
  `payment_mode` text NOT NULL,
  `payment_state` text NOT NULL,
  `payment_id` text NOT NULL,
  `payment_create_time` text NOT NULL,
  `payment_intent` text NOT NULL,
  `client_platform` text NOT NULL,
  `client_paypal_sdk_version` text,
  `client_product_name` text,
  `client_environment` text NOT NULL,
  `payment_response_type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_details`
--

CREATE TABLE IF NOT EXISTS `ticket_details` (
  `ticket_detail_id` bigint(20) NOT NULL,
  `ticket_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `ticket_number` int(11) NOT NULL,
  `ticket_amount` decimal(6,2) NOT NULL,
  `win_amount` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE IF NOT EXISTS `transaction_details` (
  `transaction_id` bigint(20) NOT NULL,
  `account_holder_id` bigint(20) NOT NULL,
  `refrence_account_id` bigint(20) NOT NULL,
  `previous_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `current_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `transaction_type` text NOT NULL,
  `transaction_name` text NOT NULL,
  `transaction_amount` decimal(10,2) NOT NULL,
  `initiated_by` text NOT NULL,
  `initiated_by_id` bigint(20) NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `transaction_status` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=225 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_admin`
--

CREATE TABLE IF NOT EXISTS `user_admin` (
  `admin_id` int(11) NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` text NOT NULL,
  `country_code` text NOT NULL,
  `country_name` text NOT NULL,
  `phone` bigint(20) NOT NULL,
  `password` text NOT NULL,
  `email_verified` tinyint(1) NOT NULL,
  `phone_verified` tinyint(1) NOT NULL,
  `added_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_admin`
--

INSERT INTO `user_admin` (`admin_id`, `first_name`, `last_name`, `email`, `country_code`, `country_name`, `phone`, `password`, `email_verified`, `phone_verified`, `added_on`, `last_login`, `status`) VALUES
(1, '', '', 'pratikraj26@gmail.com', '', '', 0, '5f4dcc3b5aa765d61d8327deb882cf99', 0, 0, '2016-02-15 12:10:20', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_bank`
--

CREATE TABLE IF NOT EXISTS `user_bank` (
  `bank_id` bigint(20) NOT NULL,
  `bank_name` text NOT NULL,
  `login_id` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `country_code` text NOT NULL,
  `country_name` text NOT NULL,
  `address` text NOT NULL,
  `address_2` text NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `postal_code` text NOT NULL,
  `landmark` text NOT NULL,
  `token` text,
  `profile_pic` text NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1000002 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_bank`
--

INSERT INTO `user_bank` (`bank_id`, `bank_name`, `login_id`, `password`, `country_code`, `country_name`, `address`, `address_2`, `city`, `state`, `postal_code`, `landmark`, `token`, `profile_pic`, `date_time`, `status`) VALUES
(1000001, 'Test Bank, India', 'BNK-1000001', '329331fffc95c63ed90dc3b5f7154957', '+91', 'India', 'Test Address', 'Test address 2', 'New Delhi', 'Delhi', '110059', 'Uttam Nagar Metro', NULL, '', '0000-00-00 00:00:00', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `user_id` bigint(20) NOT NULL,
  `login_id` text NOT NULL,
  `user_type` varchar(50) NOT NULL DEFAULT 'individual',
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `store_name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `gender` text NOT NULL,
  `country_code` text NOT NULL,
  `country_name` text NOT NULL,
  `address` text NOT NULL,
  `address_2` text NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `postal_code` text NOT NULL,
  `landmark` text NOT NULL,
  `phone` varchar(10) NOT NULL,
  `verification_code` int(4) NOT NULL,
  `email_verified` varchar(5) NOT NULL DEFAULT 'no',
  `phone_verified` varchar(5) NOT NULL DEFAULT 'no',
  `added_by` text NOT NULL,
  `added_by_id` bigint(20) NOT NULL,
  `token` text,
  `profile_pic` text NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1023 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_id`, `login_id`, `user_type`, `first_name`, `last_name`, `store_name`, `email`, `password`, `gender`, `country_code`, `country_name`, `address`, `address_2`, `city`, `state`, `postal_code`, `landmark`, `phone`, `verification_code`, `email_verified`, `phone_verified`, `added_by`, `added_by_id`, `token`, `profile_pic`, `date_time`, `status`) VALUES
(0, '0', 'zippcash', 'Zipp', 'Cash', 'ZippCash', '', '', '', '', '', '', '', '', '', '', '', '', 0, '', '', '', 0, NULL, '', '2016-02-14 10:04:44', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_ticket`
--

CREATE TABLE IF NOT EXISTS `user_ticket` (
  `ticket_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `lottery_id` bigint(20) NOT NULL,
  `total_amount` decimal(6,2) NOT NULL,
  `paid_amount` decimal(6,2) NOT NULL,
  `win_amount` decimal(6,2) DEFAULT NULL,
  `purchased_on` datetime NOT NULL,
  `purchased_by` text NOT NULL,
  `purchased_by_id` bigint(20) NOT NULL,
  `paid_on` datetime NOT NULL,
  `payment_status` text,
  `payment_transaction_id` bigint(20) DEFAULT NULL,
  `payment_sent_status` text,
  `payment_sent_transaction_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_wallet`
--

CREATE TABLE IF NOT EXISTS `user_wallet` (
  `wallet_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `available_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `wallet_type` text NOT NULL,
  `wallet_status` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_wallet`
--

INSERT INTO `user_wallet` (`wallet_id`, `user_id`, `available_balance`, `wallet_type`, `wallet_status`) VALUES
(1, 0, 50000.00, 'Premium', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lottery_details`
--
ALTER TABLE `lottery_details`
  ADD PRIMARY KEY (`lottery_id`);

--
-- Indexes for table `lottery_result`
--
ALTER TABLE `lottery_result`
  ADD PRIMARY KEY (`result_id`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `ticket_details`
--
ALTER TABLE `ticket_details`
  ADD PRIMARY KEY (`ticket_detail_id`);

--
-- Indexes for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `user_admin`
--
ALTER TABLE `user_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `user_bank`
--
ALTER TABLE `user_bank`
  ADD PRIMARY KEY (`bank_id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_ticket`
--
ALTER TABLE `user_ticket`
  ADD PRIMARY KEY (`ticket_id`);

--
-- Indexes for table `user_wallet`
--
ALTER TABLE `user_wallet`
  ADD PRIMARY KEY (`wallet_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lottery_details`
--
ALTER TABLE `lottery_details`
  MODIFY `lottery_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `lottery_result`
--
ALTER TABLE `lottery_result`
  MODIFY `result_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `transaction_id` bigint(20) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ticket_details`
--
ALTER TABLE `ticket_details`
  MODIFY `ticket_detail_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `transaction_details`
--
ALTER TABLE `transaction_details`
  MODIFY `transaction_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=225;
--
-- AUTO_INCREMENT for table `user_admin`
--
ALTER TABLE `user_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_bank`
--
ALTER TABLE `user_bank`
  MODIFY `bank_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1000002;
--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `user_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1023;
--
-- AUTO_INCREMENT for table `user_ticket`
--
ALTER TABLE `user_ticket`
  MODIFY `ticket_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `user_wallet`
--
ALTER TABLE `user_wallet`
  MODIFY `wallet_id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
