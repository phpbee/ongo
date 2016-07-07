# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.7.12)
# Database: ongo_test
# Generation Time: 2016-07-07 16:23:41 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table city
# ------------------------------------------------------------

DROP TABLE IF EXISTS `city`;

CREATE TABLE `city` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(11) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`),
  CONSTRAINT `city_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `city` WRITE;
/*!40000 ALTER TABLE `city` DISABLE KEYS */;

INSERT INTO `city` (`id`, `country_id`, `name`, `logo`)
VALUES
	(2,1,'Siem Reap','/img/city2.jpg'),
	(4,2,'Petersburg',NULL),
	(5,3,'Washington',NULL),
	(6,3,'Toronto',NULL),
	(7,3,'Miami',NULL);

/*!40000 ALTER TABLE `city` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table country
# ------------------------------------------------------------

DROP TABLE IF EXISTS `country`;

CREATE TABLE `country` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `country` WRITE;
/*!40000 ALTER TABLE `country` DISABLE KEYS */;

INSERT INTO `country` (`id`, `name`, `logo`)
VALUES
	(1,'Cambodia','/img/city3.jpg'),
	(2,'Russian Federation',NULL),
	(3,'USA',NULL);

/*!40000 ALTER TABLE `country` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table gallery
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gallery`;

CREATE TABLE `gallery` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `place_id` int(11) unsigned NOT NULL,
  `photograph_id` int(10) unsigned NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  KEY `photograph_id` (`photograph_id`),
  KEY `place_id` (`place_id`),
  CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`photograph_id`) REFERENCES `photograph` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gallery_ibfk_2` FOREIGN KEY (`place_id`) REFERENCES `place` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `gallery` WRITE;
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;

INSERT INTO `gallery` (`id`, `created`, `place_id`, `photograph_id`, `description`)
VALUES
	(5,'2016-06-13 18:40:36',11,16,NULL),
	(1019,'2016-06-30 22:07:21',3,8,'www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)'),
	(1020,'2016-06-30 22:07:21',3,8,'www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot'),
	(1021,'2016-06-30 22:07:21',3,8,'www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection'),
	(1022,'2016-06-30 22:07:21',3,8,'www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016'),
	(1023,'2016-06-30 22:07:21',3,8,'www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017'),
	(1024,'2016-06-30 22:07:21',3,8,'www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016');

/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table photo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `photo`;

CREATE TABLE `photo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `gallery_id` int(10) unsigned NOT NULL,
  `src` varchar(255) DEFAULT NULL,
  `thumb` varchar(255) DEFAULT NULL,
  `ico` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gallery_id` (`gallery_id`),
  CONSTRAINT `photo_ibfk_1` FOREIGN KEY (`gallery_id`) REFERENCES `gallery` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `photo` WRITE;
/*!40000 ALTER TABLE `photo` DISABLE KEYS */;

