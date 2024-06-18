<?php
ob_start();
require('connect_db.php');
session_start();
function formatDateToUkrainian($dateString) {
    $months = [
        1 => 'січня', 2 => 'лютого', 3 => 'березня', 4 => 'квітня',
        5 => 'травня', 6 => 'червня', 7 => 'липня', 8 => 'серпня',
        9 => 'вересня', 10 => 'жовтня', 11 => 'листопада', 12 => 'грудня'
    ];

    $date = new DateTime($dateString);
    $day = $date->format('j');
    $month = $months[(int)$date->format('n')];
    $year = $date->format('Y');
    $time = $date->format('H:i');
    
    return "{$day} {$month} {$year} {$time}";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Персональний кабінет</title>
        <link rel="stylesheet" href="Title Main.css">
        <link rel="stylesheet" href="Main page.css">
        <link rel="stylesheet" href="Profile.css">
        <link rel="stylesheet" href="Carousel of images.css">
        <link rel="stylesheet" href="Book page.css">
        <link rel="stylesheet" href="books.css">
        <link rel="stylesheet" href="CartStyles.css">
        <link rel="stylesheet" href="AuthorsStyles.css">
        <link rel="stylesheet" href="ScreenAdaptation.css">
        <link rel="icon" type="image/x-icon" href="favicon1.png">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    </head>
    <header>
        <a id="SearchToggle">
            <img src="search.png" id="search" width="20px">
        </a>
        <h1>
            <a id="Title" href="index.php">Title</a>
        </h1>
        <nav>
            <a id="Catalog" href="Каталог.php">Каталог</a>
            <a id="Authors" href="Автори.php">Автори</a>
            <h1>
                <a id="TitleNav" href="index.php">Title</a>
            </h1>
            <a id="New" href="Новинки.php">Новинки</a>
            <a id="Contacts" href="Контакти.php">Контакти</a>
            <a id="Cabinet" href="Profile.php">
                <img src="personal-icon.png" id="pers-cab" width="20px">
            </a>
        </nav>
        <a id="MainCabinet" href="Profile.php">
            <img src="personal-icon.png" width="20px">
        </a>
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
        <section id="cabinetSection">
            <?php
                if(empty($_SESSION['id'])){
                    echo '<form method="POST" id="LoginForm">';
                    echo '<h3>Авторизація</h3>';
                    echo '<div id="loginInputs">';
                    echo '<input type="text" name="login" placeholder="Введіть логін">';
                    echo '<input type="password" name="pass" placeholder="Введіть пароль">';
                    echo '</div>';
                    echo '<input type="submit" name="enter" value="Ввійти">';
                    echo '<p id="regProposition">Не маєте облікового запису? <input type="submit" name="regPage" value="Зареєструватися"></p>';
                    echo '</form>';
                    if(isset($_POST['enter'])) {
                        echo '<script src="LogFormEnabler.js"></script>';
                        $invalid = false;
                        if (isset($_POST['pass']) and strlen($_POST['pass']) < 8) {
                            $invalid = true;
                        }
                        if (!$invalid){
                            $sql = "SELECT * FROM users WHERE Login='" . $_POST['login'] . "'";
                            $res = mysqli_query($conn, $sql);
                            $result = mysqli_fetch_array($res);
                            
                            if(empty($result) || !password_verify($_POST['pass'], $result['Password'])){
                                echo "<p id='regError'>Користувача з даним логіном та паролем не існує. Перевірте введені дані.</p>";
                            } 
                            else {
                                $_SESSION['id'] = $result['userId'];
                                header('Location: Profile.php');
                            }
                        } else {
                            echo "<p id='regError'>Неправильний логін або пароль</p>";
                        }
                        $_SESSION['login'] = $_POST['login'];
                        
                    }
                    else if (isset($_POST['regPage'])) {
                        header("Location: Register.php");
                        exit;
                    }
                }
                else {
                    $sql = "SELECT * FROM users WHERE userId='". $_SESSION['id'] . "'";
                    $res = mysqli_query($conn, $sql);
                    $result = mysqli_fetch_array($res);
                    echo '<div id="userProfileInfo">';
                    echo '<a id="changeUserPic"><img id="userPict" src="' . $result['image'] . '" alt=" Зображення профілю "></a>';
                    echo '<svg id="userPictRect" width="200" height="200" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">';
                    echo '<rect width="200" height="200" rx="6" fill="#E1D5FF"/>';
                    echo '</svg>';
                    echo '<div id="userInfo">';
                    echo '<h2>Профіль користувача</h2>';
                    echo "<p>Ім'я: " . $result['FirstName'] . '</p>';
                    echo "<p>Прізвище: " . $result['LastName'] . '</p>';
                    echo "<p>По-батькові: " . $result['MiddleName'] . '</p>';
                    echo "<p>Email: " . $result['Email'] . '</p>';
                    echo '<div id="userInfoBtns">';
                    echo '<form method="POST" id="changePassForm">';
                    echo '<input type="submit" name="changePass" value="Змінити пароль">';
                    echo '</form>';
                    if (isset($_POST['changePass'])){
                        echo $_POST['changePass'];
                        header('Location: changePassword.php');
                    }
                    echo '<script src="ExitFormAdder.js"></script>';
                    if(isset($_POST['exit'])) {
                        echo '<script src="UpdateStoredBooks.js"></script>';
                        session_destroy();
                        header('Location: Profile.php');
                        exit;
                    }
                    if (!empty($result['StoredBooks'])) {
                        $storedBooks = json_encode(json_decode($result['StoredBooks'], true), JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE);
                        $tableStoredBooks = $result['StoredBooks'];
                        echo "<script>
                                const booksData = $storedBooks;
                                const tableBooksData = $tableStoredBooks;
                                console.log('Books Data:', booksData);
                                console.log('Table Books Data: ', tableBooksData);
                                window.localStorage.setItem('books', JSON.stringify(booksData));
                            </script>";
                    } else {
                        echo "<script>
                                console.error('No stored books');
                                window.localStorage.setItem('books', JSON.stringify([]));
                            </script>";
                    }
                            
                    
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';


                    //ДРУГА ЧАСТИНА СТОРІНКИ (ЗАЛЕЖНА ВІД ТИПУ КОРИСТУВАЧА)



                    if (isset($_SESSION["login"]) && $_SESSION["login"] != null && $_SESSION['login'] == "admin") {
                        echo '<script src="adminFormsAdder.js" defer></script>';
                        echo "<select id='baseBookCodeSelect' class='bookCodeSelect' style='display: none;'>
                              <option value='' disabled selected>Оберіть книгу</option>";
                              $select_books_sql = "SELECT * FROM books ORDER BY SeriesName, NumberInSeries, ShortName ASC";
                              $result = mysqli_query($conn, $select_books_sql);
                              while ($row = mysqli_fetch_assoc($result)) {
                                  echo "<option value='" . $row['BookID'] . "'>" . $row['Name'] . "</option>";
                              }
                        echo "</select>";
                        echo "<select id='baseBookGenreSelect' style='display: none;'>
                                <option value='' disabled selected>Жанр</option>
                                <option value='Fantasy'>Фентезі та фантастика</option>
                                <option value='Horrors'>Горрори | Трилери</option>
                                <option value='Dark Academia'>Dark academia</option>
                                <option value='Light Academia'>Light academia</option>
                                <option value='Detective'>Детектив</option>
                                <option value='Gothic'>Готика</option>
                                <option value='Other prose'>Інша проза</option>
                                <option value='Poetry'>Поезія</option>
                              </select>";
                        echo "<select id='baseAuthorSelect' class='authorSelect' style='display: none;'>
                              <option value='' disabled selected>Оберіть автора</option>";
                              $select_books_sql = "SELECT * FROM authors ORDER BY AuthorName ASC";
                              $result = mysqli_query($conn, $select_books_sql);
                              while ($row = mysqli_fetch_assoc($result)) {
                                  echo "<option value='" . $row['id'] . "'>" . $row['AuthorName'] . "</option>";
                              }
                        echo "</select>";
                    } 
                    else {
                        echo '<h2 id="YourOrdersTitle">Ваші замовлення</h2>';
                        echo '<div id="YourOrders">';
                        $orders_sql = "SELECT * FROM orders WHERE userId = '" . $_SESSION['id'] . "' ORDER BY FIELD(Status, 'New', 'Processing', 'Shipping', 'Delivered', 'Canceled'), OrderDate DESC";

                        $orders_res = mysqli_query($conn, $orders_sql);

                        while ($or_row = mysqli_fetch_array($orders_res)) {
                            $formattedDate = formatDateToUkrainian($or_row['OrderDate']);
                            echo '<div id="Order">';
                            echo '<p id="OrderStatus">' . $or_row['Status'] . '</p>';
                            echo '<p id="OrderDate">' . $formattedDate . '</p>';
                            echo '<div id="OrderCovers"><a class="ViewOrderBooks"><img src="books.png" alt="Переглянути книги"></a></div>';
                            echo '<p id="OrderPrice">' . $or_row['TotalPrice'] . ' грн</p>';
                            echo "<div id='OrdersList'>";
                            $bookIds = json_decode($or_row['BookIDs'], true);
                            foreach ($bookIds as $bookId) {
                                $book_sql = "SELECT * FROM books WHERE BookID = '" . $bookId['code'] . "'";
                                $book_res = mysqli_query($conn, $book_sql);
                                $book_row = mysqli_fetch_array($book_res);
                                
                                echo '<div id="OrdersBook">';
                                echo '<a href="КнижковаСторінка.php?id=' . urlencode($book_row['Name'] . ' ' . $book_row['Author'] . ' ' . $book_row['BookID']) . '">';
                                echo '<img src="' . $book_row['FrontCover'] . '" alt="' . $book_row['ShortName'] . '">';
                                echo '</a>';
                                echo '<p>' . $book_row['Name'] . '</p>';
                                echo '<p>' . $book_row['Author'] . '</p>';
                                echo '<p>' . $book_row['Price'] . ' грн x ' . $bookId['quantity'] . ' од.</p>';
                                echo '<h5>' . intval($book_row['Price']) * intval($bookId['quantity']) . ' грн</h5>';
                                echo '</div>';
                            }
                            echo '</div>';
                            echo '</div>';
                        }
                        echo '</div>';

                        echo '<h2 id="titleForRecs">Рекомендації для вас</h2>';
                        echo '<div id="UserFeatures">';
                        if(isset($_SESSION['id'])) {
                            $userId = $_SESSION['id'];

                            $sql = "SELECT FeaturedGenres FROM users WHERE userId = $userId";
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            $featuredGenres = json_decode($row['FeaturedGenres'], true);
                        
                            if (!empty($featuredGenres)) {

                                arsort($featuredGenres);
                                $featuredGenresKeys = array_keys($featuredGenres);

                                $genresString = implode("','", array_map('strtolower', $featuredGenresKeys));

                                $featuredSql = "SELECT * FROM books WHERE `Genre` IN ('$genresString') ORDER BY FIELD(`Genre`, '$genresString'), `SeriesName`, `NumberInSeries`";
                            } else {
                                $featuredSql = "SELECT * FROM books ORDER BY `SeriesName`, `NumberInSeries`";
                            }
                        }
                        
                        $responseBooks = mysqli_query($conn, $featuredSql);
                        while ($row = mysqli_fetch_array($responseBooks)) {
                            echo '<div class="book-container" data-genre="' . $row["Genre"] . '">';
                            echo '<a href="КнижковаСторінка.php?id=' . urlencode($row['Name'] . ' ' . $row['Author'] . ' ' . $row['BookID']) . '">';
                            echo '<img class="cover" src="' . $row['FrontCover'] . '">';
                            echo '</a>';
                            echo '<div class="description">';
                            echo '<div class="book-name">' . $row['Name'] . '</div>';
                            echo '<div class="book-author">' . $row['Author'] . '</div>';
                            echo '<div class="price">' . $row['Price'] . ' грн</div>';
                            echo '</div>';
                            echo '<a class="buy" href="КнижковаСторінка.php?id=' . urlencode($row['Name'] . ' ' . $row['Author'] . ' ' . $row['BookID']) . '"> Придбати </a>';
                            echo '</div>';
                        }
                        echo '</div>';
                        echo '<script src="orderBooksShow.js"></script>';
                    }
                }
            ?>
            <div id="backdropShadow">
            <form id="UploadImageForm" action="UploadPictures.php" method="post" enctype="multipart/form-data">
                <h3>Завантажити зображення</h3><br>
                <label for="file">Виберіть фото:</label>
                <input type="file" name="file" id="file">
                <input type="submit" value="Завантажити">
                <a id="closeUploadForm"><img id="closeUploadFormImage" src="close.png" width="25"></a>
            </form></div>
        </section>
        <script src="CloseUploadForm.js"></script>
        <script src="Search.js"></script>
        <script src="SetDiscounts.js"></script>
        <script src="FooterAdder.js" defer></script>
    </body>
    <footer>
    </footer>
</html>
<?php
ob_end_flush();
?>