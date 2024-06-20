<?php 
//Home
$servername = '192.168.0.197';

//Mobile
// $servername = '192.168.6.247';

//GALCOL_U
// $servername = '192.168.175.242';

//21_5g
// $servername = '21.21.21.113';


$username = 'marianpelekh';
$password = 'mH04122005Op';
$dbname = 'books';

$conn = mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Помилка підключення до бази даних: " . $conn->connect_error);
}
?>