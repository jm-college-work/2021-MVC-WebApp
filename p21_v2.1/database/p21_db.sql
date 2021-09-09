CREATE DATABASE  IF NOT EXISTS `p21_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `p21_db`;
-- MySQL dump 10.13  Distrib 8.0.24, for Win64 (x86_64)
--
-- Host: localhost    Database: p21_db
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.14-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `ID` varchar(10) NOT NULL,
  `FirstName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `PassWord` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `idcounty` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_admin_county_idx` (`idcounty`),
  CONSTRAINT `fk_admin_county` FOREIGN KEY (`idcounty`) REFERENCES `county` (`idcounty`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES ('ADMIN','John','Smith','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','jsmith@college.ie','0875869745',4),('ADMIN2','Jack','Murphy','Password1',NULL,NULL,5);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `allusers`
--

DROP TABLE IF EXISTS `allusers`;
/*!50001 DROP VIEW IF EXISTS `allusers`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `allusers` AS SELECT 
 1 AS `ID`,
 1 AS `FirstName`,
 1 AS `LastName`,
 1 AS `PassWord`,
 1 AS `email`,
 1 AS `mobile`,
 1 AS `idcounty`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `chatmsg`
--

DROP TABLE IF EXISTS `chatmsg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chatmsg` (
  `msgID` int(11) NOT NULL AUTO_INCREMENT,
  `msgText` varchar(244) DEFAULT NULL,
  `dateTimeStamp` datetime DEFAULT current_timestamp(),
  `msgAuthorID` varchar(10) DEFAULT NULL,
  `userType` varchar(10) DEFAULT NULL,
  `msgTo` varchar(10) DEFAULT 'ALL',
  PRIMARY KEY (`msgID`)
) ENGINE=InnoDB AUTO_INCREMENT=812 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chatmsg`
--

