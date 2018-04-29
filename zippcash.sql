-- phpMyAdmin SQL Dump
-- version 4.1.14.8
-- http://www.phpmyadmin.net
--
-- Host: db608828411.db.1and1.com
-- Generation Time: Apr 29, 2018 at 03:39 AM
-- Server version: 5.5.59-0+deb7u1-log
-- PHP Version: 5.4.45-0+deb7u13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db608828411`
--

-- --------------------------------------------------------

--
-- Table structure for table `lottery_details`
--

CREATE TABLE IF NOT EXISTS `lottery_details` (
  `lottery_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `lottery_name` text,
  `lottery_description` text,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lottery_date_time` datetime NOT NULL,
  `result_date_time` datetime NOT NULL,
  `timezone` text NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`lottery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

--
-- Dumping data for table `lottery_details`
--

INSERT INTO `lottery_details` (`lottery_id`, `lottery_name`, `lottery_description`, `created_on`, `lottery_date_time`, `result_date_time`, `timezone`, `status`) VALUES
(29, 'Maten', NULL, '2017-08-13 17:50:05', '2017-07-06 11:00:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(30, 'AswÃ¨', NULL, '2017-08-13 18:47:36', '2017-07-08 17:00:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(31, 'Maten', NULL, '2017-08-13 17:50:05', '2017-07-09 11:00:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(32, 'Maten', NULL, '2017-08-13 17:50:05', '2017-07-10 11:00:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(33, 'Maten', NULL, '2017-08-13 17:50:05', '2017-07-11 12:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(34, 'AswÃ¨', NULL, '2017-08-13 18:47:36', '2017-07-11 19:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(35, 'Maten', NULL, '2017-08-13 17:50:05', '2017-07-12 12:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(36, 'Maten', NULL, '2017-08-13 17:50:05', '2017-07-14 12:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(37, 'Maten', NULL, '2017-08-13 17:50:05', '2017-07-16 12:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(38, 'AswÃ¨', NULL, '2017-08-13 18:47:36', '2017-07-16 19:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(39, 'Maten', NULL, '2017-08-13 17:50:05', '2017-07-17 12:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(40, 'Maten', NULL, '2017-08-13 17:50:05', '2017-07-20 12:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(41, 'AswÃ¨', NULL, '2017-08-13 18:47:36', '2017-07-20 19:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(42, 'AswÃ¨', NULL, '2017-08-13 18:47:36', '2017-07-21 19:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(43, 'Maten', NULL, '2017-08-13 17:50:05', '2017-07-23 12:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(44, 'AswÃ¨', NULL, '2017-08-13 18:47:36', '2017-07-23 19:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(45, 'Maten', NULL, '2017-08-13 17:50:05', '2017-07-24 12:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(46, 'AswÃ¨', NULL, '2017-08-13 18:47:36', '2017-07-24 19:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(47, 'Maten', NULL, '2017-08-13 17:50:05', '2017-07-25 12:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(48, 'AswÃ¨', NULL, '2017-08-13 18:47:36', '2017-07-25 19:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(49, 'Maten', NULL, '2017-08-13 17:50:05', '2017-07-26 12:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(50, 'AswÃ¨', NULL, '2017-08-13 18:47:36', '2017-07-26 19:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(51, 'Maten', NULL, '2017-08-13 17:50:05', '2017-07-27 12:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(52, 'AswÃ¨', NULL, '2017-08-13 18:47:36', '2017-07-27 19:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(53, 'Maten', NULL, '2017-08-13 17:50:05', '2017-07-28 12:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(54, 'AswÃ¨', NULL, '2017-08-13 18:47:36', '2017-07-28 19:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(55, 'Maten', NULL, '2017-08-13 17:50:05', '2017-07-29 12:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(56, 'Maten', NULL, '2017-08-13 17:50:05', '2017-07-30 12:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(57, 'Maten', NULL, '2017-08-13 17:50:05', '2017-08-12 12:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(58, 'AswÃ¨', NULL, '2017-08-13 18:47:36', '2017-08-12 19:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(59, 'Maten', NULL, '2017-08-13 19:35:49', '2017-08-13 12:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(60, 'AswÃ¨', NULL, '2017-10-04 16:35:56', '2017-08-13 19:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(61, 'AswÃ¨', NULL, '2018-01-12 14:24:49', '2017-10-04 19:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(62, 'AswÃ¨', NULL, '2018-01-16 16:55:41', '2018-01-12 19:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(63, 'AswÃ¨', NULL, '2018-03-22 23:01:23', '2018-01-16 19:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(64, 'Maten', NULL, '2018-04-22 16:52:55', '2018-03-23 12:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(65, 'AswÃ¨', NULL, '2018-04-23 08:59:23', '2018-04-22 19:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(66, 'AswÃ¨', NULL, '2018-04-23 23:59:23', '2018-04-23 19:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(67, 'Maten', NULL, '2018-04-24 19:59:38', '2018-04-24 12:30:00', '0000-00-00 00:00:00', 'America/New_York', 'inactive'),
(68, 'AswÃ¨', NULL, '2018-04-24 19:59:38', '2018-04-24 19:30:00', '0000-00-00 00:00:00', 'America/New_York', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `lottery_result`
--

CREATE TABLE IF NOT EXISTS `lottery_result` (
  `result_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `lottery_id` bigint(20) NOT NULL,
  `lottery_number_1` text,
  `lottery_number_2` text,
  `lottery_number_3` text,
  `amount_received` decimal(10,2) DEFAULT NULL,
  `amount_paid` decimal(10,2) DEFAULT NULL,
  `published_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`result_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `lottery_result`
--

INSERT INTO `lottery_result` (`result_id`, `lottery_id`, `lottery_number_1`, `lottery_number_2`, `lottery_number_3`, `amount_received`, `amount_paid`, `published_on`) VALUES
(27, 29, '00', '12', '15', '0.00', '0.00', '2017-07-08 11:52:16'),
(28, 30, '324', '76', '89', '0.00', '0.00', '2017-07-09 00:48:56'),
(29, 31, '216', '85', '99', '0.00', '0.00', '2017-07-09 16:34:41'),
(30, 32, '602', '15', '38', '0.00', '0.00', '2017-07-10 23:51:24'),
(31, 33, '428', '00', '79', '0.00', '0.00', '2017-07-11 19:37:18'),
(32, 34, '593', '83', '88', '0.00', '0.00', '2017-07-12 00:46:08'),
(33, 35, '245', '69', '34', '0.00', '0.00', '2017-07-14 01:27:31'),
(34, 36, '586', '24', '11', '0.00', '0.00', '2017-07-15 20:25:46'),
(35, 37, '11', '22', '77', '60.00', '0.00', '2017-07-16 17:09:31'),
(36, 38, '356', '55', '67', '0.00', '0.00', '2017-07-17 00:14:37'),
(37, 39, '210', '45', '33', '0.00', '0.00', '2017-07-19 20:52:37'),
(38, 40, '712', '44', '05', '4.00', '0.00', '2017-07-20 19:41:19'),
(39, 41, '256', '45', '56', '0.00', '0.00', '2017-07-21 14:17:08'),
(40, 42, '678', '86', '34', '15.00', '0.00', '2017-07-23 02:05:37'),
(41, 43, '808', '85', '50', '0.00', '0.00', '2017-07-23 16:40:59'),
(42, 44, '182', '09', '50', '0.00', '0.00', '2017-07-23 23:51:43'),
(43, 45, '571', '32', '39', '0.00', '0.00', '2017-07-24 17:01:26'),
(44, 46, '057', '26', '46', '0.00', '0.00', '2017-07-24 23:51:59'),
(45, 47, '992', '38', '53', '0.00', '0.00', '2017-07-25 17:01:16'),
(46, 48, '865', '14', '62', '0.00', '0.00', '2017-07-25 23:58:02'),
(47, 49, '541', '17', '03', '0.00', '0.00', '2017-07-26 16:53:20'),
(48, 50, '34', '24', '33', '0.00', '0.00', '2017-07-26 23:38:21'),
(49, 51, '106', '99', '74', '0.00', '0.00', '2017-07-27 18:02:47'),
(50, 52, '628', '96', '42', '0.00', '0.00', '2017-07-27 23:58:43'),
(51, 53, '618', '30', '32', '0.00', '0.00', '2017-07-28 17:44:05'),
(52, 54, '044', '35', '21', '0.00', '0.00', '2017-07-29 00:52:32'),
(53, 55, '050', '07', '16', '0.00', '0.00', '2017-07-29 20:29:37'),
(54, 56, '075', '67', '67', '0.00', '0.00', '2017-08-12 02:59:43'),
(55, 57, '453', '23', '40', '0.00', '0.00', '2017-08-12 17:34:26'),
(56, 58, '534', '64', '86', '0.00', '0.00', '2017-08-13 01:06:12'),
(57, 59, '765', '89', '78', '0.00', '0.00', '2017-08-13 19:35:49'),
(58, 60, '472', '19', '00', '0.00', '0.00', '2017-10-04 16:35:56'),
(59, 61, '346', '17', '24', '0.00', '0.00', '2018-01-12 14:24:49'),
(60, 62, '256', '47', '36', '0.00', '0.00', '2018-01-16 16:55:41'),
(61, 63, '025', '19', '24', '5.00', '0.00', '2018-03-22 23:01:23'),
(62, 64, '136', '56', '20', '500.00', '0.00', '2018-04-22 16:52:55'),
(63, 65, '346', '17', '68', '0.00', '0.00', '2018-04-23 08:59:23'),
(64, 66, '425', '19', '46', '9.00', '60.00', '2018-04-23 23:59:23'),
(65, 67, '349', '17', '98', '0.00', '0.00', '2018-04-24 19:59:38'),
(66, 68, NULL, NULL, NULL, NULL, NULL, '2018-04-24 19:59:38');

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE IF NOT EXISTS `payment_details` (
  `transaction_id` bigint(20) NOT NULL AUTO_INCREMENT,
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
  `payment_response_type` text NOT NULL,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reported_issues`
--

CREATE TABLE IF NOT EXISTS `reported_issues` (
  `issue_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `issue_type` text NOT NULL,
  `issue_details` text NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`issue_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `reported_issues`
--

INSERT INTO `reported_issues` (`issue_id`, `user_id`, `issue_type`, `issue_details`, `status`) VALUES
(1, 1044, 'Report an Issue', 'Test', 'Active'),
(2, 1044, 'Report an Issue', 'Yo vole telephone mwen', 'Active'),
(3, 1055, 'Report an Issue', 'Fuck', 'Active'),
(4, 1048, 'Report an Issue', 'Mwen fÃ¨ you movÃ© tranzaksyon', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `ticket_details`
--

CREATE TABLE IF NOT EXISTS `ticket_details` (
  `ticket_detail_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ticket_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `ticket_number` text NOT NULL,
  `ticket_amount` decimal(6,2) NOT NULL,
  `win_amount` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`ticket_detail_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=137 ;

--
-- Dumping data for table `ticket_details`
--

INSERT INTO `ticket_details` (`ticket_detail_id`, `ticket_id`, `user_id`, `ticket_number`, `ticket_amount`, `win_amount`) VALUES
(116, 47, 1048, '356', '10.00', '0.00'),
(117, 47, 1048, '367', '10.00', '0.00'),
(118, 47, 1048, '3675', '5.00', '0.00'),
(119, 47, 1048, '5567', '5.00', '0.00'),
(120, 47, 1048, '34x65', '5.00', '0.00'),
(121, 47, 1048, '38', '20.00', '0.00'),
(122, 47, 1048, '78x23', '5.00', '0.00'),
(123, 48, 1048, '478', '1.00', '0.00'),
(124, 48, 1048, '3175', '1.00', '0.00'),
(125, 48, 1048, '45x32', '1.00', '0.00'),
(126, 48, 1048, '25', '1.00', '0.00'),
(127, 49, 1048, '46', '5.00', '0.00'),
(128, 49, 1048, '67', '10.00', '0.00'),
(129, 50, 1048, '23', '5.00', '0.00'),
(130, 51, 1048, '42', '200.00', '0.00'),
(131, 51, 1048, '57', '300.00', '0.00'),
(132, 52, 1048, '134', '1.00', '0.00'),
(133, 52, 1048, '25', '1.00', '60.00'),
(134, 52, 1048, '6734', '1.00', '0.00'),
(135, 52, 1048, '45x24', '1.00', '0.00'),
(136, 53, 1048, '23', '5.00', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE IF NOT EXISTS `transaction_details` (
  `transaction_id` bigint(20) NOT NULL AUTO_INCREMENT,
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
  `transaction_status` text NOT NULL,
  PRIMARY KEY (`transaction_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=446 ;

--
-- Dumping data for table `transaction_details`
--

INSERT INTO `transaction_details` (`transaction_id`, `account_holder_id`, `refrence_account_id`, `previous_balance`, `current_balance`, `transaction_type`, `transaction_name`, `transaction_amount`, `initiated_by`, `initiated_by_id`, `transaction_date`, `transaction_status`) VALUES
(326, 1044, 0, '500.00', '482.00', 'debit', 'lottery_ticket_purchase', '18.00', 'bank', 1044, '2017-05-18 23:37:20', 'complete'),
(327, 0, 1044, '100000.00', '100018.00', 'credit', 'lottery_ticket_purchase', '18.00', 'bank', 1044, '2017-05-18 23:37:20', 'complete'),
(328, 0, 1044, '100018.00', '95718.00', 'debit', 'ticket_win_amount', '4300.00', 'bank', 1, '2017-05-20 01:54:32', 'complete'),
(329, 1044, 0, '482.00', '4782.00', 'credit', 'ticket_win_amount', '4300.00', 'bank', 1, '2017-05-20 01:54:32', 'complete'),
(330, 1044, 0, '4782.00', '4749.00', 'debit', 'lottery_ticket_purchase', '33.00', 'bank', 1044, '2017-05-20 14:54:30', 'complete'),
(331, 0, 1044, '95718.00', '95751.00', 'credit', 'lottery_ticket_purchase', '33.00', 'bank', 1044, '2017-05-20 14:54:30', 'complete'),
(332, 1043, 0, '500.00', '495.00', 'debit', 'lottery_ticket_purchase', '5.00', 'bank', 1043, '2017-05-28 14:57:57', 'complete'),
(333, 0, 1043, '95751.00', '95756.00', 'credit', 'lottery_ticket_purchase', '5.00', 'bank', 1043, '2017-05-28 14:57:57', 'complete'),
(334, 0, 1043, '95756.00', '95456.00', 'debit', 'ticket_win_amount', '300.00', 'bank', 1, '2017-06-04 18:23:44', 'complete'),
(335, 1043, 0, '495.00', '795.00', 'credit', 'ticket_win_amount', '300.00', 'bank', 1, '2017-06-04 18:23:44', 'complete'),
(336, 1045, 0, '500.00', '490.00', 'debit', 'lottery_ticket_purchase', '10.00', 'bank', 1045, '2017-06-04 18:24:33', 'complete'),
(337, 0, 1045, '95456.00', '95466.00', 'credit', 'lottery_ticket_purchase', '10.00', 'bank', 1045, '2017-06-04 18:24:33', 'complete'),
(338, 0, 1045, '95466.00', '95166.00', 'debit', 'ticket_win_amount', '300.00', 'bank', 1, '2017-06-04 18:27:28', 'complete'),
(339, 1045, 0, '490.00', '790.00', 'credit', 'ticket_win_amount', '300.00', 'bank', 1, '2017-06-04 18:27:28', 'complete'),
(340, 1044, 0, '4749.00', '4733.00', 'debit', 'lottery_ticket_purchase', '16.00', 'bank', 1044, '2017-06-05 00:29:49', 'complete'),
(341, 0, 1044, '95166.00', '95182.00', 'credit', 'lottery_ticket_purchase', '16.00', 'bank', 1044, '2017-06-05 00:29:49', 'complete'),
(342, 1044, 0, '4733.00', '4713.00', 'debit', 'lottery_ticket_purchase', '20.00', 'bank', 1044, '2017-06-17 02:36:20', 'complete'),
(343, 0, 1044, '95182.00', '95202.00', 'credit', 'lottery_ticket_purchase', '20.00', 'bank', 1044, '2017-06-17 02:36:20', 'complete'),
(344, 1048, 0, '500.00', '431.00', 'debit', 'lottery_ticket_purchase', '69.00', 'bank', 1048, '2017-07-03 14:51:40', 'complete'),
(345, 0, 1048, '95202.00', '95271.00', 'credit', 'lottery_ticket_purchase', '69.00', 'bank', 1048, '2017-07-03 14:51:40', 'complete'),
(346, 0, 1048, '95271.00', '73921.00', 'debit', 'ticket_win_amount', '21350.00', 'bank', 1, '2017-07-03 19:40:32', 'complete'),
(347, 1048, 0, '431.00', '21781.00', 'credit', 'ticket_win_amount', '21350.00', 'bank', 1, '2017-07-03 19:40:32', 'complete'),
(348, 0, 1049, '73921.00', '74421.00', 'credit', 'cash_deposit', '500.00', 'bank', 1, '2017-07-15 14:35:50', 'complete'),
(349, 0, 1049, '74421.00', '73921.00', 'debit', 'deposit_transfer', '500.00', 'bank', 1, '2017-07-15 14:35:50', 'complete'),
(350, 1049, 0, '500.00', '1000.00', 'credit', 'deposit_transfer', '500.00', 'bank', 1, '2017-07-15 14:35:50', 'complete'),
(351, 0, 1049, '73921.00', '74421.00', 'credit', 'withdraw_transfer', '500.00', 'bank', 1, '2017-07-15 14:36:43', 'complete'),
(352, 1049, 0, '1000.00', '500.00', 'debit', 'withdraw_transfer', '500.00', 'bank', 1, '2017-07-15 14:36:43', 'complete'),
(353, 0, 1049, '74421.00', '73921.00', 'debit', 'cash_withdraw', '500.00', 'bank', 1, '2017-07-15 14:36:43', 'complete'),
(354, 0, 1048, '73921.00', '73942.00', 'credit', 'cash_deposit', '21.00', 'bank', 1, '2017-07-15 20:31:48', 'complete'),
(355, 0, 1048, '73942.00', '73921.00', 'debit', 'deposit_transfer', '21.00', 'bank', 1, '2017-07-15 20:31:48', 'complete'),
(356, 1048, 0, '21781.00', '21802.00', 'credit', 'deposit_transfer', '21.00', 'bank', 1, '2017-07-15 20:31:48', 'complete'),
(357, 0, 1048, '73921.00', '75421.00', 'credit', 'cash_deposit', '1500.00', 'bank', 1, '2017-07-15 20:35:51', 'complete'),
(358, 0, 1048, '75421.00', '73921.00', 'debit', 'deposit_transfer', '1500.00', 'bank', 1, '2017-07-15 20:35:51', 'complete'),
(359, 1048, 0, '21802.00', '23302.00', 'credit', 'deposit_transfer', '1500.00', 'bank', 1, '2017-07-15 20:35:51', 'complete'),
(360, 0, 1048, '73921.00', '77921.00', 'credit', 'cash_deposit', '4000.00', 'bank', 1, '2017-07-15 20:43:49', 'complete'),
(361, 0, 1048, '77921.00', '73921.00', 'debit', 'deposit_transfer', '4000.00', 'bank', 1, '2017-07-15 20:43:49', 'complete'),
(362, 1048, 0, '23302.00', '27302.00', 'credit', 'deposit_transfer', '4000.00', 'bank', 1, '2017-07-15 20:43:49', 'complete'),
(363, 0, 1048, '73921.00', '74921.00', 'credit', 'cash_deposit', '1000.00', 'bank', 1, '2017-07-15 20:47:32', 'complete'),
(364, 0, 1048, '74921.00', '73921.00', 'debit', 'deposit_transfer', '1000.00', 'bank', 1, '2017-07-15 20:47:32', 'complete'),
(365, 1048, 0, '27302.00', '28302.00', 'credit', 'deposit_transfer', '1000.00', 'bank', 1, '2017-07-15 20:47:32', 'complete'),
(366, 0, 1048, '73921.00', '111521.00', 'credit', 'cash_deposit', '37600.00', 'bank', 1, '2017-07-15 20:59:11', 'complete'),
(367, 0, 1048, '111521.00', '73921.00', 'debit', 'deposit_transfer', '37600.00', 'bank', 1, '2017-07-15 20:59:11', 'complete'),
(368, 1048, 0, '28302.00', '65902.00', 'credit', 'deposit_transfer', '37600.00', 'bank', 1, '2017-07-15 20:59:11', 'complete'),
(369, 1048, 0, '65902.00', '65842.00', 'debit', 'lottery_ticket_purchase', '60.00', 'bank', 1048, '2017-07-16 16:16:52', 'complete'),
(370, 0, 1048, '73921.00', '73981.00', 'credit', 'lottery_ticket_purchase', '60.00', 'bank', 1048, '2017-07-16 16:16:52', 'complete'),
(371, 1048, 0, '65842.00', '65838.00', 'debit', 'lottery_ticket_purchase', '4.00', 'bank', 1048, '2017-07-20 11:13:22', 'complete'),
(372, 0, 1048, '73981.00', '73985.00', 'credit', 'lottery_ticket_purchase', '4.00', 'bank', 1048, '2017-07-20 11:13:22', 'complete'),
(373, 1048, 0, '65838.00', '65823.00', 'debit', 'lottery_ticket_purchase', '15.00', 'bank', 1048, '2017-07-21 14:20:10', 'complete'),
(374, 0, 1048, '73985.00', '74000.00', 'credit', 'lottery_ticket_purchase', '15.00', 'bank', 1048, '2017-07-21 14:20:10', 'complete'),
(375, 1048, 1051, '65823.00', '65800.00', 'debit', 'credit_transfer', '23.00', 'bank', 1048, '2017-08-12 03:40:36', 'complete'),
(376, 1051, 1048, '500.00', '523.00', 'credit', 'credit_transfer', '23.00', 'bank', 1048, '2017-08-12 03:40:36', 'complete'),
(377, 0, 1048, '74000.00', '74058.00', 'credit', 'withdraw_transfer', '58.00', 'bank', 0, '2017-08-12 17:39:12', 'complete'),
(378, 1048, 0, '65800.00', '65742.00', 'debit', 'withdraw_transfer', '58.00', 'bank', 0, '2017-08-12 17:39:12', 'complete'),
(379, 0, 1048, '74058.00', '74000.00', 'debit', 'cash_withdraw', '58.00', 'bank', 0, '2017-08-12 17:39:12', 'complete'),
(380, 0, 1048, '74000.00', '74058.00', 'credit', 'cash_deposit', '58.00', 'bank', 0, '2017-08-12 17:40:42', 'complete'),
(381, 0, 1048, '74058.00', '74000.00', 'debit', 'deposit_transfer', '58.00', 'bank', 0, '2017-08-12 17:40:42', 'complete'),
(382, 1048, 0, '65742.00', '65800.00', 'credit', 'deposit_transfer', '58.00', 'bank', 0, '2017-08-12 17:40:42', 'complete'),
(383, 0, 1048, '74000.00', '74058.00', 'credit', 'withdraw_transfer', '58.00', 'bank', 0, '2017-08-13 01:09:26', 'complete'),
(384, 1048, 0, '65800.00', '65742.00', 'debit', 'withdraw_transfer', '58.00', 'bank', 0, '2017-08-13 01:09:26', 'complete'),
(385, 0, 1048, '74058.00', '74000.00', 'debit', 'cash_withdraw', '58.00', 'bank', 0, '2017-08-13 01:09:26', 'complete'),
(386, 0, 1048, '74000.00', '74058.00', 'credit', 'cash_deposit', '58.00', 'bank', 0, '2017-08-13 01:12:22', 'complete'),
(387, 0, 1048, '74058.00', '74000.00', 'debit', 'deposit_transfer', '58.00', 'bank', 0, '2017-08-13 01:12:22', 'complete'),
(388, 1048, 0, '65742.00', '65800.00', 'credit', 'deposit_transfer', '58.00', 'bank', 0, '2017-08-13 01:12:22', 'complete'),
(389, 0, 1048, '74000.00', '74200.00', 'credit', 'cash_deposit', '200.00', 'bank', 0, '2017-09-18 18:23:30', 'complete'),
(390, 0, 1048, '74200.00', '74000.00', 'debit', 'deposit_transfer', '200.00', 'bank', 0, '2017-09-18 18:23:30', 'complete'),
(391, 1048, 0, '65800.00', '66000.00', 'credit', 'deposit_transfer', '200.00', 'bank', 0, '2017-09-18 18:23:30', 'complete'),
(392, 1055, 1048, '500.00', '0.00', 'debit', 'credit_transfer', '500.00', 'bank', 1055, '2017-10-09 16:13:28', 'complete'),
(393, 1048, 1055, '66000.00', '66500.00', 'credit', 'credit_transfer', '500.00', 'bank', 1055, '2017-10-09 16:13:28', 'complete'),
(394, 1048, 1055, '66500.00', '66000.00', 'debit', 'credit_transfer', '500.00', 'bank', 1048, '2017-10-09 16:22:37', 'complete'),
(395, 1055, 1048, '0.00', '500.00', 'credit', 'credit_transfer', '500.00', 'bank', 1048, '2017-10-09 16:22:37', 'complete'),
(396, 1055, 1048, '500.00', '400.00', 'debit', 'credit_transfer', '100.00', 'bank', 1055, '2017-10-10 00:55:32', 'complete'),
(397, 1048, 1055, '66000.00', '66100.00', 'credit', 'credit_transfer', '100.00', 'bank', 1055, '2017-10-10 00:55:33', 'complete'),
(398, 1048, 1055, '66100.00', '66000.00', 'debit', 'credit_transfer', '100.00', 'bank', 1048, '2017-10-10 16:59:37', 'complete'),
(399, 1055, 1048, '400.00', '500.00', 'credit', 'credit_transfer', '100.00', 'bank', 1048, '2017-10-10 16:59:37', 'complete'),
(400, 1048, 1055, '66000.00', '65900.00', 'debit', 'credit_transfer', '100.00', 'bank', 1048, '2017-10-10 16:59:44', 'complete'),
(401, 1055, 1048, '500.00', '600.00', 'credit', 'credit_transfer', '100.00', 'bank', 1048, '2017-10-10 16:59:44', 'complete'),
(402, 0, 1048, '74000.00', '74900.00', 'credit', 'withdraw_transfer', '900.00', 'bank', 0, '2017-10-10 21:38:25', 'complete'),
(403, 1048, 0, '65900.00', '65000.00', 'debit', 'withdraw_transfer', '900.00', 'bank', 0, '2017-10-10 21:38:25', 'complete'),
(404, 0, 1048, '74900.00', '74000.00', 'debit', 'cash_withdraw', '900.00', 'bank', 0, '2017-10-10 21:38:25', 'complete'),
(405, 0, 1048, '74000.00', '74900.00', 'credit', 'cash_deposit', '900.00', 'bank', 0, '2017-10-10 21:44:28', 'complete'),
(406, 0, 1048, '74900.00', '74000.00', 'debit', 'deposit_transfer', '900.00', 'bank', 0, '2017-10-10 21:44:28', 'complete'),
(407, 1048, 0, '65000.00', '65900.00', 'credit', 'deposit_transfer', '900.00', 'bank', 0, '2017-10-10 21:44:28', 'complete'),
(408, 0, 1048, '74000.00', '74900.00', 'credit', 'withdraw_transfer', '900.00', 'bank', 0, '2017-10-10 21:58:09', 'complete'),
(409, 1048, 0, '65900.00', '65000.00', 'debit', 'withdraw_transfer', '900.00', 'bank', 0, '2017-10-10 21:58:09', 'complete'),
(410, 0, 1048, '74900.00', '74000.00', 'debit', 'cash_withdraw', '900.00', 'bank', 0, '2017-10-10 21:58:09', 'complete'),
(411, 1048, 1057, '65000.00', '62000.00', 'debit', 'credit_transfer', '3000.00', 'bank', 1048, '2017-10-10 23:39:33', 'complete'),
(412, 1057, 1048, '500.00', '3500.00', 'credit', 'credit_transfer', '3000.00', 'bank', 1048, '2017-10-10 23:39:33', 'complete'),
(413, 1048, 1055, '62000.00', '61970.00', 'debit', 'credit_transfer', '30.00', 'bank', 1048, '2017-10-15 00:08:50', 'complete'),
(414, 1055, 1048, '600.00', '630.00', 'credit', 'credit_transfer', '30.00', 'bank', 1048, '2017-10-15 00:08:50', 'complete'),
(415, 1048, 1058, '61970.00', '61870.00', 'debit', 'credit_transfer', '100.00', 'bank', 1048, '2017-10-27 16:54:22', 'complete'),
(416, 1058, 1048, '500.00', '600.00', 'credit', 'credit_transfer', '100.00', 'bank', 1048, '2017-10-27 16:54:22', 'complete'),
(417, 0, 0, '74000.00', '70000.00', 'debit', 'bank_withdrawl', '4000.00', 'bank', 1, '2017-10-29 13:35:25', 'complete'),
(418, 0, 0, '70000.00', '62079.00', 'debit', 'bank_withdrawl', '7921.00', 'bank', 1, '2017-10-29 19:54:59', 'complete'),
(419, 0, 0, '62079.00', '70000.00', 'credit', 'bank_deposit', '7921.00', 'bank', 1, '2017-10-29 19:56:18', 'complete'),
(420, 1048, 1055, '61870.00', '61800.00', 'debit', 'credit_transfer', '70.00', 'bank', 1048, '2017-11-30 13:14:33', 'complete'),
(421, 1055, 1048, '630.00', '700.00', 'credit', 'credit_transfer', '70.00', 'bank', 1048, '2017-11-30 13:14:33', 'complete'),
(422, 1048, 1061, '61800.00', '61700.00', 'debit', 'credit_transfer', '100.00', 'bank', 1048, '2017-11-30 13:58:58', 'complete'),
(423, 1061, 1048, '500.00', '600.00', 'credit', 'credit_transfer', '100.00', 'bank', 1048, '2017-11-30 13:58:58', 'complete'),
(424, 1061, 1048, '600.00', '500.00', 'debit', 'credit_transfer', '100.00', 'bank', 1061, '2017-11-30 14:02:23', 'complete'),
(425, 1048, 1061, '61700.00', '61800.00', 'credit', 'credit_transfer', '100.00', 'bank', 1061, '2017-11-30 14:02:23', 'complete'),
(426, 1055, 1048, '700.00', '600.00', 'debit', 'credit_transfer', '100.00', 'bank', 1055, '2017-12-24 04:46:46', 'complete'),
(427, 1048, 1055, '61800.00', '61900.00', 'credit', 'credit_transfer', '100.00', 'bank', 1055, '2017-12-24 04:46:46', 'complete'),
(428, 1048, 0, '61900.00', '61895.00', 'debit', 'lottery_ticket_purchase', '5.00', 'bank', 1048, '2018-01-16 21:21:28', 'complete'),
(429, 0, 1048, '70000.00', '70005.00', 'credit', 'lottery_ticket_purchase', '5.00', 'bank', 1048, '2018-01-16 21:21:28', 'complete'),
(430, 1048, 1055, '61895.00', '61795.00', 'debit', 'credit_transfer', '100.00', 'bank', 1048, '2018-01-16 21:23:12', 'complete'),
(431, 1055, 1048, '600.00', '700.00', 'credit', 'credit_transfer', '100.00', 'bank', 1048, '2018-01-16 21:23:12', 'complete'),
(432, 1048, 1055, '61795.00', '61695.00', 'debit', 'credit_transfer', '100.00', 'bank', 1048, '2018-02-23 21:56:30', 'complete'),
(433, 1055, 1048, '700.00', '800.00', 'credit', 'credit_transfer', '100.00', 'bank', 1048, '2018-02-23 21:56:30', 'complete'),
(434, 1048, 0, '61695.00', '61195.00', 'debit', 'lottery_ticket_purchase', '500.00', 'bank', 1048, '2018-03-22 23:03:06', 'complete'),
(435, 0, 1048, '70005.00', '70505.00', 'credit', 'lottery_ticket_purchase', '500.00', 'bank', 1048, '2018-03-22 23:03:06', 'complete'),
(436, 1055, 1048, '800.00', '700.00', 'debit', 'credit_transfer', '100.00', 'bank', 1055, '2018-04-17 22:57:29', 'complete'),
(437, 1048, 1055, '61195.00', '61295.00', 'credit', 'credit_transfer', '100.00', 'bank', 1055, '2018-04-17 22:57:29', 'complete'),
(438, 1055, 1048, '700.00', '600.00', 'debit', 'credit_transfer', '100.00', 'bank', 1055, '2018-04-17 23:00:07', 'complete'),
(439, 1048, 1055, '61295.00', '61395.00', 'credit', 'credit_transfer', '100.00', 'bank', 1055, '2018-04-17 23:00:07', 'complete'),
(440, 1048, 0, '61395.00', '61391.00', 'debit', 'lottery_ticket_purchase', '4.00', 'bank', 1048, '2018-04-23 23:18:06', 'complete'),
(441, 0, 1048, '70505.00', '70509.00', 'credit', 'lottery_ticket_purchase', '4.00', 'bank', 1048, '2018-04-23 23:18:06', 'complete'),
(442, 1048, 0, '61391.00', '61386.00', 'debit', 'lottery_ticket_purchase', '5.00', 'bank', 1048, '2018-04-23 23:29:14', 'complete'),
(443, 0, 1048, '70509.00', '70514.00', 'credit', 'lottery_ticket_purchase', '5.00', 'bank', 1048, '2018-04-23 23:29:14', 'complete'),
(444, 0, 1048, '70514.00', '70454.00', 'debit', 'ticket_win_amount', '60.00', 'bank', 1, '2018-04-23 23:59:23', 'complete'),
(445, 1048, 0, '61386.00', '61446.00', 'credit', 'ticket_win_amount', '60.00', 'bank', 1, '2018-04-23 23:59:23', 'complete');

-- --------------------------------------------------------

--
-- Table structure for table `user_admin`
--

CREATE TABLE IF NOT EXISTS `user_admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `status` text NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user_admin`
--

INSERT INTO `user_admin` (`admin_id`, `first_name`, `last_name`, `email`, `country_code`, `country_name`, `phone`, `password`, `email_verified`, `phone_verified`, `added_on`, `last_login`, `status`) VALUES
(1, '', '', 'pratikraj26@gmail.com', '', '', 0, '5f4dcc3b5aa765d61d8327deb882cf99', 0, 0, '2016-02-15 12:10:20', '0000-00-00 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_agent`
--

CREATE TABLE IF NOT EXISTS `user_agent` (
  `agent_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `agent_name` text NOT NULL,
  `agent_email` text NOT NULL,
  `password` text NOT NULL,
  `agent_phone` varchar(15) NOT NULL,
  `status` enum('Active','Inactive','','') NOT NULL,
  PRIMARY KEY (`agent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_bank`
--

CREATE TABLE IF NOT EXISTS `user_bank` (
  `bank_id` bigint(20) NOT NULL AUTO_INCREMENT,
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
  `status` text NOT NULL,
  PRIMARY KEY (`bank_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1000002 ;

--
-- Dumping data for table `user_bank`
--

INSERT INTO `user_bank` (`bank_id`, `bank_name`, `login_id`, `password`, `country_code`, `country_name`, `address`, `address_2`, `city`, `state`, `postal_code`, `landmark`, `token`, `profile_pic`, `date_time`, `status`) VALUES
(1000001, 'Test Bank, India', 'BNK-1000001', '5f4dcc3b5aa765d61d8327deb882cf99', '+91', 'India', 'Test Address', 'Test address 2', 'New Delhi', 'Delhi', '110059', 'Uttam Nagar Metro', NULL, '', '0000-00-00 00:00:00', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `login_id` text NOT NULL,
  `user_type` varchar(50) NOT NULL DEFAULT 'individual',
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `slug` text,
  `referral_id` text,
  `store_name` text NOT NULL,
  `email` text NOT NULL,
  `dob` text NOT NULL,
  `password` varchar(100) NOT NULL DEFAULT '5f4dcc3b5aa765d61d8327deb882cf99',
  `passcode` int(11) DEFAULT NULL,
  `email_verification` tinyint(1) NOT NULL,
  `new_email` text,
  `new_phone` text NOT NULL,
  `gender` text NOT NULL,
  `country_code` text NOT NULL,
  `country_name` text NOT NULL,
  `address` text NOT NULL,
  `address_2` text NOT NULL,
  `city` text NOT NULL,
  `state` text NOT NULL,
  `postal_code` text NOT NULL,
  `landmark` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `verification_code` int(4) NOT NULL,
  `temp_verification_code` int(4) DEFAULT NULL,
  `email_verified` varchar(5) NOT NULL DEFAULT 'no',
  `phone_verified` varchar(5) NOT NULL DEFAULT 'no',
  `added_by` text NOT NULL,
  `added_by_id` bigint(20) NOT NULL,
  `token` text,
  `profile_pic` text NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_locked` tinyint(1) NOT NULL DEFAULT '0',
  `status` text NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1069 ;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_id`, `login_id`, `user_type`, `first_name`, `last_name`, `slug`, `referral_id`, `store_name`, `email`, `dob`, `password`, `passcode`, `email_verification`, `new_email`, `new_phone`, `gender`, `country_code`, `country_name`, `address`, `address_2`, `city`, `state`, `postal_code`, `landmark`, `phone`, `verification_code`, `temp_verification_code`, `email_verified`, `phone_verified`, `added_by`, `added_by_id`, `token`, `profile_pic`, `date_time`, `is_locked`, `status`) VALUES
(0, '0', 'zippcash', 'Zipp', 'Cash', NULL, NULL, 'ZippCash', '', '', '', NULL, 0, NULL, '', '', '', '', '', '', '', '', '', '', '', 0, NULL, '', '', '', 0, NULL, '', '2016-02-14 10:04:44', 0, ''),
(1047, 'ZIPP1047', 'individual', 'Pratik', 'Raj', NULL, NULL, '', '', '1990-09-23', '5f4dcc3b5aa765d61d8327deb882cf99', 3223, 0, 'pratikraj26@gmail.com', '+918447227929', '', '+91', 'India', '', '', '', '', '', '', '+918447227929', 3852, 0, 'no', 'yes', '', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9pZCI6IlpJUFAxMDQ3IiwidXNlcl90eXBlIjoiaW5kaXZpZHVhbCJ9.cQP9rmiK8TuDiFvXdbdl-SdVB3tQfvVFAMLQwi8J6bo', '1498978498.jpg', '2018-01-04 16:43:21', 0, 'active'),
(1048, 'ZIPP1048', 'individual', 'Mitch', 'Brutus', NULL, NULL, '', '', '1986-01-26', '3c1241e080a60626aae7b50bb1473a9a', 2525, 0, NULL, '', '', '+1', 'United States', '', '', '', '', '', '', '+16179593646', 1111, 0, 'no', 'yes', '', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9pZCI6IlpJUFAxMDQ4IiwidXNlcl90eXBlIjoiaW5kaXZpZHVhbCJ9.DXIbppOGpfMGPZdcjocXNhVzd0ODU8btlE5CjjdqhMg', '', '2017-12-28 21:26:31', 0, 'active'),
(1049, 'ZIPP1049', 'individual', 'Mitch', 'Luv', NULL, NULL, '', '', '2017-07-02', '5f4dcc3b5aa765d61d8327deb882cf99', 3223, 0, NULL, '+918447227929', '', '+91', 'India', '', '', '', '', '', '', '+918447227929', 1111, 0, 'no', 'yes', '', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9pZCI6IlpJUFAxMDQ5IiwidXNlcl90eXBlIjoiaW5kaXZpZHVhbCJ9.srB3UFimzCzL-U9mzhqooesthqs-qKuHpeQcoPd23Is', '', '2017-09-30 14:29:55', 1, 'active'),
(1050, 'ZIPP1050', 'individual', 'Mitch', 'Brutus', NULL, NULL, '', '', '1986-01-23', '3c1241e080a60626aae7b50bb1473a9a', NULL, 0, NULL, '', '', '+1', 'United States', '', '', '', '', '', '', '+16179493646', 6946, NULL, 'no', 'no', '', 0, NULL, '', '2017-07-02 19:09:58', 0, 'active'),
(1051, 'ZIPP1051', 'individual', 'Miche', 'Brutus', NULL, NULL, '', '', '1981-09-07', '977b33ace8251dd9bee913e7ba56eebc', 4364, 0, NULL, '', '', '+1', 'United States', '', '', '', '', '', '', '+18573183463', 1111, NULL, 'no', 'yes', '', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9pZCI6IlpJUFAxMDUxIiwidXNlcl90eXBlIjoiaW5kaXZpZHVhbCJ9.pi9oymE_SoFPr8gdNsZAg0NAdpUTmw35kpW9QDJx6Q4', '', '2017-07-10 00:48:58', 0, 'active'),
(1052, 'ZIPP1052', 'individual', 'Merilus', 'Cassy', NULL, NULL, '', '', '2017-07-18', 'b337c590c7ee2e9f36d5672bce190d5e', 1995, 0, NULL, '', '', '+509', 'Haiti', '', '', '', '', '', '', '+50941662649', 1111, NULL, 'no', 'yes', '', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9pZCI6IlpJUFAxMDUyIiwidXNlcl90eXBlIjoiaW5kaXZpZHVhbCJ9.T-9okgFtscy_vpUgyO968TAIudHjcYe6o3rNZXsoUe8', '', '2018-04-17 22:44:29', 0, 'active'),
(1053, 'ZIPP1053', 'individual', 'Hirak', 'Jyoti', NULL, NULL, '', '', '1992-03-01', '25bbdcd06c32d477f7fa1c3e4a91b032', NULL, 0, NULL, '', '', '+1', 'United States', '', '', '', '', '', '', '+17002786971', 6576, NULL, 'no', 'no', '', 0, NULL, '', '2017-09-09 12:35:20', 0, 'active'),
(1054, 'ZIPP1054', 'individual', 'Hirak', 'Jyoti', NULL, NULL, '', '', '1992-03-01', '25bbdcd06c32d477f7fa1c3e4a91b032', NULL, 0, NULL, '', '', '+91', 'India', '', '', '', '', '', '', '+917002786971', 1111, NULL, 'no', 'yes', '', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9pZCI6IlpJUFAxMDU0IiwidXNlcl90eXBlIjoiaW5kaXZpZHVhbCJ9.VtnO7jZrWiC9Cl8fZvBhoNJSDF4WKO3bjas82lj75Jw', '', '2017-09-09 12:36:13', 0, 'active'),
(1055, 'ZIPP1055', 'individual', 'Lul', 'Brutus', NULL, NULL, '', '', '1988-10-09', '81dc9bdb52d04dc20036dbd8313ed055', 1234, 0, NULL, '', '', '+1', 'United States', '', '', '', '', '', '', '+16173906010', 1111, 0, 'no', 'yes', '', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9pZCI6IlpJUFAxMDU1IiwidXNlcl90eXBlIjoiaW5kaXZpZHVhbCJ9.xRtGJGyyApxRYZDwkP_SssNNissaxjg-wZ9EpMrg090', '1507596845.jpg', '2018-04-17 22:56:31', 0, 'active'),
(1056, 'ZIPP1056', 'individual', 'Misholkin', 'Brutus', NULL, NULL, '', '', '1989-11-13', '7ebacdc461799d2e6617cc88871bce84', 1389, 0, NULL, '', '', '+1', 'United States', '', '', '', '', '', '', '+17815103614', 1111, NULL, 'no', 'yes', '', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9pZCI6IlpJUFAxMDU2IiwidXNlcl90eXBlIjoiaW5kaXZpZHVhbCJ9.fCquqpxYksInlFogAaNGGeO_nNGZb4E-ExH1uEDUXqA', '', '2017-10-09 17:46:56', 0, 'active'),
(1057, 'ZIPP1057', 'individual', 'Pecky', 'Celestin', NULL, NULL, '', '', '1983-04-26', '7d2b92b6726c241134dae6cd3fb8c182', 1975, 0, NULL, '', '', '+509', 'Haiti', '', '', '', '', '', '', '+50938541351', 1111, 0, 'no', 'yes', '', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9pZCI6IlpJUFAxMDU3IiwidXNlcl90eXBlIjoiaW5kaXZpZHVhbCJ9.qAZuvyRLF07ELdHMV0LG-O5Av5yHZVgIRWyLp3ChrcU', '', '2018-04-17 22:44:20', 0, 'active'),
(1058, 'ZIPP1058', 'individual', 'Cherline', 'Vernet', NULL, NULL, '', '', '1985-09-15', '34af41b593ce0c112bb54547a96fa12c', 8886, 0, NULL, '', '', '+1', 'United States', '', '', '', '', '', '', '+18572512817', 1111, 0, 'no', 'yes', '', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9pZCI6IlpJUFAxMDU4IiwidXNlcl90eXBlIjoiaW5kaXZpZHVhbCJ9.8M9uC_JuBlV0Sbo_DTjliMolmkIbg0bCQRDikSSSu4o', '', '2017-10-29 22:19:59', 0, 'active'),
(1059, 'ZIPP1059', 'individual', 'Lul', 'Brutus', NULL, NULL, '', '', '1988-01-01', '3c1241e080a60626aae7b50bb1473a9a', NULL, 0, NULL, '', '', '+1', 'United States', '', '', '', '', '', '', '+16173906810', 1568, NULL, 'no', 'no', '', 0, NULL, '', '2017-12-28 21:24:17', 0, 'active'),
(1060, 'ZIPP1060', 'individual', 'Mel', 'Yeah', NULL, NULL, '', '', '2017-11-14', '80db5f8614aded76026852f6d1ca1847', NULL, 0, NULL, '', '', '+1', 'United States', '', '', '', '', '', '', '+13158643525', 3866, NULL, 'no', 'no', '', 0, NULL, '', '2017-11-15 00:47:33', 0, 'active'),
(1061, 'ZIPP1061', 'individual', 'Cisco', 'Pierre', NULL, NULL, '', '', '1984-04-21', '960a732799af0ad837587b0311aec874', 4040, 0, NULL, '', '', '+1', 'United States', '', '', '', '', '', '', '+16178493877', 1111, NULL, 'no', 'yes', '', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9pZCI6IlpJUFAxMDYxIiwidXNlcl90eXBlIjoiaW5kaXZpZHVhbCJ9.jTRLUQBBTOIRwWLl1SEM5OQuaCqB2EQbcjF5Oraqdjc', '', '2018-04-17 22:45:13', 0, 'blocked'),
(1062, 'ZIPP1062', 'individual', 'Rahul', 'Sharma', NULL, NULL, '', '', '2017-12-22', '5f4dcc3b5aa765d61d8327deb882cf99', 3223, 0, NULL, '', '', '+1', 'United States', '', '', '', '', '', '', '+17896541236', 1111, NULL, 'no', 'yes', '', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9pZCI6IlpJUFAxMDYyIiwidXNlcl90eXBlIjoiaW5kaXZpZHVhbCJ9.iZY2jOzVbEG0y4PuC_BUT2ujSLro-JQMohKmBoctXEk', '', '2017-12-23 09:05:49', 0, 'active'),
(1063, 'ZIPP1063', 'individual', 'aaa', 'aaa', NULL, NULL, '', '', '2017-12-27', '5f4dcc3b5aa765d61d8327deb882cf99', 3223, 0, NULL, '', '', '+1', 'United States', '', '', '', '', '', '', '+17896541233', 1111, NULL, 'no', 'yes', '', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9pZCI6IlpJUFAxMDYzIiwidXNlcl90eXBlIjoiaW5kaXZpZHVhbCJ9.CHBLuTC7-fYvaMZbRP25mdurSUqZMzzDYLfCgT0WqvU', '', '2018-04-17 22:44:57', 0, 'active'),
(1065, 'ZIPP1065', 'individual', 'ababa', 'bababa', 'ababa1', NULL, '', '', '2017-12-27', '5f4dcc3b5aa765d61d8327deb882cf99', 1112, 0, NULL, '', '', '+1', 'United States', '', '', '', '', '', '', '+11236547895', 1111, NULL, 'no', 'yes', '', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9pZCI6IlpJUFAxMDY1IiwidXNlcl90eXBlIjoiaW5kaXZpZHVhbCJ9.zQ1cyrSPGRbjmgofxuYE305AyfXtk4Tmc5BvGDgkhso', '', '2018-04-17 22:44:47', 0, 'active'),
(1066, 'ZIPP1066', 'individual', 'Condrea', 'Constantin', 'condrea1', NULL, '', '', '1980-05-23', '7a63536ef4c4232357bd334e606e3663', 1980, 0, NULL, '', '', '+40', 'Romania', '', '', '', '', '', '', '+40755916123', 1111, NULL, 'no', 'yes', '', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9pZCI6IlpJUFAxMDY2IiwidXNlcl90eXBlIjoiaW5kaXZpZHVhbCJ9.uQpq-jWw4wNAEtBoMDir6vV580ifYpCxDRFhpMnyQSA', '', '2018-01-31 05:11:57', 0, 'active'),
(1067, 'ZIPP1067', 'individual', 'sateesh', 'Lingam', 'sateesh1', NULL, '', '', '2018-02-25', '48feaa1f53feae66a08a5cbc9d4eeca3', 8888, 0, NULL, '', '', '+91', 'India', '', '', '', '', '', '', '+918886029888', 1111, NULL, 'no', 'yes', '', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9pZCI6IlpJUFAxMDY3IiwidXNlcl90eXBlIjoiaW5kaXZpZHVhbCJ9.55EFxIXSTNkk88yZewwSeawRtQ3LCQ7XV7P_CcUsySI', '', '2018-02-16 13:39:06', 0, 'active'),
(1068, 'ZIPP1068', 'individual', 'P. Milo', 'Jannini', 'p.-milo1', NULL, '', '', '2018-03-10', '8bbf7f8df56f8dd17263898c63e85d10', 2234, 0, NULL, '', '', '+1', 'United States', '', '', '', '', '', '', '+15082030511', 1111, NULL, 'no', 'yes', '', 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJsb2dpbl9pZCI6IlpJUFAxMDY4IiwidXNlcl90eXBlIjoiaW5kaXZpZHVhbCJ9.dOkr5UThm5ijmpNuBj2NNzaFTqWHtLrBWArc15ki3T0', '', '2018-04-17 22:44:35', 0, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `user_messages`
--

CREATE TABLE IF NOT EXISTS `user_messages` (
  `message_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `to_user_id` bigint(20) NOT NULL,
  `from_user_id` bigint(20) NOT NULL,
  `message_body` text NOT NULL,
  `status` tinytext NOT NULL,
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=76 ;

--
-- Dumping data for table `user_messages`
--

INSERT INTO `user_messages` (`message_id`, `to_user_id`, `from_user_id`, `message_body`, `status`, `datetime`) VALUES
(16, 1047, 0, 'Hello everyone!', 'read', '2018-01-16 16:57:08'),
(17, 1048, 0, 'Hello everyone!', 'read', '2018-01-16 16:57:08'),
(18, 1049, 0, 'Hello everyone!', 'unread', '2018-01-16 16:57:08'),
(19, 1050, 0, 'Hello everyone!', 'unread', '2018-01-16 16:57:08'),
(20, 1051, 0, 'Hello everyone!', 'unread', '2018-01-16 16:57:08'),
(21, 1052, 0, 'Hello everyone!', 'unread', '2018-01-16 16:57:08'),
(22, 1053, 0, 'Hello everyone!', 'unread', '2018-01-16 16:57:08'),
(23, 1054, 0, 'Hello everyone!', 'unread', '2018-01-16 16:57:08'),
(24, 1055, 0, 'Hello everyone!', 'unread', '2018-01-16 16:57:08'),
(25, 1056, 0, 'Hello everyone!', 'unread', '2018-01-16 16:57:08'),
(26, 1057, 0, 'Hello everyone!', 'unread', '2018-01-16 16:57:08'),
(27, 1058, 0, 'Hello everyone!', 'unread', '2018-01-16 16:57:08'),
(28, 1059, 0, 'Hello everyone!', 'unread', '2018-01-16 16:57:08'),
(29, 1060, 0, 'Hello everyone!', 'unread', '2018-01-16 16:57:08'),
(30, 1061, 0, 'Hello everyone!', 'unread', '2018-01-16 16:57:08'),
(31, 1062, 0, 'Hello everyone!', 'unread', '2018-01-16 16:57:08'),
(32, 1063, 0, 'Hello everyone!', 'unread', '2018-01-16 16:57:08'),
(33, 1065, 0, 'Hello everyone!', 'unread', '2018-01-16 16:57:08'),
(34, 1047, 0, 'sakapfet Michelove', 'read', '2018-03-22 22:55:42'),
(35, 1048, 0, 'sakapfet Michelove', 'read', '2018-03-22 22:55:42'),
(36, 1049, 0, 'sakapfet Michelove', 'unread', '2018-03-22 22:55:42'),
(37, 1050, 0, 'sakapfet Michelove', 'unread', '2018-03-22 22:55:42'),
(38, 1051, 0, 'sakapfet Michelove', 'unread', '2018-03-22 22:55:42'),
(39, 1052, 0, 'sakapfet Michelove', 'unread', '2018-03-22 22:55:42'),
(40, 1053, 0, 'sakapfet Michelove', 'unread', '2018-03-22 22:55:42'),
(41, 1054, 0, 'sakapfet Michelove', 'unread', '2018-03-22 22:55:42'),
(42, 1055, 0, 'sakapfet Michelove', 'unread', '2018-03-22 22:55:42'),
(43, 1056, 0, 'sakapfet Michelove', 'unread', '2018-03-22 22:55:42'),
(44, 1057, 0, 'sakapfet Michelove', 'unread', '2018-03-22 22:55:42'),
(45, 1058, 0, 'sakapfet Michelove', 'unread', '2018-03-22 22:55:42'),
(46, 1059, 0, 'sakapfet Michelove', 'unread', '2018-03-22 22:55:42'),
(47, 1060, 0, 'sakapfet Michelove', 'unread', '2018-03-22 22:55:42'),
(48, 1061, 0, 'sakapfet Michelove', 'unread', '2018-03-22 22:55:42'),
(49, 1062, 0, 'sakapfet Michelove', 'unread', '2018-03-22 22:55:42'),
(50, 1063, 0, 'sakapfet Michelove', 'unread', '2018-03-22 22:55:42'),
(51, 1065, 0, 'sakapfet Michelove', 'unread', '2018-03-22 22:55:42'),
(52, 1066, 0, 'sakapfet Michelove', 'unread', '2018-03-22 22:55:42'),
(53, 1067, 0, 'sakapfet Michelove', 'unread', '2018-03-22 22:55:42'),
(54, 1068, 0, 'sakapfet Michelove', 'unread', '2018-03-22 22:55:42'),
(55, 1047, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'read', '2018-04-24 00:02:09'),
(56, 1048, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'read', '2018-04-24 00:02:09'),
(57, 1049, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'unread', '2018-04-24 00:02:09'),
(58, 1050, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'unread', '2018-04-24 00:02:09'),
(59, 1051, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'unread', '2018-04-24 00:02:09'),
(60, 1052, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'unread', '2018-04-24 00:02:09'),
(61, 1053, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'unread', '2018-04-24 00:02:09'),
(62, 1054, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'unread', '2018-04-24 00:02:09'),
(63, 1055, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'unread', '2018-04-24 00:02:09'),
(64, 1056, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'unread', '2018-04-24 00:02:09'),
(65, 1057, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'unread', '2018-04-24 00:02:09'),
(66, 1058, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'unread', '2018-04-24 00:02:09'),
(67, 1059, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'unread', '2018-04-24 00:02:09'),
(68, 1060, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'unread', '2018-04-24 00:02:09'),
(69, 1061, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'unread', '2018-04-24 00:02:09'),
(70, 1062, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'unread', '2018-04-24 00:02:09'),
(71, 1063, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'unread', '2018-04-24 00:02:09'),
(72, 1065, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'unread', '2018-04-24 00:02:09'),
(73, 1066, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'unread', '2018-04-24 00:02:09'),
(74, 1067, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'unread', '2018-04-24 00:02:09'),
(75, 1068, 0, 'koman nou ye la. ZippCash gen gro sipriz pou nou.', 'unread', '2018-04-24 00:02:09');

-- --------------------------------------------------------

--
-- Table structure for table `user_ticket`
--

CREATE TABLE IF NOT EXISTS `user_ticket` (
  `ticket_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `lottery_id` bigint(20) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `paid_amount` decimal(10,2) NOT NULL,
  `win_amount` decimal(10,2) DEFAULT NULL,
  `purchased_on` datetime NOT NULL,
  `purchased_by` text NOT NULL,
  `purchased_by_id` bigint(20) NOT NULL,
  `paid_on` datetime NOT NULL,
  `payment_status` text,
  `payment_transaction_id` bigint(20) DEFAULT NULL,
  `payment_sent_status` text,
  `payment_sent_transaction_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`ticket_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `user_ticket`
--

INSERT INTO `user_ticket` (`ticket_id`, `user_id`, `lottery_id`, `total_amount`, `paid_amount`, `win_amount`, `purchased_on`, `purchased_by`, `purchased_by_id`, `paid_on`, `payment_status`, `payment_transaction_id`, `payment_sent_status`, `payment_sent_transaction_id`) VALUES
(47, 1048, 37, '60.00', '0.00', '0.00', '2017-07-16 12:16:52', 'user', 1048, '2017-07-16 12:16:52', 'paid', NULL, 'sent', NULL),
(48, 1048, 40, '4.00', '0.00', '0.00', '2017-07-20 07:13:22', 'user', 1048, '2017-07-20 07:13:22', 'paid', NULL, 'sent', NULL),
(49, 1048, 42, '15.00', '0.00', '0.00', '2017-07-21 10:20:10', 'user', 1048, '2017-07-21 10:20:10', 'paid', NULL, 'sent', NULL),
(50, 1048, 63, '5.00', '0.00', '0.00', '2018-01-16 16:21:28', 'user', 1048, '2018-01-16 16:21:28', 'paid', NULL, 'sent', NULL),
(51, 1048, 64, '500.00', '0.00', '0.00', '2018-03-22 19:03:06', 'user', 1048, '2018-03-22 19:03:06', 'paid', NULL, 'sent', NULL),
(52, 1048, 66, '4.00', '0.00', '60.00', '2018-04-23 19:18:06', 'user', 1048, '2018-04-23 19:18:06', 'paid', NULL, 'sent', NULL),
(53, 1048, 66, '5.00', '0.00', '0.00', '2018-04-23 19:29:14', 'user', 1048, '2018-04-23 19:29:14', 'paid', NULL, 'sent', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_wallet`
--

CREATE TABLE IF NOT EXISTS `user_wallet` (
  `wallet_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `available_balance` decimal(10,2) NOT NULL DEFAULT '0.00',
  `wallet_type` text NOT NULL,
  `wallet_status` text NOT NULL,
  PRIMARY KEY (`wallet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=61 ;

--
-- Dumping data for table `user_wallet`
--

INSERT INTO `user_wallet` (`wallet_id`, `user_id`, `available_balance`, `wallet_type`, `wallet_status`) VALUES
(1, 0, '70454.00', 'Premium', 'Active'),
(35, 1043, '795.00', 'Free', 'Active'),
(36, 1044, '4713.00', 'Free', 'Active'),
(37, 1045, '790.00', 'Free', 'Active'),
(38, 1046, '500.00', 'Free', 'Active'),
(39, 1047, '500.00', 'Free', 'Active'),
(40, 1048, '61446.00', 'Free', 'Active'),
(41, 1049, '500.00', 'Free', 'Active'),
(42, 1050, '500.00', 'Free', 'Active'),
(43, 1051, '523.00', 'Free', 'Active'),
(44, 1052, '500.00', 'Free', 'Active'),
(45, 1053, '500.00', 'Free', 'Active'),
(46, 1054, '500.00', 'Free', 'Active'),
(47, 1055, '600.00', 'Free', 'Active'),
(48, 1056, '500.00', 'Free', 'Active'),
(49, 1057, '3500.00', 'Free', 'Active'),
(50, 1058, '600.00', 'Free', 'Active'),
(51, 1059, '500.00', 'Free', 'Active'),
(52, 1060, '500.00', 'Free', 'Active'),
(53, 1061, '500.00', 'Free', 'Active'),
(54, 1062, '500.00', 'Free', 'Active'),
(55, 1063, '500.00', 'Free', 'Active'),
(56, 1064, '500.00', 'Free', 'Active'),
(57, 1065, '500.00', 'Free', 'Active'),
(58, 1066, '0.00', 'Free', 'Active'),
(59, 1067, '0.00', 'Free', 'Active'),
(60, 1068, '0.00', 'Free', 'Active');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
