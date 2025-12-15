-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2025-12-14 05:12:40
-- 服务器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `cafeteria`
--

-- --------------------------------------------------------

--
-- 表的结构 `cart`
--

CREATE TABLE `cart` (
  `CartID` char(36) NOT NULL,
  `CustomerID` char(36) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `cart`
--

INSERT INTO `cart` (`CartID`, `CustomerID`, `created_at`) VALUES
('CRT693cf3212b419', 'C00004', '2025-12-13 13:01:21');

-- --------------------------------------------------------

--
-- 表的结构 `cartitems`
--

CREATE TABLE `cartitems` (
  `ItemsID` int(11) NOT NULL,
  `CartID` varchar(32) NOT NULL,
  `ProductID` varchar(32) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `customer`
--

CREATE TABLE `customer` (
  `CustomerID` varchar(10) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `customer`
--

INSERT INTO `customer` (`CustomerID`, `Name`, `Phone`, `Address`, `password`) VALUES
('C00004', 'saw', '0124411270', '', '$2y$10$ibvkB0yJ5L.vq07jqGqwxu82R0P.GpshIgPM0RJjqOA5F4YW2iHqe'),
('C00005', 'ki', '0123456789', '', '$2y$10$fJsGTIBLcjdAVRf9KJ62aeRIvbS15pOzI/h0WxnAxUV6W0zSNhy.m'),
('C00006', 'hang', '0987654321', '', '$2y$10$P3vzDvMRRDEr2faiUh.bD.F40okumg2LZY1vP78HMw6wEvkpegtDi'),
('C00007', 'hanxing', '0124578963', '', '$2y$10$HNapyonowiT.BBFH4JTV4ut1gg5mtjZieSzuC5HOAyCIOl0rljrd2'),
('C00008', 'HANG', '0147258369', '', '$2y$10$t0QeEJtER6k20Y8go9v39uEIoUWy11F8LjYM/oBetFh6lCfWBRYRy'),
('C00009', 'gauk', '0321654987', '', '$2y$10$1UuoHfWLQrrXxT20gCIe4OT4ZB8EMnb2fmKEzyF2raM4jul4KDMh2'),
('C00010', 'myname', '0321456987', '', '$2y$10$uGxHYIeA6DnB0YBo0wuj.e43foskyTFL44Ll9xnkA7hPwUzUe7NOi'),
('C00011', 'chin', '03579518426', '', '$2y$10$Uf.5qGOEZ8SeSXmj2d/qPeGSMuAyGTRVxDqdN1zDvgPzyEHBR6SoS');

-- --------------------------------------------------------

--
-- 表的结构 `deliveryinfo`
--

CREATE TABLE `deliveryinfo` (
  `DeliveryID` char(36) NOT NULL,
  `OrderID` char(36) NOT NULL,
  `receiver_name` varchar(100) NOT NULL,
  `receiver_phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `status` enum('PENDING','DELIVERING','COMPLETED','CANCELLED') NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `deliveryinfo`
--

INSERT INTO `deliveryinfo` (`DeliveryID`, `OrderID`, `receiver_name`, `receiver_phone`, `address`, `status`) VALUES
('DEL_1782b4fe4da3b4051765609788', 'ORD_b0688c2ceab908fe1765609788', 'saw', '0124411270', 'huweaskdflahd', 'PENDING'),
('DEL_3a3ce5fe51a0fc091765608107', 'ORD_c798f11ed3bcd2e21765608107', 'saw', '0124411270', 'myaddressis best', 'PENDING');

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

CREATE TABLE `order` (
  `OrderID` char(36) NOT NULL,
  `CustomerID` char(36) NOT NULL,
  `StaffID` char(36) DEFAULT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('PENDING','ACCEPTED','PREPARING','DELIVERING','COMPLETED','CANCELLED') NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `order`
--

INSERT INTO `order` (`OrderID`, `CustomerID`, `StaffID`, `order_date`, `total_amount`, `status`) VALUES
('ORD_b0688c2ceab908fe1765609788', 'C00004', NULL, '2025-12-13 15:09:48', 2.50, 'CANCELLED'),
('ORD_c798f11ed3bcd2e21765608107', 'C00004', NULL, '2025-12-13 14:41:47', 6.50, 'CANCELLED');

-- --------------------------------------------------------

--
-- 表的结构 `orderhistory`
--

CREATE TABLE `orderhistory` (
  `HistoryID` char(36) NOT NULL,
  `OrderID` char(36) NOT NULL,
  `status` varchar(30) NOT NULL,
  `changed_by_staff` char(36) DEFAULT NULL,
  `changed_at` datetime NOT NULL DEFAULT current_timestamp(),
  `remark` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `orderhistory`
--

INSERT INTO `orderhistory` (`HistoryID`, `OrderID`, `status`, `changed_by_staff`, `changed_at`, `remark`) VALUES
('HIS698c9d337a34286c1765609788', 'ORD_b0688c2ceab908fe1765609788', 'PENDING', NULL, '2025-12-13 15:09:48', 'Order placed by customer'),
('HIS83b585e57a8ba6e91765608107', 'ORD_c798f11ed3bcd2e21765608107', 'PENDING', NULL, '2025-12-13 14:41:47', 'Order placed by customer'),
('HIS_20251213080914_121f3454', 'ORD_c798f11ed3bcd2e21765608107', 'CANCELLED', NULL, '2025-12-13 15:09:14', 'Order cancelled by customer'),
('HIS_20251213080956_71655d69', 'ORD_b0688c2ceab908fe1765609788', 'CANCELLED', NULL, '2025-12-13 15:09:56', 'Order cancelled by customer');

-- --------------------------------------------------------

--
-- 表的结构 `orderitems`
--

CREATE TABLE `orderitems` (
  `ItemID` char(36) NOT NULL,
  `OrderID` char(36) NOT NULL,
  `ProductID` char(36) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `orderitems`
--

INSERT INTO `orderitems` (`ItemID`, `OrderID`, `ProductID`, `quantity`, `unit_price`) VALUES
('ITEM66fcb7b4656af1f21765608107', 'ORD_c798f11ed3bcd2e21765608107', 'P00001', 1, 6.00),
('ITEMc1a0ab5a465df7aa1765609788', 'ORD_b0688c2ceab908fe1765609788', 'P00003', 1, 2.00);

-- --------------------------------------------------------

--
-- 表的结构 `payment`
--

CREATE TABLE `payment` (
  `PaymentID` char(36) NOT NULL,
  `OrderID` char(36) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` varchar(30) NOT NULL,
  `payment_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `payment`
--

INSERT INTO `payment` (`PaymentID`, `OrderID`, `amount`, `method`, `payment_date`) VALUES
('PAY_13926d63d1f796391765608107', 'ORD_c798f11ed3bcd2e21765608107', 6.50, 'Card', '2025-12-13 14:41:47'),
('PAY_93a85bcbb85561391765609788', 'ORD_b0688c2ceab908fe1765609788', 2.50, 'COD', '2025-12-13 15:09:48');

-- --------------------------------------------------------

--
-- 表的结构 `paymenthistory`
--

CREATE TABLE `paymenthistory` (
  `PaymentHistoryID` char(36) NOT NULL,
  `PaymentID` char(36) NOT NULL,
  `OrderID` char(36) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` varchar(30) NOT NULL,
  `action_type` varchar(30) NOT NULL,
  `changed_at` datetime NOT NULL DEFAULT current_timestamp(),
  `remark` varchar(255) DEFAULT NULL,
  `StaffID` char(36) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE `product` (
  `ProductID` varchar(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL CHECK (`stock_quantity` >= 0),
  `categories` varchar(100) DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`ProductID`, `name`, `description`, `price`, `stock_quantity`, `categories`, `ImageURL`) VALUES
('P00001', 'Chicken Rice', 'Fresh steamed chicken with rice', 6.50, 100, 'Chicken', NULL),
('P00002', 'Cheese Burger', 'Beef burger with cheese', 8.90, 40, 'Burgers', NULL),
('P00003', 'Iced Lemon Tea', 'Cold refreshing drink', 2.50, 99, 'Drinks', NULL),
('P00014', 'Noodle Soup', 'Hot noodle soup bowl with vegetables and seasoning.', 5.50, 39, 'Noodles', 'https://example.com/images/noodle_soup.jpg'),
('P00015', 'Fried Chicken', 'Crispy fried chicken with savory coating.', 5.00, 59, 'Chicken', 'https://example.com/images/fried_chicken.jpg'),
('P00016', 'Beef Burger', 'Grilled beef patty with lettuce, tomato, and cheese.', 9.50, 29, 'Burgers', 'https://example.com/images/beef_burger.jpg'),
('P00017', 'Vegetable Salad', 'Fresh mixed vegetables with a tangy dressing.', 4.50, 25, 'Salads', 'https://example.com/images/vegetable_salad.jpg'),
('P00018', 'Fish and Chips', 'Crispy fish fillet with golden fries.', 7.80, 19, 'Meals', 'https://example.com/images/fish_and_chips.jpg'),
('P00019', 'Fried Noodles', 'Stir-fried noodles with vegetables and soy sauce.', 6.20, 34, 'Noodles', 'https://example.com/images/fried_noodles.jpg'),
('P00020', 'Chocolate Cake', 'Rich chocolate cake with creamy frosting.', 3.90, 49, 'Desserts', 'https://example.com/images/chocolate_cake.jpg');

-- --------------------------------------------------------

--
-- 表的结构 `staff`
--

CREATE TABLE `staff` (
  `StaffID` varchar(10) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `staff`
--

INSERT INTO `staff` (`StaffID`, `Name`, `Phone`, `Role`) VALUES
('S00001', 'Admin One', '01122223333', 'admin'),
('S00002', 'Delivery Boy', '01788889999', 'delivery');

--
-- 转储表的索引
--

--
-- 表的索引 `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`CartID`),
  ADD UNIQUE KEY `uq_cart_customer` (`CustomerID`);

--
-- 表的索引 `cartitems`
--
ALTER TABLE `cartitems`
  ADD PRIMARY KEY (`ItemsID`),
  ADD UNIQUE KEY `uq_cart_product` (`CartID`,`ProductID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- 表的索引 `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`);

--
-- 表的索引 `deliveryinfo`
--
ALTER TABLE `deliveryinfo`
  ADD PRIMARY KEY (`DeliveryID`),
  ADD KEY `idx_delivery_order` (`OrderID`);

--
-- 表的索引 `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `idx_order_customer` (`CustomerID`),
  ADD KEY `idx_order_staff` (`StaffID`);

--
-- 表的索引 `orderhistory`
--
ALTER TABLE `orderhistory`
  ADD PRIMARY KEY (`HistoryID`),
  ADD KEY `idx_order_id` (`OrderID`);

--
-- 表的索引 `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`ItemID`),
  ADD KEY `idx_orderitems_order` (`OrderID`),
  ADD KEY `fk_orderitems_product` (`ProductID`);

--
-- 表的索引 `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `idx_payment_order` (`OrderID`);

--
-- 表的索引 `paymenthistory`
--
ALTER TABLE `paymenthistory`
  ADD PRIMARY KEY (`PaymentHistoryID`),
  ADD KEY `idx_payment_id` (`PaymentID`),
  ADD KEY `idx_order_id` (`OrderID`);

--
-- 表的索引 `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- 表的索引 `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`StaffID`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `cartitems`
--
ALTER TABLE `cartitems`
  MODIFY `ItemsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- 限制导出的表
--

--
-- 限制表 `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_customer` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE;

--
-- 限制表 `cartitems`
--
ALTER TABLE `cartitems`
  ADD CONSTRAINT `cartitems_ibfk_1` FOREIGN KEY (`CartID`) REFERENCES `cart` (`CartID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cartitems_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`) ON UPDATE CASCADE;

--
-- 限制表 `deliveryinfo`
--
ALTER TABLE `deliveryinfo`
  ADD CONSTRAINT `fk_delivery_order` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`) ON DELETE CASCADE;

--
-- 限制表 `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `fk_order_customer` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`) ON DELETE CASCADE;

--
-- 限制表 `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `fk_orderitems_order` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_orderitems_product` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- 限制表 `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_order` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
