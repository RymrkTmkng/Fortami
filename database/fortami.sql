-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2023 at 01:40 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fortami`
--

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `address_id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `address_type` varchar(50) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `region` varchar(50) NOT NULL,
  `province` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `barangay` varchar(50) NOT NULL,
  `street` varchar(50) NOT NULL,
  `zip` varchar(50) NOT NULL,
  `label` varchar(50) NOT NULL,
  `note` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`address_id`, `user_id`, `full_name`, `address_type`, `contact`, `region`, `province`, `city`, `barangay`, `street`, `zip`, `label`, `note`) VALUES
(30, 35, 'Reymark Timkang', 'Default', '09123456789', '7', 'Cebu', 'Talisay', 'Linao', 'Maghaway St. , San Antonio', '6045', 'Home', 'Gray gate , not on a rush so take your time and ha'),
(32, 37, 'Joseph Restaurant', 'Default', '09999988543', '7', 'Cebu', 'Cebu', 'N/A', 'P.del Rosario St.', '6000', 'Home', 'Beside ACT school'),
(34, 39, 'Romeo Food Hub', 'Default', '09994564213', '7', 'Cebu ', 'Cebu', 'N/A', 'Leon Kilat St.', '6000', 'Home', ''),
(40, 47, 'Mike Resto', 'Default', '09995564157', '7', 'Cebu', 'Cebu', 'N/a', 'Leon Kilat St.', '6000', 'Home', 'Accross On Central'),
(44, 35, 'Cardo Dalisay', 'Default', '09875648132', 'NCR', 'Manila', 'Manila', 'Pasig', 'Noded st', '5180', 'Work', 'Butihan mo ang pagdadala pag may tapon, patay ka sakin'),
(45, 36, 'Justin Eatery', 'Default', '09875648981', '7', 'Cebu', 'Cebu', 'Sambag 1', 'J. Alcantara Street', '6000', 'Pickup', '');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `food_id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `quantity` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(20) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `category_description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_description`) VALUES
(1, 'Fast Food', 'Foods that takes lesser time to prepare.'),
(2, 'vegetables', 'Foods that are 100% organic and meat free.'),
(3, 'Baked', 'Foods that are baked'),
(4, 'Beverages', 'Drinks and more'),
(5, 'Seafood', 'Foods from the sea'),
(10, 'Liquor', 'Alcoholic Beverages'),
(11, 'Asian', 'Foods that originated in Asia');

-- --------------------------------------------------------

--
-- Table structure for table `food_order`
--

CREATE TABLE `food_order` (
  `order_id` int(20) NOT NULL,
  `food_id` int(20) DEFAULT NULL,
  `address_id` int(20) NOT NULL,
  `payTrans_id` int(20) NOT NULL,
  `order_status` varchar(50) NOT NULL,
  `rating_status` varchar(50) DEFAULT NULL,
  `quantity` varchar(50) NOT NULL,
  `order_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `received_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `food_order`
--

INSERT INTO `food_order` (`order_id`, `food_id`, `address_id`, `payTrans_id`, `order_status`, `rating_status`, `quantity`, `order_datetime`, `received_datetime`) VALUES
(158, 97, 30, 194, 'Received', 'Done', '1', '2023-05-04 05:22:13', '2023-05-04 13:22:04');

-- --------------------------------------------------------

--
-- Table structure for table `food_product`
--

CREATE TABLE `food_product` (
  `food_id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `category_id` int(20) NOT NULL,
  `food_pic` varchar(255) NOT NULL,
  `food_name` varchar(50) NOT NULL,
  `food_description` varchar(100) NOT NULL,
  `preparation` varchar(50) NOT NULL,
  `food_creation` datetime DEFAULT NULL,
  `food_discountedPrice` varchar(50) DEFAULT NULL,
  `food_origPrice` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `food_product`
--

