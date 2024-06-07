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
            echo "<h3 id='AdminFormsTitle'>Форми для адміністрування сайту</h3>
                  <div id='formsTabs'>
                    <a id='booksAdminFormsA' class='active' href='#booksAdminForms'>Книги</a>
                    <a id='authorsAdminFormsA' href='#authorsAdminForms'>Автори</a>
                    <a id='publishersAdminFormsA' href='#publishersAdminForms'>Видавництва</a>
                    <a id='commentsAdminFormsA' href='#commentsAdminForms'>Коментарі</a>
                    <a id='ordersAdminFormsA' href='#ordersAdminForms'>Замовлення</a>
                  </div>
                  <div id='adminForms'>
                  <div id='adminFormsDiv'>
                  <div id='booksAdminForms' class='adminFormContent'>
                  <div id='addDiscountFormDiv'>
                  <form action='add_discounts.php' method='POST'>
                  <h4>Додати знижку на книгу</h4>
                  <select id='DiscountBookId' name='discountBookId'>";
            echo "<option value='' disabled selected>Виберіть книгу для додавання знижки</option>";
            $select_books_sql = "SELECT * FROM books ORDER BY SeriesName, NumberInSeries, ShortName ASC";
            $result = mysqli_query($conn, $select_books_sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['BookID'] . "'>" . $row['Name'] . "</option>";
            }
            echo "</select>
                  <input type='text' name='discountValue' placeholder='Відсоток знижки'>
                  <div id='expirationInput'><h5>Дата закінчення знижки:</h5> <input type='date' name='expirationDate'></div>
                  <button name='setDiscount'>Додати знижку</button></form></div>";


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
                  <input type='date' name='ExactPublishingDate' placeholder='Точна дата видання'>
                  <textarea name='Annotation' placeholder='Анотація'></textarea>
                  <select name='Genre'>
                  <option value='' disabled selected>Жанр</option>
                  <option value='Fantasy'>Фентезі та фантастика</option>
                  <option value='Horrors'>Горрори | Трилери</option>
                  <option value='Dark Academia'>Dark academia</option>
                  <option value='Light Academia'>Light academia</option>
                  <option value='Detective'>Детектив</option>
                  <option value='Gothic'>Готика</option>
                  <option value='Other prose'>Інша проза</option>
                  <option value='Poetry'>Поезія</option>
                  </select>
                  <input type='text' name='SeriesName' placeholder='Назва серії'>
                  <input type='number' step='0.1' name='InSeriesNumber' placeholder='Номер в серії'>
                  <input type='submit' value='Додати книгу' name='addBtn'>
                  <form></div>";
            echo "<div id='EditFormDiv'>";
            //Вибір книги для редагування
            echo "<form action='' method='POST'>";
            echo "<h4>Форма для редагування книг</h4>
                  <select name='bookCodeEdit' onchange='this.form.submit()'>";
            echo "<option value='' disabled selected>Виберіть код книги для редагування</option>";
            $select_books_sql_2 = "SELECT * FROM books ORDER BY SeriesName, NumberInSeries, ShortName ASC";
            $result_2 = mysqli_query($conn, $select_books_sql_2);
            while ($rowi = mysqli_fetch_assoc($result_2)) {
                echo "<option value='" . $rowi['BookID'] . "'>" . $rowi['Name'] . "</option>";
            }
            echo "</select>";
            echo "</form>";

            // Відображення форми для редагування
            if (isset($_POST['bookCodeEdit'])) {
                $selected_book_code = $_POST['bookCodeEdit'];
                $selected_book_query = "SELECT * FROM books WHERE BookID='$selected_book_code'";
                $selected_book_result = mysqli_query($conn, $selected_book_query);
                $selected_book_row = mysqli_fetch_assoc($selected_book_result);
            
                // Set the charset for the MySQL connection
                mysqli_set_charset($conn, "utf8");
            
                // Форма для редагування
                echo "<form action='' method='POST' id='editBookForm'>";
                echo "<input type='text' name='ShortNameEdit' value='" . htmlspecialchars($selected_book_row['ShortName'], ENT_QUOTES, 'UTF-8') . "' placeholder='Коротка назва'>";
                echo "<input type='text' name='BookCodeEdit' value='" . htmlspecialchars($selected_book_row['BookID'], ENT_QUOTES, 'UTF-8') . "' placeholder='Код книги'>";
                echo "<input type='text' name='FullNameEdit' value='" . htmlspecialchars($selected_book_row['Name'], ENT_QUOTES, 'UTF-8') . "' placeholder='Повна назва'>";
                echo "<input type='text' name='AuthorEdit' value='" . htmlspecialchars($selected_book_row['Author'], ENT_QUOTES, 'UTF-8') . "' placeholder='Автор'>";
                echo "<input type='text' name='PublishingEdit' value='" . htmlspecialchars($selected_book_row['Publishing'], ENT_QUOTES, 'UTF-8') . "' placeholder='Видавництво'>";
                echo "<input type='text' name='PriceEdit' value='" . htmlspecialchars($selected_book_row['Price'], ENT_QUOTES, 'UTF-8') . "' placeholder='Ціна'>";
                echo "<input type='text' name='CoverURLEdit' value='" . htmlspecialchars($selected_book_row['FrontCover'], ENT_QUOTES, 'UTF-8') . "' placeholder='Посилання на обкладинку (перед)'>";
                echo "<input type='text' name='RearCoverURLEdit' value='" . htmlspecialchars($selected_book_row['BackCover'], ENT_QUOTES, 'UTF-8') . "' placeholder='Посилання на обкладинку (тил)'>";
                echo "<input type='text' name='PageNumberEdit' value='" . htmlspecialchars($selected_book_row['PagesNumber'], ENT_QUOTES, 'UTF-8') . "' placeholder='Кількість сторінок'>";
                echo "<input type='text' name='LanguageEdit' value='" . htmlspecialchars($selected_book_row['Language'], ENT_QUOTES, 'UTF-8') . "' placeholder='Мова'>";
                echo "<input type='date' name='ExactPublishingDateEdit' value='" . htmlspecialchars($selected_book_row['DateExact'], ENT_QUOTES, 'UTF-8') . "' placeholder='Точна дата видання'>";
                echo "<textarea name='AnnotationEdit' placeholder='Анотація'>". htmlspecialchars($selected_book_row['Description'], ENT_QUOTES, 'UTF-8') . "</textarea>";
                //echo "<input type='text' name='GenreEdit' value='" . htmlspecialchars($selected_book_row['Genre'], ENT_QUOTES, 'UTF-8') . "' placeholder='Жанр'>";
                echo "<select name='GenreEdit'>
                      <option value='".htmlspecialchars($selected_book_row['Genre'], ENT_QUOTES, 'UTF-8')."' selected>" . htmlspecialchars($selected_book_row['Genre'], ENT_QUOTES, 'UTF-8') . "</option>
                      <option value='Fantasy'>Фентезі та фантастика</option>
                      <option value='Horrors'>Горрори | Трилери</option>
                      <option value='Dark Academia'>Dark academia</option>
                      <option value='Light Academia'>Light academia</option>
                      <option value='Detective'>Детектив</option>
                      <option value='Gothic'>Готика</option>
                      <option value='Other prose'>Інша проза</option>
                      <option value='Poetry'>Поезія</option>
                      </select>";
                echo "<input type='text' name='SeriesNameEdit' value='" . htmlspecialchars($selected_book_row['SeriesName'], ENT_QUOTES, 'UTF-8') . "' placeholder='Назва серії'>";
                echo "<input type='number' step='0.1' name='InSeriesNumberEdit' value='" . htmlspecialchars($selected_book_row['NumberInSeries'], ENT_QUOTES, 'UTF-8') . "' placeholder='Номер в серії'>";
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
                echo "<option value='" . $row['BookID'] . "'>" . $row['Name'] . "</option>";
            }
            echo "</select>";
            echo "<input type='submit' value='Видалити книгу' name='deleteBtn'>";
            echo "</form>";
            echo "</div></div>
                  <div id='authorsAdminForms' class='adminFormContent'></div>
                  <div id='publisheradminForms' class='adminFormContent'></div>
                  <div id='commentsAdminForms' class='adminFormContent'></div>
                  <div id='ordersAdminForms' class='adminFormContent'></div></div></div>";
            // Оновлення книги в БД після редагування
            if (isset($_POST['editBtn'])) {
                $edited_shortName = mysqli_real_escape_string($conn, $_POST['ShortNameEdit']);
                $edited_fullName = mysqli_real_escape_string($conn, $_POST['FullNameEdit']);
                $edited_book_code = mysqli_real_escape_string($conn, $_POST['BookCodeEdit']);
                $edited_author = mysqli_real_escape_string($conn, $_POST['AuthorEdit']);
                $edited_publishing = mysqli_real_escape_string($conn, $_POST['PublishingEdit']);
                $edited_price = mysqli_real_escape_string($conn, $_POST['PriceEdit']);
                $edited_coverURL = mysqli_real_escape_string($conn, $_POST['CoverURLEdit']);
                $edited_rearCoverURL = mysqli_real_escape_string($conn, $_POST['RearCoverURLEdit']);
                $edited_pageNumber = mysqli_real_escape_string($conn, $_POST['PageNumberEdit']);
                $edited_language = mysqli_real_escape_string($conn, $_POST['LanguageEdit']);
                $edited_exactPublishingDate = mysqli_real_escape_string($conn, $_POST['ExactPublishingDateEdit']);
                $edited_annotation = mysqli_real_escape_string($conn, $_POST['AnnotationEdit']);
                $edited_genre = mysqli_real_escape_string($conn, $_POST['GenreEdit']);
                $edited_seriesName = mysqli_real_escape_string($conn, $_POST['SeriesNameEdit']);
                $edited_inSeriesNumber = mysqli_real_escape_string($conn, $_POST['InSeriesNumberEdit']);
                if (!empty($edited_seriesName)) {
                    $edited_isSeries = 1;
                } else {
                    $edited_isSeries = 0;
                }
                $update_sql = "UPDATE books SET ShortName='$edited_shortName', Name='$edited_fullName', BookID='$edited_book_code', Author='$edited_author', Publishing='$edited_publishing', Price='$edited_price', FrontCover='$edited_coverURL', BackCover='$edited_rearCoverURL', PagesNumber ='$edited_pageNumber', Language='$edited_language', DateExact='$edited_exactPublishingDate', Description='$edited_annotation', Genre='$edited_genre', SeriesName='$edited_seriesName', NumberInSeries='$edited_inSeriesNumber' WHERE BookID='$edited_book_code'";
                if(mysqli_query($conn, $update_sql)) {
                    echo "Книгу '" . $edited_shortName .  "' успішно оновлено.";
                }
            }

            // Видалення книги з БД
            if (isset($_POST['deleteBtn'])) {
                $deleted_book_code = mysqli_real_escape_string($conn, $_POST['bookCodeDelete']);
                $delete_sql = "DELETE FROM books WHERE BookID='$deleted_book_code'";
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
                $exactPublishingDate = mysqli_real_escape_string($conn, $_POST['ExactPublishingDate']);
                $annotation = mysqli_real_escape_string($conn, $_POST['Annotation']);
                $genre = mysqli_real_escape_string($conn, $_POST['Genre']);
                $seriesName = mysqli_real_escape_string($conn, $_POST['SeriesName']);
                $inSeriesNumber = mysqli_real_escape_string($conn, $_POST['InSeriesNumber']);
                $isSeries;
                if (!empty($seriesName)) {
                    $isSeries = 1;
                } else {
                    $isSeries = 0;
                }
                
                $adding_sql = "INSERT INTO books (ShortName, BookID, Name, Author, Publishing, Price, FrontCover, BackCover, PagesNumber, Language, DateExact, Description, Genre, SeriesName, NumberInSeries) VALUES ('$shortName', '$bookCode', '$fullName', '$author', '$publishing', '$price', '$coverURL', '$rearCoverURL', '$pageNumber', '$language', '$exactPublishingDate', '$annotation', '$genre', '$seriesName', '$inSeriesNumber')";
                
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
        <script src="adminFormsAdder.js" defer></script>
    </body>
    <footer>
    </footer>
</html>
<?php
ob_end_flush();
?>