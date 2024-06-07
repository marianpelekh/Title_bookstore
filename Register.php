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
        echo '<script src="LogFormDissabler.js"></script>';
        echo '<form method="POST" id="regForm">';
        echo '<h3>Реєстрація</h3>';
        echo "<p>Прізвище: <input type='text' name='LastName'></p>";
        echo "<p>Ім'я: <input type='text' name='FirstName'></p>";
        echo "<p>По-батькові: <input type='text' name='MiddleName'></p>";
        echo '<p>Email: <input type="text" name="Email"></p>';
        echo '<p>Логін: <input type="text" name="userLogin"></p>';
        echo '<p>Пароль: <input type="password" name="userPass"></p>';
        echo '<p>Повторити пароль: <input type="password" name="userPassRepeat"></p>';
        echo '<input type="submit" name="register" value="Зареєструватися">';
        echo '<input type="button" name="returnToLogin" value="Авторизуватися" onclick="window.location=\'Кабінет.php\'">';
        echo '</form>';
        if (isset($_POST['register'])) {
            $firstName = mysqli_real_escape_string($conn, $_POST['FirstName']);
            $lastName = mysqli_real_escape_string($conn, $_POST['LastName']);
            $middleName = mysqli_real_escape_string($conn, $_POST['MiddleName']);
            $email = mysqli_real_escape_string($conn, $_POST['Email']);
            $userLogin = mysqli_real_escape_string($conn, $_POST['userLogin']);
            $userPass = password_hash(mysqli_real_escape_string($conn, $_POST['userPass']), PASSWORD_BCRYPT);
            $userPassRepeat = mysqli_real_escape_string($conn, $_POST['userPassRepeat']);
            if ($userPass !== $userPassRepeat) {
                echo "<p id='regError'>ПОМИЛКА: Пароль та його повторення не співпадають.</p>";
                exit;
            }
            $check_sql = "SELECT * FROM `users` WHERE `Login`='$userLogin'";
            $check_result = mysqli_query($conn, $check_sql);
            $check_email_sql = "SELECT * FROM `users` WHERE `Email`='$email'";
            $check_email_result = mysqli_query($conn, $check_email_sql);
            if (mysqli_num_rows($check_result) > 0) {
                echo "<p id='regError'>ПОМИЛКА: Користувач з таким логіном уже існує. Введіть інший логін.</p>";
            } else if (mysqli_num_rows($check_email_result) > 0) {
                echo "<p id='regError'>ПОМИЛКА: На дану електронну пошту вже зареєстрований користувач. На один email можна зареєструвати лише одного користувача.</p>";
            } else if ($userLogin == "admin") {
                echo "<p id='regError'>ПОМИЛКА: Користувач не може мати логін 'admin'</p>";
            } else {
                $sql = "INSERT INTO `users`(`Login`, `Password`, `Email`, `FirstName`, `LastName`, `MiddleName`, `image`, `StoredBooks`, `FeaturedGenres`) 
                        VALUES ('$userLogin','$userPass','$email','$firstName','$lastName','$middleName','user.png', '[]', '')";
                mysqli_query($conn, $sql);
                $_SESSION['id'] = mysqli_insert_id($conn);
                header('Location: Profile.php');
                exit;
            }
        }
    }
?>

    </section>
<script src="Search.js"></script>
<script src="FooterAdder.js" defer></script>
</body>
<footer>
</footer>
</html>
<?php 
ob_end_flush();
?>