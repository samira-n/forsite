-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июн 11 2024 г., 22:56
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `forsite`
--

-- --------------------------------------------------------

--
-- Структура таблицы `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `brands`
--

INSERT INTO `brands` (`id`, `name`, `logo`) VALUES
(1, 'MSI', 'msi.png'),
(2, 'ASUS', 'asus.png'),
(3, 'HUAWEI', 'huawei.png'),
(4, 'LENOVO', 'lenovo.png');

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Офисные компьютеры', NULL),
(2, 'Игровые компьютеры', NULL),
(3, 'Ноутбуки', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `name`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 'test', 'test@test.ru', 'test', 'test', '2024-06-09 19:36:08'),
(2, 'test', 'test@test.ru', 'test', 'test', '2024-06-09 19:36:32'),
(3, 'test', 'test@test.ru', 'test', 'test', '2024-06-10 19:16:53'),
(4, 'test', 'test@test.ru', 'test', 'test', '2024-06-10 19:50:25');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `status` enum('Оформлен','Получен') DEFAULT 'Оформлен',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `status`, `created_at`) VALUES
(1, 1, 29000.00, 'Оформлен', '2024-06-10 19:08:52'),
(2, 1, 42000.00, 'Оформлен', '2024-06-10 19:09:58'),
(3, 1, 116000.00, 'Оформлен', '2024-06-10 19:50:08'),
(4, 1, 25000.00, 'Оформлен', '2024-06-10 20:12:07'),
(5, 1, 162000.00, 'Оформлен', '2024-06-10 21:13:05');

-- --------------------------------------------------------

--
-- Структура таблицы `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 11, 1, 29000.00),
(2, 2, 16, 1, 17000.00),
(3, 2, 3, 1, 25000.00),
(4, 3, 13, 1, 91000.00),
(5, 3, 3, 1, 25000.00),
(6, 4, 3, 1, 25000.00),
(7, 5, 3, 3, 25000.00),
(8, 5, 11, 3, 29000.00);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `category_id`, `brand_id`, `name`, `description`, `price`, `image`) VALUES
(1, 3, 1, 'Ноутбук MSI', 'test', 10000.00, 'msi_laptop.png'),
(2, 2, NULL, 'Игровой компьютер (Intel Core i3-4170/Radeon RX 550 2 ГБ/8 ГБ DDR3/256 ГБ SSD)', 'Intel Core i3-4170/Radeon RX 550 2 ГБ/8 ГБ DDR3/256 ГБ SSD', 20000.00, 'gamepk1.png'),
(3, 2, NULL, 'Игровой компьютер (Intel Core i3-10100F/GeForce RTX 3050 8 ГБ/16 ГБ DDR4/M2 256 ГБ SSD)', 'Intel Core i3-10100F/GeForce RTX 3050 8 ГБ/16 ГБ DDR4/M2 256 ГБ SSD', 25000.00, 'gamepk2.png'),
(4, 2, NULL, 'Игровой компьютер (Intel Core i3-4170/Radeon RX 550 2 ГБ/16 ГБ DDR3/512 ГБ SSD)', 'Intel Core i3-4170/Radeon RX 550 2 ГБ/16 ГБ DDR3/512 ГБ SSD', 23000.00, 'gamepk3.png'),
(7, 1, NULL, 'Офисный ПК (Intel Core i3-2100/Intel HD Graphics/4 ГБ DDR3/128 ГБ SSD)', 'Intel Core i3-2100/Intel HD Graphics/4 ГБ DDR3/128 ГБ SSD', 9000.00, 'officepk1.png'),
(8, 1, NULL, 'Офисный ПК (Intel Core i5-2500/Intel HD Graphics/4 ГБ DDR3/256 ГБ SSD)', 'Intel Core i5-2500/Intel HD Graphics/4 ГБ DDR3/256 ГБ SSD', 11000.00, 'officepk2.png'),
(9, 1, NULL, 'Офисный ПК (Intel Core i3-4160/Intel HD Graphics/8 ГБ DDR3/256 ГБ SSD)', 'Intel Core i3-4160/Intel HD Graphics/8 ГБ DDR3/256 ГБ SSD', 12000.00, 'officepk3.png'),
(11, 3, 4, 'Ноутбук Lenovo V15-IGL 82C3001NAK', 'Ноутбук Lenovo V15-IGL 82C3001NAK', 29000.00, 'lenovo_laptop1.png'),
(12, 3, 2, 'Ноутбук ASUS Vivobook 15X OLED X1503ZA-L1493', 'Ноутбук ASUS Vivobook 15X OLED X1503ZA-L1493', 63000.00, 'asus_laptop1.png'),
(13, 3, 4, 'Ноутбук Lenovo ThinkBook 14 G4 IAP 21DHA09ACD', 'Ноутбук Lenovo ThinkBook 14 G4 IAP 21DHA09ACD', 91000.00, 'lenovo_laptop2.png'),
(14, 3, 3, 'Ноутбук Huawei MateBook D 14 2023 MDF-X 53013RHL', 'Ноутбук Huawei MateBook D 14 2023 MDF-X 53013RHL', 55000.00, 'huawei_laptop.png'),
(15, 3, 3, 'Ноутбук Huawei MateBook 16s 2023 CREFG-X 53013SDA', 'Ноутбук Huawei MateBook 16s 2023 CREFG-X 53013SDA', 149000.00, 'huawei_laptop2.png'),
(16, 1, NULL, 'Офисный ПК (Intel Core i3-6100/Intel HD Graphics/8 ГБ DDR4/128 ГБ SSD)', 'Intel Core i3-6100/Intel HD Graphics/8 ГБ DDR4/128 ГБ SSD', 17000.00, 'officepk4.png'),
(17, 1, NULL, 'Офисный ПК ARENA 10439 (Intel Core i3-6100/Intel HD Graphics/4 ГБ DDR4/256 ГБ SSD)', 'Intel Core i3-6100/Intel HD Graphics/4 ГБ DDR4/256 ГБ SSD', 18000.00, 'officepk1.png'),
(18, 1, NULL, 'Офисный ПК ARENA 10285 (Intel Core i3-8100/Intel HD Graphics/4 ГБ DDR4/128 ГБ SSD)', 'Intel Core i3-8100/Intel HD Graphics/4 ГБ DDR4/128 ГБ SSD', 20000.00, 'officepk2.png'),
(19, 2, NULL, 'Игровой ПК ARENA 5321 (Intel Core i3-10100F/Radeon RX 550 2 ГБ/16 ГБ DDR4/128 ГБ SSD/1000 ГБ HDD)', 'Игровой ПК (Intel Core i3-10100F/Radeon RX 550 2 ГБ/16 ГБ DDR4/128 ГБ SSD/1000 ГБ HDD', 39000.00, 'gamepk5.png'),
(20, 2, NULL, 'Игровой ПК (AMD Ryzen 5 3600/Radeon RX 550 4 ГБ/16 ГБ DDR4/M2 256 ГБ SSD)', 'AMD Ryzen 5 3600/Radeon RX 550 4 ГБ/16 ГБ DDR4/M2 256 ГБ SSD', 40000.00, 'gamepk4.png'),
(21, 2, NULL, 'Игровой ПК (Intel Core i5-7400/GeForce GTX 1650 4 ГБ/8 ГБ DDR4/128 ГБ SSD)', 'Intel Core i5-7400/GeForce GTX 1650 4 ГБ/8 ГБ DDR4/128 ГБ SSD', 45000.00, 'gamepk3.png');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `full_name`) VALUES
(1, 'test', '$2y$10$AFdfp/doT5H9BVPGB57fY.jo8f/FFqK3fOMzkddsAg4yIQI4OBSS2', 'user@test.ru', 'test test test');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
