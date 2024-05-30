-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: mariadb
-- Час створення: Трв 29 2024 р., 18:49
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
-- Структура таблиці `BooksComments`
--

CREATE TABLE `BooksComments` (
  `BookID` varchar(20) NOT NULL,
  `CommentID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `BooksComments`
--

INSERT INTO `BooksComments` (`BookID`, `CommentID`) VALUES
('ISBN-0412-1507-5002', 15),
('ІЛ-00029348', 8),
('ІЛ-00029348', 3),
('ІЛ-00029348', 7),
('ІД-4135911', 14),
('ISBN-0412-1507-5002', 20),
('ISBN-0412-1507-5002', 22),
('ISBN-0412-1507-5002', 24),
('ІД-4135924', 25),
('ISBN-0412-1507-5002', 26);

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `BooksComments`
--
ALTER TABLE `BooksComments`
  ADD KEY `BookID` (`BookID`),
  ADD KEY `CommentID` (`CommentID`);

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `BooksComments`
--
ALTER TABLE `BooksComments`
  ADD CONSTRAINT `bookscomments_ibfk_1` FOREIGN KEY (`BookID`) REFERENCES `books` (`number`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookscomments_ibfk_2` FOREIGN KEY (`CommentID`) REFERENCES `comments` (`commentId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
