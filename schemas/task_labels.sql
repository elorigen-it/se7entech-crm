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
-- Table structure for table `task_labels`
--

CREATE TABLE `task_labels` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `background_color` varchar(45) NOT NULL,
  `text_color` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task_labels`
--

INSERT INTO `task_labels` (`id`, `name`, `background_color`, `text_color`) VALUES
(11, 'PROJECT MANAGER (OPERACIONES)', '#337ab7', '#ffffff'),
(12, 'PROJECT MANAGER (COMUNICACIÓN)', '#2acb85', '#ffffff'),
(14, 'DISEÑO GRÁFICO ', '#b7a134', '#ffffff'),
(16, 'COPYWRITE / CREADOR DE CONTENIDO', '#2c9ea0', '#ffffff'),
(17, 'EDITOR DE VIDEOS ', '#4b99dd', '#ffffff'),
(18, 'COMMUNITY MANAGER (PAOLA)', '#d96e54', '#ffffff'),
(21, 'PROJECT DE NUBES ', '#233fc7', '#ffffff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task_labels`
--
ALTER TABLE `task_labels`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task_labels`
--
ALTER TABLE `task_labels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
