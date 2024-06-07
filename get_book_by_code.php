<?php
include('connect_db.php');

if (isset($_GET['bookCode'])) {
    $bookCode = $_GET['bookCode'];
    error_log($bookCode);
    $sql = "SELECT * FROM books WHERE BookID = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $bookCode);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($row = $result->fetch_assoc()) {
            $bookInfo = array(
                'ShortName' => htmlspecialchars($row['ShortName'], ENT_QUOTES, 'UTF-8'),
                'BookID' => htmlspecialchars($row['BookID'], ENT_QUOTES, 'UTF-8'),
                'Name' => htmlspecialchars($row['Name'], ENT_QUOTES, 'UTF-8'),
                'Author' => htmlspecialchars($row['Author'], ENT_QUOTES, 'UTF-8'),
                'Publishing' => htmlspecialchars($row['Publishing'], ENT_QUOTES, 'UTF-8'),
                'Price' => htmlspecialchars($row['Price'], ENT_QUOTES, 'UTF-8'),
                'FrontCover' => htmlspecialchars($row['FrontCover'], ENT_QUOTES, 'UTF-8'),
                'BackCover' => htmlspecialchars($row['BackCover'], ENT_QUOTES, 'UTF-8'),
                'PagesNumber' => htmlspecialchars($row['PagesNumber'], ENT_QUOTES, 'UTF-8'),
                'Language' => htmlspecialchars($row['Language'], ENT_QUOTES, 'UTF-8'),
                'DateExact' => htmlspecialchars($row['DateExact'], ENT_QUOTES, 'UTF-8'),
                'Description' => $row['Description'],
                'Genre' => htmlspecialchars($row['Genre'], ENT_QUOTES, 'UTF-8'),
                'SeriesName' => htmlspecialchars($row['SeriesName'], ENT_QUOTES, 'UTF-8'),
                'NumberInSeries' => htmlspecialchars($row['NumberInSeries'], ENT_QUOTES, 'UTF-8')
            );
            echo json_encode($bookInfo);
        } else {
            echo json_encode(array("error" => "No book found with the given code."));
        }
        
        $stmt->close();
    } else {
        echo json_encode(array("error" => "Failed to prepare the SQL statement."));
    }
    
} else {
    echo json_encode(array("error" => "No book code received."));
}

$conn->close();
?>
