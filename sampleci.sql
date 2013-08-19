-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 19, 2013 at 05:31 AM
-- Server version: 5.5.25a
-- PHP Version: 5.4.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sampleci`
--

-- --------------------------------------------------------

--
-- Table structure for table `columns`
--

CREATE TABLE IF NOT EXISTS `columns` (
  `colId` int(11) NOT NULL AUTO_INCREMENT,
  `tableId` int(11) NOT NULL,
  `isForm` tinyint(1) NOT NULL,
  `isGrid` tinyint(1) NOT NULL,
  `isQuickSearch` tinyint(1) NOT NULL,
  `dataBind` varchar(200) NOT NULL,
  `refTableName` varchar(120) NOT NULL,
  `optionsText` varchar(50) NOT NULL,
  `optionsValue` varchar(50) NOT NULL,
  `colName` varchar(50) NOT NULL,
  `isPk` tinyint(1) NOT NULL,
  `ai` tinyint(1) NOT NULL,
  `dataType` varchar(20) NOT NULL,
  `size` int(11) NOT NULL,
  `isNull` tinyint(1) NOT NULL,
  `orderNo` int(11) NOT NULL,
  PRIMARY KEY (`colId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `columns`
--

INSERT INTO `columns` (`colId`, `tableId`, `isForm`, `isGrid`, `isQuickSearch`, `dataBind`, `refTableName`, `optionsText`, `optionsValue`, `colName`, `isPk`, `ai`, `dataType`, `size`, `isNull`, `orderNo`) VALUES
(13, 30, 0, 0, 0, '', '', '', '', 'NavigationId', 1, 1, 'int', 100, 0, 0),
(14, 30, 1, 1, 1, '', '', '', '', 'NavName', 0, 0, 'varchar', 100, 0, 0),
(15, 30, 1, 1, 0, '', '', '', '', 'NavOrder', 0, 0, 'int', 0, 0, 0),
(16, 30, 1, 1, 0, '', '', '', '', 'ActionPath', 0, 0, 'varchar', 100, 0, 0),
(17, 30, 1, 1, 1, '', 'Navigations', 'NavName', 'NavigationId', 'ParentNavId', 0, 0, 'int', 0, 1, 0),
(18, 31, 0, 0, 0, '', '', '', '', 'RoleId', 1, 1, 'int', 0, 0, 0),
(19, 31, 1, 1, 1, '', '', '', '', 'RoleName', 0, 0, 'varchar', 50, 0, 0),
(20, 31, 1, 1, 1, '', 'Navigations', 'NavName', 'NavigationId', 'NavigationId', 0, 0, 'int', 0, 1, 0),
(21, 31, 1, 1, 0, '', '', '', '', 'IsRead', 0, 0, 'boolean', 0, 0, 0),
(22, 31, 1, 1, 0, '', '', '', '', 'IsInsert', 0, 0, 'boolean', 0, 0, 0),
(23, 31, 1, 1, 0, '', '', '', '', 'IsUpdate', 0, 0, 'boolean', 0, 0, 0),
(24, 31, 1, 1, 0, '', '', '', '', 'IsDelete', 0, 0, 'boolean', 0, 0, 0),
(25, 32, 0, 0, 0, '', '', '', '', 'UserId', 1, 1, 'int', 0, 0, 0),
(26, 32, 1, 1, 1, '', '', '', '', 'UserName', 0, 0, 'varchar', 100, 0, 0),
(27, 32, 1, 1, 1, '', '', '', '', 'FirstName', 0, 0, 'varchar', 50, 0, 0),
(28, 32, 1, 1, 1, '', '', '', '', 'LastName', 0, 0, 'varchar', 50, 0, 0),
(29, 32, 1, 0, 0, '', '', '', '', 'Password', 0, 0, 'varchar', 100, 0, 0),
(30, 32, 1, 1, 1, '', '', '', '', 'Email', 0, 0, 'varchar', 100, 0, 0),
(31, 32, 1, 1, 1, '', 'Roles', 'RoleName', 'RoleId', 'Role', 0, 0, 'int', 0, 0, 0),
(32, 32, 1, 1, 1, '', '', '', '', 'IsActive', 0, 0, 'boolean', 0, 1, 0),
(33, 32, 1, 1, 1, '', 'Navigations', 'NavName', 'NavigationId', 'NavigationId', 0, 0, 'int', 0, 1, 0),
(34, 33, 0, 0, 0, '', '', '', '', 'NavgViewId', 1, 1, 'int', 0, 0, 0),
(35, 33, 1, 1, 1, '', 'Navigations', 'NavName', 'NavigationId', 'Navigations', 0, 0, 'int', 0, 0, 0),
(36, 33, 1, 1, 1, '', 'Roles', 'RoleName', 'RoleId', 'Roles', 0, 0, 'int', 0, 1, 0),
(37, 33, 1, 1, 1, '', 'Users', 'UserName', 'UserId', 'Users', 0, 0, 'int', 0, 1, 0),
(38, 34, 0, 0, 0, '', '', '', '', 'TestId', 1, 1, 'int', 0, 0, 1),
(39, 34, 1, 1, 1, '', '', '', '', 'Name', 0, 0, 'varchar', 100, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `navigations`
--

CREATE TABLE IF NOT EXISTS `navigations` (
  `NavigationId` int(11) NOT NULL AUTO_INCREMENT,
  `NavName` varchar(100) NOT NULL,
  `NavOrder` int(11) NOT NULL,
  `ActionPath` varchar(100) NOT NULL,
  `ParentNavId` int(11) DEFAULT NULL,
  PRIMARY KEY (`NavigationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `navigations`
--

INSERT INTO `navigations` (`NavigationId`, `NavName`, `NavOrder`, `ActionPath`, `ParentNavId`) VALUES
(1, 'Users', 2, 'Users', 4),
(2, 'Roles', 4, 'Roles', 4),
(3, 'Navigations', 2, 'Navigations', 4),
(4, 'Authorize', 1, 'Authorize', NULL),
(5, 'Navigations View Right', 3, 'NavigViewRight', 4),
(6, 'Test', 2, 'Test', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `navigviewright`
--

CREATE TABLE IF NOT EXISTS `navigviewright` (
  `NavgViewId` int(11) NOT NULL AUTO_INCREMENT,
  `Navigations` int(11) NOT NULL,
  `Roles` int(11) DEFAULT NULL,
  `Users` int(11) DEFAULT NULL,
  PRIMARY KEY (`NavgViewId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `navigviewright`
--

INSERT INTO `navigviewright` (`NavgViewId`, `Navigations`, `Roles`, `Users`) VALUES
(1, 1, 1, NULL),
(2, 4, 1, NULL),
(3, 5, 1, NULL),
(4, 3, 1, NULL),
(5, 2, 1, NULL),
(6, 6, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `RoleId` int(11) NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(50) NOT NULL,
  `NavigationId` int(11) NOT NULL,
  `IsRead` tinyint(1) NOT NULL,
  `IsInsert` tinyint(1) NOT NULL,
  `IsUpdate` tinyint(1) NOT NULL,
  `IsDelete` tinyint(1) NOT NULL,
  PRIMARY KEY (`RoleId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`RoleId`, `RoleName`, `NavigationId`, `IsRead`, `IsInsert`, `IsUpdate`, `IsDelete`) VALUES
(1, 'Super Admin', 1, 1, 1, 1, 1),
(2, 'Admin', 1, 1, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `synctables`
--

CREATE TABLE IF NOT EXISTS `synctables` (
  `TableName` varchar(100) NOT NULL,
  PRIMARY KEY (`TableName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `synctables`
--

INSERT INTO `synctables` (`TableName`) VALUES
('Navigations'),
('NavigViewRight'),
('Roles'),
('Test'),
('Users');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE IF NOT EXISTS `tables` (
  `tableId` int(11) NOT NULL AUTO_INCREMENT,
  `tableName` varchar(100) NOT NULL,
  PRIMARY KEY (`tableId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`tableId`, `tableName`) VALUES
(30, 'Navigations'),
(31, 'Roles'),
(32, 'Users'),
(33, 'NavigViewRight'),
(34, 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `Name` varchar(100) NOT NULL,
  `TestId` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`TestId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`Name`, `TestId`) VALUES
('Sample', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `UserId` int(11) NOT NULL AUTO_INCREMENT,
  `UserName` varchar(100) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Role` int(11) NOT NULL,
  `IsActive` tinyint(1) DEFAULT NULL,
  `NavigationId` int(11) DEFAULT NULL,
  PRIMARY KEY (`UserId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `UserName`, `FirstName`, `LastName`, `Password`, `Email`, `Role`, `IsActive`, `NavigationId`) VALUES
(1, 'jasim', 'jasim', 'khan', 'jasim', 'jasim@email.com', 1, 1, NULL),
(2, 'test', 'test', 'test', 'test', 'test@gmail.com', 2, 1, NULL);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
