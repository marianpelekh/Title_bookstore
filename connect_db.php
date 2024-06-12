<?php 
//Home
$servername = '192.168.0.199';

//Mobile
// $servername = '192.168.6.247';

//GALCOL_U
// $servername = '192.168.174.72';


$username = 'marianpelekh';
$password = 'mH04122005Op';
$dbname = 'books';

$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Помилка підключення до бази даних: " . $conn->connect_error);
}
?>