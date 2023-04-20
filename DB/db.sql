-- MariaDB dump 10.19  Distrib 10.5.19-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: EnCom
-- ------------------------------------------------------
-- Server version	10.5.19-MariaDB-0+deb11u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Device`
--

DROP TABLE IF EXISTS `Device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Device` (
  `device_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kw` float DEFAULT NULL,
  PRIMARY KEY (`device_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `Device_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `User` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Device`
--

LOCK TABLES `Device` WRITE;
/*!40000 ALTER TABLE `Device` DISABLE KEYS */;
INSERT INTO `Device` VALUES (1,'contatore',1,0.7);
/*!40000 ALTER TABLE `Device` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Location`
--

DROP TABLE IF EXISTS `Location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Location` (
  `ID` int(11) NOT NULL,
  `street` varchar(30) NOT NULL,
  `civic_number` int(11) NOT NULL,
  `city` varchar(30) NOT NULL,
  `cap` int(6) NOT NULL,
  `state` varchar(30) NOT NULL,
  KEY `ID` (`ID`),
  CONSTRAINT `Location_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `User` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Location`
--

LOCK TABLES `Location` WRITE;
/*!40000 ALTER TABLE `Location` DISABLE KEYS */;
INSERT INTO `Location` VALUES (1,'Via Timoleone',41,'Gela',93012,'Italy');
/*!40000 ALTER TABLE `Location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pricing`
--

DROP TABLE IF EXISTS `Pricing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pricing` (
  `id_bill` int(11) NOT NULL AUTO_INCREMENT,
  `rate_amount` float NOT NULL,
  `date` date NOT NULL,
  `paid` tinyint(4) DEFAULT NULL,
  `deadline` int(11) DEFAULT NULL,
  `id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_bill`),
  KEY `id` (`id`),
  CONSTRAINT `Pricing_ibfk_1` FOREIGN KEY (`id`) REFERENCES `User` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pricing`
--

LOCK TABLES `Pricing` WRITE;
/*!40000 ALTER TABLE `Pricing` DISABLE KEYS */;
INSERT INTO `Pricing` VALUES (1,42.65,'2023-04-14',1,1,1),(2,0.371,'2023-05-14',NULL,1,1);
/*!40000 ALTER TABLE `Pricing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) DEFAULT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL,
  `fiscal_code` char(16) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES (1,'domestico','Mattia','Ruberto','RBRMTT03B05D960G','mattiar.o@live.it','!.D3vast4tor.!');
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'EnCom'
--
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `gen_bill` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `gen_bill`(IN Id int)
    MODIFIES SQL DATA
BEGIN
  SELECT type into @user_type from User WHERE ID=Id;
  SELECT kw into @kw from Device WHERE id=Id AND type='contatore';
  SELECT deadline into @deadline from Pricing WHERE id=Id;
  IF(@user_type = "domestico") THEN
    INSERT INTO Pricing(rate_amount,date,paid,deadline,id) VALUES(
      @kw*0.530,
      CURDATE()+(@deadline*100),
      paid = NULL,
      @deadline,
      Id
    );
    ELSE
      INSERT INTO Pricing(rate_amount,date,paid,deadline,id) VALUES(
      @kw*0.510,
      CURDATE()+(@deadline*100),
      paid = NULL,
      @deadline,
      Id
      );
  END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
/*!50003 DROP PROCEDURE IF EXISTS `pay_bill` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `pay_bill`(in bill_id int)
    MODIFIES SQL DATA
BEGIN    UPDATE Pricing SET paid=1 where ID=bill_id; END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-04-20 11:39:59
