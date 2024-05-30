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
-- Структура таблиці `comments`
--

CREATE TABLE `comments` (
  `commentId` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `userName` text NOT NULL,
  `userPic` text NOT NULL,
  `commentText` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `comments`
--

INSERT INTO `comments` (`commentId`, `userId`, `userName`, `userPic`, `commentText`) VALUES
(3, 16, 'Admin Admin', 'user.png', 'Я адмін, хехе'),
(4, 16, 'Admin Admin', 'user.png', 'Адміністратор сайту незадоволений такою низькою відвідуваністю'),
(6, 16, 'Admin Admin', 'user.png', 'Це деякий коментар'),
(7, 17, 'Marian Pelekh', './UserPictures/_e354c2e6-636c-469a-a931-7e4c77ba7116.jpeg', 'Можна мені, будь ласочка, якщо вам не важко, якщо вам звісно важко, то не слухайте мене далі, але ну якщо ви все таки послухаєте, то будь ласка, не тримайте на мене зла, але я хотів би попросити у вас, сподіваюсь це не сильно погано, але чи можна у вас попросити одну книжечку безкоштовно?🥺👉👈'),
(8, 6, 'Мар\'ян Пелех', './UserPictures/_13be486f-b9cb-4617-8d48-55d744ee42de.jfif', 'Хочу залишити деякий відгук тут'),
(9, 18, 'Михайло Музика', './UserPictures/flat,750x,075,f-pad,750x1000,f8f8f8.jpg', '██╗░░██╗██████╗░ ╚██╗██╔╝██╔══██╗ ░╚███╔╝░██║░░██║ ░██╔██╗░██║░░██║ ██╔╝╚██╗██████╔╝ ╚═╝░░╚═╝╚═════╝░'),
(10, 19, 'bfhf dbf', './UserPictures/ae5fc8040c9763d5a7eb1b8d683d096f.jpg', 'hi high chu from loona'),
(11, 20, 'jhgbfdcsxs bgfvcdx', './UserPictures/images.jpg', 'yor mom'),
(12, 20, 'jhgbfdcsxs bgfvcdx', './UserPictures/images.jpg', 'your dad'),
(13, 19, 'bfhf dbf', './UserPictures/piccolo_divany4.jpg', 'jinsoul from loona'),
(14, 21, 'Jo Ma', 'user.png', 'Чудовий посібник від Агатки'),
(15, 19, 'bfhf dbf', './UserPictures/piccolo_divany4.jpg', 'Продам аккаунт за 50$'),
(16, 17, 'Marian Pelekh', './UserPictures/_e354c2e6-636c-469a-a931-7e4c77ba7116.jpeg', 'Ось це деякий загальний коментар'),
(20, 17, 'Marian Pelekh', './UserPictures/_e354c2e6-636c-469a-a931-7e4c77ba7116.jpeg', 'Класна книга, я писав'),
(22, 6, 'Мар\'ян Пелех', './UserPictures/_13be486f-b9cb-4617-8d48-55d744ee42de.jfif', 'Ні, це я написав'),
(24, 17, 'Marian Pelekh', './UserPictures/_e354c2e6-636c-469a-a931-7e4c77ba7116.jpeg', 'Геній, ми одна людина'),
(25, 17, 'Marian Pelekh', './UserPictures/_e354c2e6-636c-469a-a931-7e4c77ba7116.jpeg', 'Прикольна книга, але чи другу частину купуватиму не знаю'),
(26, 6, 'Мар\'ян Пелех', './UserPictures/_13be486f-b9cb-4617-8d48-55d744ee42de.jfif', 'Hello there');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentId`),
  ADD KEY `comments_ibfk_1` (`userId`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `comments`
--
ALTER TABLE `comments`
  MODIFY `commentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Обмеження зовнішнього ключа збережених таблиць
--

--
-- Обмеження зовнішнього ключа таблиці `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
