-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-10-25 18:24:29
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `vehiclecontrolsystem`
--

-- --------------------------------------------------------

--
-- 資料表結構 `carinfo`
--

CREATE TABLE `carinfo` (
  `_ID` int(11) NOT NULL,
  `CarID` varchar(90) NOT NULL,
  `Topic_V` varchar(200) NOT NULL,
  `Topic_loc` varchar(200) NOT NULL,
  `IsUsed` tinyint(1) NOT NULL,
  `Notice` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- 傾印資料表的資料 `carinfo`
--

INSERT INTO `carinfo` (`_ID`, `CarID`, `Topic_V`, `Topic_loc`, `IsUsed`, `Notice`) VALUES
(1, '466977005891254', '466977005891254/v', '466977005891254/loc', 1, 'R3'),
(2, '466977005891255', '466977005891255/v', '466977005891255/loc', 1, 'A32'),
(3, '466977005891251', '466977005891251/v', '466977005891251/loc', 1, '53'),
(4, '466977005891257', '466977005891257/v', '466977005891257/loc', 1, 'P3'),
(5, '466977005891256', '466977005891256/v', '466977005891256/loc', 1, '12');

-- --------------------------------------------------------

--
-- 資料表結構 `carrecord`
--

CREATE TABLE `carrecord` (
  `_ID` int(11) NOT NULL,
  `DateTime` varchar(30) NOT NULL,
  `CarID` varchar(90) NOT NULL,
  `Record` varchar(200) NOT NULL,
  `TopicMode` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;


--
-- 資料表結構 `meber`
--

CREATE TABLE `meber` (
  `_ID` int(11) NOT NULL,
  `UserName` varchar(222) NOT NULL,
  `Password` varchar(222) NOT NULL,
  `Notice` varchar(222) NOT NULL,
  `IsUsed` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- 傾印資料表的資料 `meber`
--

INSERT INTO `meber` (`_ID`, `UserName`, `Password`, `Notice`, `IsUsed`) VALUES
(1, 'yoyo30618', 'yoyo0516', 'BEAR', 1),
(2, 'mqtttest', 'mqtttest', '測試帳號', 1);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `carinfo`
--
ALTER TABLE `carinfo`
  ADD PRIMARY KEY (`_ID`);

--
-- 資料表索引 `carrecord`
--
ALTER TABLE `carrecord`
  ADD PRIMARY KEY (`_ID`),
  ADD UNIQUE KEY `T` (`_ID`,`DateTime`,`CarID`);

--
-- 資料表索引 `meber`
--
ALTER TABLE `meber`
  ADD PRIMARY KEY (`_ID`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `carinfo`
--
ALTER TABLE `carinfo`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `carrecord`
--
ALTER TABLE `carrecord`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `meber`
--
ALTER TABLE `meber`
  MODIFY `_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
