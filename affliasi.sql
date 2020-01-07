-- MariaDB dump 10.17  Distrib 10.4.10-MariaDB, for osx10.15 (x86_64)
--
-- Host: localhost    Database: affliasi
-- ------------------------------------------------------
-- Server version	10.4.10-MariaDB

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
-- Table structure for table `banks`
--

DROP TABLE IF EXISTS `banks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banks` (
  `id_banks` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) unsigned DEFAULT NULL,
  `bank` varchar(45) NOT NULL,
  `bank_rekening` bigint(20) NOT NULL,
  `bank_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_banks`),
  UNIQUE KEY `id_banks_UNIQUE` (`id_banks`),
  KEY `fq_banks_refer_idx` (`id_user`),
  CONSTRAINT `fq_banks_refer` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banks`
--

LOCK TABLES `banks` WRITE;
/*!40000 ALTER TABLE `banks` DISABLE KEYS */;
INSERT INTO `banks` VALUES (1,2,'BCA',48376584736,'Martua Nasution','2019-12-09 17:06:42'),(2,3,'BNI',454354654,'Firaz','2019-12-09 17:06:42'),(3,NULL,'BRI',56575673232,'Buyung','2019-12-09 17:06:42');
/*!40000 ALTER TABLE `banks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `blogger_view_summary`
--

