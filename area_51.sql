-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 30, 2018 at 04:29 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `area 51`
--
CREATE DATABASE IF NOT EXISTS `area 51` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `area 51`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`, `email`) VALUES
('admin', '$2y$10$jR4a9a14JNKkrqFW2THgHuTDYc2qoTgvd1SinhAJ5qJ2.24leGQOi', 'nchen1181999@gmail.com'),
('sam', '$2y$10$yqtCrM.jZ5IHihZm4X00l.9t07uv/erc2v4NkLBu82sfmNWzbNXQ2', 'shixian0511@hotmail.com'),
('wesly', '$2y$10$Cwuv16aRJMvyKPOVTdiO2uYg4wv4tkg1Cz7KvsPW9FJP.gzZdF8fu', 'wesly_0808@hotmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `cust_name` varchar(100) NOT NULL,
  `prod_id` int(6) UNSIGNED NOT NULL,
  `qty` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cust_name`, `prod_id`, `qty`) VALUES
('customer1', 10012, 10),
('customer1', 10019, 10),
('nicholaschen', 10027, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `cat_key` char(2) NOT NULL,
  `cat_name` varchar(50) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_key`, `cat_name`, `description`) VALUES
('HS', 'Headset', NULL),
('KB', 'Keyboard', NULL),
('LP', 'Laptop', NULL),
('MS', 'Mouse', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` int(6) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ph_number` varchar(12) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT NULL,
  `first_name` varchar(30) DEFAULT NULL,
  `last_name` varchar(30) DEFAULT NULL,
  `address` text,
  `city` varchar(50) DEFAULT NULL,
  `post_code` char(5) DEFAULT NULL,
  `state` char(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `username`, `password`, `email`, `ph_number`, `profile_pic`, `first_name`, `last_name`, `address`, `city`, `post_code`, `state`) VALUES
(3, 'customer1', '$2y$10$3i1/8ZmIsxNc0KEwgZNogeYkneY9dLn4vBLZnyBfXhckGnUHYk1Bi', 'das@gmail.com', NULL, 'profile_picture.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'EXPLOSION', '$2y$10$Ww1uCJ2ilN4mLZadwC7pq.nq5cLqYtTz1vxl4hvCrNiYHjNqy5Elq', 'samcsx0511@gmail.com', NULL, 'profile_picture.jpg', NULL, NULL, NULL, NULL, NULL, NULL),
(1, 'nchen118', '$2y$10$.hQUvpaatwzHe4AsET0E0OxwszcA3v5M0U9bCI8rbvoUg1rscTBh2', 'nchen118@yahoo.com', '013-2881886', '5b86e991ca20d.jpg', 'Chen', 'Yew Seng', '', '', '', 'SL'),
(4, 'nicholaschen', '$2y$10$qp6TkI52VLvGub386weOj.CXl06K7XGmqxpH1qZoZDwLjLQuGN7P.', 'chenys-wm17@student.tarc.edu.my', NULL, 'profile_picture.jpg', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

DROP TABLE IF EXISTS `discount`;
CREATE TABLE `discount` (
  `discount_code` char(6) NOT NULL,
  `rate` int(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`discount_code`, `rate`) VALUES
('RE079Z', 20);

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `id` int(2) UNSIGNED NOT NULL,
  `personal_detail` int(10) UNSIGNED NOT NULL,
  `transaction_id` int(6) UNSIGNED NOT NULL,
  `product_id` int(6) UNSIGNED NOT NULL,
  `delivery_notes` text,
  `delivery_time` time DEFAULT NULL,
  `delivery_day` date DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `quantity` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `personal_detail`, `transaction_id`, `product_id`, `delivery_notes`, `delivery_time`, `delivery_day`, `created`, `quantity`) VALUES
(1, 1, 1, 10032, NULL, NULL, NULL, '2018-08-30 02:40:01', 3),
(2, 1, 1, 10023, NULL, NULL, NULL, '2018-08-30 02:40:01', 1),
(3, 1, 1, 10020, NULL, NULL, NULL, '2018-08-30 02:40:01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `personal_detail`
--

DROP TABLE IF EXISTS `personal_detail`;
CREATE TABLE `personal_detail` (
  `id` int(2) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(30) NOT NULL,
  `post_code` int(5) NOT NULL,
  `state` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `personal_detail`
--

INSERT INTO `personal_detail` (`id`, `email`, `firstname`, `lastname`, `address`, `city`, `post_code`, `state`) VALUES
(1, 'nchen118@yahoo.com', 'Chen', 'Yew Seng', 'NO 78 JALAN KASAWARI 7, BANDAR PUCHONG JA', 'Puchong', 47100, 'SL');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `category` char(2) NOT NULL,
  `date` date NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `photo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `brand`, `category`, `date`, `price`, `photo`) VALUES
