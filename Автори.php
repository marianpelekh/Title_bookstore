<!DOCTYPE html>
<html lang="UTF-8">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Автори. Title Bookstore</title>
    <link rel="stylesheet" href="Title Main.css">
    <link rel="stylesheet" href="Carousel of images.css">
    <link rel="stylesheet" href="Main page.css">
    <link rel="stylesheet" href="books.css">
    <link rel="stylesheet" href="CartStyles.css">
    <link rel="stylesheet" href="AuthorsStyles.css">
    <link rel="stylesheet" href="ScreenAdaptation.css">
    <link rel="icon" type="image/x-icon" href="favicon1.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<!-- <style>
    body {
        background-image: url(https://images.pexels.com/photos/3527796/pexels-photo-3527796.jpeg?cs=srgb&dl=pexels-didsss-3527796.jpg&fm=jpg);
    }
</style> -->
<header>
    <a id="SearchToggle"><img src="search.png" id="search" width="20px"></a>
    <h1><a id="Title" href="index.php">Title</a></h1>
    <nav>
        <a id="Catalog" href="Каталог.php">Каталог</a>
        <a id="Authors" href="Автори.php">Автори</a>
        <h1><a id="TitleNav" href="index.php">Title</a></h1>
        <a id="New" href="Новинки.php">Новинки</a>
        <a id="Contacts" href="Контакти.php">Контакти</a>
        <a id="Cabinet" href="Profile.php"><img src="personal-icon.png" id="pers-cab" width="20px"></a>
    </nav>
    <a id="MainCabinet" href="Profile.php"><img src="personal-icon.png" width="20px"></a>
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
        <div id="AuthorsTitle">Автори</div>
        <?php
            include('connect_db.php');

            $query = "SELECT * FROM authors ORDER BY `AuthorName` COLLATE utf8mb4_general_ci";
            $result = mysqli_query($conn, $query);
            
            echo '<div id="AllAuthors">';
            while ($row = mysqli_fetch_array($result)) {
                echo '<button type="button" class="AuthorContainer" onclick="window.location.href=\'АвторськаСторінка.php?id=' . urlencode($row['id']) . '\';">' . $row['AuthorName'] . '</button>';
            }
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
        <script src="Search.js"></script>
        <script src="FooterAdder.js" defer></script>
</body>
<footer>
</footer>
</html>