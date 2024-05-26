<?php
ob_start();
session_start();
include('connect_db.php');

// Папка для збереження завантажених файлів
$target_dir = "./UserPictures/";

// Переконайтеся, що папка існує
if (!is_dir($target_dir)) {
    die("Папка для збереження завантажених файлів не існує.");
}

// Отримуємо ім'я файлу без розширення
$file_name = pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME);
// Отримуємо розширення файлу
$imageFileType = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));

// Початковий шлях до файлу
$target_file = $target_dir . $file_name . '.' . $imageFileType;

// Перевірка, чи є файл зображенням
$check = getimagesize($_FILES["file"]["tmp_name"]);
if ($check === false) {
    die("Файл не є зображенням.");
}

// Перевірка розміру файлу (наприклад, не більше 5MB)
if ($_FILES["file"]["size"] > 5000000) {
    die("Вибачте, ваш файл занадто великий.");
}

// Дозволені формати файлів
$allowed_types = array("jpg", "jpeg", "png", "gif", "jfif");
if (!in_array($imageFileType, $allowed_types)) {
    die("Вибачте, дозволені лише формати JPG, JPEG, PNG, JFIF та GIF.");
}

// Перевірка, чи існує файл
if (file_exists($target_file)) {
    // Файл існує, встановлюємо посилання на нього
    $relative_path = "./UserPictures/" . basename($target_file);
} else {
    // Файл не існує, завантажуємо його
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        $relative_path = "./UserPictures/" . basename($target_file);
    } else {
        die("Вибачте, виникла помилка під час завантаження вашого файлу.");
    }
}

// Оновлення бази даних
$query = "UPDATE users SET image = ? WHERE userId = ?";
$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    die("Помилка підготовки SQL запиту: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "si", $relative_path, $_SESSION["id"]);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "Зображення успішно оновлено.";
} else {
    echo "Помилка оновлення зображення у базі даних.";
}

mysqli_stmt_close($stmt);

header('Location: Кабінет.php');
exit();

$conn->close();
ob_end_flush();
?>
