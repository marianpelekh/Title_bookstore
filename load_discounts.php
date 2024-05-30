<?php
include('connect_db.php');

if (isset($_GET['bookId'])) {
    $bookId = $_GET['bookId'];

    $priceQuery = "SELECT Price FROM books WHERE `number` = '$bookId'";
    $priceResult = mysqli_query($conn, $priceQuery);

    if ($priceResult && mysqli_num_rows($priceResult) > 0) {
        $originalPrice = (int)mysqli_fetch_assoc($priceResult)['Price'];
        
        // Отримати знижку з таблиці discounts
        $discountQuery = "SELECT Discount FROM discounts WHERE BookID = '$bookId' AND Expires >= NOW()";
        $discountResult = mysqli_query($conn, $discountQuery);
        
        if ($discountResult && mysqli_num_rows($discountResult) > 0) {
            $discountRow = mysqli_fetch_assoc($discountResult);
            $discount = (int)$discountRow['Discount'];
            
            $newPrice = $originalPrice - round($originalPrice * ($discount / 100));
            
            $formattedNewPrice = $newPrice;
            $formattedOldPrice = $originalPrice;
            $showDiscount = (-1 * $discount > 0) ? '+' . (-1 * $discount) : (-1 * $discount);
            echo "<p style='margin: 0px;'>$formattedNewPrice <s style='color: var(--red);'>$formattedOldPrice</s><sup style='color: var(--red);'>$showDiscount%</sup> грн</p>";
        } else {
            echo $originalPrice . " грн";
        }
    } else {
        echo "Книга не знайдена або неправильний запит.";
    }
    $expiredDiscountsQuery = "SELECT BookID FROM discounts WHERE Expires < NOW()";
    $expiredDiscountsResult = mysqli_query($conn, $expiredDiscountsQuery);

    if ($expiredDiscountsResult && mysqli_num_rows($expiredDiscountsResult) > 0) {
        while ($row = mysqli_fetch_assoc($expiredDiscountsResult)) {
            $deleteExpiredDiscountQuery = "DELETE FROM discounts WHERE BookID = '$bookId'";
            mysqli_query($conn, $deleteExpiredDiscountQuery);
        }
    }
} else {
    echo "Неправильний запит.";
}
?>
