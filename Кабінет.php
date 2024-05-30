<?php
ob_start();
require('connect_db.php');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сторінка користувача</title>
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
                $sql = "SELECT * FROM users WHERE Login='" . $_POST['login'] . "' AND Password='" . $_POST['pass'] . "'";
                $res = mysqli_query($conn, $sql);
                $result = mysqli_fetch_array($res);
                
                if(empty($result)){
                    echo "<p id='regError'>Користувача з даним логіном та паролем не існує. Перевірте введені дані.</p>";
                } 
                else {
                    $_SESSION['id'] = $result['userId'];
                    header('Location: Кабінет.php');
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
            header('Location: Кабінет.php');
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
        if (isset($_SESSION["login"]) && $_SESSION["login"] != null && $_SESSION['login'] == "admin") {
            echo "<div id='addDiscountFormDiv'>
                  <form action='add_discounts.php' method='POST'>
                  <h4>Додати знижку на книгу</h4>
                  <select id='DiscountBookId' name='discountBookId'>";
            echo "<option value='' disabled selected>Виберіть книгу для додавання знижки</option>";
            $select_books_sql = "SELECT * FROM books";
            $result = mysqli_query($conn, $select_books_sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['number'] . "'>" . $row['Name'] . "</option>";
            }
            echo "</select>
                  <input type='text' name='discountValue' placeholder='Відсоток знижки'>
                  <div id='expirationInput'>Дата закінчення знижки: <input type='date' name='expirationDate'></div>
                  <input type='submit' value='Додати знижку' name='setDiscount'>";


            echo "<div id='addFormDiv'>";
            echo "<form action='' method='POST'>";
            echo "<h4>Форма для додавання книг</h4>
                  <input type='text' name='ShortName' placeholder='Коротка назва'>
                  <input type='text' name='BookCode' placeholder='Код книги'>
                  <input type='text' name='FullName' placeholder='Повна назва'>
                  <input type='text' name='Author' placeholder='Автор'>
                  <input type='text' name='Publishing' placeholder='Видавництво'>
                  <input type='text' name='Price' placeholder='Ціна'>
                  <input type='text' name='CoverURL' placeholder='Посилання на обкладинку (перед)'>
                  <input type='text' name='RearCoverURL' placeholder='Посилання на обкладинку (тил)'>
                  <input type='text' name='PageNumber' placeholder='Кількість сторінок'>
                  <input type='text' name='Language' placeholder='Мова'>
                  <input type='text' name='PublishingYear' maxlength='4' placeholder='Рік видання'>
                  <input type='date' name='ExactPublishingDate' placeholder='Точна дата видання'>
                  <input type='text' name='Annotation' placeholder='Анотація'>
                  <input type='text' name='Genre' placeholder='Жанр'>
                  <div class='isSeriesDiv'><p>Це серія?</p>
                  <input type='checkbox' name='IsSeries'></div>
                  <input type='text' name='SeriesName' placeholder='Назва серії'>
                  <input type='number' name='InSeriesNumber' placeholder='Номер в серії'>
                  <input type='submit' value='Додати книгу' name='addBtn'>
                  <form></div>";
            echo "<div id='EditFormDiv'>";
            //Вибір книги для редагування
            echo "<form action='' method='POST'>";
            echo "<h4>Форма для редагування книг</h4>
                  <select name='bookCodeEdit' onchange='this.form.submit()'>";
            echo "<option value='' disabled selected>Виберіть код книги для редагування</option>";
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['number'] . "'>" . $row['Name'] . "</option>";
            }
            echo "</select>";
            echo "</form>";

            // Відображення форми для редагування
            if(isset($_POST['bookCodeEdit'])) {
                $selected_book_code = $_POST['bookCodeEdit'];
                $selected_book_query = "SELECT * FROM books WHERE number='$selected_book_code'";
                $selected_book_result = mysqli_query($conn, $selected_book_query);
                $selected_book_row = mysqli_fetch_assoc($selected_book_result);
                
                // Форма для редагування
                echo "<form action='' method='POST'>";
                echo "<input type='text' name='ShortNameEdit' value='" . $selected_book_row['ShortName'] . "' placeholder='Коротка назва'>";
                echo "<input type='text' name='BookCodeEdit' value='" . $selected_book_row['number'] . "' placeholder='Код книги'>";
                echo "<input type='text' name='FullNameEdit' value='" . $selected_book_row['Name'] . "' placeholder='Повна назва'>";
                echo "<input type='text' name='AuthorEdit' value='" . $selected_book_row['Author'] . "' placeholder='Автор'>";
                echo "<input type='text' name='PublishingEdit' value='" . $selected_book_row['Publishing'] . "' placeholder='Видавництво'>";
                echo "<input type='text' name='PriceEdit' value='" . $selected_book_row['Price'] . "' placeholder='Ціна'>";
                echo "<input type='text' name='CoverURLEdit' value='" . $selected_book_row['Cover'] . "' placeholder='Посилання на обкладинку (перед)'>";
                echo "<input type='text' name='RearCoverURLEdit' value='" . $selected_book_row['BackCover'] . "' placeholder='Посилання на обкладинку (тил)'>";
                echo "<input type='text' name='PageNumberEdit' value='" . $selected_book_row['PageNumbers'] . "' placeholder='Кількість сторінок'>";
                echo "<input type='text' name='LanguageEdit' value='" . $selected_book_row['Language'] . "' placeholder='Мова'>";
                echo "<input type='text' name='PublishingYearEdit' value='" . $selected_book_row['YearOfPubl'] . "' maxlength='4' placeholder='Рік видання'>";
                echo "<input type='date' name='ExactPublishingDateEdit' value='" . $selected_book_row['DateExact'] . "' placeholder='Точна дата видання'>";
                echo "<input type='text' name='AnnotationEdit' value='" . $selected_book_row['Description'] . "' placeholder='Анотація'>";
                echo "<input type='text' name='GenreEdit' value='" . $selected_book_row['Genre'] . "' placeholder='Жанр'>";
                echo "<div class='isSeriesDiv'><p>Це серія?</p>
                      <input type='checkbox' name='IsSeries' " . ($selected_book_row['IsSeries'] ? 'checked' : '') . "></div>";
                echo "<input type='text' name='SeriesNameEdit' value='" . $selected_book_row['SeriesName'] . "' placeholder='Назва серії'>";
                echo "<input type='number' name='InSeriesNumberEdit' value='" . $selected_book_row['NumberInSeries'] . "' placeholder='Номер в серії'>";
                echo "<input type='submit' value='Оновити книгу' name='editBtn'>";
                echo "</form>";
            }

            echo "</div>";

            //Видалення книги
            echo "<div id='DeleteFormDiv'>";
            echo "<form action='' method='POST'>";
            echo "<h4>Форма для видалення книг</h4>
                  <select name='bookCodeDelete'>";
            echo "<option value='' disabled selected>Виберіть код книги для видалення</option>";
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['number'] . "'>" . $row['Name'] . "</option>";
            }
            echo "</select>";
            echo "<input type='submit' value='Видалити книгу' name='deleteBtn'>";
            echo "</form>";
            echo "</div>";

            // Оновлення книги в БД після редагування
            if (isset($_POST['editBtn'])) {
                $edited_shortName = mysqli_real_escape_string($conn, $_POST['ShortNameEdit']);
                $edited_fullName = mysqli_real_escape_string($conn, $_POST['FullNameEdit']);
                $edited_book_code = mysqli_real_escape_string($conn, $_POST['bookCodeEdit']);
                $edited_author = mysqli_real_escape_string($conn, $_POST['AuthorEdit']);
                $edited_publishing = mysqli_real_escape_string($conn, $_POST['PublishingEdit']);
                $edited_price = mysqli_real_escape_string($conn, $_POST['PriceEdit']);
                $edited_coverURL = mysqli_real_escape_string($conn, $_POST['CoverURLEdit']);
                $edited_rearCoverURL = mysqli_real_escape_string($conn, $_POST['RearCoverURLEdit']);
                $edited_pageNumber = mysqli_real_escape_string($conn, $_POST['PageNumberEdit']);
                $edited_language = mysqli_real_escape_string($conn, $_POST['LanguageEdit']);
                $edited_publishingYear = mysqli_real_escape_string($conn, $_POST['PublishingYearEdit']);
                $edited_exactPublishingDate = mysqli_real_escape_string($conn, $_POST['ExactPublishingDateEdit']);
                $edited_annotation = mysqli_real_escape_string($conn, $_POST['AnnotationEdit']);
                $edited_genre = mysqli_real_escape_string($conn, $_POST['GenreEdit']);
                $edited_isSeries = mysqli_real_escape_string($conn, $_POST['IsSeriesEdit']);
                $edited_seriesName = mysqli_real_escape_string($conn, $_POST['SeriesNameEdit']);
                $edited_inSeriesNumber = mysqli_real_escape_string($conn, $_POST['InSeriesNumberEdit']);
                
                $update_sql = "UPDATE books SET ShortName='$edited_shortName', Name='$edited_fullName', number='$edited_book_code', Author='$edited_author', Publishing='$edited_publishing', Price='$edited_price', Cover='$edited_coverURL', BackCover='$edited_rearCoverURL', PageNumbers='$edited_pageNumber', Language='$edited_language', YearOfPubl='$edited_publishingYear', DateExact='$edited_exactPublishingDate', Description='$edited_annotation', Genre='$edited_genre', IsSeries='$edited_isSeries', SeriesName='$edited_seriesName', NumberInSeries='$edited_inSeriesNumber' WHERE number='$edited_book_code'";
                
                mysqli_query($conn, $update_sql);
            }

            // Видалення книги з БД
            if (isset($_POST['deleteBtn'])) {
                $deleted_book_code = mysqli_real_escape_string($conn, $_POST['bookCodeDelete']);
                $delete_sql = "DELETE FROM books WHERE number='$deleted_book_code'";
                mysqli_query($conn, $delete_sql);
            }

            // Додавання книги в БД
            if (isset($_POST['addBtn'])) {
                $shortName = mysqli_real_escape_string($conn, $_POST['ShortName']);
                $bookCode = mysqli_real_escape_string($conn, $_POST['BookCode']);
                $fullName = mysqli_real_escape_string($conn, $_POST['FullName']);
                $author = mysqli_real_escape_string($conn, $_POST['Author']);
                $publishing = mysqli_real_escape_string($conn, $_POST['Publishing']);
                $price = mysqli_real_escape_string($conn, $_POST['Price']);
                $coverURL = mysqli_real_escape_string($conn, $_POST['CoverURL']);
                $rearCoverURL = mysqli_real_escape_string($conn, $_POST['RearCoverURL']);
                $pageNumber = mysqli_real_escape_string($conn, $_POST['PageNumber']);
                $language = mysqli_real_escape_string($conn, $_POST['Language']);
                $publishingYear = mysqli_real_escape_string($conn, $_POST['PublishingYear']);
                $exactPublishingDate = mysqli_real_escape_string($conn, $_POST['ExactPublishingDate']);
                $annotation = mysqli_real_escape_string($conn, $_POST['Annotation']);
                $genre = mysqli_real_escape_string($conn, $_POST['Genre']);
                $isSeries = mysqli_real_escape_string($conn, $_POST['IsSeries']);
                $seriesName = mysqli_real_escape_string($conn, $_POST['SeriesName']);
                $inSeriesNumber = mysqli_real_escape_string($conn, $_POST['InSeriesNumber']);
                
                if ($isSeries == true) {
                    $isSeries = 1;
                } else {
                    $isSeries = 0;
                }
                
                $adding_sql = "INSERT INTO books (ShortName, number, Name, Author, Publishing, Price, Cover, BackCover, PageNumbers, Language, YearOfPubl, DateExact, Description, Genre, IsSeries, SeriesName, NumberInSeries) VALUES ('$shortName', '$bookCode', '$fullName', '$author', '$publishing', '$price', '$coverURL', '$rearCoverURL', '$pageNumber', '$language', '$publishingYear', '$exactPublishingDate', '$annotation', '$genre', '$isSeries', '$seriesName', '$inSeriesNumber')";
                
                if (mysqli_query($conn, $adding_sql)) {
                    echo "Результат: Книгу додано успішно :)";
                } else {
                    echo "Результат: Сталася якась помилка :(";
                }
            }
        } else {
            echo '<label id="titleForRecs" for="UserFeatures"><h2>Рекомендації для вас</h2>';
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
                    //Якщо немає улюблених жанрів, вибрати усі книги
                    $featuredSql = "SELECT * FROM books ORDER BY `SeriesName`, `NumberInSeries`";
                }
            } else {
                //Або якщо користувач не авторизований, вибрати усі книги
                $featuredSql = "SELECT * FROM books";
            }
            
            $responseBooks = mysqli_query($conn, $featuredSql);
            while ($row = mysqli_fetch_array($responseBooks)) {
                echo '<div class="book-container" data-genre="' . $row["Genre"] . '">';
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
            echo '</div>';
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
<?php
ob_end_flush();
?>