<?php
ob_start();
include 'connect_db.php';
if (isset($_POST['commentId'])) {
    $commentId = $_POST['commentId'];

    $sql = "UPDATE comments SET Likes = Likes + 1 WHERE commentId = '$commentId'";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)){
        $likes = $row['Likes'];

        echo $likes;
    } else {
        echo "Error ". $commentId . " or null";
    }
} else if (isset($_GET['commentId'])) {
    $commentId = $_GET['commentId'];
    $sql = "SELECT Likes FROM comments WHERE commentId = '$commentId'";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)){
        $likes = $row['Likes'];

        echo $likes;
    } else {
        echo "Error ". $commentId . " or null";
    }
}
ob_end_flush();
?>
