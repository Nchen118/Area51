-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 28, 2018 at 05:58 AM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

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

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(6) UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`) VALUES
(100002, 'nicholaschen', '$2y$10$rHGUokm3RK787W8Lv40P3ONC015VJPRzwczz/hW0l0ZZsy903/Cle', 'nchen118@yahoo.com'),
(100003, 'admin', '$2y$10$jR4a9a14JNKkrqFW2THgHuTDYc2qoTgvd1SinhAJ5qJ2.24leGQOi', 'nchen1181999@gmail.com'),
(100004, 'wesly', '$2y$10$Cwuv16aRJMvyKPOVTdiO2uYg4wv4tkg1Cz7KvsPW9FJP.gzZdF8fu', 'wesly_0808@hotmail.com'),
(100005, 'sam', '$2y$10$RGns2/UiJiA4rurpDv2/x.QZ4GSJuxW4gnjlH3WuNGHggrQh82Se2', 'samcsx0511@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cust_id` int(6) UNSIGNED NOT NULL,
  `prod_id` int(6) UNSIGNED NOT NULL,
  `qty` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_key` char(1) NOT NULL,
  `cat_name` varchar(50) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

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
(1, 'nchen118', '$2y$10$rhQ88xZs2czSxCE5W0w5/.lUFa09Z2Q2yyXIS52EF6G6zR4pE5yBi', 'nchen118@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'EXPLOOOOOSION', '$2y$10$4MGRPnsNlE3ZtR/dcwbOUe/Jan9SFpezYN3eFV9ZsZgd4urT9.Ztm', 'samcsx0511@gmail.com', NULL, 'profile_picture.jpg', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `category` char(1) NOT NULL,
  `date` date NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `photo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `brand`, `category`, `date`, `price`, `photo`) VALUES
(10001, 'S5X KABYLAKE', 'The S5X comes equipped with the latest Intel Core i7-7700HQ processor and Nvidia GeForce GTX1070 8GB Max-Q graphcis in a 18.6mm thin chassis. Weighing no more than 1.9kg, your S5X is the perfect lightweight gaming companion.', 'ILLEGEAR', 'L', '2016-09-08', '6700.00', '5b838ed51fa17.jpg'),
(10002, 'Asus VivoBook S15 S510UN', 'The ASUS VivoBook S15 gives you the perfect combination of beauty and performance. With its slim NanoEdge bezel, brushed-metal finish, the latest IntelÂ® Coreâ„¢ i7 processor with 16GB RAM, and NVIDIAÂ® GeForceÂ® MX150 graphics*, VivoBook S15 is designed ', 'ASUS', 'L', '2016-10-20', '2825.00', '5b839dac08833.jpg'),
(10003, 'Dell Inspiron 15 3000 series-3576', 'Inspiron 15 Inch 3000 Laptop with in-demand features and the latest IntelÂ® processors, CinemaStream and CinemaSound.', 'DELL', 'L', '2016-12-25', '1800.00', '5b839eeaf302d.jpg'),
(10004, 'Dell G7 15 Gaming Laptop', '15-Inch gaming laptop designed for a powerful, immersive in-game experience featuring NVIDIAÂ® GeForceÂ® GTX 1060 graphics and the latest 8th Gen IntelÂ® Quad-and-Hex Coreâ„¢ CPUs.', 'DELL', 'L', '2018-02-12', '3769.00', '5b83b351ded0c.jpg'),
(10005, 'msi-GE73-Raider-RGB-8RE', 'Inspired by exotic sports cars and the RGB master race, the GE63/73 Raider RGB are given a new identity. The new lighting top cover design with Mystic Light and Gaming Mode optimization offers the fanciest illumination ever. Get ready to light up whoeverâ', 'MSI', 'L', '2018-05-30', '7700.00', '5b83b4631a739.jpg'),
(10006, 'MSI-GS65-STEALTH-THIN-8RF', 'GS65 Stealth Thin - An ultraportable 15.6-inch laptop with thin bezel gaming display and its brand new gold-and-black premium design. Sharp, powerful, slim - all forged into one.', 'MSI', 'L', '2018-07-25', '8359.00', '5b83b4eccd833.jpg'),
(10007, 'ALIENWARE 17', '17-inch gaming laptop is the ultimate powerhouse machine, designed for VR with upgraded cooling technology and a new-generation overclocked CPU.', 'Alienware', 'L', '2017-07-26', '7549.00', '5b83b569d29cb.jpg'),
(10008, 'PREDATOR HELIOS 300', 'Conquer the competition with the latest 8th Gen IntelÂ® Coreâ„¢ i7 processor1 and overclockable NVIDIAÂ® GeForceÂ® GTX 1060 graphics', 'Predator', 'L', '2017-08-30', '3819.00', '5b83b8692265c.jpg'),
(10009, 'Predator Triton 700', 'The Predator Triton 700 delivers the power of a full-on desktop replacement in the body of a stylish, portable mainstream laptop.', 'Predator', 'L', '2018-06-24', '12200.00', '5b83b95958b25.jpg'),
(10010, 'ROG Zephyrus M (GM501)', 'ROG Zephyrus M picks up where its predecessor, ROG Zephyrus, left off â€” delivering mighty performance in a minute package. Itâ€™s powered by up to an 8th Generation IntelÂ® Coreâ„¢ i7 processor and NVIDIAÂ® GeForceÂ® GTX 1070 graphics, and features an I', 'ROG', 'L', '2018-08-24', '7545.00', '5b83b9df514d6.jpg');

-- --------------------------------------------------------

--
-- Stand-in structure for view `user`
-- (See below for the actual view)
--
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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`prod_id`,`cust_id`),
  ADD KEY `cust_id` (`cust_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_key`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100006;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10011;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`cust_id`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`prod_id`) REFERENCES `product` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