DROP TABLE IF EXISTS `blogger_view_summary`;
/*!50001 DROP VIEW IF EXISTS `blogger_view_summary`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `blogger_view_summary` (
  `id_user` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `url_blog` tinyint NOT NULL,
  `status` tinyint NOT NULL,
  `total_pendapatan` tinyint NOT NULL,
  `total_klik` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blogs` (
  `id_blog` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) unsigned DEFAULT NULL,
  `url_blog` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_blog`),
  UNIQUE KEY `id_blog_UNIQUE` (`id_blog`),
  UNIQUE KEY `url_UNIQUE` (`url_blog`),
  KEY `fk_id_user_blogs_idx` (`id_user`),
  CONSTRAINT `fk_id_user_blogs` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blogs`
--

LOCK TABLES `blogs` WRITE;
/*!40000 ALTER TABLE `blogs` DISABLE KEYS */;
INSERT INTO `blogs` VALUES (1,1,'https:://google.com','2019-12-09 16:36:54'),(2,2,'https:://facebook.com','2019-12-09 16:36:54'),(3,3,'https:://twitter.com','2019-12-09 16:36:54'),(4,NULL,'https:://yahoo.com','2019-12-09 16:36:54'),(5,5,'https:://kompas.com','2019-12-09 16:36:54'),(6,1,'https:://blibli.com','2019-12-09 16:36:54'),(7,9,'https://devnas.com','2020-01-06 19:36:26');
/*!40000 ALTER TABLE `blogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `campaigns`
--

DROP TABLE IF EXISTS `campaigns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `campaigns` (
  `id_campaign` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `campaign_name` varchar(255) NOT NULL,
  `landing_page` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_campaign`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `campaigns`
--

LOCK TABLES `campaigns` WRITE;
/*!40000 ALTER TABLE `campaigns` DISABLE KEYS */;
INSERT INTO `campaigns` VALUES (1,'Harbolnas','https://moladin.com/harbolnas','https://s3-ap-southeast-1.amazonaws.com/moladin.assets/blog/wp-content/uploads/2018/12/07170507/800x445_Harbolnas12.12Blog.jpg',1,1,'2019-12-09 17:41:36','2020-01-03 04:06:47'),(3,'Test Campaign 2','https://www.google.com/','https://affliasi.test/storage/campaign/2020-07/5LJ6AW0kmap5p9mSiabAgzXQUnxLokVRfAnRHxfW.png',1,1,'2020-01-07 10:26:32','2020-01-07 10:27:23'),(4,'Test Campaign 3','https://dev.to/nikola/making-ajax-calls-in-pure-javascript-the-old-way-ed5','https://affliasi.test/storage/campaign/2020-07/oScFYRi4V1R1blGgKvWyw4uu9AVdV1Yynrmq3Uct.png',1,1,'2020-01-07 10:26:45','2020-01-07 10:26:45');
/*!40000 ALTER TABLE `campaigns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `penarikans`
--

DROP TABLE IF EXISTS `penarikans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `penarikans` (
  `id_penarikan` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `saldo` varchar(45) NOT NULL,
  `penarikan` varchar(45) NOT NULL,
  `status` int(11) DEFAULT 2,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_penarikan`),
  KEY `fk_user_id_idx` (`user_id`),
  CONSTRAINT `fk_user_id_penarikan` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `penarikans`
--

LOCK TABLES `penarikans` WRITE;
/*!40000 ALTER TABLE `penarikans` DISABLE KEYS */;
INSERT INTO `penarikans` VALUES (1,1,'10000','10000',0,'2020-01-06 19:15:58');
/*!40000 ALTER TABLE `penarikans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id_role` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_role`),
  UNIQUE KEY `id_role_UNIQUE` (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','2019-12-09 15:53:24'),(2,'affliate','2019-12-09 15:53:24');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id_transaction` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip` varchar(20) NOT NULL,
  `id_campaign` bigint(20) unsigned DEFAULT NULL,
  `total_belanja` int(11) NOT NULL,
  `komisi` int(11) NOT NULL,
  `cookie` varchar(255) NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_transaction`),
  KEY `fk_user_id_idx` (`user_id`),
  KEY `fk_campagin_id_idx` (`id_campaign`),
  CONSTRAINT `fk_campagin_id` FOREIGN KEY (`id_campaign`) REFERENCES `campaigns` (`id_campaign`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,2,'127.0.0.1',1,40000,1000,'active',1,'2019-12-09 17:43:24'),(2,2,'127.0.0.1',1,40000,1000,'active',1,'2019-12-09 17:43:24'),(3,2,'127.0.0.1',1,40000,1000,'active',1,'2019-12-09 17:43:24'),(4,2,'127.0.0.1',1,40000,1000,'active',1,'2019-12-09 17:43:24'),(5,2,'127.0.0.1',1,40000,1000,'active',1,'2019-12-09 17:43:24'),(6,2,'127.0.0.1',1,40000,1000,'active',1,'2019-12-09 17:43:24'),(7,2,'127.0.0.1',1,40000,1000,'active',1,'2019-12-09 17:43:24'),(8,2,'127.0.0.1',1,40000,1000,'active',1,'2019-12-09 17:43:24'),(9,3,'127.0.0.1',1,40000,1000,'active',1,'2019-12-09 17:43:24'),(10,3,'127.0.0.1',1,40000,1000,'active',1,'2019-12-09 17:43:24'),(11,3,'127.0.0.1',1,40000,1000,'active',1,'2019-12-09 17:43:24'),(12,3,'127.0.0.1',1,40000,1000,'active',1,'2019-12-09 17:43:24'),(13,3,'127.0.0.1',1,40000,1000,'active',1,'2019-12-09 17:43:24'),(14,3,'127.0.0.1',1,40000,1000,'active',1,'2019-12-09 17:43:25'),(15,3,'127.0.0.1',1,40000,1000,'active',1,'2019-12-09 17:43:25'),(16,NULL,'127.0.0.1',1,40000,1000,'active',1,'2019-12-09 17:43:25'),(19,1,'127.0.0.1',1,0,0,'active',1,'2020-01-07 18:13:05'),(20,1,'127.0.0.1',1,0,0,'active',1,'2020-01-07 18:13:11'),(21,1,'127.0.0.1',1,0,0,'active',1,'2020-01-07 18:13:15'),(22,1,'127.0.0.1',1,0,0,'active',1,'2020-01-07 18:16:23'),(24,1,'127.0.0.1',1,5000000,500000,'inactive',1,'2020-01-07 19:31:52'),(25,1,'127.0.0.1',1,0,0,'active',1,'2020-01-07 18:20:46');
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id_user` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `id_role` int(10) unsigned DEFAULT 2,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `id_user_UNIQUE` (`id_user`),
  KEY `fk_roles_idx` (`id_role`),
  CONSTRAINT `fk_roles` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Maritho Nasution','082168133319','marithonst@gmail.com','$2y$10$fnxfWV9.ic5kfFYxpB0CFuNARnGOU8cdYg3MrA4iL7iUkaFpsVQ4.',1,1,'2019-11-30 12:21:18','2019-12-09 16:19:03'),(2,'Martua Nasution','082168133318','martuanst@gmail.com','$2y$10$fnxfWV9.ic5kfFYxpB0CFuNARnGOU8cdYg3MrA4iL7iUkaFpsVQ4.',1,2,'2019-11-30 12:34:12','2019-12-09 16:19:03'),(3,'Firaz','082168133355','firaz@gmail.com','$2y$10$fnxfWV9.ic5kfFYxpB0CFuNARnGOU8cdYg3MrA4iL7iUkaFpsVQ4.',1,2,'2019-11-30 12:21:18','2019-12-09 16:19:03'),(5,'Freddy','082168133357','freddy@gmail.com','$2y$10$fnxfWV9.ic5kfFYxpB0CFuNARnGOU8cdYg3MrA4iL7iUkaFpsVQ4.',1,2,'2019-11-30 12:21:18','2019-12-09 16:19:03'),(9,'sdf','092345874365','test@gmail.com','$2y$10$95W1.slgIS3ckguctzNnp.5hrgNtw4xL8CWX4HpOW8ooV2bon.Mi.',1,2,'2020-01-06 12:36:26','2020-01-06 12:36:26');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `blogger_view_summary`
--

/*!50001 DROP TABLE IF EXISTS `blogger_view_summary`*/;
/*!50001 DROP VIEW IF EXISTS `blogger_view_summary`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `blogger_view_summary` AS select `users`.`id_user` AS `id_user`,`users`.`name` AS `name`,`blogs`.`url_blog` AS `url_blog`,`users`.`status` AS `status`,sum(`transactions`.`komisi`) AS `total_pendapatan`,count(`transactions`.`id_transaction`) AS `total_klik` from ((`users` join `transactions`) join `blogs` on(`blogs`.`id_user` = `users`.`id_user`)) where `users`.`id_user` = `transactions`.`id_transaction` and `users`.`id_role` = 2 group by `users`.`id_user` */;
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

-- Dump completed on 2020-01-08  2:44:07
