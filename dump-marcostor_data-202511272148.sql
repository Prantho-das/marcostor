-- MySQL dump 10.13  Distrib 8.4.3, for Win64 (x86_64)
--
-- Host: localhost    Database: marcostor_data
-- ------------------------------------------------------
-- Server version	8.4.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `couriers`
--

DROP TABLE IF EXISTS `couriers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `couriers` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int DEFAULT '0',
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `couriers`
--

LOCK TABLES `couriers` WRITE;
/*!40000 ALTER TABLE `couriers` DISABLE KEYS */;
INSERT INTO `couriers` VALUES (1,'pathao','pathao',1,NULL,NULL,NULL);
/*!40000 ALTER TABLE `couriers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courier_orders`
--

DROP TABLE IF EXISTS `courier_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `courier_orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `courier` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `consignment_id` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'created',
  `request_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `response_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `sent_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `courier_orders_order_id_index` (`order_id`),
  KEY `courier_orders_courier_index` (`courier`),
  KEY `courier_orders_consignment_id_index` (`consignment_id`),
  CONSTRAINT `courier_orders_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `courier_orders_chk_1` CHECK (json_valid(`request_payload`)),
  CONSTRAINT `courier_orders_chk_2` CHECK (json_valid(`response_payload`))
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courier_orders`
--

LOCK TABLES `courier_orders` WRITE;
/*!40000 ALTER TABLE `courier_orders` DISABLE KEYS */;
INSERT INTO `courier_orders` VALUES (4,171,'pathao',NULL,'Pending','{\"store_id\":\"149046\",\"merchant_order_id\":\"ORD1764257303\",\"recipient_name\":\"Prodipto Vhakto\",\"recipient_phone\":\"01745543676\",\"recipient_address\":\"Mirpur-1 , bardhon bari , house : 2\\/8\\/f\",\"delivery_type\":\"48\",\"item_type\":\"2\",\"item_quantity\":\"1\",\"item_weight\":\"0.5\",\"item_description\":null,\"amount_to_collect\":\"0\"}','{\"consignment_id\":\"DT271125WYZSX8\",\"merchant_order_id\":\"ORD1764257303\",\"order_status\":\"Pending\",\"delivery_fee\":60}','2025-11-27 09:45:28',NULL,'2025-11-27 15:45:28','2025-11-27 15:45:28');
/*!40000 ALTER TABLE `courier_orders` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-27 21:48:19
