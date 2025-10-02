-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 03, 2025 at 12:40 AM
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
-- Database: `cake_lovers`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(3, 'Admin User', 'admin@cake.com', 'admin123', '2025-09-27 02:18:09');

-- --------------------------------------------------------

--
-- Table structure for table `cakes`
--

CREATE TABLE `cakes` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` float NOT NULL,
  `rating` float DEFAULT 0,
  `rating_count` int(11) DEFAULT 0,
  `size` varchar(50) DEFAULT '1 kg',
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 10
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cakes`
--

INSERT INTO `cakes` (`id`, `name`, `image`, `description`, `price`, `rating`, `rating_count`, `size`, `stock`) VALUES
(1, 'Chocolate Cake', 'chocolate_cake.jpg', 'Rich and moist chocolate cake layered with silky chocolate ganache.', 500, 0, 0, '1 kg', 12),
(2, 'Vanilla Cake', 'vanilla_cake.jpg\r\n', 'Classic vanilla sponge cake with whipped cream and a smooth vanilla flavor.', 450, 0, 0, '1 kg', 5),
(3, 'Strawberry Cake', 'strawberry_cake.jpg', 'Fresh strawberry sponge cake layered with strawberry cream and glaze.', 480, 0, 0, '1 kg', 10),
(4, 'Red Velvet Cake', 'red_velvet.jpg', 'Soft red sponge cake with cream cheese frosting, a delightful choice for special occasions.', 600, 0, 0, '1 kg', 10),
(5, 'Black Forest Cake', 'black_forest.jpg', 'Layers of chocolate sponge, whipped cream, and cherries topped with chocolate shavings.', 500, 0, 0, '1 kg', 10),
(6, 'Pineapple Cake', 'pineapple_cake.jpg', 'Soft sponge with pineapple chunks and fresh cream, fruity and refreshing.', 480, 0, 0, '1 kg', 10),
(7, 'Butterscotch Cake', 'butterscotch_cake.jpg', 'Crunchy caramel butterscotch layers with whipped cream, nutty and sweet.', 520, 0, 0, '1 kg', 10),
(8, 'Mango mousse Cake', 'mango_mousse.jpg', 'Seasonal delight with layers of mango puree and fresh cream.', 550, 0, 0, '1 kg', 10),
(9, 'Blueberry Cake', 'blueberry.jpg', 'Moist cake infused with blueberry cream and topped with blueberry glaze.', 570, 0, 0, '1 kg', 10),
(10, 'Coffee walnut cake', 'coffee_walnut.jpg', 'Rich coffee flavored sponge with whipped cream and chocolate drizzle and crunchy walnuts.', 530, 0, 0, '1 kg', 10),
(11, 'Oreo cream Cake', 'oreo_cream.jpg', 'Delicious cake layered with Oreo cream and cookie crumbles.', 560, 0, 0, '1 kg', 10),
(12, 'Fruit Cake', 'fruit_cake.jpg', 'Loaded with fresh fruits and cream, perfect for celebrations.', 590, 0, 0, '1 kg', 10);

-- --------------------------------------------------------

--
-- Table structure for table `cake_customizations`
--

