<?php
session_start();
include('connect_db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['books']) && isset($_SESSION['id'])) {
    $books = mysqli_real_escape_string($conn, $_POST['books']);
    $userId = $_SESSION['id'];
    
    $saveBooks = "UPDATE users SET StoredBooks = '$books' WHERE userId = $userId";
    if (mysqli_query($conn, $saveBooks)) {
        echo "Books saved successfully.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
