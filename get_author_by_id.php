<?php
include('connect_db.php');

if (isset($_GET['authorId'])) {
    $authorId = $_GET['authorId'];
    error_log($authorId);
    $sql = "SELECT * FROM authors WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $authorId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $authorInfo = array(
                'AuthorName' => htmlspecialchars($row['AuthorName'], ENT_QUOTES, 'UTF-8'),
                'Birth' => htmlspecialchars($row['Birth'], ENT_QUOTES, 'UTF-8'),
                'Death' => isset($row['Death']) ? htmlspecialchars($row['Death'], ENT_QUOTES, 'UTF-8') : null,
                'Picture' => htmlspecialchars($row['Picture'], ENT_QUOTES, 'UTF-8'),
                'Biography' => $row['Bibliography']
            );
            echo json_encode($authorInfo);
        } else {
            echo json_encode(array("error" => "No author found with the given id."));
        }
        
        $stmt->close();
    } else {
        echo json_encode(array("error" => "Failed to prepare the SQL statement."));
    }
    
} else {
    echo json_encode(array("error" => "No author id received."));
}

$conn->close();
?>
