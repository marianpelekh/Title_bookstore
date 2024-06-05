<?php
include('connect_db.php');

if (isset($_GET['ids']) && isset($_GET['originalTotal'])) {
    $bookArr = json_decode($_GET['ids'], true);
    $originalTotal = floatval($_GET['originalTotal']);

    $total = 0;

    foreach ($bookArr as $book) {
        $bookId = $book['code'];
        $quantity = intval($book['quantity']);

        $query = "SELECT Discount, InitialPrice FROM discounts WHERE BookID = '$bookId'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $discount = floatval($row['Discount']) / 100;
            $initialPrice = floatval($row['InitialPrice']);

            $discountedPrice = $initialPrice * (1 - $discount);
            $total += $discountedPrice * $quantity;
        } else {
            $query = "SELECT Price FROM books WHERE `BookID` = '$bookId'";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $initialPrice = floatval($row['Price']);
                $total += $initialPrice * $quantity;
            }
        }
    }
    echo $total;
}
?>
