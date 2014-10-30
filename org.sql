CREATE DATABASE  IF NOT EXISTS `org_manager` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `org_manager`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: localhost    Database: org_manager
-- ------------------------------------------------------
-- Server version	5.6.14

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
-- Table structure for table `document`
--

DROP TABLE IF EXISTS `document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document` (
  `did` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(245) DEFAULT NULL,
  `url` varchar(245) DEFAULT NULL,
  `oid` int(11) DEFAULT NULL,
  `administrator` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`did`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document`
--

LOCK TABLES `document` WRITE;
/*!40000 ALTER TABLE `document` DISABLE KEYS */;
INSERT INTO `document` VALUES (1,'Google Documentation','http://google.com',1,'0'),(2,'Facebook Document','http://facebook.com',1,'1');
/*!40000 ALTER TABLE `document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `start` datetime DEFAULT NULL,
  `finish` datetime DEFAULT NULL,
  PRIMARY KEY (`eid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (1,23,'First Event','This is the first Event','2015-01-03 19:30:32','2015-01-03 19:30:39');
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membership`
--

DROP TABLE IF EXISTS `membership`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `membership` (
  `mid` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`mid`),
  UNIQUE KEY `mid_UNIQUE` (`mid`),
  KEY `organization_idx` (`oid`),
  KEY `user_idx` (`uid`),
  CONSTRAINT `organization` FOREIGN KEY (`oid`) REFERENCES `organization` (`oid`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `user` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membership`
--

LOCK TABLES `membership` WRITE;
/*!40000 ALTER TABLE `membership` DISABLE KEYS */;
INSERT INTO `membership` VALUES (20,20,1),(21,21,1),(22,22,1),(23,23,1),(24,24,1),(25,25,1),(27,26,1),(28,21,9),(29,23,9);
/*!40000 ALTER TABLE `membership` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `membership_request`
--

DROP TABLE IF EXISTS `membership_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `membership_request` (
  `mrid` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  PRIMARY KEY (`mrid`),
  KEY `mr_user_idx` (`uid`),
  KEY `mr_organization_idx` (`oid`),
  CONSTRAINT `mr_organization` FOREIGN KEY (`oid`) REFERENCES `organization` (`oid`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `mr_user` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membership_request`
--

LOCK TABLES `membership_request` WRITE;
/*!40000 ALTER TABLE `membership_request` DISABLE KEYS */;
INSERT INTO `membership_request` VALUES (5,26,9);
/*!40000 ALTER TABLE `membership_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organization`
--

DROP TABLE IF EXISTS `organization`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organization` (
  `oid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `abbreviation` varchar(45) DEFAULT NULL,
  `description` varchar(999) DEFAULT NULL,
  `parent_oid` int(11) DEFAULT NULL,
  `membership_requestable` varchar(45) NOT NULL DEFAULT 'FALSE',
  `confirmed_parent` varchar(45) NOT NULL DEFAULT 'FALSE',
  PRIMARY KEY (`oid`),
  UNIQUE KEY `oid_UNIQUE` (`oid`),
  KEY `pa_idx` (`parent_oid`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organization`
--

LOCK TABLES `organization` WRITE;
/*!40000 ALTER TABLE `organization` DISABLE KEYS */;
INSERT INTO `organization` VALUES (20,'Demo School','DS','This is a demo account to test some of the functionality that is existing up and to this point.',0,'TRUE','FALSE'),(21,'Jesse Hockenbury Organization','Jesse','this is a description',0,'TRUE','FALSE'),(22,'Testing 2','test2','This ios for testing',20,'TRUE','FALSE'),(23,'Testing 31','Testing 3','This ios for testing',22,'TRUE','1'),(24,'Test Org','Test Org','This is a test organization i am admining',22,'TRUE','1'),(25,'Tech','tech','technology is the center of the world',20,'TRUE','FALSE'),(26,'Kentucky FBLA','ky-fbla','This is a student group for business organizations.',0,'TRUE','FALSE');
/*!40000 ALTER TABLE `organization` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `organization_view`
--

DROP TABLE IF EXISTS `organization_view`;
/*!50001 DROP VIEW IF EXISTS `organization_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `organization_view` (
  `id` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `description` tinyint NOT NULL,
  `parent` tinyint NOT NULL,
  `abbreviation` tinyint NOT NULL,
  `requestable` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `permission`
--

DROP TABLE IF EXISTS `permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission` (
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `value` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`pid`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission`
--

LOCK TABLES `permission` WRITE;
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
INSERT INTO `permission` VALUES (1,'Add Organization','add_organization'),(2,'Edit Organization','edit_organization'),(3,'Manage Requests','manage_requests'),(4,'Add Event','add_event'),(5,'Edit Event','edit_event'),(6,'Cancel Event','cancel_event'),(7,'Add Role','add_role'),(8,'Edit Role','edit_role'),(9,'View Roles','view_roles'),(10,'Delete Role','delete_role');
/*!40000 ALTER TABLE `permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `relationship_request`
--

DROP TABLE IF EXISTS `relationship_request`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `relationship_request` (
  `rrid` int(11) NOT NULL AUTO_INCREMENT,
  `parent_oid` int(11) DEFAULT NULL,
  `oid` int(11) DEFAULT NULL,
  PRIMARY KEY (`rrid`),
  KEY `rr_parent_oid_idx` (`parent_oid`),
  KEY `rr_oid_idx` (`oid`),
  CONSTRAINT `rr_oid` FOREIGN KEY (`oid`) REFERENCES `organization` (`oid`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `rr_parent_oid` FOREIGN KEY (`parent_oid`) REFERENCES `organization` (`oid`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `relationship_request`
--

LOCK TABLES `relationship_request` WRITE;
/*!40000 ALTER TABLE `relationship_request` DISABLE KEYS */;
INSERT INTO `relationship_request` VALUES (4,20,22),(8,20,25);
/*!40000 ALTER TABLE `relationship_request` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`rid`),
  UNIQUE KEY `rid_UNIQUE` (`rid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'Administrator'),(2,'Event Coordinator'),(4,'Event Sponsor');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_membership`
--

DROP TABLE IF EXISTS `role_membership`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_membership` (
  `rmid` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) DEFAULT NULL,
  `rid` int(11) DEFAULT NULL,
  PRIMARY KEY (`rmid`),
  UNIQUE KEY `rmid_UNIQUE` (`rmid`),
  KEY `organization_idx` (`oid`),
  KEY `role_idx` (`rid`),
  CONSTRAINT `rm_organization` FOREIGN KEY (`oid`) REFERENCES `organization` (`oid`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `rm_role` FOREIGN KEY (`rid`) REFERENCES `role` (`rid`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_membership`
--

LOCK TABLES `role_membership` WRITE;
/*!40000 ALTER TABLE `role_membership` DISABLE KEYS */;
INSERT INTO `role_membership` VALUES (20,20,1),(21,21,1),(22,22,1),(23,23,1),(24,24,1),(25,25,1),(26,26,1),(27,23,2),(29,23,4);
/*!40000 ALTER TABLE `role_membership` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_permission`
--

DROP TABLE IF EXISTS `role_permission`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_permission` (
  `rid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `rpid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`rpid`),
  KEY `rp_pid_idx` (`pid`),
  KEY `rp_rid_idx` (`rid`),
  CONSTRAINT `rp_pid` FOREIGN KEY (`pid`) REFERENCES `permission` (`pid`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `rp_rid` FOREIGN KEY (`rid`) REFERENCES `role` (`rid`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_permission`
--

LOCK TABLES `role_permission` WRITE;
/*!40000 ALTER TABLE `role_permission` DISABLE KEYS */;
INSERT INTO `role_permission` VALUES (1,1,26),(1,2,27),(1,3,28),(1,4,29),(1,5,30),(1,6,31),(1,7,32),(1,8,33),(2,4,47),(2,5,48),(2,6,49),(1,9,51),(4,4,52),(4,6,53),(1,10,54);
/*!40000 ALTER TABLE `role_permission` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` VALUES (1,'Accounting'),(2,'Business'),(3,'Finance'),(4,'Technology'),(5,'Northern Kentucky University');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag_membership`
--

DROP TABLE IF EXISTS `tag_membership`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag_membership` (
  `tmid` int(11) NOT NULL AUTO_INCREMENT,
  `tid` int(11) DEFAULT NULL,
  `oid` int(11) DEFAULT NULL,
  PRIMARY KEY (`tmid`),
  KEY `tm_tag_idx` (`tid`),
  KEY `tm_organization_idx` (`oid`),
  CONSTRAINT `tm_organization` FOREIGN KEY (`oid`) REFERENCES `organization` (`oid`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `tm_tag` FOREIGN KEY (`tid`) REFERENCES `tag` (`tid`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag_membership`
--

LOCK TABLES `tag_membership` WRITE;
/*!40000 ALTER TABLE `tag_membership` DISABLE KEYS */;
INSERT INTO `tag_membership` VALUES (1,5,23);
/*!40000 ALTER TABLE `tag_membership` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(90) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`uid`),
  UNIQUE KEY `uid_UNIQUE` (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'hockenburj1@nku.edu','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8','Jessef','Hockenbury'),(2,'test@gmail.com','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8',NULL,NULL),(6,'admin@example.com','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8','Demo','User'),(7,'newguy@test.com','df9f71aae6d4743660c32761b50ac21360032f43','Wyantt','Newguys'),(9,'jh0993@gmail.com','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8','Demoed','Hockenbury');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `urid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `rid` int(11) DEFAULT NULL,
  `oid` int(11) DEFAULT NULL,
  PRIMARY KEY (`urid`),
  KEY `ur_uid_idx` (`uid`),
  KEY `ur_rid_idx` (`rid`),
  KEY `ur_oid_idx` (`oid`),
  CONSTRAINT `ur_oid` FOREIGN KEY (`oid`) REFERENCES `organization` (`oid`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `ur_rid` FOREIGN KEY (`rid`) REFERENCES `role` (`rid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `ur_uid` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (18,1,1,20),(19,1,1,21),(20,1,1,22),(21,1,1,23),(22,1,1,24),(23,1,1,25),(24,1,1,26);
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `organization_view`
--

/*!50001 DROP TABLE IF EXISTS `organization_view`*/;
/*!50001 DROP VIEW IF EXISTS `organization_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `organization_view` AS select `organization`.`oid` AS `id`,`organization`.`name` AS `name`,`organization`.`description` AS `description`,`organization`.`parent_oid` AS `parent`,`organization`.`abbreviation` AS `abbreviation`,`organization`.`membership_requestable` AS `requestable` from `organization` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-10-30 16:23:36
