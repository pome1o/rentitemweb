-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- 主機: 127.0.0.1
-- 產生時間： 2018-02-07 12:20:52
-- 伺服器版本: 10.1.21-MariaDB
-- PHP 版本： 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `borrow`
--
CREATE DATABASE IF NOT EXISTS `borrow` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `borrow`;

-- --------------------------------------------------------

--
-- 資料表結構 `ban_record`
--

CREATE TABLE `ban_record` (
  `studentID` varchar(20) NOT NULL,
  `violation_id` int(11) NOT NULL,
  `ban_date_from` datetime NOT NULL,
  `ban_date_to` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 資料表結構 `borowperson`
--

CREATE TABLE `borowperson` (
  `_id` int(11) NOT NULL,
  `personName` varchar(10) NOT NULL,
  `studentID` varchar(20) NOT NULL,
  `itemNo` varchar(30) NOT NULL,
  `note` varchar(100) NOT NULL,
  `lendTime` datetime DEFAULT NULL,
  `lend_manager` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `returnTime` datetime NOT NULL,
  `return_manager` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `borowperson`
--

INSERT INTO `borowperson` (`_id`, `personName`, `studentID`, `itemNo`, `note`, `lendTime`, `lend_manager`, `returnTime`, `return_manager`, `status`) VALUES
(106, '李旻祐', '103111123', 'A100', '', '2017-04-06 19:32:31', '', '2017-06-09 19:46:16', '', 0),
(107, '李旻祐', '103111123', '51701', '', '2018-01-01 19:35:31', '', '2017-06-09 19:46:16', '', 0),
(108, '高育正', '103111104', 'A104', '', '2017-04-07 11:02:48', '', '2017-06-09 19:46:16', '', 0),
(109, '李旻祐', '103111123', 'A107', '', '2017-04-06 20:31:01', '', '2017-06-09 19:46:16', '', 0),
(110, '李旻祐', '103111123', 'A100', '', '2017-04-06 20:39:13', '', '2017-06-09 19:46:16', '', 0),
(111, '李旻祐', '103111123', '51700', '', '2017-04-06 20:40:44', '', '2017-06-13 15:18:41', '', 0),
(112, '李旻祐', '103111123', '51700', '', '2017-04-06 20:41:14', '', '2017-06-13 15:18:41', '', 0),
(113, '李旻祐', '103111123', 'A105', '', '2017-04-06 20:41:21', '', '2017-06-09 19:46:16', '', 0),
(114, '李旻祐', '103111123', 'A101', '', '2017-04-06 21:02:36', '', '2017-06-09 19:46:16', '', 0),
(115, '李旻祐', '103111123', 'A103', '', '2017-04-06 21:02:41', '', '2017-06-09 19:46:16', '', 0),
(116, '高育正', '103111104', 'A106', '', '2017-04-07 11:04:12', '', '2017-06-09 19:46:16', '', 0),
(117, '高育正', '103111104', '51701', '', '2017-04-07 11:04:16', '', '2017-06-09 19:46:16', '', 0),
(118, '高育正', '103111104', '51703', '', '2017-04-07 11:04:21', '', '2017-06-09 19:46:16', '', 0),
(119, '高育正', '103111104', '51710', '', '2017-04-07 11:04:25', '', '2017-06-09 19:46:16', '', 0),
(120, '李旻祐', '103111123', '51700', '', '2017-05-07 00:47:52', '', '2017-06-13 15:18:41', '', 0),
(121, '李旻祐', '103111123', 'A100', '', '2017-05-07 00:47:59', '', '2017-06-09 19:46:16', '', 0),
(122, '高育正', '103111104', 'A100', '', '2017-05-07 00:56:14', '', '2017-06-09 19:46:16', '', 0),
(123, '李旻祐', '103111123', 'A100', '', '2017-06-08 15:52:24', '', '2017-06-09 19:46:16', '', 0),
(124, '高育正', '103111104', '51700', '', '2017-05-07 00:57:27', '', '2017-06-13 15:18:41', '', 0),
(125, '高育正', '103111104', '7878', '', '2017-05-07 11:26:32', '', '2017-06-09 19:46:16', '', 0),
(126, '李旻祐', '103111123', 'A100', '', '2017-06-08 15:52:24', '', '2017-06-09 19:46:16', '', 0),
(127, '高育正', '103111104', '51700', '', '2017-06-13 11:10:14', '', '2017-06-13 15:18:41', '', 0),
(128, 'test1', '111', '12', '', '2017-06-13 15:18:32', '', '2017-06-13 15:18:41', '', 0),
(129, 'test1', '111', 'A100', '', '2017-06-13 22:15:56', '', '2017-06-13 22:16:16', '', 0),
(130, 'test1', '111', '51700', '', '2017-06-14 09:01:26', '', '2017-06-14 09:15:29', '', 0),
(131, 'test1', '111', 'A100', '', '2017-06-14 09:01:30', '', '2017-06-14 09:15:29', '', 0),
(132, 'test1', '111', 'A100', '', '2017-06-14 09:28:37', '', '2017-06-14 09:28:51', '', 0),
(133, 'test1', '111', 'A100', '', '2017-06-14 11:46:58', '', '2017-06-14 11:47:03', '', 0),
(134, 'test1', '111', '何', '', '2017-06-14 22:22:01', '', '2017-06-14 22:22:29', '', 0),
(135, 'test1', '111', '袁', '', '2017-06-14 22:22:05', '', '2017-06-14 22:22:29', '', 0),
(136, 'test1', '111', 'A100', '', '2017-06-14 22:22:52', '', '2017-06-14 22:23:20', '', 0),
(137, 'test1', '111', '51700', '', '2017-06-14 22:22:56', '', '2017-06-14 22:23:20', '', 0),
(138, 'test1', '111', 'A100', '', '2017-06-14 22:27:01', '', '2017-06-14 22:27:22', '', 0),
(139, 'test1', '111', 'A100', '', '2017-06-18 15:39:39', '', '2017-06-18 17:18:56', '', 0),
(140, 'test1', '111', 'A101', '', '2017-06-18 17:18:35', '', '2017-06-18 17:19:11', '', 0),
(141, '王堉宸', '103111120', 'A101', '123', '2018-01-24 17:21:19', '104111123', '2018-01-24 17:45:33', '104111123', 0),
(142, '王堉宸', '101111120', 'A102', '8888', '2018-01-25 14:49:24', 'f0987', '2018-01-25 14:49:39', 'f0987', 0),
(143, '王堉宸', '102111120', '3140101-0311543', '', '2018-01-25 15:26:54', 'f0987', '2018-01-25 15:27:29', 'f0987', 0),
(144, '654', '104111123', 'A107', '', '2018-01-30 13:23:15', '8787', '2018-01-30 13:23:28', '8787', 0),
(145, '李', '104111123', 'A106', '', NULL, '', '2018-02-01 14:35:44', '', -2);

-- --------------------------------------------------------

--
-- 資料表結構 `borrowlab`
--

CREATE TABLE `borrowlab` (
  `_id` int(11) NOT NULL,
  `personName` varchar(10) CHARACTER SET utf8 NOT NULL,
  `studentID` varchar(20) CHARACTER SET utf8 NOT NULL,
  `lab_num` varchar(10) CHARACTER SET utf8 DEFAULT NULL,
  `seat_num` varchar(20) CHARACTER SET utf8 NOT NULL,
  `lendTime` datetime DEFAULT NULL,
  `lend_manager` varchar(30) CHARACTER SET utf8 NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `returnTime` datetime NOT NULL,
  `return_manager` varchar(30) CHARACTER SET utf8 NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `borrowlab`
--

INSERT INTO `borrowlab` (`_id`, `personName`, `studentID`, `lab_num`, `seat_num`, `lendTime`, `lend_manager`, `start_time`, `end_time`, `returnTime`, `return_manager`, `status`) VALUES
(19, '王堉宸', '101111120', '20804', '討論1', '2018-01-25 14:49:24', 'f0987', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2018-01-25 14:49:39', 'f0987', 0),
(23, '王堉宸', '103111120', '20806', 'Meeting', '2018-01-30 12:31:33', '104111123', '2018-01-30 09:00:00', '2018-01-30 10:00:00', '2018-01-30 12:31:58', '104111123', 0),
(24, '李', '104111123', '20806', 'Meeting', '2018-01-30 13:14:35', '8787', '2018-01-30 09:00:00', '2018-01-30 10:00:00', '2018-01-30 13:15:25', '8787', 0),
(25, '李', '104111123', '20806', 'Meeting', '2018-01-30 13:52:24', '8787', '2018-01-30 14:00:00', '2018-01-30 15:00:00', '2018-01-30 13:52:42', '8787', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `borrowroom`
--

CREATE TABLE `borrowroom` (
  `_id` int(11) NOT NULL,
  `studentID` varchar(20) NOT NULL,
  `personName` varchar(10) NOT NULL,
  `period` int(10) NOT NULL,
  `week` int(2) NOT NULL,
  `room_no` varchar(10) NOT NULL,
  `lendTime` datetime NOT NULL,
  `lend_manager` varchar(20) NOT NULL,
  `returnTime` datetime NOT NULL,
  `return_manager` varchar(20) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `borrowroom`
--

INSERT INTO `borrowroom` (`_id`, `studentID`, `personName`, `period`, `week`, `room_no`, `lendTime`, `lend_manager`, `returnTime`, `return_manager`, `status`) VALUES
(1, '103111120', '王堉宸', 1, 2, '30801', '2018-01-30 11:38:07', '104111123', '2018-01-30 11:40:16', '104111123', 0),
(2, '103111120', '王堉宸', 2, 2, '30801', '2018-01-30 11:39:59', '104111123', '2018-01-30 11:40:16', '104111123', 0),
(3, '103111120', '王堉宸', 1, 2, '30801', '2018-01-30 11:38:07', '104111123', '2018-01-30 11:40:17', '104111123', 0),
(4, '103111120', '王堉宸', 2, 2, '30801', '2018-01-30 11:39:59', '104111123', '2018-01-30 11:40:17', '104111123', 0),
(5, '103111120', '王堉宸', 1, 2, '30801', '2018-01-30 11:38:07', '104111123', '2018-01-30 11:40:35', '104111123', 0),
(6, '103111120', '王堉宸', 2, 2, '30801', '2018-01-30 11:39:59', '104111123', '2018-01-30 11:40:35', '104111123', 0),
(7, '103111120', '王堉宸', 1, 2, '30801', '2018-01-30 11:38:07', '104111123', '2018-01-30 11:44:38', '104111123', 0),
(8, '103111120', '王堉宸', 2, 2, '30801', '2018-01-30 11:39:59', '104111123', '2018-01-30 11:44:38', '104111123', 0),
(9, '8787', '654', 1, 4, '30801', '2018-01-24 17:25:12', '103111120', '2018-01-30 11:49:11', '104111123', 0),
(10, '8787', '王', 1, 2, '30801', '0000-00-00 00:00:00', '', '0000-00-00 00:00:00', '', -2);

-- --------------------------------------------------------

--
-- 資料表結構 `borrow_note`
--

CREATE TABLE `borrow_note` (
  `category` int(11) NOT NULL,
  `other` int(11) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `borrow_note`
--

INSERT INTO `borrow_note` (`category`, `other`, `content`) VALUES
(1, 0, 'asdasd'),
(1, 1, 'vvvvv');

-- --------------------------------------------------------

--
-- 資料表結構 `classperiod`
--

CREATE TABLE `classperiod` (
  `room` varchar(10) NOT NULL,
  `period` int(2) NOT NULL,
  `Mon` int(1) NOT NULL,
  `Tue` int(1) NOT NULL,
  `Wed` int(1) NOT NULL,
  `Thu` int(1) NOT NULL,
  `Fri` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `classperiod`
--

INSERT INTO `classperiod` (`room`, `period`, `Mon`, `Tue`, `Wed`, `Thu`, `Fri`) VALUES
('30801', 1, 0, 0, 0, 0, 0),
('30801', 2, 2, 2, 2, 2, 2),
('30801', 3, 2, 2, 2, 2, 2),
('30801', 4, 2, 2, 2, 2, 2),
('30801', 5, 2, 2, 0, 2, 2),
('30801', 6, 2, 2, 0, 2, 2),
('30801', 7, 2, 2, 0, 2, 2),
('30801', 8, 0, 0, 0, 0, 0),
('30802', 1, 0, 0, 0, 2, 0),
('30802', 2, 2, 2, 2, 2, 2),
('30802', 3, 2, 2, 2, 0, 2),
('30802', 4, 2, 2, 2, 0, 2),
('30802', 5, 2, 0, 0, 2, 2),
('30802', 6, 2, 0, 0, 2, 2),
('30802', 7, 2, 2, 0, 2, 2),
('30802', 8, 0, 2, 0, 2, 2),
('30803', 1, 0, 0, 0, 2, 2),
('30803', 2, 2, 2, 2, 2, 2),
('30803', 3, 2, 2, 2, 2, 2),
('30803', 4, 2, 2, 2, 2, 2),
('30803', 5, 2, 2, 0, 2, 2),
('30803', 6, 2, 2, 0, 2, 2),
('30803', 7, 2, 2, 0, 2, 2),
('30803', 8, 2, 2, 0, 2, 0),
('30804', 1, 0, 2, 2, 0, 2),
('30804', 2, 0, 2, 0, 0, 2),
('30804', 3, 0, 2, 0, 0, 0),
('30804', 4, 0, 0, 0, 0, 2),
('30804', 5, 0, 2, 2, 2, 0),
('30804', 6, 0, 2, 2, 2, 0),
('30804', 7, 0, 2, 2, 2, 2),
('30804', 8, 0, 0, 0, 0, 0),
('30805', 1, 0, 2, 0, 2, 0),
('30805', 2, 0, 2, 0, 2, 0),
('30805', 3, 0, 2, 0, 2, 0),
('30805', 4, 0, 2, 0, 2, 0),
('30805', 5, 0, 2, 0, 2, 0),
('30805', 6, 0, 2, 0, 2, 0),
('30805', 7, 0, 2, 0, 2, 0),
('30805', 8, 0, 2, 0, 2, 0),
('30806', 1, 2, 0, 2, 0, 2),
('30806', 2, 2, 0, 0, 0, 2),
('30806', 3, 2, 0, 2, 0, 2),
('30806', 4, 2, 0, 0, 0, 2),
('30806', 5, 2, 0, 2, 0, 2),
('30806', 6, 2, 0, 2, 0, 2),
('30806', 7, 2, 0, 0, 0, 2),
('30806', 8, 2, 0, 0, 0, 2),
('gg', 1, 2, 2, 2, 2, 2),
('gg', 2, 2, 2, 2, 2, 2),
('gg', 3, 0, 0, 0, 0, 0),
('gg', 4, 2, 2, 2, 2, 2),
('gg', 5, 2, 2, 2, 2, 2),
('gg', 6, 0, 0, 0, 0, 0),
('gg', 7, 0, 0, 0, 0, 0),
('gg', 8, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `classperiod1`
--

CREATE TABLE `classperiod1` (
  `room_no` varchar(10) NOT NULL,
  `period` int(2) NOT NULL,
  `day` int(2) NOT NULL,
  `class_name` varchar(20) DEFAULT NULL,
  `open_off` int(2) NOT NULL DEFAULT '0',
  `off_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `classperiod1`
--

INSERT INTO `classperiod1` (`room_no`, `period`, `day`, `class_name`, `open_off`, `off_time`) VALUES
('30801', 1, 1, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 1, 2, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 1, 3, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 1, 4, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 1, 5, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 2, 1, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 2, 2, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 2, 3, '*LINUX作業系統\n2B\n陳東?', 0, '0000-00-00 00:00:00'),
('30801', 2, 4, '*決策分析與應用\n3B\n邱天嵩', 0, '0000-00-00 00:00:00'),
('30801', 2, 5, '*進階Python程式設計\n2B\n陳鵬文', 0, '0000-00-00 00:00:00'),
('30801', 3, 1, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 3, 2, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 3, 3, '*LINUX作業系統\n2B\n陳東?', 0, '0000-00-00 00:00:00'),
('30801', 3, 4, '*決策分析與應用\n3B\n邱天嵩', 0, '0000-00-00 00:00:00'),
('30801', 3, 5, '*進階Python程式設計\n2B\n陳鵬文', 0, '0000-00-00 00:00:00'),
('30801', 4, 1, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 4, 2, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 4, 3, '*LINUX作業系統\n2B\n陳東?', 0, '0000-00-00 00:00:00'),
('30801', 4, 4, '*決策分析與應用\n3B\n邱天嵩', 0, '0000-00-00 00:00:00'),
('30801', 4, 5, '*進階Python程式設計\n2B\n陳鵬文', 0, '0000-00-00 00:00:00'),
('30801', 5, 1, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 5, 2, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 5, 3, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 5, 4, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 5, 5, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 6, 1, '數位繪圖設計\n蔡文隆\n1B', 0, '0000-00-00 00:00:00'),
('30801', 6, 2, '數位繪圖設計\n蔡文隆\n1A', 0, '0000-00-00 00:00:00'),
('30801', 6, 3, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 6, 4, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 6, 5, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 7, 1, '數位繪圖設計\n蔡文隆\n1B', 0, '0000-00-00 00:00:00'),
('30801', 7, 2, '數位繪圖設計\n蔡文隆\n1A', 0, '0000-00-00 00:00:00'),
('30801', 7, 3, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 7, 4, '*企業資源規劃\n賴鍵元\n2A', 0, '0000-00-00 00:00:00'),
('30801', 7, 5, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 8, 1, '數位繪圖設計\n蔡文隆\n1B', 0, '0000-00-00 00:00:00'),
('30801', 8, 2, '數位繪圖設計\n蔡文隆\n1A', 0, '0000-00-00 00:00:00'),
('30801', 8, 3, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 8, 4, '*企業資源規劃\n賴鍵元\n2A', 0, '0000-00-00 00:00:00'),
('30801', 8, 5, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 9, 1, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 9, 2, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 9, 3, 'no_class', 0, '0000-00-00 00:00:00'),
('30801', 9, 4, '*企業資源規劃\n賴鍵元\n2A', 0, '0000-00-00 00:00:00'),
('30801', 9, 5, 'no_class', 0, '0000-00-00 00:00:00'),
('30802', 1, 1, '互動式網頁程式設計\n3B\n黃正達', 0, '0000-00-00 00:00:00'),
('30802', 1, 2, 'no_class', 0, '0000-00-00 00:00:00'),
('30802', 1, 3, 'no_class', 0, '0000-00-00 00:00:00'),
('30802', 1, 4, '影像處理\n1A\n劉一凡', 0, '0000-00-00 00:00:00'),
('30802', 1, 5, 'no_class', 0, '0000-00-00 00:00:00'),
('30802', 2, 1, '互動式網頁程式設計\n3B\n黃正達', 0, '0000-00-00 00:00:00'),
('30802', 2, 2, '專案管理\n3A\n葉乙璇', 0, '0000-00-00 00:00:00'),
('30802', 2, 3, '專案管理\n3B\n葉乙璇', 0, '0000-00-00 00:00:00'),
('30802', 2, 4, '影像處理\n1A\n劉一凡', 0, '0000-00-00 00:00:00'),
('30802', 2, 5, '*巨量資料分析與管理\n3B\n吳宜憲', 0, '0000-00-00 00:00:00'),
('30802', 3, 1, '互動式網頁程式設計\n3B\n黃正達', 0, '0000-00-00 00:00:00'),
('30802', 3, 2, '專案管理\n3A\n葉乙璇', 0, '0000-00-00 00:00:00'),
('30802', 3, 3, '專案管理\n3B\n葉乙璇', 0, '0000-00-00 00:00:00'),
('30802', 3, 4, '影像處理\n1A\n劉一凡', 0, '0000-00-00 00:00:00'),
('30802', 3, 5, '*巨量資料分析與管理\n3B\n吳宜憲', 0, '0000-00-00 00:00:00'),
('30802', 4, 1, '互動式網頁程式設計\n3B\n黃正達', 0, '0000-00-00 00:00:00'),
('30802', 4, 2, '專案管理\n3A\n葉乙璇', 0, '0000-00-00 00:00:00'),
('30802', 4, 3, '專案管理\n3B\n葉乙璇', 0, '0000-00-00 00:00:00'),
('30802', 4, 4, '影像處理\n1A\n劉一凡', 0, '0000-00-00 00:00:00'),
('30802', 4, 5, '*巨量資料分析與管理\n3B\n吳宜憲', 0, '0000-00-00 00:00:00'),
('30802', 5, 1, 'no_class', 0, '0000-00-00 00:00:00'),
('30802', 5, 2, 'no_class', 0, '0000-00-00 00:00:00'),
('30802', 5, 3, 'no_class', 0, '0000-00-00 00:00:00'),
('30802', 5, 4, 'no_class', 0, '0000-00-00 00:00:00'),
('30802', 5, 5, 'no_class', 0, '0000-00-00 00:00:00'),
('30802', 6, 1, '*LINUX作業系統\n2A\n陳東?', 0, '0000-00-00 00:00:00'),
('30802', 6, 2, '*行動裝置程式設計\n3A\n黃正達', 0, '0000-00-00 00:00:00'),
('30802', 6, 3, 'no_class', 0, '0000-00-00 00:00:00'),
('30802', 6, 4, 'no_class', 0, '0000-00-00 00:00:00'),
('30802', 6, 5, '統計學\n2A\n吳宜憲', 0, '0000-00-00 00:00:00'),
('30802', 7, 1, '*LINUX作業系統\n2A\n陳東?', 0, '0000-00-00 00:00:00'),
('30802', 7, 2, '*行動裝置程式設計\n3A\n黃正達', 0, '0000-00-00 00:00:00'),
('30802', 7, 3, 'no_class', 0, '0000-00-00 00:00:00'),
('30802', 7, 4, '*雲端服務與行動科技導論\n1B\n蔡文隆', 0, '0000-00-00 00:00:00'),
('30802', 7, 5, '統計學\n2A\n吳宜憲', 0, '0000-00-00 00:00:00'),
('30802', 8, 1, '*LINUX作業系統\n2A\n陳東?', 0, '0000-00-00 00:00:00'),
('30802', 8, 2, '*行動裝置程式設計\n3A\n黃正達', 0, '0000-00-00 00:00:00'),
('30802', 8, 3, 'no_class', 0, '0000-00-00 00:00:00'),
('30802', 8, 4, '*雲端服務與行動科技導論\n1B\n蔡文隆', 0, '0000-00-00 00:00:00'),
('30802', 8, 5, '統計學\n2B\n吳宜憲', 0, '0000-00-00 00:00:00'),
('30802', 9, 1, 'no_class', 0, '0000-00-00 00:00:00'),
('30802', 9, 2, 'no_class', 0, '0000-00-00 00:00:00'),
('30802', 9, 3, 'no_class', 0, '0000-00-00 00:00:00'),
('30802', 9, 4, '*雲端服務與行動科技導論\n1B\n蔡文隆', 0, '0000-00-00 00:00:00'),
('30802', 9, 5, '統計學\n2B\n吳宜憲', 0, '0000-00-00 00:00:00'),
('30803', 1, 1, '資料庫\n2A\n李紹綸', 0, '0000-00-00 00:00:00'),
('30803', 1, 2, '資料庫\n2B\n李紹綸', 0, '0000-00-00 00:00:00'),
('30803', 1, 3, '程式設計\n1B\n陳鵬文', 0, '0000-00-00 00:00:00'),
('30803', 1, 4, 'no_class', 0, '0000-00-00 00:00:00'),
('30803', 1, 5, 'no_class', 0, '0000-00-00 00:00:00'),
('30803', 2, 1, '資料庫\n2A\n李紹綸', 0, '0000-00-00 00:00:00'),
('30803', 2, 2, '資料庫\n2B\n李紹綸', 0, '0000-00-00 00:00:00'),
('30803', 2, 3, '程式設計\n1B\n陳鵬文', 0, '0000-00-00 00:00:00'),
('30803', 2, 4, '*使用者頁面設計\n3A\n陳東?', 0, '0000-00-00 00:00:00'),
('30803', 2, 5, '*遊戲設計\n2A\n劉一凡', 0, '0000-00-00 00:00:00'),
('30803', 3, 1, '資料庫\n2A\n李紹綸', 0, '0000-00-00 00:00:00'),
('30803', 3, 2, '資料庫\n2B\n李紹綸', 0, '0000-00-00 00:00:00'),
('30803', 3, 3, '程式設計\n1A\n陳鵬文', 0, '0000-00-00 00:00:00'),
('30803', 3, 4, '*使用者頁面設計\n3A\n陳東?', 0, '0000-00-00 00:00:00'),
('30803', 3, 5, '*遊戲設計\n2A\n劉一凡', 0, '0000-00-00 00:00:00'),
('30803', 4, 1, '資料庫\n2A\n李紹綸', 0, '0000-00-00 00:00:00'),
('30803', 4, 2, '資料庫\n2B\n李紹綸', 0, '0000-00-00 00:00:00'),
('30803', 4, 3, '程式設計\n1A\n陳鵬文', 0, '0000-00-00 00:00:00'),
('30803', 4, 4, '*使用者頁面設計\n3A\n陳東?', 0, '0000-00-00 00:00:00'),
('30803', 4, 5, '*遊戲設計\n2A\n劉一凡', 0, '0000-00-00 00:00:00'),
('30803', 5, 1, 'no_class', 0, '0000-00-00 00:00:00'),
('30803', 5, 2, 'no_class', 0, '0000-00-00 00:00:00'),
('30803', 5, 3, 'no_class', 0, '0000-00-00 00:00:00'),
('30803', 5, 4, 'no_class', 0, '0000-00-00 00:00:00'),
('30803', 5, 5, 'no_class', 0, '0000-00-00 00:00:00'),
('30803', 6, 1, '系統分析與設計\n2B\n葉乙璇', 0, '0000-00-00 00:00:00'),
('30803', 6, 2, '系統分析與設計\n葉乙璇\n2A', 0, '0000-00-00 00:00:00'),
('30803', 6, 3, 'no_class', 0, '0000-00-00 00:00:00'),
('30803', 6, 4, 'no_class', 0, '0000-00-00 00:00:00'),
('30803', 6, 5, '程式設計\n陳鵬文\n1A', 0, '0000-00-00 00:00:00'),
('30803', 7, 1, '系統分析與設計\n2B\n葉乙璇', 0, '0000-00-00 00:00:00'),
('30803', 7, 2, '系統分析與設計\n葉乙璇\n2A', 0, '0000-00-00 00:00:00'),
('30803', 7, 3, 'no_class', 0, '0000-00-00 00:00:00'),
('30803', 7, 4, '*網路管理\n陳東?\n4B', 0, '0000-00-00 00:00:00'),
('30803', 7, 5, '程式設計\n陳鵬文\n1A', 0, '0000-00-00 00:00:00'),
('30803', 8, 1, '系統分析與設計\n2B\n葉乙璇', 0, '0000-00-00 00:00:00'),
('30803', 8, 2, '系統分析與設計\n葉乙璇\n2A', 0, '0000-00-00 00:00:00'),
('30803', 8, 3, 'no_class', 0, '0000-00-00 00:00:00'),
('30803', 8, 4, '*網路管理\n陳東?\n4B', 0, '0000-00-00 00:00:00'),
('30803', 8, 5, '程式設計\n陳鵬文\n1B', 0, '0000-00-00 00:00:00'),
('30803', 9, 1, '系統分析與設計\n2B\n葉乙璇', 0, '0000-00-00 00:00:00'),
('30803', 9, 2, '系統分析與設計\n葉乙璇\n2A', 0, '0000-00-00 00:00:00'),
('30803', 9, 3, 'no_class', 0, '0000-00-00 00:00:00'),
('30803', 9, 4, '*網路管理\n陳東?\n4B', 0, '0000-00-00 00:00:00'),
('30803', 9, 5, '程式設計\n陳鵬文\n1B', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 資料表結構 `classroom`
--

CREATE TABLE `classroom` (
  `num` varchar(10) NOT NULL,
  `name` varchar(10) NOT NULL,
  `open_off` int(2) NOT NULL DEFAULT '0',
  `off_time` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `classroom`
--

INSERT INTO `classroom` (`num`, `name`, `open_off`, `off_time`) VALUES
('30801', '801電腦教室', 0, '0000-00-00'),
('30802', '802電腦教室', 0, '0000-00-00'),
('30803', '803電腦教室', 0, '0000-00-00');

-- --------------------------------------------------------

--
-- 資料表結構 `item_category`
--

CREATE TABLE `item_category` (
  `num` int(11) NOT NULL,
  `name` varchar(10) NOT NULL,
  `open_off` int(2) NOT NULL DEFAULT '0',
  `off_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- 資料表的匯出資料 `item_category`
--

INSERT INTO `item_category` (`num`, `name`, `open_off`, `off_time`) VALUES
(1, '筆電', 0, '0000-00-00'),
(2, '手機', 0, '0000-00-00'),
(6, '相機', 0, '0000-00-00'),
(7, '槍', 0, '0000-00-00'),
(8, '火箭', 0, '0000-00-00'),
(9, '戰車', 0, '0000-00-00'),
(10, '摁摁', 0, '0000-00-00'),
(11, '213', 0, '0000-00-00'),
(12, '大哥', 0, '0000-00-00'),
(13, '筆記型電腦', 0, '0000-00-00');

-- --------------------------------------------------------

--
-- 資料表結構 `item_info`
--

CREATE TABLE `item_info` (
  `itemNo` varchar(30) NOT NULL,
  `specification` varchar(10) DEFAULT NULL,
  `brand` varchar(10) DEFAULT NULL,
  `catergory` int(11) NOT NULL,
  `open_off` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `item_info`
--

INSERT INTO `item_info` (`itemNo`, `specification`, `brand`, `catergory`, `open_off`) VALUES
('1', '2', '3', 1, 0),
('12', '2', '21', 11, 0),
('3140101-03', 'A1398', 'Apple', 13, 0),
('3140101-0311543', 'A1398', 'Apple', 13, 0),
('3140101-0311545', 'A1398', 'Apple', 13, 0),
('3140101-0311553', 'A1398', 'Apple', 13, 0),
('3140101-0311554', 'A1398', 'Apple', 13, 0),
('3140101-0311555', 'A1398', 'Apple', 13, 0),
('456-oo', 'oo', 'oo', 8, 0),
('51700', 'LiquidZ630', 'acer', 2, 0),
('51701', 'LiquidZ410', 'acer', 2, 0),
('51702', 'ZenFone3', 'asus', 2, 0),
('51703', 'ZenFoneZoo', 'asus', 2, 0),
('51704', 'htc10', 'htc', 2, 0),
('51705', 'mi4s', 'mi', 2, 0),
('51706', 'note7', 'samsung', 2, 0),
('51707', 'J7Prime', 'samsung', 2, 0),
('51708', 'XperiaXZ', 'sony', 2, 0),
('51709', 'XperiaZ5', 'sony', 2, 0),
('51710', 'iphone7', 'apple', 2, 0),
('51711', 'iphone6', 'apple', 2, 0),
('51712', 'iphone5', 'apple', 2, 0),
('51713', 'iphone4', 'apple', 2, 0),
('51714', 'iphone3', 'apple', 2, 0),
('51715', 'iphone2', 'apple', 2, 0),
('7878', '一二三', '四五', 7, 0),
('A100', 'MacBook', 'MAC', 1, 1),
('A101', 'MacBook', 'MAC', 1, 0),
('A102', 'MacBook', 'MAC', 1, 0),
('A103', 'MacBook', 'MAC', 1, 0),
('A104', 'MacBook', 'MAC', 1, 0),
('A105', 'MacBook', 'MAC', 1, 0),
('A106', 'PROB8230UA', 'asus', 1, 0),
('A107', 'Swift7', 'acer', 1, 0),
('aaa', 'aaa', 'aaa', 10, 0),
('cc', 'cc', 'cc', 9, 0),
('何', 'abc', 'occ', 12, 0),
('袁', 'ccc', '789', 12, 0);

-- --------------------------------------------------------

--
-- 資料表結構 `laboratory_info`
--

CREATE TABLE `laboratory_info` (
  `lab_num` varchar(10) CHARACTER SET utf8 NOT NULL,
  `seat_num` varchar(10) CHARACTER SET utf8 NOT NULL,
  `usingORnot` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `laboratory_info`
--

INSERT INTO `laboratory_info` (`lab_num`, `seat_num`, `usingORnot`) VALUES
('20806', '討論8', 0),
('20806', '討論7', 0),
('20806', '討論6', 0),
('20806', '討論5', 0),
('20806', '討論4', 0),
('20806', '討論3', 0),
('20806', '討論2', 0),
('20806', '討論1', 0),
('20806', '電腦12', 0),
('20806', '電腦11', 0),
('20806', '討論12', 0),
('20806', '討論11', 0),
('20806', '討論10', 0),
('20806', '電腦10', 0),
('20806', '電腦9', 0),
('20806', '電腦8', 0),
('20806', '電腦7', 0),
('20806', '電腦6', 0),
('20806', '電腦5', 0),
('20806', '電腦4', 0),
('20806', '電腦3', 0),
('20806', '電腦2(專題)', 0),
('20804', '電腦12', 0),
('20804', '電腦11', 0),
('20804', '電腦10', 0),
('20804', '電腦9', 0),
('20804', '電腦8', 0),
('20804', '電腦7', 0),
('20804', '電腦6', 0),
('20804', '電腦5', 0),
('20804', '電腦4', 0),
('20804', '電腦3', 0),
('20804', '電腦2', 0),
('20804', '電腦1', 0),
('20805', '討論12', 0),
('20805', '討論11', 0),
('20805', '討論9', 0),
('20805', '討論8', 0),
('20805', '討論7', 0),
('20805', '討論6', 0),
('20805', '討論5', 0),
('20805', '討論4', 0),
('20805', '討論3', 0),
('20805', '討論2', 0),
('20805', '討論1', 0),
('20805', '電腦12', 0),
('20805', '電腦11', 0),
('20805', '電腦10', 0),
('20805', '電腦9', 0),
('20805', '電腦8', 0),
('20805', '電腦7', 0),
('20805', '電腦6', 0),
('20805', '電腦5', 0),
('20805', '電腦4', 0),
('20805', '電腦3', 0),
('20805', '電腦2', 0),
('20805', '電腦1', 0),
('20804', '討論1', 1),
('20804', '討論2', 0),
('20804', '討論3', 0),
('20804', '討論4', 0),
('20804', '討論5', 0),
('20804', '討論6', 0),
('20804', '討論7', 0),
('20804', '討論8', 0),
('20804', '討論9', 0),
('20804', '討論10', 1),
('20804', '討論11', 0),
('20804', '討論12', 0),
('20805', '討論10', 0),
('20804', 'Meeting', 0),
('20805', 'Meeting', 0),
('20806', '討論9', 0),
('20806', 'Meeting', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `lab_category`
--

CREATE TABLE `lab_category` (
  `num` int(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `img` varchar(30) NOT NULL,
  `open_off` int(2) NOT NULL DEFAULT '0',
  `off_time` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `lab_category`
--

INSERT INTO `lab_category` (`num`, `name`, `img`, `open_off`, `off_time`) VALUES
(20804, '804實驗室', '20804.jpg', 2, '2018-01-30'),
(20805, '805實驗室', '20805.jpg', 0, '0000-00-00'),
(20806, '806實驗室', '20806.jpg', 0, '0000-00-00');

-- --------------------------------------------------------

--
-- 資料表結構 `roomborrow`
--

CREATE TABLE `roomborrow` (
  `id` int(11) NOT NULL,
  `studentID` varchar(20) NOT NULL,
  `personName` varchar(10) NOT NULL,
  `period` int(10) NOT NULL,
  `week` int(2) NOT NULL,
  `roomNo` varchar(10) NOT NULL,
  `insert_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lendTime` datetime DEFAULT NULL,
  `lend_manager` varchar(30) NOT NULL,
  `returnTime` datetime DEFAULT NULL,
  `return_manager` varchar(30) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `roomborrow`
--

INSERT INTO `roomborrow` (`id`, `studentID`, `personName`, `period`, `week`, `roomNo`, `insert_time`, `lendTime`, `lend_manager`, `returnTime`, `return_manager`, `status`) VALUES
(370, '8787', '王', 1, 2, '30801', '2018-01-30 05:25:50', '2018-01-30 13:35:32', '104111123', NULL, '', 1),
(371, '8787', '王', 2, 2, '30801', '2018-01-30 05:55:01', '2018-01-30 13:55:51', '104111123', NULL, '', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `semester_value`
--

CREATE TABLE `semester_value` (
  `semester` varchar(15) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `semester_value`
--

INSERT INTO `semester_value` (`semester`, `date_from`, `date_to`) VALUES
('1061', '2017-08-01', '2018-01-31'),
('1062', '2018-02-01', '2018-07-31');

-- --------------------------------------------------------

--
-- 資料表結構 `student`
--

CREATE TABLE `student` (
  `studentID` varchar(20) NOT NULL,
  `password` varchar(65) NOT NULL,
  `class` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `personName` varchar(10) NOT NULL,
  `cardId` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `foulCount` int(20) NOT NULL,
  `stop` int(1) DEFAULT '-2',
  `chmod` tinyint(1) NOT NULL DEFAULT '0',
  `addtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `verfiy_code` varchar(10) DEFAULT NULL,
  `verfiy_mail` varchar(20) NOT NULL,
  `latest_login` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `student`
--

INSERT INTO `student` (`studentID`, `password`, `class`, `personName`, `cardId`, `email`, `foulCount`, `stop`, `chmod`, `addtime`, `verfiy_code`, `verfiy_mail`, `latest_login`) VALUES
('104111123', '$2y$10$1V.Y0TCkboLpl6IrqO2TheJAX5BQOfO2ryqgoeb.g7K0150XuOLfC', '9A', '李', '555555', 'line6238@gmail.com', 0, 1, 3, '2017-11-07 13:44:27', NULL, '', '2018-02-07 19:20:27'),
('8787', '$2y$10$1V.Y0TCkboLpl6IrqO2TheJAX5BQOfO2ryqgoeb.g7K0150XuOLfC', '9A', '王', '', '87', 0, 1, 3, '2018-01-27 03:48:07', NULL, '', '2018-01-30 14:35:51'),
('987987', '', '9A', '8979879', '', '987987', 0, -2, 0, '2018-01-27 03:48:46', NULL, '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- 資料表結構 `tempborrow`
--

CREATE TABLE `tempborrow` (
  `_id` int(11) NOT NULL,
  `personName` varchar(10) NOT NULL,
  `studentID` varchar(20) NOT NULL,
  `itemNo` varchar(30) NOT NULL,
  `note` text NOT NULL,
  `insert_time` timestamp NULL DEFAULT NULL,
  `lendTime` datetime DEFAULT NULL,
  `lend_manager` varchar(30) NOT NULL,
  `expect_return_time` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `tempborrow`
--

INSERT INTO `tempborrow` (`_id`, `personName`, `studentID`, `itemNo`, `note`, `insert_time`, `lendTime`, `lend_manager`, `expect_return_time`, `status`) VALUES
(3, '王堉宸', '103111120', 'A101', '55555', '2018-01-25 04:41:30', '2018-01-25 12:42:47', '104111123', '2018-01-25 00:00:00', -1),
(6, '系助A', 'f0987', 'A102', '222', '2018-01-25 07:55:18', NULL, '', '2018-01-27 00:00:00', 0),
(7, '系助A', 'f0987', 'A102', 'HDMI線', '2018-01-27 08:51:45', NULL, '', '2018-01-30 00:00:00', 0),
(12, '王', '8787', 'A103', '', '2018-01-30 06:23:48', '2018-01-30 14:25:09', '104111123', '2018-01-31 14:23:48', 1),
(13, '王', '8787', 'A100', '', '2018-01-30 06:37:16', '2018-01-30 14:37:53', '104111123', '2018-01-31 14:37:16', 1),
(17, '李', '104111123', 'A107', '', '2018-01-31 13:04:48', NULL, '', '2018-02-01 21:04:48', 0),
(18, '李', '104111123', 'A107', '', '2018-02-02 13:29:07', NULL, '', '2018-02-03 21:29:07', 0),
(19, '李', '104111123', 'A106', '', '2018-01-31 13:38:12', NULL, '', '2018-02-01 21:38:12', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `templab`
--

CREATE TABLE `templab` (
  `_id` int(11) NOT NULL,
  `personName` varchar(10) CHARACTER SET utf8 NOT NULL,
  `studentID` varchar(20) NOT NULL,
  `itemNo` varchar(20) CHARACTER SET utf8 NOT NULL,
  `category` varchar(10) CHARACTER SET utf8 NOT NULL,
  `insert_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lendTime` datetime DEFAULT NULL,
  `lend_manager` varchar(30) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `templab`
--

INSERT INTO `templab` (`_id`, `personName`, `studentID`, `itemNo`, `category`, `insert_time`, `lendTime`, `lend_manager`, `start_time`, `end_time`, `status`) VALUES
(95, '系助A', 'f0987', '討論10', '20804', '2018-01-25 07:59:45', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(94, '王堉宸', '102111120', '討論1', '20804', '2018-01-27 07:28:09', '2018-01-27 16:50:02', 'f0987', '0000-00-00 00:00:00', '0000-00-00 00:00:00', -1),
(101, '王堉宸', '103111120', 'Meeting', '20805', '2018-01-30 04:32:29', NULL, '', '2018-01-31 09:00:00', '2018-02-02 10:00:00', 0),
(102, '李', '104111123', '討論5', '20805', '2018-01-30 05:03:39', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(105, '李', '104111123', 'Meeting', '20804', '2018-01-30 06:15:00', '2018-01-30 14:15:23', '8787', '2018-01-30 15:00:00', '2018-01-30 16:00:00', 1);

-- --------------------------------------------------------

--
-- 資料表結構 `temp_add_user`
--

CREATE TABLE `temp_add_user` (
  `studentID` varchar(20) NOT NULL,
  `personName` varchar(20) NOT NULL,
  `class` varchar(3) NOT NULL,
  `mail` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `temp_add_user`
--

INSERT INTO `temp_add_user` (`studentID`, `personName`, `class`, `mail`) VALUES
('104111123', '李', '9A', '321321321@gamil'),
('8787', '87', '9A', '87'),
('987987', '8979879', '9A', '987987'),
('asd', 'asd', '9A', ''),
('asdddd', 'ddddd', '9A', 'ddd'),
('rrrrr', 'rr', '9A', 'rrrrr');

-- --------------------------------------------------------

--
-- 資料表結構 `value_data`
--

CREATE TABLE `value_data` (
  `_key` varchar(30) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `value_data`
--

INSERT INTO `value_data` (`_key`, `value`) VALUES
('801_image', ''),
('802_image', ''),
('check_borrow', '2018-01-24'),
('check_lab', '2018-01-27 23:56:31'),
('check_return', '2018-01-28 14:45:34');

-- --------------------------------------------------------

--
-- 資料表結構 `verfiy_mail`
--

CREATE TABLE `verfiy_mail` (
  `account` varchar(30) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `verfiy` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `verfiy_mail`
--

INSERT INTO `verfiy_mail` (`account`, `mail`, `verfiy`) VALUES
('103111120', 'xwg49998@pdold.com', '0dc49_668d5');

-- --------------------------------------------------------

--
-- 資料表結構 `violation_record`
--

CREATE TABLE `violation_record` (
  `_id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `record_id` int(11) NOT NULL,
  `reason` varchar(20) NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 資料表的匯出資料 `violation_record`
--

INSERT INTO `violation_record` (`_id`, `user_id`, `type`, `record_id`, `reason`, `add_date`) VALUES
(5, '102111120', 'lab', 94, '實驗室5點尚未歸還', '2018-01-28 07:47:38'),
(6, '103111120', 'item', 3, '設備逾期3天', '2018-01-28 07:47:38'),
(7, '104111123', 'item', 1, '設備逾期3天', '2018-01-28 07:47:38');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `ban_record`
--
ALTER TABLE `ban_record`
  ADD PRIMARY KEY (`studentID`);

--
-- 資料表索引 `borowperson`
--
ALTER TABLE `borowperson`
  ADD PRIMARY KEY (`_id`);

--
-- 資料表索引 `borrowlab`
--
ALTER TABLE `borrowlab`
  ADD PRIMARY KEY (`_id`);

--
-- 資料表索引 `borrowroom`
--
ALTER TABLE `borrowroom`
  ADD PRIMARY KEY (`_id`);

--
-- 資料表索引 `borrow_note`
--
ALTER TABLE `borrow_note`
  ADD PRIMARY KEY (`category`,`other`);

--
-- 資料表索引 `classperiod`
--
ALTER TABLE `classperiod`
  ADD PRIMARY KEY (`room`,`period`);

--
-- 資料表索引 `classperiod1`
--
ALTER TABLE `classperiod1`
  ADD PRIMARY KEY (`room_no`,`period`,`day`);

--
-- 資料表索引 `classroom`
--
ALTER TABLE `classroom`
  ADD PRIMARY KEY (`num`);

--
-- 資料表索引 `item_category`
--
ALTER TABLE `item_category`
  ADD PRIMARY KEY (`num`,`name`);

--
-- 資料表索引 `item_info`
--
ALTER TABLE `item_info`
  ADD PRIMARY KEY (`itemNo`);

--
-- 資料表索引 `laboratory_info`
--
ALTER TABLE `laboratory_info`
  ADD PRIMARY KEY (`seat_num`,`lab_num`);

--
-- 資料表索引 `lab_category`
--
ALTER TABLE `lab_category`
  ADD PRIMARY KEY (`num`);

--
-- 資料表索引 `roomborrow`
--
ALTER TABLE `roomborrow`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `semester_value`
--
ALTER TABLE `semester_value`
  ADD PRIMARY KEY (`semester`);

--
-- 資料表索引 `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentID`);

--
-- 資料表索引 `tempborrow`
--
ALTER TABLE `tempborrow`
  ADD PRIMARY KEY (`_id`);

--
-- 資料表索引 `templab`
--
ALTER TABLE `templab`
  ADD PRIMARY KEY (`_id`);

--
-- 資料表索引 `temp_add_user`
--
ALTER TABLE `temp_add_user`
  ADD PRIMARY KEY (`studentID`);

--
-- 資料表索引 `value_data`
--
ALTER TABLE `value_data`
  ADD PRIMARY KEY (`_key`);

--
-- 資料表索引 `verfiy_mail`
--
ALTER TABLE `verfiy_mail`
  ADD PRIMARY KEY (`account`);

--
-- 資料表索引 `violation_record`
--
ALTER TABLE `violation_record`
  ADD PRIMARY KEY (`_id`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `borowperson`
--
ALTER TABLE `borowperson`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=146;
--
-- 使用資料表 AUTO_INCREMENT `borrowlab`
--
ALTER TABLE `borrowlab`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- 使用資料表 AUTO_INCREMENT `borrowroom`
--
ALTER TABLE `borrowroom`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- 使用資料表 AUTO_INCREMENT `item_category`
--
ALTER TABLE `item_category`
  MODIFY `num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- 使用資料表 AUTO_INCREMENT `roomborrow`
--
ALTER TABLE `roomborrow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=372;
--
-- 使用資料表 AUTO_INCREMENT `tempborrow`
--
ALTER TABLE `tempborrow`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- 使用資料表 AUTO_INCREMENT `templab`
--
ALTER TABLE `templab`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
--
-- 使用資料表 AUTO_INCREMENT `violation_record`
--
ALTER TABLE `violation_record`
  MODIFY `_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
