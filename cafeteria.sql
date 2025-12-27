-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2025-12-27 08:49:28
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
  `status` enum('PENDING','READY_TO_PICKUP','DELIVERING','ARRIVE','COMPLETED','CANCELLED') NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `deliveryinfo`
--

INSERT INTO `deliveryinfo` (`DeliveryID`, `OrderID`, `receiver_name`, `receiver_phone`, `address`, `status`) VALUES
('DEL_061cd6e764b4457a1765821372', 'ORD_11b26029071654501765821372', 'saw', '0124411270', 'wdauhbwdauhkwdaki', 'COMPLETED'),
('DEL_08273cbc7ced1c781765826573', 'ORD_4b62a49a62a444901765826573', 'saw', '0124411270', 'bjhkwabdysuiabkoedch', 'PENDING'),
('DEL_0e1be4741fc66a1a1765824755', 'ORD_0c2458c94c10b2df1765824755', 'saw', '0124411270', 'waduyjgdauqgwjwadukg', 'COMPLETED'),
('DEL_0f9dc9993051ab4d1765821553', 'ORD_e2141cd80d5cbd751765821553', 'saw', '0124411270', 'wdaihdwauhkdwahiku', 'COMPLETED'),
('DEL_1782b4fe4da3b4051765609788', 'ORD_b0688c2ceab908fe1765609788', 'saw', '0124411270', 'huweaskdflahd', 'COMPLETED'),
('DEL_3a3ce5fe51a0fc091765608107', 'ORD_c798f11ed3bcd2e21765608107', 'saw', '0124411270', 'myaddressis best', 'CANCELLED'),
('DEL_3eaa80ec65eb81f21765795087', 'ORD_adaca6053bacbf7b1765795087', 'saw', '0124411270', 'dwawdauhgwdaihkwda', 'COMPLETED'),
('DEL_5e4c2bec60989cfa1765824774', 'ORD_7198cac06de8a8281765824774', 'saw', '0124411270', 'dwdjubybukjdwsaeknubwdesawjbuad', 'COMPLETED'),
('DEL_66d27afc74ddf66b1765819498', 'ORD_8499f42339f453b31765819498', 'saw', '0124411270', '2wgrjygefszcbv', 'CANCELLED'),
('DEL_7920444b004dfad51765796018', 'ORD_9de11c3a463294d81765796018', 'saw', '0124411270', 'dwadwawdajttyfjtfj', 'COMPLETED'),
('DEL_800e21e0d0cfea861765825231', 'ORD_b2f2b9e1463091871765825231', 'saw', '0124411270', 'weanbhudwabkjudwa', 'COMPLETED'),
('DEL_82cf667acb53ad6e1765823710', 'ORD_50f6bd97abbd225d1765823710', 'saw', '0124411270', 'YHBUWDJANIUHWDAKKJI', 'COMPLETED'),
('DEL_855560ae3d5e1bb71765819139', 'ORD_b890c476193c5aa01765819139', 'saw', '0124411270', '3wesffgredghfjhtr', 'COMPLETED'),
('DEL_9b4aed0a7dca7e531765826424', 'ORD_163655501f42b4771765826424', 'saw', '0124411270', 'dwauygbdwabygjesfhunegfsr', 'CANCELLED'),
('DEL_a13bc011300c4b0a1765825665', 'ORD_befb6c83dcb484df1765825665', 'saw', '0124411270', 'qwdsafesdrghthjf', 'CANCELLED'),
('DEL_b132c527663c7c5c1765817967', 'ORD_ded97737a0a353be1765817967', 'saw', '0124411270', 'yghjwsgjyuqsujg', 'CANCELLED'),
('DEL_b9b45e87061d0bfd1765826351', 'ORD_7a6000d1c51b39fa1765826351', 'saw', '0124411270', 'dwnuakdwabwadwa', 'CANCELLED'),
('DEL_c1370e30fc4a449f1765826398', 'ORD_941867e183a565191765826398', 'saw', '0124411270', 'buwdkajawqdvhgjwdabjhm', 'CANCELLED'),
('DEL_c7258212948d54cd1765795301', 'ORD_31a330535ca65bf01765795301', 'saw', '0124411270', 'dwefsfefeshrtfngvn', 'COMPLETED'),
('DEL_d8b299438b6847021765818080', 'ORD_8d69a6b1f9a704921765818080', 'saw', '0124411270', 'dwaukhavydwea', 'CANCELLED'),
('DEL_e031ca2fe27881151765821541', 'ORD_e2c7bf88446078a91765821541', 'saw', '0124411270', 'wsdijsweiknwdailn', 'COMPLETED'),
('DEL_f3c9a87defa898b51765784582', 'ORD_2afd50c0d712523b1765784582', 'saw', '0124411270', 'ndwiadwhaidw', 'COMPLETED');

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
  `status` enum('PENDING','CANCELLED','ACCEPTED','PREPARING','DELIVERING','COMPLETED','READY_TO_PICKUP') NOT NULL DEFAULT 'PENDING'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `order`
--

