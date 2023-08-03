-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2023-07-31 08:30:12
-- 伺服器版本： 10.4.28-MariaDB
-- PHP 版本： 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `hongteag_goose`
--

-- --------------------------------------------------------

--
-- 資料表結構 `banner`
--

CREATE TABLE `banner` (
  `filename` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `banner`
--

INSERT INTO `banner` (`filename`, `path`, `id`) VALUES
('', 'images/89712.jpg', 1),
('', 'images/slide2.png', 2),
('', 'images/slide3.png', 3),
(NULL, NULL, 10);

-- --------------------------------------------------------

--
-- 資料表結構 `booking`
--

CREATE TABLE `booking` (
  `Cart_ID` int(45) NOT NULL,
  `Booking_ID` int(45) NOT NULL,
  `Date` date NOT NULL,
  `Order_Status` varchar(45) NOT NULL,
  `Remark` varchar(255) NOT NULL,
  `BookingTotalPrice` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `business_info`
--

CREATE TABLE `business_info` (
  `Location` varchar(255) NOT NULL,
  `TimeDate` date NOT NULL,
  `Title` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `coupon`
--

CREATE TABLE `coupon` (
  `Coupon_ID` int(45) NOT NULL,
  `Member_ID` int(45) NOT NULL,
  `Discount_period` date NOT NULL,
  `Discount` double NOT NULL,
  `Coupon_Discount` varchar(45) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `income_statement`
--

CREATE TABLE `income_statement` (
  `Booking_ID` int(45) NOT NULL,
  `Product_ID` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `information`
--

CREATE TABLE `information` (
  `Date` date NOT NULL,
  `Title` double NOT NULL,
  `Content` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `manager`
--

CREATE TABLE `manager` (
  `Employee_ID` int(45) NOT NULL,
  `Employee_Account` varchar(255) NOT NULL,
  `Employee_Password` varchar(255) NOT NULL,
  `Employee_LV` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `news`
--

CREATE TABLE `news` (
  `newsID` int(11) NOT NULL,
  `newsDate` date NOT NULL,
  `newsContent` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `news`
--

INSERT INTO `news` (`newsID`, `newsDate`, `newsContent`) VALUES
(1, '2023-07-14', '最新消息6'),
(2, '2023-07-17', '最新消息6'),
(3, '2023-07-16', '最新消息3');

-- --------------------------------------------------------

--
-- 資料表結構 `popular_products`
--

CREATE TABLE `popular_products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `image_path` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `popular_products`
--

INSERT INTO `popular_products` (`id`, `product_name`, `image_path`, `description`, `price`) VALUES
(1, '鵝001', 'images/230505_5.jpg', '產品說明:ABC123', 110.00),
(2, '鵝002', 'image/230505_6.jpg', '產品說明:DEF', 15.00),
(3, '鵝003', 'images/230505_7.jpg', '產品說明:GHJ', 300.00);

-- --------------------------------------------------------

--
-- 資料表結構 `product`
--

CREATE TABLE `product` (
  `Product_ID` int(11) NOT NULL,
  `Product_name` text NOT NULL,
  `Product_description` varchar(255) DEFAULT NULL,
  `Product_price` int(11) NOT NULL,
  `Product_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `product`
--

INSERT INTO `product` (`Product_ID`, `Product_name`, `Product_description`, `Product_price`, `Product_image`) VALUES
(1, '燻茶鵝1/2', 'anv', 3804, 'images/pic02.jpg'),
(2, '鹹水鵝半隻', 'Sed nisl arcu euismod sit amet nisi lorem etiam dolor veroeros et feugiat', 660, 'images/pic02 (2).jpg'),
(3, '醉鵝半隻', 'Sed nisl arcu euismod sit amet nisi lorem etiam dolor veroeros et feugiat', 7600, 'images/pic03 (2).jpg'),
(4, '醉鵝1/4隻', 'Sed nisl arcu euismod sit amet nisi lorem etiam dolor veroeros et feugiat', 460, 'images/pic04 (2).jpg'),
(5, '鵝頭', 'Sed nisl arcu euismod sit amet nisi lorem etiam dolor veroeros et feugiat', 75, 'images/pic05 (2).jpg'),
(6, '鵝腳', 'Sed nisl arcu euismod sit amet nisi lorem etiam dolor veroeros et feugiat', 35, 'images/pic06.jpg'),
(7, '鵝翅', 'Sed nisl arcu euismod sit amet nisi lorem etiam dolor veroeros et feugiat', 40, 'images/pic07.jpg'),
(8, '鵝胗', 'Sed nisl arcu euismod sit amet nisi lorem etiam dolor veroeros et feugiat', 100, 'images/pic08.jpg'),
(9, '雞腳', 'Sed nisl arcu euismod sit amet nisi lorem etiam dolor veroeros et feugiat', 100, 'images/pic09.jpg');

-- --------------------------------------------------------

--
-- 資料表結構 `purchase_history`
--

CREATE TABLE `purchase_history` (
  `Member_ID` int(45) NOT NULL,
  `Booking_ID` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `purchase_order`
--

CREATE TABLE `purchase_order` (
  `Product_ID` int(45) NOT NULL,
  `ProductName` varchar(45) NOT NULL,
  `Purchase_OrderID` int(45) NOT NULL,
  `Purchase_Quantity` int(45) NOT NULL,
  `Purchase_Price` int(45) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `sales_list`
--

CREATE TABLE `sales_list` (
  `Booking` int(45) NOT NULL,
  `Sales_ID` int(45) NOT NULL,
  `Member_ID` int(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `shoppingcart`
--

CREATE TABLE `shoppingcart` (
  `Cart_ID` int(45) NOT NULL,
  `Member_ID` int(45) NOT NULL,
  `Product_ID` int(45) NOT NULL,
  `Sales_Quantity` int(45) NOT NULL,
  `Coupon_ID` int(45) NOT NULL,
  `TotalPrice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 傾印資料表的資料 `shoppingcart`
--

INSERT INTO `shoppingcart` (`Cart_ID`, `Member_ID`, `Product_ID`, `Sales_Quantity`, `Coupon_ID`, `TotalPrice`) VALUES
(6616, 0, 1, 1, 3804, 3804),
(2728, 0, 2, 2, 660, 1320);

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `Account` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Name` varchar(45) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Phone` int(45) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Member_ID` int(45) DEFAULT NULL,
  `Line_ID` varchar(255) DEFAULT NULL,
  `Coupon_ID` int(45) DEFAULT NULL,
  `Booking` int(45) DEFAULT NULL,
  `Gender` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`Account`, `Password`, `Name`, `Email`, `Phone`, `Address`, `Member_ID`, `Line_ID`, `Coupon_ID`, `Booking`, `Gender`) VALUES
('dfgg', 'ger', 'greg', 'gregh@gmail.com', 15464, 'gerg', NULL, NULL, NULL, NULL, NULL),
('321', '123', 'SID', '132@hh', 12345, 'taipei', NULL, NULL, NULL, NULL, NULL),
('Jacky', '$2y$10$y/aHeEofWERwwD4fQLQDp.0ygOti9tGo1WzGWw312Vbt22F1U1Uji', 'kkk', 'jkk@321', 12345, 'taipei', NULL, NULL, NULL, NULL, NULL),
('Jacky2', '$2y$10$4Hie4nTV7O5MWfc.RY0uK.9jIF0ClvjgR8CY0uXkm9XLcUQ2MNFVO', 'kkk', 'jkk@321', 12345, 'taipei', NULL, NULL, NULL, NULL, NULL),
('Jacky3', '$2y$10$VDyDEP3KRww89CI4znq8N.hTRerUw88r2EzDVemtHwxsBFRUo3pAS', 'kkk', 'jkk@321', 12345, 'taipei', NULL, NULL, NULL, NULL, NULL),
('Jacky4', '$2y$10$ENHVkPO3XWmGaecPve2R/eQrshxarMq/bsOiuqjwlkEzTfRvUf1q.', 'kkk', 'jkk@321', 12345, 'taipei', NULL, NULL, NULL, NULL, NULL),
('Jacky6', '$2y$10$GqUqOPmLnjVK4.9YUWBLkOofOmuHBDvHt/PIPlXPOwWehWq6dOEwy', 'SID', '132@hh', 2324234, 'taipei', NULL, NULL, NULL, NULL, NULL);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`newsID`);

--
-- 資料表索引 `popular_products`
--
ALTER TABLE `popular_products`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `popular_products`
--
ALTER TABLE `popular_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
