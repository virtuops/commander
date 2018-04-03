-- MySQL dump 10.16  Distrib 10.1.10-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: __DB__
-- ------------------------------------------------------
-- Server version	10.1.10-MariaDB

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
-- Current Database: `__DB__`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `__DB__` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `__DB__`;

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

LOCK TABLES `auth_servers` WRITE;
/*!40000 ALTER TABLE `auth_servers` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_servers` ENABLE KEYS */;
UNLOCK TABLES;

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

LOCK TABLES `dataset` WRITE;
/*!40000 ALTER TABLE `dataset` DISABLE KEYS */;
INSERT INTO `dataset` VALUES ('MySQL Bar Example','MySQL SampleData','select purchasetype as pt,  SUM(purchaseamount) as purchaseamount from sample_purchases group by purchasetype UNION select purchaselocation as pt, SUM(purchaseamount) as purchaseamount from sample_purchases group by purchaselocation'),('MySQL Grid Example','MySQL SampleData','select spr.productname as productname, spr.productcategory as productcategory, spu.purchaseamount as purchaseamount, spu.purchasedate as purchasedate, spu.purchasetype as purchasetype, spu.purchaselocation as purchaselocation from sample_purchases spu left join sample_products spr on spu.productid = spr.productid'),('MySQL Pie Example','MySQL SampleData','select spr.productcategory as productcategory, SUM(spu.purchaseamount) as purchaseamount from sample_purchases spu left join sample_products spr on spu.productid = spr.productid group by spr.productcategory'),('XML File Example','XML File Sample',''),('XML File Gauge','XML File Gauge',''),('XML File Grid Example','XML File Grid Sample',''),('Zabbix Sample Event List','Zabbix DB',' SELECT DISTINCT host, t.description,  e.acknowledged, t.priority, t.value FROM triggers t  INNER JOIN functions f ON ( f.triggerid = t.triggerid )  INNER JOIN items i ON ( i.itemid = f.itemid )   INNER JOIN hosts ON ( i.hostid = hosts.hostid )  INNER JOIN events e ON ( e.objectid = t.triggerid )  GROUP BY f.triggerid  ORDER BY t.priority DESC');
/*!40000 ALTER TABLE `dataset` ENABLE KEYS */;
UNLOCK TABLES;

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

LOCK TABLES `ds_conn` WRITE;
/*!40000 ALTER TABLE `ds_conn` DISABLE KEYS */;
INSERT INTO `ds_conn` VALUES ('MySQL SampleData','MySQL','sampleuser','sampleuser123','localhost',3306,'','','sampledata','','Run ./sampledata.sh under the install directory to get this database and tables with data'),('XML File Gauge','XML','','','',-1,'','/var/www/html/commander/tmp/files/gauge.xml','','',''),('XML File Grid Sample','XML','','','',-1,'','/var/www/html/commander/tmp/files/opennms.xml','','',''),('XML File Sample','XML','','','',-1,'','/var/www/html/commander/tmp/files/attribute.xml','','','Using an XML File as the data source.  Demonstration only.'),('Zabbix DB','MySQL','zabbix','zabbix123!','192.99.56.209',3306,'','','zabbix','','Grabs data from hosts, items, and triggers for the last 10 minutes');
/*!40000 ALTER TABLE `ds_conn` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `groups` VALUES ('admingroup','Admin Group'),('nocusers','NOC Users');
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

LOCK TABLES `menu_tools` WRITE;
/*!40000 ALTER TABLE `menu_tools` DISABLE KEYS */;
INSERT INTO `menu_tools` VALUES ('General Tools','Ping Example'),('General Tools','SNMP Walk Example'),('RevenueTools','Purchase Email');
/*!40000 ALTER TABLE `menu_tools` ENABLE KEYS */;
UNLOCK TABLES;

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

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES ('General Tools'),('None'),('RevenueTools');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

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

LOCK TABLES `nocview_groups` WRITE;
/*!40000 ALTER TABLE `nocview_groups` DISABLE KEYS */;
INSERT INTO `nocview_groups` VALUES ('XMLFileExampleMeter','nocusers'),('XMLFileExampleMeter','admingroup'),('XMLFileExampleGrid','admingroup'),('MeterGrid','admingroup'),('MeterGrid','nocusers'),('XMLFileGauge','admingroup'),('XMLFileGauge','nocusers'),('MySQLGridExample','admingroup'),('MySQLGraphs','admingroup'),('ZabbixSampleEventList','admingroup'),('ZabbixSampleEventList','nocusers');
/*!40000 ALTER TABLE `nocview_groups` ENABLE KEYS */;
UNLOCK TABLES;

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

