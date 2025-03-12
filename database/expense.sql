-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2025 at 07:05 AM
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
-- Database: `expense`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('expense','investment') NOT NULL DEFAULT 'expense'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `user_id`, `name`, `type`) VALUES
(14, 21, 'food', 'expense'),
(15, 21, 'sip', 'investment'),
(16, 21, 'The Maroon Suit', 'expense'),
(17, 21, 'stokes ', 'investment');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `item` varchar(255) NOT NULL,
  `price` float NOT NULL,
  `details` text NOT NULL,
  `expense_date` date NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`id`, `category_id`, `item`, `price`, `details`, `expense_date`, `added_by`) VALUES
(11, 14, '3', 0, 'adg', '2025-03-10', 21),
(12, 16, '12', 12344, 'wedding clothes ', '2025-03-11', 21);

-- --------------------------------------------------------

--
-- Table structure for table `investment`
--

CREATE TABLE `investment` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `item` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `details` text DEFAULT NULL,
  `investment_date` date NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `investment`
--

INSERT INTO `investment` (`id`, `category_id`, `item`, `price`, `details`, `investment_date`, `added_by`) VALUES
(2, 15, 'fhfgh', 5.00, 'fgjghjyk', '2025-03-03', 21),
(3, 17, '2', 500.00, 'tcs', '2025-03-10', 21);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` text NOT NULL,
  `role` enum('Admin','User') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `mobile`, `role`) VALUES
(4, 'admin', '$2y$10$nrTrhAZ3494mN1NftSbcDezuyzQ3LDRh.Hvw7ZeTi6oQhRe0.Jn6m', '', '0', 'Admin'),
(20, 'hardik', '$2y$10$5Ne3c2O1K6CrreJpCKf4ye5TfNhFbp7AFZg3qmuJfwqbLN957vvZe', '', '0', 'Admin'),
(21, 'hardikuser', '$2y$10$iKynR8YaFXSA7j5uQ9R87edyCLtvMJ.f3Qwy5LxBx.XJnLrBnbYJO', '', '0', 'User'),
(22, 'jeel', '$2y$10$yYWBLs2Ky9KvVELI3nGoOu4c1K3RK809xT/FJsiOI5scdGlDnbbwC', '', '0', 'User'),
(26, 'vinay', '$2y$10$NhRstpdVafO0NgY2w8NgyOOZI72zN1Z/k920eI8U/Wg86vxQMwHke', 'vinay123@gmail.com', '2147483647', 'User'),
(27, 'DODIYA HARDIK DINESHBHAI', '$2y$10$8GeAbtHI4hmNEfqP3el7luaiiSXZ1VEfser2aAd3ABw/R9PIvRaIa', 'hardikdodiya2410@gmail.com', '2147483647', 'User'),
(28, 'deep', '$2y$10$KwctPGfoTt4LzMM32fZOYuEsqokSEovqsEGSp91xd0B7wyJTk8iOG', 'deepdodiya2410@gmail.com', '7285008403', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `investment`
--
ALTER TABLE `investment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `added_by` (`added_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `investment`
--
ALTER TABLE `investment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `investment`
--
ALTER TABLE `investment`
  ADD CONSTRAINT `investment_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `investment_ibfk_2` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
