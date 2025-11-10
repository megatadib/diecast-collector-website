-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:8080
-- Generation Time: Nov 10, 2025 at 10:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diecasthub`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_name`, `price`, `quantity`) VALUES
(6, 3, 'Porsche 911 GT3', 29.90, 1),
(7, 3, 'Toyota Supra A80', 25.00, 1),
(8, 3, 'Nissan GT-R R35', 35.00, 1),
(9, 3, 'Porsche 911 GT3', 29.90, 1),
(10, 3, 'Toyota Supra A80', 25.00, 1),
(11, 3, 'Nissan GT-R R35', 35.00, 1),
(12, 3, 'Porsche 911 GT3', 29.90, 1),
(13, 3, 'Toyota Supra A80', 25.00, 1),
(18, 2, 'Porsche 911 GT3', 29.90, 1);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `poster` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `created_at`) VALUES
(1, 2, 179.60, '2025-10-25 19:36:05'),
(2, 2, 35.00, '2025-10-25 19:37:17'),
(3, 4, 35.00, '2025-11-10 04:36:53'),
(4, 4, 25.00, '2025-11-10 04:37:08'),
(5, 4, 29.90, '2025-11-10 04:40:41'),
(6, 4, 80.00, '2025-11-10 06:16:11'),
(7, 8, 35.00, '2025-11-10 07:12:30');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `price`, `quantity`) VALUES
(1, 1, 'Toyota Supra A80', 25.00, 1),
(2, 1, 'Porsche 911 GT3', 29.90, 1),
(3, 1, 'Nissan GT-R R35', 35.00, 1),
(4, 1, 'Porsche 911 GT3', 29.90, 1),
(5, 1, 'Porsche 911 GT3', 29.90, 1),
(6, 1, 'Porsche 911 GT3', 29.90, 1),
(7, 2, 'Nissan GT-R R35', 35.00, 1),
(8, 3, 'Nissan GT-R R35', 35.00, 1),
(9, 4, 'Toyota Supra A80', 25.00, 1),
(10, 5, 'Porsche 911 GT3', 29.90, 1),
(11, 6, 'Nissan GT-R R35', 35.00, 1),
(12, 6, 'BMW M4', 45.00, 1),
(13, 7, 'Nissan GT-R R35', 35.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `brand`, `price`, `image`) VALUES
(1, 'Nissan GT-R R35', 'MINIGT', 35.00, 'gtr.jpg'),
(2, 'Toyota Supra A80', 'Hot Wheels', 25.00, 'supra.jpg'),
(3, 'Porsche 911 GT3', 'Tomica', 29.90, 'gt3.jpg'),
(4, 'BMW M4', 'MINIGT', 45.00, '1762751725_BMW_M4.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','customer') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(2, 'megat', 'megat@gmail.com', '$2y$10$IAhoirvWynLNcAOYY1rl4.RnsK/k9vK4V8YbGZOu63nHpoeLjebu2', 'customer'),
(3, 'luqman', 'luqman@gmail.com', '$2y$10$1/IzwByA8..XOZuQKjv5K.vGk6TUSnZbW4PH1CdfkTeeNZmy5tVAe', 'customer'),
(4, 'adam', 'adam@gmail.com', '$2y$10$zzuDpEZnGdDbl7oeKGtJsuue4Z6pvgKTQQtEjgz8HgzWfC3Ii095y', 'customer'),
(5, 'test', 'test@gmail.com', '$2y$10$bWiuJMruTW/VcIZIukR.CewudgOSQ36ZCW2WuuM/Ov88qDJZSZljm', 'admin'),
(7, 'admin@diecasthub.com', 'admin@diecasthub.com', '$2y$10$8Q56aw5L4NwEUKLcJyyrFupEuWFpVYpAubkcyaEs2cEOrbwz0j2Ey', 'admin'),
(8, 'alif', 'alif@gmail.com', '$2y$10$9dAWUYvRORirfbPAbzj6vuaAV3IXEWaJ.bZ9NM7rR64tJf.qLix5O', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
