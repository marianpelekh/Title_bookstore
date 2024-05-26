<?php

use Joomla\CMS\Service\Provider\Console;

use const Avifinfo\UNDEFINED;

 session_start(); ?>
<!DOCTYPE html>
<html lang="UTF-8">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title Bookstore</title>
    <link rel="stylesheet" href="Title Main.css">
    <link rel="stylesheet" href="Carousel of images.css">
    <link rel="stylesheet" href="Main page.css">
    <link rel="stylesheet" href="books.css">
    <link rel="stylesheet" href="CartStyles.css">
    <link rel="stylesheet" href="AuthorsStyles.css">
    <link rel="stylesheet" href="ScreenAdaptation.css">
    <link rel="icon" type="image/x-icon" href="favicon1.png">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
<header>
    <a id="SearchToggle"><img src="search.png" id="search" width="20px"></a>
    <h1><a id="Title" href="index.php">Title</a></h1>
    <nav>
        <a id="Catalog" href="Каталог.php">Каталог</a>
        <a id="Authors" href="Автори.php">Автори</a>
        <h1><a id="TitleNav" href="index.php">Title</a></h1>
        <a id="New" href="Новинки">Новинки</a>
        <a id="Contacts" href="Контакти.php">Контакти</a>
        <a id="Cabinet" href="Кабінет.php"><img src="personal-icon.png" id="pers-cab" width="20px"></a>
    </nav>
    <a id="MainCabinet" href="Кабінет.php"><img src="personal-icon.png" width="20px"></a>
    <div id="menuToggle">
        <img src="menu.png" alt="Menu" width="20px">
    </div>
    <div id="searchContainer">
        <div id="searchPlusClose">
            <input type="text" id="searchField" placeholder="Введіть назву книги або автора...">
            <img src="close.png" id="closeSearch" alt="X">
        </div>

        <div id="searchResultField">
            <div id="searchedBooks">
                <div id="booksContainer">
                </div>
            </div>
            <div id="searchedAuthors">
                <div id="authorsContainer">
                </div>
            </div>
        </div>
    </div>
