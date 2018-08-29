-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 29, 2018 at 05:08 AM
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
(100003, 'admin', '$2y$10$jR4a9a14JNKkrqFW2THgHuTDYc2qoTgvd1SinhAJ5qJ2.24leGQOi', 'nchen1181999@gmail.com'),
(100004, 'wesly', '$2y$10$Cwuv16aRJMvyKPOVTdiO2uYg4wv4tkg1Cz7KvsPW9FJP.gzZdF8fu', 'wesly_0808@hotmail.com'),
(100005, 'sam', '$2y$10$yqtCrM.jZ5IHihZm4X00l.9t07uv/erc2v4NkLBu82sfmNWzbNXQ2', 'shixian0511@hotmail.com');

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
(1, 'nchen118', '$2y$10$.hQUvpaatwzHe4AsET0E0OxwszcA3v5M0U9bCI8rbvoUg1rscTBh2', 'nchen118@yahoo.com', NULL, 'profile_picture.jpg', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

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
(10011, 'S5X KABYLAKE', 'The S5X comes equipped with the latest Intel Core i7-7700HQ processor and Nvidia GeForce GTX1070 8GB Max-Q graphcis in a 18.6mm thin chassis. Weighing no more than 1.9kg, your S5X is the perfect lightweight gaming companion.', 'ILLEGEAR', 'LP', '2016-09-06', '6700.00', '5b85f5c2f3e9d.png'),
(10012, 'Asus VivoBook S15 S510UN', 'The ASUS VivoBook S15 gives you the perfect combination of beauty and performance. With its slim NanoEdge bezel, brushed-metal finish, the latest IntelÂ® Coreâ„¢ i7 processor with 16GB RAM, and NVIDIAÂ® GeForceÂ® MX150 graphics*, VivoBook S15 is designed ', 'ASUS', 'LP', '2016-12-25', '2825.00', '5b85f77137582.png'),
(10013, 'Dell Inspiron 15 3000 series-3576', 'Inspiron 15 Inch 3000 Laptop with in-demand features and the latest IntelÂ® processors, CinemaStream and CinemaSound.', 'DELL', 'LP', '2016-12-25', '1800.00', '5b85f7bf2993f.png'),
(10014, 'Dell G7 15 Gaming Laptop', '15-Inch gaming laptop designed for a powerful, immersive in-game experience featuring NVIDIAÂ® GeForceÂ® GTX 1060 graphics and the latest 8th Gen IntelÂ® Quad-and-Hex Coreâ„¢ CPUs.', 'DELL', 'LP', '2018-02-12', '3769.00', '5b85f8339bc79.png'),
(10015, 'MSI-GE73-Raider-RGB-8RE', 'Inspired by exotic sports cars and the RGB master race, the GE63/73 Raider RGB are given a new identity. The new lighting top cover design with Mystic Light and Gaming Mode optimization offers the fanciest illumination ever. Get ready to light up whoeverâ', 'MSI', 'LP', '2018-05-30', '7700.00', '5b85f885f0f13.png'),
(10016, 'MSI-GS65-STEALTH-THIN-8RF', 'GS65 Stealth Thin - An ultraportable 15.6-inch laptop with thin bezel gaming display and its brand new gold-and-black premium design. Sharp, powerful, slim - all forged into one.', 'MSI', 'LP', '2018-07-25', '8359.00', '5b85f8d4146c9.png'),
(10017, 'ALIENWARE 17', '17-inch gaming laptop is the ultimate powerhouse machine, designed for VR with upgraded cooling technology and a new-generation overclocked CPU.', 'Alienware', 'LP', '2017-07-26', '7549.00', '5b85f944d8d15.png'),
(10018, 'PREDATOR HELIOS 300', 'Conquer the competition with the latest 8th Gen IntelÂ® Coreâ„¢ i7 processor1 and overclockable NVIDIAÂ® GeForceÂ® GTX 1060 graphics', 'Predator', 'LP', '2017-08-30', '3819.00', '5b85f9dcdf248.png'),
(10019, 'Predator Triton 700', 'The Predator Triton 700 delivers the power of a full-on desktop replacement in the body of a stylish, portable mainstream laptop.', 'Predator', 'LP', '2018-06-24', '12200.00', '5b85fa3a737eb.png'),
(10020, 'ROG Zephyrus M (GM501)', 'ROG Zephyrus M picks up where its predecessor, ROG Zephyrus, left off â€” delivering mighty performance in a minute package. Itâ€™s powered by up to an 8th Generation IntelÂ® Coreâ„¢ i7 processor and NVIDIAÂ® GeForceÂ® GTX 1070 graphics, and features an I', 'ROG', 'LP', '2018-08-24', '7545.00', '5b85fa949e635.png'),
(10021, 'Logitech G502', 'G502 is critically acclaimed and tops the charts in popularity. The high performance, premium build quality, advanced gaming features and incredible comfort combine for a truly exceptional and highly customizable gaming experience.', 'Logitech', 'MS', '2018-04-10', '265.00', '5b86008e51ff4.png'),
(10022, 'Logitech G903', 'G903 is most advanced and fully featured gaming mouse. Featuring 1 ms LIGHTSPEED wireless, G903 delivers competition-grade performance, responsiveness and accuracy. Combined with POWERPLAY, G903 operates wirelessly with infinite power, never needing a', 'Logitech', 'MS', '2018-07-31', '467.00', '5b86017b7f872.png'),
(10023, 'Razer Deathadder Elite', 'Equipped with the new esports-grade 16,000 DPI optical sensor and true tracking at 450 Inches Per Second (IPS), the Razer DeathAdder Elite ergonomic mouse gives you the absolute advantage. Engineered to redefine the standards of accuracy and speed, this i', 'Razer', 'MS', '2018-06-28', '249.00', '5b8601f700869.png'),
(10024, 'Razer Naga Trinity', 'Experience the power of total control in your hand, no matter what game you play. Designed to provide you that edge you need in MOBA/MMO gameplay, the Razer Naga Trinity lets you configure your mouse for everything from weapons to build customizations so', 'Razer', 'MS', '2018-08-20', '369.00', '5b86025a4c736.png'),
(10025, 'Steelseries Sensei 310', 'The Sensei 310 is an ambidextrous gaming mouse that SteelSeries hopes will win over professional gamers. Itâ€™s remarkably lightweight, comfortable to use and, most importantly, it performs excellently across all games and applications.', 'Steelseries', 'MS', '2018-04-20', '250.00', '5b8603be2d80e.png'),
(10026, 'Cooler-Master-MasterSet-MS120', 'The MasterSet MS120 is a keyboard with the durability and features normally found in pro-grade hardware. The tactile keyboard   quality tools to elevate your gaming aspirations.', 'Cooler Master', 'KB', '2018-05-17', '273.00', '5b860af1ed310.png'),
(10027, 'Corsair K63 Wireless', 'Experience ultimate gaming freedom with the CORSAIR K63 Wireless Mechanical Gaming Keyboard, featuring ultra-fast 1ms 2.4GHz wireless technology with CHERRYÂ® MX mechanical keyswitches packed into a portable, tenkeyless design.', 'Corsair', 'KB', '2018-04-19', '412.00', '5b860b44df811.png'),
(10028, 'HyperX Alloy Elite', 'Equip yourself with a keyboard that has both stunning style and substance. Choose from the HyperXÂ™ Alloy Elite RGB with its stunning RGB lighting, or the single-colour HyperX Alloy Elite. The Alloy Elite RGB allows you to customise the colour for each of', 'HyperX', 'KB', '2017-11-23', '480.00', '5b860cf417488.png'),
(10029, 'Razer Cynosa Chroma', 'If you think a keyboard with all the essentials couldnâ€™t get betterâ€”think again. With the Razer Cynosa Chroma, we kept the necessities and amped it up with features. It now boasts all-round gaming performance with individually backlit keys, so you hav', 'Razer', 'KB', '2018-04-11', '230.00', '5b860d6f7bdd3.png'),
(10030, 'Razer Huntsman Elite', 'Meet the Razer Huntsman Elite: the product of years of research and innovationâ€”now taken to new heights. By redefining the boundaries of precision and speed, you are about to experience performance that can only be described as ahead of its time. The ne', 'Razer', 'KB', '2017-09-20', '649.00', '5b860db92b3cc.png');

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
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10031;

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
