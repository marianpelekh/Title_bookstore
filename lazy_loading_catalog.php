<?php
include('connect_db.php');

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = 8;

// Параметри фільтрації
$minPriceValue = isset($_GET['minPriceValue']) ? floatval($_GET['minPriceValue']) : null;
$maxPriceValue = isset($_GET['maxPriceValue']) ? floatval($_GET['maxPriceValue']) : null;
$storedPublFilter = isset($_GET['storedPublishingFilter']) ? $_GET['storedPublishingFilter'] : null;
$storedGenreFilter = isset($_GET['storedGenreFilter']) ? $_GET['storedGenreFilter'] : null;

$query = "SELECT * FROM books";

// Додаємо умови фільтрації до запиту
$whereConditions = array();
if (!is_null($minPriceValue) && !is_null($maxPriceValue)) {
    $whereConditions[] = "CAST(REPLACE(Price, ' грн', '') AS UNSIGNED) >= $minPriceValue AND CAST(REPLACE(Price, ' грн', '') AS UNSIGNED) <= $maxPriceValue";
}
if (!is_null($storedPublFilter)) {
    $whereConditions[] = "Publishing = '$storedPublFilter'";
}
if (!is_null($storedGenreFilter)) {
    $whereConditions[] = "Genre = '$storedGenreFilter'";
}

if (!empty($whereConditions)) {
    $query .= " WHERE " . implode(" AND ", $whereConditions);
}

$query .= " ORDER BY `DateExact` DESC LIMIT $limit OFFSET $offset";
// Друк сформованого запиту для діагностики
error_log($query);

$result = mysqli_query($conn, $query);

// Перевірка на помилки запиту
if (!$result) {
    die("Помилка виконання запиту: " . mysqli_error($conn));
}
$books = array();
while ($row = mysqli_fetch_array($result)) {
    $publ_query = "SELECT PublNameEng FROM publishings WHERE PublName = '" . mysqli_real_escape_string($conn, $row['Publishing']) . "'";
    $publ_result = mysqli_query($conn, $publ_query);
    $publ_row = mysqli_fetch_array($publ_result);

    $books[] = array(
        'Name' => $row['Name'],
        'Author' => $row['Author'],
        'Cover' => $row['Cover'],
        'Price' => $row['Price'],
        'Genre' => $row['Genre'],
        'PublishingEng' => $publ_row['PublNameEng']
    );
}

echo json_encode($books);

?>