</header>
<body>
    <div id="loader-wrapper">
        <div id="loader"></div>
        <!-- <div id="progress">0%</div> -->
        <div id="LoaderStrip"></div>
        <svg id="LoaderLightOne" width="2227" height="995" viewBox="0 0 2227 995" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M94 1.86223C282.167 -13.8044 674.2 62.5623 737 493.362C815.5 1031.86 1320.5 568.862 1521.5 519.362C1682.3 479.762 2058.83 588.196 2227 647.362L1121.5 994.862L253.5 960.862L0 806.862L94 1.86223Z" fill="#E1D5FF"/>
        </svg>
        <svg id="LoaderDarkOne" width="1654" height="989" viewBox="0 0 1654 989" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1378 62.0004C1262.5 200 1274 378.501 1099 407.001C1030.2 418.205 962.167 375.834 937 355.001C879.5 317.501 747.797 311.116 659.5 378.501C450.5 538.001 230.833 601.5 16.5 668.5L1 935L1493.5 987.5L1653 62.0004C1653 62.0004 1493.5 -75.9996 1378 62.0004Z" fill="#471B4B" stroke="black"/>
        </svg>
        <svg id="LoaderEllipse" width="435" height="435" viewBox="0 0 435 435" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="217.5" cy="217.5" r="217.5" fill="#EEDBF7"/>
        </svg>
        <h1 id="LoaderTitle" word="Title"></h1>
    </div>
    <section>
        <div id="CartContainer">
            <div id="Cart"><img src="shopping-cart.png" width="20"></div>
            <div id="CartWindow">
                <h2 style="text-align: center; height: 20px;">Корзина</h2>
            </div>
        </div>
    <div class="carousel">
        <img class="carousel-img" src="BSAF.jpg">
        <img class="carousel-img" src="NINTH-HOUSE.jpg">
        <img class="carousel-img" src="NEW.jpg">
    </div>
    <div class="dot-container">
        <span class="dots active"></span>
        <span class="dots"></span>
        <span class="dots"></span>
    </div>
    <div id="greetings">
        <img class="titleimage" id="titleimage" src="GREETINGS.jpg">
        <p id="greet">Доброго дня, раді вітати Вас 
            на сайті книгарні Title. Бажаємо вам вдалих 
            покупок і чудово проведеного часу за вивченням
            величезного світу літератури, який ми пропонуємо. 
            Нехай кожна книга, яку ви знайдете тут, надихає, 
            розважає та захоплює вас. Приємного читання!</p>
    </div>
    <div id="NewsTitle">Новинки</div>

    <?php
        include('connect_db.php');
    
        $query = "SELECT * FROM books";
        $result = mysqli_query($conn, $query);
        echo '<div id="NewBooksMain">';
        while ($row = mysqli_fetch_array($result)) {
            $date1 = new DateTime($row['DateExact']);
            $date2 = new DateTime();
            $interval = $date1->diff($date2);
            if ($interval->y == 0 && $interval->m < 2){
                echo '<div class="book-container">';
                echo '<a href="КнижковаСторінка.php?id=' . urlencode($row['Name'] . ' ' . $row['Author']) . '">';
                echo '<img class="cover" src="' . $row['Cover'] . '">';
                echo '</a>';
                echo '<div class="description">';
                echo '<div class="book-name">' . $row['Name'] . '</div>';
                echo '<div class="book-author">' . $row['Author'] . '</div>';
                echo '<div class="price">' . $row['Price'] . '</div>';
                echo '</div>';
                echo '<a class="buy" href="КнижковаСторінка.php?id=' . urlencode($row['Name'] . ' ' . $row['Author']) . '"> Придбати </a>';
                echo '</div>';
            }    
        }
        echo '</div>';
    ?>

    <div class="NewsArrows">
        <svg id="LeftArrow" style="cursor: pointer;" width="23.5" height="27.5" viewBox="0 0 47 55" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M40.4698 2.42373L3.46977 24.9196C1.51008 26.0818 1.51007 28.9182 3.46977 30.0804L40.4698 52.5763C42.4696 53.7622 45 52.3209 45 49.9959L45 5.00411C45 2.67912 42.4696 1.2378 40.4698 2.42373Z" fill="var(--main-color)" stroke="var(--a-color)" stroke-width="4" stroke-miterlimit="0" stroke-linecap="round"/>
        </svg>
        <svg id="block"  width="90.5" height="25.5" viewBox="0 0 181 51" fill="none" xmlns="http://www.w3.org/2000/svg">
        <rect width="181" height="51" rx="3" fill="var(--main-color)"/>
        </svg>
        <svg id="RightArrow" style="cursor: pointer;" width="23.5" height="27.5" viewBox="0 0 47 55" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M6.53023 52.5763L43.5302 30.0804C45.4899 28.9182 45.4899 26.0818 43.5302 24.9196L6.53023 2.42373C4.53044 1.23781 2 2.67912 2 5.00412L2 49.9959C2 52.3209 4.53043 53.7622 6.53023 52.5763Z" fill="var(--main-color)" stroke="var(--a-color)" stroke-width="4" stroke-miterlimit="0" stroke-linecap="round"/>
        </svg>
    </div>
    <div class="InfoAboutStore">
        <h2>Про видавництво</h2>
        <p>Наше видавництво було створено зовсім недавно, 
            проте вже зараз має змогу радувати вас світовими 
            новинками різних жанрів. Ми спеціалізуємося на 
            художній літературі і пропонуємо широкий вибір 
            творів у таких жанрах:

        <br>> Фентезі та фантастика
        <br>> Горрори | Трилери
        <br>> Dark academia
        <br>> Light academia
        <br>> Детективи
        <br>> Готика
        <br>> Інша проза
        <br>> Поезія
        <br>Ми прагнемо забезпечити вам найкращий досвід 
        читання, пропонуючи як класичні твори, так і
        сучасні новинки. Наша мета - робити світ книг 
        доступним для кожного, хто любить читати.
    </p>
    
    </div>
    <div class="InfoAboutStoreNext">
        <p>
    Історія видавництва Title  почалася з невеликої книгарні на околицях Тернополя, і продовжується у вигляді всеукраїнського видавничого підприємства. Ми почали з видання книг маловідомих авторів, але з часом наш каталог розширився, і тепер ми пишаємося тим, що можемо пропонувати вам широкий вибір жанрів і стилів.

Наша мета - не просто видавати книги, а створювати спільноту любителів літератури. Ми влаштовуємо регулярні заходи, такі як читацькі клуби та проводимо зустрічі з авторами, щоб залучити наших читачів до обговорення та обміну думками.

Ми прагнемо того, щоб кожна книга, яку ми видаємо, була не просто товаром, а частинкою нашої спільної історії. Кожна сторінка, кожне слово - це вияв нашого захоплення літературою і нашого бажання подарувати вам незабутній читацький досвід. Сподвіаємося, що кожен з наших читачів долучиться до розвитку нового українського видавництва і зробить свій вклад в його поширення літературним простором.
        </p>    
</div>
<div class="CommentsTitle">
    <h3>Відгуки та пропозиції</h3>
