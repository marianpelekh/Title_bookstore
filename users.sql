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
-- Структура таблиці `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `Login` varchar(20) NOT NULL,
  `Password` varchar(16) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `FirstName` text NOT NULL,
  `LastName` text NOT NULL,
  `MiddleName` text NOT NULL,
  `StoredBooks` text NOT NULL,
  `image` text NOT NULL,
  `FeaturedGenres` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп даних таблиці `users`
--

INSERT INTO `users` (`userId`, `Login`, `Password`, `Email`, `FirstName`, `LastName`, `MiddleName`, `StoredBooks`, `image`, `FeaturedGenres`) VALUES
(6, 'marianpelekh', '04122005', 'marianpeleh@gmail.com', 'Мар\'ян', 'Пелех', 'Павлович', '[{\"code\":\"ISBN-0412-1507-5002-\",\"innerHTML\":\"<img class=\\u0022CartCover\\u0022 src=\\u0022КоронаЗмій_mockup.png\\u0022 alt=\\u0022Обкладинка\\u0022><h4 class=\\u0022CartTitle\\u0022>Корона Змій. Мечем та Полум\\u0027ям. Книга I<\\/h4><p class=\\u0022CartAuthor\\u0022>P. Marphine<\\/p><h4 class=\\u0022CartPrice\\u0022 price-of=\\u0022ISBN-0412-1507-5002-\\u0022>350 грн<\\/h4><div class=\\u0022Quantity\\u0022><button class=\\u0022DecreaseQuantity\\u0022>-<\\/button><span class=\\u0022quantityItself\\u0022 quantity-of=\\u0022ISBN-0412-1507-5002-\\u0022>1<\\/span><button class=\\u0022IncreaseQuantity\\u0022>+<\\/button><\\/div><button type=\\u0022button\\u0022 related-book=\\u0022ISBN-0412-1507-5002-\\u0022 class=\\u0022deleteButton\\u0022><img src=\\u0022x-mark.png\\u0022 width=\\u002220\\u0022><\\/button>\",\"singlePrice\":\"350\",\"quantity\":\"1\",\"style\":{\"display\":\"\",\"width\":\"\",\"margin\":\"\",\"gridTemplateColumns\":\"\",\"gridTemplateRows\":\"\"}},{\"code\":\"ІЛ-00028134\",\"innerHTML\":\"<img class=\\u0022CartCover\\u0022 src=\\u0022https:\\/\\/book-ye.com.ua\\/upload\\/iblock\\/44e\\/67e46d29_5176_11ee_8187_00505684ea69_c1f8531e_5178_11ee_8187_00505684ea69.jpg\\u0022 alt=\\u0022Обкладинка\\u0022><h4 class=\\u0022CartTitle\\u0022>Гадес і Персефона. Книга 1. Доторк темряви<\\/h4><p class=\\u0022CartAuthor\\u0022>Скарлетт Сент-Клер<\\/p><h4 class=\\u0022CartPrice\\u0022 price-of=\\u0022ІЛ-00028134\\u0022>266 грн<\\/h4><div class=\\u0022Quantity\\u0022><button class=\\u0022DecreaseQuantity\\u0022>-<\\/button><span class=\\u0022quantityItself\\u0022 quantity-of=\\u0022ІЛ-00028134\\u0022>1<\\/span><button class=\\u0022IncreaseQuantity\\u0022>+<\\/button><\\/div><button type=\\u0022button\\u0022 related-book=\\u0022ІЛ-00028134\\u0022 class=\\u0022deleteButton\\u0022><img src=\\u0022x-mark.png\\u0022 width=\\u002220\\u0022><\\/button>\",\"singlePrice\":\"266\",\"quantity\":\"1\",\"style\":{\"display\":\"\",\"width\":\"\",\"margin\":\"\",\"gridTemplateColumns\":\"\",\"gridTemplateRows\":\"\"}}]', './UserPictures/_13be486f-b9cb-4617-8d48-55d744ee42de.jfif', '{\"Dark Academia\":4,\"Fantasy\":40,\"Gothic\":18,\"Detective\":3,\"Poetry\":3,\"Other prose\":2,\"\":2}'),
(7, 'heinaoksana', '15072006', 'oksikheina@gmail.com', 'Оксана', 'Гейна', 'Іванівна', '', 'user.png', '{\"Other prose\":2,\"Gothic\":2}'),
(16, 'admin', 'TitleAdmin11', 'admin@title.ua', 'Admin', 'Admin', 'Admin', '[{\"code\":\"ISBN-978-617-15-0710\",\"innerHTML\":\"<img class=\\u0022CartCover\\u0022 src=\\u0022https:\\/\\/bookclub.ua\\/images\\/db\\/goods\\/61919_123354.jpg\\u0022 alt=\\u0022Обкладинка\\u0022><h4 class=\\u0022CartTitle\\u0022>Залізне полум’я. Емпіреї. Книга 2<\\/h4><p class=\\u0022CartAuthor\\u0022>Ребекка Яррос<\\/p><h4 class=\\u0022CartPrice\\u0022 price-of=\\u0022ISBN-978-617-15-0710\\u0022>720 грн<\\/h4><div class=\\u0022Quantity\\u0022><button class=\\u0022DecreaseQuantity\\u0022>-<\\/button><span class=\\u0022quantityItself\\u0022 quantity-of=\\u0022ISBN-978-617-15-0710\\u0022>1<\\/span><button class=\\u0022IncreaseQuantity\\u0022>+<\\/button><\\/div><button type=\\u0022button\\u0022 related-book=\\u0022ISBN-978-617-15-0710\\u0022 class=\\u0022deleteButton\\u0022><img src=\\u0022x-mark.png\\u0022 width=\\u002220\\u0022><\\/button>\",\"singlePrice\":\"720\",\"quantity\":1,\"style\":{\"display\":\"\",\"width\":\"\",\"margin\":\"\",\"gridTemplateColumns\":\"\",\"gridTemplateRows\":\"\"}},{\"code\":\"ISBN-0412-1507-5002-\",\"innerHTML\":\"<img class=\\u0022CartCover\\u0022 src=\\u0022КоронаЗмій_mockup.png\\u0022 alt=\\u0022Обкладинка\\u0022><h4 class=\\u0022CartTitle\\u0022>Корона Змій. Мечем та Полум\\u0027ям. Книга I<\\/h4><p class=\\u0022CartAuthor\\u0022>P. Marphine<\\/p><h4 class=\\u0022CartPrice\\u0022 price-of=\\u0022ISBN-0412-1507-5002-\\u0022>350 грн<\\/h4><div class=\\u0022Quantity\\u0022><button class=\\u0022DecreaseQuantity\\u0022>-<\\/button><span class=\\u0022quantityItself\\u0022 quantity-of=\\u0022ISBN-0412-1507-5002-\\u0022>1<\\/span><button class=\\u0022IncreaseQuantity\\u0022>+<\\/button><\\/div><button type=\\u0022button\\u0022 related-book=\\u0022ISBN-0412-1507-5002-\\u0022 class=\\u0022deleteButton\\u0022><img src=\\u0022x-mark.png\\u0022 width=\\u002220\\u0022><\\/button>\",\"singlePrice\":\"350\",\"quantity\":\"1\",\"style\":{\"display\":\"\",\"width\":\"\",\"margin\":\"\",\"gridTemplateColumns\":\"\",\"gridTemplateRows\":\"\"}}]', 'user.png', '{\"Fantasy\":39,\"Gothic\":3,\"\":1,\"Detective\":1}'),
(17, 'mari', 'mh04122005op', 'marianpelekh@title.com', 'Marian', 'Pelekh', 'Pavlovych', '[{\"code\":\"ІД-4134103\",\"innerHTML\":\"<img class=\\u0022CartCover\\u0022 src=\\u0022https:\\/\\/bookclub.ua\\/images\\/db\\/goods\\/49791_84572.jpg\\u0022 alt=\\u0022Обкладинка\\u0022><h4 class=\\u0022CartTitle\\u0022>Гессі<\\/h4><p class=\\u0022CartAuthor\\u0022>Наталія Матолінець<\\/p><h4 class=\\u0022CartPrice\\u0022 price-of=\\u0022ІД-4134103\\u0022>290 грн<\\/h4><div class=\\u0022Quantity\\u0022><button class=\\u0022DecreaseQuantity\\u0022>-<\\/button><span class=\\u0022quantityItself\\u0022 quantity-of=\\u0022ІД-4134103\\u0022>1<\\/span><button class=\\u0022IncreaseQuantity\\u0022>+<\\/button><\\/div><button type=\\u0022button\\u0022 related-book=\\u0022ІД-4134103\\u0022 class=\\u0022deleteButton\\u0022><img src=\\u0022x-mark.png\\u0022 width=\\u002220\\u0022><\\/button>\",\"singlePrice\":\"290\",\"quantity\":\"1\",\"style\":{\"display\":\"\",\"width\":\"\",\"margin\":\"\",\"gridTemplateColumns\":\"\",\"gridTemplateRows\":\"\"}}]', './UserPictures/_e354c2e6-636c-469a-a931-7e4c77ba7116.jpeg', '{\"Fantasy\":252,\"Detective\":5,\"Gothic\":3,\"\":2,\"Light Academia\":1}'),
(18, 'Mykhail024', '87643215Db@', 'semerka535@gmail.com', 'Михайло', 'Музика', 'Андрійович', '[]', './UserPictures/flat,750x,075,f-pad,750x1000,f8f8f8.jpg', '{\"Dark Academia\":1}'),
(19, 'madara', '12345678', 'asfewq12ewfewfgfewgy@gmail.com', 'bfhf', 'dbf', 'frfh', '[{\"code\":\"ІД-4135911\",\"innerHTML\":\"<img class=\\u0022CartCover\\u0022 src=\\u0022https:\\/\\/bookclub.ua\\/images\\/db\\/goods\\/61387_121775.jpg\\u0022 alt=\\u0022Обкладинка\\u0022><h4 class=\\u0022CartTitle\\u0022>Убивство - це легко<\\/h4><p class=\\u0022CartAuthor\\u0022>Аґата Крісті<\\/p><h4 class=\\u0022CartPrice\\u0022 price-of=\\u0022ІД-4135911\\u0022>230 грн<\\/h4><div class=\\u0022Quantity\\u0022><button class=\\u0022DecreaseQuantity\\u0022>-<\\/button><span class=\\u0022quantityItself\\u0022 quantity-of=\\u0022ІД-4135911\\u0022>1<\\/span><button class=\\u0022IncreaseQuantity\\u0022>+<\\/button><\\/div><button type=\\u0022button\\u0022 related-book=\\u0022ІД-4135911\\u0022 class=\\u0022deleteButton\\u0022><img src=\\u0022x-mark.png\\u0022 width=\\u002220\\u0022><\\/button>\",\"singlePrice\":\"230\",\"quantity\":\"1\",\"style\":{\"display\":\"\",\"width\":\"\",\"margin\":\"\",\"gridTemplateColumns\":\"\",\"gridTemplateRows\":\"\"}}]', './UserPictures/piccolo_divany4.jpg', '{\"Detective\":1,\"Gothic\":2}'),
(20, 'ilovepespatron', '1234', 'zelerontop@gmail.com', 'jhgbfdcsxs', 'bgfvcdx', 'ghbfvcdxs', '[]', './UserPictures/images.jpg', '{\"Other prose\":2}'),
(21, 'asdas', 'asdasd', 'asdhj@gmaila.c', 'Jo', 'Ma', 'Ma', '[{\"code\":\"ІД-4135911\",\"innerHTML\":\"<img class=\\u0022CartCover\\u0022 src=\\u0022https:\\/\\/bookclub.ua\\/images\\/db\\/goods\\/61387_121775.jpg\\u0022 alt=\\u0022Обкладинка\\u0022><h4 class=\\u0022CartTitle\\u0022>Убивство - це легко<\\/h4><p class=\\u0022CartAuthor\\u0022>Аґата Крісті<\\/p><h4 class=\\u0022CartPrice\\u0022 price-of=\\u0022ІД-4135911\\u0022>230 грн<\\/h4><div class=\\u0022Quantity\\u0022><button class=\\u0022DecreaseQuantity\\u0022>-<\\/button><span class=\\u0022quantityItself\\u0022 quantity-of=\\u0022ІД-4135911\\u0022>1<\\/span><button class=\\u0022IncreaseQuantity\\u0022>+<\\/button><\\/div><button type=\\u0022button\\u0022 related-book=\\u0022ІД-4135911\\u0022 class=\\u0022deleteButton\\u0022><img src=\\u0022x-mark.png\\u0022 width=\\u002220\\u0022><\\/button>\",\"singlePrice\":\"230\",\"quantity\":\"1\",\"style\":{\"display\":\"\",\"width\":\"\",\"margin\":\"\",\"gridTemplateColumns\":\"\",\"gridTemplateRows\":\"\"}}]', './UserPictures/IMG-66dbeb07e3529618fc1277876cacc060-V.jpg', '{\"Detective\":1}');

--
-- Індекси збережених таблиць
--

--
-- Індекси таблиці `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT для збережених таблиць
--

--
-- AUTO_INCREMENT для таблиці `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
