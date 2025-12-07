-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2025 at 03:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nidra_homes`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `created_at`) VALUES
(1, 'Rughs', 'rughs', 'uploads/category_images/1759645330_CeilingRugWebsiteImage_1.webp', '2025-10-05 06:22:10');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(150) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_list` text NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('Pending','Processing','Shipped','Delivered','Cancelled') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_id`, `user_id`, `product_list`, `total_amount`, `status`, `created_at`) VALUES
(2, 'ORD1759644488714', 10, '{\"110\":{\"name\":\"Comforter 1\",\"price\":8999,\"image\":\"uploads\\/products\\/1757671080_1.jpeg\",\"qty\":1}}', 8999.00, 'Cancelled', '2025-10-05 06:08:08'),
(3, 'ORD1759644509746', 10, '{\"110\":{\"name\":\"Comforter 1\",\"price\":8999,\"image\":\"uploads\\/products\\/1757671080_1.jpeg\",\"qty\":1}}', 8999.00, '', '2025-10-05 06:08:29'),
(4, 'ORD1759651470651', 10, '{\"110\":{\"name\":\"Comforter 1\",\"price\":8999,\"image\":\"uploads\\/products\\/1757671080_1.jpeg\",\"qty\":1},\"132\":{\"name\":\"Bedsheets\",\"price\":8000,\"image\":\"uploads\\/products\\/1759651201_1.jpeg\",\"qty\":1},\"111\":{\"name\":\"Curtains\",\"price\":3000,\"image\":\"uploads\\/products\\/1759643698_curtain.webp\",\"qty\":1}}', 19999.00, 'Processing', '2025-10-05 08:04:30'),
(5, 'ORD1759653318891', 10, '{\"110\":{\"name\":\"Comforter 1\",\"price\":8999,\"image\":\"uploads\\/products\\/1757671080_1.jpeg\",\"qty\":1},\"132\":{\"name\":\"Bedsheets\",\"price\":8000,\"image\":\"uploads\\/products\\/1759651201_1.jpeg\",\"qty\":1},\"121\":{\"name\":\"Pillows\",\"price\":2500,\"image\":\"uploads\\/products\\/1759648421_1.jpeg\",\"qty\":1},\"111\":{\"name\":\"Curtains\",\"price\":3000,\"image\":\"uploads\\/products\\/1759643698_curtain.webp\",\"qty\":1}}', 22499.00, 'Pending', '2025-10-05 08:35:18');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` enum('Comforters','Bedsheets','Dohars','Towels','Pillows','Curtains') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `color` varchar(255) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category`, `created_at`, `color`, `size`) VALUES
(110, 'Comforter 1', '', 8999.00, 'uploads/products/1757671080_1.jpeg', 'Comforters', '2025-09-12 09:58:00', NULL, NULL),
(111, 'Curtains', 'Best cloth', 3000.00, 'uploads/products/1759643698_curtain.webp', 'Curtains', '2025-10-05 05:54:58', NULL, NULL),
(112, 'Comforters', '', 8500.00, 'uploads/products/1759647910_2.jpeg', 'Comforters', '2025-10-05 07:05:10', '', ''),
(113, 'Comforters', '', 8000.00, 'uploads/products/1759647930_3.jpeg', 'Comforters', '2025-10-05 07:05:30', '', ''),
(114, 'Comforters', '', 7000.00, 'uploads/products/1759647946_4.jpeg', 'Comforters', '2025-10-05 07:05:46', '', ''),
(115, 'Comforters', '', 8500.00, 'uploads/products/1759647961_5.jpeg', 'Comforters', '2025-10-05 07:06:01', 'Grey', ''),
(116, 'Comforters', '', 8500.00, 'uploads/products/1759648047_6.jpeg', 'Comforters', '2025-10-05 07:07:27', NULL, NULL),
(117, 'Comforters', '', 7000.00, 'uploads/products/1759648060_7.jpeg', 'Comforters', '2025-10-05 07:07:40', NULL, NULL),
(118, 'Comforters', '', 8000.00, 'uploads/products/1759648073_8.jpeg', 'Comforters', '2025-10-05 07:07:53', NULL, NULL),
(119, 'Curtains', '', 3500.00, 'uploads/products/1759648382_1.jpeg', 'Curtains', '2025-10-05 07:13:02', NULL, NULL),
(120, 'Curtains', '', 3000.00, 'uploads/products/1759648398_2.jpeg', 'Curtains', '2025-10-05 07:13:18', NULL, NULL),
(121, 'Pillows', '', 2500.00, 'uploads/products/1759648421_1.jpeg', 'Pillows', '2025-10-05 07:13:41', NULL, NULL),
(122, 'Pillows', '', 2000.00, 'uploads/products/1759648440_2.jpeg', 'Pillows', '2025-10-05 07:14:00', NULL, NULL),
(123, 'Bath Towels', '', 3000.00, 'uploads/products/1759648466_1.jpeg', 'Towels', '2025-10-05 07:14:26', NULL, NULL),
(124, 'Bath Towels', '', 2500.00, 'uploads/products/1759648512_2.jpeg', 'Towels', '2025-10-05 07:15:12', NULL, NULL),
(125, 'Bath Towels', '', 3000.00, 'uploads/products/1759648530_3.jpeg', 'Towels', '2025-10-05 07:15:30', NULL, NULL),
(126, 'Bath Towels', '', 2500.00, 'uploads/products/1759648546_4.jpeg', 'Towels', '2025-10-05 07:15:46', NULL, NULL),
(127, 'Bath Towels', '', 3000.00, 'uploads/products/1759648608_5.jpeg', 'Towels', '2025-10-05 07:16:48', NULL, NULL),
(128, 'Dohars', '', 7000.00, 'uploads/products/1759648656_2.jpeg', 'Dohars', '2025-10-05 07:17:36', NULL, NULL),
(129, 'd', '', 8000.00, 'uploads/products/1759648686_1.jpeg', 'Dohars', '2025-10-05 07:18:06', NULL, NULL),
(130, 'Dohars', '', 7000.00, 'uploads/products/1759648703_3.jpeg', 'Dohars', '2025-10-05 07:18:23', NULL, NULL),
(131, 'Dohars', '', 8000.00, 'uploads/products/1759648730_4.jpeg', 'Dohars', '2025-10-05 07:18:50', NULL, NULL),
(132, 'Bedsheets', '', 8000.00, 'uploads/products/1759651201_1.jpeg', 'Bedsheets', '2025-10-05 08:00:01', NULL, NULL),
(133, 'Bedsheets', '', 8900.00, 'uploads/products/1759651222_10.jpeg', 'Bedsheets', '2025-10-05 08:00:22', NULL, NULL),
(134, 'Bedsheets', '', 7000.00, 'uploads/products/1759651244_7.jpeg', 'Bedsheets', '2025-10-05 08:00:44', NULL, NULL),
(135, 'Bedsheets', '', 8000.00, 'uploads/products/1759651257_8.jpeg', 'Bedsheets', '2025-10-05 08:00:57', NULL, NULL),
(136, 'Bedsheets', '', 9000.00, 'uploads/products/1759651282_14.jpeg', 'Bedsheets', '2025-10-05 08:01:22', NULL, NULL),
(137, 'Bedsheets', '', 8000.00, 'uploads/products/1759651301_13.jpeg', 'Bedsheets', '2025-10-05 08:01:41', NULL, NULL),
(138, 'Bedsheets', '', 8000.00, 'uploads/products/1759651317_6.jpeg', 'Bedsheets', '2025-10-05 08:01:57', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reset_token` varchar(100) DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `address`, `password`, `role`, `profile_image`, `created_at`, `reset_token`, `reset_expires`) VALUES
(9, 'admin@gmail.com', 'admin@gmail.com', '1234567899', 'Lonand', '$2y$10$7WoP6JF/ctJDYymejcBAOeWsWDx7cTyq44fm.IqfUkYHtprxWAGHa', 'admin', 'uploads/profile_images/1759643573_profile.jpg', '2025-10-05 05:52:53', NULL, NULL),
(10, 'User', 'User@gmail.com', '1233211233', 'kalmboli , Panvel', '$2y$10$l6jc1Rt98uJHmJgkxEfV6uaPmGiVB0IdNGlGv5Zs3NQ0NIPtz98TS', 'user', 'uploads/profile_images/1759643984_1757407799_profile.jpg', '2025-10-05 05:59:44', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_id` (`order_id`),
  ADD KEY `user_id_idx` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_product` (`user_id`,`product_id`),
  ADD KEY `fk_wishlist_product` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `fk_wishlist_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_wishlist_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
