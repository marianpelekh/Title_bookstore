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
    <h1><a id="Title" href="index.php">Title</a></h1>
    <nav>
        <a id="Catalog" href="Каталог.php">Каталог</a>
        <a id="Authors" href="Автори.php">Автори</a>
        <h1><a id="TitleNav" href="index.php"><?php echo $title ?></a></h1>
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
            <li><a href="index.php">TITLE</a></li>
            <li><a href="Автори.php">Автори</a></li>
            <li><a href="#"><?php echo $row['AuthorName'] ?></a></li>
        </ul>
        <div id="AuthorsContent">
                <img id="AuthorsPicture" src="<?php echo $row['Picture']; ?>">
                <?php
                    $queryBooks = "SELECT * FROM books ORDER BY SeriesName, NumberInSeries DESC";
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
                            echo '<a href="КнижковаСторінка.php?id=' . urlencode($bookRow['Name'] . ' ' . $bookRow['Author'] . ' ' . $bookRow['BookID']) . '">';
                            echo '<img class="cover" src="' . $bookRow['FrontCover'] . '">';
                            echo '</a>';
                            echo '<div class="description">';
                            echo '<div class="book-name">' . $bookRow['Name'] . '</div>';
                            echo '<div class="book-author">' . $bookRow['Author'] . '</div>';
                            echo '<div class="price">' . $bookRow['Price'] . ' грн</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    echo '</div>';

                ?>
            <div id="Col2">
                <h2 id='AuthorsName'><?php echo $row['AuthorName']; ?></h2>
                <h4 id='AuthorsLife'><?php echo $row['Birth'] . '-' . (is_null($row['Death']) ? '...' : $row['Death']); ?></h4>
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
        <script src="FooterAdder.js" defer></script>
</body>
<footer>
</footer>
</html>
