-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `easylist` (
  `id` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_german2_ci NOT NULL,
  `vorname` varchar(100) CHARACTER SET utf8 COLLATE utf8_german2_ci NOT NULL,
  `email` varchar(500) CHARACTER SET utf8 COLLATE utf8_german2_ci DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `IP` varchar(64) CHARACTER SET utf8 COLLATE utf8_german2_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `display` varchar(500) NOT NULL,
  `value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `settings` (`id`, `type`, `display`, `value`) VALUES
(1, 'maxguests', 'Max number of guests (0 = disabled)', 0),
(2, 'loginrequired', 'Guests have to login (0 = disabled)', 1);

INSERT INTO `settings` (`id`, `type`, `display`, `value`) VALUES
(1, 'maxguests', 'Max number of guests (0 = disabled)', 0),
(2, 'loginrequired', 'Guests have to login (0 = disabled)', 0);

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `pw` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `name`, `pw`, `type`) VALUES
(2, 'admin', 'asdasd', 'admin');

ALTER TABLE `easylist`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `easylist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
