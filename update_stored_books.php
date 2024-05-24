<?php
session_start();
require('connect_db.php');

// Отримати JSON-дані з потоку вхідних даних
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['books']) && !empty($data['books'])) {
    $books = $data['books'];
    if (json_last_error() === JSON_ERROR_NONE) {
        $booksJson = json_encode($books, JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE);
        $userId = $_SESSION['id'];

        $updateBooks = "UPDATE users SET StoredBooks = ? WHERE userId = ?";
        $stmt = $conn->prepare($updateBooks);
        $stmt->bind_param('si', $booksJson, $userId);
        
        if ($stmt->execute()) {
            echo "Books updated successfully.";
        } else {
            echo "Error updating books: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Invalid JSON data.";
    }
} else if (isset($data['books'])) {
    echo "Books data received but it's empty.";
} else {
    echo "No books data received.";
    echo "What is received: " . isset($data['books']);
}

$conn->close();
?>
