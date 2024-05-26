<?php
    include('connect_db.php');

    $query = "SELECT COUNT(*) as count FROM books";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    echo $row['count'];
?>
