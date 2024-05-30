-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: mariadb
-- Час створення: Трв 29 2024 р., 18:51
-- Версія сервера: 11.3.2-MariaDB-1:11.3.2+maria~ubu2204
-- Версія PHP: 8.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База даних: `books`
--

-- --------------------------------------------------------

--
-- Структура таблиці `publishings`
--

CREATE TABLE `publishings` (
  `id` int(11) NOT NULL,
  `PublName` text NOT NULL,
  `PublNameEng` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `publishings`
--

INSERT INTO `publishings` (`id`, `PublName`, `PublNameEng`) VALUES
(1, 'Penguin', 'Penguin'),
(2, 'КСД', 'KSD'),
(3, 'Vivat', 'Vivat'),
(4, 'Nebo BookLab Publishing', 'Nebo'),
(5, 'Жорж', 'Zhorzh'),
(6, 'А-БА-БА-ГА-ЛА-МА-ГА', 'Ababahalamaha'),
(7, 'Ранок', 'Ranok'),
(8, '#книголав', 'knygolav'),
(9, 'Віхола', 'Vihola'),
(10, 'Бородатий Тамарин', 'BorodatyyTamaryn'),
(11, 'BookChef', 'BookChef'),
(12, 'Disney Hyperion', 'DisneyHyperion'),
(13, 'Meridian Czernowitz', 'MeridianCzernowitz'),
(14, 'Фабула', 'Fabula'),
(22, 'TitleRead', 'TitleRead');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `publishings`
--
ALTER TABLE `publishings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `PublName` (`PublName`(768));

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `publishings`
--
ALTER TABLE `publishings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
