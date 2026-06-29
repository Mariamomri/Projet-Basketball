-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 29, 2026 at 07:56 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `basketball_dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `coaches`
--

DROP TABLE IF EXISTS `coaches`;
CREATE TABLE IF NOT EXISTS `coaches` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_verified` tinyint NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coaches`
--

INSERT INTO `coaches` (`id`, `email`, `roles`, `password`, `firstname`, `lastname`, `created_at`, `updated_at`, `is_verified`) VALUES
(1, 'Julien@basketball.be', '[]', '$2y$13$z8RJQbZeEiOmk1MVt6V9seybLbSD9OJKWpKijfu9zzbTNPl2K9ycK', 'Julien', 'Dunia', '2026-06-27 19:26:35', '2026-06-27 19:26:35', 1),
(2, 'sami@basketball.be', '[]', '$2y$13$gI4pPVprVcLQ1cXRU3SDFeuFXVOBH8lV0PUKEbwshndIrEsPmB3ue', 'Sami', 'Omri', '2026-06-27 19:50:49', '2026-06-27 19:50:49', 1),
(3, 'codegirlbxl@gmail.com', '[]', '$2y$13$siCKWVRuwZg67tsOOvcSHOiwComdOjMk9LfUOBZuR7CBgYSIo2seS', 'Mary', 'Omri', '2026-06-28 17:15:38', '2026-06-28 17:15:38', 0),
(4, 'bianchl@gmail.com', '[]', '$2y$13$5mVvsJxZEoFOBBIHcVFQTuEBvLnc1kixRRBmbOJv2d2eylzq5C9ri', 'Sara', 'Bianchi', '2026-06-28 17:26:38', '2026-06-28 17:30:49', 1),
(5, 'imran@gmail.com', '[]', '$2y$13$qU5hH4APC05jSbaGgbbZPu3H2GqqZgeBi5Vnenuo1j0SiDfIVr4iC', 'Imran', 'Blu', '2026-06-28 17:45:39', '2026-06-28 17:47:11', 1),
(6, 'ciao@gmail.com', '[]', '$2y$13$6/XOc1n3numM69GLUSDgU.ABhS5G3AHMgv3sw2DHFxP41zY1omd2q', 'Rayan', 'Omri', '2026-06-29 17:33:38', '2026-06-29 17:33:38', 0);

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20260517103028', '2026-05-17 10:43:04', 32),
('DoctrineMigrations\\Version20260517104145', NULL, NULL),
('DoctrineMigrations\\Version20260517131500', NULL, NULL),
('DoctrineMigrations\\Version20260517131627', NULL, NULL),
('DoctrineMigrations\\Version20260517154153', NULL, NULL),
('DoctrineMigrations\\Version20260517154723', NULL, NULL),
('DoctrineMigrations\\Version20260627163958', '2026-06-27 16:48:30', 129),
('DoctrineMigrations\\Version20260627222246', '2026-06-27 22:24:04', 73),
('DoctrineMigrations\\Version20260628001631', '2026-06-28 00:20:39', 188);

-- --------------------------------------------------------

--
-- Table structure for table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0E3BD61CE16BA31DBBF396750` (`queue_name`,`available_at`,`delivered_at`,`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

DROP TABLE IF EXISTS `players`;
CREATE TABLE IF NOT EXISTS `players` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `team` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `coach_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_264E43A63C105691` (`coach_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `name`, `slug`, `position`, `team`, `description`, `image`, `created_at`, `updated_at`, `coach_id`) VALUES
(1, 'LeBron James', 'lebron-james', 'Forward', 'Los Angeles Lakers', 'L\'un des meilleurs joueurs de l\'histoire du basketball, connu pour sa polyvalence et son leadership.', 'https://imgcdn.stablediffusionweb.com/2024/5/13/1620ce95-bb8f-4c8f-9f73-99e21383c0eb.jpg', '0000-00-00 00:00:00', '2026-06-29 17:43:00', 1),
(2, 'Stephen Curry', 'stephen-curry', 'Point Guard', 'Golden State Warriors', 'Meilleur shooteur de l\'histoire, révolutionnaire du jeu moderne grâce à ses tirs à 3 points.', 'https://cdn.nba.com/headshots/nba/latest/1040x760/201939.png', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2),
(3, 'Giannis Antetokounmpo', 'giannis-antetokounmpo', 'Power Forward', 'Milwaukee Bucks', 'Surnommé le Greek Freak, double MVP de la saison régulière et champion NBA en 2021.', 'https://tse4.mm.bing.net/th/id/OIP.vBDfolMSjz21ia-3M-6svwHaEE?pid=Api&h=220&P=0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1),
(5, 'test 1', 'test-1', 'test@gmail.com', 'a', 'gcjvn;hv', NULL, '2026-06-28 21:33:42', '2026-06-28 21:33:42', 5),
(6, 'bla bla', 'bla-bla', 'nhjknh', 'jnkj', ',:,jlmkjpm', NULL, '2026-06-29 17:43:39', '2026-06-29 17:43:39', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