INSERT INTO `food_product` (`food_id`, `user_id`, `category_id`, `food_pic`, `food_name`, `food_description`, `preparation`, `food_creation`, `food_discountedPrice`, `food_origPrice`) VALUES
(97, 36, 1, 'FORTAMI-645340a04d7119.29174688.jpg', 'wdada', '      dawda          \r\n            ', 'Made to order', '0000-00-00 00:00:00', '2141', '12412');

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `msg_id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `receiver_id` int(20) NOT NULL,
  `content` varchar(200) NOT NULL,
  `status` varchar(20) NOT NULL,
  `msg_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `notification_id` int(10) NOT NULL,
  `user_id` int(20) NOT NULL,
  `notif_datetime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `notif_details` varchar(200) NOT NULL,
  `notif_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notification_id`, `user_id`, `notif_datetime`, `notif_details`, `notif_status`) VALUES
(41, 36, '2023-05-04 05:29:30', 'Hooray! You have added a new product, increase your menu by adding more products!', 'Read'),
(42, 35, '2023-05-04 05:30:38', 'You have ordered from Justin Eatery with a total amount of ₱2,141.00', 'Read'),
(43, 36, '2023-05-04 05:29:34', 'Hooray!, you have a new order,open the Orders tab to view pending orders.', 'Read'),
(44, 46, '2023-05-04 05:22:04', 'New Successful Transaction with an ID of 2023194', 'Unread');

-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE `payment_method` (
  `paymethod_id` int(20) NOT NULL,
  `paymethod_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`paymethod_id`, `paymethod_type`) VALUES
(1, 'Gcash'),
(2, 'Maya'),
(3, 'Coinsph'),
(4, 'Credit Card');

-- --------------------------------------------------------

--
-- Table structure for table `payment_transaction`
--

CREATE TABLE `payment_transaction` (
  `payTrans_id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `paymethod_id` int(20) NOT NULL,
  `pay_amount` varchar(50) NOT NULL,
  `delivery_option` varchar(20) NOT NULL,
  `trans_status` varchar(50) NOT NULL,
  `pay_datetime` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_transaction`
--

INSERT INTO `payment_transaction` (`payTrans_id`, `user_id`, `paymethod_id`, `pay_amount`, `delivery_option`, `trans_status`, `pay_datetime`) VALUES
(194, 35, 4, '2141.00', 'Delivery', 'Successful', '2023-05-04 05:21:20');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `rating_id` int(20) NOT NULL,
  `order_id` int(20) NOT NULL,
  `rating` varchar(20) NOT NULL,
  `comment` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`rating_id`, `order_id`, `rating`, `comment`) VALUES
(39, 158, '4', 'yummy');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(20) NOT NULL,
  `user_type` varchar(6) NOT NULL,
  `profile_pic` varchar(50) NOT NULL,
  `user_fName` varchar(50) NOT NULL,
  `user_lName` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_userName` varchar(50) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `tagline` varchar(100) DEFAULT NULL,
  `permit` varchar(200) DEFAULT NULL,
  `verification` varchar(20) NOT NULL,
  `wallet` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_type`, `profile_pic`, `user_fName`, `user_lName`, `user_email`, `user_userName`, `user_password`, `tagline`, `permit`, `verification`, `wallet`) VALUES
