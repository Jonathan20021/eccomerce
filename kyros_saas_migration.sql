-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: kyros_saas
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `cart_items`
--

DROP TABLE IF EXISTS `cart_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `price` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `store_id` (`store_id`),
  KEY `product_id` (`product_id`),
  KEY `idx_cart_user` (`user_id`),
  CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cart_items_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_items`
--

LOCK TABLES `cart_items` WRITE;
/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
INSERT INTO `cart_items` VALUES (1,3,'u79fkcbr4kpajrbq10c66qh5bk',2,6,1,NULL,'2026-04-09 22:34:34','2026-04-09 22:34:34');
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `idx_category_store` (`store_id`),
  CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE,
  CONSTRAINT `categories_ibfk_2` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,3,'Ropa','ropa-69d83acebc354','',NULL,NULL,1,'2026-04-09 23:48:30','2026-04-09 23:48:30');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `licenses`
--

DROP TABLE IF EXISTS `licenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `licenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `store_id` int(11) DEFAULT NULL,
  `plan_id` int(11) NOT NULL,
  `status` enum('active','expired','suspended','cancelled') DEFAULT 'active',
  `trial_days` int(11) DEFAULT 15,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `starts_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `expires_at` timestamp NULL DEFAULT NULL,
  `is_trial` tinyint(1) DEFAULT 1,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `store_id` (`store_id`),
  CONSTRAINT `licenses_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `licenses`
--

