<?php
session_start();
require('connect_db.php');

$data = json_decode(file_get_contents("php://input"), true);

$storedBooks = json_encode($data);

$insertQuery = "UPDATE users SET StoredBooks = '$storedBooks' WHERE userId = $_SESSION[id]";
mysqli_query($conn, $insertQuery);
?>
