<?php 
$servername = 'localhost';
$username = 'marianpelekh';
$password = 'mH04122005Op';
$dbname = 'books';

$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Помилка підключення до бази даних: " . $conn->connect_error);
}
?>