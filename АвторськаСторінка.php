<?php
include('connect_db.php');

$id = urldecode($_GET['id']);  // отримуємо ідентифікатор автора з URL

// Use prepared statement to prevent SQL injection
$query = "SELECT * FROM `authors` WHERE `AuthorName`=?";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    die("Error in SQL query: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $title = $row['AuthorName'];
} else {
    $title = 'Автор не знайдений';
}

mysqli_stmt_close($stmt); // Close the statement after using it
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="Title Main.css">
    <link rel="stylesheet" href="Carousel of images.css">
    <link rel="stylesheet" href="Book page.css">
    <link rel="stylesheet" href="books.css">
    <link rel="stylesheet" href="CartStyles.css">
    <link rel="stylesheet" href="AuthorsPage.css">
    <link rel="stylesheet" href="AuthorsStyles.css">
    <link rel="stylesheet" href="ScreenAdaptation.css">
    <link rel="icon" type="image/x-icon" href="favicon1.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<header>
    <a id="SearchToggle"><img src="search.png" id="search" width="20px"></a>
    <h1><a id="Title" href="КнигарняTitle.php">Title</a></h1>
    <nav>
        <a id="Catalog" href="Каталог.php">Каталог</a>
        <a id="Authors" href="Автори.php">Автори</a>
        <h1><a id="TitleNav" href="КнигарняTitle.php"><?php echo $title ?></a></h1>
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
    <section>
        <ul class="breadcrumb">
            <li><a href="КнигарняTitle.php">TITLE</a></li>
            <li><a href="Автори.php">Автори</a></li>
            <li><a href="#"><?php echo $row['AuthorName'] ?></a></li>
        </ul>
        <div id="AuthorsContent">
                <img id="AuthorsPicture" src="<?php echo $row['Picture']; ?>">
                <?php
                    $queryBooks = "SELECT * FROM books";
                    $resultBooks = mysqli_query($conn, $queryBooks);
                    
                    echo '<h2 id="AuthorBooksTitle">Книги автора:</h2>';
                    echo '<div id="AuthorsBooks">';
                    while ($bookRow = mysqli_fetch_array($resultBooks)) {
                        $authorName = $row['AuthorName'];
                        $bookName = $bookRow['Name'];
                        $bookAuthor = $bookRow['Author'];
                        $authorNameParts = explode(" ", $authorName);
                        $bookAuthorLastName = end($authorNameParts);

                    
                        // Check if the author's name is present in the book's name or vice versa
                        if (stripos($bookName, $bookAuthorLastName) !== false || stripos($bookAuthor, $authorName) !== false) {
                            echo '<div class="book-container">';
                            echo '<a href="КнижковаСторінка.php?id=' . urlencode($bookRow['Name'] . ' ' . $bookRow['Author']) . '">';
                            echo '<img class="cover" src="' . $bookRow['Cover'] . '">';
                            echo '</a>';
                            echo '<div class="description">';
                            echo '<div class="book-name">' . $bookRow['Name'] . '</div>';
                            echo '<div class="book-author">' . $bookRow['Author'] . '</div>';
                            echo '<div class="price">' . $bookRow['Price'] . '</div>';
                            echo '</div>';
                            echo '<a class="buy" href="КнижковаСторінка.php?id=' . urlencode($bookRow['Name'] . ' ' . $bookRow['Author']) . '"> Придбати </a>';
                            echo '</div>';
                        }
                    }
                    echo '</div>';

                ?>
            <div id="Col2">
                <h2 id='AuthorsName'><?php echo $row['AuthorName']; ?></h2>
                <h4 id='AuthorsLife'><?php echo $row['YearsOfLife']; ?></h4>
                <p id='AuthorsBibliography'><?php echo $row['Bibliography']; ?></p>
            </div>
        </div>
    </section>
    <script src="Books.js"></script>
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
