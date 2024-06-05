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

            $novelties = [];

            $query = "SELECT * FROM books";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_array($result)) {
                $date1 = new DateTime($row['DateExact']);
                $date2 = new DateTime();
                if ($date1 > $date2) {
                    continue;
                }
                $interval = $date1->diff($date2);
                if ($interval->y == 0 && $interval->m < 2){
                    $novelties[] = $row;
                }
            }

            echo '<div id="Novelties">';
            echo '<div class="content">';
            echo '<div class="swiperContent">';
            echo '<div class="swiper">';
            echo '<div class="swiper-wrapper">';
            
            foreach ($novelties as $row) {
                echo '<div class="swiper-slide" style="display: flex; justify-content: center; align-items: center; max-height: 500px;" related-book="' . $row['BookID'] . '">';
                echo '<a href="КнижковаСторінка.php?id=' . urlencode($row['Name'] . ' ' . $row['Author'] . ' ' . $row['BookID']) . '">';
                echo '<img class="cover" width="250rem" src="' . $row['FrontCover'] . '">';
                echo '</a>';
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            
            echo '<div class="info">';
            foreach ($novelties as $row) {
                echo '<div class="relatedInfo" related-book="' . $row['BookID'] . '">';
                echo '<div id="BookTitle">' . $row['ShortName'] . '</div>';
                echo '<div id="BookAuthor">' . $row['Author'] . '</div>';
                echo '<div id="BookDesc">' . $row['Description'] . '</div>';
                echo '<button id="BuyButton" href="КнижковаСторінка.php?id=' . urlencode($row['Name'] . ' ' . $row['Author'] . ' ' . $row['BookID']) . '">' . $row['Price'] . ' грн</button>';
                echo '<a id="UnderBuyButton" href="КнижковаСторінка.php?id=' . urlencode($row['Name'] . ' ' . $row['Author'] . ' ' . $row['BookID']) . '"> ПРИДБАТИ </a>';
                echo '</div>';
            }
            
            echo '</div>';
            echo '</div>';
            echo '</div>';
        ?>
    <script src="CartBooks.js"></script>
    <script src="SetDiscounts.js"></script>
    <script>
            document.addEventListener('DOMContentLoaded', function () {
                const menuToggle = document.getElementById('menuToggle');
                const navs = document.querySelectorAll('nav');
                const cabinet = document.getElementById('Cabinet');
                
                menuToggle.addEventListener('click', function () {
                    navs.forEach(nav => {
                    if (nav.style.display === 'grid') {
                        nav.style.display = 'none';
                        nav.style.gridRow = 'initial';
                        nav.style.gridColumn = 'initial';
                        nav.classList.remove('active-menu');
                    } else {
                        nav.style.display = 'grid';
                        nav.classList.add('active-menu');
                    }   
                    });
                });
                let buyBtns = document.querySelectorAll('#BuyButton');
                buyBtns.forEach(buyBtn  => {
                    buyBtn.addEventListener('click', function() {
                        window.location.href = buyBtn.getAttribute('href');;
                    })
                })
            });
        </script> 
        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
        <script src="SwiperNovelties.js"></script>
        <script src="Search.js"></script>
        <script src="FooterAdder.js" defer></script>
</body>
<footer>
</footer>
</html>