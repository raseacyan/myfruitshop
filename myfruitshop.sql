-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2021 at 02:14 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myfruitshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_on`) VALUES
(2, 'Local', '2021-08-02 11:55:43'),
(3, 'Imported', '2021-08-02 11:55:58');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `order_amount` int(32) NOT NULL,
  `amount_received` int(32) NOT NULL,
  `order_id` int(11) NOT NULL,
  `admin_note` text NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `order_amount`, `amount_received`, `order_id`, `admin_note`, `created_on`) VALUES
(2, 3700, 3700, 2, '', '2021-08-03 13:16:41'),
(3, 7500, 7500, 3, '', '2021-08-03 14:46:18'),
(4, 5000, 5000, 4, '', '2021-08-03 14:53:44');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(32) NOT NULL,
  `customer_phone` varchar(32) NOT NULL,
  `customer_address` varchar(32) NOT NULL,
  `customer_message` text NOT NULL,
  `payment_method` varchar(32) NOT NULL,
  `order_status` enum('pending','paid','shipped','completed','cancelled','refunded') NOT NULL,
  `admin_note` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `shipping_rate_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `customer_phone`, `customer_address`, `customer_message`, `payment_method`, `order_status`, `admin_note`, `user_id`, `shipping_rate_id`, `created_on`) VALUES
(2, 'Nay', '0105437407', 'DG 3, Rayaria Condominium Jalan ', 'test', 'COD', 'paid', '', 4, 1, '2021-08-03 13:16:41'),
(3, 'Nay', '0105437407', 'DG 3, Rayaria Condominium Jalan ', 'Hello', 'Visa', 'paid', '', 4, 2, '2021-08-03 14:46:18'),
(4, 'Nay', '0105437407', 'DG 3, Rayaria Condominium Jalan ', '', 'Visa', 'paid', '', 4, 1, '2021-08-03 14:53:44');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `quantity`, `price`, `product_id`, `order_id`, `created_on`) VALUES
(4, 1, 200, 1, 2, '2021-08-03 13:16:41'),
(5, 1, 100, 2, 2, '2021-08-03 13:16:41'),
(6, 1, 400, 3, 2, '2021-08-03 13:16:41'),
(7, 5, 100, 2, 3, '2021-08-03 14:46:18'),
(8, 5, 400, 3, 3, '2021-08-03 14:46:18'),
(9, 5, 400, 3, 4, '2021-08-03 14:53:44');

-- --------------------------------------------------------

--
-- Table structure for table `payment_options`
--

CREATE TABLE `payment_options` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_options`
--

INSERT INTO `payment_options` (`id`, `name`, `description`, `created_on`) VALUES
(1, 'COD', 'Please pay cash when your order is delivered.', '2021-07-26 19:52:10'),
(2, 'KPay', 'Please pay to  #12345678', '2021-07-26 19:54:22'),
(3, 'Visa', 'Please pay by credit card (Visa)', '2021-07-26 19:54:48');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `price` int(32) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `code`, `price`, `description`, `image`, `category_id`, `created_on`) VALUES
(1, 'Apple', 'mfs-001', 200, 'Fresh local apples. MMK 200 for 1 apple.', '1627897480_apple.jpg', 2, '2021-08-02 16:14:40'),
(2, 'Banana', 'mfs-002', 100, 'Fresh local banana. MMK 100 for 1 banana.', '1627900003_banana.jpg', 2, '2021-08-02 16:56:43'),
(3, 'Strawberry', 'mfs-003', 400, 'Fresh imported strawberry. MMK 400 for 10g.', '1627900072_strawberry.jpg', 3, '2021-08-02 16:57:52');

-- --------------------------------------------------------

--
-- Table structure for table `shippings`
--

CREATE TABLE `shippings` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `price` int(32) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shippings`
--

INSERT INTO `shippings` (`id`, `name`, `description`, `price`, `created_on`) VALUES
(1, 'Yangon', 'All townships', 3000, '2021-07-26 10:35:40'),
(2, 'Other', 'All other cities', 5000, '2021-07-26 10:37:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `email` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `role` varchar(32) NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_on`) VALUES
(4, 'Nay', 'nay@test.com', 'cc03e747a6afbbcbf8be7668acfebee5', '', '2021-07-26 14:19:54'),
(5, 'Admin', 'admin@test.com', 'cc03e747a6afbbcbf8be7668acfebee5', 'admin', '2021-07-28 14:11:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_options`
--
ALTER TABLE `payment_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shippings`
--
ALTER TABLE `shippings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payment_options`
--
ALTER TABLE `payment_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shippings`
--
ALTER TABLE `shippings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
