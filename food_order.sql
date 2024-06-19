-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 19, 2024 at 05:07 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_order`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_address`
--

CREATE TABLE `tbl_address` (
  `id` int(11) UNSIGNED NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` int(10) DEFAULT NULL,
  `city` varchar(32) NOT NULL DEFAULT '',
  `state` varchar(32) NOT NULL DEFAULT '',
  `country` varchar(32) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_address`
--

INSERT INTO `tbl_address` (`id`, `address`, `postal_code`, `city`, `state`, `country`) VALUES
(1, '214-D, Kampung Tiga, Taman Kerampus 3/11', 75300, 'Melaka', 'Melaka', 'Malaysia'),
(2, '92, Floor 3, Taman Hancur Lantai', 75350, 'Melaka', 'Melaka', 'Malaysia'),
(3, '21a, Taman Mentos Jaya, Jalan Pure Fresh 5/6', 75150, 'Melaka', 'Melaka', 'Malaysia'),
(4, '779-C, Taman Comel Laksamana, Jalan Simpang 5', 75650, 'Melaka', 'Melaka', 'Malaysia');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `IC` varchar(20) NOT NULL,
  `ph_no` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address_id` int(10) UNSIGNED DEFAULT NULL,
  `position` enum('Admin','Superadmin') NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `full_name`, `username`, `password`, `image_name`, `IC`, `ph_no`, `email`, `address_id`, `position`, `status`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'Lom Yuen', 'Erzonth', 'Word2086', 'MMU ID PIC.v5(16).jpg', '041122-12-1112', '011-16896678', 'lomyuen@gmail.com', 1, 'Superadmin', 'Active', NULL, NULL),
(2, 'King', 'King', 'Word2086', 'KING(2).jpg', '011214-04-2114', '016-5186917', 'king@gmail.com', 2, 'Superadmin', 'Active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart_items`
--

CREATE TABLE `tbl_cart_items` (
  `id` int(11) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED DEFAULT NULL,
  `food_id` int(10) UNSIGNED DEFAULT NULL,
  `variation` varchar(20) DEFAULT NULL,
  `quantity` int(10) DEFAULT 0,
  `size` enum('Normal','Large') DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `active` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `title`, `active`) VALUES
(1, 'Noodles', 'Yes'),
(2, 'Add-Ons', 'Yes'),
(3, 'Small Meals', 'Yes'),
(4, 'Drinks', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_checkout_verification`
--

CREATE TABLE `tbl_checkout_verification` (
  `id` int(10) NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `verification_code` int(20) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_checkout_verification`
--

INSERT INTO `tbl_checkout_verification` (`id`, `customer_id`, `verification_code`, `timestamp`) VALUES
(9, 2, 602263, '2024-06-18 08:18:27'),
(12, 1, 583264, '2024-06-19 03:41:46'),
(22, 10, 615394, '2024-06-19 14:47:38');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_us`
--

CREATE TABLE `tbl_contact_us` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` enum('Yes','No') NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `id` int(11) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `ph_no` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `status` enum('Active','Inactive') NOT NULL DEFAULT 'Active',
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`id`, `full_name`, `username`, `password`, `image_name`, `ph_no`, `email`, `status`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'Suguru Geto', 'Geto', 'Geto1223', 'Geto.jpg', '012-2144617', 'lomyuen20@gmail.com', 'Active', NULL, NULL),
(2, 'Satoru Gojo', 'Satoru Gojo', 'Gojo1223', '', '012-31942812', 'gojo@gmail.com', 'Active', NULL, NULL),
(10, 'Mel Afra koshta', 'Melafra Koshta', 'Koshta1223', '', '011-21957294', 'koshta@gmail.com', 'Active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_address`
--

CREATE TABLE `tbl_customer_address` (
  `id` int(11) UNSIGNED NOT NULL,
  `address` varchar(255) NOT NULL,
  `postal_code` int(10) DEFAULT NULL,
  `city` varchar(32) NOT NULL DEFAULT '',
  `state` varchar(32) NOT NULL DEFAULT '',
  `country` varchar(32) NOT NULL DEFAULT '',
  `customer_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer_address`
--

INSERT INTO `tbl_customer_address` (`id`, `address`, `postal_code`, `city`, `state`, `country`, `customer_id`, `name`, `phone`) VALUES
(1, '714-C, Taman Terror, Jalan Zus 3/11', 75300, 'Melaka', 'Melaka', 'Malaysia', 1, 'Lom Yuen', '012-2144617');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer_paymethod`
--

CREATE TABLE `tbl_customer_paymethod` (
  `id` int(11) UNSIGNED NOT NULL,
  `cardname` varchar(100) NOT NULL,
  `cardnumber` varchar(20) NOT NULL,
  `expmonth` varchar(20) NOT NULL,
  `expyear` varchar(20) NOT NULL,
  `cvv` varchar(20) NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customer_paymethod`
--

INSERT INTO `tbl_customer_paymethod` (`id`, `cardname`, `cardnumber`, `expmonth`, `expyear`, `cvv`, `customer_id`) VALUES
(1, 'Lom Yuen', '1234 2134 5142 7119', 'January', '2028', '637', 1),
(2, '', '', '', '', '', 1),
(3, 'Satoru Gojo', '9091 3979 8333 1212', '373', '2028', '712', 2),
(4, '', '', '', '', '', 2),
(5, '', '', '', '', '', 10);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_driver`
--

CREATE TABLE `tbl_driver` (
  `id` int(11) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `IC` varchar(20) NOT NULL,
  `ph_no` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address_id` int(10) UNSIGNED NOT NULL,
  `position` enum('Driver') NOT NULL,
  `status` enum('Active','Inactive') NOT NULL,
  `license_classification` varchar(100) NOT NULL,
  `license_exp_date` date NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_driver`
--

INSERT INTO `tbl_driver` (`id`, `full_name`, `username`, `password`, `image_name`, `IC`, `ph_no`, `email`, `address_id`, `position`, `status`, `license_classification`, `license_exp_date`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'John Doe', 'Johnny', 'Johnny1223', 'BOII.png', '123412-43-1234', '012-6731333', 'johnny@gmail.com', 3, 'Driver', 'Active', 'CDL', '2026-10-24', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_food`
--

CREATE TABLE `tbl_food` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `quantity` int(10) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `active` enum('Yes','No') NOT NULL,
  `normal_price` decimal(10,2) NOT NULL,
  `large_price` decimal(10,2) NOT NULL,
  `normal_active` enum('Yes','No') NOT NULL,
  `large_active` enum('Yes','No') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_food`
--

INSERT INTO `tbl_food` (`id`, `title`, `description`, `image_name`, `quantity`, `category_id`, `active`, `normal_price`, `large_price`, `normal_active`, `large_active`) VALUES
(1, 'Minced Pork Emperor Noodles', 'Enjoy the minced pork with Emperor Noodles, served dry or in soup. Mix it up with your favorite add-ons for a meal you\'ll love!', 'Minced Pork Emperor Noodles.png', 94, 1, 'Yes', 3.50, 5.00, 'Yes', 'Yes'),
(2, 'Minced Pork Mee Noodles', 'Enjoy the minced pork with Mee Noodles, served dry or in soup. Mix it up with your favorite add-ons for a meal you\'ll love!', 'Minced Pork Mee Noodles.png', 97, 1, 'Yes', 3.50, 5.00, 'Yes', 'Yes'),
(3, 'Minced Pork Kuay Teow', 'Enjoy the minced pork with Kuay Teow, served dry or in soup. Mix it up with your favorite add-ons for a meal you\'ll love!', 'Minced Pork Kuay Teow.png', 100, 1, 'Yes', 3.50, 5.00, 'Yes', 'Yes'),
(4, 'Minced Pork Bee Hoon', 'Enjoy the minced pork with Bee Hoon, served dry or in soup. Mix it up with your favorite add-ons for a meal you\'ll love!', 'Minced Pork Bee Hoon Mee.png', 100, 1, 'Yes', 3.50, 5.00, 'Yes', 'Yes'),
(5, 'Minced Pork Kuay Teow Mee', 'Enjoy the minced pork with Kuay Teow Mee, served dry or in soup. Mix it up with your favorite add-ons for a meal you\'ll love!', 'Minced Pork Bee Hoon Mee(2).png', 100, 1, 'Yes', 3.50, 5.00, 'Yes', 'Yes'),
(6, 'Minced Pork Bee Hoon Mee', 'Enjoy the minced pork with Bee Hoon Mee, served dry or in soup. Mix it up with your favorite add-ons for a meal you\'ll love!', 'Minced Pork Bee Hoon Mee(1).png', 100, 1, 'Yes', 3.50, 5.00, 'Yes', 'Yes'),
(7, 'Minced Pork Kuay Teow Bee Hoon', 'Enjoy the minced pork with Kuay Teow Bee Hoon, served dry or in soup. Mix it up with your favorite add-ons for a meal you\'ll love!', 'Minced Pork Kuay Teow Bee Hoon.png', 100, 1, 'Yes', 3.50, 5.00, 'Yes', 'Yes'),
(8, 'Fried Dumpling', 'Fried dumplings are golden-brown parcels filled with a savory mixture of minced meat,  encased in a crispy dough shell.', 'Fried Dumpling.png', 97, 2, 'Yes', 1.20, 0.00, 'Yes', 'No'),
(9, 'Wu Xiang Fish Meat & Bean', 'Wu Xiang Fish Meat & Bean is a dish featuring tender fish meat and beans stir-fried with aromatic spices and seasonings.', 'Wu Xiang Fish Meat and Bean.png', 99, 2, 'Yes', 1.20, 0.00, 'Yes', 'No'),
(10, 'Wu Xiang Fish Meat & Pork', 'Wu Xiang Fish Meat & Pork typically refers to a dish where fish meat and pork are combined and stir-fried together with a variety of spices and seasonings.', 'Wu Xiang Fish Meat & Pork.png', 100, 2, 'Yes', 1.20, 0.00, 'Yes', 'No'),
(11, 'Fried Bean Curd', 'Fried bean curd is a dish where slices of tofu are deep-fried until golden brown and crispy on the outside, while remaining soft and creamy inside.', 'Fried Bean Curd.png', 100, 2, 'Yes', 1.20, 0.00, 'Yes', 'No'),
(12, 'Handmade Meat Ball', 'Handmade Meat Balls are savory spheres of ground meat, traditionally seasoned and shaped by hand. ', 'Handmade Meat Ball.png', 100, 2, 'Yes', 1.20, 0.00, 'Yes', 'No'),
(13, 'Handmade Fish Ball', 'Handmade Fish Balls are delicately crafted spheres of fish paste, meticulously shaped by hand. These fish balls bring a delightful taste of the sea to any dish.', 'Handmade Fish Ball.png', 100, 2, 'Yes', 1.20, 0.00, 'Yes', 'No'),
(14, 'White Fish Ball', 'White Fish Balls are a delicate seafood delicacy made from finely ground fish meat, shaped into round balls.', '', 100, 2, 'Yes', 1.20, 0.00, 'Yes', 'No'),
(15, 'Hainan White Tau Kua', 'Hainan White Tau Kua is a dish consisting of tofu that has been sliced and marinated in a distinctive blend of seasonings.', 'Hainan White Tau Kua.png', 100, 2, 'Yes', 1.40, 0.00, 'Yes', 'No'),
(16, 'Hainan Fried Tau Kua', 'Hainan White Tau Kua is a dish consisting of fried tofu that has been sliced and marinated in a distinctive blend of seasonings.', 'Hainan Fried Tau Kua.png', 100, 2, 'Yes', 1.40, 0.00, 'Yes', 'No'),
(17, 'Tofu', 'Tofu is a dish made by coagulating soy milk and pressing the resulting curds into blocks. It has a mild flavor and a firm yet silky texture.', 'Tofu.png', 100, 2, 'Yes', 1.40, 0.00, 'Yes', 'No'),
(18, 'Bitter Melon', 'Bitter melon, also known as bitter gourd or karela, is a green, warty vegetable with a distinctively bitter taste. ', 'Bitter Melon.png', 100, 2, 'Yes', 1.40, 0.00, 'Yes', 'No'),
(19, 'Lady Finger', 'Lady finger is a slender green vegetable with a slightly fuzzy texture. It is prized for its mild flavor and unique mucilaginous (slimy) texture when cooked.', 'Lady Finger.png', 100, 2, 'Yes', 1.40, 0.00, 'Yes', 'No'),
(20, 'Eggplant', 'Eggplant is a vegetable with a smooth, glossy skin ranging in color from deep purple to white or green. It has a mild, slightly earthy flavor and a meaty texture.', 'Eggplant.png', 100, 2, 'Yes', 1.40, 0.00, 'Yes', 'No'),
(21, 'Fish Paste', 'Fish paste is a dish made by combining fish meat, often from freshwater or saltwater fish, with salt and sometimes other ingredients like starch or seasoning.', 'Fish Paste.png', 100, 2, 'Yes', 1.50, 0.00, 'Yes', 'No'),
(22, 'Chilis', 'Chilis is a vegetable, often prized for their ability to enhance dishes with their spicy kick and contribute to the complexity of flavors.', 'Chili.png', 100, 2, 'Yes', 1.50, 0.00, 'Yes', 'No'),
(23, 'Steamed Tofu Delight', 'A dish using boiled Tofu with minced Pork and scallion oil. It is a comforting and flavorful dish that combines delicate tofu cubes, savory minced pork, and aromatic scallion oil.', 'Steamed Tofu Delight.png', 100, 2, 'Yes', 5.00, 0.00, 'Yes', 'No'),
(24, 'Fried Tofu Delight', 'A dish using fried Tofu with minced Pork and scallion oil. It is a comforting and flavorful dish that combines delicate tofu cubes, savory minced pork, and aromatic scallion oil.', 'Fried Tofu Delight.png', 100, 2, 'Yes', 5.00, 0.00, 'Yes', 'No'),
(25, 'Xiax Cai', 'Xian Cai, also known as \"preserved mustard greens\" or \"salted vegetables,\" is a traditional Chinese ingredient made from leafy greens preserved with salt.', 'Xian Cai.png', 100, 2, 'Yes', 3.00, 0.00, 'Yes', 'No'),
(26, 'Kopi', 'Kopi is known for its robust flavor that often involve brewing with ground coffee beans, condensed milk or sugar.', 'Kopi.jpg', 100, 4, 'Yes', 1.80, 2.20, 'Yes', 'Yes'),
(27, 'Kopi \'O', 'Kopi \'O is known for its robust flavor that often involve brewing with ground coffee beans except with no milk or sugar included.', 'Kopi O.jpg', 100, 4, 'Yes', 1.60, 2.00, 'Yes', 'Yes'),
(28, 'Milo', 'Milo is known for its distinctive sweet and chocolatey flavor, served hot or cold. ', 'Milo.png', 100, 4, 'Yes', 2.40, 2.80, 'Yes', 'Yes'),
(29, 'Milo \'O', 'Milo \'O is known for its distinctive sweet and chocolatey flavor without milk or sugar, served hot or cold. ', 'Milo(1).png', 100, 4, 'Yes', 2.20, 2.60, 'Yes', 'Yes'),
(30, 'Nescafe', 'Nescafe is made from high-quality coffee beans that are roasted, ground, and then brewed to create a concentrated coffee extract.', 'Nescafe.png', 100, 4, 'Yes', 2.40, 2.80, 'Yes', 'Yes'),
(31, 'Nescafe \'O', 'Nescafe \'O is served without milk, made from high-quality coffee beans that are roasted, ground, and then brewed to create a concentrated coffee extract.', 'Nescafe(1).png', 100, 4, 'Yes', 2.20, 2.60, 'Yes', 'Yes'),
(32, 'Half Boiled Egg', 'An egg that has been partially cooked, where the white is just set, while the yolk remains partially liquid and runny.', 'Half-boiled-egg.png', 100, 3, 'Yes', 3.00, 0.00, 'Yes', 'No'),
(33, 'Kaya Butter Bread', 'Kaya butter bread is known for its creaminess of the butter, the sweet aromatic notes of the kaya inside the crispy bread.', 'kaya-butter.png', 100, 3, 'Yes', 3.00, 0.00, 'Yes', 'No'),
(34, '100 Plus', '100 Plus, served in warm or cold.', '100 PLUS.jpeg', 100, 4, 'Yes', 2.50, 0.00, 'Yes', 'No'),
(36, 'Cocacola', 'Cocacola, served in warm or cold.', 'Coca Cola.png', 100, 4, 'Yes', 2.50, 0.00, 'Yes', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_food_variation`
--

CREATE TABLE `tbl_food_variation` (
  `id` int(11) UNSIGNED NOT NULL,
  `food_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `active` enum('Yes','No') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_food_variation`
--

INSERT INTO `tbl_food_variation` (`id`, `food_id`, `name`, `active`) VALUES
(1, 1, 'Dry', 'Yes'),
(2, 1, 'Soup', 'Yes'),
(3, 2, 'Dry', 'Yes'),
(4, 2, 'Soup', 'Yes'),
(5, 3, 'Dry', 'Yes'),
(6, 3, 'Soup', 'Yes'),
(7, 4, 'Dry', 'Yes'),
(8, 4, 'Soup', 'Yes'),
(9, 5, 'Dry', 'Yes'),
(10, 5, 'Soup', 'Yes'),
(11, 6, 'Dry', 'Yes'),
(12, 6, 'Soup', 'Yes'),
(13, 7, 'Dry', 'Yes'),
(14, 7, 'Soup', 'Yes'),
(15, 8, 'Fried', 'Yes'),
(16, 9, 'Fried', 'Yes'),
(18, 10, 'Fried', 'Yes'),
(20, 11, 'Fried', 'Yes'),
(21, 12, 'Fried', 'Yes'),
(23, 13, 'Fried', 'Yes'),
(25, 9, 'Boiled', 'Yes'),
(26, 13, 'Boiled', 'Yes'),
(27, 12, 'Boiled', 'Yes'),
(28, 10, 'Boiled', 'Yes'),
(29, 14, 'Fried', 'Yes'),
(30, 14, 'Boiled', 'Yes'),
(31, 15, 'Boiled', 'Yes'),
(32, 16, 'Fried', 'Yes'),
(33, 17, 'Fried', 'Yes'),
(34, 17, 'Boiled', 'Yes'),
(35, 18, 'Fried', 'Yes'),
(36, 18, 'Boiled', 'Yes'),
(37, 19, 'Fried', 'Yes'),
(38, 19, 'Boiled', 'Yes'),
(39, 20, 'Fried', 'Yes'),
(40, 20, 'Boiled', 'Yes'),
(41, 21, 'Fried', 'Yes'),
(42, 21, 'Boiled', 'Yes'),
(43, 22, 'Fried', 'Yes'),
(44, 22, 'Boiled', 'Yes'),
(45, 23, 'Boiled', 'Yes'),
(46, 24, 'Fried', 'Yes'),
(47, 25, 'Boiled', 'Yes'),
(48, 26, 'Hot', 'Yes'),
(49, 26, 'Cold', 'Yes'),
(50, 27, 'Hot', 'Yes'),
(51, 27, 'Cold', 'Yes'),
(52, 28, 'Hot', 'Yes'),
(53, 28, 'Cold', 'Yes'),
(54, 29, 'Hot', 'Yes'),
(55, 29, 'Cold', 'Yes'),
(56, 30, 'Hot', 'Yes'),
(57, 30, 'Cold', 'Yes'),
(58, 31, 'Hot', 'Yes'),
(59, 31, 'Cold', 'Yes'),
(60, 34, 'Hot', 'Yes'),
(61, 34, 'Cold', 'Yes'),
(62, 36, 'Hot', 'Yes'),
(63, 36, 'Cold', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_license_type`
--

CREATE TABLE `tbl_license_type` (
  `id` int(11) UNSIGNED NOT NULL,
  `driver_id` int(11) UNSIGNED NOT NULL,
  `license_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_license_type`
--

INSERT INTO `tbl_license_type` (`id`, `driver_id`, `license_type`) VALUES
(5, 1, 'D'),
(6, 1, 'DA');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_limit`
--

CREATE TABLE `tbl_limit` (
  `id` int(11) UNSIGNED NOT NULL,
  `day` varchar(10) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `minimum_cart_price` decimal(10,2) NOT NULL,
  `delivery_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_limit`
--

INSERT INTO `tbl_limit` (`id`, `day`, `start_time`, `end_time`, `minimum_cart_price`, `delivery_price`) VALUES
(1, 'Monday', '06:15:00', '14:00:00', 15.00, 5.00),
(2, 'Tuesday', '06:15:00', '14:00:00', 15.00, 5.00),
(3, 'Wednesday', '06:15:00', '23:00:00', 15.00, 5.00),
(4, 'Thursday', '06:15:00', '14:00:00', 15.00, 5.00),
(5, 'Friday', '06:15:00', '14:00:00', 15.00, 5.00),
(6, 'Saturday', '06:15:00', '14:00:00', 15.00, 5.00),
(7, 'Sunday', '06:15:00', '14:00:00', 15.00, 5.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id` int(11) UNSIGNED NOT NULL,
  `order_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `delivery_time` timestamp NULL DEFAULT NULL,
  `order_status` enum('pending','preparing','out-for-delivery','delivered','cancelled','on-hold') DEFAULT NULL,
  `customer_id` int(11) UNSIGNED DEFAULT NULL,
  `address_id` int(11) UNSIGNED DEFAULT NULL,
  `pay_id` int(11) UNSIGNED NOT NULL,
  `paymethod` enum('CreditCard','COD') NOT NULL,
  `special_instructions` varchar(255) DEFAULT NULL,
  `last_edited_at` datetime DEFAULT NULL,
  `delivery_fee` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`id`, `order_time`, `delivery_time`, `order_status`, `customer_id`, `address_id`, `pay_id`, `paymethod`, `special_instructions`, `last_edited_at`, `delivery_fee`) VALUES
(8, '2024-06-19 14:39:47', NULL, 'pending', 10, 6, 5, 'CreditCard', 'Hello, wassup', '2024-06-19 23:00:59', 5.00),
(9, '2024-06-19 14:47:38', NULL, 'pending', 10, 7, 5, 'CreditCard', 'dwawd', '2024-06-19 23:01:02', 5.00);

--
-- Triggers `tbl_order`
--
DELIMITER $$
CREATE TRIGGER `update_delivery_time` BEFORE UPDATE ON `tbl_order` FOR EACH ROW BEGIN
   IF NEW.order_status = 'completed' AND OLD.order_status != 'completed' THEN
      SET NEW.delivery_time = NOW();
   END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_last_edited_at` BEFORE UPDATE ON `tbl_order` FOR EACH ROW BEGIN
   SET NEW.last_edited_at = NOW();
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_address`
--

CREATE TABLE `tbl_order_address` (
  `id` int(11) UNSIGNED NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_order_address`
--

INSERT INTO `tbl_order_address` (`id`, `firstname`, `email`, `address`, `city`, `state`, `zip`, `customer_id`, `phone`) VALUES
(1, 'Lom Yuen', 'lomyuen@gmail.com', '714-C, Taman terror, Jalan Zus 3/11', 'Melaka', 'Melaka', '75300', 1, '012-2144617'),
(4, 'Satoru Gojo', 'gojo@gmail.com', '61230 Myra Corner', 'Bristol', 'Melaka', '75250', 2, '012-31942812'),
(5, 'Koshta', 'koshta@gmail.com', '123, Northern temple of the east', 'Taman Perdana Menteri Sabah Sultan', 'Melaka', '75200', 10, '011-1231234'),
(6, 'User Test', '2111212@gmail.com', '41242', '124142', 'Melaka', '75250', 10, '01116896678'),
(7, 'User Test', '1211208979@student.mmu.edu.my', '21a, Taman Mentos Jaya, Jalan Pure Fresh 5/6', 'Taman Perdana Menteri Sabah Sultan', 'Melaka', '75250', 10, '01116896678');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_items`
--

CREATE TABLE `tbl_order_items` (
  `id` int(11) UNSIGNED NOT NULL,
  `order_id` int(10) UNSIGNED DEFAULT NULL,
  `food_id` int(10) UNSIGNED DEFAULT NULL,
  `variation_id` int(10) UNSIGNED DEFAULT NULL,
  `quantity` int(10) DEFAULT 0,
  `size` enum('Regular','Large') DEFAULT NULL,
  `price` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_order_items`
--

INSERT INTO `tbl_order_items` (`id`, `order_id`, `food_id`, `variation_id`, `quantity`, `size`, `price`) VALUES
(16, 8, 1, 1, 3, '', 3.50),
(17, 8, 8, 15, 3, '', 1.20),
(18, 8, 9, 25, 1, '', 1.20),
(19, 9, 1, 1, 3, '', 3.50),
(20, 9, 2, 3, 3, '', 3.50);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_store_variation`
--

CREATE TABLE `tbl_store_variation` (
  `id` int(11) UNSIGNED NOT NULL,
  `category_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_store_variation`
--

INSERT INTO `tbl_store_variation` (`id`, `category_id`, `name`) VALUES
(1, 1, 'Dry'),
(2, 1, 'Soup'),
(3, 2, 'Fried'),
(5, 4, 'Hot'),
(6, 4, 'Cold'),
(9, 2, 'Boiled');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_worker`
--

CREATE TABLE `tbl_worker` (
  `id` int(11) UNSIGNED NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `IC` varchar(20) NOT NULL,
  `ph_no` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address_id` int(10) UNSIGNED NOT NULL,
  `position` enum('Worker') NOT NULL,
  `status` enum('Active','Inactive') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_worker`
--

INSERT INTO `tbl_worker` (`id`, `full_name`, `image_name`, `IC`, `ph_no`, `email`, `address_id`, `position`, `status`) VALUES
(1, 'Merlock Shift', 'Anime Boii.png', '524321-14-6245', '011-41448365', 'merlock@gmail.com', 4, 'Worker', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_address`
--
ALTER TABLE `tbl_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  ADD KEY `FK_admin_address` (`address_id`);

--
-- Indexes for table `tbl_cart_items`
--
ALTER TABLE `tbl_cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_cart_items_customer` (`customer_id`) USING BTREE,
  ADD KEY `FK_cart_items_food` (`food_id`) USING BTREE;

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_checkout_verification`
--
ALTER TABLE `tbl_checkout_verification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_checkout_verify_customer` (`customer_id`);

--
-- Indexes for table `tbl_contact_us`
--
ALTER TABLE `tbl_contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`);

--
-- Indexes for table `tbl_customer_address`
--
ALTER TABLE `tbl_customer_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_customer_address_customer` (`customer_id`) USING BTREE;

--
-- Indexes for table `tbl_customer_paymethod`
--
ALTER TABLE `tbl_customer_paymethod`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_customer_paymethod_customer` (`customer_id`);

--
-- Indexes for table `tbl_driver`
--
ALTER TABLE `tbl_driver`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  ADD KEY `FK_driver_address` (`address_id`);

--
-- Indexes for table `tbl_food`
--
ALTER TABLE `tbl_food`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_food_category` (`category_id`);

--
-- Indexes for table `tbl_food_variation`
--
ALTER TABLE `tbl_food_variation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_food_variation_food` (`food_id`) USING BTREE;

--
-- Indexes for table `tbl_license_type`
--
ALTER TABLE `tbl_license_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_license_driver` (`driver_id`);

--
-- Indexes for table `tbl_limit`
--
ALTER TABLE `tbl_limit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_order_customer` (`customer_id`),
  ADD KEY `FK_order_address` (`address_id`),
  ADD KEY `FK_order_paymethod` (`pay_id`);

--
-- Indexes for table `tbl_order_address`
--
ALTER TABLE `tbl_order_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_order_address_customer` (`customer_id`) USING BTREE;

--
-- Indexes for table `tbl_order_items`
--
ALTER TABLE `tbl_order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_order_items_order` (`order_id`) USING BTREE,
  ADD KEY `FK_order_items_variation` (`variation_id`) USING BTREE,
  ADD KEY `FK_order_items_food` (`food_id`) USING BTREE;

--
-- Indexes for table `tbl_store_variation`
--
ALTER TABLE `tbl_store_variation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_store_variation_category` (`category_id`) USING BTREE;

--
-- Indexes for table `tbl_worker`
--
ALTER TABLE `tbl_worker`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_worker_address` (`address_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_address`
--
ALTER TABLE `tbl_address`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_cart_items`
--
ALTER TABLE `tbl_cart_items`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_checkout_verification`
--
ALTER TABLE `tbl_checkout_verification`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_contact_us`
--
ALTER TABLE `tbl_contact_us`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_customer_address`
--
ALTER TABLE `tbl_customer_address`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_customer_paymethod`
--
ALTER TABLE `tbl_customer_paymethod`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_driver`
--
ALTER TABLE `tbl_driver`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_food`
--
ALTER TABLE `tbl_food`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tbl_food_variation`
--
ALTER TABLE `tbl_food_variation`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `tbl_license_type`
--
ALTER TABLE `tbl_license_type`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_limit`
--
ALTER TABLE `tbl_limit`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_order_address`
--
ALTER TABLE `tbl_order_address`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_order_items`
--
ALTER TABLE `tbl_order_items`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_store_variation`
--
ALTER TABLE `tbl_store_variation`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_worker`
--
ALTER TABLE `tbl_worker`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD CONSTRAINT `FK_admin_address` FOREIGN KEY (`address_id`) REFERENCES `tbl_address` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_cart_items`
--
ALTER TABLE `tbl_cart_items`
  ADD CONSTRAINT `FK_cart_items_customer` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_cart_items_food` FOREIGN KEY (`food_id`) REFERENCES `tbl_food` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_checkout_verification`
--
ALTER TABLE `tbl_checkout_verification`
  ADD CONSTRAINT `FK_checkout_verify_customer` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_customer_address`
--
ALTER TABLE `tbl_customer_address`
  ADD CONSTRAINT `FK_customer_address_customer` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_customer_paymethod`
--
ALTER TABLE `tbl_customer_paymethod`
  ADD CONSTRAINT `FK_customer_paymethod_customer` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_driver`
--
ALTER TABLE `tbl_driver`
  ADD CONSTRAINT `FK_driver_address` FOREIGN KEY (`address_id`) REFERENCES `tbl_address` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_food`
--
ALTER TABLE `tbl_food`
  ADD CONSTRAINT `FK_food_category` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_food_variation`
--
ALTER TABLE `tbl_food_variation`
  ADD CONSTRAINT `FK_foodvariation_food` FOREIGN KEY (`food_id`) REFERENCES `tbl_food` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_license_type`
--
ALTER TABLE `tbl_license_type`
  ADD CONSTRAINT `FK_license_driver` FOREIGN KEY (`driver_id`) REFERENCES `tbl_driver` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `FK_order_address` FOREIGN KEY (`address_id`) REFERENCES `tbl_order_address` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_order_customer` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_order_paymethod` FOREIGN KEY (`pay_id`) REFERENCES `tbl_customer_paymethod` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_order_address`
--
ALTER TABLE `tbl_order_address`
  ADD CONSTRAINT `FK_orderaddress_customer` FOREIGN KEY (`customer_id`) REFERENCES `tbl_customer` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_order_items`
--
ALTER TABLE `tbl_order_items`
  ADD CONSTRAINT `FK_orderitems_food` FOREIGN KEY (`food_id`) REFERENCES `tbl_food` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_orderitems_order` FOREIGN KEY (`order_id`) REFERENCES `tbl_order` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_orderitems_variation` FOREIGN KEY (`variation_id`) REFERENCES `tbl_food_variation` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_store_variation`
--
ALTER TABLE `tbl_store_variation`
  ADD CONSTRAINT `FK_store_variation_category` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_worker`
--
ALTER TABLE `tbl_worker`
  ADD CONSTRAINT `FK_worker_address` FOREIGN KEY (`address_id`) REFERENCES `tbl_address` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
