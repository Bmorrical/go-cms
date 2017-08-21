-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 16, 2017 at 03:50 PM
-- Server version: 10.1.10-MariaDB
-- PHP Version: 7.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `go-cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `go_menus`
--

CREATE TABLE `go_menus` (
  `MenuID` int(11) NOT NULL,
  `MenuName` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Status` int(1) DEFAULT '1',
  `Type` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `go_menus`
--

INSERT INTO `go_menus` (`MenuID`, `MenuName`, `Status`, `Type`) VALUES
(1, 'Top', 1, 1),
(2, 'Left', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `go_menu_items`
--

CREATE TABLE `go_menu_items` (
  `MenuItemID` int(11) NOT NULL,
  `MenuID` int(11) DEFAULT NULL,
  `MenuItemName` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `MenuItemURL` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Level` int(11) DEFAULT NULL,
  `Order` int(11) DEFAULT NULL,
  `Icon` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `ActiveClass` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Status` int(1) DEFAULT '1',
  `DisplayStatus` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `go_menu_items`
--

INSERT INTO `go_menu_items` (`MenuItemID`, `MenuID`, `MenuItemName`, `MenuItemURL`, `Level`, `Order`, `Icon`, `ActiveClass`, `Status`, `DisplayStatus`) VALUES
(1, 1, 'Logout', 'admin/logout', 1, 1, 'fa fa-sign-out', NULL, 1, 1),
(2, 1, 'Config', 'admin/config', 1, 2, 'fa fa-wrench', 'config', 1, 1),
(3, 1, 'Users', 'admin/users', 1, 3, 'fa fa-lock', 'users', 1, 1),
(4, 1, 'Lab', 'admin/lab', 1, 4, 'fa fa-flask', 'lab', 1, 1),
(5, 2, 'Dashboard', 'admin/dashboard', 1, 1, 'fa fa-home', 'dashboard', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `go_system_info`
--

CREATE TABLE `go_system_info` (
  `id` int(11) NOT NULL,
  `meta_key` varchar(255) NOT NULL,
  `meta_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `go_system_info`
--

INSERT INTO `go_system_info` (`id`, `meta_key`, `meta_value`) VALUES
(1, 'current_version', '1.1');

-- --------------------------------------------------------

--
-- Table structure for table `go_users`
--

CREATE TABLE `go_users` (
  `ID` int(11) NOT NULL,
  `Username` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Password` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Firstname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Lastname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `UserTypeID` int(11) DEFAULT NULL,
  `Status` int(1) DEFAULT NULL,
  `Created` datetime DEFAULT NULL,
  `Updated` datetime DEFAULT NULL,
  `LastLogin` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `go_users`
--

INSERT INTO `go_users` (`ID`, `Username`, `Password`, `Firstname`, `Lastname`, `UserTypeID`, `Status`, `Created`, `Updated`, `LastLogin`) VALUES
(1, 'super-admin', '$2y$10$YOelcNvH5gjpn4zYQCt3qO0Tw/hGWa2uklYfYW6UVXPu31dVE/gR6', 'Super', 'Admin', 1, 1, NULL, NULL, '2017-08-16 13:37:48'),
(2, 'user-admin', '$2y$10$YOelcNvH5gjpn4zYQCt3qO0Tw/hGWa2uklYfYW6UVXPu31dVE/gR6', 'User', 'Admin', 2, 1, NULL, NULL, NULL),
(3, 'home-user', '$2y$10$YOelcNvH5gjpn4zYQCt3qO0Tw/hGWa2uklYfYW6UVXPu31dVE/gR6', 'Home', 'User', 3, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `go_user_types`
--

CREATE TABLE `go_user_types` (
  `UserTypeID` int(11) NOT NULL,
  `UserType` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Status` int(1) DEFAULT NULL,
  `Order` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `go_user_types`
--

INSERT INTO `go_user_types` (`UserTypeID`, `UserType`, `Status`, `Order`) VALUES
(1, 'Super Admin', 1, 1),
(2, 'Admin', 1, 2),
(3, 'User', 1, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `go_menus`
--
ALTER TABLE `go_menus`
  ADD PRIMARY KEY (`MenuID`);

--
-- Indexes for table `go_menu_items`
--
ALTER TABLE `go_menu_items`
  ADD PRIMARY KEY (`MenuItemID`),
  ADD KEY `menu_items__menues_idx` (`MenuID`);

--
-- Indexes for table `go_system_info`
--
ALTER TABLE `go_system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `go_users`
--
ALTER TABLE `go_users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `users__user_types_idx` (`UserTypeID`);

--
-- Indexes for table `go_user_types`
--
ALTER TABLE `go_user_types`
  ADD PRIMARY KEY (`UserTypeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `go_menus`
--
ALTER TABLE `go_menus`
  MODIFY `MenuID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `go_menu_items`
--
ALTER TABLE `go_menu_items`
  MODIFY `MenuItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `go_system_info`
--
ALTER TABLE `go_system_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `go_users`
--
ALTER TABLE `go_users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `go_user_types`
--
ALTER TABLE `go_user_types`
  MODIFY `UserTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `go_menu_items`
--
ALTER TABLE `go_menu_items`
  ADD CONSTRAINT `menu_items__menues` FOREIGN KEY (`MenuID`) REFERENCES `go_menus` (`MenuID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `go_users`
--
ALTER TABLE `go_users`
  ADD CONSTRAINT `users__user_types` FOREIGN KEY (`UserTypeID`) REFERENCES `go_user_types` (`UserTypeID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