INSERT INTO `photo` (`id`, `gallery_id`, `src`, `thumb`, `ico`)
VALUES
	(243,5,'/img/city1.jpg','/img/city1.jpg','/img/city1.jpg'),
	(244,5,'/img/city2.jpg','/img/city2.jpg','/img/city2.jpg'),
	(245,5,'/img/city3.jpg','/img/city3.jpg','/img/city3.jpg'),
	(423,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0001.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0001.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0001.jpg'),
	(424,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0002.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0002.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0002.jpg'),
	(425,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0003.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0003.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0003.jpg'),
	(426,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0004.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0004.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0004.jpg'),
	(427,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0005.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0005.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0005.jpg'),
	(428,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0006.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0006.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0006.jpg'),
	(429,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0007.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0007.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0007.jpg'),
	(430,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0008.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0008.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0008.jpg'),
	(431,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0009.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0009.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0009.jpg'),
	(432,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0010.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0010.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0010.jpg'),
	(433,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0011.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0011.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0011.jpg'),
	(434,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0012.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0012.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0012.jpg'),
	(435,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0013.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0013.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0013.jpg'),
	(436,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0014.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0014.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0014.jpg'),
	(437,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0015.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0015.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0015.jpg'),
	(438,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0016.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0016.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0016.jpg'),
	(439,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0017.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0017.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0017.jpg'),
	(440,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0018.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0018.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0018.jpg'),
	(441,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0019.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0019.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0019.jpg'),
	(442,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0020.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0020.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0020.jpg'),
	(443,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0021.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0021.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0021.jpg'),
	(444,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0022.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0022.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0022.jpg'),
	(445,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0023.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0023.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0023.jpg'),
	(446,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0024.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0024.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0024.jpg'),
	(447,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0025.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0025.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0025.jpg'),
	(448,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0026.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0026.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0026.jpg'),
	(449,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0027.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0027.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0027.jpg'),
	(450,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0028.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0028.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0028.jpg'),
	(451,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0029.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0029.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0029.jpg'),
	(452,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0030.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0030.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0030.jpg'),
	(453,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0031.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0031.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0031.jpg'),
	(454,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0032.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0032.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0032.jpg'),
	(455,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0033.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0033.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0033.jpg'),
	(456,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0034.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0034.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0034.jpg'),
	(457,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0035.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0035.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0035.jpg'),
	(458,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0036.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0036.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0036.jpg'),
	(459,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0037.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0037.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0037.jpg'),
	(460,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0038.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0038.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0038.jpg'),
	(461,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0039.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0039.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0039.jpg'),
	(462,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0040.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0040.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0040.jpg'),
	(463,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0041.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0041.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0041.jpg'),
	(464,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0042.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0042.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0042.jpg'),
	(465,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0043.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0043.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0043.jpg'),
	(466,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0044.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0044.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0044.jpg'),
	(467,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0045.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0045.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0045.jpg'),
	(468,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0046.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0046.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0046.jpg'),
	(469,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0047.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0047.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0047.jpg'),
	(470,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0048.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0048.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0048.jpg'),
	(471,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0049.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0049.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0049.jpg'),
	(472,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0050.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0050.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0050.jpg'),
	(473,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0051.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0051.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0051.jpg'),
	(474,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0052.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0052.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0052.jpg'),
	(475,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0053.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0053.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0053.jpg'),
	(476,1019,'http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/MM0054.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/MM0054.jpg','http://www2.cloudspaceto.me/t8/Candice Swanepoel - Free People July 2014 (Repost)/thumb/ico_MM0054.jpg'),
	(478,1020,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/MM0001.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/MM0001.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/ico_MM0001.jpg'),
	(479,1020,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/MM0002.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/MM0002.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/ico_MM0002.jpg'),
	(480,1020,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/MM0003.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/MM0003.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/ico_MM0003.jpg'),
	(481,1020,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/MM0004.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/MM0004.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/ico_MM0004.jpg'),
	(482,1020,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/MM0005.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/MM0005.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/ico_MM0005.jpg'),
	(483,1020,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/MM0006.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/MM0006.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/ico_MM0006.jpg'),
	(484,1020,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/MM0007.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/MM0007.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/ico_MM0007.jpg'),
	(485,1020,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/MM0008.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/MM0008.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/ico_MM0008.jpg'),
	(486,1020,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/MM0009.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/MM0009.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/ico_MM0009.jpg'),
	(487,1020,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/MM0010.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/MM0010.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Russ Elloway photoshoot/thumb/ico_MM0010.jpg'),
	(489,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0001.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0001.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0001.jpg'),
	(490,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0002.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0002.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0002.jpg'),
	(491,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0003.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0003.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0003.jpg'),
	(492,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0004.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0004.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0004.jpg'),
	(493,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0005.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0005.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0005.jpg'),
	(494,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0006.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0006.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0006.jpg'),
	(495,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0007.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0007.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0007.jpg'),
	(496,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0008.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0008.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0008.jpg'),
	(497,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0009.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0009.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0009.jpg'),
	(498,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0010.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0010.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0010.jpg'),
	(499,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0011.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0011.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0011.jpg'),
	(500,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0012.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0012.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0012.jpg'),
	(501,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0013.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0013.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0013.jpg'),
	(502,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0014.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0014.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0014.jpg'),
	(503,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0015.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0015.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0015.jpg'),
	(504,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0016.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0016.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0016.jpg'),
	(505,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0017.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0017.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0017.jpg'),
	(506,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0018.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0018.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0018.jpg'),
	(507,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0019.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0019.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0019.jpg'),
	(508,1021,'http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/MM0020.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/MM0020.jpg','http://www2.cloudspaceto.me/t8/Prestin Obradovich - Lee + Lani collection/thumb/ico_MM0020.jpg'),
	(510,1022,'http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/1.jpg','http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/thumb/1.jpg','http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/thumb/ico_1.jpg'),
	(511,1022,'http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/2.jpg','http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/thumb/2.jpg','http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/thumb/ico_2.jpg'),
	(512,1022,'http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/3.jpg','http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/thumb/3.jpg','http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/thumb/ico_3.jpg'),
	(513,1022,'http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/4.jpg','http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/thumb/4.jpg','http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/thumb/ico_4.jpg'),
	(514,1022,'http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/5.jpg','http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/thumb/5.jpg','http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/thumb/ico_5.jpg'),
	(515,1022,'http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/6.jpg','http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/thumb/6.jpg','http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/thumb/ico_6.jpg'),
	(516,1022,'http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/7.jpg','http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/thumb/7.jpg','http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/thumb/ico_7.jpg'),
	(517,1022,'http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/8.jpg','http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/thumb/8.jpg','http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/thumb/ico_8.jpg'),
	(518,1022,'http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/9.jpg','http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/thumb/9.jpg','http://www2.cloudspaceto.me/t8/Daniela Lopez Osorio - Stephan Wurth Photoshoot 2016/thumb/ico_9.jpg'),
	(520,1023,'http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/10.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/10.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/ico_10.jpg'),
	(521,1023,'http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/1.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/1.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/ico_1.jpg'),
	(522,1023,'http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/2.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/2.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/ico_2.jpg'),
	(523,1023,'http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/3.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/3.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/ico_3.jpg'),
	(524,1023,'http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/4.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/4.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/ico_4.jpg'),
	(525,1023,'http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/5.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/5.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/ico_5.jpg'),
	(526,1023,'http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/6.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/6.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/ico_6.jpg'),
	(527,1023,'http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/7.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/7.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/ico_7.jpg'),
	(528,1023,'http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/8.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/8.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/ico_8.jpg'),
	(529,1023,'http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/9.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/9.jpg','http://www2.cloudspaceto.me/t8/Kiernan Shipka - Kristian Schuller Photoshoot for  Carolina Herrera Resort 2017/thumb/ico_9.jpg'),
	(531,1024,'http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/10.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/10.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/ico_10.jpg'),
	(532,1024,'http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/11.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/11.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/ico_11.jpg'),
	(533,1024,'http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/1.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/1.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/ico_1.jpg'),
	(534,1024,'http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/2.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/2.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/ico_2.jpg'),
	(535,1024,'http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/3.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/3.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/ico_3.jpg'),
	(536,1024,'http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/4.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/4.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/ico_4.jpg'),
	(537,1024,'http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/5.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/5.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/ico_5.jpg'),
	(538,1024,'http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/6.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/6.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/ico_6.jpg'),
	(539,1024,'http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/7.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/7.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/ico_7.jpg'),
	(540,1024,'http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/8.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/8.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/ico_8.jpg'),
	(541,1024,'http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/9.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/9.jpg','http://www2.cloudspaceto.me/t8/Rosie Huntington-Whiteley - Russell James Photoshoot 2016/thumb/ico_9.jpg');

/*!40000 ALTER TABLE `photo` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table photograph
# ------------------------------------------------------------

DROP TABLE IF EXISTS `photograph`;

CREATE TABLE `photograph` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `photograph` WRITE;
/*!40000 ALTER TABLE `photograph` DISABLE KEYS */;

INSERT INTO `photograph` (`id`, `name`)
VALUES
	(1,'greater flamingos'),
	(2,'phoenicopterus'),
	(3,'bird'),
	(4,'exterior'),
	(5,'fenicottero'),
	(6,'italy'),
	(7,'outside pink'),
	(8,'roberto melotti'),
	(9,'Nick'),
	(10,'Dilan'),
	(11,'Jim'),
	(12,'Grayson Hoffman'),
	(13,'Gilles Bensimon'),
	(14,'Underlash Activewwear'),
	(15,'Gooseberry Intimates'),
	(16,'Parah Lingerie');

/*!40000 ALTER TABLE `photograph` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table place
# ------------------------------------------------------------

DROP TABLE IF EXISTS `place`;

CREATE TABLE `place` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `city_id` int(11) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`city_id`),
  CONSTRAINT `place_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `place` WRITE;
/*!40000 ALTER TABLE `place` DISABLE KEYS */;

INSERT INTO `place` (`id`, `city_id`, `name`, `logo`)
VALUES
	(1,2,'Angkor Wat','/img/city1.jpg'),
	(2,2,'Bayon temple complex',NULL),
	(3,4,'Cathedral of the Resurrection',NULL),
	(4,5,'Lincoln Memorial',NULL),
	(5,7,'NightClub',NULL),
	(6,6,'Uniun Nightclub',NULL),
	(7,6,'Brittany Oldehoff',NULL),
	(8,6,'Ginta Lapina',NULL),
	(9,6,'Jacqueline Oloniceva',NULL),
	(10,6,'Maya Stepper',NULL),
	(11,6,'Paula Bulczynska',NULL);

/*!40000 ALTER TABLE `place` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
