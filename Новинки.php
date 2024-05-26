<!DOCTYPE html>
<html lang="UTF-8">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Автори. Title Bookstore</title>
    <link rel="stylesheet" href="Title Main.css">
    <link rel="stylesheet" href="Carousel of images.css">
    <link rel="stylesheet" href="Main page.css">
    <link rel="stylesheet" href="CartStyles.css">
    <link rel="stylesheet" href="Novelties.css">
    <link rel="stylesheet" href="AuthorsStyles.css">
    <link rel="stylesheet" href="ScreenAdaptation.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="icon" type="image/x-icon" href="favicon1.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<header>
    <a id="SearchToggle"><img src="search.png" id="search" width="20px"></a>
    <h1><a id="Title" href="index.php">Title</a></h1>
    <nav>
        <a id="Catalog" href="Каталог.php">Каталог</a>
        <a id="Authors" href="Автори.php">Автори</a>
        <h1><a id="TitleNav" href="index.php">Title</a></h1>
        <a id="New" href="Новинки.php">Новинки</a>
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
    <div id="Cart"><img src="shopping-cart.png" width="20"></div>
    <div id="CartWindow">
        <h2 style="text-align: center; height: 20px;">Корзина</h2>
    </div>
        <div id="NoveltiesTitle">Новинки</div>
        <?php
            include('connect_db.php');

            $novelties = []; // Create an array to store novelties

    $query = "SELECT * FROM books";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_array($result)) {
        $date1 = new DateTime($row['DateExact']);
        $date2 = new DateTime();
        $interval = $date1->diff($date2);
        if ($interval->y == 0 && $interval->m < 2){
            $novelties[] = $row; // Store the fetched data in the array
        }
    }

    echo '<div id="Novelties">';
    echo '<div class="content">';
    echo '<div class="swiperContent">';
    echo '<div class="swiper">';
    echo '<div class="swiper-wrapper">';
    
    foreach ($novelties as $row) {
        echo '<div class="swiper-slide" style="display: flex; justify-content: center; align-items: center; max-height: 500px;" related-book="' . $row['number'] . '">';
        echo '<a href="КнижковаСторінка.php?id=' . urlencode($row['Name'] . ' ' . $row['Author']) . '">';
        echo '<img class="cover" width="250rem" src="' . $row['Cover'] . '">';
        echo '</a>';
        echo '</div>';
    }
    echo '</div>';
    echo '</div>';
    echo '</div>';
    
    echo '<div class="info">';
    foreach ($novelties as $row) {
        echo '<div class="relatedInfo" related-book="' . $row['number'] . '">';
        echo '<div id="BookTitle">' . $row['ShortName'] . '</div>';
        echo '<div id="BookAuthor">' . $row['Author'] . '</div>';
        echo '<div id="BookDesc">' . $row['Description'] . '</div>';
        echo '<a id="BuyButton" href="КнижковаСторінка.php?id=' . urlencode($row['Name'] . ' ' . $row['Author']) . '">' . $row['Price'] . '</a>';
        echo '</div>';
    }
    
    echo '</div>';
    echo '</div>';
    echo '</div>';
?>
    <script src="CartBooks.js"></script>
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
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
        <script src="SwiperNovelties.js"></script>
        <script src="Search.js"></script>
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