(10011, 'S5X KABYLAKE', 'The S5X comes equipped with the latest Intel Core i7-7700HQ processor and Nvidia GeForce GTX1070 8GB Max-Q graphcis in a 18.6mm thin chassis. Weighing no more than 1.9kg, your S5X is the perfect lightweight gaming companion.', 'ILLEGEAR', 'LP', '2016-09-06', '6700.00', '5b8745485506d.png'),
(10012, 'Asus VivoBook S15 S510UN', 'The ASUS VivoBook S15 gives you the perfect combination of beauty and performance. With its slim NanoEdge bezel, brushed-metal finish, the latest IntelÂ® Coreâ„¢ i7 processor with 16GB RAM, and NVIDIAÂ® GeForceÂ® MX150 graphics*, VivoBook S15 is designed', 'ASUS', 'LP', '2016-12-25', '2825.00', '5b8745898fb67.png'),
(10013, 'Dell Inspiron 15 3000 series-3576', 'Inspiron 15 Inch 3000 Laptop with in-demand features and the latest IntelÂ® processors, CinemaStream and CinemaSound.', 'DELL', 'LP', '2016-12-25', '1800.00', '5b8745961eb8e.png'),
(10014, 'Dell G7 15 Gaming Laptop', '15-Inch gaming laptop designed for a powerful, immersive in-game experience featuring NVIDIAÂ® GeForceÂ® GTX 1060 graphics and the latest 8th Gen IntelÂ® Quad-and-Hex Coreâ„¢ CPUs.', 'DELL', 'LP', '2018-02-12', '3769.00', '5b8745a3ec1d9.png'),
(10015, 'MSI-GE73-Raider-RGB-8RE', 'Inspired by exotic sports cars and the RGB master race, the GE63/73 Raider RGB are given a new identity. The new lighting top cover design with Mystic Light and Gaming Mode optimization offers the fanciest illumination ever. Get ready to light up whoeverï', 'MSI', 'LP', '2018-05-30', '7700.00', '5b8745b893d9b.png'),
(10016, 'MSI-GS65-STEALTH-THIN-8RF', 'GS65 Stealth Thin - An ultraportable 15.6-inch laptop with thin bezel gaming display and its brand new gold-and-black premium design. Sharp, powerful, slim - all forged into one.', 'MSI', 'LP', '2018-07-25', '8359.00', '5b8745c555ebe.png'),
(10017, 'ALIENWARE 17', '17-inch gaming laptop is the ultimate powerhouse machine, designed for VR with upgraded cooling technology and a new-generation overclocked CPU.', 'Alienware', 'LP', '2017-07-26', '7549.00', '5b8745cf81463.png'),
(10018, 'PREDATOR HELIOS 300', 'Conquer the competition with the latest 8th Gen IntelÂ® Coreâ„¢ i7 processor1 and overclockable NVIDIAÂ® GeForceÂ® GTX 1060 graphics', 'Predator', 'LP', '2017-08-30', '3819.00', '5b8745d9efa2a.png'),
(10019, 'Predator Triton 700', 'The Predator Triton 700 delivers the power of a full-on desktop replacement in the body of a stylish, portable mainstream laptop.', 'Predator', 'LP', '2018-06-24', '12200.00', '5b8745e988d8e.png'),
(10020, 'ROG Zephyrus M (GM501)', 'ROG Zephyrus M picks up where its predecessor, ROG Zephyrus, left off â€” delivering mighty performance in a minute package. Itâ€™s powered by up to an 8th Generation IntelÂ® Coreâ„¢ i7 processor and NVIDIAÂ® GeForceÂ® GTX 1070 graphics, and features an I', 'ROG', 'LP', '2018-08-24', '7545.00', '5b874611bcece.png'),
(10021, 'Logitech G502', 'G502 is critically acclaimed and tops the charts in popularity. The high performance, premium build quality, advanced gaming features and incredible comfort combine for a truly exceptional and highly customizable gaming experience.', 'Logitech', 'MS', '2018-04-10', '265.00', '5b87462170bc0.png'),
(10022, 'Logitech G903', 'G903 is most advanced and fully featured gaming mouse. Featuring 1 ms LIGHTSPEED wireless, G903 delivers competition-grade performance, responsiveness and accuracy. Combined with POWERPLAY, G903 operates wirelessly with infinite power, never needing a', 'Logitech', 'MS', '2018-07-31', '467.00', '5b87462a4db4d.png'),
(10023, 'Razer Deathadder Elite', 'Equipped with the new esports-grade 16,000 DPI optical sensor and true tracking at 450 Inches Per Second (IPS), the Razer DeathAdder Elite ergonomic mouse gives you the absolute advantage. Engineered to redefine the standards of accuracy and speed, this i', 'Razer', 'MS', '2018-06-28', '249.00', '5b874632a324e.png'),
(10024, 'Razer Naga Trinity', 'Experience the power of total control in your hand, no matter what game you play. Designed to provide you that edge you need in MOBA/MMO gameplay, the Razer Naga Trinity lets you configure your mouse for everything from weapons to build customizations so', 'Razer', 'MS', '2018-08-20', '369.00', '5b87463d79255.png'),
(10025, 'Steelseries Sensei 310', 'The Sensei 310 is an ambidextrous gaming mouse that SteelSeries hopes will win over professional gamers. Itâ€™s remarkably lightweight, comfortable to use and, most importantly, it performs excellently across all games and applications.', 'Steelseries', 'MS', '2018-04-20', '250.00', '5b874645e8cb7.png'),
(10026, 'Cooler-Master-MasterSet-MS120', 'The MasterSet MS120 is a keyboard with the durability and features normally found in pro-grade hardware. The tactile keyboard   quality tools to elevate your gaming aspirations.', 'Cooler Master', 'KB', '2018-05-17', '273.00', '5b8746549376e.png'),
(10027, 'Corsair K63 Wireless', 'Experience ultimate gaming freedom with the CORSAIR K63 Wireless Mechanical Gaming Keyboard, featuring ultra-fast 1ms 2.4GHz wireless technology with CHERRYÂ® MX mechanical keyswitches packed into a portable, tenkeyless design.', 'Corsair', 'KB', '2018-04-19', '412.00', '5b87465fb70fe.png'),
(10028, 'HyperX Alloy Elite', 'Equip yourself with a keyboard that has both stunning style and substance. Choose from the HyperXÂ™ Alloy Elite RGB with its stunning RGB lighting, or the single-colour HyperX Alloy Elite. The Alloy Elite RGB allows you to customise the colour for each of', 'HyperX', 'KB', '2017-11-23', '480.00', '5b87466858879.png'),
(10029, 'Razer Cynosa Chroma', 'If you think a keyboard with all the essentials couldnâ€™t get betterâ€”think again. With the Razer Cynosa Chroma, we kept the necessities and amped it up with features. It now boasts all-round gaming performance with individually backlit keys, so you hav', 'Razer', 'KB', '2018-04-11', '230.00', '5b874670e60cc.png'),
(10030, 'Razer Huntsman Elite', 'Meet the Razer Huntsman Elite: the product of years of research and innovationâ€”now taken to new heights. By redefining the boundaries of precision and speed, you are about to experience performance that can only be described as ahead of its time. The ne', 'Razer', 'KB', '2017-09-20', '649.00', '5b87467c8896a.png'),
(10031, 'A20', 'The A20 Wireless Headset is tuned for gaming. Immersive, accurate, and precise; experience your game audio exactly as the developers intended with signature EQ profiles created by ASTRO', 'ASTRO', 'HS', '2018-06-13', '350.00', '5b87468d2fa25.png'),
(10032, 'Corsair HS50 Stereo', 'The CORSAIR HS50 Stereo Gaming Headset provides the comfort, sound quality and durability needed for hours of gameplay.', 'Corsair', 'HS', '2018-04-20', '210.00', '5b87469700378.png'),
(10033, 'Corsair HS70 Wireless', 'The CORSAIR HS70 Wireless Gaming Headset provides exceptional comfort, superior sound quality, a fully detachable microphone, and up to 16 hours of battery life.', 'Corsair', 'HS', '2018-05-16', '410.00', '5b8746a1590c3.png'),
(10034, 'HyperX Cloud Revolver S', 'If youâ€™re serious about gaming, you need a headset that will give you the maximum competitive advantage. The HyperX Cloud Revolverâ„¢ line is premium-grade gear, meticulously designed to meet the demands of the elite PC or console gamer. Next-gen driver', 'HyperX', 'HS', '2018-04-18', '495.00', '5b8746acdd392.png'),
(10035, 'SteelSeries Arctis Pro Wireless', 'The SteelSeries Arctis Pro Wireless delivers nuanced sound and a plethora of audio options, all without the need for cumbersome software.', 'Steelseries', 'HS', '2018-06-27', '460.00', '5b8746b5b96c3.png');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE `transaction` (
  `id` int(6) UNSIGNED NOT NULL,
  `total` decimal(8,2) UNSIGNED NOT NULL,
  `card_number` char(16) NOT NULL,
  `exp_date` char(5) NOT NULL,
  `cvv` char(3) NOT NULL,
  `payment_date` date NOT NULL,
  `discount_code` char(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `total`, `card_number`, `exp_date`, `cvv`, `payment_date`, `discount_code`) VALUES
(1, '8424.00', '8888-8888-8888-8', '12/25', '888', '2018-08-30', NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `user`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `user`;
CREATE TABLE `user` (
`username` varchar(100)
,`password` varchar(255)
,`email` varchar(100)
,`role` varchar(8)
);

-- --------------------------------------------------------

--
-- Structure for view `user`
--
DROP TABLE IF EXISTS `user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user`  AS  select `customer`.`username` AS `username`,`customer`.`password` AS `password`,`customer`.`email` AS `email`,'customer' AS `role` from `customer` union all select `admin`.`username` AS `username`,`admin`.`password` AS `password`,`admin`.`email` AS `email`,'admin' AS `role` from `admin` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`,`email`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`prod_id`,`cust_name`),
  ADD KEY `cust_id` (`cust_name`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_key`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`username`,`email`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`discount_code`),
  ADD UNIQUE KEY `Rate` (`rate`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guest_detail` (`personal_detail`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `personal_detail`
--
ALTER TABLE `personal_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discount_code` (`discount_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_detail`
--
ALTER TABLE `personal_detail`
  MODIFY `id` int(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10036;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `customer_name` FOREIGN KEY (`cust_name`) REFERENCES `customer` (`username`),
  ADD CONSTRAINT `product_id` FOREIGN KEY (`prod_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`personal_detail`) REFERENCES `personal_detail` (`id`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`id`),
  ADD CONSTRAINT `order_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`discount_code`) REFERENCES `discount` (`discount_code`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