(35, 'Buyer', 'FORTAMI-643d60cb5a4912.19721463.jpg', 'Reymark', 'Timkang', 'reymark@gmail.com', 'reymark', '$2y$10$5Y844Z4VcjbQ0/AZyR.Ssuhw5GUtP9PV4hVQul6RL2IGvMRLVmtzm', NULL, 'FORTAMI64513ec43863e0.05900499.jpg', '', 0),
(36, 'Seller', 'FORTAMI-643c2332b597c5.64436764.jpg', 'Justin', 'Conje', 'justinconje@gmail.com', 'JustinEatery', '$2y$10$AmjTjdgItwp5buYug9O5OujaflmPqx79Ub7Q65WTjw21iPMPQ.sIa', NULL, 'FORTAMI645273a2d014a2.12803127.png', 'Verified', 0),
(37, 'Seller', 'FORTAMI-643d0b16de3775.33433947.jpg', 'Joseph', 'Banzon', 'joseph@gmail.com', 'Joseph Restaurant', '$2y$10$IJ/vWWD84ZQRiR3ojfnnWeAoV/XL79fqbwcli8Zqu5CEEr/pgVRm2', NULL, '', '', 0),
(39, 'Seller', 'FORTAMI-643d102d3a84e1.80215800.jpg', 'Romeo', 'Chavez', 'romeo@gmail.com', 'Romeo Food Hub', '$2y$10$VMZtYxqdzlAvv20wn/ryPOeWMqvxrqOb2WFNzNE/3dmhSHmTMltM.', NULL, '', '', 0),
(46, 'Admin', 'FORTAMI-6444f29a7c7a66.99910239.png', 'Fortami', 'Admin', 'macktimkang@gmail.com', 'fortamiAdmin', '$2y$10$0dE6hnsi/Za3CWDWG07hfOaSLLkvJMhOy1hwMeHoGqeEBH6WsHusa', NULL, NULL, '', 0),
(47, 'Seller', 'FORTAMI-64460a95079f61.27407185.png', 'Mike', 'Tango-an', 'mike@gmail.com', 'Mike_resto', '$2y$10$XwMb3gahwa6d39/.3fVfkOL9eXMNvhoP5h2YD3XFrjdVUVUxSE7uW', NULL, 'FORTAMI64465359703b37.31358579.png', 'Verified', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `address_fk_1` (`user_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`food_id`,`user_id`),
  ADD KEY `cart_ibfk_2` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `food_order`
--
ALTER TABLE `food_order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `food_order_ibfk_1` (`payTrans_id`),
  ADD KEY `food_order_ibfk_3` (`address_id`),
  ADD KEY `food_order_ibfk_2` (`food_id`);

--
-- Indexes for table `food_product`
--
ALTER TABLE `food_product`
  ADD PRIMARY KEY (`food_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `food_product_ibfk_2` (`category_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`msg_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payment_method`
--
ALTER TABLE `payment_method`
  ADD PRIMARY KEY (`paymethod_id`);

--
-- Indexes for table `payment_transaction`
--
ALTER TABLE `payment_transaction`
  ADD PRIMARY KEY (`payTrans_id`),
  ADD KEY `paymethod_id` (`paymethod_id`),
  ADD KEY `payment_transaction_ibfk_4` (`user_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `rating_ibfk_1` (`order_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address`
--
ALTER TABLE `address`
  MODIFY `address_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `food_order`
--
ALTER TABLE `food_order`
  MODIFY `order_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT for table `food_product`
--
ALTER TABLE `food_product`
  MODIFY `food_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `msg_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notification_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `payment_method`
--
ALTER TABLE `payment_method`
  MODIFY `paymethod_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `payment_transaction`
--
ALTER TABLE `payment_transaction`
  MODIFY `payTrans_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `rating_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_fk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `food_product` (`food_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `food_order`
--
ALTER TABLE `food_order`
  ADD CONSTRAINT `food_order_ibfk_1` FOREIGN KEY (`payTrans_id`) REFERENCES `payment_transaction` (`payTrans_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `food_order_ibfk_2` FOREIGN KEY (`food_id`) REFERENCES `food_product` (`food_id`) ON DELETE SET NULL ON UPDATE NO ACTION,
  ADD CONSTRAINT `food_order_ibfk_3` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `food_product`
--
ALTER TABLE `food_product`
  ADD CONSTRAINT `food_product_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `food_product_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment_transaction`
--
ALTER TABLE `payment_transaction`
  ADD CONSTRAINT `payment_transaction_ibfk_1` FOREIGN KEY (`paymethod_id`) REFERENCES `payment_method` (`paymethod_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `payment_transaction_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `food_order` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
