<?php
session_start();
require('connect_db.php');

$data = json_decode(file_get_contents('php://input'), true);

if(isset($_SESSION['id']) && $data) {
    $userId = $_SESSION['id'];
    $userName = $data['userName'];
    $userPhone = isset($data['phoneNumber']) ? $data['phoneNumber'] : null;
    $userMail = $data['userMail'];
    $deliveryMethod = $data['deliveryMethod'];
    $deliveryTown = isset($data['deliveryTown']) ? $data['deliveryTown'] : null;
    $deliveryAddress = isset($data['deliveryAddress']) ? $data['deliveryAddress'] : null;
    $payByCard = $data['payByCard'] ? 1 : 0;
    $cardNumber = $payByCard ? $data['cardNumber'] : null;
    $bookIds = $data['bookIds'];
    $totalPrice = $data['totalPrice'];

    $bookIdsJson = json_encode($bookIds, JSON_UNESCAPED_UNICODE);

    $query = "INSERT INTO orders (BookIds, UserName, UserPhone, UserEmail, DeliveryMethod, DeliveryTown, DeliveryAddress, PayByCard, CardNumber, TotalPrice)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssssssisd', $bookIdsJson, $userName, $userPhone, $userMail, $deliveryMethod, $deliveryTown, $deliveryAddress, $payByCard, $cardNumber, $totalPrice);

    if($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Order placed successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to place order']);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid session or data']);
}
$conn->close();
?>