CREATE TABLE `cake_customizations` (
  `id` int(10) UNSIGNED NOT NULL,
  `cake_id` int(10) UNSIGNED NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `flavour` varchar(100) DEFAULT NULL,
  `toppings` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `extra_charges` float DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cake_customizations`
--

INSERT INTO `cake_customizations` (`id`, `cake_id`, `size`, `flavour`, `toppings`, `message`, `image`, `extra_charges`, `created_at`) VALUES
(1, 1, '0.5kg', 'Chocolate', '', '', '', 0, '2025-09-26 07:51:47'),
(2, 2, '0.5kg', 'Chocolate', '', '', '', 0, '2025-09-26 11:23:17'),
(3, 2, '0.5kg', 'Chocolate', '', '', '', 0, '2025-09-26 11:23:23'),
(4, 2, '1kg', 'Chocolate', 'nuts', 'hello kitty', '', 100, '2025-09-27 03:18:07'),
(5, 2, '1kg', 'Chocolate', 'nuts', 'hello kitty', '', 100, '2025-09-27 03:18:28'),
(6, 6, '0.5kg', 'Chocolate', '', '', '', 0, '2025-09-27 03:20:43'),
(7, 9, '0.5kg', 'Chocolate', '', '', '', 0, '2025-09-27 04:45:29'),
(8, 6, '0.5kg', 'Chocolate', '', '', '', 0, '2025-09-27 07:55:52'),
(9, 5, '1kg', 'Strawberry', 'nuts and chocochips', 'hello kitty', '', 200, '2025-09-28 04:43:33'),
(10, 2, '0.5kg', 'Chocolate', '', '', '', 0, '2025-09-28 05:09:47'),
(11, 3, '0.5kg', 'Chocolate', '', '', '', 0, '2025-09-28 05:12:24'),
(12, 3, '0.5kg', 'Chocolate', '', '', '', 0, '2025-09-28 05:12:26'),
(13, 1, '0.5kg', 'Chocolate', '', '', '', 0, '2025-09-28 05:13:07'),
(14, 1, '0.5kg', 'Chocolate', '', '', '', 0, '2025-09-28 05:13:09'),
(15, 2, '0.5kg', 'Chocolate', '', '', '', 0, '2025-09-28 07:12:15'),
(16, 10, '2kg', 'Strawberry', 'nuts', 'hello kitty', '', 400, '2025-09-28 07:25:08'),
(17, 10, '2kg', 'Strawberry', 'nuts', 'hello kitty', '', 400, '2025-09-28 08:10:34'),
(18, 2, '0.5kg', 'Chocolate', '', '', '', 0, '2025-10-02 14:35:14'),
(19, 2, '0.5kg', 'Chocolate', '', '', '', 0, '2025-10-02 14:35:38'),
(20, 2, '0.5kg', 'Chocolate', '', '', '', 0, '2025-10-02 14:35:42'),
(21, 10, '0.5kg', 'Chocolate', '', '', '', 0, '2025-10-02 16:25:53');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `cake_id` int(10) UNSIGNED NOT NULL,
  `customization_id` int(10) UNSIGNED DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `size` varchar(20) DEFAULT '1/2 kg',
  `flavour` varchar(50) DEFAULT '',
  `toppings` varchar(100) DEFAULT '',
  `message` varchar(255) DEFAULT '',
  `extra_charges` int(11) DEFAULT 0,
  `message_text` varchar(255) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `cake_id`, `customization_id`, `quantity`, `created_at`, `size`, `flavour`, `toppings`, `message`, `extra_charges`, `message_text`) VALUES
(4, 5, 9, 7, 1, '2025-09-27 04:45:29', '1/2 kg', '', '', '', 0, ''),
(5, 5, 6, 8, 1, '2025-09-27 07:55:52', '1/2 kg', '', '', '', 0, ''),
(12, 6, 2, 15, 1, '2025-09-28 07:12:15', '1/2 kg', '', '', '', 0, ''),
(14, 6, 10, 17, 1, '2025-09-28 08:10:34', '1/2 kg', '', '', '', 0, ''),
(22, 8, 4, NULL, 1, '2025-10-02 21:40:55', '0.5', 'Chocolate', 'Choco Chips', '', 150, '');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'mamta', 'mamta@gmail.com', NULL, 'hellow  ..', '2025-09-29 13:42:00'),
(2, 'fgdfbdf', 'ashish@gmail.com', NULL, 'gfbgfbgfbfdbdbgbrbgfb', '2025-10-02 21:01:17');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `cake_id` int(10) UNSIGNED NOT NULL,
  `customization_id` int(10) UNSIGNED DEFAULT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `total_price` float NOT NULL,
  `delivery_name` varchar(255) NOT NULL,
  `delivery_phone` varchar(20) NOT NULL,
  `delivery_address` text NOT NULL,
  `payment_method` varchar(50) DEFAULT 'COD',
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status_updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `takeaway` tinyint(1) DEFAULT 0,
  `payment_status` enum('Pending','Paid','Failed') NOT NULL DEFAULT 'Pending',
  `payment_reference` varchar(255) DEFAULT NULL,
  `status_preparing` timestamp NULL DEFAULT NULL,
  `status_shipped` timestamp NULL DEFAULT NULL,
  `status_out_for_delivery` timestamp NULL DEFAULT NULL,
  `status_delivered` timestamp NULL DEFAULT NULL,
  `delivery_info` varchar(255) DEFAULT '',
  `delivery_date` date DEFAULT NULL,
  `size` varchar(10) DEFAULT '0.5',
  `flavour` varchar(50) DEFAULT '',
  `message` varchar(255) DEFAULT '',
  `toppings` varchar(50) DEFAULT '',
  `extra_charges` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `cake_id`, `customization_id`, `quantity`, `total_price`, `delivery_name`, `delivery_phone`, `delivery_address`, `payment_method`, `status`, `created_at`, `status_updated_at`, `takeaway`, `payment_status`, `payment_reference`, `status_preparing`, `status_shipped`, `status_out_for_delivery`, `status_delivered`, `delivery_info`, `delivery_date`, `size`, `flavour`, `message`, `toppings`, `extra_charges`) VALUES
(1, 5, 6, 6, 1, 480, 'fggfh', '9076349229', '1499, rabale, navi mumbai , maharashtra, 400708', 'GPay', 'Pending', '2025-09-27 04:00:21', '2025-09-28 05:11:40', 1, 'Pending', NULL, NULL, NULL, NULL, NULL, '', NULL, '0.5', '', '', '', 0),
(2, 9, 4, NULL, 1, 560, 'kknjjjjnj', '', '', 'GPay', 'Pending', '2025-10-02 22:36:30', '2025-10-02 22:36:30', 0, 'Pending', NULL, NULL, NULL, NULL, NULL, '', NULL, '0.5kg', 'vanilla', 'hello kitty', 'add nuts', -40),
(3, 9, 11, NULL, 2, 2140, 'kknjjjjnj', '', '', 'GPay', 'Out for Delivery', '2025-10-02 22:36:30', '2025-10-02 22:36:30', 0, 'Pending', NULL, NULL, NULL, NULL, NULL, '', NULL, '2kg', 'strawberry', 'hello kitty', 'add nuts', 510),
(4, 9, 4, NULL, 1, 660, 'fggfh', 'fdfdgfdgrtgtggf', 'gfgrgrgrgrgergregregr', 'GPay', 'Pending', '2025-10-02 22:37:56', '2025-10-02 22:37:56', 0, 'Pending', NULL, NULL, NULL, NULL, NULL, '', NULL, '1kg', '', 'add vanilla cream also in this cake, half strawberry and half vanilla', 'nuts', 60);

-- --------------------------------------------------------

--
-- Table structure for table `order_status_history`
--

CREATE TABLE `order_status_history` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `cake_id` int(10) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `review` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(5, 'Mamta shripati kawde', 'mamta@gmail.com', 'e5fbfbc5', '2025-09-27 03:17:08'),
(6, 'ashwini', 'ashwini@gmail.com', '4debcc77', '2025-09-28 04:40:52'),
(8, 'ashish k', 'ashish@gmail.com', 'ashish@123', '2025-10-02 14:32:44'),
(9, 'roshan d', 'roshan@gmail.com', 'roshan@123', '2025-10-02 21:57:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `cakes`
--
ALTER TABLE `cakes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cake_customizations`
--
ALTER TABLE `cake_customizations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cake` (`cake_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cake_id` (`cake_id`),
  ADD KEY `customization_id` (`customization_id`);

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
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cake_id` (`cake_id`),
  ADD KEY `customization_id` (`customization_id`);

--
-- Indexes for table `order_status_history`
--
ALTER TABLE `order_status_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `cake_id` (`cake_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cakes`
--
ALTER TABLE `cakes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cake_customizations`
--
ALTER TABLE `cake_customizations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_status_history`
--
ALTER TABLE `order_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cake_customizations`
--
ALTER TABLE `cake_customizations`
  ADD CONSTRAINT `cake_customizations_ibfk_1` FOREIGN KEY (`cake_id`) REFERENCES `cakes` (`id`),
  ADD CONSTRAINT `fk_cake` FOREIGN KEY (`cake_id`) REFERENCES `cakes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`cake_id`) REFERENCES `cakes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_3` FOREIGN KEY (`customization_id`) REFERENCES `cake_customizations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`cake_id`) REFERENCES `cakes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`customization_id`) REFERENCES `cake_customizations` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`cake_id`) REFERENCES `cakes` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