LOCK TABLES `nocviews` WRITE;
/*!40000 ALTER TABLE `nocviews` DISABLE KEYS */;
INSERT INTO `nocviews` VALUES ('MeterGrid','Meter Grid','XML File Example: Meter','20%','','','XML File Example: Grid','80%','','','','','','','topmain'),('MySQLGraphs','MySQL Graphs','MySQL Example: Bar','60%','MySQL Example: Pie','30%','MySQL Example: Grid','70%','','','','','','','topmainleft'),('MySQLGridExample','MySQL Grid Example','','','','','MySQL Example: Grid','100%','','','','','','','main'),('XMLFileExampleGrid','XML File Example Grid','','','','','XML File Example: Grid','100%','','','','','','','main'),('XMLFileExampleMeter','XML File Example Meter','','','','','XML File Example: Meter','100%','','','','','','','main'),('XMLFileGauge','XML File Gauge','','','','','XML File Gauge','100%','','','','','','','main'),('ZabbixSampleEventList','Zabbix Sample Event List','','','','','Zabbix Sample Event List','100%','','','','','','','main');
/*!40000 ALTER TABLE `nocviews` ENABLE KEYS */;
UNLOCK TABLES;

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

LOCK TABLES `tool_groups` WRITE;
/*!40000 ALTER TABLE `tool_groups` DISABLE KEYS */;
INSERT INTO `tool_groups` VALUES ('Ping Example','admingroup'),('Ping Example','nocusers'),('SNMP Walk Example','admingroup'),('SNMP Walk Example','nocusers'),('Email','admingroup'),('Purchase Email','admingroup');
/*!40000 ALTER TABLE `tool_groups` ENABLE KEYS */;
UNLOCK TABLES;

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
  `multirow` varchar(16) DEFAULT NULL,
  `tooltype` varchar(16) DEFAULT NULL,
  `outputcols` mediumtext,
  `launchurl` mediumtext,
  `toolfields` mediumtext,
  PRIMARY KEY (`toolname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tools`
--

LOCK TABLES `tools` WRITE;
/*!40000 ALTER TABLE `tools` DISABLE KEYS */;
INSERT INTO `tools` VALUES ('Ping Example','/var/www/html/commander/tmp/tools/ping.pl','true','false','Program','[\n{\"field\":\"host\", \"caption\":\"Host\",\"size\":\"130px\",\"sortable\":\"true\"},\n{\"field\":\"status\", \"caption\":\"Status\",\"size\":\"50%\",\"sortable\":\"true\"}\n]\n','','ipAddress'),('Purchase Email','/var/www/html/commander/tmp/tools/purchase-email.pl','false','false','Program','[\n{\"field\":\"status\", \"caption\":\"Status\",\"size\":\"200px\",\"sortable\":\"true\"},\n{\"field\":\"message\", \"caption\":\"Message\",\"size\":\"70%\",\"sortable\":\"true\"}\n]\n','','productname,productcategory,purchaseamount,purchasedate'),('SNMP Walk Example','/var/www/html/commander/tmp/tools/snmpwalk.pl','false','true','Program','[\n{\"field\":\"oid\", \"caption\":\"OID\",\"size\":\"200px\",\"sortable\":\"true\"},\n{\"field\":\"value\", \"caption\":\"Value\",\"size\":\"50%\",\"sortable\":\"true\"}\n]\n','','ipAddress,public,1.3.6.1.2.1.1');
/*!40000 ALTER TABLE `tools` ENABLE KEYS */;
UNLOCK TABLES;

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
INSERT INTO `user_groups` VALUES ('admingroup','admin'),('nocusers','someuser');
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
INSERT INTO `users` VALUES ('admin','Administrator','User','Local','$2y$10$kkxz8dBRUbJZtFIyBz2Ecey6Hebka5gAu9jO0ppCDtyjt7d34NCKW','user@company.com','pj1qnvlkhiqtraqjvsjmla55g4',NULL,1,'2017-12-23 16:43:49'),('someuser','Some','User','Local','$2y$10$iA8B5rK9ne3DZlC2EbdnneuHpwz4BAbv9UVQToSgCFCfMhu4Z3EuW','user1@company.com','47qj9shikva2tf715fsh1c6df5',NULL,0,'2000-01-01 00:00:00');
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
  `chartthreshold1_linewidth` varchar(24) DEFAULT NULL,
  `chartthreshold1_linecolor` varchar(24) DEFAULT NULL,
  `chartthreshold1_value` varchar(24) DEFAULT NULL,
  `chartthreshold1_label` varchar(24) DEFAULT NULL,
  `chartthreshold2_linewidth` varchar(24) DEFAULT NULL,
  `chartthreshold2_linecolor` varchar(24) DEFAULT NULL,
  `chartthreshold2_value` varchar(24) DEFAULT NULL,
  `chartthreshold2_label` varchar(24) DEFAULT NULL,
  `chartthreshold3_linewidth` varchar(24) DEFAULT NULL,
  `chartthreshold3_linecolor` varchar(24) DEFAULT NULL,
  `chartthreshold3_value` varchar(24) DEFAULT NULL,
  `chartthreshold3_label` varchar(24) DEFAULT NULL,
  `chartthreshold4_linewidth` varchar(24) DEFAULT NULL,
  `chartthreshold4_linecolor` varchar(24) DEFAULT NULL,
  `chartthreshold4_value` varchar(24) DEFAULT NULL,
  `chartthreshold4_label` varchar(24) DEFAULT NULL,
  `chartthreshold5_linewidth` varchar(24) DEFAULT NULL,
  `chartthreshold5_linecolor` varchar(24) DEFAULT NULL,
  `chartthreshold5_value` varchar(24) DEFAULT NULL,
  `chartthreshold5_label` varchar(24) DEFAULT NULL,
  PRIMARY KEY (`objname`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `viewobjects`
--

LOCK TABLES `viewobjects` WRITE;
/*!40000 ALTER TABLE `viewobjects` DISABLE KEYS */;
INSERT INTO `viewobjects` VALUES ('MySQL Example: Bar','chart','MySQL Bar Example','','','','','','','',60,1200,410,'bar','FFFFFF','DDDDDD','0x00000000','0x00000000','0x00000000','0x00000000','0x00000000',0,'',0,'0x00000000','0x00000000','0x00000000','0x00000000','','','','','','0x00000000','Purchases By Type','arialbd.ttf','','0A5394','9FC5E8','0A5394','USD','arial.ttf','','0A5394','9FC5E8','0A5394',2,'','','','','','','','','','','','0x00000000','','','','','','Purchase Type','Revenue','arial.ttf','','3D85C6','pt','purchaseamount','','000000','arial.ttf','','000000',40,0,'93C47D','','true','true','3DBarSoft','arial.ttf','','3D85C6','','','','','','','','',-1,'','',100,'Normal',50,10,1,'','','12','','0x000000',0,100,120,'','0x00000000','','','12','','0x000000',0,100,250,'','0x00000000',100,'OnTop','','12',100,'0x000000','','','0.00','2','6AA84F','50000','store=50000','2','6AA84F','20000','online=20000','0','0x00000000','','','0','0x00000000','','','0','0x00000000','',''),('MySQL Example: Grid','grid','MySQL Grid Example','','','','[\n{\"field\":\"productname\", \"caption\":\"Name\",\"size\":\"30%\",\"sortable\":\"true\"},\n{\"field\":\"productcategory\", \"caption\":\"Category\",\"size\":\"130px\",\"sortable\":\"true\"},\n{\"field\":\"purchaseamount\", \"caption\":\"Amount\",\"size\":\"100px\",\"sortable\":\"true\",\"render\":\"money\"},\n{\"field\":\"purchasedate\", \"caption\":\"Date\",\"size\":\"140px\",\"sortable\":\"true\"},\n{\"field\":\"purchasetype\", \"caption\":\"Type\",\"size\":\"110px\",\"sortable\":\"true\"},\n{\"field\":\"purchaselocation\", \"caption\":\"Location\",\"size\":\"110px\",\"sortable\":\"true\"},\n]\n','','None','RevenueTools',60,200,200,'','0x00000000','0x00000000','0x00000000','0x00000000','0x00000000','0x00000000','0x00000000',0,'',0,'0x00000000','0x00000000','0x00000000','0x00000000','','','','','','0x00000000','','','','0x000000','0x00000000','0x00000000','','','','0x000000','0x00000000','0x000000',8,'','','','','','','','','','','','0x00000000','','','','','','','','','','0x00000000','','','','0x000000','','','0x000000',40,90,'','','','','','','','0x00000000','','','','','','','','',-1,'','',100,'Normal',50,10,1,'','','12','','0x000000',0,100,120,'','0x00000000','','','12','','0x000000',0,100,250,'','0x00000000',100,'OnTop','','12',100,'0x000000','','','0.00','0','0x00000000','','','0','0x00000000','','','0','0x00000000','','','0','0x00000000','','','0','0x00000000','',''),('MySQL Example: Pie','chart','MySQL Pie Example','','','','','','','',45,350,350,'pie','0x00000000','0x00000000','0x00000000','0x00000000','0x00000000','0x00000000','0x00000000',0,'',0,'0x00000000','0x00000000','0x00000000','0x00000000','','','','','','0x00000000','Revenue By Category','arialbd.ttf','','0A5394','9FC5E8','0A5394','USD','arial.ttf','','0A5394','9FC5E8','0A5394',2,'','','','','','','','','','','','0x00000000','','','','','','','','','','0x00000000','productcategory','purchaseamount','','0x000000','','','0x000000',40,90,'','','','','','','','0x00000000','','','','','','','','',-1,'#ABEBC6, #AED6F1,#F7DC6F','3D Donut Gradient',100,'Normal',50,10,1,'','','12','','0x000000',0,100,120,'','0x00000000','','','12','','0x000000',0,100,250,'','0x00000000',100,'OnTop','','12',100,'0x000000','','','0.00','0','0x00000000','','','0','0x00000000','','','0','0x00000000','','','0','0x00000000','','','0','0x00000000','',''),('XML File Example: Grid','grid','XML File Grid Example','alarm','','','[\n{\"field\":\"ipAddress\", \"caption\":\"Node\",\"size\":\"130px\",\"sortable\":\"true\"},\n{\"field\":\"description\", \"caption\":\"Summary\",\"size\":\"50%\",\"sortable\":\"true\"},\n{\"field\":\"severity\", \"caption\":\"Severity\",\"size\":\"130px\",\"sortable\":\"true\"},\n{\"field\":\"lastEventTime\", \"caption\":\"Last Occurrence\",\"size\":\"140px\",\"sortable\":\"true\"}\n]\n','[\n{\"severity\":\"CRITICAL\",\"style\":\"background-color: #E74C3C\"},\n{\"severity\":\"MAJOR\",\"style\":\"background-color: #F0B27A\"},\n{\"severity\":\"MINOR\",\"style\":\"background-color: #FFF68F\"},\n{\"severity\":\"WARNING\",\"style\":\"background-color: #85C1E9\"},\n{\"severity\":\"NORMAL\",\"style\":\"background-color: #FFFFFF\"},\n{\"severity\":\"CLEARED\",\"style\":\"background-color: #82E0AA\"},\n{\"severity\":\"INDETERMINATE\",\"style\":\"background-color: #C39BDA\"}\n]\n','','General Tools',60,200,200,'','0x00000000','0x00000000','0x00000000','0x00000000','0x00000000','0x00000000','0x00000000',0,'',0,'0x00000000','0x00000000','0x00000000','0x00000000','','','','','','0x00000000','','','','0x000000','0x00000000','0x00000000','','','','0x000000','0x00000000','0x000000',8,'','','','','','','','','','','','0x00000000','','','','','','','','','','0x00000000','','','','0x000000','','','0x000000',40,90,'','','','','','','','0x00000000','','','','','','','','',-1,'','',100,'Normal',50,10,1,'','','12','','0x000000',0,100,120,'','0x00000000','','','12','','0x000000',0,100,250,'','0x00000000',100,'OnTop','','12',100,'0x000000','','','0.00','0','0x00000000','','','0','0x00000000','','','0','0x00000000','','','0','0x00000000','','','0','0x00000000','',''),('XML File Example: Meter','chart','XML File Example','Perf,Datapoint,CpuAvg','','','','','','',10,1100,100,'meter','0x00000000','0x00000000','0x00000000','0x00000000','0x00000000','0x00000000','0x00000000',0,'',0,'0x00000000','0x00000000','0x00000000','0x00000000','','','','','','0x00000000','','','','0x000000','0x00000000','0x00000000','','','','0x000000','0x00000000','0x000000',8,'','','','','','','','','','','','0x00000000','','','','','','','','','','0x00000000','@max','','','0x000000','','','0x000000',40,90,'','','','','','','','0x00000000','','','','','','','','',-1,'','',100,'Normal',50,10,1,'','','12','','0x000000',0,100,120,'','0x00000000','Horizontal','arial.ttf','10','CPU Avg','0A5394',0,100,250,'0A5394','CFE2F3',5,'OnTop','','12',100,'0x000000','','','0.00','0','0x00000000','','','0','0x00000000','','','0','0x00000000','','','0','0x00000000','','','0','0x00000000','',''),('XML File Gauge','chart','XML File Gauge','Perf,Datapoint','','','','','','',60,350,200,'gauge','0x00000000','0x00000000','0x00000000','0x00000000','0x00000000','0x00000000','0x00000000',0,'',0,'0x00000000','0x00000000','0x00000000','0x00000000','','','','','','0x00000000','','','','0x000000','0x00000000','0x00000000','','','','0x000000','0x00000000','0x000000',8,'','','','','','','','','','','','0x00000000','','','','','','','','','','0x00000000','CpuAvg','','','0x000000','','','0x000000',40,90,'','','','','','','','0x00000000','','','','','','','','',-1,'','',100,'Normal',25,10,5,'Rectangle','arialbi.ttf','12','CPU Avg','888888',0,100,120,'888888','EEEEEE','','','12','','0x000000',0,100,250,'','0x00000000',100,'OnTop','','12',100,'0x000000','','','0.00','0','0x00000000','','','0','0x00000000','','','0','0x00000000','','','0','0x00000000','','','0','0x00000000','',''),('Zabbix Sample Event List','grid','Zabbix Sample Event List','','','','[\n{\"field\":\"host\", \"caption\":\"Name\",\"size\":\"250px\",\"sortable\":\"true\"},\n{\"field\":\"description\", \"caption\":\"Description\",\"size\":\"60%\",\"sortable\":\"true\"},\n{\"field\":\"acknowledged\", \"caption\":\"Ack\",\"size\":\"100px\",\"sortable\":\"true\"},\n{\"field\":\"priority\", \"caption\":\"Severity\",\"size\":\"140px\",\"sortable\":\"true\"},\n{\"field\":\"value\", \"caption\":\"Cleared\",\"size\":\"140px\",\"sortable\":\"true\",\"hidden\":\"true\"},\n]','[\n{\"priority\":\"5\",\"style\":\"background-color: #E74C3C\"},\n{\"priority\":\"4\",\"style\":\"background-color: #E74C3C\"},\n{\"priority\":\"3\",\"style\":\"background-color: #F0B27A\"},\n{\"priority\":\"2\",\"style\":\"background-color: #FFF68F\"},\n{\"priority\":\"1\",\"style\":\"background-color: #FFFFFF\"},\n{\"value\":\"0\",\"style\":\"background-color: #82E0AA\"}\n]\n','None','None',60,200,200,'','0x00000000','0x00000000','0x00000000','0x00000000','0x00000000','0x00000000','0x00000000',0,'',0,'0x00000000','0x00000000','0x00000000','0x00000000','','','','','','0x00000000','','','','0x000000','0x00000000','0x00000000','','','','0x000000','0x00000000','0x000000',8,'','','','','','','','','','','','0x00000000','','','','','','','','','','0x00000000','','','','0x000000','','','0x000000',40,90,'','','','','','','','0x00000000','','','','','','','','',-1,'','',100,'Normal',50,10,1,'','','12','','0x000000',0,100,120,'','0x00000000','','','12','','0x000000',0,100,250,'','0x00000000',100,'OnTop','','12',100,'0x000000','','','0.00','0','0x00000000','','','0','0x00000000','','','0','0x00000000','','','0','0x00000000','','','0','0x00000000','','');
/*!40000 ALTER TABLE `viewobjects` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-31  8:23:40
