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
    <section id="cabinetSection">
<?php
    $sql = "SELECT * FROM users WHERE userId='". $_SESSION['id'] . "'";
    $res = mysqli_query($conn, $sql);
    $result = mysqli_fetch_array($res);
    echo '<script src="LogFormDissabler.js"></script>';
    echo '<form method="POST" id="regForm" onsubmit="return validatePassword();">';
    echo '<h3>Змінити пароль</h3>';
    echo "<p>Прізвище: <input type='text' name='LastName' value=".$result['LastName']." readonly></p>";
    echo "<p>Ім'я: <input type='text' name='FirstName' value=".$result['FirstName']." readonly></p>";
    echo "<p>По-батькові: <input type='text' name='MiddleName' value=".$result['MiddleName']." readonly></p>";
    echo '<p>Email: <input type="text" name="Email" value='.$result["Email"].' readonly></p>';
    echo '<p>Логін: <input type="text" name="userLogin" value='.$result['Login'].' readonly></p>';
    echo '<p>Новий пароль: <input type="password" name="userPass"></p>';
    echo '<p>Повторити пароль: <input type="password" name="userPassRepeat"></p>';
    echo '<input type="submit" name="changePass" value="Змінити пароль">';
    echo '<input type="button" name="returnToCabinet" value="Повернутися" onclick="window.location=\'Profile.php\'">';
    echo '</form>';
?>
<script>
    let passwordInput = document.getElementsByName('userPass')[0];
    let confirmPasswordInput = document.getElementsByName('userPassRepeat')[0];

    function validatePassword() {
        let password = passwordInput.value;
        let confirmPassword = confirmPasswordInput.value;
        let currentPassword = '<?php echo $result["Password"]; ?>';

        // Перевірка, щоб новий пароль був не порожнім
        if (!password || password.trim() === '') {
            alert('Будь ласка, введіть новий пароль.');
            return false;
        }

        // Перевірка, щоб підтвердження пароля було не порожнім
        if (!confirmPassword || confirmPassword.trim() === '') {
            alert('Будь ласка, введіть підтвердження нового пароля.');
            return false;
        }

        if (password !== confirmPassword) {
            alert('Пароль та підтвердження пароля повинні співпадати.');
            return false;
        }

        if (password === currentPassword) {
            alert('Новий пароль повинен відрізнятися від поточного пароля.');
            return false;
        }

        if (password.length < 8) {
            alert('Пароль має мати щонайменше 8 символів.');
            return false;
        }

        return true;
    }
</script>
<?php 
    if(isset($_POST['changePass'])) {
        $password = password_hash($_POST['userPass'], PASSWORD_BCRYPT);
        $query = "UPDATE users SET Password = '$password' WHERE userId = '" . $_SESSION['id'] . "'";
        $response = mysqli_query($conn, $query);
        header('Location: Profile.php');
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