LOCK TABLES `licenses` WRITE;
/*!40000 ALTER TABLE `licenses` DISABLE KEYS */;
INSERT INTO `licenses` VALUES (1,'STARTER-TRIAL-001',NULL,1,'active',15,'2026-04-24 21:28:50','2026-04-09 21:28:50',NULL,1,NULL,'2026-04-09 21:28:50','2026-04-09 21:28:50'),(2,'PRO-TRIAL-001',NULL,2,'active',15,'2026-04-24 21:28:55','2026-04-09 21:28:55',NULL,1,NULL,'2026-04-09 21:28:55','2026-04-09 21:28:55'),(3,'ENT-PAID-001',NULL,3,'active',15,NULL,'2026-04-09 21:28:55','2027-04-09 21:28:55',0,NULL,'2026-04-09 21:28:55','2026-04-09 21:28:55'),(4,'KYROS-EBBEA9665D92-1775773809',2,1,'active',15,'2026-04-25 04:30:09','2026-04-09 22:30:09',NULL,1,'{\"id\":1,\"name\":\"Starter\",\"price\":0,\"products\":50,\"storage\":5,\"features\":[\"basic_storefront\",\"products\",\"orders\"]}','2026-04-09 22:30:09','2026-04-09 22:30:09'),(5,'KYROS-9F273E842DCB-1775775042',3,1,'active',3650,'2036-04-07 04:50:42','2026-04-09 22:50:42',NULL,1,'{\"id\":1,\"name\":\"Starter\",\"price\":0,\"products\":50,\"storage\":5,\"features\":[\"basic_storefront\",\"products\",\"orders\",\"finance_module\",\"inventory_module\"],\"module_inventory\":1,\"module_finance\":1}','2026-04-09 22:50:42','2026-04-10 00:18:07'),(6,'KYROS-0A3BCAF5F0CF-1775775042',4,2,'active',3650,'2036-04-07 04:50:42','2026-04-09 22:50:42',NULL,1,'{\"id\":2,\"name\":\"Professional\",\"price\":99,\"products\":500,\"storage\":50,\"features\":[\"advanced_storefront\",\"analytics\",\"seo\",\"api\"]}','2026-04-09 22:50:42','2026-04-09 22:50:42');
/*!40000 ALTER TABLE `licenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,7,1,49.99,49.99,'2026-04-09 23:53:28'),(2,2,7,1,49.99,49.99,'2026-04-10 00:03:10'),(3,3,7,1,49.99,49.99,'2026-04-10 00:03:53');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `order_number` varchar(50) DEFAULT NULL,
  `status` enum('pending','confirmed','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `total` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT 0.00,
  `shipping_cost` decimal(10,2) DEFAULT 0.00,
  `discount` decimal(10,2) DEFAULT 0.00,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_status` enum('pending','paid','failed') DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_number` (`order_number`),
  KEY `user_id` (`user_id`),
  KEY `idx_order_store` (`store_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,5,3,'ORD-1775778808-3416','pending',49.99,49.99,0.00,0.00,0.00,'Jonathan Sandoval','keegleeshop@gmail.com','809-968-8289','Santiago\r\n16','whatsapp','pending',NULL,'2026-04-09 23:53:28','2026-04-09 23:53:28'),(2,5,3,'ORD-1775779390-3048','pending',49.99,49.99,0.00,0.00,0.00,'Cliente Prueba','cliente.prueba@example.com','8095551234','Calle Principal 123, Santo Domingo','whatsapp','pending',NULL,'2026-04-10 00:03:10','2026-04-10 00:03:10'),(3,5,3,'ORD-1775779433-8676','pending',49.99,49.99,0.00,0.00,0.00,'Cliente Prueba 2','cliente2.prueba@example.com','8095556789','Av. Central 456, Santiago','whatsapp','pending',NULL,'2026-04-10 00:03:53','2026-04-10 00:03:53');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `store_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `cost` decimal(10,2) DEFAULT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `discount_percent` int(11) DEFAULT 0,
  `sku` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `gallery` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery`)),
  `category_id` int(11) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `rating` decimal(3,2) DEFAULT 0.00,
  `reviews_count` int(11) DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(500) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `idx_product_store` (`store_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,1,'Laptop DELL XPS 13','laptop-dell-xps-13','Computadora ultraligera y potente',1299.99,800.00,999.99,0,'SKU001',NULL,NULL,NULL,50,1,4.50,0,NULL,NULL,'2026-04-09 21:29:34','2026-04-09 21:29:34'),(2,1,'iPhone 14 Pro','iphone-14-pro','??ltimo modelo de Apple con c??mara mejorada',999.99,600.00,NULL,0,'SKU002',NULL,NULL,NULL,30,1,4.80,0,NULL,NULL,'2026-04-09 21:29:34','2026-04-09 21:29:34'),(3,1,'Samsung Galaxy A52','samsung-galaxy-a52','Smartphone con pantalla AMOLED',399.99,250.00,349.99,0,'SKU003',NULL,NULL,NULL,40,1,4.30,0,NULL,NULL,'2026-04-09 21:29:34','2026-04-09 21:29:34'),(4,1,'Funda de celular protectora','funda-celular-protectora','Funda resistente de silicona',19.99,5.00,14.99,0,'SKU004',NULL,NULL,NULL,200,1,4.20,0,NULL,NULL,'2026-04-09 21:29:34','2026-04-09 21:29:34'),(5,1,'Cable USB-C de carga r??pida','cable-usb-c','Cable de 2 metros para carga r??pida',24.99,3.00,15.99,0,'SKU005',NULL,NULL,NULL,150,1,4.60,0,NULL,NULL,'2026-04-09 21:29:34','2026-04-09 21:29:34'),(6,2,'Producto QA Global','producto-qa-global-69d829475da8e','Producto creado durante QA end-to-end para validar flujo de tienda.',19.99,0.00,0.00,NULL,'',NULL,NULL,NULL,15,1,0.00,0,NULL,NULL,'2026-04-09 22:33:43','2026-04-09 22:33:43'),(7,3,'Camiseta Demo','camiseta-demo-69d83adbd7cbe','',49.99,0.00,NULL,NULL,'','C:/xampp/htdocs/eccomerce/app/controllers/../../public/uploads/products/1775784641_69d852c1ed42a.jpg',NULL,1,20,1,0.00,0,NULL,NULL,'2026-04-09 23:48:43','2026-04-10 01:30:41'),(8,3,'Producto Imagen Test','producto-imagen-test-69d8522903346','',99.99,0.00,NULL,NULL,'','C:/xampp/htdocs/eccomerce/app/controllers/../../public/uploads/products/1775784489_69d8522903aea.png',NULL,NULL,3,1,0.00,0,NULL,NULL,'2026-04-10 01:28:09','2026-04-10 01:28:09');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `store_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `customer_name` varchar(120) DEFAULT NULL,
  `title` varchar(150) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `reply_comment` text DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `is_approved` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `store_id` (`store_id`),
  KEY `idx_review_product` (`product_id`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`store_id`) REFERENCES `stores` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

ALTER TABLE `reviews` ADD COLUMN IF NOT EXISTS `customer_name` varchar(120) DEFAULT NULL AFTER `rating`;
ALTER TABLE `reviews` ADD COLUMN IF NOT EXISTS `reply_comment` text DEFAULT NULL AFTER `comment`;
ALTER TABLE `reviews` ADD COLUMN IF NOT EXISTS `replied_at` timestamp NULL DEFAULT NULL AFTER `reply_comment`;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) DEFAULT NULL,
  `setting_value` longtext DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'store_2_menu_json','[{\"label\":\"Inicio\",\"url\":\"http:\\/\\/localhost\\/eccomerce\\/shop\\/test-qa-s-store-69d828717e07d\"},{\"label\":\"Contacto\",\"url\":\"https:\\/\\/wa.me\\/573001112233\"}]','json','2026-04-09 22:47:23','2026-04-09 22:47:23'),(2,'store_2_footer_json','{\"text\":\"Footer propio de Test QA Store. Entregas en 24h.\",\"contact_email\":\"store@testqa.com\",\"contact_phone\":\"+57 300 111 2233\",\"terms_url\":\"https:\\/\\/example.com\\/terminos-tienda\",\"privacy_url\":\"https:\\/\\/example.com\\/privacidad-tienda\",\"facebook\":\"\",\"instagram\":\"\",\"tiktok\":\"\"}','json','2026-04-09 22:47:23','2026-04-09 22:47:23'),(3,'platform_demo_accounts_enabled','1','boolean','2026-04-09 22:54:19','2026-04-09 23:02:09'),(4,'platform_demo_passwords_visible','1','boolean','2026-04-09 22:54:19','2026-04-09 23:02:09'),(7,'platform_demo_block_visible','1','boolean','2026-04-09 22:55:31','2026-04-09 23:02:09'),(11,'store_3_menu_json','[]','json','2026-04-09 23:57:29','2026-04-10 00:04:11'),(12,'store_3_footer_json','{\"text\":\"\",\"contact_email\":\"\",\"contact_phone\":\"\",\"terms_url\":\"\",\"privacy_url\":\"\",\"facebook\":\"\",\"instagram\":\"\",\"tiktok\":\"\"}','json','2026-04-09 23:57:29','2026-04-10 00:04:11');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stores`
--

DROP TABLE IF EXISTS `stores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `domain` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `whatsapp_number` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `currency` varchar(3) DEFAULT 'USD',
  `license_id` int(11) DEFAULT NULL,
  `plan_id` int(11) DEFAULT 1,
  `is_active` tinyint(1) DEFAULT 1,
  `verified` tinyint(1) DEFAULT 0,
  `stripe_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `license_id` (`license_id`),
  KEY `idx_store_owner` (`owner_id`),
  CONSTRAINT `stores_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `stores_ibfk_2` FOREIGN KEY (`license_id`) REFERENCES `licenses` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stores`
--

LOCK TABLES `stores` WRITE;
/*!40000 ALTER TABLE `stores` DISABLE KEYS */;
INSERT INTO `stores` VALUES (1,2,'Tienda Demo Kyros','tienda-demo-kyros','Tienda de demostraci┬¥n de Kyros',NULL,NULL,NULL,'+57 300 123 4567','573001234567','info@tienda-demo.com',NULL,'Bogot├ƒ',NULL,'Colombia',NULL,'USD',1,1,1,1,NULL,'2026-04-09 21:29:03','2026-04-09 21:29:03'),(2,3,'Test QA&#039;s Store','test-qa-s-store-69d828717e07d','',NULL,NULL,NULL,'','','qa.kyroscommerce.20260409@example.com','','','','','','USD',4,1,1,0,NULL,'2026-04-09 22:30:09','2026-04-09 23:11:33'),(3,5,'Demo Starter Store','demo-starter-store-f842c12d','Cuenta demo para pruebas de Kyros Commerce',NULL,NULL,NULL,'8495024061','8495024061','demo.starter@kyros.com','','','','','','USD',5,1,1,0,NULL,'2026-04-09 22:50:42','2026-04-10 00:04:11'),(4,6,'Demo Pro Store','demo-pro-store-7b3ebdba','Cuenta demo para pruebas de Kyros Commerce',NULL,NULL,NULL,'+57 300 000 0003',NULL,'demo.pro@kyros.com',NULL,NULL,NULL,NULL,NULL,'USD',6,2,1,0,NULL,'2026-04-09 22:50:42','2026-04-09 22:50:42');
/*!40000 ALTER TABLE `stores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('superadmin','store_owner','store_staff','customer') DEFAULT 'customer',
  `store_id` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `email_verified` tinyint(1) DEFAULT 0,
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrador','admin@kyros.com','\\.K6B6Xx7M5K3L9X8P7Z6Y5W4V3U2T1S0',NULL,'superadmin',NULL,1,1,NULL,'2026-04-09 21:28:44','2026-04-09 21:28:44'),(2,'Juan P├Ürez','juan@example.com','\\.K6B6Xx7M5K3L9X8P7Z6Y5W4V3U2T1S0','+57 300 123 4567','store_owner',NULL,1,1,NULL,'2026-04-09 21:29:03','2026-04-09 21:29:03'),(3,'Test QA','qa.kyroscommerce.20260409@example.com','$2y$10$zrqZpGXDqYWuzEXtnF5vL.t9qz9SVzUwSySk82CAeeBbsWxAvky7.','','store_owner',2,1,0,NULL,'2026-04-09 22:30:09','2026-04-09 22:30:09'),(4,'Demo SuperAdmin','demo.admin@kyros.com','$2y$10$kDaMl7TpGTBqfJX.LA3YDeGW.U3y1OvR3FG.qknyWIX7PCFX2jh1C','+57 300 000 0001','superadmin',NULL,1,1,NULL,'2026-04-09 22:50:42','2026-04-09 22:50:42'),(5,'Demo Tienda Starter','demo.starter@kyros.com','$2y$10$ZSn.vxtbkM1f.NHYeGFiLOFfGSQqOICCc/B5YbfZJ7U02t9lUcOdK','+57 300 000 0002','store_owner',3,1,1,NULL,'2026-04-09 22:50:42','2026-04-09 22:50:42'),(6,'Demo Tienda Pro','demo.pro@kyros.com','$2y$10$IgIfGhBN.K5ImS.JIuQbGeSCxSJyuy3EZoC1DGaX8A7czxhruT.rS','+57 300 000 0003','store_owner',4,1,1,NULL,'2026-04-09 22:50:42','2026-04-09 22:50:42');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'kyros_saas'
--

--
-- Dumping routines for database 'kyros_saas'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-09 21:47:11