LOCK TABLES `chatmsg` WRITE;
/*!40000 ALTER TABLE `chatmsg` DISABLE KEYS */;
INSERT INTO `chatmsg` VALUES (4,'Hello from ADMIN','2021-03-20 10:21:05','ADMIN','ADMIN','ALL'),(6,'Hello from Manager','2021-03-20 10:21:05','MAN001','MANAGER','CUST001'),(811,'hello again','2021-04-20 15:24:27','CUST001','CUSTOMER','ALL');
/*!40000 ALTER TABLE `chatmsg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `country_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `country`
--

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;
INSERT INTO `country` VALUES (1,'Afghanistan'),(2,'Albania'),(3,'Bahamas'),(4,'Bahrain'),(5,'Cambodia'),(6,'Cameroon'),(7,'Denmark'),(8,'Djibouti'),(9,'East Timor'),(10,'Ecuador'),(11,'Falkland Islands (Malvinas)'),(12,'Faroe Islands'),(13,'Gabon'),(14,'Gambia'),(15,'Haiti'),(16,'Heard and Mc Donald Islands'),(17,'Iceland'),(18,'India'),(19,'Jamaica'),(20,'Japan'),(21,'Kenya'),(22,'Kiribati'),(23,'Lao Peoples Democratic Republic'),(24,'Latvia'),(25,'Macau'),(26,'Macedonia'),(27,'Namibia'),(28,'Nauru'),(29,'Oman'),(30,'Pakistan'),(31,'Palau'),(32,'Qatar'),(33,'Reunion'),(34,'Romania'),(35,'Saint Kitts and Nevis'),(36,'Saint Lucia'),(37,'Taiwan'),(38,'Tajikistan'),(39,'Uganda'),(40,'Ukraine'),(41,'Vanuatu'),(42,'Vatican City State'),(43,'Wallis and Futuna Islands'),(44,'Western Sahara'),(45,'Yemen'),(46,'Yugoslavia'),(47,'Zaire'),(48,'Zambia');
/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `county`
--

DROP TABLE IF EXISTS `county`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `county` (
  `idcounty` int(11) NOT NULL AUTO_INCREMENT,
  `countyName` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idcounty`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `county`
--

LOCK TABLES `county` WRITE;
/*!40000 ALTER TABLE `county` DISABLE KEYS */;
INSERT INTO `county` VALUES (1,'Antrim'),(2,'Armagh'),(3,'Carlow'),(4,'Cavan'),(5,'Clare'),(6,'Cork'),(7,'Donegal'),(8,'Down'),(9,'Dublin'),(10,'DunLaoghaire-Rathdown'),(11,'Fermanagh'),(12,'Fingal'),(13,'Galway'),(14,'Kerry'),(15,'Kildare'),(16,'Kilkenny'),(17,'Laois'),(18,'Leitrim'),(19,'Limerick'),(20,'Londonderry'),(21,'Longford'),(22,'Louth'),(23,'Mayo'),(24,'Meath'),(25,'Monaghan'),(26,'North Tipperary'),(27,'Offaly'),(28,'Roscommon'),(29,'Sligo'),(30,'South Dublin'),(31,'South Tipperary'),(32,'Tipperary'),(33,'Tyrone'),(34,'Waterford'),(35,'Westmeath'),(36,'Wexford'),(37,'Wicklow');
/*!40000 ALTER TABLE `county` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer` (
  `ID` varchar(10) NOT NULL,
  `FirstName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `PassWord` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `idcounty` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_customer_county1_idx` (`idcounty`),
  CONSTRAINT `fk_customer_county1` FOREIGN KEY (`idcounty`) REFERENCES `county` (`idcounty`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES ('CUST001','Jane','Smith','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','janeh@mail.com','0875544887',1),('CUST002','Joe','Morais','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','joe@@morais.com','0891234567',19),('CUST003','Harry','Boland','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','harry@lit.ie','01234567',2),('CUST007','James','Flannery','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','flann@gmail.com','0875426987',3);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manager`
--

DROP TABLE IF EXISTS `manager`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `manager` (
  `ID` varchar(10) NOT NULL,
  `FirstName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `PassWord` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `idcounty` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_manager_county1_idx` (`idcounty`),
  CONSTRAINT `fk_manager_county1` FOREIGN KEY (`idcounty`) REFERENCES `county` (`idcounty`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manager`
--

LOCK TABLES `manager` WRITE;
/*!40000 ALTER TABLE `manager` DISABLE KEYS */;
INSERT INTO `manager` VALUES ('MAN001','James','Murphy','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','james@framework.com','0862356897',19),('MAN004','Jack','McKeown','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','jack@lit.ie','0875458745',8);
/*!40000 ALTER TABLE `manager` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product` (
  `productID` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(45) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`productID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES (7,'Cadburys 100g Milk Chocolate',1.45),(8,'Cadburys Easter Egg 200g',3.25),(9,'Wispa Bar 100g',1.42);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `project` (
  `projectID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `description` varchar(45) DEFAULT NULL,
  `userID` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`projectID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (1,'Gardening','Garden stuff','CUST001'),(2,'Web App','My new web application','CUST001'),(3,'Yoga Classes','Weekly yoga schedule','CUST001'),(4,'Data Science Course','Weekly python course schedule','CUST002'),(5,'College Tasks','College related tasks','CUST002'),(6,'Cooking Classes','Weekly cooking class schedule','CUST003'),(7,'Python','Learn more about Python','CUST002');
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `allusers`
--

/*!50001 DROP VIEW IF EXISTS `allusers`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `allusers` AS select `admin`.`ID` AS `ID`,`admin`.`FirstName` AS `FirstName`,`admin`.`LastName` AS `LastName`,`admin`.`PassWord` AS `PassWord`,`admin`.`email` AS `email`,`admin`.`mobile` AS `mobile`,`admin`.`idcounty` AS `idcounty` from `admin` union select `customer`.`ID` AS `ID`,`customer`.`FirstName` AS `FirstName`,`customer`.`LastName` AS `LastName`,`customer`.`PassWord` AS `PassWord`,`customer`.`email` AS `email`,`customer`.`mobile` AS `mobile`,`customer`.`idcounty` AS `idcounty` from `customer` union select `manager`.`ID` AS `ID`,`manager`.`FirstName` AS `FirstName`,`manager`.`LastName` AS `LastName`,`manager`.`PassWord` AS `PassWord`,`manager`.`email` AS `email`,`manager`.`mobile` AS `mobile`,`manager`.`idcounty` AS `idcounty` from `manager` */;
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

-- Dump completed on 2021-04-27 16:02:27
