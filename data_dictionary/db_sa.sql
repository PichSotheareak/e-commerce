/*
 Navicat MySQL Data Transfer

 Source Server         : MYSQL
 Source Server Type    : MySQL
 Source Server Version : 100432 (10.4.32-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : db_sa

 Target Server Type    : MySQL
 Target Server Version : 100432 (10.4.32-MariaDB)
 File Encoding         : 65001

 Date: 14/01/2025 18:48:14
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for branch
-- ----------------------------
DROP TABLE IF EXISTS `branch`;
CREATE TABLE `branch`  (
  `branch_id` int NOT NULL AUTO_INCREMENT,
  `branch_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `branch_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`branch_id`) USING BTREE,
  UNIQUE INDEX `branch_name`(`branch_name` ASC) USING BTREE,
  UNIQUE INDEX `phone`(`phone` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of branch
-- ----------------------------
BEGIN;
INSERT INTO `branch` (`branch_id`, `branch_name`, `branch_address`, `phone`) VALUES (1, 'Phnom Penh Branch', 'No. 101, Street 93, Russian Federation Blvd., Sangkat Teuk Laak I, Khan Toul Kork, Phnom Penh', '012111111'), (2, 'Siem Reap Branch', 'No. 23, Street 63, Sangkat Slor Kram, Siem Reap', '012222222'), (3, 'Battambang Branch', 'No. 56, Street 3, Sangkat Svay Por, Battambang', '012333333'), (4, 'Sihanoukville Branch', 'No. 89, Street 4, Sangkat Mittapheap, Sihanoukville', '012444444'), (5, 'Kampong Cham Branch', 'No. 120, Street 7, Sangkat Veal Vong, Kampong Cham', '012555555');
COMMIT;

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`category_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of category
-- ----------------------------
BEGIN;
INSERT INTO `category` (`category_id`, `category_name`) VALUES (1, 'Gaming Laptops'), (2, 'Business Laptops'), (3, 'Ultrabooks'), (4, 'Student Laptops'), (5, '2-in-1 Laptops');
COMMIT;

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer`  (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tel` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` blob NULL,
  PRIMARY KEY (`customer_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of customer
-- ----------------------------
BEGIN;
INSERT INTO `customer` (`customer_id`, `customer_name`, `tel`, `password`, `address`, `created_at`, `image`) VALUES (1, 'Sok Dara', '012123456', 'dara123', 'No. 12, Street 271, Khan Meanchey, Phnom Penh', '2025-01-14 13:31:53', NULL), (2, 'Chhun Nary', '096654321', 'narysecure', 'No. 23, Street 60, Sangkat Slor Kram, Siem Reap', '2025-01-14 13:31:53', NULL), (3, 'Phan Rithy', '012789012', 'rithypass', 'No. 45, Street 3, Sangkat Svay Por, Battambang', '2025-01-14 13:31:53', NULL), (4, 'Kim Sreyneang', '096345678', 'srey123', 'No. 78, Street 4, Sangkat Mittapheap, Sihanoukville', '2025-01-14 13:31:53', NULL), (5, 'Chea Vanna', '012456789', 'vanna321', 'No. 56, Street 6, Sangkat Veal Vong, Kampong Cham', '2025-01-14 13:31:53', NULL);
COMMIT;

-- ----------------------------
-- Table structure for invoice
-- ----------------------------
DROP TABLE IF EXISTS `invoice`;
CREATE TABLE `invoice`  (
  `invoice_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NULL DEFAULT NULL,
  `invoice_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`invoice_id`) USING BTREE,
  INDEX `order_id`(`order_id` ASC) USING BTREE,
  CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of invoice
-- ----------------------------
BEGIN;
INSERT INTO `invoice` (`invoice_id`, `order_id`, `invoice_date`) VALUES (1, 1, '2025-01-14 13:31:53'), (2, 2, '2025-01-14 13:31:53'), (3, 3, '2025-01-14 13:31:53'), (4, 4, '2025-01-14 13:31:53'), (5, 5, '2025-01-14 13:31:53');
COMMIT;

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order`  (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NULL DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10, 2) NOT NULL,
  PRIMARY KEY (`order_id`) USING BTREE,
  INDEX `customer_id`(`customer_id` ASC) USING BTREE,
  CONSTRAINT `order_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of order
-- ----------------------------
BEGIN;
INSERT INTO `order` (`order_id`, `customer_id`, `order_date`, `total_amount`) VALUES (1, 1, '2025-01-14 13:31:53', 1824.98), (2, 2, '2025-01-14 13:31:53', 1299.99), (3, 3, '2025-01-14 13:31:53', 1999.99), (4, 4, '2025-01-14 13:31:53', 699.99), (5, 5, '2025-01-14 13:31:53', 849.99);
COMMIT;

-- ----------------------------
-- Table structure for order_detail
-- ----------------------------
DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE `order_detail`  (
  `order_detail_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NULL DEFAULT NULL,
  `product_id` int NULL DEFAULT NULL,
  `qty` int NOT NULL,
  `price` decimal(10, 2) NOT NULL,
  PRIMARY KEY (`order_detail_id`) USING BTREE,
  INDEX `order_id`(`order_id` ASC) USING BTREE,
  INDEX `product_id`(`product_id` ASC) USING BTREE,
  CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of order_detail
-- ----------------------------
BEGIN;
INSERT INTO `order_detail` (`order_detail_id`, `order_id`, `product_id`, `qty`, `price`) VALUES (1, 1, 1, 1, 1799.99), (2, 1, 5, 1, 24.99), (3, 2, 3, 1, 1299.99), (4, 3, 2, 1, 1999.99), (5, 4, 4, 1, 699.99), (6, 5, 5, 1, 849.99);
COMMIT;

-- ----------------------------
-- Table structure for payment
-- ----------------------------
DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment`  (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `invoice_id` int NULL DEFAULT NULL,
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(10, 2) NULL DEFAULT NULL,
  `payment_method` enum('Bank Transfer','Pick Up at Branch') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `branch_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`payment_id`) USING BTREE,
  INDEX `invoice_id`(`invoice_id` ASC) USING BTREE,
  INDEX `branch_id`(`branch_id` ASC) USING BTREE,
  CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`invoice_id`) REFERENCES `invoice` (`invoice_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of payment
-- ----------------------------
BEGIN;
INSERT INTO `payment` (`payment_id`, `invoice_id`, `payment_date`, `amount`, `payment_method`, `branch_id`) VALUES (1, 1, '2025-01-14 13:31:53', 1824.98, 'Bank Transfer', 1), (2, 2, '2025-01-14 13:31:53', 1299.99, 'Pick Up at Branch', 2), (3, 3, '2025-01-14 13:31:53', 1999.99, 'Bank Transfer', 3), (4, 4, '2025-01-14 13:31:53', 699.99, 'Pick Up at Branch', 4), (5, 5, '2025-01-14 13:31:53', 849.99, 'Bank Transfer', 5);
COMMIT;

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product`  (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `image` blob NULL,
  `price` decimal(10, 2) NOT NULL,
  `instock` int NULL DEFAULT 0,
  `category_id` int NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `brand` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`product_id`) USING BTREE,
  INDEX `category_id`(`category_id` ASC) USING BTREE,
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of product
-- ----------------------------
BEGIN;
INSERT INTO `product` (`product_id`, `product_name`, `description`, `image`, `price`, `instock`, `category_id`, `created_at`, `brand`) VALUES (1, 'Asus ROG Strix', 'High-performance gaming laptop with NVIDIA RTX 3070', NULL, 1799.99, 15, 1, '2025-01-14 13:31:53', 'Asus'), (2, 'Dell XPS 15', 'Premium business laptop with 4K display', NULL, 1999.99, 10, 2, '2025-01-14 13:31:53', 'Dell'), (3, 'MacBook Air M2', 'Lightweight ultrabook with M2 chip', NULL, 1299.99, 20, 3, '2025-01-14 13:31:53', 'Apple'), (4, 'HP Pavilion 14', 'Affordable laptop for students with AMD Ryzen 5', NULL, 699.99, 25, 4, '2025-01-14 13:31:53', 'HP'), (5, 'Lenovo Yoga 7i', 'Versatile 2-in-1 laptop with touchscreen', NULL, 849.99, 18, 5, '2025-01-14 13:31:53', 'Lenovo'), (6, 'MSI GS66 Stealth', 'High-performance gaming laptop', NULL, 1700.00, 6, 1, '2025-01-14 13:53:44', 'MSI'), (7, 'Apple MacBook Air', 'Thin and lightweight laptop', NULL, 999.00, 8, 1, '2025-01-14 13:53:44', 'Apple'), (8, 'Gigabyte Aero', 'Laptop with high-end graphics', NULL, 1800.00, 4, 1, '2025-01-14 13:53:44', 'Gigabyte');
COMMIT;

-- ----------------------------
-- Table structure for staff
-- ----------------------------
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff`  (
  `staff_id` int NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `image` blob NULL,
  `tel` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `branch_id` int NULL DEFAULT NULL,
  PRIMARY KEY (`staff_id`) USING BTREE,
  INDEX `branch_id`(`branch_id` ASC) USING BTREE,
  CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`branch_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- ----------------------------
-- Records of staff
-- ----------------------------
BEGIN;
INSERT INTO `staff` (`staff_id`, `staff_name`, `image`, `tel`, `password`, `branch_id`) VALUES (2, 'Hem Chenda', NULL, '012222222', 'chenda456', 2), (3, 'Sun Rath', NULL, '096333333', 'rathpass', 3), (4, 'Lim Pisey', NULL, '012444444', 'pisey123', 4), (5, 'Neang Borey', NULL, '096555555', 'boreypass', 5), (6, 'Vong Sokha', NULL, '096111111', 'staff123', 1);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
