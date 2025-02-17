-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Värd: mysql_db
-- Tid vid skapande: 30 jan 2024 kl 13:19
-- Serverversion: 8.3.0
-- PHP-version: 8.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `beetsphp`
--
CREATE DATABASE IF NOT EXISTS `beetsphp` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `beetsphp`;

-- --------------------------------------------------------

--
-- Tabellstruktur `admin__permissions`
--

CREATE TABLE `admin__permissions` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `admin__permissions`
--

INSERT INTO `admin__permissions` (`id`, `name`, `description`) VALUES
(1, 'view_users_list', 'View the users list'),
(2, 'view_user', 'View a user profile'),
(3, 'add_user', 'Create a new user'),
(4, 'edit_user', 'Edit a user profile'),
(5, 'delete_user', 'Delete a user');

-- --------------------------------------------------------

--
-- Tabellstruktur `admin__permissions_relations`
--

CREATE TABLE `admin__permissions_relations` (
  `id` int NOT NULL,
  `permission_id` int NOT NULL,
  `role_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `admin__permissions_relations`
--

INSERT INTO `admin__permissions_relations` (`id`, `permission_id`, `role_id`) VALUES
(1, 3, 1),
(2, 5, 1),
(3, 4, 1),
(4, 2, 1),
(5, 1, 1),
(6, 3, 2),
(7, 4, 2),
(8, 2, 2),
(9, 1, 2),
(10, 2, 3),
(11, 1, 3);

-- --------------------------------------------------------

--
-- Tabellstruktur `admin__roles`
--

CREATE TABLE `admin__roles` (
  `id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `long_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `admin__roles`
--

INSERT INTO `admin__roles` (`id`, `name`, `long_name`, `description`) VALUES
(1, 'sysadmin', 'System Administrator', 'Full permissions'),
(2, 'admin', 'Administrator', 'Elevated permissions'),
(3, 'user', 'User', 'Common user with restricted permissions');

-- --------------------------------------------------------

--
-- Tabellstruktur `admin__user_accounts`
--

CREATE TABLE `admin__user_accounts` (
  `id` int NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(17) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` tinytext COLLATE utf8mb4_general_ci NOT NULL,
  `password_reset_token` varchar(32) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password_reset_token_created_at` datetime DEFAULT NULL,
  `role_id` int NOT NULL,
  `status` tinyint(1) NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumpning av Data i tabell `admin__user_accounts`
--

INSERT INTO `admin__user_accounts` (`id`, `first_name`, `last_name`, `email`, `phone`, `image`, `password`, `password_reset_token`, `password_reset_token_created_at`, `role_id`, `status`, `last_login`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'Sysadmin', 'Sysadminson', 'sysadmin@sysadmin.com', '', NULL, '$2y$10$4aBV2P3INM5smLhN3nHDr.2aAebiIiocS4Sz.71HGF/tKEzkq.ixm', NULL, NULL, 1, 1, NULL, '2024-01-01 12:00:00', 1, NULL, NULL),
(2, 'Admin', 'Adminsson', 'admin@admin.com', '', NULL, '$2y$10$iGlQq66MpUgR1ekisPObTOE/hTwUSRWZPmBmcu2T9iIYD4Sx0AUWa', NULL, NULL, 2, 1, NULL, '2024-01-01 12:00:00', 1, NULL, NULL),
(3, 'User', 'Usersson', 'user@user.com', '', NULL, '$2y$10$wIZpUElF8ERraDm5nQvQxO3DbGJ6c0FVF6HhS81wB7MzJ7VIMhr0a', NULL, NULL, 3, 1, NULL, '2024-01-01 12:00:00', 1, NULL, NULL);

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `admin__permissions`
--
ALTER TABLE `admin__permissions`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `admin__permissions_relations`
--
ALTER TABLE `admin__permissions_relations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permission_id` (`permission_id`),
  ADD KEY `admin__permissions_relations` (`role_id`);

--
-- Index för tabell `admin__roles`
--
ALTER TABLE `admin__roles`
  ADD PRIMARY KEY (`id`);

--
-- Index för tabell `admin__user_accounts`
--
ALTER TABLE `admin__user_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role` (`role_id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `admin__permissions`
--
ALTER TABLE `admin__permissions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT för tabell `admin__permissions_relations`
--
ALTER TABLE `admin__permissions_relations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT för tabell `admin__roles`
--
ALTER TABLE `admin__roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT för tabell `admin__user_accounts`
--
ALTER TABLE `admin__user_accounts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `admin__permissions_relations`
--
ALTER TABLE `admin__permissions_relations`
  ADD CONSTRAINT `admin__permissions_relations` FOREIGN KEY (`role_id`) REFERENCES `admin__roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `admin__permissions_relations_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `admin__permissions` (`id`);

--
-- Restriktioner för tabell `admin__user_accounts`
--
ALTER TABLE `admin__user_accounts`
  ADD CONSTRAINT `admin__user_accounts_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `admin__roles` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
