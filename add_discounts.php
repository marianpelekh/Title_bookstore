<?php 
ob_start();
include('connect_db.php');

$bookID = $_POST['discountBookId'];
$discVal = $_POST['discountValue'];
$expirationDate = $_POST['expirationDate'];
$initialPrice = mysqli_fetch_assoc(mysqli_query($conn, "SELECT Price FROM books WHERE `number` = '$bookID'"))['Price'];
echo $bookID . " " . $discVal . " " . $expirationDate . " " . $initialPrice;
$discount_query = "INSERT INTO Discounts(BookID, Discount, Expires, InitialPrice) VALUES ('$bookID', '$discVal', '$expirationDate', '$initialPrice')";
if(mysqli_query($conn, $discount_query)) {
    
} else {
    die('Знижка не встановлена.');
}
ob_end_flush();
?>