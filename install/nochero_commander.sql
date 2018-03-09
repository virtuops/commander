-- MySQL dump 10.15  Distrib 10.0.29-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.0.29-MariaDB

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
-- Current Database: `nochero_commander`
--

DROP DATABASE IF EXISTS `nochero_commander`;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `nochero_commander` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `nochero_commander`;

--
-- Table structure for table `auth_servers`
--

DROP TABLE IF EXISTS `auth_servers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_servers` (
  `host` varchar(64) NOT NULL,
  `port` int(11) NOT NULL,
  `organization` varchar(64) NOT NULL,
  `type` varchar(24) NOT NULL,
  PRIMARY KEY (`host`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_servers`
--


--
-- Table structure for table `dataset`
--

DROP TABLE IF EXISTS `dataset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dataset` (
  `setname` varchar(64) NOT NULL,
  `connectionname` varchar(64) DEFAULT NULL,
  `query` mediumtext,
  PRIMARY KEY (`setname`),
  KEY `connectionname` (`connectionname`),
  CONSTRAINT `dataset_ibfk_2` FOREIGN KEY (`connectionname`) REFERENCES `ds_conn` (`connectionname`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dataset`
--


--
-- Table structure for table `ds_conn`
--

DROP TABLE IF EXISTS `ds_conn`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ds_conn` (
  `connectionname` varchar(64) NOT NULL,
  `connectiontype` varchar(64) DEFAULT NULL,
  `username` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `host` varchar(128) DEFAULT NULL,
  `port` int(11) DEFAULT NULL,
  `url` mediumtext,
  `fileloc` varchar(255) DEFAULT NULL,
  `database` varchar(128) DEFAULT NULL,
  `headers` mediumtext,
  `description` mediumtext,
  PRIMARY KEY (`connectionname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ds_conn`
--


--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `groupid` varchar(48) NOT NULL,
  `groupname` varchar(48) NOT NULL,
  PRIMARY KEY (`groupid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES ('admingroup','Admin Group');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_tools`
--

DROP TABLE IF EXISTS `menu_tools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_tools` (
  `menuname` varchar(64) DEFAULT NULL,
  `toolname` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_tools`
--


--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `menuname` varchar(64) NOT NULL,
  PRIMARY KEY (`menuname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--


--
-- Table structure for table `nocview_groups`
--

DROP TABLE IF EXISTS `nocview_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nocview_groups` (
  `nocviewname` varchar(64) DEFAULT NULL,
  `groupid` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nocview_groups`
--

--
-- Table structure for table `nocviews`
--

DROP TABLE IF EXISTS `nocviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nocviews` (
  `nocviewname` varchar(64) NOT NULL,
  `title` varchar(128) DEFAULT NULL,
  `toppanel` varchar(128) DEFAULT NULL,
  `topsize` varchar(16) DEFAULT NULL,
  `leftpanel` varchar(128) DEFAULT NULL,
  `leftsize` varchar(16) DEFAULT NULL,
  `mainpanel` varchar(128) DEFAULT NULL,
  `mainsize` varchar(16) DEFAULT NULL,
  `previewpanel` varchar(128) DEFAULT NULL,
  `previewsize` varchar(16) DEFAULT NULL,
  `rightpanel` varchar(128) DEFAULT NULL,
  `rightsize` varchar(16) DEFAULT NULL,
  `bottompanel` varchar(128) DEFAULT NULL,
  `bottomsize` varchar(16) DEFAULT NULL,
  `canvasname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`nocviewname`),
  KEY `canvasname` (`canvasname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nocviews`
--

--
-- Table structure for table `tool_groups`
--

DROP TABLE IF EXISTS `tool_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tool_groups` (
  `toolname` varchar(64) DEFAULT NULL,
  `groupid` varchar(48) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tool_groups`
--

--
-- Table structure for table `tools`
--

DROP TABLE IF EXISTS `tools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tools` (
  `toolname` varchar(64) NOT NULL,
  `program` varchar(255) DEFAULT NULL,
  `everyrow` varchar(16) DEFAULT NULL,
  `tooltype` varchar(16) DEFAULT NULL,
  `launchurl` mediumtext,
  `toolfields` mediumtext,
  PRIMARY KEY (`toolname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tools`
--

--
-- Table structure for table `user_groups`
--

DROP TABLE IF EXISTS `user_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_groups` (
  `groupid` varchar(48) NOT NULL,
  `username` varchar(48) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_groups`
--

LOCK TABLES `user_groups` WRITE;
/*!40000 ALTER TABLE `user_groups` DISABLE KEYS */;
INSERT INTO `user_groups` VALUES ('admingroup','admin');
/*!40000 ALTER TABLE `user_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `username` varchar(48) NOT NULL,
  `firstname` varchar(24) NOT NULL,
  `lastname` varchar(24) NOT NULL,
  `authmethod` varchar(24) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(96) DEFAULT NULL,
  `sessionid` varchar(128) DEFAULT NULL,
  `locked` tinyint(1) DEFAULT NULL,
  `LoginCount` int(11) NOT NULL DEFAULT '0',
  `LastFailedLogin` datetime NOT NULL DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('admin','Administrator','User','Local','$2y$10$kkxz8dBRUbJZtFIyBz2Ecey6Hebka5gAu9jO0ppCDtyjt7d34NCKW','user@company.com','p5s3epdciqvdkkbcchbjiv0tq7',NULL,1,'2017-12-23 16:43:49');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `viewobjects`
--

DROP TABLE IF EXISTS `viewobjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `viewobjects` (
  `objname` varchar(64) NOT NULL,
  `objtype` varchar(24) DEFAULT NULL,
  `setname` varchar(64) DEFAULT NULL,
  `reststartproperty` varchar(512) DEFAULT NULL,
  `objurl` mediumtext,
  `objmarkup` mediumtext,
  `gridcolumns` mediumtext,
  `colformat` mediumtext,
  `toolbarmenu` varchar(64) DEFAULT NULL,
  `contextmenu` varchar(64) DEFAULT NULL,
  `refreshrate` int(11) DEFAULT '60',
  `chartwidth` int(11) DEFAULT '250',
  `chartheight` int(11) DEFAULT '250',
  `charttype` varchar(24) DEFAULT NULL,
  `chartbackgroundcolor` varchar(24) DEFAULT NULL,
  `chartaltbackgroundcolor` varchar(24) DEFAULT NULL,
  `chartedgecolor` varchar(24) DEFAULT NULL,
  `charthgridcolor` varchar(24) DEFAULT NULL,
  `chartvgridcolor` varchar(24) DEFAULT NULL,
  `chartbordercolor` varchar(24) DEFAULT NULL,
  `chartborder3d` varchar(24) DEFAULT NULL,
  `chartborderrounding` int(11) DEFAULT NULL,
  `chartborderextcolor` varchar(24) DEFAULT NULL,
  `chartborderthickness` int(11) DEFAULT NULL,
  `chartframecolor` varchar(24) DEFAULT NULL,
  `chartframeinnercolor` varchar(24) DEFAULT NULL,
  `chartframeoutercolor` varchar(24) DEFAULT NULL,
  `chartdropshadowcolor` varchar(24) DEFAULT NULL,
  `chartdropshadowoffsetx` varchar(24) DEFAULT NULL,
  `chartdropshadowoffsety` varchar(24) DEFAULT NULL,
  `chartdropshadowblurradius` varchar(24) DEFAULT NULL,
  `chartwallpaper` varchar(512) DEFAULT NULL,
  `chartbackgroundimg` varchar(512) DEFAULT NULL,
  `charttransparentcolor` varchar(24) DEFAULT NULL,
  `charttitle` varchar(512) DEFAULT NULL,
  `charttitlefont` varchar(24) DEFAULT NULL,
  `charttitlefontsize` varchar(24) DEFAULT NULL,
  `charttitlefontcolor` varchar(24) DEFAULT NULL,
  `charttitlebgcolor` varchar(24) DEFAULT NULL,
  `charttitleedgecolor` varchar(24) DEFAULT NULL,
  `chartsubtitle` varchar(512) DEFAULT NULL,
  `chartsubtitlefont` varchar(24) DEFAULT NULL,
  `chartsubtitlefontsize` varchar(24) DEFAULT NULL,
  `chartsubtitlefontcolor` varchar(24) DEFAULT NULL,
  `chartsubtitlebgcolor` varchar(24) DEFAULT NULL,
  `chartsubtitleedgecolor` varchar(24) DEFAULT NULL,
  `chartsubtitleposition` int(11) DEFAULT '8',
  `chartlegendx` varchar(24) DEFAULT NULL,
  `chartlegendy` varchar(24) DEFAULT NULL,
  `chartlegendvert` varchar(24) DEFAULT NULL,
  `chartlegendfont` varchar(24) DEFAULT NULL,
  `chartlegendfontsize` varchar(24) DEFAULT NULL,
  `chartlegendnumcols` varchar(24) DEFAULT NULL,
  `chartaddtextx` varchar(24) DEFAULT NULL,
  `chartaddtexty` varchar(24) DEFAULT NULL,
  `chartaddtextfont` varchar(24) DEFAULT NULL,
  `chartaddtexttext` varchar(512) DEFAULT NULL,
  `chartaddtextfontsize` varchar(24) DEFAULT NULL,
  `chartaddtextfontcolor` varchar(24) DEFAULT NULL,
  `chartaddtextalignment` varchar(24) DEFAULT NULL,
  `chartaddtextangle` varchar(24) DEFAULT NULL,
  `chartx` varchar(24) DEFAULT NULL,
  `charty` varchar(24) DEFAULT NULL,
  `chartswapxy` varchar(24) DEFAULT 'false',
  `chartxtitle` varchar(128) DEFAULT NULL,
  `chartytitle` varchar(128) DEFAULT NULL,
  `chartytitlefont` varchar(128) DEFAULT NULL,
  `chartytitlefontsize` varchar(24) DEFAULT NULL,
  `chartytitlefontcolor` varchar(24) DEFAULT NULL,
  `chartdscolx` varchar(128) DEFAULT NULL,
  `chartdscoly` varchar(128) DEFAULT NULL,
  `chartdscolz` varchar(128) DEFAULT NULL,
  `chartaxiscolor` varchar(24) DEFAULT NULL,
  `chartaxisfont` varchar(24) DEFAULT NULL,
  `chartaxisfontsize` varchar(24) DEFAULT NULL,
  `chartaxisfontcolor` varchar(24) DEFAULT NULL,
  `chartaxisspacing` int(11) DEFAULT NULL,
  `chartaxisangle` int(11) DEFAULT NULL,
  `chartbarcolor_single` varchar(24) DEFAULT NULL,
  `chartbarcolor_multi` varchar(1024) DEFAULT NULL,
  `chartbarroundedcorners` varchar(24) DEFAULT 'false',
  `chartbarlabels` varchar(24) DEFAULT 'false',
  `chartbareffect` varchar(24) DEFAULT 'Normal',
  `chartxtitlefont` varchar(24) DEFAULT NULL,
  `chartxtitlefontsize` varchar(24) DEFAULT NULL,
  `chartxtitlefontcolor` varchar(24) DEFAULT NULL,
  `chartbargrouptype` varchar(24) DEFAULT NULL,
  `chartlineeffect` varchar(24) DEFAULT NULL,
  `chartlinecolor_single` varchar(24) DEFAULT NULL,
  `chartlinecolor_multi` varchar(1024) DEFAULT NULL,
  `chartareacolor_multi` varchar(1024) DEFAULT NULL,
  `chartareacolor_single` varchar(24) DEFAULT NULL,
  `chartareaeffect` varchar(24) DEFAULT NULL,
  `chartareagrouptype` varchar(24) DEFAULT NULL,
  `chartpiebreakoutslice` int(11) DEFAULT '-1',
  `chartpiecolor_multi` varchar(1024) DEFAULT NULL,
  `chartpieeffect` varchar(24) DEFAULT NULL,
  `chartpieradius` int(11) DEFAULT '100',
  `chartpielabels` varchar(24) DEFAULT 'Normal',
  `chartgaugemajortick` int(11) DEFAULT '50',
  `chartgaugeminortick` int(11) DEFAULT '10',
  `chartgaugemicrotick` int(11) DEFAULT '5',
  `chartgaugeeffect` varchar(24) DEFAULT NULL,
  `chartgaugefont` varchar(24) DEFAULT NULL,
  `chartgaugefontsize` varchar(24) DEFAULT NULL,
  `chartgaugelabel` varchar(128) DEFAULT NULL,
  `chartgaugelabelcolor` varchar(24) DEFAULT NULL,
  `chartgaugebeginscale` int(11) DEFAULT '0',
  `chartgaugeendscale` int(11) DEFAULT '100',
  `chartgaugeradius` int(11) DEFAULT '120',
  `chartgaugebordercolor` varchar(24) DEFAULT NULL,
  `chartgaugebgcolor` varchar(24) DEFAULT NULL,
  `chartmetereffect` varchar(24) DEFAULT NULL,
  `chartmeterfont` varchar(24) DEFAULT NULL,
  `chartmeterfontsize` varchar(24) DEFAULT NULL,
  `chartmeterlabel` varchar(128) DEFAULT NULL,
  `chartmeterlabelcolor` varchar(128) DEFAULT NULL,
  `chartmeterbeginscale` int(11) DEFAULT '0',
  `chartmeterendscale` int(11) DEFAULT '100',
  `chartmetersize` int(11) DEFAULT '250',
  `chartmeterbordercolor` varchar(24) DEFAULT NULL,
  `chartmeterbgcolor` varchar(24) DEFAULT NULL,
  `chartmetertickinterval` int(11) DEFAULT '100',
  `chartpyramidlabels` varchar(24) DEFAULT NULL,
  `chartpyramidfont` varchar(24) DEFAULT NULL,
  `chartpyramidfontsize` varchar(24) DEFAULT NULL,
  `chartpyramidsize` int(11) DEFAULT '150',
  `chartpyramidfontcolor` varchar(24) DEFAULT NULL,
  `chartpyramideffect` varchar(24) DEFAULT NULL,
  `chartpyramidcolor_multi` varchar(1024) DEFAULT NULL,
  `chartpyramidlayergap` varchar(24) DEFAULT '0.00',
  PRIMARY KEY (`objname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-02-19 17:11:43
