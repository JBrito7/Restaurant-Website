-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2025 at 07:47 PM
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
-- Database: `morgane_auth`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NULL DEFAULT current_timestamp(),
  `status` enum('pending','completed') DEFAULT 'pending',
  `total_price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_date`, `status`, `total_price`) VALUES
(4, 1, '2025-08-07 15:18:29', 'pending', 100.00),
(9, 1, '2025-08-07 19:37:47', 'completed', 65.00),
(18, 1, '2025-08-08 16:56:39', 'completed', 25.00);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(3, 4, 5, 1, 80.00),
(4, 4, 11, 1, 20.00),
(11, 9, 1, 1, 40.00),
(12, 9, 10, 1, 25.00),
(22, 18, 7, 1, 25.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(50) NOT NULL DEFAULT 'uncategorized',
  `stock` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image`, `price`, `category`, `stock`) VALUES
(1, 'Blue Hoodie', 'Na cor azul-marinho, confortável e estiloso. Feito em algodão macio, com ajuste descontraído e capuz ajustável. Perfeito para um look casual e aconchegante.', 'hoodie2-clothes.png', 40.00, 'MaMa Clothes', 15),
(2, 'Bege Hoodie', 'Na cor bege, macio e confortável. Feito em algodão de alta qualidade, com capuz ajustável e ajuste descontraído. Ideal para um look casual e aconchegante.', 'hoodie-clothes.png', 40.00, 'MaMa Clothes', 20),
(3, 'Rain Coat', 'Casaco impermeável em azul, elegante e funcional. Feito com material resistente à água, possui capuz ajustável e corte confortável. Perfeito para proteção com estilo em dias chuvosos.', 'rain-clothes.png', 55.00, 'MaMa Clothes', 20),
(4, 'T-shirt para Criança', 'T-shirt Mama Loves You na cor branca, minimalista e versátil. Feita em algodão macio, com corte confortável e estampa discreta. Perfeita para um look casual e cheio de significado.', 'shirt-clothes.png', 35.00, 'MaMa Clothes', 20),
(5, 'Bolsa de viagem', 'Bolsa de viagem na cor écru, espaçosa e elegante. Feita em lona resistente, com alças reforçadas e amplo compartimento interno. Perfeita para escapadelas de fim de semana com estilo e praticidade.', 'bag-acessorie.png', 80.00, 'MaMa Accessories', 10),
(6, 'Gorro', 'Gorro Mama Love - Edição Limitada (conjunto de 2), confortável e estiloso. Feito em malha macia, ideal para os dias frios. Perfeito para combinar e compartilhar com quem você ama.', 'bennie-acessorie.png', 35.00, 'MaMa Accessories', 10),
(7, 'Boné', 'Boné azul, estiloso e versátil. Feito em algodão resistente, com ajuste regulável e bordado exclusivo. Perfeito para um look casual com atitude.', 'cap-acessorie.png', 25.00, 'MaMa Accessories', 15),
(8, 'Tigela de porcelana', 'Tigela Breton Mama Loves You, clássica e charmosa. Feita em cerâmica resistente, com design atemporal e inscrição delicada. Perfeita para começar o dia com estilo e aconchego.', 'bowl-souvenir.png', 55.00, 'MaMa Souvenir', 10),
(9, 'Prato fundo de porcelana', 'Prato fundo Mama x Juliette Seban, em porcelana elegante e sofisticada. Design exclusivo, ideal para trazer charme e autenticidade à mesa. Perfeito para refeições especiais.', 'hollow-souvenir.png', 43.00, 'MaMa Souvenir', 10),
(10, 'Caneca Ti amo', 'Caneca Ti Amo - Mama x Juliette Seban, em cerâmica elegante e resistente. Design exclusivo com detalhes delicados, perfeita para desfrutar das suas bebidas favoritas com charme e estilo.', 'mug-souvenir.png', 25.00, 'MaMa Souvenir', 10),
(11, 'Prato de porcelana', 'Prato raso Visage Mama, em porcelana de alta qualidade. Design exclusivo e moderno, perfeito para adicionar sofisticação à sua mesa com um toque artístico e único.', 'plate-souvenir.png', 20.00, 'MaMa Souvenir', 10),
(12, 'Mama Love You Mustard', 'Mostarda caseira, feita com ingredientes de alta qualidade. Sabor único e autêntico, perfeita para adicionar um toque especial às suas refeições. Ideal para os amantes de sabores intensos e sofisticados.', 'mustard-food.png', 18.00, 'MaMa Food', 15),
(14, 'MaMa Loves You Pasta', 'Les Coquillettes de la Mama, massas deliciosas e autênticas, perfeitas para criar pratos saborosos e reconfortantes. Feitas com ingredientes de alta qualidade, ideais para um jantar simples e cheio de sabor.', '1754323240_pasta-food.png', 15.00, 'MaMa Food', 20);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `avatar` varchar(100) DEFAULT 'avatar1.jpg',
  `user_type` enum('client','admin') DEFAULT 'client',
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `avatar`, `user_type`, `address`, `phone`) VALUES
(1, 'JBrito', 'brito@gmail.com', '$2y$10$5xzlVy8GKlzot2OdKSxYK.31Qar75Te1LRBzMo6s9Ly3Ffmvv6cia', 'avatar1.png', 'admin', 'funchal, Madeira 22', '9876654554'),
(2, 'Morgane', 'morgane@gmail.com', '$2y$10$n2Mb.MKq21zLO.8.52KTy.iqDfOEcIwC/9OvWMluSv3fGQZS06DYK', 'avatar1.png', 'admin', 'Paris, France 22', '1234567891'),
(3, 'Nando', 'nando@gmail.com', '$2y$10$ER79VfxYKR/YdQDo4620AuXsSlnpNo1H8oIlOhS8c8Sfr7WITDkO6', 'avatar4.png', 'client', 'Sardinha, Italy 33', '351986544657'),
(4, 'Julieta', 'julieta@gmail.com', '$2y$10$6HioqoYD7SKqXFwWdF257.RhxMOQhr86dD97W4CN/Q2C7QTkUgrO6', 'avatar3.png', 'client', 'Bunny Street, 7, Luxembourg', '987654321987'),
(5, 'Admin', 'admin@gmail.com', '$2y$10$gP0z/MeBHdVPbalaPY3kpOH/gJSRJuQnhWTVTAwaldw6QnIWPAyua', 'avatar5.png', 'admin', 'admin, Lisboa 88', '98765432198');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_ibfk_1` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_ibfk_1` (`order_id`),
  ADD KEY `order_items_ibfk_2` (`product_id`);

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
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
