<?php
    include('connect_db.php');
    
    $searchValue = $_GET['searchValue'];
    $query = "SELECT * FROM books WHERE Name LIKE '%$searchValue%' OR Author LIKE '%$searchValue%' OR SeriesName LIKE '%$searchValue%'";       
    $result = mysqli_query($conn, $query);
    
    $books = array();
    while($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }

    $queryAuthors = "SELECT * FROM authors WHERE AuthorName LIKE '%$searchValue%'";
    $resultAuthors = mysqli_query($conn, $queryAuthors);

    $authors = array();
    while($row = mysqli_fetch_assoc($resultAuthors)) {
        $authors[] = $row;
    }

    // Об'єднуємо книги та авторів в один об'єкт
    $response = array('books' => $books, 'authors' => $authors);

    // Кодуємо та виводимо JSON-відповідь
    echo json_encode($response);
?>