</div>
<div class="CommentsBlock">
    <?php 
        $sql_comment = "SELECT * FROM comments ORDER BY commentId DESC";
        $result = mysqli_query($conn, $sql_comment);
        if (mysqli_num_rows($result) > 0) {
            for ($i = 0; $i < 4; $i++) { 
                if ($row = mysqli_fetch_array($result)) {
                    $userPic = htmlspecialchars($row['userPic'], ENT_QUOTES, 'UTF-8');
                    $userName = htmlspecialchars($row['userName'], ENT_QUOTES, 'UTF-8');
                    $commentText = htmlspecialchars($row['commentText'], ENT_QUOTES, 'UTF-8');
                    
                    echo "<div class='Comment'>";
                    echo "<div class='Avatar'><img src='" . $userPic . "' alt=''></div>";
                    echo "<div class='CommentText'><div><h3 class='CommUserName'>" . $userName . "</h3><p>" . $commentText . "</p></div></div>";
                    echo "</div>";
                }
            }
        } else {
            echo "Немає коментарів для відображення.";
        }
    ?>
    <div class="undercomms">
        <p id="MakeComment">Залишити відгук</p>
        <a href="mailto:title@contact.com" id="SendProposition">Надати пропозицію</a>
    </div>
    <?php
        if (isset($_POST['postComm']) && isset($_SESSION['id'])) {
            $userId = $_SESSION["id"];
            
            $userInfoQuery = "SELECT FirstName, LastName, `image` FROM users WHERE userId = '$userId'";
            $userInfoResult = mysqli_query($conn, $userInfoQuery);
            
            $userInfoRow = mysqli_fetch_assoc($userInfoResult);
            
            $firstName = mysqli_real_escape_string($conn, $userInfoRow['FirstName']);
            $lastName = mysqli_real_escape_string($conn, $userInfoRow['LastName']);
            $userName = $firstName . ' ' . $lastName;
            $userPic = mysqli_real_escape_string($conn, $userInfoRow['image']);
            
            $commentText = mysqli_real_escape_string($conn, $_POST["commText"]);
            
            $comms_sql = "INSERT INTO `comments` (`userId`, `userName`, `userPic`, `commentText`) 
                        VALUES ('$userId', '$userName', '$userPic', '$commentText')";
            
            mysqli_query($conn, $comms_sql);
            echo "<script>console.log('QUERY DONE');</script>";
        } else if (isset($_POST['postComm']) && !isset($_SESSION['id'])) {
            echo "<h4>Неавторизовані користувачі не можуть залишати відгуки U_U</h4>";
        }
    ?>

</div>
  
</section>
<script src="Comments.js"></script>
<script src="CookieAlert.js"></script>
<script src="Carousel of images.js"></script>
<script src="Books.js"></script>
<script src="NewBooksScrolling.js"></script>
<script src="CartBooks.js"></script>
<script src="MakeComments.js"></script>
<script>
            document.addEventListener('DOMContentLoaded', function () {
                // Отримати посилання на елементи
                const menuToggle = document.getElementById('menuToggle');
                const navs = document.querySelectorAll('nav');
                const cabinet = document.getElementById('Cabinet');
                
                // Додати обробник подій для кліку на #menuToggle
                menuToggle.addEventListener('click', function () {
                    // Змінити стилі в залежності від стану меню
                    navs.forEach(nav => {
                    if (nav.style.display === 'grid') {
                        nav.style.display = 'none';
                        // Змінити атрибути grid-row та grid-column на початкові значення
                        nav.style.gridRow = 'initial';
                        nav.style.gridColumn = 'initial';
                        nav.classList.remove('active-menu');
                    } else {
                        nav.style.display = 'grid';
                        // Змінити атрибути grid-row та grid-column на нові значення
                        nav.classList.add('active-menu');
                    }   
                    });
                });
            });
        </script>
        <script src="Search.js"></script>
        <script src="Loading.js"></script>
</body>
<footer>
    <h1 id="foot-title">Title</h1>
    <span id="catalog-footer">
        <a id="FootCatalog" href="Каталог.php"><h2 id="FootCatalog" style="text-align: left;">Каталог</h2></a>
        <a href="Каталог.php" class="genreLink" genre-link="Fantasy">Фентезі</a>
        <a href="Каталог.php" class="genreLink" genre-link="Horrors">Горрори | Трилери</a>
        <a href="Каталог.php" class="genreLink" genre-link="DarkAcademia">Dark academia</a>
        <a href="Каталог.php" class="genreLink" genre-link="LightAcademia">Light academia</a>
        <a href="Каталог.php" class="genreLink" genre-link="Detective">Детективи</a>
        <a href="Каталог.php" class="genreLink" genre-link="Gothic">Готика</a>
        <a href="Каталог.php" class="genreLink" genre-link="OtherProse">Інша проза</a>
        <a href="Каталог.php" class="genreLink" genre-link="Poetry">Поезія</a>
    </span>
    <span id="other-footer-info">
        <a id="FootAuthors" href="Автори.php"><h2 id="FootAuthors">Автори</h2></a>
        <a id="FootNews" href="Новинки.php"><h2 id="FootNews">Новинки</h2></a>
        <a id="FootContacts" href="Контакти.php"><h2 id="FootContacts">Контакти</h2></a>
        <a href="">@titlebookstore</a>
        <a href="">title@contact.com</a>
        <a href="">+380*********</a>
    </span>

</footer>
</html>