INSERT INTO `order` (`OrderID`, `CustomerID`, `StaffID`, `order_date`, `total_amount`, `status`) VALUES
('ORD_0c2458c94c10b2df1765824755', 'C00004', NULL, '2025-12-16 02:52:35', 14.50, 'COMPLETED'),
('ORD_11b26029071654501765821372', 'C00004', NULL, '2025-12-16 01:56:12', 14.50, 'COMPLETED'),
('ORD_163655501f42b4771765826424', 'C00004', NULL, '2025-12-16 03:20:24', 9.90, 'CANCELLED'),
('ORD_2afd50c0d712523b1765784582', 'C00004', NULL, '2025-12-15 15:43:02', 11.80, 'COMPLETED'),
('ORD_31a330535ca65bf01765795301', 'C00004', NULL, '2025-12-15 18:41:41', 11.80, 'COMPLETED'),
('ORD_4b62a49a62a444901765826573', 'C00004', NULL, '2025-12-16 03:22:53', 27.20, 'PENDING'),
('ORD_50f6bd97abbd225d1765823710', 'C00004', NULL, '2025-12-16 02:35:10', 11.80, 'COMPLETED'),
('ORD_7198cac06de8a8281765824774', 'C00004', NULL, '2025-12-16 02:52:54', 11.80, 'COMPLETED'),
('ORD_7a6000d1c51b39fa1765826351', 'C00004', NULL, '2025-12-16 03:19:11', 11.80, 'CANCELLED'),
('ORD_8499f42339f453b31765819498', 'C00004', NULL, '2025-12-16 01:24:58', 11.80, 'CANCELLED'),
('ORD_8d69a6b1f9a704921765818080', 'C00004', NULL, '2025-12-16 01:01:20', 14.50, 'CANCELLED'),
('ORD_941867e183a565191765826398', 'C00004', NULL, '2025-12-16 03:19:58', 11.80, 'CANCELLED'),
('ORD_9de11c3a463294d81765796018', 'C00004', NULL, '2025-12-15 18:53:38', 7.90, 'COMPLETED'),
('ORD_adaca6053bacbf7b1765795087', 'C00004', NULL, '2025-12-15 18:38:07', 6.80, 'COMPLETED'),
('ORD_b0688c2ceab908fe1765609788', 'C00004', 'S00001', '2025-12-13 15:09:48', 2.50, 'COMPLETED'),
('ORD_b2f2b9e1463091871765825231', 'C00004', NULL, '2025-12-16 03:00:31', 9.90, 'COMPLETED'),
('ORD_b890c476193c5aa01765819139', 'C00004', NULL, '2025-12-16 01:18:59', 11.80, 'COMPLETED'),
('ORD_befb6c83dcb484df1765825665', 'C00004', NULL, '2025-12-16 03:07:45', 14.50, 'CANCELLED'),
('ORD_c798f11ed3bcd2e21765608107', 'C00004', NULL, '2025-12-13 14:41:47', 6.50, 'CANCELLED'),
('ORD_ded97737a0a353be1765817967', 'C00004', NULL, '2025-12-16 00:59:27', 11.80, 'CANCELLED'),
('ORD_e2141cd80d5cbd751765821553', 'C00004', NULL, '2025-12-16 01:59:13', 11.80, 'COMPLETED'),
('ORD_e2c7bf88446078a91765821541', 'C00004', NULL, '2025-12-16 01:59:01', 9.90, 'COMPLETED');

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
('HIS001e900557e61be01765826398', 'ORD_941867e183a565191765826398', 'PENDING', NULL, '2025-12-16 03:19:58', 'Order placed by customer'),
('HIS070d6a70aa50aade1765821541', 'ORD_e2c7bf88446078a91765821541', 'PENDING', NULL, '2025-12-16 01:59:01', 'Order placed by customer'),
('HIS0a3f2f14dd30d4231765795087', 'ORD_adaca6053bacbf7b1765795087', 'PENDING', NULL, '2025-12-15 18:38:07', 'Order placed by customer'),
('HIS198b3284687014c01765824755', 'ORD_0c2458c94c10b2df1765824755', 'PENDING', NULL, '2025-12-16 02:52:35', 'Order placed by customer'),
('HIS3962025a579719931765817967', 'ORD_ded97737a0a353be1765817967', 'PENDING', NULL, '2025-12-16 00:59:27', 'Order placed by customer'),
('HIS45af40adf9ae60211765819498', 'ORD_8499f42339f453b31765819498', 'PENDING', NULL, '2025-12-16 01:24:58', 'Order placed by customer'),
('HIS50e232170bdf44671765826424', 'ORD_163655501f42b4771765826424', 'PENDING', NULL, '2025-12-16 03:20:24', 'Order placed by customer'),
('HIS698c9d337a34286c1765609788', 'ORD_b0688c2ceab908fe1765609788', 'PENDING', NULL, '2025-12-13 15:09:48', 'Order placed by customer'),
('HIS74e172513240fa5f1765818080', 'ORD_8d69a6b1f9a704921765818080', 'PENDING', NULL, '2025-12-16 01:01:20', 'Order placed by customer'),
('HIS7ebf80e55c2f64551765796018', 'ORD_9de11c3a463294d81765796018', 'PENDING', NULL, '2025-12-15 18:53:38', 'Order placed by customer'),
('HIS83b585e57a8ba6e91765608107', 'ORD_c798f11ed3bcd2e21765608107', 'PENDING', NULL, '2025-12-13 14:41:47', 'Order placed by customer'),
('HIS868431e47aaac8b01765784582', 'ORD_2afd50c0d712523b1765784582', 'PENDING', NULL, '2025-12-15 15:43:02', 'Order placed by customer'),
('HISacb466099edadb631765825665', 'ORD_befb6c83dcb484df1765825665', 'PENDING', NULL, '2025-12-16 03:07:45', 'Order placed by customer'),
('HISae4c9409f329e1581765823710', 'ORD_50f6bd97abbd225d1765823710', 'PENDING', NULL, '2025-12-16 02:35:10', 'Order placed by customer'),
('HISc01e51d2bdbb31d21765824774', 'ORD_7198cac06de8a8281765824774', 'PENDING', NULL, '2025-12-16 02:52:54', 'Order placed by customer'),
('HISca0f2597ee20b7101765819139', 'ORD_b890c476193c5aa01765819139', 'PENDING', NULL, '2025-12-16 01:18:59', 'Order placed by customer'),
('HISd3e670cff4a30d7b1765821553', 'ORD_e2141cd80d5cbd751765821553', 'PENDING', NULL, '2025-12-16 01:59:13', 'Order placed by customer'),
('HISdd40c86a42dd85321765826573', 'ORD_4b62a49a62a444901765826573', 'PENDING', NULL, '2025-12-16 03:22:53', 'Order placed by customer'),
('HISe0f2d45a0fa4dcfc1765826351', 'ORD_7a6000d1c51b39fa1765826351', 'PENDING', NULL, '2025-12-16 03:19:11', 'Order placed by customer'),
('HISe76ff9fdd1e243731765821372', 'ORD_11b26029071654501765821372', 'PENDING', NULL, '2025-12-16 01:56:12', 'Order placed by customer'),
('HISf11a44aa5000474d1765825231', 'ORD_b2f2b9e1463091871765825231', 'PENDING', NULL, '2025-12-16 03:00:31', 'Order placed by customer'),
('HISffef9ca5f1a1f7c71765795301', 'ORD_31a330535ca65bf01765795301', 'PENDING', NULL, '2025-12-15 18:41:41', 'Order placed by customer'),
('HIST_9ac00787', 'ORD_2afd50c0d712523b1765784582', 'PREPARING', 'S00001', '2025-12-15 16:43:54', 'Status changed from ACCEPTED to PREPARING'),
('HIS_20251213080914_121f3454', 'ORD_c798f11ed3bcd2e21765608107', 'CANCELLED', NULL, '2025-12-13 15:09:14', 'Order cancelled by customer'),
('HIS_20251213080956_71655d69', 'ORD_b0688c2ceab908fe1765609788', 'CANCELLED', NULL, '2025-12-13 15:09:56', 'Order cancelled by customer'),
('HIS_20251215094932_34f8ae35', 'ORD_2afd50c0d712523b1765784582', 'READY_TO_PICKUP', 'S00001', '2025-12-15 16:49:32', 'Order handed to delivery'),
('HIS_20251215095340_a185d22b', 'ORD_2afd50c0d712523b1765784582', 'ACCEPTED', 'S00001', '2025-12-15 16:53:40', 'Order accepted by admin'),
('HIS_20251215095410_7ec0f030', 'ORD_2afd50c0d712523b1765784582', 'PREPARING', 'S00001', '2025-12-15 16:54:10', 'Kitchen started preparation'),
('HIS_20251215095658_45ca446d', 'ORD_2afd50c0d712523b1765784582', 'READY_TO_PICKUP', 'S00001', '2025-12-15 16:56:58', 'Order handed to delivery'),
('HIS_20251215105405_ee9715a4', 'ORD_2afd50c0d712523b1765784582', 'ACCEPTED', 'S00001', '2025-12-15 17:54:05', 'Order accepted by admin'),
('HIS_20251215105414_6b1a9d4d', 'ORD_2afd50c0d712523b1765784582', 'PREPARING', 'S00001', '2025-12-15 17:54:14', 'Kitchen started preparation'),
('HIS_20251215105422_291cac7e', 'ORD_2afd50c0d712523b1765784582', 'READY_TO_PICKUP', 'S00001', '2025-12-15 17:54:22', 'Order handed to delivery'),
('HIS_20251215113913_cfc88b95', 'ORD_adaca6053bacbf7b1765795087', 'ACCEPTED', 'S00001', '2025-12-15 18:39:13', 'Order accepted by admin'),
('HIS_20251215113950_eaf3eb04', 'ORD_adaca6053bacbf7b1765795087', 'PREPARING', 'S00001', '2025-12-15 18:39:50', 'Kitchen started preparation'),
('HIS_20251215114003_3203adad', 'ORD_adaca6053bacbf7b1765795087', 'READY_TO_PICKUP', 'S00001', '2025-12-15 18:40:03', 'Order handed to delivery'),
('HIS_20251215114045_7e1b1c5a', 'ORD_adaca6053bacbf7b1765795087', 'DELIVERING', 'S00002', '2025-12-15 18:40:45', 'Order handed to delivery'),
('HIS_20251215114052_18d60718', 'ORD_adaca6053bacbf7b1765795087', 'COMPLETED', 'S00002', '2025-12-15 18:40:52', 'Order completed successfully'),
('HIS_20251215115031_635f613e', 'ORD_31a330535ca65bf01765795301', 'ACCEPTED', 'S00001', '2025-12-15 18:50:31', 'Order accepted by admin'),
('HIS_20251215115034_38a4b46a', 'ORD_31a330535ca65bf01765795301', 'READY_TO_PICKUP', 'S00001', '2025-12-15 18:50:34', 'Order handed to delivery'),
('HIS_20251215115034_3ffa9d0c', 'ORD_31a330535ca65bf01765795301', 'PREPARING', 'S00001', '2025-12-15 18:50:34', 'Kitchen started preparation'),
('HIS_20251215115049_c8e99e29', 'ORD_31a330535ca65bf01765795301', 'DELIVERING', 'S00002', '2025-12-15 18:50:49', 'Order handed to delivery'),
('HIS_20251215115050_e2e66b2e', 'ORD_31a330535ca65bf01765795301', 'COMPLETED', 'S00002', '2025-12-15 18:50:50', 'Order completed successfully'),
('HIS_20251215115356_6e61d430', 'ORD_9de11c3a463294d81765796018', 'ACCEPTED', 'S00001', '2025-12-15 18:53:56', 'Order accepted by admin'),
('HIS_20251215115358_2d5b0f5a', 'ORD_9de11c3a463294d81765796018', 'PREPARING', 'S00001', '2025-12-15 18:53:58', 'Kitchen started preparation'),
('HIS_20251215115400_17a9fbe0', 'ORD_9de11c3a463294d81765796018', 'READY_TO_PICKUP', 'S00001', '2025-12-15 18:54:00', 'Order handed to delivery'),
('HIS_20251215115409_039d8d45', 'ORD_9de11c3a463294d81765796018', 'DELIVERING', 'S00002', '2025-12-15 18:54:09', 'Pick up by Rider'),
('HIS_20251215115412_e1afe1f8', 'ORD_9de11c3a463294d81765796018', 'COMPLETED', 'S00002', '2025-12-15 18:54:12', 'Order completed successfully'),
('HIS_20251215175930_2d6d4d12', 'ORD_ded97737a0a353be1765817967', 'CANCELLED', NULL, '2025-12-16 00:59:30', 'Order cancelled by customer'),
('HIS_20251215180123_f3f53a87', 'ORD_8d69a6b1f9a704921765818080', 'CANCELLED', NULL, '2025-12-16 01:01:23', 'Order cancelled by customer'),
('HIS_20251215181925_73bfe406', 'ORD_b890c476193c5aa01765819139', 'ACCEPTED', 'S00001', '2025-12-16 01:19:25', 'Order accepted by admin'),
('HIS_20251215181926_ce5ca5eb', 'ORD_b890c476193c5aa01765819139', 'PREPARING', 'S00001', '2025-12-16 01:19:26', 'Kitchen started preparation'),
('HIS_20251215181926_d8bbf3d9', 'ORD_b890c476193c5aa01765819139', 'READY_TO_PICKUP', 'S00001', '2025-12-16 01:19:26', 'Order handed to delivery'),
('HIS_20251215181938_99d4d236', 'ORD_b890c476193c5aa01765819139', 'DELIVERING', 'S00002', '2025-12-16 01:19:38', 'Pick up by Rider'),
('HIS_20251215181939_750e04c4', 'ORD_b890c476193c5aa01765819139', 'COMPLETED', 'S00002', '2025-12-16 01:19:39', 'Your Meals Have Arrive!'),
('HIS_20251215182502_c967a34f', 'ORD_8499f42339f453b31765819498', 'CANCELLED', NULL, '2025-12-16 01:25:02', 'Order cancelled by customer'),
('HIS_20251215185640_4a79d5bb', 'ORD_11b26029071654501765821372', 'ACCEPTED', 'S00001', '2025-12-16 01:56:40', 'Order accepted by admin'),
('HIS_20251215185650_dd76aa92', 'ORD_11b26029071654501765821372', 'PREPARING', 'S00001', '2025-12-16 01:56:50', 'Kitchen started preparation'),
('HIS_20251215185653_f4601f08', 'ORD_11b26029071654501765821372', 'READY_TO_PICKUP', 'S00001', '2025-12-16 01:56:53', 'Order handed to delivery'),
('HIS_20251215185728_dba7c79c', 'ORD_11b26029071654501765821372', 'DELIVERING', 'S00002', '2025-12-16 01:57:28', 'Pick up by Rider'),
('HIS_20251215185733_e4083eb5', 'ORD_11b26029071654501765821372', 'COMPLETED', 'S00002', '2025-12-16 01:57:33', 'Your Meals Have Arrive!'),
('HIS_20251215194313_43b0d22c', 'ORD_e2c7bf88446078a91765821541', 'ACCEPTED', 'S00001', '2025-12-16 02:43:13', 'Order accepted by admin'),
('HIS_20251215194315_c40e2a36', 'ORD_e2141cd80d5cbd751765821553', 'ACCEPTED', 'S00001', '2025-12-16 02:43:15', 'Order accepted by admin'),
('HIS_20251215194317_786af5d7', 'ORD_50f6bd97abbd225d1765823710', 'ACCEPTED', 'S00001', '2025-12-16 02:43:17', 'Order accepted by admin'),
('HIS_20251215194319_85145271', 'ORD_e2c7bf88446078a91765821541', 'PREPARING', 'S00001', '2025-12-16 02:43:19', 'Kitchen started preparation'),
('HIS_20251215194321_242f8395', 'ORD_e2141cd80d5cbd751765821553', 'PREPARING', 'S00001', '2025-12-16 02:43:21', 'Kitchen started preparation'),
('HIS_20251215194323_34f32d6b', 'ORD_50f6bd97abbd225d1765823710', 'PREPARING', 'S00001', '2025-12-16 02:43:23', 'Kitchen started preparation'),
('HIS_20251215194325_3e3cba4f', 'ORD_e2c7bf88446078a91765821541', 'READY_TO_PICKUP', 'S00001', '2025-12-16 02:43:25', 'Order handed to delivery'),
('HIS_20251215194327_80a9c7b8', 'ORD_e2141cd80d5cbd751765821553', 'READY_TO_PICKUP', 'S00001', '2025-12-16 02:43:27', 'Order handed to delivery'),
('HIS_20251215194329_d038f4a6', 'ORD_50f6bd97abbd225d1765823710', 'READY_TO_PICKUP', 'S00001', '2025-12-16 02:43:29', 'Order handed to delivery'),
('HIS_20251215194434_171d8c75', 'ORD_e2c7bf88446078a91765821541', 'DELIVERING', 'S00002', '2025-12-16 02:44:34', 'Pick up by Rider'),
('HIS_20251215194436_ccb184b6', 'ORD_50f6bd97abbd225d1765823710', 'DELIVERING', 'S00002', '2025-12-16 02:44:36', 'Pick up by Rider'),
('HIS_20251215194440_8b20ed62', 'ORD_e2141cd80d5cbd751765821553', 'DELIVERING', 'S00002', '2025-12-16 02:44:40', 'Pick up by Rider'),
('HIS_20251215194443_6ccc37b0', 'ORD_50f6bd97abbd225d1765823710', 'COMPLETED', 'S00002', '2025-12-16 02:44:43', 'Your Meals Have Arrived!'),
('HIS_20251215194447_18243707', 'ORD_e2141cd80d5cbd751765821553', 'COMPLETED', 'S00002', '2025-12-16 02:44:47', 'Your Meals Have Arrived!'),
('HIS_20251215194450_8a01eb5e', 'ORD_e2c7bf88446078a91765821541', 'ARRIVE', 'S00002', '2025-12-16 02:44:50', 'Rider has arrived at destination. Waiting for payment.'),
('HIS_20251215195147_ec115a46', 'ORD_e2c7bf88446078a91765821541', 'COMPLETED', 'S00002', '2025-12-16 02:51:47', 'Payment received. Order completed successfully.'),
('HIS_20251215200100_08b35709', 'ORD_0c2458c94c10b2df1765824755', 'ACCEPTED', 'S00001', '2025-12-16 03:01:00', 'Order accepted by admin'),
('HIS_20251215200101_23d131d5', 'ORD_b2f2b9e1463091871765825231', 'ACCEPTED', 'S00001', '2025-12-16 03:01:01', 'Order accepted by admin'),
('HIS_20251215200101_81044c6a', 'ORD_7198cac06de8a8281765824774', 'ACCEPTED', 'S00001', '2025-12-16 03:01:01', 'Order accepted by admin'),
('HIS_20251215200102_375d161f', 'ORD_0c2458c94c10b2df1765824755', 'READY_TO_PICKUP', 'S00001', '2025-12-16 03:01:02', 'Order handed to delivery'),
('HIS_20251215200102_e775e251', 'ORD_0c2458c94c10b2df1765824755', 'PREPARING', 'S00001', '2025-12-16 03:01:02', 'Kitchen started preparation'),
('HIS_20251215200103_7ff9e03b', 'ORD_7198cac06de8a8281765824774', 'PREPARING', 'S00001', '2025-12-16 03:01:03', 'Kitchen started preparation'),
('HIS_20251215200104_2733d296', 'ORD_b2f2b9e1463091871765825231', 'READY_TO_PICKUP', 'S00001', '2025-12-16 03:01:04', 'Order handed to delivery'),
('HIS_20251215200104_41276a3d', 'ORD_7198cac06de8a8281765824774', 'READY_TO_PICKUP', 'S00001', '2025-12-16 03:01:04', 'Order handed to delivery'),
('HIS_20251215200104_b6ff999d', 'ORD_b2f2b9e1463091871765825231', 'PREPARING', 'S00001', '2025-12-16 03:01:04', 'Kitchen started preparation'),
('HIS_20251215200115_f872ca8d', 'ORD_b2f2b9e1463091871765825231', 'DELIVERING', 'S00002', '2025-12-16 03:01:15', 'Pick up by Rider'),
('HIS_20251215200116_30d65f8b', 'ORD_7198cac06de8a8281765824774', 'DELIVERING', 'S00002', '2025-12-16 03:01:16', 'Pick up by Rider'),
('HIS_20251215200117_090f6bff', 'ORD_0c2458c94c10b2df1765824755', 'DELIVERING', 'S00002', '2025-12-16 03:01:17', 'Pick up by Rider'),
('HIS_20251215200118_ce0333c8', 'ORD_0c2458c94c10b2df1765824755', 'ARRIVE', 'S00002', '2025-12-16 03:01:18', 'Rider has arrived at destination. Waiting for payment.'),
('HIS_20251215200119_3adb924b', 'ORD_7198cac06de8a8281765824774', 'COMPLETED', 'S00002', '2025-12-16 03:01:19', 'Delivery completed successfully!'),
('HIS_20251215200120_272f3620', 'ORD_b2f2b9e1463091871765825231', 'COMPLETED', 'S00002', '2025-12-16 03:01:20', 'Delivery completed successfully!'),
('HIS_20251215200124_91a53ca6', 'ORD_0c2458c94c10b2df1765824755', 'COMPLETED', 'S00002', '2025-12-16 03:01:24', 'Payment received. Order completed successfully.'),
('HIS_20251215201849_b187afa4', 'ORD_befb6c83dcb484df1765825665', 'CANCELLED', NULL, '2025-12-16 03:18:49', 'Order cancelled by customer'),
('HIS_20251215202041_c5e58a61', 'ORD_7a6000d1c51b39fa1765826351', 'CANCELLED', NULL, '2025-12-16 03:20:41', 'Order cancelled by customer'),
('HIS_20251215202043_c6b965fa', 'ORD_941867e183a565191765826398', 'CANCELLED', NULL, '2025-12-16 03:20:43', 'Order cancelled by customer'),
('HIS_20251215202045_589b722a', 'ORD_163655501f42b4771765826424', 'CANCELLED', NULL, '2025-12-16 03:20:45', 'Order cancelled by customer'),
('HIS_693eb573c917a', 'ORD_b0688c2ceab908fe1765609788', 'ACCEPTED', 'S00001', '2025-12-14 21:02:43', 'Status changed from PENDING to ACCEPTED'),
('HIS_693eb5764bb65', 'ORD_b0688c2ceab908fe1765609788', 'PREPARING', 'S00001', '2025-12-14 21:02:46', 'Status changed from ACCEPTED to PREPARING'),
('HIS_693eb5772dfe8', 'ORD_b0688c2ceab908fe1765609788', 'DELIVERING', 'S00001', '2025-12-14 21:02:47', 'Status changed from PREPARING to DELIVERING'),
('HIS_693eb57816aa7', 'ORD_b0688c2ceab908fe1765609788', 'COMPLETED', 'S00001', '2025-12-14 21:02:48', 'Status changed from DELIVERING to COMPLETED'),
('HIS_693eb604b289a', 'ORD_b0688c2ceab908fe1765609788', 'ACCEPTED', 'S00001', '2025-12-14 21:05:08', 'Status changed from PENDING to ACCEPTED'),
('HIS_693eb6052cb46', 'ORD_b0688c2ceab908fe1765609788', 'PREPARING', 'S00001', '2025-12-14 21:05:09', 'Status changed from ACCEPTED to PREPARING'),
('HIS_693eb605ad5d1', 'ORD_b0688c2ceab908fe1765609788', 'DELIVERING', 'S00001', '2025-12-14 21:05:09', 'Status changed from PREPARING to DELIVERING'),
('HIS_693eb60666a4b', 'ORD_b0688c2ceab908fe1765609788', 'COMPLETED', 'S00001', '2025-12-14 21:05:10', 'Status changed from DELIVERING to COMPLETED'),
('HIS_693eb6ce5854f', 'ORD_b0688c2ceab908fe1765609788', 'PREPARING', 'S00001', '2025-12-14 21:08:30', 'Status changed from ACCEPTED to PREPARING'),
('HIS_693eb6d0a2f6d', 'ORD_b0688c2ceab908fe1765609788', 'DELIVERING', 'S00001', '2025-12-14 21:08:32', 'Status changed from PREPARING to DELIVERING'),
('HIS_693eb6d240561', 'ORD_b0688c2ceab908fe1765609788', 'COMPLETED', 'S00001', '2025-12-14 21:08:34', 'Status changed from DELIVERING to COMPLETED'),
('HIS_693eb960841af', 'ORD_b0688c2ceab908fe1765609788', 'ACCEPTED', 'S00001', '2025-12-14 21:19:28', 'Order accepted by admin'),
('HIS_693eb96ac1195', 'ORD_b0688c2ceab908fe1765609788', 'PREPARING', 'S00001', '2025-12-14 21:19:38', 'Kitchen started preparation'),
('HIS_693eb97288487', 'ORD_b0688c2ceab908fe1765609788', 'DELIVERING', 'S00001', '2025-12-14 21:19:46', 'Order handed to delivery'),
('HIS_693eb978b511b', 'ORD_b0688c2ceab908fe1765609788', 'COMPLETED', 'S00001', '2025-12-14 21:19:52', 'Order completed successfully');

