-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2025 at 10:05 PM
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
-- Database: `se7entechnet_contractnew`
--

-- --------------------------------------------------------

--
-- Table structure for table `task_labels_tasks`
--

CREATE TABLE `task_labels_tasks` (
  `id` int(11) NOT NULL,
  `id_task_label` int(11) NOT NULL,
  `id_task` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_labels_tasks`
--

INSERT INTO `task_labels_tasks` (`id`, `id_task_label`, `id_task`) VALUES
(28, 14, 179),
(30, 14, 180),
(33, 14, 181),
(34, 14, 183),
(36, 14, 184),
(37, 14, 190),
(38, 14, 193),
(39, 14, 194),
(41, 14, 196),
(45, 17, 198),
(46, 17, 200),
(49, 14, 202),
(51, 17, 201),
(52, 14, 203),
(53, 16, 204),
(61, 11, 195),
(72, 17, 211),
(83, 18, 210),
(84, 18, 215),
(87, 17, 216),
(88, 18, 207),
(91, 18, 212),
(95, 14, 217),
(101, 16, 220),
(102, 18, 220),
(107, 16, 222),
(108, 18, 222),
(119, 17, 224),
(121, 18, 219),
(128, 18, 213),
(129, 16, 221),
(130, 18, 221),
(131, 16, 223),
(132, 18, 223),
(137, 18, 225),
(139, 18, 226),
(140, 16, 229),
(141, 17, 230),
(142, 18, 227),
(143, 18, 228),
(144, 18, 214),
(145, 17, 231),
(146, 17, 232),
(147, 14, 233),
(148, 17, 234),
(149, 18, 235),
(150, 18, 236),
(151, 18, 237),
(152, 16, 209),
(153, 16, 208),
(154, 16, 206),
(155, 16, 205),
(160, 16, 240),
(162, 16, 239),
(163, 18, 242),
(164, 16, 241),
(165, 16, 243),
(166, 16, 244),
(167, 16, 245),
(168, 16, 246),
(170, 18, 248),
(171, 18, 247),
(172, 18, 249),
(173, 18, 250),
(174, 18, 251),
(175, 18, 252),
(178, 18, 255),
(179, 18, 254),
(180, 18, 253),
(181, 18, 256),
(182, 16, 257),
(183, 14, 258),
(184, 18, 262),
(186, 14, 264),
(187, 14, 265),
(188, 14, 266),
(189, 14, 267),
(190, 14, 268),
(191, 14, 269),
(192, 17, 272),
(193, 16, 273),
(194, 16, 274),
(195, 16, 276),
(196, 18, 277),
(197, 17, 279),
(198, 14, 280),
(200, 11, 238),
(201, 17, 282),
(202, 18, 283),
(203, 18, 284),
(204, 14, 285),
(205, 14, 286),
(206, 18, 287),
(207, 18, 288),
(208, 18, 289),
(209, 18, 290),
(210, 18, 291),
(211, 18, 292),
(212, 14, 293),
(213, 17, 294),
(214, 17, 296),
(215, 14, 297),
(216, 14, 299),
(217, 14, 301),
(218, 17, 302),
(219, 17, 304),
(221, 14, 305),
(222, 14, 306),
(223, 18, 307),
(224, 17, 308),
(225, 17, 309),
(226, 14, 310),
(227, 17, 311),
(228, 17, 312),
(230, 14, 314),
(231, 14, 313),
(232, 17, 315),
(233, 17, 316),
(234, 14, 317),
(235, 14, 318),
(236, 14, 319),
(237, 14, 320),
(238, 14, 321),
(239, 17, 322),
(240, 17, 323),
(241, 21, 324),
(242, 14, 325),
(244, 17, 326),
(245, 14, 328),
(246, 14, 329);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task_labels_tasks`
--
ALTER TABLE `task_labels_tasks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task_labels_tasks`
--
ALTER TABLE `task_labels_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
