-- MySQL dump 10.13  Distrib 5.7.30, for Linux (x86_64)
--
-- Host: localhost    Database: healthcare
-- ------------------------------------------------------
-- Server version	5.7.30-0ubuntu0.16.04.1

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
-- Table structure for table `WARNING`
--

DROP TABLE IF EXISTS `WARNING`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `WARNING` (
  `id` int(11) NOT NULL,
  `warning` text COLLATE utf8_unicode_ci,
  `website` text COLLATE utf8_unicode_ci,
  `token` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `WARNING`
--

LOCK TABLES `WARNING` WRITE;
/*!40000 ALTER TABLE `WARNING` DISABLE KEYS */;
INSERT INTO `WARNING` VALUES (1,'To recover your lost databases and avoid leaking it: visit http://dbrestore.to and enter your unique token f238c303f9953c44 and pay the required amount of Bitcoin to get it back. Databases that we have: healthcare. Your databases are downloaded and backed up on our servers. If we dont receive your payment in the next 9 Days, we will sell your database to the highest bidder or use them otherwise.','http://dbrestore.to','f238c303f9953c44');
/*!40000 ALTER TABLE `WARNING` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ad_commision`
--

DROP TABLE IF EXISTS `ad_commision`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ad_commision` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_commision` float NOT NULL,
  `host_commision` float NOT NULL,
  `deposit` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ad_commision`
--

LOCK TABLES `ad_commision` WRITE;
/*!40000 ALTER TABLE `ad_commision` DISABLE KEYS */;
INSERT INTO `ad_commision` VALUES (1,5,80,10,'2018-07-18 23:23:32','2018-07-18 23:23:32');
/*!40000 ALTER TABLE `ad_commision` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ad_pages`
--

DROP TABLE IF EXISTS `ad_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ad_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(250) NOT NULL,
  `page_url` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ad_pages`
--

LOCK TABLES `ad_pages` WRITE;
/*!40000 ALTER TABLE `ad_pages` DISABLE KEYS */;
INSERT INTO `ad_pages` VALUES (1,'Manage Admin','admin/add/admin-user','2018-07-17 19:44:17','2018-07-17 19:44:17'),(2,'Add Admin','admin/add/admin-user','2018-07-17 19:44:17','2018-07-17 19:44:17'),(3,'Add Property','admin/add/admin-user','2018-07-17 19:44:17','2018-07-17 19:44:17');
/*!40000 ALTER TABLE `ad_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ad_users`
--

DROP TABLE IF EXISTS `ad_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ad_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `pages` varchar(250) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ad_users`
--

LOCK TABLES `ad_users` WRITE;
/*!40000 ALTER TABLE `ad_users` DISABLE KEYS */;
INSERT INTO `ad_users` VALUES (1,'Admin','admin@healthcaretravels.com','admin123','1',1,'2018-07-17 16:45:45','2018-07-17 16:45:45');
/*!40000 ALTER TABLE `ad_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agency`
--

DROP TABLE IF EXISTS `agency`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agency` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=259 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agency`
--

LOCK TABLES `agency` WRITE;
/*!40000 ALTER TABLE `agency` DISABLE KEYS */;
INSERT INTO `agency` VALUES (6,'24 Hour Medical Staffing',0,'2018-10-22 06:26:50','2018-10-22 06:26:50'),(7,'AB Staffing',0,'2018-10-22 06:27:07','2018-10-22 06:27:07'),(8,'ACCOUNTABLE HEALTHCARE STAFFING',0,'2018-10-22 06:27:21','2018-10-22 06:27:21'),(9,'Adex',0,'2018-10-22 06:27:56','2018-10-22 06:27:56'),(10,'ACES',0,'2018-10-22 06:28:14','2018-10-22 06:28:14'),(11,'Advance Med',0,'2018-10-22 06:28:30','2018-10-22 06:28:30'),(12,'Advance Medical Staffing',0,'2018-10-22 06:28:50','2018-10-22 06:28:50'),(13,'Advanced Surgical',0,'2018-10-22 06:29:02','2018-10-22 06:29:02'),(15,'Advantage RN',0,'2018-10-24 04:59:31','2018-10-24 04:59:31'),(16,'Agostini',0,'2018-10-24 04:59:47','2018-10-24 04:59:47'),(17,'AHS Pharmastat',0,'2018-10-24 05:00:59','2018-10-24 05:00:59'),(18,'AHS Renalstat',0,'2018-10-24 05:02:06','2018-10-24 05:02:06'),(19,'Alegiant Healthcare',0,'2018-10-24 05:02:30','2018-10-24 05:02:30'),(20,'Alignment Medical Solutions (AKA; Voyage)',0,'2018-10-24 05:02:46','2018-10-24 05:02:46'),(21,'All About Staffing',0,'2018-10-24 05:03:39','2018-10-24 05:03:39'),(22,'All Health Staffing',0,'2018-10-24 05:06:53','2018-10-24 05:06:53'),(23,'Alliant Medical Staffing',0,'2018-10-24 05:07:50','2018-10-24 05:07:50'),(24,'Allied Medical Resources',0,'2018-10-24 05:08:09','2018-10-24 05:08:09'),(25,'Altres Medical',0,'2018-10-24 05:08:48','2018-10-24 05:08:48'),(26,'American Medical Traveler',0,'2018-10-24 05:09:04','2018-10-24 05:09:04'),(27,'American Mobile',0,'2018-10-24 05:09:19','2018-10-24 05:09:19'),(28,'American Traveler',0,'2018-10-24 05:09:34','2018-10-24 05:09:34'),(29,'AMN',0,'2018-10-24 05:09:57','2018-10-24 05:09:57'),(30,'Anders Group',0,'2018-10-24 05:10:11','2018-10-24 05:10:11'),(31,'Anderson and Bates',0,'2018-10-24 05:10:31','2018-10-24 05:10:31'),(32,'Assured Nursing',0,'2018-10-24 05:11:03','2018-10-24 05:11:03'),(33,'Atlas Healthcare',0,'2018-10-24 05:11:20','2018-10-24 05:11:20'),(34,'Atlas MedStaff',0,'2018-10-24 05:11:39','2018-10-24 05:11:39'),(35,'Aureus',0,'2018-10-24 05:11:57','2018-10-24 05:11:57'),(36,'Axis Medical Staffing',0,'2018-10-24 05:12:23','2018-10-24 05:12:23'),(37,'Aya Healthcare',0,'2018-10-24 05:12:36','2018-10-24 05:12:36'),(38,'BalancePoint Staffing',0,'2018-10-24 05:12:51','2018-10-24 05:12:51'),(39,'Barton & Associates',0,'2018-10-24 05:13:06','2018-10-24 05:13:06'),(40,'Bridge Staffing',0,'2018-10-24 05:13:26','2018-10-24 05:13:26'),(41,'BrightMed',0,'2018-10-24 05:13:48','2018-10-24 05:13:48'),(42,'Capability Healthcare',0,'2018-10-24 05:14:21','2018-10-24 05:14:21'),(43,'Cardinal Nursing Healthcare Staffing',0,'2018-10-24 05:14:50','2018-10-24 05:14:50'),(44,'Cariant Health Partners',0,'2018-10-24 05:15:07','2018-10-24 05:15:07'),(45,'Century Health',0,'2018-10-24 05:15:23','2018-10-24 05:15:23'),(46,'Chesapeake Medical Staffing',0,'2018-10-24 05:15:41','2018-10-24 05:15:41'),(47,'Cirrus',0,'2018-10-24 05:15:58','2018-10-24 05:15:58'),(48,'Clinical One',0,'2018-10-24 05:16:14','2018-10-24 05:16:14'),(49,'Club Staffing',0,'2018-10-24 05:16:29','2018-10-24 05:16:29'),(50,'Coastal Healthcare Resources',0,'2018-10-24 05:16:43','2018-10-24 05:16:43'),(51,'Concentric Healthcare Staffing',0,'2018-10-24 05:16:58','2018-10-24 05:16:58'),(52,'ConTemporary Nursing Solutions',0,'2018-10-24 05:17:19','2018-10-24 05:17:19'),(53,'Continental Nurses',0,'2018-10-24 05:17:47','2018-10-24 05:17:47'),(54,'Continuum Medical Staffing Agency',0,'2018-10-24 05:18:03','2018-10-24 05:18:03'),(55,'Convergence Medical Staffing',0,'2018-10-24 05:18:21','2018-10-24 05:18:21'),(56,'Core Medical Group',0,'2018-10-24 05:18:37','2018-10-24 05:18:37'),(57,'Corratel',0,'2018-10-24 05:18:51','2018-10-24 05:18:51'),(58,'Corratel Healthcare',0,'2018-10-24 05:19:07','2018-10-24 05:19:07'),(59,'Crdentia',0,'2018-10-24 05:19:21','2018-10-24 05:19:21'),(60,'Critical Nursing Solutions',0,'2018-10-24 05:19:37','2018-10-24 05:19:37'),(61,'Critical Options',0,'2018-10-24 05:20:16','2018-10-24 05:20:16'),(62,'Criticore',0,'2018-10-24 05:20:31','2018-10-24 05:20:31'),(63,'Cross Country TravCorps',0,'2018-10-24 05:20:53','2018-10-24 05:20:53'),(64,'Curamed',0,'2018-10-24 05:21:08','2018-10-24 05:21:08'),(65,'Curastat Healthcare',0,'2018-10-24 05:21:28','2018-10-24 05:21:28'),(66,'Cynthia',0,'2018-10-24 05:21:43','2018-10-24 05:21:43'),(67,'Dakota Travel Nurse',0,'2018-10-24 05:21:56','2018-10-24 05:21:56'),(68,'Day one staffing',0,'2018-10-24 05:22:15','2018-10-24 05:22:15'),(69,'debbie briggs',0,'2018-10-24 05:22:31','2018-10-24 05:22:31'),(70,'Dedicated Nursing Associates, Inc',0,'2018-10-24 05:22:56','2018-10-24 05:22:56'),(71,'Dependable Staffing',0,'2018-10-24 05:23:12','2018-10-24 05:23:12'),(72,'Dzeel Clinical Healthcare Staffing',0,'2018-10-24 05:23:28','2018-10-24 05:23:28'),(73,'Elite & Genesis Medical Staffing',0,'2018-10-24 05:23:47','2018-10-24 05:23:47'),(74,'Emerald Health Services',0,'2018-10-24 05:24:34','2018-10-24 05:24:34'),(75,'EmPower Nursing & Allied Solutions',0,'2018-10-24 05:25:11','2018-10-24 05:25:11'),(76,'Envision Healthcare aka Vista Staffing',0,'2018-10-24 05:26:13','2018-10-24 05:26:13'),(77,'Expedient Medstaff',0,'2018-10-24 05:26:36','2018-10-24 05:26:36'),(78,'EZ Staffing, Inc.',0,'2018-10-24 05:26:59','2018-10-24 05:26:59'),(79,'Fastaff',0,'2018-10-24 05:27:16','2018-10-24 05:27:16'),(80,'Favorite Healthcare Staffing',0,'2018-10-24 05:27:32','2018-10-24 05:27:32'),(81,'Fidelity On Call',0,'2018-10-24 05:27:58','2018-10-24 05:27:58'),(82,'Fifty States Staffing',0,'2018-10-24 05:28:54','2018-10-24 05:28:54'),(83,'FlexCare Medical Staffing',0,'2018-10-24 05:29:24','2018-10-24 05:29:24'),(84,'FlexRN in Stafford, Virginia',0,'2018-10-24 05:29:42','2018-10-24 05:29:42'),(85,'focus staffing',0,'2018-10-24 05:29:58','2018-10-24 05:29:58'),(86,'Fortus Group',0,'2018-10-24 05:30:10','2018-10-24 05:30:10'),(87,'Foundation Medical Staffing',0,'2018-10-24 05:30:26','2018-10-24 05:30:26'),(88,'FreedomHCS',0,'2018-10-24 05:30:45','2018-10-24 05:30:45'),(89,'Fusion Medical Staffing',0,'2018-10-24 05:30:59','2018-10-24 05:30:59'),(90,'Galileo Search',0,'2018-10-24 05:31:25','2018-10-24 05:31:25'),(91,'Genie Healthcare',0,'2018-10-24 05:31:50','2018-10-24 05:31:50'),(92,'GHR Travel Nursing',0,'2018-10-24 05:32:10','2018-10-24 05:32:10'),(93,'Gifted Healthcare',0,'2018-10-24 05:32:24','2018-10-24 05:32:24'),(94,'Go Healthcare Staffing',0,'2018-10-24 05:32:40','2018-10-24 05:32:40'),(95,'Grape Tree Medical Staffing',0,'2018-10-24 05:32:58','2018-10-24 05:32:58'),(96,'Greenleaf Travel Nurse Staffing',0,'2018-10-24 05:33:14','2018-10-24 05:33:14'),(97,'Hamilton Staffing Solutions',0,'2018-10-24 05:33:31','2018-10-24 05:33:31'),(98,'HARTRA',0,'2018-10-24 05:33:48','2018-10-24 05:33:48'),(99,'Health Carousel',0,'2018-10-24 05:34:04','2018-10-24 05:34:04'),(100,'Health One Medical Staffing',0,'2018-10-24 05:34:26','2018-10-24 05:34:26'),(101,'Health Providers Choice',0,'2018-10-24 05:34:44','2018-10-24 05:34:44'),(102,'health source global',0,'2018-10-24 05:35:02','2018-10-24 05:35:02'),(103,'Health Specialists',0,'2018-10-24 05:35:23','2018-10-24 05:35:23'),(104,'Health-Force',0,'2018-10-24 05:35:38','2018-10-24 05:35:38'),(105,'Healthcare Pros',0,'2018-10-24 05:35:59','2018-10-24 05:35:59'),(106,'Healthcare Seeker',0,'2018-10-24 05:36:19','2018-10-24 05:36:19'),(107,'Healthcare Staffing Network',0,'2018-10-24 05:36:33','2018-10-24 05:36:33'),(108,'Healthtrust',0,'2018-10-24 05:36:47','2018-10-24 05:36:47'),(109,'HorizonNursingServices',0,'2018-10-24 05:38:21','2018-10-24 05:38:21'),(110,'Host Healthcare',0,'2018-10-24 05:38:45','2018-10-24 05:38:45'),(111,'HRN',0,'2018-10-24 05:39:03','2018-10-24 05:39:03'),(112,'Hudson Staffing',0,'2018-10-24 05:39:17','2018-10-24 05:39:17'),(113,'Independent Healthcare',0,'2018-10-24 05:39:31','2018-10-24 05:39:31'),(114,'Innovent Global',0,'2018-10-24 05:39:48','2018-10-24 05:39:48'),(115,'InSync Consulting Services',0,'2018-10-24 05:40:03','2018-10-24 05:40:03'),(116,'Integrated Health Care',0,'2018-10-24 05:40:19','2018-10-24 05:40:19'),(117,'Interim',0,'2018-10-24 05:40:36','2018-10-24 05:40:36'),(118,'IPI Travel',0,'2018-10-24 05:40:54','2018-10-24 05:40:54'),(119,'Jackson Nurse Professionals',0,'2018-10-24 05:41:11','2018-10-24 05:41:11'),(120,'JaQuanda Boyd',0,'2018-10-24 05:41:27','2018-10-24 05:41:27'),(121,'Judith Winston',0,'2018-10-24 05:41:40','2018-10-24 05:41:40'),(122,'kemmcare',0,'2018-10-24 05:41:56','2018-10-24 05:41:56'),(123,'KPG Healthcare',0,'2018-10-24 05:42:17','2018-10-24 05:42:17'),(124,'Liberty Healthcare',0,'2018-10-24 05:42:33','2018-10-24 05:42:33'),(125,'Liquid Agents',0,'2018-10-24 05:42:47','2018-10-24 05:42:47'),(126,'LiquidAgents',0,'2018-10-24 05:43:06','2018-10-24 05:43:06'),(127,'LiquidAgents Healthcare',0,'2018-10-24 05:43:24','2018-10-24 05:43:24'),(128,'LRS',0,'2018-10-24 05:43:40','2018-10-24 05:43:40'),(129,'LRS Healthcare',0,'2018-10-24 05:43:57','2018-10-24 05:43:57'),(130,'Margaret E Lynch',0,'2018-10-24 05:44:15','2018-10-24 05:44:15'),(131,'MAS Medical Staffing',0,'2018-10-24 05:44:30','2018-10-24 05:44:30'),(132,'Maxim Healthcare',0,'2018-10-24 05:44:44','2018-10-24 05:44:44'),(133,'Med Pro Staffing',0,'2018-10-24 05:45:02','2018-10-24 05:45:02'),(134,'Med-Call Healthcare, Inc',0,'2018-10-24 05:45:17','2018-10-24 05:45:17'),(135,'Med-Call Healthcare, Inc',0,'2018-10-24 05:45:32','2018-10-24 05:45:32'),(136,'Medical Express',0,'2018-10-24 05:45:53','2018-10-24 05:45:53'),(137,'Medical One Staffers',0,'2018-10-24 05:46:09','2018-10-24 05:46:09'),(138,'Medical Solutions',0,'2018-10-24 05:46:22','2018-10-24 05:46:22'),(139,'Medical Staffers.com',0,'2018-10-24 05:46:44','2018-10-24 05:46:44'),(140,'Medical Staffing Network',0,'2018-10-24 05:47:05','2018-10-24 05:47:05'),(141,'Medical Staffing Options',0,'2018-10-24 05:47:19','2018-10-24 05:47:19'),(142,'Medical staffing solutions',0,'2018-10-24 05:47:33','2018-10-24 05:47:33'),(143,'Medical Staffing Solutions LLC',0,'2018-10-24 05:47:47','2018-10-24 05:47:47'),(144,'Medical Staffing Solutions, Inc.',0,'2018-10-24 05:48:01','2018-10-24 05:48:01'),(145,'Mediscan Staffing Services',0,'2018-10-24 05:48:19','2018-10-24 05:48:19'),(146,'Medpartners HIM',0,'2018-10-24 05:48:35','2018-10-24 05:48:35'),(147,'Medpartners HIM',0,'2018-10-24 05:48:48','2018-10-24 05:48:48'),(148,'Medstaff',0,'2018-10-24 05:49:04','2018-10-24 05:49:04'),(149,'Medtemps',0,'2018-10-24 05:49:18','2018-10-24 05:49:18'),(150,'Meridian Medical Staffing',0,'2018-10-24 05:49:37','2018-10-24 05:49:37'),(151,'MGA',0,'2018-10-24 05:49:49','2018-10-24 05:49:49'),(152,'Millenia Medical Staffing',0,'2018-10-24 05:50:05','2018-10-24 05:50:05'),(153,'MOORE NURSES',0,'2018-10-24 05:50:21','2018-10-24 05:50:21'),(154,'Mountain Vista Medical Center Nurse Recruiter',0,'2018-10-24 05:50:21','2018-10-24 05:50:21'),(155,'National Healthcare Staffing',0,'2018-10-24 05:51:51','2018-10-24 05:51:51'),(156,'National Nurses Plus',0,'2018-10-24 05:52:24','2018-10-24 05:52:24'),(157,'Nationwide Nurses',0,'2018-10-24 05:52:44','2018-10-24 05:52:44'),(158,'New Directions',0,'2018-10-24 05:52:58','2018-10-24 05:52:58'),(159,'Next Travel Nursing',0,'2018-10-24 05:53:32','2018-10-24 05:53:32'),(160,'Nightingale',0,'2018-10-24 05:54:03','2018-10-24 05:54:03'),(161,'Novapro',0,'2018-10-24 05:54:25','2018-10-24 05:54:25'),(162,'Nurse Choice',0,'2018-10-24 05:54:43','2018-10-24 05:54:43'),(163,'Nurse Connection',0,'2018-10-24 05:55:04','2018-10-24 05:55:04'),(164,'Nurse Education Development Centers',0,'2018-10-24 05:55:17','2018-10-24 05:55:17'),(165,'Nurse Finders',0,'2018-10-24 05:55:37','2018-10-24 05:55:37'),(166,'Nurses First Staffing',0,'2018-10-24 05:56:12','2018-10-24 05:56:12'),(167,'Nurses in Partnership',0,'2018-10-24 05:56:25','2018-10-24 05:56:25'),(168,'Nurses PRN',0,'2018-10-24 05:56:40','2018-10-24 05:56:40'),(169,'Nurses Rx',0,'2018-10-24 05:56:56','2018-10-24 05:56:56'),(170,'NURSING OPTIONS',0,'2018-10-24 05:57:15','2018-10-24 05:57:15'),(171,'NuWest Group',0,'2018-10-24 05:57:37','2018-10-24 05:57:37'),(172,'O\'Grady Peyton',0,'2018-10-24 05:57:52','2018-10-24 05:57:52'),(173,'Onestaff Medical',0,'2018-10-24 05:58:08','2018-10-24 05:58:08'),(174,'Onward Healthcare',0,'2018-10-24 05:58:24','2018-10-24 05:58:24'),(175,'OR Nurses',0,'2018-10-24 05:58:43','2018-10-24 05:58:43'),(176,'Parallon aka All about staff',0,'2018-10-24 05:58:58','2018-10-24 05:58:58'),(177,'Patient Ready Clinicians, LLC',0,'2018-10-24 05:59:13','2018-10-24 05:59:13'),(178,'Perspective Medical Careers',0,'2018-10-24 05:59:30','2018-10-24 05:59:30'),(179,'Plains Medical Staffing',0,'2018-10-24 05:59:44','2018-10-24 05:59:44'),(180,'Power Personnel',0,'2018-10-24 05:59:59','2018-10-24 05:59:59'),(181,'PPR Travel Nursing',0,'2018-10-24 06:00:14','2018-10-24 06:00:14'),(182,'Premier Healthcare Professionals',0,'2018-10-24 06:00:29','2018-10-24 06:00:29'),(183,'Premier Medical Associates Inc.',0,'2018-10-24 06:00:46','2018-10-24 06:00:46'),(184,'Prime Time Healthcare',0,'2018-10-24 06:01:00','2018-10-24 06:01:00'),(185,'Primetime',0,'2018-10-24 06:01:14','2018-10-24 06:01:14'),(186,'ProCare One',0,'2018-10-24 06:01:30','2018-10-24 06:01:30'),(187,'Procare USA',0,'2018-10-24 06:01:44','2018-10-24 06:01:44'),(188,'PROCEL Nurses',0,'2018-10-24 06:01:59','2018-10-24 06:01:59'),(189,'Prodex Medical Staffing',0,'2018-10-24 06:02:23','2018-10-24 06:02:23'),(190,'Professional Nursing Service',0,'2018-10-24 06:02:54','2018-10-24 06:02:54'),(191,'Professional Nursing Staffing',0,'2018-10-24 06:03:17','2018-10-24 06:03:17'),(192,'Progressive Nursing Staffers in Springfield, Virginia',0,'2018-10-24 06:03:37','2018-10-24 06:03:37'),(193,'ProLink Healthcare',0,'2018-10-24 06:03:59','2018-10-24 06:03:59'),(194,'Protocol Executive Staffing',0,'2018-10-24 06:04:24','2018-10-24 06:04:24'),(195,'Provenir Staffing',0,'2018-10-24 06:04:40','2018-10-24 06:04:40'),(196,'Providence healthcare staffing',0,'2018-10-24 06:04:53','2018-10-24 06:04:53'),(197,'Pulse Clinical',0,'2018-10-24 06:05:07','2018-10-24 06:05:07'),(198,'QShift',0,'2018-10-24 06:05:19','2018-10-24 06:05:19'),(199,'Quest Group',0,'2018-10-24 06:05:33','2018-10-24 06:05:33'),(200,'Quest Staffing Group',0,'2018-10-24 06:05:57','2018-10-24 06:05:57'),(201,'Quik Travel Staffing',0,'2018-10-24 06:06:44','2018-10-24 06:06:44'),(202,'Randstad Healthcare (former known as Clinical One)',0,'2018-10-24 06:07:06','2018-10-24 06:07:06'),(203,'Rapid Temps',0,'2018-10-24 06:07:20','2018-10-24 06:07:20'),(204,'RCM Healthcare',0,'2018-10-24 06:07:33','2018-10-24 06:07:33'),(205,'Readylink',0,'2018-10-24 06:07:54','2018-10-24 06:07:54'),(206,'Republic Health Resources',0,'2018-10-24 06:08:07','2018-10-24 06:08:07'),(207,'Resource Healthcare Solutions',0,'2018-10-24 06:08:21','2018-10-24 06:08:21'),(208,'Rich Healthcare(RHS)',0,'2018-10-24 06:08:58','2018-10-24 06:08:58'),(209,'Richards Healthcare',0,'2018-10-24 06:10:02','2018-10-24 06:10:02'),(210,'Rise Medical Staffing',0,'2018-10-24 06:10:18','2018-10-24 06:10:18'),(211,'RN Demand',0,'2018-10-24 06:11:09','2018-10-24 06:11:09'),(212,'RN RECRUIT',0,'2018-10-24 06:12:36','2018-10-24 06:12:36'),(213,'RNNetwork',0,'2018-10-24 06:12:57','2018-10-24 06:12:57'),(214,'Robinson Medical Resource Group',0,'2018-10-24 06:14:40','2018-10-24 06:14:40'),(215,'RT/RN TEMPS',0,'2018-10-24 06:15:01','2018-10-24 06:15:01'),(216,'RTG',0,'2018-10-24 06:15:35','2018-10-24 06:15:35'),(217,'Sagent Healthstaff',0,'2018-10-24 06:16:06','2018-10-24 06:16:06'),(218,'Skyline Med Staff',0,'2018-10-24 06:16:31','2018-10-24 06:16:31'),(219,'Soliant Health Care',0,'2018-10-24 06:16:46','2018-10-24 06:16:46'),(220,'Source One Healthcare Professionals',0,'2018-10-24 06:18:12','2018-10-24 06:18:12'),(221,'Southwest SWAT Nurses',0,'2018-10-24 06:18:27','2018-10-24 06:18:27'),(222,'Springboard Healthcare',0,'2018-10-24 06:19:28','2018-10-24 06:19:28'),(223,'SquadBuilders Medical Staffing',0,'2018-10-24 06:19:50','2018-10-24 06:19:50'),(224,'Stability HealthCare',0,'2018-10-24 06:20:02','2018-10-24 06:20:02'),(225,'staff care',0,'2018-10-24 06:20:14','2018-10-24 06:20:14'),(226,'Staffing Medical USA',0,'2018-10-24 06:20:27','2018-10-24 06:20:27'),(227,'Star Nursing',0,'2018-10-24 06:21:03','2018-10-24 06:21:03'),(228,'Stat Staff Professionals',0,'2018-10-24 06:21:16','2018-10-24 06:21:16'),(229,'Strategic Healthcare Staffing',0,'2018-10-24 06:21:43','2018-10-24 06:21:43'),(230,'Sunbelt Staffing',0,'2018-10-24 06:21:59','2018-10-24 06:21:59'),(231,'Supplemental Healthcare',0,'2018-10-24 06:22:18','2018-10-24 06:22:18'),(232,'Surgical Staffing Incorporated (SSI)',0,'2018-10-24 06:22:36','2018-10-24 06:22:36'),(233,'Tailored Healthcare Staffing',0,'2018-10-24 06:23:18','2018-10-24 06:23:18'),(234,'Talemed',0,'2018-10-24 06:23:32','2018-10-24 06:23:32'),(235,'TechGroup Inc.',0,'2018-10-24 06:23:46','2018-10-24 06:23:46'),(236,'TG Healthcare',0,'2018-10-24 06:24:02','2018-10-24 06:24:02'),(237,'The Quest Group',0,'2018-10-24 06:24:17','2018-10-24 06:24:17'),(238,'The Zack Group',0,'2018-10-24 06:24:35','2018-10-24 06:24:35'),(239,'Titan Medical',0,'2018-10-24 06:24:55','2018-10-24 06:24:55'),(240,'Top Medical Staffing',0,'2018-10-24 06:25:09','2018-10-24 06:25:09'),(241,'TotalMed Staffing',0,'2018-10-24 06:25:32','2018-10-24 06:25:32'),(242,'Travel Force',0,'2018-10-24 06:25:47','2018-10-24 06:25:47'),(243,'Travel Nurse Across America',0,'2018-10-24 06:26:05','2018-10-24 06:26:05'),(244,'Travel Nurse Soutions',0,'2018-10-24 06:27:12','2018-10-24 06:27:12'),(245,'TravelMax',0,'2018-10-24 06:27:27','2018-10-24 06:27:27'),(246,'Travmed USA',0,'2018-10-24 06:27:45','2018-10-24 06:27:45'),(247,'Triage Staffing',0,'2018-10-24 06:28:11','2018-10-24 06:28:11'),(248,'TRS Healthcare',0,'2018-10-24 06:28:34','2018-10-24 06:28:34'),(249,'Trustaff',0,'2018-10-24 06:28:49','2018-10-24 06:28:49'),(250,'United Staffing Solutions(USSI)',0,'2018-10-24 06:29:01','2018-10-24 06:29:01'),(251,'Valley Healthcare Systems Inc',0,'2018-10-24 06:29:13','2018-10-24 06:29:13'),(252,'VeroRN',0,'2018-10-24 06:29:26','2018-10-24 06:29:26'),(253,'Vertex',0,'2018-10-24 06:29:42','2018-10-24 06:29:42'),(256,'Others',0,'2018-11-09 12:51:11','2018-11-09 12:51:11'),(257,'Private',0,'2019-01-10 16:48:15','2019-01-10 16:48:15'),(258,'Name Of the Agency',0,'2019-11-16 06:16:19','2019-11-16 06:16:19');
/*!40000 ALTER TABLE `agency` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `amenities`
--

DROP TABLE IF EXISTS `amenities`;
/*!50001 DROP VIEW IF EXISTS `amenities`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `amenities` AS SELECT 
 1 AS `client_id`,
 1 AS `property_id`,
 1 AS `amenties_name`,
 1 AS `amenties_icon`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `amenities_list`
--

DROP TABLE IF EXISTS `amenities_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `amenities_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `amenities_name` varchar(500) NOT NULL,
  `icon_url` varchar(500) NOT NULL,
  `sort` int(10) NOT NULL,
  `status` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `amenties_list_fk0` (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `amenities_list`
--

LOCK TABLES `amenities_list` WRITE;
/*!40000 ALTER TABLE `amenities_list` DISABLE KEYS */;
INSERT INTO `amenities_list` VALUES (1,15465793,'Air Conditioner','public/amenities/Air%20Conditioner.png',1,1,'2018-11-10 07:11:41','0000-00-00 00:00:00'),(2,15465793,'Hot Tub','public/amenities/Bath.png',2,1,'2018-11-10 07:13:49','0000-00-00 00:00:00'),(3,15465793,'Breakfast Included','public/amenities/Break-Fast.png',3,1,'2018-11-10 07:11:52','0000-00-00 00:00:00'),(4,15465793,'Closet','public/amenities/Closet.png',4,1,'2018-11-10 07:12:55','0000-00-00 00:00:00'),(5,15465793,'Doorman','public/amenities/Door%20Keeper.png',5,1,'2018-11-10 07:13:03','0000-00-00 00:00:00'),(6,15465793,'Elevator in Building','public/amenities/Elevator.png',6,1,'2018-11-10 07:13:21','0000-00-00 00:00:00'),(7,15465793,'Essentials','public/amenities/Essentials.png',7,1,'2018-11-10 07:13:26','0000-00-00 00:00:00'),(8,15465793,'Kid Friendly','public/amenities/FamilyKid-Friendly.png',8,1,'2018-11-10 07:14:13','0000-00-00 00:00:00'),(9,15465793,'Indoor Fireplace','public/amenities/Fireplace.png',9,1,'2018-11-10 07:13:55','0000-00-00 00:00:00'),(10,15465793,'Free Parking on Premises','public/amenities/parking.png',10,1,'2018-11-10 07:13:31','0000-00-00 00:00:00'),(11,15465793,'Gym','public/amenities/Gym.png',11,1,'2018-11-10 07:13:35','0000-00-00 00:00:00'),(12,15465793,'Dryer','public/amenities/hair-dyer.png',12,1,'2018-11-10 07:13:15','0000-00-00 00:00:00'),(13,15465793,'Heating','public/amenities/Heater.png',13,1,'2018-11-10 07:13:45','0000-00-00 00:00:00'),(14,15465793,'Internet','public/amenities/Internet.png',14,1,'2018-11-10 07:14:07','0000-00-00 00:00:00'),(15,15465793,'Kitchen','public/amenities/Kitchen.png',15,1,'2018-11-10 07:14:18','0000-00-00 00:00:00'),(16,15465793,'Non Smoking','public/amenities/No-Smoking.png',16,1,'2018-11-10 07:18:13','0000-00-00 00:00:00'),(17,15465793,'Pets Allowed','public/amenities/Pet-Allowed.png',17,1,'2018-11-10 07:19:43','0000-00-00 00:00:00'),(18,15465793,'Pool','public/amenities/Pool.png',18,1,'2018-11-10 07:14:35','0000-00-00 00:00:00'),(19,15465793,'Scanner Printer','public/amenities/Printer.png',19,1,'2018-11-10 07:14:59','0000-00-00 00:00:00'),(20,15465793,'Private Entrance','public/amenities/Private-Entrance.png',20,1,'2018-11-10 07:14:41','0000-00-00 00:00:00'),(21,15465793,'projector','public/amenities/Projector.png',21,1,'2018-11-10 07:14:47','0000-00-00 00:00:00'),(22,15465793,'Scanner','public/amenities/Scanner.png',22,1,'2018-11-10 07:14:54','0000-00-00 00:00:00'),(23,15465793,'Smoking Allowed','public/amenities/Smoking-Allowed.png',23,1,'2018-11-10 07:15:15','0000-00-00 00:00:00'),(24,15465793,'Suitable For Events','public/amenities/Suitable-for-Events.png',24,1,'2018-11-10 07:15:21','0000-00-00 00:00:00'),(25,15465793,'Tv','public/amenities/Television.png',25,1,'2019-01-22 05:52:57','0000-00-00 00:00:00'),(26,15465793,'Washer','public/amenities/Washer.png',26,1,'2018-11-10 07:15:25','0000-00-00 00:00:00'),(27,15465793,'Wheelchair Accessible','public/amenities/Wheel-Chair.png',27,1,'2018-11-10 07:15:33','0000-00-00 00:00:00'),(28,15465793,'Wireless Internet','public/amenities/Wireles-Internet.png',28,1,'2018-11-10 07:15:38','0000-00-00 00:00:00'),(30,15465793,'Towels','public/amenities/Essentials.png',30,1,'2018-11-10 07:13:26','2019-01-22 07:08:00'),(29,15465793,'Netflix','public/amenities/Netflix.png',29,1,'2018-11-10 07:15:38','2019-01-22 05:09:08'),(31,15465793,'Phone','public/amenities/Phone.png',30,1,'2018-11-10 07:15:38','2019-01-22 13:00:00'),(32,15465793,'Fax','public/amenities/Printer.png',32,1,'2018-11-10 07:14:59','2019-01-22 10:00:00'),(33,15465793,'Pots and Pans','public/amenities/pots.png',33,1,'2018-11-10 07:15:38','2019-01-22 08:00:00'),(34,15465793,'Computer','public/amenities/monitor.png',34,1,'2018-11-10 07:15:38','2019-01-22 08:00:00'),(35,15465793,'Cable','public/amenities/cable.png',35,1,'2018-11-10 07:15:38','2019-01-22 08:00:00'),(36,15465793,'Garage','public/amenities/Garage.png',36,1,'2018-11-10 07:15:38','2019-01-22 08:00:00'),(37,15465793,'Security Cameras','public/amenities/Sec-Camera.png',37,1,'2019-01-22 12:12:19','2019-01-22 08:00:00'),(38,15465793,'Coffee Pot','public/amenities/Coffee-Pot.png',38,1,'2019-03-07 05:25:38','2019-01-22 08:00:00');
/*!40000 ALTER TABLE `amenities_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `become_scout`
--

DROP TABLE IF EXISTS `become_scout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `become_scout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(25) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `days` varchar(30) DEFAULT NULL,
  `is_take_photo` varchar(10) DEFAULT 'No',
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `miles` varchar(10) DEFAULT NULL,
  `information_check_allows` varchar(10) DEFAULT 'No',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `become_scout`
--

LOCK TABLES `become_scout` WRITE;
/*!40000 ALTER TABLE `become_scout` DISABLE KEYS */;
INSERT INTO `become_scout` VALUES (1,'test@yopmail.com','23213313','test','test','Sun','No','test','test','1212','Yes','2020-07-10 11:01:24','2020-07-10 11:01:24');
/*!40000 ALTER TABLE `become_scout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cancellation_policy`
--

DROP TABLE IF EXISTS `cancellation_policy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cancellation_policy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `before_1_day` float NOT NULL,
  `before_15_day` float NOT NULL,
  `before_30_day` float NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cancellation_policy`
--

LOCK TABLES `cancellation_policy` WRITE;
/*!40000 ALTER TABLE `cancellation_policy` DISABLE KEYS */;
INSERT INTO `cancellation_policy` VALUES (1,'Flexible',25,22,21,1,'2018-08-10 20:54:11','0000-00-00 00:00:00'),(2,'Moderate',40,32,210,1,'2018-08-10 20:54:10','0000-00-00 00:00:00'),(3,'Strict',90,75,60,1,'2019-03-07 13:19:24','0000-00-00 00:00:00'),(4,'Super Strict',90,75,60,1,'2019-03-07 13:19:24','2019-03-07 04:08:13');
/*!40000 ALTER TABLE `cancellation_policy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `client_settings`
--

DROP TABLE IF EXISTS `client_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(50) NOT NULL,
  `email` varchar(500) NOT NULL,
  `password` varchar(500) NOT NULL,
  `logo_url` varchar(500) NOT NULL,
  `background_image` varchar(500) NOT NULL,
  `currency_code` varchar(20) NOT NULL,
  `currency_symbol` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `currency_icon` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client_settings`
--

LOCK TABLES `client_settings` WRITE;
/*!40000 ALTER TABLE `client_settings` DISABLE KEYS */;
INSERT INTO `client_settings` VALUES (1,15465793,'admin@keepers.biz','keepers123','https://keepers.biz/wp-content/uploads/2017/09/keep2-2.png','http://192.168.31.52/keepers/public/main_background.jpg','USD','Locale.US','2018-08-09 14:46:35','2018-08-09 14:47:05','$');
/*!40000 ALTER TABLE `client_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `country_name` varchar(500) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES (1,15465793,'USA',1,'2018-09-05 06:28:19','0000-00-00 00:00:00'),(2,15465793,'India',0,'2018-09-05 06:28:29','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country_code`
--

DROP TABLE IF EXISTS `country_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `code` varchar(500) NOT NULL,
  `value` int(11) NOT NULL,
  `status` int(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country_code`
--

LOCK TABLES `country_code` WRITE;
/*!40000 ALTER TABLE `country_code` DISABLE KEYS */;
INSERT INTO `country_code` VALUES (1,15465793,'IN',91,1,'2018-01-27 19:19:32','0000-00-00 00:00:00'),(2,15465793,'US',1,1,'2018-01-27 19:20:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `country_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `coupon_code`
--

DROP TABLE IF EXISTS `coupon_code`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `coupon_code` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_name` varchar(200) DEFAULT NULL,
  `coupon_code` varchar(200) DEFAULT NULL,
  `max_no_users` int(50) unsigned DEFAULT NULL,
  `total_applied` int(10) DEFAULT '0',
  `coupon_valid_from` date DEFAULT NULL,
  `coupon_valid_to` date DEFAULT NULL,
  `is_percent` tinyint(4) DEFAULT '0',
  `coupon_type` varchar(200) DEFAULT NULL,
  `price_value` varchar(255) DEFAULT NULL,
  `description` varchar(355) DEFAULT NULL,
  `status` int(11) unsigned DEFAULT NULL COMMENT '1-Active,0-Inactive',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `coupon_code`
--

LOCK TABLES `coupon_code` WRITE;
/*!40000 ALTER TABLE `coupon_code` DISABLE KEYS */;
/*!40000 ALTER TABLE `coupon_code` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `document_type` varchar(255) NOT NULL,
  `document_url` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` VALUES (1,'GOVERNMENT_ID','https://healthcaretravels.com/public/uploads/KUFRG3UFYR.pdf',22,0,'2020-07-09 11:51:08','2020-07-09 11:51:08'),(2,'GOVERNMENT_ID','https://healthcaretravels.com/public/uploads/BXJPQ1OEQQ.jpg',24,0,'2020-07-10 08:12:10','2020-07-10 08:12:10'),(3,'GOVERNMENT_ID','https://healthcaretravels.com/public/uploads/YP29JWDOB1.jpg',25,0,'2020-07-10 10:09:27','2020-07-10 10:09:27');
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `email_config`
--

DROP TABLE IF EXISTS `email_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `email_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `message` varchar(1000) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `email_config`
--

LOCK TABLES `email_config` WRITE;
/*!40000 ALTER TABLE `email_config` DISABLE KEYS */;
INSERT INTO `email_config` VALUES (1,2,'Health Care Travels- Email Verification','Health Care Travels- Email Verification','Your email has been verified. We are excited to have you! You can click on the link below and login to your account.',0,'2018-09-27 07:13:52','2020-07-07 21:10:25'),(2,1,'Welcome to Health Care Travels','Welcome to Health Care Travels','Thank you for registering with us. Now you are able to access our platform. As a reminder, to begin using our services once you’re logged in, don’t forget to finish filling out and uploading documents in “My Profile” and “Verify Account” Again, welcome!',1,'2018-09-27 07:22:15','2018-10-16 09:45:28'),(3,1,'Welcome to Healthcare Travels','Welcome to Healthcare Travels','Thank you for registering with us. Now you are able to access our platform. As a reminder, to begin using our services once you’re logged in, don’t forget to finish filling out and uploading documents in “My Profile” and “Verify Account” Again, welcome!',0,'2018-09-27 07:22:50','2018-10-03 10:05:59'),(4,1,'Welcome to Healthcare Travels','Welcome to Healthcare Travels','Thank you for registering with us. Now you are able to access our platform. As a reminder, to begin using our services once you’re logged in, don’t forget to finish filling out and uploading documents in “My Profile” and “Verify Account” Again, welcome!',2,'2018-09-27 07:23:10','2018-10-03 10:06:15'),(5,3,'New booking Request from Health Care Travels','New booking Request from Health Care Travels','',0,'2018-09-27 07:59:14','2018-10-16 09:45:59'),(6,5,'Health Care Travels- Password Reset','Health Care Travels- Password Reset','Reset Your Password.',0,'2018-09-27 09:00:42','2018-09-27 09:00:42');
/*!40000 ALTER TABLE `email_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faq`
--

DROP TABLE IF EXISTS `faq`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(100) NOT NULL,
  `answer` varchar(1500) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faq`
--

LOCK TABLES `faq` WRITE;
/*!40000 ALTER TABLE `faq` DISABLE KEYS */;
INSERT INTO `faq` VALUES (2,'Is there a fee to create an account with Health Care Travels?','No. Creating an account is free for Travelers, Homeowners and Travel Agencies.','2018-09-27 12:40:39','2018-09-27 12:40:39'),(3,'What are the service fees for booking?','It depends. \r\nFor length of stays less than 30 days the service fee is $25.00. \r\n\r\nFor length of stays more than 30 days the service fee is $50.00. \r\n\r\n*Service fees apply to both the Traveler and the Home Owner','2018-11-09 13:47:26','2018-11-09 13:47:26'),(4,'I am having technical issues, who do I contact?','We apologize about the inconvenience. Please contact support@healthcaretravels.com Be sure to include a detailed description of the issue you are having and your contact information. Someone will get back to you within 48 hours.','2018-11-09 13:50:18','2018-11-09 13:50:18'),(5,'Do I have to create an account to search for housing?','No. Searching for housing on our platform is free. Please keep in mind in order to book housing you must have an account with us.','2018-11-09 13:52:39','2018-11-09 13:52:39'),(6,'Why do I have to upload verification documents?','It is our responsibility to ensure the safety of all our users. We ask for methods of verification to verify that indeed you are a real person. We do this to prevent scams and the misuse of our platform.','2018-11-09 13:56:14','2018-11-09 13:56:14'),(7,'What things do I need to become verified?','Each account differs and has specific verification documents. All accounts can attach social media info as a way of verification. Below is a list of a few items required to have a verified account. \r\n\r\nHomeowners- Drivers License, Utility Bill, Property Tax Statement, links to other websites where they are already hosting like Airbnb and Homeaway. \r\n\r\nAgency- Tax ID, housing recruiter contact, email of person creating the account and company website.\r\n\r\nTraveler: Drivers License, copy of your travel contract, picture of your work badge, recruiters name, email and number, practicing license number, state and board website to verify.','2018-11-09 14:07:31','2018-11-09 14:07:31'),(8,'What do I do if i\'m being asked to western union money or paypal money?','Don\'t do it. Report it to support@healthcaretravels.com or call us at 1-866-955-9944 for any suspicious activity. Please provide all evidence you may have.','2018-11-09 14:11:45','2018-11-09 14:11:45'),(9,'I don\'t see any housing options avaiable where my next assignment is what do I do?','Please email us at info@healthcaretravels.com so we can assist you further in finding housing. Please provide as much information in the email so we can better assist.','2018-11-09 14:17:12','2018-11-09 14:17:12'),(10,'How do I pay for a booking?','To pay for a booking. After you select request now. You will receive an email to your verified email we have on file. The email will have a pay now option where you will be asked to enter your banks, account number and routing number. After you submit your payment you will receive a confirmation email.','2018-12-29 18:09:34','2018-12-29 18:09:34'),(11,'What is a Scout?','A scout is a person that is physically located in an area in which another travel healthcare professional is trying to secure housing. If a listing does not have a verified stamp, travelers may request a scout. Scouts should be open to meeting with homeowners in person to check the accuracy of the home for the healthcare professional before booking.','2019-01-01 13:35:46','2019-01-01 13:35:46'),(12,'When will host receive a payout?','From the time the Traveler checks in he or she has 24-hours to submit to us their check-in form. Regardless if we do, or do not receive a check-in form from the Traveler after 24 Hours of check-in we will begin processing a payout. Host will receive a text or email. Once you have provided the information needed you will receive a payout in 2-3 days. (Exception to Holidays)','2019-01-20 20:05:21','2019-01-20 20:05:21'),(13,'What forms of payment do you accept?','n/a','2019-01-20 22:44:05','2019-01-20 22:44:05'),(14,'What if I have multiple rooms that I would like to rent out in my home?','We suggest you create separate listings for each room. This will allow you to keep track of which room(s) are available to be booked by looking at the calendar. We also suggest labeling the rooms by alphabetic or numeric order. ex: Room A or Room 1','2019-01-20 22:52:08','2019-01-20 22:52:08'),(15,'What is the difference between instant and requested booking?','Instant booking the homeowner automatically gives the approval for a booking request and Health Care Travels can collect payment right away. \r\nRequested Booking- The homeowner is more in control of which bookings they approve or reject.','2019-03-02 20:35:47','2019-03-02 20:35:47'),(16,'How much do I have to pay to reserve housing?','Travelers are required to pay 50% down if they are staying more than 30 days of the first months rent. \r\nTravelers that are staying less than 30days are required to pay the full amount.\r\nAgencies are required to pay the entire cost at booking.','2019-03-03 10:22:13','2019-03-03 10:22:13');
/*!40000 ALTER TABLE `faq` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `guest_informations`
--

DROP TABLE IF EXISTS `guest_informations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `guest_informations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_id` varchar(50) NOT NULL,
  `guest_count` int(10) NOT NULL,
  `name` varchar(100) NOT NULL DEFAULT '',
  `occupation` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `guest_informations`
--

LOCK TABLES `guest_informations` WRITE;
/*!40000 ALTER TABLE `guest_informations` DISABLE KEYS */;
/*!40000 ALTER TABLE `guest_informations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `home_category`
--

DROP TABLE IF EXISTS `home_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `home_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `category_name` varchar(500) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_category`
--

LOCK TABLES `home_category` WRITE;
/*!40000 ALTER TABLE `home_category` DISABLE KEYS */;
INSERT INTO `home_category` VALUES (1,15465793,'Great City to Explore',1,'2017-12-24 06:32:19','0000-00-00 00:00:00'),(2,15465793,'Perfect Gateways',1,'2017-12-24 06:32:41','0000-00-00 00:00:00'),(3,15465793,'Most Popular Properties',1,'2017-12-24 06:33:10','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `home_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `home_images`
--

DROP TABLE IF EXISTS `home_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `home_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `image_url` varchar(500) NOT NULL,
  `property_type` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_images`
--

LOCK TABLES `home_images` WRITE;
/*!40000 ALTER TABLE `home_images` DISABLE KEYS */;
INSERT INTO `home_images` VALUES (1,15465793,'https://healthcaretravels.com/public/locations/short_term.jpg',0,1,'2018-11-12 05:40:04','0000-00-00 00:00:00'),(2,15465793,'https://healthcaretravels.com/public/locations/long_term.jpg',1,1,'2018-11-12 05:40:11','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `home_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `home_listings`
--

DROP TABLE IF EXISTS `home_listings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `home_listings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `image_url` varchar(500) NOT NULL,
  `category_id` int(11) NOT NULL,
  `location` varchar(500) NOT NULL,
  `property_type` int(2) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_listings`
--

LOCK TABLES `home_listings` WRITE;
/*!40000 ALTER TABLE `home_listings` DISABLE KEYS */;
INSERT INTO `home_listings` VALUES (1,15465793,'Nevada','https://healthcaretravels.com/public/uploads/Nevada1.png',1,'Nevada',1,1,'2018-10-08 11:54:10','0000-00-00 00:00:00'),(2,15465793,'New York','https://healthcaretravels.com/public/uploads/TZOMIQCGL9.jpg',2,'New York',1,1,'2019-01-27 12:24:45','2019-01-27 12:24:45'),(4,15465793,'Oregon','https://healthcaretravels.com/public/uploads/France%20Anunciacion-OR%201.jpeg',2,'Oregon',1,1,'2018-09-10 08:25:30','0000-00-00 00:00:00'),(5,15465793,'New Jersey','https://healthcaretravels.com/public/uploads/New_Jersey1.jpg',1,'New Jersey',1,1,'2018-09-10 08:31:18','0000-00-00 00:00:00'),(6,15465793,'Texas','https://healthcaretravels.com/public/uploads/IMG_4971%20%282%29-min.JPG',1,'Texas',1,1,'2018-09-10 08:25:40','0000-00-00 00:00:00'),(10,15465793,'Arizona','https://healthcaretravels.com/public/uploads/HRRLDZAGL7.jpeg',2,'Arizona',0,0,'2018-10-08 11:54:07','2018-10-07 12:08:09'),(11,15465793,'South Dakota','https://healthcaretravels.com/public/uploads/Rebecca%20Geller-South%20Dakota%20.jpg',2,'South Dakota',1,1,'2018-09-10 08:25:54','2018-08-13 00:00:00'),(14,15465793,'California','https://healthcaretravels.com/public/uploads/Deanna%20Wallace-ca.jpg',1,'California',1,1,'2018-10-08 11:52:18','2018-08-21 00:00:00');
/*!40000 ALTER TABLE `home_listings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `instant_chat`
--

DROP TABLE IF EXISTS `instant_chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instant_chat` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `traveller_id` int(11) NOT NULL,
  `sent_by` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `guest_count` int(11) NOT NULL,
  `check_in` varchar(10) NOT NULL,
  `check_out` varchar(10) NOT NULL,
  `message` text NOT NULL,
  `status` int(3) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instant_chat`
--

LOCK TABLES `instant_chat` WRITE;
/*!40000 ALTER TABLE `instant_chat` DISABLE KEYS */;
/*!40000 ALTER TABLE `instant_chat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2018_03_02_204053_create_samples_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `occupation`
--

DROP TABLE IF EXISTS `occupation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `occupation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `occupation`
--

LOCK TABLES `occupation` WRITE;
/*!40000 ALTER TABLE `occupation` DISABLE KEYS */;
INSERT INTO `occupation` VALUES (1,'Allied Health',0,'2018-10-24 11:15:45','2018-10-24 11:15:45'),(2,'CNA',0,'2018-10-24 11:16:03','2018-10-24 11:16:03'),(3,'Community Health',0,'2018-10-24 11:16:39','2018-10-24 11:16:39'),(4,'Consultant',0,'2018-10-24 11:17:58','2018-10-24 11:17:58'),(5,'Doctor',0,'2018-10-24 11:18:08','2018-10-24 11:18:08'),(6,'Nurse',0,'2018-10-24 11:18:18','2018-10-24 11:18:18'),(7,'Sales Rep',0,'2018-10-24 11:18:28','2018-10-24 11:18:28'),(8,'Tech',0,'2018-10-24 11:18:39','2018-10-24 11:18:39'),(9,'Therapist',0,'2018-10-24 11:18:58','2018-10-24 11:18:58'),(10,'Other',0,'2019-01-01 13:41:21','2019-01-01 13:41:21');
/*!40000 ALTER TABLE `occupation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `owner_rating`
--

DROP TABLE IF EXISTS `owner_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `owner_rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `booking_id` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` float NOT NULL,
  `comments` varchar(500) DEFAULT NULL,
  `rating_by` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `owner_rating`
--

LOCK TABLES `owner_rating` WRITE;
/*!40000 ALTER TABLE `owner_rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `owner_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_method`
--

DROP TABLE IF EXISTS `payment_method`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `beneficiary_name` char(50) DEFAULT NULL,
  `pay_pal_email` varchar(500) DEFAULT NULL,
  `bank_name` varchar(500) NOT NULL,
  `account_number` varchar(20) NOT NULL,
  `ifsc_code` varchar(30) NOT NULL,
  `account_type` int(3) NOT NULL COMMENT '1 - savings 2 - current',
  `is_default` int(2) NOT NULL DEFAULT '0',
  `status` int(3) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_method`
--

LOCK TABLES `payment_method` WRITE;
/*!40000 ALTER TABLE `payment_method` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment_method` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_chat`
--

DROP TABLE IF EXISTS `personal_chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `traveller_id` int(11) NOT NULL,
  `property_id` int(10) DEFAULT NULL,
  `sent_by` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` int(3) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `owner_visible` int(2) NOT NULL DEFAULT '1',
  `traveler_visible` int(2) NOT NULL DEFAULT '1',
  `traveler_notify` enum('1','0') NOT NULL DEFAULT '1',
  `owner_notify` enum('1','0') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_chat`
--

LOCK TABLES `personal_chat` WRITE;
/*!40000 ALTER TABLE `personal_chat` DISABLE KEYS */;
INSERT INTO `personal_chat` VALUES (1,15465793,6,22,7,22,'Hi',0,'2020-07-10 11:27:43',NULL,1,1,'1','1');
/*!40000 ALTER TABLE `personal_chat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_amenties`
--

DROP TABLE IF EXISTS `property_amenties`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_amenties` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `amenties_name` varchar(500) NOT NULL,
  `amenties_icon` varchar(500) NOT NULL,
  `amenties_flag` int(11) NOT NULL DEFAULT '1',
  `sort` int(10) NOT NULL DEFAULT '1',
  `status` int(10) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `property_amenties_fk0` (`client_id`),
  KEY `property_amenties_fk1` (`amenties_name`),
  KEY `property_id` (`property_id`)
) ENGINE=MyISAM AUTO_INCREMENT=110 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_amenties`
--

LOCK TABLES `property_amenties` WRITE;
/*!40000 ALTER TABLE `property_amenties` DISABLE KEYS */;
INSERT INTO `property_amenties` VALUES (1,15465793,1,'Closet','public/amenities/Closet.png',1,1,1,'2019-11-16 13:15:17','0000-00-00 00:00:00'),(2,15465793,1,'Doorman','public/amenities/Door%20Keeper.png',1,1,1,'2019-11-16 13:15:17','0000-00-00 00:00:00'),(3,15465793,1,'Elevator in Building','public/amenities/Elevator.png',1,1,1,'2019-11-16 13:15:17','0000-00-00 00:00:00'),(4,15465793,2,'Air Conditioner','public/amenities/Air%20Conditioner.png',1,1,1,'2019-11-16 13:28:04','0000-00-00 00:00:00'),(5,15465793,2,'Hot Tub','public/amenities/Bath.png',1,1,1,'2019-11-16 13:28:04','0000-00-00 00:00:00'),(6,15465793,2,'Breakfast Included','public/amenities/Break-Fast.png',1,1,1,'2019-11-16 13:28:04','0000-00-00 00:00:00'),(7,15465793,2,'Closet','public/amenities/Closet.png',1,1,1,'2019-11-16 13:28:04','0000-00-00 00:00:00'),(8,15465793,2,'Doorman','public/amenities/Door%20Keeper.png',1,1,1,'2019-11-16 13:28:04','0000-00-00 00:00:00'),(9,15465793,2,'Elevator in Building','public/amenities/Elevator.png',1,1,1,'2019-11-16 13:28:04','0000-00-00 00:00:00'),(10,15465793,2,'Essentials','public/amenities/Essentials.png',1,1,1,'2019-11-16 13:28:04','0000-00-00 00:00:00'),(11,15465793,3,'Closet','public/amenities/Closet.png',1,1,1,'2019-11-16 13:37:15','0000-00-00 00:00:00'),(12,15465793,3,'Doorman','public/amenities/Door%20Keeper.png',1,1,1,'2019-11-16 13:37:15','0000-00-00 00:00:00'),(13,15465793,3,'Elevator in Building','public/amenities/Elevator.png',1,1,1,'2019-11-16 13:37:15','0000-00-00 00:00:00'),(14,15465793,5,'Air Conditioner','public/amenities/Air%20Conditioner.png',1,1,1,'2019-11-18 06:24:44','0000-00-00 00:00:00'),(15,15465793,5,'Hot Tub','public/amenities/Bath.png',1,1,1,'2019-11-18 06:24:44','0000-00-00 00:00:00'),(16,15465793,5,'Breakfast Included','public/amenities/Break-Fast.png',1,1,1,'2019-11-18 06:24:44','0000-00-00 00:00:00'),(17,15465793,5,'Closet','public/amenities/Closet.png',1,1,1,'2019-11-18 06:24:44','0000-00-00 00:00:00'),(18,15465793,5,'Elevator in Building','public/amenities/Elevator.png',1,1,1,'2019-11-18 06:24:44','0000-00-00 00:00:00'),(19,15465793,5,'Essentials','public/amenities/Essentials.png',1,1,1,'2019-11-18 06:24:44','0000-00-00 00:00:00'),(20,15465793,6,'Air Conditioner','public/amenities/Air%20Conditioner.png',1,1,1,'2019-11-18 06:29:27','0000-00-00 00:00:00'),(21,15465793,6,'Hot Tub','public/amenities/Bath.png',1,1,1,'2019-11-18 06:29:27','0000-00-00 00:00:00'),(22,15465793,6,'Breakfast Included','public/amenities/Break-Fast.png',1,1,1,'2019-11-18 06:29:27','0000-00-00 00:00:00'),(23,15465793,6,'Doorman','public/amenities/Door%20Keeper.png',1,1,1,'2019-11-18 06:29:27','0000-00-00 00:00:00'),(24,15465793,7,'Air Conditioner','public/amenities/Air%20Conditioner.png',1,1,1,'2019-11-21 08:04:05','0000-00-00 00:00:00'),(25,15465793,7,'Hot Tub','public/amenities/Bath.png',1,1,1,'2019-11-21 08:04:05','0000-00-00 00:00:00'),(26,15465793,7,'Breakfast Included','public/amenities/Break-Fast.png',1,1,1,'2019-11-21 08:04:05','0000-00-00 00:00:00'),(27,15465793,7,'Closet','public/amenities/Closet.png',1,1,1,'2019-11-21 08:04:05','0000-00-00 00:00:00'),(28,15465793,7,'Doorman','public/amenities/Door%20Keeper.png',1,1,1,'2019-11-21 08:04:05','0000-00-00 00:00:00'),(29,15465793,7,'Elevator in Building','public/amenities/Elevator.png',1,1,1,'2019-11-21 08:04:05','0000-00-00 00:00:00'),(30,15465793,7,'Essentials','public/amenities/Essentials.png',1,1,1,'2019-11-21 08:04:05','0000-00-00 00:00:00'),(31,15465793,8,'Kitchen','kitchen_icon',1,1,1,'2019-11-22 14:54:01','2019-11-22 14:54:01'),(32,15465793,8,'Wheelchair Accessible','Wheelchair_Accessible_icon',1,1,1,'2019-11-22 14:54:01','2019-11-22 14:54:01'),(33,15465793,8,'Essentials','Essentials_icon',1,1,1,'2019-11-22 14:54:01','2019-11-22 14:54:01'),(104,15465793,9,'Coffee Pot','Coffee_Pot_icon',1,1,1,'2020-02-21 01:33:59','2020-02-21 01:33:59'),(103,15465793,9,'Netflix','Netflix_icon',1,1,1,'2020-02-21 01:33:59','2020-02-21 01:33:59'),(102,15465793,9,'All Bils Included','All_Bils_Included_icon',1,1,1,'2020-02-21 01:33:59','2020-02-21 01:33:59'),(101,15465793,9,'Smart Tv','Smart_Tv_icon',1,1,1,'2020-02-21 01:33:59','2020-02-21 01:33:59'),(100,15465793,9,'Towels','Towels_icon',1,1,1,'2020-02-21 01:33:59','2020-02-21 01:33:59'),(98,15465793,9,'Air Conditioner','Air_Conditioner_icon',1,1,1,'2020-02-21 01:33:59','2020-02-21 01:33:59'),(99,15465793,9,'Pots and Pans','pots_and_pans_icon',1,1,1,'2020-02-21 01:33:59','2020-02-21 01:33:59'),(97,15465793,9,'Non Smoking','Non_Smoking_icon',1,1,1,'2020-02-21 01:33:59','2020-02-21 01:33:59'),(96,15465793,9,'Wireless Internet','Wireless_Internet_icon',1,1,1,'2020-02-21 01:33:59','2020-02-21 01:33:59'),(95,15465793,9,'Free Parking on Premises','Free_Parking_on_Premises_icon',1,1,1,'2020-02-21 01:33:59','2020-02-21 01:33:59'),(94,15465793,9,'Dryer','Dryer_icon',1,1,1,'2020-02-21 01:33:59','2020-02-21 01:33:59'),(93,15465793,9,'Washer','Washer_icon',1,1,1,'2020-02-21 01:33:59','2020-02-21 01:33:59'),(92,15465793,9,'Essentials','Essentials_icon',1,1,1,'2020-02-21 01:33:59','2020-02-21 01:33:59'),(91,15465793,9,'Heating','Heating_icon',1,1,1,'2020-02-21 01:33:59','2020-02-21 01:33:59'),(90,15465793,9,'Kitchen','kitchen_icon',1,1,1,'2020-02-21 01:33:59','2020-02-21 01:33:59'),(86,15465793,11,'Pots and Pans','pots_and_pans_icon',1,1,1,'2020-02-19 20:46:47','2020-02-19 20:46:47'),(87,15465793,11,'Towels','Towels_icon',1,1,1,'2020-02-19 20:46:47','2020-02-19 20:46:47'),(85,15465793,11,'Scanner Printer','Scanner_Printer_icon',1,1,1,'2020-02-19 20:46:47','2020-02-19 20:46:47'),(84,15465793,11,'Non Smoking','Non_Smoking_icon',1,1,1,'2020-02-19 20:46:47','2020-02-19 20:46:47'),(83,15465793,11,'Kid Friendly','Kid_Friendly_icon',1,1,1,'2020-02-19 20:46:47','2020-02-19 20:46:47'),(82,15465793,11,'Wireless Internet','Wireless_Internet_icon',1,1,1,'2020-02-19 20:46:47','2020-02-19 20:46:47'),(81,15465793,11,'Free Parking on Premises','Free_Parking_on_Premises_icon',1,1,1,'2020-02-19 20:46:47','2020-02-19 20:46:47'),(80,15465793,11,'Tv','Tv_icon',1,1,1,'2020-02-19 20:46:47','2020-02-19 20:46:47'),(79,15465793,11,'Kitchen','kitchen_icon',1,1,1,'2020-02-19 20:46:47','2020-02-19 20:46:47'),(88,15465793,11,'Smart Tv','Smart_Tv_icon',1,1,1,'2020-02-19 20:46:47','2020-02-19 20:46:47'),(89,15465793,11,'Coffee Pot','Coffee_Pot_icon',1,1,1,'2020-02-19 20:46:47','2020-02-19 20:46:47'),(105,15465793,12,'Cable','cable_icon',1,1,1,'2020-03-30 14:29:12','2020-03-30 14:29:12'),(106,15465793,13,'Elevator in Building','public/amenities/Elevator.png',1,1,1,'2019-11-16 13:15:17','2020-06-20 00:00:00'),(107,15465793,14,'Air Conditioner','public/amenities/Air%20Conditioner.png',1,1,1,'2019-11-16 13:28:04','2020-06-20 00:00:00'),(108,15465793,15,'Hot Tub','public/amenities/Bath.png',1,1,1,'2019-11-16 13:28:04','2020-06-20 00:00:00'),(109,15465793,16,'Cable','cable_icon',1,1,1,'2020-07-10 08:17:25','2020-07-10 08:17:25');
/*!40000 ALTER TABLE `property_amenties` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_bedrooms`
--

DROP TABLE IF EXISTS `property_bedrooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_bedrooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `bedroom_number` int(11) NOT NULL,
  `bed_type` varchar(500) NOT NULL COMMENT '1 - double , 2 - queen , 3 - single , 4 - sofa bed, 5 - bunk bed, 6 - common spaces',
  `is_common_space` int(3) NOT NULL DEFAULT '0',
  `count` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_bedrooms`
--

LOCK TABLES `property_bedrooms` WRITE;
/*!40000 ALTER TABLE `property_bedrooms` DISABLE KEYS */;
INSERT INTO `property_bedrooms` VALUES (1,15465793,1,1,'double_bed',0,1,1,'2019-11-16 13:13:00','0000-00-00 00:00:00'),(2,15465793,1,1,'queen_bed',0,1,1,'2019-11-16 13:13:00','0000-00-00 00:00:00'),(3,15465793,2,1,'double_bed',0,1,1,'2019-11-16 13:27:43','0000-00-00 00:00:00'),(4,15465793,2,1,'queen_bed',0,1,1,'2019-11-16 13:27:43','0000-00-00 00:00:00'),(5,15465793,2,1,'single_bed',0,1,1,'2019-11-16 13:27:43','0000-00-00 00:00:00'),(6,15465793,2,1,'sofa_bed',0,1,1,'2019-11-16 13:27:43','0000-00-00 00:00:00'),(7,15465793,2,1,'bunk_bed',0,1,1,'2019-11-16 13:27:43','0000-00-00 00:00:00'),(8,15465793,3,1,'double_bed',0,1,1,'2019-11-16 13:36:55','0000-00-00 00:00:00'),(9,15465793,3,1,'queen_bed',0,1,1,'2019-11-16 13:36:55','0000-00-00 00:00:00'),(10,15465793,3,1,'single_bed',0,1,1,'2019-11-16 13:36:55','0000-00-00 00:00:00'),(11,15465793,3,1,'sofa_bed',0,1,1,'2019-11-16 13:36:55','0000-00-00 00:00:00'),(12,15465793,3,1,'bunk_bed',0,1,1,'2019-11-16 13:36:55','0000-00-00 00:00:00'),(18,15465793,6,1,'double_bed',0,1,1,'2019-11-18 06:29:07','0000-00-00 00:00:00'),(19,15465793,6,1,'queen_bed',0,1,1,'2019-11-18 06:29:07','0000-00-00 00:00:00'),(20,15465793,6,1,'single_bed',0,2,1,'2019-11-18 06:29:07','0000-00-00 00:00:00'),(21,15465793,6,1,'sofa_bed',0,1,1,'2019-11-18 06:29:07','0000-00-00 00:00:00'),(22,15465793,6,1,'bunk_bed',0,1,1,'2019-11-18 06:29:07','0000-00-00 00:00:00'),(23,15465793,6,1,'double_bed',1,1,2,'2019-11-18 06:29:07','0000-00-00 00:00:00'),(24,15465793,6,1,'queen_bed',1,3,2,'2019-11-18 06:29:07','0000-00-00 00:00:00'),(25,15465793,6,1,'single_bed',1,3,2,'2019-11-18 06:29:07','0000-00-00 00:00:00'),(26,15465793,6,1,'sofa_bed',1,3,2,'2019-11-18 06:29:07','0000-00-00 00:00:00'),(27,15465793,6,1,'bunk_bed',1,2,2,'2019-11-18 06:29:07','0000-00-00 00:00:00'),(28,15465793,5,1,'double_bed',0,1,1,'2019-11-18 06:42:58','0000-00-00 00:00:00'),(29,15465793,5,1,'queen_bed',0,1,1,'2019-11-18 06:42:58','0000-00-00 00:00:00'),(30,15465793,5,1,'single_bed',0,1,1,'2019-11-18 06:42:58','0000-00-00 00:00:00'),(31,15465793,5,1,'sofa_bed',0,1,1,'2019-11-18 06:42:58','0000-00-00 00:00:00'),(32,15465793,5,1,'bunk_bed',0,1,1,'2019-11-18 06:42:58','0000-00-00 00:00:00'),(44,15465793,9,1,'double_bed',0,0,1,'2020-01-30 02:11:44','0000-00-00 00:00:00'),(45,15465793,9,1,'queen_bed',0,1,1,'2020-01-30 02:11:44','0000-00-00 00:00:00'),(46,15465793,9,1,'single_bed',0,0,1,'2020-01-30 02:11:44','0000-00-00 00:00:00'),(47,15465793,9,1,'sofa_bed',0,0,1,'2020-01-30 02:11:44','0000-00-00 00:00:00'),(48,15465793,9,1,'bunk_bed',0,0,1,'2020-01-30 02:11:44','0000-00-00 00:00:00'),(52,15465793,10,1,'double_bed',0,2,1,'2020-02-19 18:21:27','0000-00-00 00:00:00'),(53,15465793,10,1,'double_bed',1,2,1,'2020-02-19 18:21:27','0000-00-00 00:00:00'),(54,15465793,10,1,'queen_bed',1,1,1,'2020-02-19 18:21:27','0000-00-00 00:00:00'),(55,15465793,10,1,'single_bed',1,2,1,'2020-02-19 18:21:27','0000-00-00 00:00:00'),(56,15465793,10,2,'queen_bed',0,1,1,'2020-02-19 18:21:27','0000-00-00 00:00:00'),(57,15465793,10,3,'single_bed',0,2,1,'2020-02-19 18:21:27','0000-00-00 00:00:00'),(76,15465793,11,1,'double_bed',0,2,1,'2020-02-19 20:45:14','0000-00-00 00:00:00'),(77,15465793,11,1,'queen_bed',0,0,1,'2020-02-19 20:45:14','0000-00-00 00:00:00'),(78,15465793,11,1,'single_bed',0,0,1,'2020-02-19 20:45:14','0000-00-00 00:00:00'),(79,15465793,11,1,'sofa_bed',0,0,1,'2020-02-19 20:45:14','0000-00-00 00:00:00'),(80,15465793,11,1,'bunk_bed',0,0,1,'2020-02-19 20:45:14','0000-00-00 00:00:00'),(81,15465793,11,2,'double_bed',0,0,1,'2020-02-19 20:45:14','0000-00-00 00:00:00'),(82,15465793,11,2,'queen_bed',0,1,1,'2020-02-19 20:45:14','0000-00-00 00:00:00'),(83,15465793,11,2,'single_bed',0,0,1,'2020-02-19 20:45:14','0000-00-00 00:00:00'),(84,15465793,11,2,'sofa_bed',0,0,1,'2020-02-19 20:45:14','0000-00-00 00:00:00'),(85,15465793,11,2,'bunk_bed',0,0,1,'2020-02-19 20:45:14','0000-00-00 00:00:00'),(86,15465793,11,3,'double_bed',0,0,1,'2020-02-19 20:45:14','0000-00-00 00:00:00'),(87,15465793,11,3,'queen_bed',0,0,1,'2020-02-19 20:45:14','0000-00-00 00:00:00'),(88,15465793,11,3,'single_bed',0,2,1,'2020-02-19 20:45:14','0000-00-00 00:00:00'),(89,15465793,11,3,'sofa_bed',0,0,1,'2020-02-19 20:45:14','0000-00-00 00:00:00'),(90,15465793,11,3,'bunk_bed',0,0,1,'2020-02-19 20:45:14','0000-00-00 00:00:00'),(91,15465793,7,1,'double_bed',0,1,1,'2020-03-09 11:40:54','0000-00-00 00:00:00'),(92,15465793,7,1,'queen_bed',0,1,1,'2020-03-09 11:40:54','0000-00-00 00:00:00'),(93,15465793,7,1,'single_bed',0,1,1,'2020-03-09 11:40:54','0000-00-00 00:00:00'),(94,15465793,7,1,'sofa_bed',0,0,1,'2020-03-09 11:40:54','0000-00-00 00:00:00'),(95,15465793,7,1,'bunk_bed',0,0,1,'2020-03-09 11:40:54','0000-00-00 00:00:00'),(96,15465793,7,2,'double_bed',0,0,1,'2020-03-09 11:40:54','0000-00-00 00:00:00'),(97,15465793,7,2,'queen_bed',0,0,1,'2020-03-09 11:40:54','0000-00-00 00:00:00'),(98,15465793,7,2,'single_bed',0,1,1,'2020-03-09 11:40:54','0000-00-00 00:00:00'),(99,15465793,7,2,'sofa_bed',0,1,1,'2020-03-09 11:40:54','0000-00-00 00:00:00'),(100,15465793,7,2,'bunk_bed',0,0,1,'2020-03-09 11:40:54','0000-00-00 00:00:00'),(101,15465793,12,1,'double_bed',0,1,1,'2020-03-30 14:28:43','0000-00-00 00:00:00'),(102,15465793,12,1,'double_bed',1,1,1,'2020-03-30 14:28:43','0000-00-00 00:00:00'),(103,15465793,13,1,'double_bed',0,1,1,'2020-03-30 14:28:43','2020-06-20 00:00:00'),(104,15465793,13,1,'double_bed',1,1,1,'2020-03-30 14:28:43','2020-06-20 00:00:00'),(105,15465793,14,1,'double_bed',0,1,1,'2020-03-30 14:28:43','2020-06-20 00:00:00'),(106,15465793,13,1,'double_bed',1,1,1,'2020-03-30 14:28:43','2020-06-20 00:00:00'),(107,15465793,15,1,'double_bed',0,1,1,'2020-03-30 14:28:43','2020-06-20 00:00:00'),(108,15465793,13,1,'double_bed',1,1,1,'2020-03-30 14:28:43','2020-06-20 00:00:00'),(109,15465793,16,1,'double_bed',0,1,1,'2020-07-10 08:15:58','0000-00-00 00:00:00'),(110,15465793,16,1,'queen_bed',0,1,1,'2020-07-10 08:15:58','0000-00-00 00:00:00'),(111,15465793,16,1,'single_bed',0,1,1,'2020-07-10 08:15:58','0000-00-00 00:00:00'),(112,15465793,16,1,'sofa_bed',0,1,1,'2020-07-10 08:15:58','0000-00-00 00:00:00'),(113,15465793,16,1,'bunk_bed',0,1,1,'2020-07-10 08:15:58','0000-00-00 00:00:00'),(114,15465793,16,1,'double_bed',1,1,1,'2020-07-10 08:15:58','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `property_bedrooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_blocking`
--

DROP TABLE IF EXISTS `property_blocking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_blocking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `client_id` int(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `booked_on` varchar(100) DEFAULT NULL,
  `is_admin` int(11) NOT NULL DEFAULT '0',
  `property_id` int(10) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_blocking`
--

LOCK TABLES `property_blocking` WRITE;
/*!40000 ALTER TABLE `property_blocking` DISABLE KEYS */;
INSERT INTO `property_blocking` VALUES (1,25,15465793,'2020-07-16','2020-07-16','test',0,17,'2020-07-10 10:27:15',NULL),(2,25,15465793,'2020-07-18','2020-07-18','test',0,17,'2020-07-10 10:27:15',NULL),(3,25,15465793,'2020-07-25','2020-07-25','test',0,17,'2020-07-10 10:27:15',NULL),(4,25,15465793,'2020-07-23','2020-07-23','test',0,17,'2020-07-10 10:27:15',NULL);
/*!40000 ALTER TABLE `property_blocking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_booking`
--

DROP TABLE IF EXISTS `property_booking`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `traveller_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `booking_id` char(10) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `guest_count` int(11) NOT NULL,
  `child_count` int(11) NOT NULL DEFAULT '0',
  `is_instant` int(2) NOT NULL DEFAULT '1' COMMENT '1 - instant 0 - booking request',
  `payment_done` int(2) NOT NULL DEFAULT '0' COMMENT '2 - canceled',
  `recruiter_name` varchar(100) NOT NULL DEFAULT '',
  `recruiter_phone_number` varchar(20) NOT NULL DEFAULT '',
  `recruiter_email` varchar(70) NOT NULL DEFAULT '',
  `contract_start_date` date NOT NULL,
  `contract_end_date` date NOT NULL,
  `status` int(3) NOT NULL DEFAULT '1' COMMENT '1 created 2 apprved 3 complted 4 canceled',
  `traveler_notify` enum('1','0') NOT NULL DEFAULT '1',
  `owner_notify` enum('1','0') NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_booking`
--

LOCK TABLES `property_booking` WRITE;
/*!40000 ALTER TABLE `property_booking` DISABLE KEYS */;
INSERT INTO `property_booking` VALUES (1,15465793,22,6,14,'QYY9VBX7DA','2020-07-28','2020-07-31',1,0,0,0,'','','','0000-00-00','0000-00-00',1,'1','1','2020-07-10 11:33:01',NULL),(2,15465793,22,6,7,'4ETOHKZPBS','2020-07-15','2020-07-22',1,0,0,0,'','','','0000-00-00','0000-00-00',1,'1','1','2020-07-10 11:34:42',NULL);
/*!40000 ALTER TABLE `property_booking` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_booking_price`
--

DROP TABLE IF EXISTS `property_booking_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_booking_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `property_booking_id` int(11) NOT NULL,
  `single_day_fare` float DEFAULT '0',
  `weekend_fare` varchar(11) DEFAULT '0',
  `total_days` int(11) NOT NULL,
  `tax_amount` float NOT NULL,
  `cleaning_fare` float NOT NULL,
  `city_fare` float NOT NULL,
  `service_fare` float NOT NULL DEFAULT '1',
  `service_tax` varchar(10) DEFAULT NULL,
  `initial_pay` float NOT NULL,
  `payment_splitup` int(11) NOT NULL DEFAULT '2',
  `total_amount` float NOT NULL,
  `temp_amount` float NOT NULL DEFAULT '0',
  `security_deposit` int(11) DEFAULT '0',
  `coupon_code` varchar(50) DEFAULT NULL,
  `coupon_value` int(10) DEFAULT NULL,
  `admin_commision` varchar(20) NOT NULL DEFAULT '0',
  `extra_guest` varchar(15) DEFAULT '0',
  `extra_guest_price` varchar(15) DEFAULT '0',
  `week_end_days` float NOT NULL DEFAULT '0',
  `status` int(3) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `property_booking_id` (`property_booking_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_booking_price`
--

LOCK TABLES `property_booking_price` WRITE;
/*!40000 ALTER TABLE `property_booking_price` DISABLE KEYS */;
INSERT INTO `property_booking_price` VALUES (1,15465793,1,20,'0',3,0,25,0,1,'25',11.1,2,1110,0,1000,NULL,NULL,'50','0','0',0,1,'2020-07-10 11:33:01','2020-07-10 11:33:01'),(2,15465793,2,1500,'0',7,0,25,0,1,'25',115.5,2,11550,0,1000,NULL,NULL,'50','0','0',0,1,'2020-07-10 11:34:42','2020-07-10 11:34:42');
/*!40000 ALTER TABLE `property_booking_price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_images`
--

DROP TABLE IF EXISTS `property_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `image_url` varchar(500) NOT NULL,
  `is_cover` int(11) NOT NULL DEFAULT '0',
  `sort` int(10) NOT NULL,
  `status` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `property_images_fk0` (`client_id`),
  KEY `property_images_fk1` (`property_id`),
  KEY `property_id` (`property_id`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_images`
--

LOCK TABLES `property_images` WRITE;
/*!40000 ALTER TABLE `property_images` DISABLE KEYS */;
INSERT INTO `property_images` VALUES (1,2,15465793,'https://healthcaretravels.com/public/uploads/3C6ZI600B4.jpg',0,1,1,'2019-11-16 13:28:52',NULL),(2,1,15465793,'https://healthcaretravels.com/public/uploads/GDHNY8RZJF.jpg',0,1,1,'2019-11-16 13:30:51',NULL),(3,3,15465793,'https://healthcaretravels.com/public/uploads/DOWF5FNLDZ.jpg',0,1,1,'2019-11-16 13:37:46',NULL),(4,5,15465793,'https://healthcaretravels.com/public/uploads/TCYL52TQZT.png',0,1,1,'2019-11-18 06:27:08',NULL),(5,6,15465793,'https://healthcaretravels.com/public/uploads/4O2QQ19XHM.png',0,1,1,'2019-11-18 06:30:09',NULL),(54,12,15465793,'https://healthcaretravels.com/public/uploads/846353.jpg',0,1,1,'2020-03-30 14:29:19',NULL),(8,8,15465793,'https://healthcaretravels.com/public/uploads/209333.jpg',0,1,1,'2019-11-22 14:54:11',NULL),(9,9,15465793,'https://healthcaretravels.com/public/uploads/259242.jpg',0,1,1,'2020-01-29 17:02:44',NULL),(10,9,15465793,'https://healthcaretravels.com/public/uploads/743544.jpg',0,1,1,'2020-01-29 17:03:19',NULL),(11,9,15465793,'https://healthcaretravels.com/public/uploads/185153.jpg',0,1,1,'2020-01-29 17:03:35',NULL),(12,9,15465793,'https://healthcaretravels.com/public/uploads/132090.jpg',0,1,1,'2020-01-29 17:03:51',NULL),(13,9,15465793,'https://healthcaretravels.com/public/uploads/497597.jpg',0,1,1,'2020-01-29 17:04:12',NULL),(14,9,15465793,'https://healthcaretravels.com/public/uploads/550813.jpg',0,1,1,'2020-01-29 17:04:36',NULL),(15,9,15465793,'https://healthcaretravels.com/public/uploads/115425.jpg',0,1,1,'2020-01-29 17:04:48',NULL),(16,9,15465793,'https://healthcaretravels.com/public/uploads/799170.jpg',0,1,1,'2020-01-29 17:04:55',NULL),(23,11,15465793,'https://healthcaretravels.com/public/uploads/925404.jpg',0,1,1,'2020-02-19 18:59:29',NULL),(18,9,15465793,'https://healthcaretravels.com/public/uploads/469598.jpg',0,1,1,'2020-01-29 17:05:13',NULL),(19,9,15465793,'https://healthcaretravels.com/public/uploads/429219.jpg',0,1,1,'2020-01-29 17:05:21',NULL),(20,9,15465793,'https://healthcaretravels.com/public/uploads/714793.jpg',0,1,1,'2020-01-29 17:05:27',NULL),(21,9,15465793,'https://healthcaretravels.com/public/uploads/138926.jpg',0,1,1,'2020-01-29 17:05:41',NULL),(22,9,15465793,'https://healthcaretravels.com/public/uploads/790832.jpg',0,1,1,'2020-01-29 17:05:58',NULL),(24,11,15465793,'https://healthcaretravels.com/public/uploads/536763.jpg',0,1,1,'2020-02-19 18:59:30',NULL),(25,11,15465793,'https://healthcaretravels.com/public/uploads/566044.jpg',0,1,1,'2020-02-19 18:59:30',NULL),(26,11,15465793,'https://healthcaretravels.com/public/uploads/920913.jpg',1,1,1,'2020-02-19 20:47:05','2020-02-19 20:47:05'),(51,7,15465793,'https://healthcaretravels.com/public/uploads/785865.jpg',0,1,1,'2020-03-09 11:38:47',NULL),(28,11,15465793,'https://healthcaretravels.com/public/uploads/954212.jpg',0,1,1,'2020-02-19 18:59:31',NULL),(29,11,15465793,'https://healthcaretravels.com/public/uploads/549118.jpg',0,1,1,'2020-02-19 18:59:31',NULL),(30,11,15465793,'https://healthcaretravels.com/public/uploads/922310.jpg',0,1,1,'2020-02-19 18:59:32',NULL),(31,11,15465793,'https://healthcaretravels.com/public/uploads/800829.jpg',0,1,1,'2020-02-19 18:59:32',NULL),(32,11,15465793,'https://healthcaretravels.com/public/uploads/379439.jpg',0,1,1,'2020-02-19 18:59:32',NULL),(33,11,15465793,'https://healthcaretravels.com/public/uploads/397156.jpg',0,1,1,'2020-02-19 18:59:32',NULL),(34,11,15465793,'https://healthcaretravels.com/public/uploads/359151.jpg',0,1,1,'2020-02-19 18:59:32',NULL),(35,11,15465793,'https://healthcaretravels.com/public/uploads/125156.jpg',0,1,1,'2020-02-19 18:59:33',NULL),(36,11,15465793,'https://healthcaretravels.com/public/uploads/416318.jpg',0,1,1,'2020-02-19 18:59:33',NULL),(37,11,15465793,'https://healthcaretravels.com/public/uploads/510660.jpg',0,1,1,'2020-02-19 18:59:33',NULL),(38,11,15465793,'https://healthcaretravels.com/public/uploads/355795.jpg',0,1,1,'2020-02-19 18:59:33',NULL),(39,11,15465793,'https://healthcaretravels.com/public/uploads/988902.jpg',0,1,1,'2020-02-19 18:59:33',NULL),(40,11,15465793,'https://healthcaretravels.com/public/uploads/555243.jpg',0,1,1,'2020-02-19 18:59:34',NULL),(41,11,15465793,'https://healthcaretravels.com/public/uploads/622792.jpg',0,1,1,'2020-02-19 18:59:34',NULL),(42,11,15465793,'https://healthcaretravels.com/public/uploads/436052.jpg',0,1,1,'2020-02-19 18:59:34',NULL),(43,11,15465793,'https://healthcaretravels.com/public/uploads/185785.jpg',0,1,1,'2020-02-19 18:59:34',NULL),(44,11,15465793,'https://healthcaretravels.com/public/uploads/859575.jpg',0,1,1,'2020-02-19 18:59:34',NULL),(45,11,15465793,'https://healthcaretravels.com/public/uploads/590191.jpg',0,1,1,'2020-02-19 18:59:34',NULL),(46,11,15465793,'https://healthcaretravels.com/public/uploads/334388.jpg',0,1,1,'2020-02-19 18:59:35',NULL),(47,11,15465793,'https://healthcaretravels.com/public/uploads/316356.jpg',0,1,1,'2020-02-19 18:59:35',NULL),(48,11,15465793,'https://healthcaretravels.com/public/uploads/994905.jpg',0,1,1,'2020-02-19 18:59:35',NULL),(49,11,15465793,'https://healthcaretravels.com/public/uploads/745313.jpg',0,1,1,'2020-02-19 18:59:35',NULL),(50,11,15465793,'https://healthcaretravels.com/public/uploads/831376.jpg',0,1,1,'2020-02-19 18:59:36',NULL),(52,7,15465793,'https://healthcaretravels.com/public/uploads/424199.jpg',1,1,1,'2020-03-09 11:38:59','2020-03-09 11:38:59'),(53,7,15465793,'https://healthcaretravels.com/public/uploads/310420.jpg',0,1,1,'2020-03-09 11:38:47',NULL),(55,13,15465793,'https://keepers-rental.s3.us-east-2.amazonaws.com/uploads/1592314703819888.png',0,1,1,'2020-06-20 11:43:10','2020-06-20 11:43:10'),(56,14,15465793,'https://healthcaretravels.com/public/uploads/TCYL52TQZT.png',0,1,1,'2019-11-18 06:27:08',NULL),(57,15,15465793,'https://keepers-rental.s3.us-east-2.amazonaws.com/uploads/1592191332339128.jpeg',0,1,1,'2020-06-20 11:43:30','2020-06-20 11:43:30');
/*!40000 ALTER TABLE `property_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_list`
--

DROP TABLE IF EXISTS `property_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_category` varchar(500) NOT NULL,
  `room_type` varchar(500) NOT NULL,
  `title` varchar(500) NOT NULL,
  `total_guests` int(10) NOT NULL,
  `minimum_guests` int(10) NOT NULL DEFAULT '0',
  `minimum_childs` varchar(10) NOT NULL DEFAULT '0',
  `city` varchar(500) NOT NULL DEFAULT '0',
  `building_number` varchar(20) DEFAULT NULL,
  `address` varchar(500) NOT NULL DEFAULT '0',
  `lat` varchar(100) DEFAULT NULL,
  `lng` varchar(100) DEFAULT NULL,
  `location` varchar(500) NOT NULL DEFAULT '0',
  `description` text,
  `verified` int(11) NOT NULL DEFAULT '0',
  `before_label` varchar(500) NOT NULL DEFAULT '0',
  `after_label` varchar(500) NOT NULL DEFAULT '0',
  `surroundings` varchar(500) DEFAULT NULL,
  `sort` int(10) NOT NULL DEFAULT '0',
  `status` int(10) NOT NULL DEFAULT '1' COMMENT '1 - active 0 disabled',
  `property_type` varchar(500) NOT NULL DEFAULT '0' COMMENT ' 0 - short term 1 - long term',
  `state` varchar(40) NOT NULL DEFAULT '1',
  `country` varchar(50) NOT NULL DEFAULT '1',
  `is_complete` int(5) NOT NULL DEFAULT '0',
  `is_available` int(11) NOT NULL DEFAULT '1',
  `is_instant` int(5) NOT NULL DEFAULT '0' COMMENT '0 - no 1 - yes',
  `on_stage` int(5) NOT NULL DEFAULT '1',
  `is_disable` int(1) NOT NULL DEFAULT '0',
  `on_popular` int(5) NOT NULL DEFAULT '0' COMMENT '0 - no 1 - yes',
  `on_recomended` int(2) NOT NULL DEFAULT '0',
  `view_count` int(11) NOT NULL DEFAULT '0',
  `cancel_before_30_days` float DEFAULT NULL,
  `cancel_before_15_days` float DEFAULT NULL,
  `cancel_before_1_week` float DEFAULT NULL,
  `cancel_before_1_day` float DEFAULT NULL,
  `currency_type` varchar(25) DEFAULT NULL,
  `deposit_amount` varchar(50) DEFAULT NULL,
  `cancellation_policy` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `reqest_book` int(20) unsigned DEFAULT NULL,
  `instant_pay` int(20) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `zip_code` varchar(250) NOT NULL,
  `cleaning_type` varchar(250) NOT NULL,
  `min_days` int(11) NOT NULL DEFAULT '1',
  `property_size` float NOT NULL DEFAULT '0',
  `property_status` int(4) NOT NULL DEFAULT '0',
  `is_camera` int(2) NOT NULL DEFAULT '0',
  `trash_pickup_days` varchar(50) DEFAULT NULL,
  `lawn_service` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0-No, 1-Yes',
  `stage` int(11) DEFAULT '0' COMMENT 'Stage for refrences show and hide menu',
  `house_rules` text,
  `pets_allowed` int(11) NOT NULL DEFAULT '0',
  `cur_adults` int(10) NOT NULL DEFAULT '0',
  `cur_child` int(10) NOT NULL DEFAULT '0',
  `cur_pets` int(10) NOT NULL DEFAULT '0',
  `property_type_rv_or_home` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `property_list_fk0` (`client_id`),
  KEY `property_list_fk1` (`user_id`),
  KEY `client_id` (`client_id`),
  KEY `property_category` (`property_category`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_list`
--

LOCK TABLES `property_list` WRITE;
/*!40000 ALTER TABLE `property_list` DISABLE KEYS */;
INSERT INTO `property_list` VALUES (9,15465793,11,'Apartment','Entire Place','Cozy Convenience',2,0,'0','United States','Unit #3','1524 Marshall Street, Houston, TX, USA','29.7397412','-95.3988021','1524 Marshall St, Houston, TX 77006, USA','Lovely second floor unit in a vintage 4-unit building located in the quiet, upscale neighborhood of Montrose.  Downtown and medical center less than five miles away. Plenty of attractions within walking distance such as museums, restaurants, clubs, shopping and more. The unit offers many amenities and all of the basics are provided: fully furnished including appliances, cookware, linens and tableware. We provide WiFi and Netflix.',0,'0','0',NULL,0,1,'0','77006','1',1,1,0,5,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,'Moderate',NULL,NULL,NULL,'2020-02-21 01:33:59','2020-01-29 16:40:31','77006','',1,600,0,0,'Mon,Fri',1,6,'No pets, no parties and no smoking inside unit. Quiet hours 9 pm until 8 am',0,0,0,0,1),(3,15465793,4,'House','Shared Room','Cebe',2,0,'0','Coimbatore',NULL,'Coimbatore, Tamil Nadu, India','11.0168445','76.9558321','414/1, Varuthiangara Palayam, Seth Narang Das Layout, Kuniyamuthur, Coimbatore, Tamil Nadu 641008, India','Grgrgr',0,'0','0',NULL,0,1,'0','Tamil Nadu','India',1,1,0,6,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,'Super Strict',NULL,NULL,NULL,'2019-11-16 13:38:02','2019-11-16 13:38:02','641001','',2,1000,0,0,NULL,0,0,NULL,0,0,0,0,1),(4,15465793,3,'','','',0,0,'0','Coimbatore',NULL,'Coimbatore, Tamil Nadu, India','11.0168445','76.9558321','Coimbatore, Tamil Nadu, India',NULL,0,'0','0',NULL,0,1,'0','Tamil Nadu','India',0,1,0,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-11-16 13:43:01','2019-11-16 13:43:01','628722','',1,0,0,0,NULL,0,0,NULL,0,0,0,0,1),(7,15465793,6,'Apartment','Entire Place','The Whitestar',3,0,'0','Harris County',NULL,'Houston, Texas, United States','29.7604267','-95.3698028','Houston, TX, USA','Our 1-bedroom suite in the heart of Downtown Houston is where history meets elegance. The historic building is a distinguishing part of Houston’s skyline and provides a breathtaking view of downtown from within. Fully upgraded, it includes all of the modern amenities needed to enjoy a comfortable stay. The spacious interior includes a full kitchen, a bathroom with a bathtub, and a large walk-in closet attached to the bedroom. Being Downtown, you’re surrounded by entertainment, dining, and more!\n\nThe space\nOur 1-bedroom stay is furnished with a queen bed, a couch, and an air mattress. It has everything you need for a comfortable stay! The kitchen is stocked with cookware to cook simple meals, stainless steel appliances, and a Keurig to enjoy a fresh cup of coffee in the morning. There\'s a smart TV with Roku and Netflix (there is no cable) & free WiFi!\n\nGuest access\nYou can access the building anytime after 3pm by using the lockbox to obtain the keys. We ask that you respect our home and the quiet hours of the community. Our home is not baby proofed, and may not be ideal for families with very small children, however, children are welcome at your own discretion.',0,'0','0',NULL,0,1,'0','Texas','United States',1,1,0,6,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,'Super Strict',NULL,NULL,NULL,'2020-03-12 10:40:14','2020-03-09 11:40:09','7700','',2,1000,1,0,'',0,2,'No Smoking',1,0,0,0,1),(8,15465793,8,'Apartment','Shared Room','test',2,0,'0','Coimbatore','12456','Coimbatore, Tamil Nadu, India','11.0168445','76.95583209999995','Coimbatore, Tamil Nadu, India','test',0,'0','0',NULL,0,1,'0','Tamil Nadu','1',1,1,0,5,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,'Strict',NULL,NULL,NULL,'2019-11-22 14:54:20','2019-11-22 14:51:31','6410','',0,100,0,0,'Sun',0,6,'cvbdfh',0,0,0,0,1),(6,15465793,4,'Apartment','Entire House','Stssw',2,0,'0','Gandhipuram',NULL,'Gandhipuram, Tamil Nadu 641012, India','11.0175845','76.9674075','183-2, 5th St, Gandhipuram, Tamil Nadu 641012, India','Rugsdhy rf',0,'0','0',NULL,0,1,'0','Tamil Nadu','India',1,1,1,6,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,'Super Strict',NULL,NULL,NULL,'2019-11-18 06:30:19','2019-11-18 06:30:19','641012','',2,123456,0,0,NULL,0,0,NULL,0,0,0,0,1),(10,15465793,12,'House','Entire Place','Centrally located Triad/Triangle Home Near 85/40',6,0,'0','United States',NULL,'1614 Maple Ave, Burlington, NC 27215, USA','36.0755112','-79.42742199999999','United States','Enjoy a Stylishly remodeled and tastefully decorated 3 bedroom 2 bath house less than 1 mile/3 minutes from I-85/40.\r\n\r\nNew features include, fresh paint, all new luxury vinyl plank flooring, all new master bedroom and bathroom suite with walk-in shower, brand new hallway bathroom, brand new kitchen featuring ceramic tile flooring, new soft-close white shaker cabinets, new countertops, subway tile, all new appliances, large living room, 3 bedrooms, laundry room with brand new washer and dryer.\r\n\r\nThe space\r\nStylishly remodeled and tastefully decorated house on Main street (Maple Avenue) heading from Interstate to quaint downtown Burlington. The home was completely renovated in October 2019. 55” 4K Smart TV in the living room equipped with all your favorite streaming apps. Fenced in back yard sitting on over 1/2 acres. The back yard is your oasis in the city.\r\n\r\nHigh-speed internet WiFi and desk for doing work.\r\n\r\nGuest access\r\nThe entire home is yours.',0,'0','0',NULL,0,1,'0','27215','1',0,1,0,4,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2020-02-19 18:30:23','2020-02-19 18:20:08','6844','',1,1308,0,0,'',0,2,NULL,0,6,0,0,1),(11,15465793,12,'House','Entire Place','Centrally located Triad/Triangle Home Near 85/40',6,0,'0','United States',NULL,'1614 Maple Ave, Burlington, NC 27215, USA','36.0755112','-79.42742199999999','1614 Maple Ave, Burlington, NC 27215, USA','Enjoy a Stylishly remodeled and tastefully decorated 3 bedroom 2 bath house less than 1 mile/3 minutes from I-85/40.\r\n\r\nNew features include, fresh paint, all new luxury vinyl plank flooring, all new master bedroom and bathroom suite with walk-in shower, brand new hallway bathroom, brand new kitchen featuring ceramic tile flooring, new soft-close white shaker cabinets, new countertops, subway tile, all new appliances, large living room, 3 bedrooms, laundry room with brand new washer and dryer.\r\n\r\nThe space\r\nStylishly remodeled and tastefully decorated house on Main street (Maple Avenue) heading from Interstate to quaint downtown Burlington. The home was completely renovated in October 2019. 55” 4K Smart TV in the living room equipped with all your favorite streaming apps. Fenced in back yard sitting on over 1/2 acres. The back yard is your oasis in the city.\r\n\r\nHigh-speed internet WiFi and desk for doing work.\r\n\r\nGuest access\r\nThe entire home is yours.',0,'0','0',NULL,0,1,'0','27215','1',1,1,0,5,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,'Moderate',NULL,NULL,NULL,'2020-06-05 05:42:09','2020-02-19 18:36:44','6844','',1,1308,0,0,'Fri',0,6,'no smoking, no pets,  no parties or events',0,0,0,0,2),(12,15465793,6,'Apartment','Private Room','dev-test',2,0,'0','Coimbatore','123','Coimbatore, Tamil Nadu, India','11.0168445','76.9558321','Coimbatore, Tamil Nadu, India','dev-test',0,'0','0',NULL,0,0,'0','Tamil Nadu','1',1,1,0,2,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,'Flexible',NULL,NULL,NULL,'2020-06-05 05:42:00','2020-03-30 14:28:29','64104','',100,0,0,0,'Sun',0,6,'testt',0,1,0,0,2),(13,15465793,6,'Apartment','Entire house','The Escape',3,0,'0','New York',NULL,'New York, New York','29.7604267','-95.3698028','New York, New York','Our 1-bedroom suite in the heart of Downtown Houston is where history meets elegance. The historic building is a distinguishing part of Houston’s skyline and provides a breathtaking view of downtown from within. Fully upgraded, it includes all of the modern amenities needed to enjoy a comfortable stay. The spacious interior includes a full kitchen, a bathroom with a bathtub, and a large walk-in closet attached to the bedroom. Being Downtown, you’re surrounded by entertainment, dining, and more!\r\n\r\nThe space\r\nOur 1-bedroom stay is furnished with a queen bed, a couch, and an air mattress. It has everything you need for a comfortable stay! The kitchen is stocked with cookware to cook simple meals, stainless steel appliances, and a Keurig to enjoy a fresh cup of coffee in the morning. There\'s a smart TV with Roku and Netflix (there is no cable) & free WiFi!\r\n\r\nGuest access\r\nYou can access the building anytime after 3pm by using the lockbox to obtain the keys. We ask that you respect our home and the quiet hours of the community. Our home is not baby proofed, and may not be ideal for families with very small children, however, children are welcome at your own discretion.',0,'0','0',NULL,0,1,'0','New York','United States',1,1,0,6,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,'Super Strict',NULL,NULL,NULL,'2020-06-20 11:48:30','2020-03-09 11:40:09','7700','',2,1000,1,0,'',0,2,'No Smoking',1,0,0,0,2),(14,15465793,6,'Apartment','shared room','Homeaway from home',3,0,'0','Harris County',NULL,'Houston, Texas, United States','29.7604267','-95.3698028','Houston, TX, USA','Our 1-bedroom suite in the heart of Downtown Houston is where history meets elegance. The historic building is a distinguishing part of Houston’s skyline and provides a breathtaking view of downtown from within. Fully upgraded, it includes all of the modern amenities needed to enjoy a comfortable stay. The spacious interior includes a full kitchen, a bathroom with a bathtub, and a large walk-in closet attached to the bedroom. Being Downtown, you’re surrounded by entertainment, dining, and more!\r\n\r\nThe space\r\nOur 1-bedroom stay is furnished with a queen bed, a couch, and an air mattress. It has everything you need for a comfortable stay! The kitchen is stocked with cookware to cook simple meals, stainless steel appliances, and a Keurig to enjoy a fresh cup of coffee in the morning. There\'s a smart TV with Roku and Netflix (there is no cable) & free WiFi!\r\n\r\nGuest access\r\nYou can access the building anytime after 3pm by using the lockbox to obtain the keys. We ask that you respect our home and the quiet hours of the community. Our home is not baby proofed, and may not be ideal for families with very small children, however, children are welcome at your own discretion.',0,'0','0',NULL,0,1,'0','Texas','United States',1,1,0,6,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,'Super Strict',NULL,NULL,NULL,'2020-06-20 11:47:25','2020-03-09 11:40:09','7700','',2,1000,1,0,'',0,2,'No Smoking',1,0,0,0,2),(15,15465793,6,'Apartment','shared room','Healthcare Living',3,0,'0','Los Angeles',NULL,'Los Angeles, California ','29.7604267','-95.3698028','Los Angeles, California ','Our 1-bedroom suite in the heart of Downtown Houston is where history meets elegance. The historic building is a distinguishing part of Houston’s skyline and provides a breathtaking view of downtown from within. Fully upgraded, it includes all of the modern amenities needed to enjoy a comfortable stay. The spacious interior includes a full kitchen, a bathroom with a bathtub, and a large walk-in closet attached to the bedroom. Being Downtown, you’re surrounded by entertainment, dining, and more!\r\n\r\nThe space\r\nOur 1-bedroom stay is furnished with a queen bed, a couch, and an air mattress. It has everything you need for a comfortable stay! The kitchen is stocked with cookware to cook simple meals, stainless steel appliances, and a Keurig to enjoy a fresh cup of coffee in the morning. There\'s a smart TV with Roku and Netflix (there is no cable) & free WiFi!\r\n\r\nGuest access\r\nYou can access the building anytime after 3pm by using the lockbox to obtain the keys. We ask that you respect our home and the quiet hours of the community. Our home is not baby proofed, and may not be ideal for families with very small children, however, children are welcome at your own discretion.',0,'0','0',NULL,0,1,'0','California','United States',1,1,0,6,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,'Super Strict',NULL,NULL,NULL,'2020-06-20 11:49:59','2020-03-09 11:40:09','7700','',2,1000,1,0,'',0,2,'No Smoking',0,0,0,0,2),(16,15465793,24,'House','Shared Room','ds',2,0,'0','Miami-Dade County','6576','Miami, FL, USA','25.7616798','-80.1917902','Miami, FL, USA','asdaasda  sadasdasd dasdsadads a dasdasd',0,'0','0',NULL,0,1,'0','Florida','1',1,1,0,5,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,'Flexible',NULL,NULL,NULL,'2020-07-10 08:17:36','2020-07-10 08:15:17','1231','',0,1212,0,0,'Sun',0,6,'asd',0,1,1,0,2),(17,15465793,25,'Apartment','Shared Room','sas',2,0,'0','Division No. 11',NULL,'Saskatoon, SK, Canada','52.1332144','-106.6700458','Division No. 11','asas',0,'0','0',NULL,0,0,'0','Saskatchewan','1',1,1,0,2,1,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,'Flexible',NULL,NULL,NULL,'2020-07-10 10:20:43','2020-07-10 10:20:43','saas','',12,0,0,0,'Sat',0,1,'wqw',0,0,0,0,2);
/*!40000 ALTER TABLE `property_list` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_long_term_pricing`
--

DROP TABLE IF EXISTS `property_long_term_pricing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_long_term_pricing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `price_per_month` varchar(50) NOT NULL,
  `security_deposit` float NOT NULL,
  `minimum_months` float NOT NULL,
  `advance` float NOT NULL,
  `status` int(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`),
  KEY `property_id` (`property_id`),
  KEY `property_id_2` (`property_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_long_term_pricing`
--

LOCK TABLES `property_long_term_pricing` WRITE;
/*!40000 ALTER TABLE `property_long_term_pricing` DISABLE KEYS */;
INSERT INTO `property_long_term_pricing` VALUES (1,15465793,31,'1000',100,3,100,1,'2018-07-27 06:05:49','0000-00-00 00:00:00'),(2,15465793,32,'1000',100,3,100,1,'2018-07-27 13:21:53','0000-00-00 00:00:00'),(3,15465793,36,'1000',100,3,100,1,'2018-07-28 09:52:06','0000-00-00 00:00:00'),(4,15465793,39,'1000',100,3,100,1,'2018-07-28 10:49:40','0000-00-00 00:00:00'),(5,15465793,40,'1000',100,3,100,1,'2018-07-28 11:20:46','0000-00-00 00:00:00'),(6,15465793,41,'1000',100,3,100,1,'2018-07-28 11:28:55','0000-00-00 00:00:00'),(7,15465793,42,'1000',100,3,100,1,'2018-07-28 11:35:29','0000-00-00 00:00:00'),(8,15465793,43,'1000',100,3,100,1,'2018-07-28 12:36:17','0000-00-00 00:00:00'),(9,15465793,48,'13',11,11,11,1,'2018-07-30 08:01:07','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `property_long_term_pricing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_rating`
--

DROP TABLE IF EXISTS `property_rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `booking_id` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rating` float NOT NULL,
  `comments` varchar(500) DEFAULT NULL,
  `rating_by` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_rating`
--

LOCK TABLES `property_rating` WRITE;
/*!40000 ALTER TABLE `property_rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `property_rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_review`
--

DROP TABLE IF EXISTS `property_review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_review` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `review_title` text NOT NULL,
  `review` text NOT NULL,
  `review_rating` int(11) NOT NULL,
  `reviewed_by` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `property_id` (`property_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_review`
--

LOCK TABLES `property_review` WRITE;
/*!40000 ALTER TABLE `property_review` DISABLE KEYS */;
/*!40000 ALTER TABLE `property_review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_room`
--

DROP TABLE IF EXISTS `property_room`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_room` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `property_size` float NOT NULL,
  `bathroom_count` float NOT NULL,
  `check_in_time` time NOT NULL,
  `check_out_time` time NOT NULL,
  `bedroom_count` float NOT NULL,
  `bed_count` float NOT NULL DEFAULT '0',
  `common_spaces` float NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_room`
--

LOCK TABLES `property_room` WRITE;
/*!40000 ALTER TABLE `property_room` DISABLE KEYS */;
INSERT INTO `property_room` VALUES (1,15465793,1,1000,2,'00:00:00','00:00:00',1,2,0,1,'2019-11-16 13:13:00','0000-00-00 00:00:00'),(2,15465793,2,100,2,'00:00:00','00:00:00',1,5,0,1,'2019-11-16 13:27:43','0000-00-00 00:00:00'),(3,15465793,3,1000,2,'00:00:00','00:00:00',1,5,0,1,'2019-11-16 13:36:55','0000-00-00 00:00:00'),(5,15465793,6,123456,1,'00:00:00','00:00:00',1,18,0,1,'2019-11-18 06:29:07','0000-00-00 00:00:00'),(6,15465793,5,1000,0,'00:00:00','00:00:00',1,5,0,1,'2019-11-18 06:42:58','0000-00-00 00:00:00'),(8,15465793,8,100,1,'00:00:00','00:00:00',1,0,1,1,'2019-11-22 14:51:59','0000-00-00 00:00:00'),(11,15465793,9,600,1,'00:00:00','00:00:00',1,1,1,1,'2020-01-30 02:11:44','0000-00-00 00:00:00'),(14,15465793,10,1308,2,'00:00:00','00:00:00',3,3,1,1,'2020-02-19 18:21:27','0000-00-00 00:00:00'),(17,15465793,11,1308,2,'00:00:00','00:00:00',3,3,1,1,'2020-02-19 20:45:14','0000-00-00 00:00:00'),(18,15465793,7,1000,2,'00:00:00','00:00:00',2,5,1,1,'2020-03-09 11:40:54','0000-00-00 00:00:00'),(19,15465793,12,0,1,'00:00:00','00:00:00',1,2,1,1,'2020-03-30 14:28:43','0000-00-00 00:00:00'),(20,15465793,16,1212,1.5,'00:00:00','00:00:00',1,4,1,1,'2020-07-10 08:15:58','0000-00-00 00:00:00'),(21,15465793,17,0,1,'00:00:00','00:00:00',1,0,1,1,'2020-07-10 10:18:11','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `property_room` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_room_types`
--

DROP TABLE IF EXISTS `property_room_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_room_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_room_types`
--

LOCK TABLES `property_room_types` WRITE;
/*!40000 ALTER TABLE `property_room_types` DISABLE KEYS */;
INSERT INTO `property_room_types` VALUES (2,'Private Room',0,'2018-10-24 08:10:03','2018-10-24 08:10:03'),(3,'Shared Room',0,'2019-02-06 08:03:43','2019-02-06 08:03:43'),(4,'Entire Place',0,'2019-02-06 08:03:58','2019-02-06 08:03:58');
/*!40000 ALTER TABLE `property_room_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_short_term_pricing`
--

DROP TABLE IF EXISTS `property_short_term_pricing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_short_term_pricing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `price_per_night` varchar(10) NOT NULL DEFAULT '0',
  `minimum_days` varchar(11) NOT NULL DEFAULT '1',
  `tax` int(10) NOT NULL,
  `price_more_than_one_week` varchar(10) NOT NULL DEFAULT '0',
  `price_more_than_one_month` varchar(11) NOT NULL DEFAULT '0',
  `price_per_weekend` varchar(10) NOT NULL DEFAULT '0',
  `weekend_days` varchar(50) NOT NULL DEFAULT '1',
  `cleaning_fee` varchar(10) NOT NULL DEFAULT '0',
  `cleaning_fee_type` varchar(50) NOT NULL DEFAULT '1',
  `city_fee_type` varchar(50) DEFAULT '0',
  `city_fee` varchar(25) DEFAULT NULL,
  `security_deposit` varchar(10) NOT NULL DEFAULT '0',
  `pre_booking_days` varchar(11) NOT NULL DEFAULT '1',
  `pre_booking_discount` int(10) NOT NULL,
  `is_extra_guest` varchar(5) NOT NULL DEFAULT '0',
  `price_per_extra_guest` varchar(10) NOT NULL,
  `first_payment_percentage` varchar(11) NOT NULL DEFAULT '1',
  `payment_parts` int(5) NOT NULL DEFAULT '1',
  `service_fee_percentage` float NOT NULL DEFAULT '1',
  `status` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `check_in` text NOT NULL,
  `check_out` text NOT NULL,
  `cleaning_type` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `property_short_term_pricing_fk0` (`client_id`),
  KEY `property_short_term_pricing_fk1` (`property_id`),
  KEY `property_id` (`property_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_short_term_pricing`
--

LOCK TABLES `property_short_term_pricing` WRITE;
/*!40000 ALTER TABLE `property_short_term_pricing` DISABLE KEYS */;
INSERT INTO `property_short_term_pricing` VALUES (1,15465793,1,'20','1',10,'17','15','25','','10','1','','10','4000','1',0,'0','','1',1,1,0,'2019-11-16 13:19:17','2019-11-16 13:19:17','00:00','06:00',''),(2,15465793,2,'4949','1',4893,'1614','4949','16','Sat','','1','','','1000','1',0,'0','','1',1,1,0,'2019-11-16 13:28:33','2019-11-16 13:28:33','00:00','01:00',''),(3,15465793,3,'55','1',88,'5','8','','Sat','','1','','','1000','1',0,'0','','1',1,1,0,'2019-11-16 13:37:38','2019-11-16 13:37:38','00:00','00:00',''),(4,15465793,5,'20','1',10,'17','15','25','fri,sat','10','1','','','1000','1',0,'0','','1',1,1,0,'2019-11-18 06:25:25','2019-11-18 06:25:25','00:00','00:00',''),(5,15465793,6,'199','1',10,'','','','Sat','','1','','','19999','1',0,'0','','1',1,1,0,'2019-11-18 06:29:56','2019-11-18 06:29:56','09:00','04:00',''),(6,15465793,7,'1500.00','1',10,'1500.00','1500.00','15','Sat','10','1',NULL,NULL,'1000','1',0,'0','','1',1,1,0,'2020-03-12 10:33:43','2019-11-21 08:04:41','5:15 PM','5:15 PM',''),(7,15465793,8,'100.00','2',0,'0','100.00','0','1','0','1',NULL,NULL,'0','1',0,'0','0','1',1,1,0,'2020-03-12 10:29:20','2019-11-22 14:53:54','12:00 AM','12:00 AM',''),(8,15465793,9,'55.00','1',0,'0','50.00','0','1','0','1',NULL,NULL,'0','1',0,'1','0','1',1,1,0,'2020-02-21 01:33:42','2020-01-29 17:00:23','4:00 PM','11:00 AM',''),(9,15465793,11,'58.00','1',0,'0','NaN','0','1','0','1',NULL,NULL,'0','1',0,'1','15.00','1',1,1,0,'2020-02-19 20:46:40','2020-02-19 18:46:54','3:00 PM','11:00 AM',''),(10,15465793,12,'1000.00','1',0,'0','1000.00','0','1','0','1',NULL,NULL,'100.00','1',0,'0','0','1',1,1,0,'2020-03-30 14:29:07','2020-03-30 14:29:07','1:00 AM','10:00 AM',''),(11,15465793,13,'55','1',88,'5','783','','Sat','','1','','','1000','1',0,'0','','1',1,1,0,'2019-11-16 13:37:38','2019-11-16 13:37:38','00:00','00:00',''),(12,15465793,14,'20','1',10,'17','1300','25','fri,sat','10','1','','','1000','1',0,'0','','1',1,1,0,'2019-11-18 06:25:25','2019-11-18 06:25:25','00:00','00:00',''),(13,15465793,15,'199','1',10,'','1050','','Sat','','1','','','19999','1',0,'0','','1',1,1,0,'2019-11-18 06:29:56','2019-11-18 06:29:56','09:00','04:00',''),(14,15465793,16,'123.00','1',0,'0','123.00','0','1','0','1',NULL,NULL,'89989.00','1',0,'1','0','1',1,1,0,'2020-07-10 08:17:18','2020-07-10 08:17:18','12:00 AM','2:00 PM',''),(15,15465793,17,'1212.00','1',0,'0','1212.00','0','1','0','1',NULL,NULL,'1221.00','1',0,'0','0','1',1,1,0,'2020-07-10 10:18:37','2020-07-10 10:18:37','4:00 PM','4:00 PM','');
/*!40000 ALTER TABLE `property_short_term_pricing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_special_pricing`
--

DROP TABLE IF EXISTS `property_special_pricing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_special_pricing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `client_id` int(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `price_per_night` varchar(20) NOT NULL,
  `property_id` int(10) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_special_pricing`
--

LOCK TABLES `property_special_pricing` WRITE;
/*!40000 ALTER TABLE `property_special_pricing` DISABLE KEYS */;
INSERT INTO `property_special_pricing` VALUES (1,6,15465793,'2019-11-22','2019-11-22','10',7,'2019-11-21 09:02:29',NULL),(2,6,15465793,'2019-11-23','2019-11-23','10',7,'2019-11-21 09:02:29',NULL),(3,25,15465793,'2020-07-10','2020-07-10','900.00',17,'2020-07-10 10:26:20',NULL);
/*!40000 ALTER TABLE `property_special_pricing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_types`
--

DROP TABLE IF EXISTS `property_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_types`
--

LOCK TABLES `property_types` WRITE;
/*!40000 ALTER TABLE `property_types` DISABLE KEYS */;
INSERT INTO `property_types` VALUES (1,'House',0,'2018-10-24 07:17:59','2018-10-24 07:17:59'),(2,'Apartment',0,'2019-02-06 07:58:20','2019-02-06 07:58:20'),(3,'Condo',0,'2019-02-06 07:58:35','2019-02-06 07:58:35'),(6,'RV',0,'2019-02-06 07:59:16','2019-02-06 07:59:16');
/*!40000 ALTER TABLE `property_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `property_video`
--

DROP TABLE IF EXISTS `property_video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `property_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `source` int(3) NOT NULL DEFAULT '0' COMMENT '0 - vimeo 1 - youtube',
  `url` varchar(100) NOT NULL,
  `sort` int(10) NOT NULL,
  `status` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `property_video_fk0` (`client_id`),
  KEY `property_video_fk1` (`property_id`),
  KEY `property_id` (`property_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_video`
--

LOCK TABLES `property_video` WRITE;
/*!40000 ALTER TABLE `property_video` DISABLE KEYS */;
/*!40000 ALTER TABLE `property_video` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recent_locations`
--

DROP TABLE IF EXISTS `recent_locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recent_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `location` varchar(500) NOT NULL,
  `name` varchar(500) NOT NULL,
  `status` int(3) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recent_locations`
--

LOCK TABLES `recent_locations` WRITE;
/*!40000 ALTER TABLE `recent_locations` DISABLE KEYS */;
/*!40000 ALTER TABLE `recent_locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reported_users`
--

DROP TABLE IF EXISTS `reported_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reported_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reported_user` varchar(100) NOT NULL,
  `reported_user_id` int(11) NOT NULL,
  `reported_by` varchar(255) NOT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `reported_by_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reported_users`
--

LOCK TABLES `reported_users` WRITE;
/*!40000 ALTER TABLE `reported_users` DISABLE KEYS */;
INSERT INTO `reported_users` VALUES (1,'Sarah Wilson',6,'yest smith','asdas',22,'2020-07-10 11:37:29',NULL),(2,'Sarah Wilson',6,'yest smith','as',22,'2020-07-10 11:38:16',NULL);
/*!40000 ALTER TABLE `reported_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `request_chat`
--

DROP TABLE IF EXISTS `request_chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `request_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `traveller_id` int(11) NOT NULL,
  `sent_by` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `guest_count` int(11) NOT NULL,
  `check_in` varchar(10) NOT NULL,
  `check_out` varchar(10) NOT NULL,
  `message` text NOT NULL,
  `status` int(3) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request_chat`
--

LOCK TABLES `request_chat` WRITE;
/*!40000 ALTER TABLE `request_chat` DISABLE KEYS */;
/*!40000 ALTER TABLE `request_chat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `request_chat_details`
--

DROP TABLE IF EXISTS `request_chat_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `request_chat_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `chat_id` int(11) NOT NULL,
  `child_count` int(11) NOT NULL,
  `first_name` varchar(111) NOT NULL,
  `last_name` varchar(111) NOT NULL,
  `email` varchar(111) NOT NULL,
  `phone_number` varchar(111) NOT NULL,
  `status` int(3) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request_chat_details`
--

LOCK TABLES `request_chat_details` WRITE;
/*!40000 ALTER TABLE `request_chat_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `request_chat_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `request_roommate`
--

DROP TABLE IF EXISTS `request_roommate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `request_roommate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` text NOT NULL,
  `phone` bigint(10) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `startdate` varchar(12) NOT NULL,
  `enddate` varchar(12) NOT NULL,
  `city` varchar(20) NOT NULL,
  `state` varchar(20) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `age` int(3) NOT NULL,
  `found_housing` varchar(3) NOT NULL,
  `rent` int(3) DEFAULT NULL,
  `is_house_on_healthcare` varchar(20) NOT NULL,
  `occupation` varchar(20) NOT NULL,
  `prefer_gender` varchar(20) NOT NULL,
  `prefer_age` varchar(20) NOT NULL,
  `request_details` varchar(60) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `request_roommate`
--

LOCK TABLES `request_roommate` WRITE;
/*!40000 ALTER TABLE `request_roommate` DISABLE KEYS */;
INSERT INTO `request_roommate` VALUES (1,'tyrty@yopmail.com',78587587,'TEST','TEST','07/10/2020','07/24/2020','ASAS','ASAS','Female',0,'',0,'Yes','GHF','Female','18-25','HJFJ','2020-07-10 10:49:10','2020-07-10 10:49:10');
/*!40000 ALTER TABLE `request_roommate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room_types`
--

DROP TABLE IF EXISTS `room_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `room_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `status` int(3) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `room_types`
--

LOCK TABLES `room_types` WRITE;
/*!40000 ALTER TABLE `room_types` DISABLE KEYS */;
INSERT INTO `room_types` VALUES (1,15465793,'Entire room',1,'2018-03-01 05:57:58','0000-00-00 00:00:00'),(2,15465793,'Shared room',1,'2018-03-01 05:57:58','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `room_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `param` varchar(250) NOT NULL,
  `value` varchar(255) CHARACTER SET utf8 NOT NULL,
  `is_image` int(2) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'logo','https://healthcaretravels.com/public/uploads/keepers_logo.png',1,1,'2018-07-17 16:06:53','2018-09-23 12:57:20'),(2,'app_name','Health Care Travels',0,1,'2018-07-17 16:06:53','2019-10-27 11:35:36'),(3,'currency','$',0,1,'2018-07-17 16:06:53','2019-10-27 11:35:36'),(4,'traveller_below_30_days','25',0,1,'2018-07-17 16:06:53','2019-10-27 11:35:36'),(5,'traveler_above_30_days','50',0,1,'2018-09-12 12:48:23','2019-10-27 11:35:36'),(6,'owner_below_30_days','25',0,1,'2018-09-20 05:26:58','2019-10-27 11:35:36'),(7,'owner_above_30_days','50',0,1,'2018-09-20 05:26:58','2019-10-27 11:35:36'),(8,'client_email','info@healthcaretravels.com',0,1,'2018-09-26 07:42:59','2019-10-27 11:35:36'),(9,'client_phone','1-(866)-955-9944',0,1,'2018-09-27 11:21:56','2019-08-23 12:57:09'),(10,'client_web','www.healthcaretravels.com',0,1,'2018-09-27 11:21:56','2019-10-27 11:35:36'),(11,'client_address','Health Care Travels, 7075 Fm 1960 Rd W, Houston, Texas 77069, United States Suite 1010',0,1,'2018-09-27 13:15:37','2019-10-27 11:35:36'),(12,'contact_content','Health Care Travels is committed to delivering a high level of expertise, customer service, and attention to detail to the market of accommodation booking .',0,1,'2018-09-27 13:15:37','2019-10-27 11:35:36'),(13,'verification_mail','info@healthcaretravels.com',0,1,'2018-10-03 12:43:16','2019-10-27 11:35:36'),(14,'support_mail','support@healthcaretravels.com​',0,1,'2018-10-03 12:43:16','2019-10-27 11:35:36'),(15,'facebook','https://www.facebook.com/healthcaretravels/',0,1,'2018-10-04 10:55:17','2019-10-27 11:35:36'),(16,'twitter','https://twitter.com/HC_Travels',0,1,'2018-10-04 10:55:17','2019-10-27 11:35:36'),(17,'google','https://plus.google.com/u/0/107370920783826975510',0,1,'2018-10-04 10:55:17','2019-10-27 11:35:36'),(18,'instagram','https://www.instagram.com/healthcaretravels/',0,1,'2018-10-04 10:55:17','2019-10-27 11:35:36'),(19,'guest_count','10',0,1,'2018-12-27 10:27:18','2019-10-27 11:35:36'),(20,'bedroom_count','10',0,1,'2018-12-27 10:27:40','2019-10-27 11:35:36');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `state`
--

DROP TABLE IF EXISTS `state`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `state_name` varchar(500) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `state`
--

LOCK TABLES `state` WRITE;
/*!40000 ALTER TABLE `state` DISABLE KEYS */;
INSERT INTO `state` VALUES (1,15465793,'Tobyona',0,'2017-12-27 10:27:28','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `state` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test_table`
--

DROP TABLE IF EXISTS `test_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `link` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test_table`
--

LOCK TABLES `test_table` WRITE;
/*!40000 ALTER TABLE `test_table` DISABLE KEYS */;
INSERT INTO `test_table` VALUES (1,'https://healthcaretravels.com/public/uploads/853803.jpg'),(2,'https://healthcaretravels.com/public/uploads/853803.jpg'),(3,'https://healthcaretravels.com/public/uploads/853803.jpg'),(4,'https://healthcaretravels.com/public/uploads/853803.jpg'),(5,'https://healthcaretravels.com/public/uploads/853803.jpg'),(6,'https://healthcaretravels.com/public/uploads/853803.jpg'),(7,'https://healthcaretravels.com/public/uploads/853803.jpg'),(8,'https://healthcaretravels.com/public/uploads/853803.jpg'),(9,'https://healthcaretravels.com/public/uploads/853803.jpg'),(10,'https://healthcaretravels.com/public/uploads/853803.jpg'),(11,'https://healthcaretravels.com/public/uploads/853803.jpg');
/*!40000 ALTER TABLE `test_table` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `third_party_calender`
--

DROP TABLE IF EXISTS `third_party_calender`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `third_party_calender` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `third_party_name` char(75) NOT NULL,
  `third_party_url` char(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `third_party_calender`
--

LOCK TABLES `third_party_calender` WRITE;
/*!40000 ALTER TABLE `third_party_calender` DISABLE KEYS */;
INSERT INTO `third_party_calender` VALUES (1,9,'Cozy Convenience Airbnb','https://www.airbnb.com/calendar/ical/32182322.ics?s=86e45ea0b56e8097add5bca2210a6924',1,'2020-01-30 02:54:04','0000-00-00 00:00:00'),(2,11,'AirBNB','https://www.airbnb.com/multicalendar/40169729',1,'2020-02-19 20:43:46','0000-00-00 00:00:00'),(3,16,'da','da',1,'2020-07-10 08:17:51','0000-00-00 00:00:00'),(4,17,'kjg','ytfrty',1,'2020-07-10 10:26:44','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `third_party_calender` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_favourites`
--

DROP TABLE IF EXISTS `user_favourites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_favourites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `sort` int(10) NOT NULL DEFAULT '1',
  `status` int(10) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `user_favourites_fk0` (`client_id`),
  KEY `user_favourites_fk1` (`user_id`),
  KEY `user_favourites_fk2` (`property_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_favourites`
--

LOCK TABLES `user_favourites` WRITE;
/*!40000 ALTER TABLE `user_favourites` DISABLE KEYS */;
INSERT INTO `user_favourites` VALUES (2,15465793,22,14,1,1,'2020-07-10 11:31:46','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `user_favourites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(100) NOT NULL,
  `status` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `client_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_role_fk0` (`client_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (1,'OWNER',1,'2018-09-06 06:40:44','0000-00-00 00:00:00',15465793),(0,'TRAVELLER',1,'2018-09-06 06:40:46','0000-00-00 00:00:00',15465793),(2,'TRAVEL AGENCY',1,'2018-09-06 06:41:37','2018-09-06 06:41:37',15465793);
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(20) NOT NULL,
  `email` varchar(500) DEFAULT '0',
  `first_name` varchar(500) DEFAULT '0',
  `last_name` varchar(500) DEFAULT '0',
  `phone` bigint(50) DEFAULT '0',
  `username` varchar(500) DEFAULT '0',
  `gender` varchar(500) DEFAULT '0',
  `date_of_birth` varchar(500) DEFAULT '0',
  `is_verified` int(11) DEFAULT '0',
  `fb_id` varchar(500) DEFAULT '0',
  `password` varchar(100) DEFAULT NULL,
  `auth_token` varchar(100) DEFAULT '0',
  `device_token` text,
  `role_id` int(10) NOT NULL COMMENT '0-Traveller,1-Owner, 2-Travel Agency,3-RV Traveller',
  `status` int(10) NOT NULL DEFAULT '1',
  `otp_verified` int(10) NOT NULL DEFAULT '0' COMMENT '0 - not verified 1 - verified',
  `otp` int(10) DEFAULT NULL,
  `email_verified` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `address` varchar(1000) DEFAULT '0',
  `country` varchar(500) DEFAULT '0',
  `state` varchar(500) DEFAULT '0',
  `city` varchar(500) DEFAULT '0',
  `pin_code` int(10) DEFAULT '0',
  `about_me` varchar(5000) DEFAULT '0',
  `current_city` varchar(5000) DEFAULT '0',
  `languages_known` varchar(500) DEFAULT '0',
  `paypal_email` varchar(500) DEFAULT '0',
  `facebook_url` varchar(500) DEFAULT '0',
  `twitter_url` varchar(500) DEFAULT '0',
  `skype_id` varchar(500) DEFAULT '0',
  `profile_image` varchar(500) DEFAULT ' ',
  `user_type` int(11) NOT NULL DEFAULT '0' COMMENT '0 - traveller 1 - owner',
  `login_type` varchar(500) NOT NULL DEFAULT '1' COMMENT '1-manual 2 - gmail 3 - facebook',
  `occupation` varchar(100) DEFAULT NULL,
  `occupation_desc` varchar(150) DEFAULT NULL,
  `reset_password_token` varchar(500) DEFAULT '0',
  `reset_date` varchar(10) DEFAULT NULL,
  `recruiter_name` varchar(52) DEFAULT NULL,
  `recruiter_phone` varchar(25) DEFAULT NULL,
  `work` varchar(255) DEFAULT '0',
  `school` varchar(255) DEFAULT '0',
  `name_of_agency` varchar(100) DEFAULT NULL,
  `website` varchar(255) DEFAULT '0',
  `rep_code` varchar(50) DEFAULT '0',
  `linkedin_url` varchar(190) DEFAULT '0',
  `airbnb_link` varchar(100) DEFAULT NULL,
  `home_away_link` varchar(100) DEFAULT NULL,
  `tax_home` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `users_fk0` (`client_id`),
  KEY `users_fk1` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'15465793','karthi@gmail.com','Karthi','K',919788429214,NULL,'0','0',0,'0','Ymh2VGRKVndkNVJXRUUrNi9ZeUZEQT09','7280291236','fVCXEo2JBuU:APA91bEP6cajAW_T1alJsHlODmSNLCMlF7yLx-VTVTiubfL9JH1MqLeIIqFqLfSSzQJ3jeK2OksXmE8pskvFSH9DvIlUg1d6sCnIA4qjswAodo9Jl1X7xj6UIafVPtPJlO1UlOE2SmB9',0,1,1,1506,0,'2019-11-16 10:43:17','2019-11-16 10:43:13','0','0','0','0',0,'0','0','0','0','0','0','0',' ',0,'1','Adex','Adex','0',NULL,NULL,NULL,'0','0','ACES','0','0','0',NULL,NULL,'0'),(2,'15465793','vishnu@gmail.com','Vishnu','V',917708964958,NULL,'0','1981-11-16',0,'0','Ymh2VGRKVndkNVJXRUUrNi9ZeUZEQT09','7723651106','fVCXEo2JBuU:APA91bEP6cajAW_T1alJsHlODmSNLCMlF7yLx-VTVTiubfL9JH1MqLeIIqFqLfSSzQJ3jeK2OksXmE8pskvFSH9DvIlUg1d6sCnIA4qjswAodo9Jl1X7xj6UIafVPtPJlO1UlOE2SmB9',1,1,1,3161,0,'2019-11-16 10:59:31','2019-11-16 10:59:27','Coimbatore','0','0','0',0,'0','0','0','0','0','0','0',' ',0,'1',NULL,NULL,'0',NULL,NULL,NULL,'0','0',NULL,'0','0','0',NULL,NULL,'0'),(3,'15465793','iOS@gmail.com','Hi','Gud',919648558880,'uug fgg','Male','2019/11/16',0,'0','Ymh2VGRKVndkNVJXRUUrNi9ZeUZEQT09','3963875381','cW30NBD4Avk:APA91bGRKFpXNj6tdgjrrM0Sqtko74Q4CtQmxaWM2kWXyJM7ebGvVyHISuyKfF6dvZ2waf8SlPC-bbFMvbYa4he2DYWEve9I5tElN1N7iz_hgSyXRAvYFBSvV6i-1APDsz8V4Rl28iPq',1,1,1,7410,0,'2019-11-16 13:24:17','2019-11-16 12:40:28','Hvjvvjb','0','0','0',0,'0','0',NULL,'0','0','0','0','https://healthcaretravels.com/public/uploads/P9ADIRFXDY.png',0,'1',NULL,NULL,'0',NULL,NULL,NULL,'0','0',NULL,'0','0','0',NULL,NULL,'0'),(4,'15465793','hfc@gmail.com','Hcuv','Hgyg',913538575857,NULL,'0','2019-11-16',0,'0','Ymh2VGRKVndkNVJXRUUrNi9ZeUZEQT09','6030173727','fVCXEo2JBuU:APA91bEP6cajAW_T1alJsHlODmSNLCMlF7yLx-VTVTiubfL9JH1MqLeIIqFqLfSSzQJ3jeK2OksXmE8pskvFSH9DvIlUg1d6sCnIA4qjswAodo9Jl1X7xj6UIafVPtPJlO1UlOE2SmB9',1,1,1,3797,0,'2019-11-16 13:09:45','2019-11-16 13:09:41','gcycy','0','0','0',0,'0','0','0','0','0','0','0',' ',0,'1',NULL,NULL,'0',NULL,NULL,NULL,'0','0',NULL,'0','0','0',NULL,NULL,'0'),(5,'15465793','18nov@gmail.com','Karthik','Sk',919865412384,'unf','Male','2019/11/18',0,'0','Ymh2VGRKVndkNVJXRUUrNi9ZeUZEQT09','2121271942','fhJqjiiipyg:APA91bG2unm8RikA4Lgb7UObc4We1TL8gu9z-535Zk4rPPoY_mPf6Iu3K_xMS6my4HUN37h8OkYq57IeWmwgKLlcl0GjjvFhw3RWnGUGhtoUSkR42X0JWt3_P06YXoDjA-SY9SYwkCGu',1,1,1,6367,0,'2019-11-18 06:34:56','2019-11-18 06:23:06','Hdhc','0','0','0',0,'0','0','Vzkd','0','0','0','0','https://healthcaretravels.com/public/uploads/I5ERWAIL6T.png',0,'1',NULL,NULL,'0',NULL,NULL,NULL,'0','0',NULL,'0','0','0',NULL,NULL,'0'),(6,'15465793','hctcare@gmail.com','Sarah','Wilson',911593572587,'Sarah Wilson','Female','2019-11-21',0,'0','YWpFYzBTUGZjc3BJRlduME5YZElkZz09','4202035847','egHQRCgIVts:APA91bE6bruhTuGMPA27dKP7NeVV8qJ56SdlNXXP4DP3A_79oGVQOJ8Hy-mP-5NVOMH-FFA_LzyBtyAxKrQhEeMjVEzDMIW26dX-d7yinB-T_rAp-XhYTo4_viaPk1pwdYTOGQRQB9oY',1,1,1,2103,1,'2020-03-30 14:22:06','2019-11-21 07:58:42','hchcxihuxh','0','0','0',0,'0','0','If it v','0','0','0','0','https://healthcaretravels.com/public/uploads/403060.jpg',0,'1',NULL,NULL,'0',NULL,NULL,NULL,'0','0',NULL,'0','0','0',NULL,NULL,'0'),(7,'15465793','21t@gmail.com','Jf','Jchv',911593574628,NULL,'0','0',0,'0','Ymh2VGRKVndkNVJXRUUrNi9ZeUZEQT09','1555265717','fdacuLoA-kA:APA91bGIKNjrZHQvwkOAb8ElndOcTwrILifYX-Jg4i__PaVJOvdU9_yKYn3ZK5HN2BIIiEBlncC1JJ00i9tu03YWG3TljC0z9WRG4-lOhIig5NJHedLZom3T02U2NL1j-wROnrby1GF2',0,1,1,3828,0,'2019-11-21 09:08:43','2019-11-21 09:08:40','0','0','0','0',0,'0','0','0','0','0','0','0',' ',0,'1','Advance Med','Advance Med','0',NULL,NULL,NULL,'0','0','Advance Med','0','0','0',NULL,NULL,'0'),(8,'15465793','ranjithkumar2441997ranji@gmail.com','Ranjith','Kumar123',9566754418,NULL,'0','2019-11-21',0,'0','MnMyaHAvTDAyR1k1NEpLczA2RmlzUT09','TRLOCSASWE',NULL,0,1,1,3318,1,'2019-11-22 14:38:21','2019-11-22 14:37:17',NULL,'0','0','0',0,'0','0','0','0','0','0','0',' ',0,'1','Allied Health','axasf','0',NULL,NULL,NULL,'0','0','24 Hour Medical Staffing','0','0','0',NULL,NULL,'0'),(9,'15465793','alisa.owens@gmail.com','Alisa','Owens',5108524784,'1','0','1937-07-23',0,'0','T0MrVE14eCtJcUE2VlA5UzlyVWh1Zz09','4CHYGKXGQH',NULL,1,1,1,1808,1,'2019-12-27 04:59:51','2019-12-27 04:53:37','347 Sandy Bay Court, Point Richmond 94801','0','0','0',0,'0','0','0','0','0','0','0',' ',0,'1',NULL,NULL,'0',NULL,NULL,NULL,'0','0',NULL,'0','0','0',NULL,NULL,'0'),(10,'15465793','twospirit69@hotmail.com','Jeff','Carvish',6193224241,NULL,'0','1963-09-01',0,'0','S3Z5UzZYZFNnT1FEY2d6N3ZXaGxtQT09','MCZUGYHFUM',NULL,1,1,1,5786,0,'2020-01-13 22:25:39','2020-01-13 22:25:14','8810 Meadow Rd SW','0','0','0',0,'0','0','0','0','0','0','0',' ',0,'1',NULL,NULL,'0',NULL,NULL,NULL,'0','0',NULL,'0','0','0',NULL,NULL,'0'),(11,'15465793','surilake@yahoo.com','Dora','Lake',8328675978,NULL,'0','1950-12-22',0,'0','cWs3Q1dtYmN0ZjZlZEw1dyt0OXZyUT09','UYWQPINPF4',NULL,1,1,1,7876,1,'2020-01-29 16:37:31','2020-01-29 16:37:31','1506 Crystal Meadow Pl','0','0','0',0,'I\'ve been a landlord and property manager for over forty years and take pride in offering well-maintained rental units. For the past three years I have been an Airbnb host as owner as well as being co-host/manager for numerous properties for others. I live in the Houston metro area.','0','English, Spanish','0','0','0','0',' ',0,'1',NULL,NULL,'0',NULL,NULL,NULL,'0','0',NULL,'0','0','0',NULL,NULL,'0'),(12,'15465793','info@Politeproperties.com','Krystal','Polite',1,NULL,'0','1980-02-14',0,'0','R2ZDbXQrOUY0RkhrYVRKRzQwejZGQT09','TSQG92NDPJ',NULL,1,1,0,5959,1,'2020-02-19 20:22:20','2020-02-18 20:30:58','1183 University Drive Suite 105-105 Burlington, NC 27215','0','0','0',0,'0','0','0','0','0','0','0',' ',0,'1',NULL,NULL,'0',NULL,NULL,NULL,'0','0',NULL,'0','0','0','https://www.airbnb.com/rooms/40169729?s','https://www.homeaway.com/haod/properties.html','0'),(13,'15465793','rainiervistaretreats@gmail.com','Lescia','Myers',2533896879,NULL,'0','1979-08-22',0,'0','dkw3RFZtbGZJRGxQTjBsQ1QyTklndz09','AXHFQEJTXR',NULL,1,1,0,9676,1,'2020-02-25 06:22:13','2020-02-25 06:21:08','11403 129th St E Puyallup, Wa 98374','0','0','0',0,'0','0','0','0','0','0','0',' ',0,'1',NULL,NULL,'0',NULL,NULL,NULL,'0','0',NULL,'0','0','0',NULL,NULL,'0'),(14,'15465793','healthcaretravelsdemo@mailinator.com',NULL,NULL,8344747831,'healthcaretravelsdemo','0',NULL,0,'0','dmkxT0pZSXBjQW9MbmJQVW5mWU5KQT09','LXJDCRNW8F',NULL,3,1,1,8013,1,'2020-03-09 11:00:46','2020-03-09 10:56:25',NULL,'0','0','0',0,'0','0','0','0','0','0','0',' ',0,'1',NULL,NULL,'0',NULL,NULL,NULL,'0','0',NULL,'0','0','0',NULL,NULL,'0'),(15,'15465793','healthcaretravelsdemo1@mailinator.com',NULL,NULL,3,'healthcaretravelsdemo1','0',NULL,0,'0','dmkxT0pZSXBjQW9MbmJQVW5mWU5KQT09','WOMSNGNS23',NULL,3,1,1,6770,1,'2020-03-09 11:02:32','2020-03-09 11:02:12',NULL,'0','0','0',0,'0','0','0','0','0','0','0',' ',0,'1',NULL,NULL,'0',NULL,NULL,NULL,'0','0',NULL,'0','0','0',NULL,NULL,'0'),(16,'15465793','healthcaretravelsdemo2@mailinator.com',NULL,NULL,35454566567,'healthcaretravelsdemo2','0',NULL,0,'0','dmkxT0pZSXBjQW9MbmJQVW5mWU5KQT09','FWUF3MLHTV',NULL,3,1,1,6782,1,'2020-03-09 11:31:15','2020-03-09 11:05:52',NULL,'0','0','0',0,'0','0','0','0','0','0','0',' https://healthcaretravels.com/public/user_profile_default.png',0,'1',NULL,NULL,'0',NULL,NULL,NULL,'0','0',NULL,'0','0','0',NULL,NULL,'0'),(17,'15465793','pisangoreng@mail.ru','0','0',NULL,NULL,'0','0',0,'0','dzBiT3pSNURwcWZiY3R5aURCc0pEQT09','5708480183',NULL,0,1,0,NULL,0,'2020-03-10 04:51:57','2020-03-10 04:51:57','0','0','0','0',0,'0','0','0','0','0','0','0',' ',0,'2',NULL,NULL,'0',NULL,NULL,NULL,'0','0',NULL,'0','0','0',NULL,NULL,'0'),(18,'15465793','hctravelss@gmail.com',NULL,NULL,8324459546,'Trailer','0',NULL,0,'0','ck9OZmY2L2xEdUhUREZNTWF0TUhiQT09','2RXXARHZAQ',NULL,3,1,1,9997,1,'2020-03-30 14:29:16','2020-03-30 14:29:16',NULL,'0','0','0',0,'drive','0','English','0','0','0','0',' ',0,'1',NULL,NULL,'0',NULL,NULL,NULL,'0','0',NULL,'0','0','0',NULL,NULL,'0'),(19,'15465793','brijeshbhakta30@gmail.com',NULL,NULL,9898304401,'2','0',NULL,0,'0','RVUwbGs1Z3J0MDZGanpzZG5uWHppQT09','J2UGHX5SWJ',NULL,2,1,1,6575,1,'2020-07-08 18:13:56','2020-07-08 18:13:56',NULL,'0','0','0',0,'0','0','English','0','0','0','0',' ',0,'1',NULL,NULL,'0',NULL,NULL,NULL,'0','0','Capability Healthcare','0','0','0',NULL,NULL,'0'),(20,'15465793','dylanmichaelcolby@gmail.com','Dylan','Colby',3024638354,NULL,'0','1997-05-09',0,'0','VjNqRUlZWlBUczJZM1Z6Y0tkNEIvQT09','QJNHVIOJTW',NULL,0,1,1,7340,1,'2020-07-08 18:38:13','2020-07-08 18:29:29',NULL,'0','0','0',0,'0','0','0','0','0','0','0',' ',0,'1','Nurse',NULL,'0',NULL,NULL,NULL,'0','0','TravelMax','0','0','0',NULL,NULL,'0'),(21,'15465793','phpatel.4518@gmail.com','Pooja','Patel',9809890890,'Select Account Type','0',NULL,0,'0','amFhREc5WVo4ZnRUTFFXNHp4RjBIQT09','YRFDPG3BTZ',NULL,2,1,1,5056,1,'2020-07-08 18:42:19','2020-07-08 18:41:30',NULL,'0','0','0',0,'0','0','0','0','0','0','0',' ',0,'1',NULL,NULL,'0',NULL,NULL,NULL,'0','0','ACCOUNTABLE HEALTHCARE STAFFING','0','0','0',NULL,NULL,'0'),(22,'15465793','yest@yopmail.com','yest','smith',786876876876,'2','0','1988-12-12',0,'0','NkdHQXFKcmJSck9LdkFDTnAvN0ZuQT09','NHYMEVVYEN',NULL,0,1,1,5058,1,'2020-07-10 11:09:29','2020-07-09 11:49:10',NULL,'0','0','0',0,'0','0','0','0','0','0','0',' ',0,'1','Community Health','saas','5594ff1e1bc56ade7acea7ead7c2a7bf8f8f6a6a','2020-07-10','qw','qwqw','0','0','ACCOUNTABLE HEALTHCARE STAFFING','0','0','0',NULL,NULL,'0'),(23,'15465793','rest@yopmail.com','Test test','yest',7678687687,NULL,'0','1980-12-12',0,'0','NkdHQXFKcmJSck9LdkFDTnAvN0ZuQT09','WCLE98V00U',NULL,0,1,1,6830,0,'2020-07-09 18:48:31','2020-07-09 18:48:24',NULL,'0','0','0',0,'0','0','0','0','0','0','0',' ',0,'1','Allied Health',NULL,'0',NULL,NULL,NULL,'0','0','24 Hour Medical Staffing','0','0','0',NULL,NULL,'0'),(24,'15465793','Traveller@yopmail.com','Traveller','Healthcare',28789798798,'0','0','08/12/2',0,'0','NkdHQXFKcmJSck9LdkFDTnAvN0ZuQT09','8SW8KOOEIU',NULL,0,1,1,6086,1,'2020-07-10 08:22:05','2020-07-10 08:22:05',NULL,'0','0','0',0,'testtt','0','English, Tamil, Hindi','0','SADDA','0','0',' ',0,'1','Other',NULL,'0',NULL,'SD','ASD','0','0','Name Of the Agency','0','0','0 ADSA',NULL,NULL,'uhhu'),(25,'15465793','owner@yopmail.comS','Owner','Property',876785875,NULL,'0','1980-12-12',0,'0','NkdHQXFKcmJSck9LdkFDTnAvN0ZuQT09','0YNEFT2R7G',NULL,1,1,1,1617,1,'2020-07-10 10:08:34','2020-07-10 10:08:34',NULL,'0','0','0',0,'SSS','0','0','0','0','0','0',' ',0,'1',NULL,NULL,'0',NULL,NULL,NULL,'0','0',NULL,'0','0','0',NULL,NULL,'0'),(26,'15465793','agency@yopmail.com',NULL,NULL,9834698698,NULL,'0',NULL,0,'0','NkdHQXFKcmJSck9LdkFDTnAvN0ZuQT09','FYCP9HHUA9',NULL,2,1,1,4705,1,'2020-07-10 10:37:19','2020-07-10 10:37:19',NULL,'0','0','0',0,'0','0','0','0','0','0','0',' ',0,'1',NULL,NULL,'0',NULL,NULL,NULL,'0','0','Name Of the Agency','0','0','0',NULL,NULL,'0');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `verify_mobile`
--

DROP TABLE IF EXISTS `verify_mobile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `verify_mobile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `verify_mobile`
--

LOCK TABLES `verify_mobile` WRITE;
/*!40000 ALTER TABLE `verify_mobile` DISABLE KEYS */;
INSERT INTO `verify_mobile` VALUES (1,12,'617-851-2364',0,'2020-02-18 17:12:43','2020-02-18 17:12:43'),(2,22,'67861287687',0,'2020-07-09 11:51:07','2020-07-09 11:51:07'),(3,24,'as12313SD',0,'2020-07-10 08:12:22','2020-07-10 08:12:22'),(4,25,'5785875875',0,'2020-07-10 10:09:26','2020-07-10 10:09:26');
/*!40000 ALTER TABLE `verify_mobile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `amenities`
--

/*!50001 DROP VIEW IF EXISTS `amenities`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `amenities` AS select `property_amenties`.`client_id` AS `client_id`,`property_amenties`.`property_id` AS `property_id`,`property_amenties`.`amenties_name` AS `amenties_name`,`amenities_list`.`icon_url` AS `amenties_icon` from (`property_amenties` join `amenities_list`) where (`amenities_list`.`amenities_name` = `property_amenties`.`amenties_name`) */;
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

-- Dump completed on 2020-07-10 16:40:04
