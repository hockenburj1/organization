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
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membership`
--

LOCK TABLES `membership` WRITE;
/*!40000 ALTER TABLE `membership` DISABLE KEYS */;
INSERT INTO `membership` VALUES (20,20,1),(21,21,1),(22,22,1),(23,23,1),(24,24,1),(25,25,1);
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
  CONSTRAINT `mr_user` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `mr_organization` FOREIGN KEY (`oid`) REFERENCES `organization` (`oid`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membership_request`
--

LOCK TABLES `membership_request` WRITE;
/*!40000 ALTER TABLE `membership_request` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organization`
--

LOCK TABLES `organization` WRITE;
/*!40000 ALTER TABLE `organization` DISABLE KEYS */;
INSERT INTO `organization` VALUES (20,'Demo School','DS','This is a demo account to test some of the functionality that is existing up and to this point.',0,'TRUE','FALSE'),(21,'Jesse','jethit','this is a description',0,'TRUE','FALSE'),(22,'Testing 2','test2','This ios for testing',20,'TRUE','FALSE'),(23,'Testing 3','Testing 3','This ios for testing',22,'TRUE','1'),(24,'Test Org','Test Org','This is a test organization i am admining',22,'TRUE','1'),(25,'Tech','tech','technology is the center of the world',20,'TRUE','FALSE');
/*!40000 ALTER TABLE `organization` ENABLE KEYS */;
UNLOCK TABLES;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission`
--

LOCK TABLES `permission` WRITE;
/*!40000 ALTER TABLE `permission` DISABLE KEYS */;
INSERT INTO `permission` VALUES (1,'Add Organization','add_organization'),(2,'Edit Organization','edit_organization'),(3,'Manage Requests','manage_requests');
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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'Administrator');
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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_membership`
--

LOCK TABLES `role_membership` WRITE;
/*!40000 ALTER TABLE `role_membership` DISABLE KEYS */;
INSERT INTO `role_membership` VALUES (20,20,1),(21,21,1),(22,22,1),(23,23,1),(24,24,1),(25,25,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_permission`
--

LOCK TABLES `role_permission` WRITE;
/*!40000 ALTER TABLE `role_permission` DISABLE KEYS */;
INSERT INTO `role_permission` VALUES (1,1,1),(1,2,2),(1,3,3);
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'hockenburj1@nku.edu','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8','Jessef','Hockenbury'),(2,'test@gmail.com','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8',NULL,NULL),(6,'admin@example.com','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8','Demo','User'),(7,'newguy@test.com','df9f71aae6d4743660c32761b50ac21360032f43','Wyantt','Newguys');
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
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (18,1,1,20),(19,1,1,21),(20,1,1,22),(21,1,1,23),(22,1,1,24),(23,1,1,25);
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-09-29 19:01:19