-- --------------------------------------------------------

--
-- 表的结构 `orderitems`
--

CREATE TABLE `orderitems` (
  `ItemID` char(36) NOT NULL,
  `OrderID` char(36) NOT NULL,
  `ProductID` varchar(36) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `orderitems`
--

INSERT INTO `orderitems` (`ItemID`, `OrderID`, `ProductID`, `quantity`, `unit_price`) VALUES
('ITEM012ca8a10ed5f6fd1765817967', 'ORD_ded97737a0a353be1765817967', 'PROD_003', 1, 11.00),
('ITEM0571e24f0972d7df1765784582', 'ORD_2afd50c0d712523b1765784582', 'PROD_003', 1, 11.00),
('ITEM10a7a292f373b18c1765825231', 'ORD_b2f2b9e1463091871765825231', 'PROD_004', 1, 9.00),
('ITEM23c6fdac01917fba1765824755', 'ORD_0c2458c94c10b2df1765824755', 'PROD_002', 1, 14.00),
('ITEM3d03d6dd93fa8d5a1765826573', 'ORD_4b62a49a62a444901765826573', 'PROD_001', 1, 12.00),
('ITEM414c9437b2032dec1765826573', 'ORD_4b62a49a62a444901765826573', 'PROD_003', 1, 11.00),
('ITEM4ff8fb3a82c2d0ff1765826398', 'ORD_941867e183a565191765826398', 'PROD_003', 1, 11.00),
('ITEM5109d72e93e7b3071765825665', 'ORD_befb6c83dcb484df1765825665', 'PROD_002', 1, 14.00),
('ITEM5d368cf3f447c5071765819139', 'ORD_b890c476193c5aa01765819139', 'PROD_003', 1, 11.00),
('ITEM73aa621b22f01bcd1765819498', 'ORD_8499f42339f453b31765819498', 'PROD_003', 1, 11.00),
('ITEM8dfae2c0ed16d53a1765821372', 'ORD_11b26029071654501765821372', 'PROD_002', 1, 14.00),
('ITEM9ac1acda6df702521765823710', 'ORD_50f6bd97abbd225d1765823710', 'PROD_003', 1, 11.00),
('ITEM9b8558913dc18ee91765821553', 'ORD_e2141cd80d5cbd751765821553', 'PROD_003', 1, 11.00),
('ITEM9f8dad3149dd2a541765795301', 'ORD_31a330535ca65bf01765795301', 'PROD_003', 1, 11.00),
('ITEMb0592bbef54253211765826424', 'ORD_163655501f42b4771765826424', 'PROD_004', 1, 9.00),
('ITEMb1afcaa3e9cb64041765826351', 'ORD_7a6000d1c51b39fa1765826351', 'PROD_003', 1, 11.00),
('ITEMbdc32dceddcd8c3e1765824774', 'ORD_7198cac06de8a8281765824774', 'PROD_003', 1, 11.00),
('ITEMc39e83721d098d861765796018', 'ORD_9de11c3a463294d81765796018', 'PROD_009', 1, 7.00),
('ITEMd66f3058299ddfd21765826573', 'ORD_4b62a49a62a444901765826573', 'PROD_007', 1, 2.00),
('ITEMd7481cd313345db91765818080', 'ORD_8d69a6b1f9a704921765818080', 'PROD_002', 1, 14.00),
('ITEMe22cfc41280825761765795087', 'ORD_adaca6053bacbf7b1765795087', 'PROD_008', 1, 6.00),
('ITEMf33c8ba095ed4a641765821541', 'ORD_e2c7bf88446078a91765821541', 'PROD_004', 1, 9.00);

-- --------------------------------------------------------

--
-- 表的结构 `payment`
--

CREATE TABLE `payment` (
  `PaymentID` char(36) NOT NULL,
  `OrderID` char(36) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` varchar(30) NOT NULL,
  `account_last4` varchar(4) DEFAULT NULL COMMENT 'Last 4 digits of card/account number',
  `payment_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `payment`
--

INSERT INTO `payment` (`PaymentID`, `OrderID`, `amount`, `method`, `account_last4`, `payment_date`) VALUES
('PAY_0d60afebba02bf511765796018', 'ORD_9de11c3a463294d81765796018', 7.90, 'COD', NULL, '2025-12-15 18:53:38'),
('PAY_13926d63d1f796391765608107', 'ORD_c798f11ed3bcd2e21765608107', 6.50, 'Card', NULL, '2025-12-13 14:41:47'),
('PAY_2a218614b5e4095b1765826424', 'ORD_163655501f42b4771765826424', 9.90, 'Online Banking - Public Bank', '2654', '2025-12-16 03:20:24'),
('PAY_32a24f7f291291061765826573', 'ORD_4b62a49a62a444901765826573', 27.20, 'COD', NULL, '2025-12-16 03:22:53'),
('PAY_470ad8cb2d56ebd81765823710', 'ORD_50f6bd97abbd225d1765823710', 11.80, 'Online Banking - Maybank', '****', '2025-12-16 02:35:10'),
('PAY_4dd614a2c12f426b1765818080', 'ORD_8d69a6b1f9a704921765818080', 14.50, 'COD', NULL, '2025-12-16 01:01:20'),
('PAY_54b9e9d5292b4c531765819139', 'ORD_b890c476193c5aa01765819139', 11.80, 'COD', NULL, '2025-12-16 01:18:59'),
('PAY_54c2c3964760a60a1765824755', 'ORD_0c2458c94c10b2df1765824755', 14.50, 'COD', NULL, '2025-12-16 02:52:35'),
('PAY_56d2c6b51ad018d11765825665', 'ORD_befb6c83dcb484df1765825665', 14.50, 'COD', NULL, '2025-12-16 03:07:45'),
('PAY_732f0775da68a25b1765817967', 'ORD_ded97737a0a353be1765817967', 11.80, 'COD', NULL, '2025-12-16 00:59:27'),
('PAY_73334dc406e7e9bc1765821541', 'ORD_e2c7bf88446078a91765821541', 9.90, 'COD', NULL, '2025-12-16 01:59:01'),
('PAY_7de9dcaf43b0f8251765819498', 'ORD_8499f42339f453b31765819498', 11.80, 'COD', NULL, '2025-12-16 01:24:58'),
('PAY_84674c759f7e74721765821372', 'ORD_11b26029071654501765821372', 14.50, 'COD', NULL, '2025-12-16 01:56:12'),
('PAY_93a85bcbb85561391765609788', 'ORD_b0688c2ceab908fe1765609788', 2.50, 'COD', NULL, '2025-12-13 15:09:48'),
('PAY_9bdb02659d8befd21765824774', 'ORD_7198cac06de8a8281765824774', 11.80, 'Online Banking - CIMB Bank', '****', '2025-12-16 02:52:54'),
('PAY_b967b3cea325bcfe1765784582', 'ORD_2afd50c0d712523b1765784582', 11.80, 'COD', NULL, '2025-12-15 15:43:02'),
('PAY_bafd9725eefeecc31765821553', 'ORD_e2141cd80d5cbd751765821553', 11.80, 'Card', NULL, '2025-12-16 01:59:13'),
('PAY_d0625f40903093cf1765826398', 'ORD_941867e183a565191765826398', 11.80, 'Card', '6618', '2025-12-16 03:19:58'),
('PAY_d1b7b9cbddf6ad0d1765826351', 'ORD_7a6000d1c51b39fa1765826351', 11.80, 'COD', NULL, '2025-12-16 03:19:11'),
('PAY_f275266ca0b9731a1765795087', 'ORD_adaca6053bacbf7b1765795087', 6.80, 'COD', NULL, '2025-12-15 18:38:07'),
('PAY_f977b7828328ae111765825231', 'ORD_b2f2b9e1463091871765825231', 9.90, 'Card', '4571', '2025-12-16 03:00:31'),
('PAY_fcb5402dcfb80f311765795301', 'ORD_31a330535ca65bf01765795301', 11.80, 'COD', NULL, '2025-12-15 18:41:41'),
('REF__20251215202043_9b4d065c', 'ORD_941867e183a565191765826398', 11.80, 'Refund - Card', '6618', '2025-12-16 03:20:43'),
('REF__20251215202045_b813029e', 'ORD_163655501f42b4771765826424', 9.90, 'Refund - Online Banking - Publ', '2654', '2025-12-16 03:20:45');

-- --------------------------------------------------------

--
-- 表的结构 `paymenthistory`
--

CREATE TABLE `paymenthistory` (
  `HistoryID` varchar(50) NOT NULL,
  `PaymentID` varchar(50) NOT NULL,
  `OrderID` varchar(50) NOT NULL,
  `transaction_type` enum('PAYMENT','REFUND') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` varchar(50) DEFAULT NULL,
  `account_last4` varchar(4) DEFAULT NULL,
  `status` enum('SUCCESS','PENDING','FAILED','REFUNDED') DEFAULT 'SUCCESS',
  `transaction_date` datetime DEFAULT current_timestamp(),
  `remark` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `paymenthistory`
--

INSERT INTO `paymenthistory` (`HistoryID`, `PaymentID`, `OrderID`, `transaction_type`, `amount`, `method`, `account_last4`, `status`, `transaction_date`, `remark`) VALUES
('PHIST_8c20ba71a20f631d1765826424', 'PAY_2a218614b5e4095b1765826424', 'ORD_163655501f42b4771765826424', 'PAYMENT', 9.90, 'Online Banking - Public Bank', '2654', 'SUCCESS', '2025-12-16 03:20:24', 'Payment received via Online Banking'),
('PHIST_d1996a588eed33ab1765826398', 'PAY_d0625f40903093cf1765826398', 'ORD_941867e183a565191765826398', 'PAYMENT', 11.80, 'Card', '6618', 'SUCCESS', '2025-12-16 03:19:58', 'Payment received via Card'),
('PHIST__20251215202043_0bde349e', 'REF__20251215202043_9b4d065c', 'ORD_941867e183a565191765826398', 'REFUND', 11.80, 'Refund - Card', '6618', 'SUCCESS', '2025-12-16 03:20:43', 'Refund issued for cancelled order - Original payment method: Card'),
('PHIST__20251215202045_1915e1ae', 'REF__20251215202045_b813029e', 'ORD_163655501f42b4771765826424', 'REFUND', 9.90, 'Refund - Online Banking - Public Bank', '2654', 'SUCCESS', '2025-12-16 03:20:45', 'Refund issued for cancelled order - Original payment method: Online Banking - Public Bank');

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE `product` (
  `ProductID` varchar(36) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `categories` varchar(100) DEFAULT NULL,
  `ImageURL` varchar(255) DEFAULT NULL,
  `status` enum('ACTIVE','INACTIVE') DEFAULT 'ACTIVE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`ProductID`, `name`, `description`, `price`, `stock_quantity`, `categories`, `ImageURL`, `status`) VALUES
('PROD_001', 'Classic Beef Burger', 'Juicy grilled beef patty with fresh lettuce and cheese.', 12.90, 49, 'Burgers', 'images/burger_beef.jpg', 'ACTIVE'),
('PROD_002', 'Chicken Chop', 'Grilled chicken chop served with black pepper sauce.', 14.50, 38, 'Chicken', 'images/chicken_chop.jpg', 'ACTIVE'),
('PROD_003', 'Spaghetti Bolognese', 'Italian spaghetti with rich beef bolognese sauce.', 11.80, 23, 'Meals', 'images/spaghetti.jpg', 'ACTIVE'),
('PROD_004', 'Fried Chicken Wings', 'Crispy fried chicken wings (6 pcs).', 9.90, 58, 'Chicken', 'images/chicken_wings.jpg', 'ACTIVE'),
('PROD_005', 'Cheese Burger', 'Classic burger with melted cheese and special sauce.', 10.90, 45, 'Burgers', 'images/cheese_burger.jpg', 'ACTIVE'),
('PROD_006', 'Caesar Salad', 'a side of green', 100.00, 5, 'Salads', 'images/caesar_salad.jpg', 'INACTIVE'),
('PROD_007', 'Iced Lemon Tea', 'Refreshing iced lemon tea.', 2.50, 99, 'Drinks', 'images/iced_lemon_tea.jpg', 'ACTIVE'),
('PROD_008', 'Chocolate Cake', 'Rich and moist chocolate cake slice.', 6.80, 19, 'Desserts', 'images/chocolate_cake.jpg', 'ACTIVE'),
('PROD_009', 'Fried Rice', 'Traditional fried rice with egg and vegetables.', 7.90, 69, 'Meals', 'images/fried_rice.jpg', 'ACTIVE'),
('PROD_010', 'Mineral Water', 'Bottled mineral water 500ml.', 1.50, 200, 'Drinks', 'images/mineral_water.jpg', 'ACTIVE'),
('PROD_693ec6fdac6aa', 'test', 'tester', 1.00, 1, '', NULL, 'ACTIVE'),
('PROD_693ec8b567e61', 'Nooodles', 'Longggggggggggggg Noodle', 100.00, 100, 'Noodles', NULL, 'ACTIVE'),
('PROD_693ec9992e396', 'lanciao', 'big lanciao', 100.00, 4, 'apalanciao', NULL, 'ACTIVE');

-- --------------------------------------------------------

--
-- 表的结构 `staff`
--

CREATE TABLE `staff` (
  `StaffID` varchar(10) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `Role` varchar(50) DEFAULT NULL,
  `Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 转存表中的数据 `staff`
--

INSERT INTO `staff` (`StaffID`, `Name`, `Phone`, `Role`, `Password`) VALUES
('S00001', 'Admin One', '01122223333', 'ADMIN', '$2y$10$faAkh3wYVs2Hhu4w1D6UaejBsZ3UuHHSTQd584iLt/xStcUg3urOi'),
('S00002', 'Delivery Boy', '01788889999', 'RIDER', '$2y$10$faAkh3wYVs2Hhu4w1D6UaejBsZ3UuHHSTQd584iLt/xStcUg3urOi');

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
  ADD KEY `idx_orderitems_product` (`ProductID`);

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
  ADD PRIMARY KEY (`HistoryID`),
  ADD KEY `idx_payment` (`PaymentID`),
  ADD KEY `idx_order` (`OrderID`),
  ADD KEY `idx_date` (`transaction_date`);

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
  MODIFY `ItemsID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

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
  ADD CONSTRAINT `fk_orderitems_product` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- 限制表 `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `fk_payment_order` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`) ON DELETE CASCADE;

--
-- 限制表 `paymenthistory`
--
ALTER TABLE `paymenthistory`
  ADD CONSTRAINT `paymenthistory_ibfk_1` FOREIGN KEY (`PaymentID`) REFERENCES `payment` (`PaymentID`) ON DELETE CASCADE,
  ADD CONSTRAINT `paymenthistory_ibfk_2` FOREIGN KEY (`OrderID`) REFERENCES `order` (`OrderID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
