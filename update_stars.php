<?php
include 'connect_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $commentId = $_POST['commentId'];
    $stars = $_POST['Rate'];

    $sql = "UPDATE comments SET Rate = ? WHERE commentId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $stars, $commentId);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
