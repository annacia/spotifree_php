-- MySQL dump 10.13  Distrib 5.7.26, for Linux (x86_64)
--
-- Host: localhost    Database: spotifree
-- ------------------------------------------------------
-- Server version	5.7.26-0ubuntu0.18.04.1

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
-- Table structure for table `album`
--

DROP TABLE IF EXISTS `album`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `album` (
  `pkAlbum` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `nameAlbum` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`pkAlbum`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `album`
--

LOCK TABLES `album` WRITE;
/*!40000 ALTER TABLE `album` DISABLE KEYS */;
INSERT INTO `album` VALUES (18,'2018-06-30 15:01:22',NULL,'TDCC'),(19,'2018-06-30 15:03:49',NULL,'Sense8'),(20,'2018-06-30 15:07:49',NULL,'BlackPink'),(21,'2018-06-30 15:37:11',NULL,'GOT7'),(22,'2018-06-30 15:45:09',NULL,'Kris Wu'),(23,'2018-06-30 16:02:41',NULL,'Metallica'),(24,'2018-07-03 16:44:52',NULL,'Ashley Tisdale');
/*!40000 ALTER TABLE `album` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `pkCategory` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `nameCategory` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`pkCategory`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'2018-05-23 13:57:47',NULL,'Pop'),(2,'2018-05-23 13:57:47',NULL,'Rock'),(3,'2018-05-23 13:59:42',NULL,'Indie'),(4,'2018-05-23 13:59:42',NULL,'Heavy Metal'),(5,'2018-05-23 14:00:25',NULL,'Funk'),(6,'2018-05-23 14:00:25',NULL,'Sertanejo'),(7,'2018-05-23 14:01:05',NULL,'Pagode'),(8,'2018-05-23 14:01:05',NULL,'Reggae'),(9,'2018-05-23 14:01:32',NULL,'Rap');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `music`
--

DROP TABLE IF EXISTS `music`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `music` (
  `pkMusic` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `fkCategory` int(11) NOT NULL,
  `fkAlbum` int(11) NOT NULL,
  `fkUser` int(11) NOT NULL,
  `nameMusic` varchar(50) DEFAULT NULL,
  `dir_music` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `dir_art` varchar(300) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`pkMusic`),
  KEY `AlbumMusic` (`fkAlbum`),
  KEY `CategoryMusic` (`fkCategory`),
  KEY `UserMusic` (`fkUser`),
  CONSTRAINT `AlbumMusic` FOREIGN KEY (`fkAlbum`) REFERENCES `album` (`pkAlbum`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `CategoryMusic` FOREIGN KEY (`fkCategory`) REFERENCES `category` (`pkCategory`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `UserMusic` FOREIGN KEY (`fkUser`) REFERENCES `user` (`pkUser`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `music`
--

LOCK TABLES `music` WRITE;
/*!40000 ALTER TABLE `music` DISABLE KEYS */;
/*!40000 ALTER TABLE `music` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `musicplaylist`
--

DROP TABLE IF EXISTS `musicplaylist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `musicplaylist` (
  `pkMusicPlaylist` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `fkMusic` int(11) NOT NULL,
  `fkPlaylist` int(11) NOT NULL,
  PRIMARY KEY (`pkMusicPlaylist`),
  KEY `MusicMusicPlaylist` (`fkMusic`),
  KEY `PlaylistMusicPlaylist` (`fkPlaylist`),
  CONSTRAINT `MusicMusicPlaylist` FOREIGN KEY (`fkMusic`) REFERENCES `music` (`pkMusic`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `PlaylistMusicPlaylist` FOREIGN KEY (`fkPlaylist`) REFERENCES `playlist` (`pkPlaylist`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `musicplaylist`
--

LOCK TABLES `musicplaylist` WRITE;
/*!40000 ALTER TABLE `musicplaylist` DISABLE KEYS */;
/*!40000 ALTER TABLE `musicplaylist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `playlist`
--

DROP TABLE IF EXISTS `playlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `playlist` (
  `pkPlaylist` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `namePlaylist` varchar(15) DEFAULT NULL,
  `fkUser` int(11) NOT NULL,
  PRIMARY KEY (`pkPlaylist`),
  KEY `UserPlaylist` (`fkUser`),
  CONSTRAINT `UserPlaylist` FOREIGN KEY (`fkUser`) REFERENCES `user` (`pkUser`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `playlist`
--

LOCK TABLES `playlist` WRITE;
/*!40000 ALTER TABLE `playlist` DISABLE KEYS */;
/*!40000 ALTER TABLE `playlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `pkUser` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `nameUser` varchar(100) NOT NULL,
  `nickname` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  PRIMARY KEY (`pkUser`),
  UNIQUE KEY `nickname` (`nickname`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (25,'2019-09-29 11:40:28',NULL,'Carol','carol','carol@carol.com','e962e26db268b3db4fd115c60dc7a9e2');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-09-29 12:15:40
