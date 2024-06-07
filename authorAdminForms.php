<?php
ob_start();
include('connect_db.php');
if(isset($_POST['AddAuthor'])) {
    $authorName = mysqli_real_escape_string($conn, $_POST['AuthorName']);
    $authorBirth = $_POST['AuthorBirth'];
    $authorDeath = $_POST['AuthorDeath'];
    $authorPic = mysqli_real_escape_string($conn, $_POST['AuthorPic']);
    $authorBiography = mysqli_real_escape_string($conn, $_POST['AuthorBiography']);

    if (empty($authorDeath)) {
        $authorDeath = 'NULL';
    } else {
        $authorDeath = mysqli_real_escape_string($conn, $authorDeath);
    }
    if (empty($authorBirth)) {
        $authorBirth = 'NULL';
    } else {
        $authorBirth = mysqli_real_escape_string($conn, $authorBirth);
    }

    $sql = "INSERT INTO authors (AuthorName, Birth, Death, Picture, Bibliography)
            VALUES ('$authorName', '$authorBirth', $authorDeath, '$authorPic', '$authorBiography')";
    mysqli_query($conn, $sql);

} else if (isset($_POST['editAuthor'])) {
    $authorId = $_POST['editAuthorSelect'];
    $authorName = $_POST['editAuthorName'];
    $authorBirth = $_POST['editAuthorBirth'];
    $authorDeath = isset($_POST['editAuthorDeath']) ? $_POST['editAuthorDeath'] : NULL;
    $authorPic = $_POST['editAuthorPic'];
    $authorBiography = $_POST['editAuthorBiography'];

    $sql = "UPDATE authors SET 
                AuthorName = '$authorName',
                Birth = '$authorBirth',
                Death = '$authorDeath',
                Picture = '$authorPic',
                Bibliography = '$authorBiography'
            WHERE id = '$authorId'";
    mysqli_query($conn, $sql);
} else if (isset($_POST['deleteAuthor'])) {
    $authorId = $_POST['deleteAuthorSelect'];
    
    $sql = "DELETE FROM authors WHERE id = '$authorId'";
    mysqli_query($conn, $sql);
}
header('Location: Profile.php');
ob_end_flush();
?>
