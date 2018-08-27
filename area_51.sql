-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2018 at 07:46 AM
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
(100005, 'sam', '$2y$10$ndrvG1bzlihaG5s8EGHQse9zjjXTgtraEc4ayIG.ccOm0KhTVZErW', 'shixian0511@hotmail.com');

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
(1, 'nchen118', '$2y$10$rhQ88xZs2czSxCE5W0w5/.lUFa09Z2Q2yyXIS52EF6G6zR4pE5yBi', 'nchen118@yahoo.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

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
(10001, 'S5X KABYLAKE', 'The S5X comes equipped with the latest Intel Core i7-7700HQ processor and Nvidia GeForce GTX1070 8GB Max-Q graphcis in a 18.6mm thin chassis. Weighing no more than 1.9kg, your S5X is the perfect lightweight gaming companion.', 'ILLEGEAR', 'l', '0000-00-00', '0.00', '5b838ed51fa17.jpg');

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
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10002;

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
