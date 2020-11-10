/*
SQLyog Ultimate v10.00 Beta1
MySQL - 5.6.21 : Database - mantrahe_data
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`mantrahe_data` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `mantrahe_data`;

/*Table structure for table `branch_master` */

DROP TABLE IF EXISTS `branch_master`;

CREATE TABLE `branch_master` (
  `BRANCH_ID` int(11) NOT NULL AUTO_INCREMENT,
  `BRANCH_CODE` varchar(5) DEFAULT NULL,
  `BRANCH_NAME` varchar(50) DEFAULT NULL,
  `LAST_SRL` int(11) DEFAULT '0',
  `E_SRL` int(11) DEFAULT '0',
  `company_id` int(11) DEFAULT NULL,
  `branch_address` varchar(500) NOT NULL,
  `is_active` enum('Y','N') DEFAULT 'Y',
  `gst_no` varchar(255) DEFAULT NULL,
  `company_contact` varchar(15) DEFAULT NULL,
  `contact_person` varchar(200) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`BRANCH_ID`),
  KEY `BRANCH_CODE` (`BRANCH_CODE`),
  KEY `BRANCH_ID` (`BRANCH_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

/*Data for the table `branch_master` */

insert  into `branch_master`(`BRANCH_ID`,`BRANCH_CODE`,`BRANCH_NAME`,`LAST_SRL`,`E_SRL`,`company_id`,`branch_address`,`is_active`,`gst_no`,`company_contact`,`contact_person`,`created_dt`,`created_by`) values (1,'SN','SINTHI',1712,451,1,'OM TOWER 36C, B.T. Road, Kol- 700002','Y',NULL,NULL,NULL,NULL,NULL),(2,'IS','ISSWBM',0,0,1,'','Y',NULL,NULL,NULL,NULL,NULL),(3,'BP','BARRACKPORE',304,10,1,'4/2, S.N. Banerjee Road, Kolkata- 700 120','Y','','','',NULL,NULL),(4,'TR','TOBBIN ROAD',304,0,1,'','Y',NULL,NULL,NULL,NULL,NULL),(9,'AB','ANY BRANCH',0,0,1,'','N','','','',NULL,NULL),(11,'CM','CHIRIAMORE',0,0,1,'29F, B.T. Road, (Ground Floor) Kolkata- 700 002','Y',NULL,NULL,NULL,NULL,NULL),(10,'SC','SINTHI & CHIRIAMORE',0,0,1,'','Y',NULL,NULL,NULL,NULL,NULL),(12,'HO','HEAD OFFICE',0,0,1,'','Y',NULL,NULL,NULL,NULL,NULL),(13,'SM','SWASTH MANTRA',0,0,1,'','Y',NULL,NULL,NULL,NULL,NULL),(14,'TX','TEXMACO ',0,0,1,'','Y',NULL,NULL,NULL,NULL,NULL),(15,'MS','MAIN STOCK',0,0,1,'','Y',NULL,NULL,NULL,NULL,NULL),(16,'LT','LAKE TOWN',0,0,2,'95, Block-B, Laketown, Kolkata - 700089','Y',NULL,NULL,NULL,NULL,NULL),(17,'KP','KANCHRAPARA',0,0,1,'','Y',NULL,NULL,NULL,NULL,NULL),(18,'BP','BARRACKPORE',1,1,6,'4/2, S.N. Banerjee Road, Kolkata- 700 120','Y','','','','2020-11-07 12:07:24',1);

/*Table structure for table `company_master` */

DROP TABLE IF EXISTS `company_master`;

CREATE TABLE `company_master` (
  `comany_id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(100) NOT NULL,
  `company_address` varchar(300) DEFAULT NULL,
  `company_phone` varchar(100) DEFAULT NULL,
  `company_email` varchar(100) DEFAULT NULL,
  `GISTN_no` varchar(20) NOT NULL,
  `registration_no` varchar(255) DEFAULT NULL,
  `is_parrent` enum('Y','N') DEFAULT 'N',
  `logo_name` varchar(255) DEFAULT NULL,
  `short_name` varchar(255) DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT 'Y',
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`comany_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `company_master` */

insert  into `company_master`(`comany_id`,`company_name`,`company_address`,`company_phone`,`company_email`,`GISTN_no`,`registration_no`,`is_parrent`,`logo_name`,`short_name`,`is_active`,`created_date`,`created_by`) values (1,'NU MANTRA LIFE STYLE HEALTH CLUB PVT LTD.','29F,B T ROAD,KOLKATA - 700 002','9088316465',NULL,'19AADCN1378E1ZG','123456','Y',NULL,NULL,'Y',NULL,NULL),(2,'SWASTH MANTRA ',NULL,NULL,NULL,'',NULL,'N',NULL,NULL,'Y',NULL,NULL),(3,'MANTRA INSTITUTE OF FITNESS & EDUCATION',NULL,NULL,NULL,'',NULL,'N',NULL,NULL,'Y',NULL,NULL),(4,'MANTRA POLICE ',NULL,NULL,NULL,'',NULL,'N',NULL,NULL,'Y',NULL,NULL),(6,'ABC Pvt Ltd',NULL,NULL,NULL,'','40338','N','AB5fa53bb278a3c1604664242.jpg','AB','Y','0000-00-00 00:00:00',1),(7,'XYZ Pvt Ltd',NULL,'8910088950','anilk6385@gmail.com','','10601','N','XY5fa541407d2b71604665664.jpg','XY','Y','0000-00-00 00:00:00',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
