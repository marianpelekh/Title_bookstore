<?php
include('connect_db.php');

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = 8;

// Параметри фільтрації
$minPriceValue = isset($_GET['minPriceValue']) ? floatval($_GET['minPriceValue']) : null;
$maxPriceValue = isset($_GET['maxPriceValue']) ? floatval($_GET['maxPriceValue']) : null;
$storedPublFilter = isset($_GET['storedPublishingFilter']) ? $_GET['storedPublishingFilter'] : null;
$storedGenreFilter = isset($_GET['storedGenreFilter']) ? $_GET['storedGenreFilter'] : null;

// Зміна значення limit залежно від ширини екрану
if (isset($_GET['screenWidth']) && intval($_GET['screenWidth']) > 1828) {
    $limit = 10;
}

$whereConditions = array();
if (!is_null($minPriceValue) && !is_null($maxPriceValue)) {
    $whereConditions[] = "CAST(REPLACE(Price, ' грн', '') AS UNSIGNED) BETWEEN $minPriceValue AND $maxPriceValue";
}

$publName = null;
if (!empty($storedPublFilter)) {
    $storedPublFilter = mysqli_real_escape_string($conn, $storedPublFilter); // Sanitize input
    $publ_query = "SELECT PublName FROM publishings WHERE PublNameEng = '$storedPublFilter'";
    $publ_result = mysqli_query($conn, $publ_query);

    if ($publ_result && mysqli_num_rows($publ_result) > 0) {
        $publ_row = mysqli_fetch_assoc($publ_result);
        $publName = mysqli_real_escape_string($conn, $publ_row['PublName']);
        $whereConditions[] = "Publishing = '$publName'";
    }
}

$groupByGenre = false;
$groupByPublishing = false;

if (!is_null($storedGenreFilter) && $storedGenreFilter !== '') {
    $storedGenreFilter = mysqli_real_escape_string($conn, $storedGenreFilter);
    $whereConditions[] = "Genre = '$storedGenreFilter'";
    $groupByGenre = true;
}

if (!is_null($publName)) {
    $groupByPublishing = true;
}

$whereClause = '';
if (!empty($whereConditions)) {
    $whereClause = " WHERE " . implode(" AND ", $whereConditions);
}

$groupByClause = '';
if ($groupByGenre && $groupByPublishing) {
    $groupByClause = "ORDER BY Genre = '$storedGenreFilter' DESC, Publishing = '$publName' DESC, DateExact DESC";
} elseif ($groupByGenre) {
    $groupByClause = "ORDER BY Genre = '$storedGenreFilter' DESC, DateExact DESC";
} elseif ($groupByPublishing) {
    $groupByClause = "ORDER BY Publishing = '$publName' DESC, DateExact DESC";
} else {
    $groupByClause = "ORDER BY DateExact DESC";
}

// Головний запит з фільтрацією і групуванням
$query = "SELECT * FROM books $whereClause $groupByClause LIMIT $limit OFFSET $offset";


// Друк сформованого запиту для діагностики
error_log("SQL Query: " . $query);

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
        'Id' => $row['number'],
        'PublishingEng' => $publ_row['PublNameEng']
    );
}

echo json_encode($books);
?>