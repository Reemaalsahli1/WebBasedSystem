-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2025 at 09:15 PM
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
-- Database: `glamour_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `email`, `username`, `password`) VALUES
(6, 'raghad@hotmail.com', 'raghad', '$2y$10$09hV8PBHrfrPAhFtRb4Ls.gORfsPPQITWx573q8bKy81LswidjmNm'),
(8, 'layan@gmail.com', 'layan', '$2y$10$Tv1MvEtPs9NnizC2N.a0Ze23F/wpusKY7bGHDCcUrkFbexKqnfFDq');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`) VALUES
(3, 2, '2025-05-02 03:22:07'),
(4, 2, '2025-05-02 03:35:30'),
(5, 2, '2025-05-02 05:57:21'),
(6, 2, '2025-05-02 16:32:12'),
(7, 2, '2025-05-03 02:16:20'),
(8, 2, '2025-05-03 02:32:41'),
(9, 2, '2025-05-03 16:40:49'),
(10, 2, '2025-05-03 21:09:15'),
(11, 2, '2025-05-04 18:05:00'),
(12, 2, '2025-05-04 18:14:55'),
(13, 2, '2025-05-04 18:16:05'),
(14, 5, '2025-05-04 19:30:22'),
(15, 2, '2025-05-04 21:29:15'),
(16, 2, '2025-05-04 21:29:35'),
(17, 2, '2025-05-04 21:39:14'),
(18, 5, '2025-05-04 21:43:29'),
(19, 5, '2025-05-04 21:43:49'),
(20, 6, '2025-05-04 21:45:54'),
(21, 6, '2025-05-04 21:46:36'),
(22, 5, '2025-05-04 22:09:03'),
(23, 6, '2025-05-04 22:13:17');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(6, 3, 10, 4, 90.00),
(7, 4, 14, 2, 600.00),
(8, 5, 10, 2, 90.00),
(9, 5, 11, 3, 80.00),
(10, 6, 11, 3, 80.00),
(11, 7, 10, 91, 90.00),
(12, 8, 10, 1, 90.00),
(13, 8, 12, 2, 15.00),
(14, 9, 10, 100, 100.00),
(15, 10, 11, 6, 80.00),
(16, 10, 14, 1, 600.00),
(17, 11, 12, 8, 15.00),
(18, 11, 14, 1, 600.00),
(19, 11, 13, 4, 25.00),
(20, 11, 10, 3, 100.00),
(21, 12, 11, 1, 80.00),
(22, 12, 12, 1, 15.00),
(23, 13, 11, 1, 80.00),
(24, 13, 10, 1, 100.00),
(25, 14, 11, 4, 80.00),
(26, 14, 21, 10, 155.00),
(27, 15, 10, 15, 100.00),
(28, 15, 11, 7, 80.00),
(29, 15, 21, 3, 155.00),
(30, 15, 14, 5, 600.00),
(31, 16, 17, 3, 44.00),
(32, 17, 11, 1, 80.00),
(33, 18, 11, 3, 80.00),
(34, 18, 14, 4, 600.00),
(35, 19, 17, 4, 44.00),
(36, 20, 11, 3, 80.00),
(37, 20, 13, 5, 25.00),
(38, 21, 17, 8, 44.00),
(39, 22, 14, 7, 600.00),
(40, 22, 12, 1, 15.00),
(41, 23, 17, 1, 44.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `description` text NOT NULL,
  `picture` varchar(255) NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `picture`, `category`, `stock`) VALUES
(10, 'Foundation', 100, 'A lightweight, buildable liquid foundation that delivers smooth, full coverage with a natural matte finish. Perfect for all-day wear, it evens out skin tone and hides imperfections without clogging pores.', 'foundation.jpeg', 'Face', 100),
(11, 'Mascara', 80, 'A rich black mascara that delivers intense volume, dramatic length, and lasting curl.Its smudge-resistant formula lifts and defines every lash with a smooth, clump-free finish — perfect for all-day wear.', 'mascara.jpeg', 'Eyes', 100),
(12, 'RoseGold Precision Eyelash Curler', 15, 'Achieve a flawless, long-lasting curl with this elegant rose gold eyelash curler.Designed with a gentle cushioned pad and ergonomic handles for comfort and control, it lifts and curls lashes without pinching or pulling.Perfect for enhancing your natural lashes before applying mascara.', 'Eyelashcurlers.png', 'Brushes & Tools', 100),
(13, 'Crimson Gloss Nail Lacquer', 50, 'A bold, high-shine red nail polish that delivers flawless color in just one coat.Its quick-dry, chip-resistant formula ensures long-lasting wear with a salon-quality finish.Perfect for both everyday glam and special occasions.', 'nailpolish.jpeg', 'Nails', 100),
(14, 'Blush Bloom Eau de Parfum', 600, 'A delicate floral fragrance with notes of jasmine, rose, and vanilla.Blush Bloom wraps you in a soft, romantic aura that lingers beautifully on the skin.Perfect for daytime elegance or a graceful evening touch.', 'perfume.jpg', 'Perfume', 100),
(17, 'Red Lipstick', 44, 'A luxurious red lipstick that delivers bold color with a smooth, satin finish. Enriched with moisturizing ingredients, it glides on effortlessly to keep lips soft, hydrated, and irresistibly vibrant all day long. Perfect for any occasion, this classic red shade adds a touch of elegance and confidence to your look.\r\n', 'lipstick.jpg', 'Lips', 100),
(21, 'Blush ', 155, 'semi-matte finish blush, embossed with texture resembling silk twill. A fine, silky, long-lasting powder for a luminous, radiant complexion.', 'blush.jpg', 'Face', 100);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `password`) VALUES
(5, 'maram', 'mrmr@gmail.co', '$2y$10$2CsRrlcmVN3.hO8h.PSUVOMVXoiSE/HiMh8n8Vle3glFGq4qTT7fq'),
(6, 'jojo', 'meowm@gmail.com', '$2y$10$l5R8xAIpjOa6Np4yByXJ9.N7GhOKLi2xKiXrS.TaKPtZgA8yS3nI6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
