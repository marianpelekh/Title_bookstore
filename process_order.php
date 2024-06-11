<?php
session_start();
require('connect_db.php');

$data = json_decode(file_get_contents('php://input'), true);

if(isset($_SESSION['id']) && $data) {
    $userId = $_SESSION['id'];
    $status = "New";
    $userName = mysqli_real_escape_string($conn, $data['userName']);
    $userPhone = isset($data['phoneNumber']) ? mysqli_real_escape_string($conn, $data['phoneNumber']) : 'NULL';
    $userMail = mysqli_real_escape_string($conn, $data['userMail']);
    $deliveryMethod = mysqli_real_escape_string($conn, $data['deliveryMethod']);
    $deliveryTown = isset($data['deliveryTown']) ? mysqli_real_escape_string($conn, $data['deliveryTown']) : 'NULL';
    $deliveryAddress = isset($data['deliveryAddress']) ? mysqli_real_escape_string($conn, $data['deliveryAddress']) : 'NULL';
    $payByCard = $data['payByCard'] ? 1 : 0;
    $cardNumber = $payByCard ? mysqli_real_escape_string($conn, $data['cardNumber']) : 'NULL';
    $bookIds = $data['bookIds'];
    $totalPrice = mysqli_real_escape_string($conn, $data['totalPrice']);
    
    if (empty($cardNumber)) {
        $cardNumber = '';
    }
    
    if (empty($userPhone)) {
        $userPhone = '';
    }
    
    if (empty($deliveryTown)) {
        $deliveryTown = '';
    }
    
    if (empty($deliveryAddress)) {
        $deliveryAddress = '';
    }
    date_default_timezone_set('Europe/Kiev');
    $orderDate = (new DateTime())->format('Y-m-d H:i:s');

    $bookIdsJson = json_encode($bookIds, JSON_UNESCAPED_UNICODE);

    $query = "INSERT INTO orders (`Status`, userId, OrderDate, BookIds, UserName, UserPhone, UserEmail, DeliveryMethod, DeliveryTown, DeliveryAddress, PayByCard, CardNumber, TotalPrice)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param(
        'sissssssssisd',
        $status,
        $userId,
        $orderDate,
        $bookIdsJson,
        $userName,
        $userPhone,
        $userMail,
        $deliveryMethod,
        $deliveryTown,
        $deliveryAddress,
        $payByCard,
        $cardNumber,
        $totalPrice
    );

    if ($stmt->execute()) {
        echo "Order placed successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid session or data']);
}
$conn->close();
?>
