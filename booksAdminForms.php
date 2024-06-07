<?php
ob_start();
include("connect_db.php");
if(isset($_POST['addBookBtn'])) {
    $ShortName = mysqli_real_escape_string($conn, $_POST['ShortName']);
    $BookID = mysqli_real_escape_string($conn, $_POST['BookCode']);
    $FullName = mysqli_real_escape_string($conn, $_POST['FullName']);
    $Author = mysqli_real_escape_string($conn, $_POST['Author']);
    $publishing = mysqli_real_escape_string($conn, $_POST['Publishing']);
    $Price = mysqli_real_escape_string($conn, $_POST['Price']);
    $Cover = mysqli_real_escape_string($conn, $_POST['CoverURL']);
    $RearCover = mysqli_real_escape_string($conn, $_POST['RearCoverURL']);
    $PageNumber = mysqli_real_escape_string($conn, $_POST['PageNumber']);
    $Language = mysqli_real_escape_string($conn, $_POST['Language']);
    $ExactDate = mysqli_real_escape_string($conn, $_POST['ExactPublishingDate']);
    $Annotation = mysqli_real_escape_string($conn, $_POST['Annotation']);
    $Genre = mysqli_real_escape_string($conn, $_POST['Genre']);
    $SeriesName = mysqli_real_escape_string($conn, $_POST['SeriesName']);
    $InSeriesNumber = mysqli_real_escape_string($conn, $_POST['InSeriesNumber']);

    $sql = "INSERT INTO books(ShortName, BookID, Name, Author, Publishing, Price, FrontCover, BackCover, PagesNumber, Language, DateExact, Description, Genre, SeriesName, NumberInSeries) 
            VALUES ('$ShortName', '$BookID', '$FullName', '$Author', '$publishing', '$Price', '$Cover', '$RearCover', '$PageNumber', '$Language', '$ExactDate', '$Annotation', '$Genre', '$SeriesName', '$InSeriesNumber')";
    if (mysqli_query($conn, $sql)) {
        echo "Книгу " . $ShortName . " успішно додано!";
    } else {
        echo "Error." . mysqli_error($conn);
    }
}
else if (isset($_POST['editBookBtn'])) {
    $selectedBookCode = mysqli_real_escape_string($conn, $_POST['bookCodeEdit']);
    $ShortName = mysqli_real_escape_string($conn, $_POST['EditShortName']);
    $BookID = mysqli_real_escape_string($conn, $_POST['EditBookCode']);
    $FullName = mysqli_real_escape_string($conn, $_POST['EditFullName']);
    $Author = mysqli_real_escape_string($conn, $_POST['EditAuthor']);
    $publishing = mysqli_real_escape_string($conn, $_POST['EditPublishing']);
    $Price = mysqli_real_escape_string($conn, $_POST['EditPrice']);
    $Cover = mysqli_real_escape_string($conn, $_POST['EditCoverURL']);
    $RearCover = mysqli_real_escape_string($conn, $_POST['EditRearCoverURL']);
    $PageNumber = mysqli_real_escape_string($conn, $_POST['EditPageNumber']);
    $Language = mysqli_real_escape_string($conn, $_POST['EditLanguage']);
    $ExactDate = mysqli_real_escape_string($conn, $_POST['EditExactPublishingDate']);
    $Annotation = mysqli_real_escape_string($conn, $_POST['EditAnnotation']);
    $Genre = mysqli_real_escape_string($conn, $_POST['EditGenre']);
    $SeriesName = mysqli_real_escape_string($conn, $_POST['EditSeriesName']);
    $InSeriesNumber = mysqli_real_escape_string($conn, $_POST['EditInSeriesNumber']);

    $sql = "
    UPDATE books 
    SET 
        ShortName = '$ShortName', 
        BookID = '$BookID', 
        Name = '$FullName', 
        Author = '$Author', 
        Publishing = '$publishing', 
        Price = '$Price', 
        FrontCover = '$Cover', 
        BackCover = '$RearCover', 
        PagesNumber = '$PageNumber', 
        Language = '$Language', 
        DateExact = '$ExactDate', 
        Description = '$Annotation', 
        Genre = '$Genre', 
        SeriesName = '$SeriesName', 
        NumberInSeries = '$InSeriesNumber'
    WHERE 
        BookID = '$selectedBookCode'";

if (mysqli_query($conn, $sql)) {
    echo "Книга " . $ShortName . " оновлена успішно.";
} else {
    echo "Error: " . mysqli_error($conn);
}
} else if (isset($_POST['deleteBookBtn'])) {
    $selectedBookCode = mysqli_real_escape_string($conn, $_POST['deleteBook']);
    $sql = "DELETE FROM books WHERE BookID = '$selectedBookCode'";
    if (mysqli_query($conn, $sql)) {
        echo "Книга " . $selectedBookCode . " видалена успішно.";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
header('Location: Profile.php');
ob_end_flush();
?>