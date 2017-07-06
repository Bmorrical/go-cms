-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: go3
-- ------------------------------------------------------
-- Server version	5.7.11

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `go_menu_items`
--

DROP TABLE IF EXISTS `go_menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `go_menu_items` (
  `MenuItemID` int(11) NOT NULL AUTO_INCREMENT,
  `MenuID` int(11) DEFAULT NULL,
  `MenuItemName` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `MenuItemURL` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Level` int(11) DEFAULT NULL,
  `Order` int(11) DEFAULT NULL,
  `Icon` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `ActiveClass` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Status` int(1) DEFAULT '1',
  `DisplayStatus` int(1) DEFAULT '1',
  PRIMARY KEY (`MenuItemID`),
  KEY `menu_items__menues_idx` (`MenuID`),
  CONSTRAINT `menu_items__menues` FOREIGN KEY (`MenuID`) REFERENCES `go_menus` (`MenuID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `go_menu_items`
--

LOCK TABLES `go_menu_items` WRITE;
/*!40000 ALTER TABLE `go_menu_items` DISABLE KEYS */;
INSERT INTO `go_menu_items` VALUES (1,1,'Logout','admin/logout',1,1,'fa fa-sign-out',NULL,1,1),(2,1,'Config','admin/config',1,2,'fa fa-wrench','config',1,1),(3,1,'Users','admin/users',1,3,'fa fa-lock','users',1,1),(4,1,'Lab','admin/lab',1,4,'fa fa-flask','lab',1,1),(5,2,'Dashboard','admin/dashboard',1,1,'fa fa-home','dashboard',1,1);
/*!40000 ALTER TABLE `go_menu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `go_menus`
--

DROP TABLE IF EXISTS `go_menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `go_menus` (
  `MenuID` int(11) NOT NULL AUTO_INCREMENT,
  `MenuName` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Status` int(1) DEFAULT '1',
  `Type` int(11) DEFAULT NULL,
  PRIMARY KEY (`MenuID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `go_menus`
--

LOCK TABLES `go_menus` WRITE;
/*!40000 ALTER TABLE `go_menus` DISABLE KEYS */;
INSERT INTO `go_menus` VALUES (1,'Top',1,1),(2,'Left',1,1);
/*!40000 ALTER TABLE `go_menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `go_user_types`
--

DROP TABLE IF EXISTS `go_user_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `go_user_types` (
  `UserTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `UserType` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Status` int(1) DEFAULT NULL,
  `Order` int(1) DEFAULT NULL,
  PRIMARY KEY (`UserTypeID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `go_user_types`
--

LOCK TABLES `go_user_types` WRITE;
/*!40000 ALTER TABLE `go_user_types` DISABLE KEYS */;
INSERT INTO `go_user_types` VALUES (1,'Super Admin',1,1),(2,'Admin',1,2),(3,'User',1,3);
/*!40000 ALTER TABLE `go_user_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `go_users`
--

DROP TABLE IF EXISTS `go_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `go_users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Password` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Firstname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `Lastname` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `UserTypeID` int(11) DEFAULT NULL,
  `Status` int(1) DEFAULT NULL,
  `Created` datetime DEFAULT NULL,
  `Updated` datetime DEFAULT NULL,
  `LastLogin` datetime DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `users__user_types_idx` (`UserTypeID`),
  CONSTRAINT `users__user_types` FOREIGN KEY (`UserTypeID`) REFERENCES `go_user_types` (`UserTypeID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `go_users`
--

LOCK TABLES `go_users` WRITE;
/*!40000 ALTER TABLE `go_users` DISABLE KEYS */;
INSERT INTO `go_users` VALUES (1,'super-admin','$2y$10$YOelcNvH5gjpn4zYQCt3qO0Tw/hGWa2uklYfYW6UVXPu31dVE/gR6','Super','Admin',1,1,NULL,NULL,NULL),(2,'user-admin','$2y$10$YOelcNvH5gjpn4zYQCt3qO0Tw/hGWa2uklYfYW6UVXPu31dVE/gR6','User','Admin',2,1,NULL,NULL,NULL),(3,'home-user','$2y$10$YOelcNvH5gjpn4zYQCt3qO0Tw/hGWa2uklYfYW6UVXPu31dVE/gR6','Home','User',3,1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `go_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-05 21:14:49
