<?php
ob_start();
include('connect_db.php');
session_start();
$id = urldecode($_GET['id']);

$query = "SELECT * FROM books WHERE CONCAT(`Name`, ' ', `Author`, ' ', `BookID`)='" . mysqli_real_escape_string($conn, $id) . "'";
$result = mysqli_query($conn, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $title = $row['ShortName'] . '. ' . $row['Author'];
    $genre = $row['Genre'];

    // Отримати ідентифікатор користувача з сесії
    if (!empty($_SESSION['id'])){
        $userId = $_SESSION['id'];

        // Отримати поточне значення поля FeaturedGenres користувача з бази даних
        $sql = "SELECT FeaturedGenres FROM users WHERE userId = $userId";
        $result_g = mysqli_query($conn, $sql);
        $row_g = mysqli_fetch_assoc($result_g);
        $featured_genres_db = $row_g['FeaturedGenres'];

        // Оновіть значення поля FeaturedGenres користувача, додаючи новий жанр
        if (!empty($featured_genres_db)) {
            $featured_genres = json_decode($featured_genres_db, true);
        } else {
            $featured_genres = array();
        }
        
        // Оновіть інформацію про жанр
        if(array_key_exists($genre, $featured_genres)) {
            $featured_genres[$genre]++;
        } else {
            $featured_genres[$genre] = 1;
        }

        // Збережіть оновлене значення поля FeaturedGenres в базі даних
        $updated_featured_genres_db = json_encode($featured_genres);
        $sql = "UPDATE users SET FeaturedGenres = '$updated_featured_genres_db' WHERE userId = $userId";
        mysqli_query($conn, $sql);
    }
}
 else {
    $title = 'Книга не знайдена';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="Title Main.css">
    <link rel="stylesheet" href="Main page.css">
    <link rel="stylesheet" href="Carousel of images.css">
    <link rel="stylesheet" href="Book page.css">
    <link rel="stylesheet" href="books.css">
    <link rel="stylesheet" href="CartStyles.css">
    <link rel="stylesheet" href="AuthorsStyles.css">
    <link rel="stylesheet" href="ScreenAdaptation.css">
    <link rel="icon" type="image/x-icon" href="favicon1.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<header>
    <a id="SearchToggle"><img src="search.png" id="search" width="20px"></a>
    <h1><a id="Title" href="index.php">Title</a></h1>
    <nav>
        <a id="Catalog" href="Каталог.php">Каталог</a>
        <a id="Authors" href="Автори.php">Автори</a>
        <h1><a id="TitleNav" href="index.php"><?php echo $row['ShortName']; ?></a></h1>
        <a id="New" href="Новинки.php">Новинки</a>
        <a id="Contacts" href="Контакти.php">Контакти</a>
        <a id="Cabinet" href="Кабінет.php"><img src="personal-icon.png" id="pers-cab" width="20px"></a>
    </nav>
    <a id="MainCabinet" href="Кабінет.php"><img src="personal-icon.png" width="20px"></a>
    <div id="menuToggle">
        <img src="menu.png" alt="Menu" width="20px">
    </div>
    <div id="searchContainer">
        <div id="searchPlusClose">
            <input type="text" id="searchField" placeholder="Введіть назву книги або автора...">
            <img src="close.png" id="closeSearch" alt="X">
        </div>

        <div id="searchResultField">
            <div id="searchedBooks">
                <div id="booksContainer">
                </div>
            </div>
            <div id="searchedAuthors">
                <div id="authorsContainer">
                </div>
            </div>
        </div>
    </div>
</header>

<body>
    <section>

        <ul class="breadcrumb">
            <li><a href="index.php">TITLE</a></li>
            <li><a href="Каталог.php">Каталог</a></li>
            <li><a href="#"><?php echo $row['Name'] ?></a></li>
        </ul>
        <div class="BookMainInfo">
        <svg id="BookCoverBG" viewBox="0 0 272 361" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect width="272" height="361" rx="6" fill="#e1d5ff" />
        </svg>
        <div id='card'>
            <?php
                $backCover = ($row['BackCover'] != null) ? $row['BackCover'] : "IMGmissing.png";
                echo '<img id="CoverOfBook" src="' . $row['FrontCover'] . '">';
                echo '<img id="BackCover" src="' . $backCover . '">';
            ?>
        </div>
        <span class="TextContainer">
            <h2><?php echo $row['Name'] ?></h2>
            <p style="font-size: 10px; color: var(--gray);">Код товару: <?php echo $row['BookID'] ?></p>
            <p>Автор: 
                <?php
                $authors = explode(", ", $row['Author']);

                foreach ($authors as $author) {
                    echo '<a class="AuthorLink" style="color: var(--a-color);" href="АвторськаСторінка.php?id=' . urlencode($author) . '">' . $author . '</a>';

                    if ($author !== end($authors)) {
                        echo ', ';
                    }
                }
                ?>
            </p>
            <p>Видавництво: <?php echo $row['Publishing'] ?></p>
            <p>Кількість сторінок: <?php echo $row['PagesNumber'] ?></p>
            <p>Мова видання: <?php echo $row['Language'] ?></p>
            <p>Рік видання: <?php echo date('Y', strtotime($row['DateExact'])) ?></p>
            <?php
                $discount_exist_query = "SELECT Expires FROM discounts WHERE BookID = '" . $row['BookID'] . "'";
                $discount_exist_result = mysqli_query($conn, $discount_exist_query);
                $dateFromDatabase = new DateTime($row['DateExact']);
                $currentDate = new DateTime();

                $hasDiscount = false;
                if ($disc = mysqli_fetch_assoc($discount_exist_result)) {
                    $hasDiscount = true;
                    if ($dateFromDatabase <= $currentDate) {
                        echo '<p>Знижка діє до: ' . $disc['Expires'] . '</p>';
                    } 
                }
                if ($dateFromDatabase > $currentDate) {
                    echo '<p>Передзамовлення діє до: ' . $row['DateExact'] . '</p>';
                }
            ?>

                <h2 id="price"><?php echo $row['Price'] . ' грн'; ?></h2>

            <?php
                $buttonText = ($dateFromDatabase > $currentDate) ? "Передзамовити" : "Додати в корзину";
                echo '<button type="button" id="InCart" data-product-id="' . $row['BookID'] . '"><a>' . $buttonText . '</a><span id="InCartBG"></span></button>';
            ?>



        </span>
        </div>
        <h2 id="descTitle">Опис</h2>
        <div id="descriptionCont">
            <?php
            echo '<p id="desc">' . $row['Description'] . '</p>';
            ?>
            <span id="gradient"></span>
        </div>
        <svg id="arrowDown" width="50" height="50" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M1.55279 6.77639C1.67628 6.5294 1.97662 6.42929 2.22361 6.55279L8 9.44098L13.7764 6.55279C14.0234 6.42929 14.3237 6.5294 14.4472 6.77639C14.5707 7.02338 14.4706 7.32372 14.2236 7.44721L8.22361 10.4472C8.08284 10.5176 7.91716 10.5176 7.77639 10.4472L1.77639 7.44721C1.5294 7.32372 1.42929 7.02338 1.55279 6.77639Z" fill="black" />
        </svg>
        <div id="SeriesContainer">
                
        </div>
        <div id="Cart"><img src="shopping-cart.png" width="20"></div>
        <div id="CartWindow">
            <h2 style="text-align: center; height: 20px;">Корзина</h2>
        </div>
    </section>
        <?php
            if (!empty($row['SeriesName'])) {
                $IsSeries = 'true';
            } else {
                $IsSeries = 'false';
            }
        ?>

        <script>
            let SeriesContainer = document.getElementById('SeriesContainer');
            let IsSeries = <?php echo $IsSeries; ?>;

            if (IsSeries) {
                let seriesTitle = document.createElement('h3');
                seriesTitle.textContent = 'Усі книги серії "<?php echo mysqli_real_escape_string($conn, $row['SeriesName']); ?>":';
                SeriesContainer.appendChild(seriesTitle);

                let seriesBooks = document.createElement('div');
                seriesBooks.id = "BooksItself";
                seriesBooks.innerHTML = '<?php
                    $thisBookSeriesName = mysqli_real_escape_string($conn, $row['SeriesName']);
                    $query = "SELECT * FROM books ORDER BY NumberInSeries";
                    $result = mysqli_query($conn, $query);
                    $books = array();

                    while ($singleRow = mysqli_fetch_array($result)) {
                        if (!empty($singleRow['SeriesName']) && $singleRow['SeriesName'] == $thisBookSeriesName){
                            echo '<div class="book-container">';
                            echo '<div class="NumInSeries">' . 'Книга ' . $singleRow['NumberInSeries'] . '</div>';
                            echo '<a href="КнижковаСторінка.php?id=' . urlencode($singleRow['Name'] . ' ' . $singleRow['Author'] . ' ' . $singleRow['BookID']) . '">';
                            echo '<img class="cover" src="' . $singleRow['FrontCover'] . '">';
                            echo '</a>';
                            echo '<div class="description">';
                            echo '<div class="book-name">' . mysqli_real_escape_string($conn, $singleRow['ShortName']) . '</div>';
                            echo '<div class="book-author">' . mysqli_real_escape_string($conn, $singleRow['Author']) . '</div>';
                            echo '<div class="price">' . $singleRow['Price'] . ' грн</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }

                ?>';
                SeriesContainer.appendChild(seriesBooks);
            }
        </script>
            <div id="BookCommentSection">
                <h3>Відгуки користувачів</h3>
                <div id="BookCommentsBlock">
                    <div id="BookComments">
                        <?php 
                            $current_book_id = $row['BookID'];
                            $bc_query = "
                                SELECT c.commentId, c.userName, c.userPic, c.commentText, c.Rate, c.Likes 
                                FROM comments c 
                                JOIN BooksComments bc ON c.commentId = bc.CommentID 
                                WHERE bc.BookID = '$current_book_id'
                                ORDER BY c.Likes DESC, c.Rate DESC, c.postTime DESC";
                            $bc_result = mysqli_query($conn, $bc_query);
                            if (mysqli_num_rows($bc_result) > 0) {
                                while ($bc_row = mysqli_fetch_array($bc_result)) {
                                    $userPic = htmlspecialchars($bc_row['userPic'], ENT_QUOTES, 'UTF-8');
                                    $userName = htmlspecialchars($bc_row['userName'], ENT_QUOTES, 'UTF-8');
                                    $commentText = htmlspecialchars($bc_row['commentText'], ENT_QUOTES, 'UTF-8');
                                    $commentId = htmlspecialchars($bc_row['commentId'], ENT_QUOTES, 'UTF-8');
                                    $stars = htmlspecialchars($bc_row['Rate'], ENT_QUOTES, 'UTF-8');
                                    $likes = htmlspecialchars($bc_row['Likes'], ENT_QUOTES, 'UTF-8');
                        
                                    echo "<div class='Comment' data-comment-id='" . $commentId . "'>";
                                    echo "<div class='Avatar'><img src='" . $userPic . "' alt=''></div>";
                                    echo "<div class='CommentText'>
                                            <div class='CommentTextItself'>
                                                <h3 class='CommUserName'>" . $userName . "</h3>
                                                <p>" . $commentText . "</p>
                                            </div>
                                            <div class='CommentStars'>
                                                <div class='starsDisplay' style='color: var(--a-color);'>" . str_repeat('★', $stars) . str_repeat('☆', 5 - $stars) . "</div>
                                            </div>
                                            <div class='Likes'>
                                                <a class='LikeComment'>♥</a>
                                                <span class='likeCount'></span>
                                            </div>
                                          </div>";
                                    echo "</div>";
                                }
                            } else {
                                // if (mysqli_num_rows($bc_result) > 0) {
                                //     while ($bc_row = mysqli_fetch_array($bc_result)) {
                                //         $userPic = htmlspecialchars($bc_row['userPic'], ENT_QUOTES, 'UTF-8');
                                //         $userName = htmlspecialchars($bc_row['userName'], ENT_QUOTES, 'UTF-8');
                                //         $commentText = htmlspecialchars($bc_row['commentText'], ENT_QUOTES, 'UTF-8');
                                        
                                //         echo "<div class='Comment'>";
                                //         echo "<div class='Avatar'><img src='" . $userPic . "' alt=''></div>";
                                //         echo "<div class='CommentText'><div><h3 class='CommUserName'>" . $userName . "</h3><p>" . $commentText . "</p></div></div>";
                                //         echo "</div>";
                                //     }
                                // } else {
                                //     echo "Немає відгуків для відображення.";
                                // }
                                echo "Немає коментарів для відображення.";
                            }
                        ?>
                    </div>
                </div>
                <div class="undercomms" id="BookUndercomms">
                    <p class="MakeBookComment" id="MakeComment">Залишити відгук про книгу</p>
                </div>
            </div>
            <script src="MakeComments.js"></script>
            <script src="CommentStarsAndLikes.js"></script>
            <script src="SetDiscounts.js" defer></script>
            <?php
            if (isset($_POST['postComm']) && isset($_SESSION['id'])) {
                if (strlen($_POST['commText']) > 0) {
                    $userId = $_SESSION["id"];

                    $userInfoQuery = "SELECT FirstName, LastName, `image` FROM users WHERE userId = '$userId'";
                    $userInfoResult = mysqli_query($conn, $userInfoQuery);
                    $userInfoRow = mysqli_fetch_assoc($userInfoResult);

                    $firstName = mysqli_real_escape_string($conn, $userInfoRow['FirstName']);
                    $lastName = mysqli_real_escape_string($conn, $userInfoRow['LastName']);
                    $userName = $firstName . ' ' . $lastName;
                    $userPic = mysqli_real_escape_string($conn, $userInfoRow['image']);
                    $rating = $_POST['rating'];
                    $commentText = mysqli_real_escape_string($conn, $_POST["commText"]);

                    $comms_sql = "INSERT INTO `comments` (`userId`, `userName`, `userPic`, `commentText`, `Rate`) 
                        VALUES ('$userId', '$userName', '$userPic', '$commentText', '$rating')";
                    if (mysqli_query($conn, $comms_sql)) {
                        $commentId = mysqli_insert_id($conn);

                        $link_comm_sql = "INSERT INTO BooksComments(BookID, CommentID) VALUES ('$current_book_id', '$commentId')";
                        mysqli_query($conn, $link_comm_sql);
                    }
                    header("Location: КнижковаСторінка.php?id=" . urlencode($row['Name'] . ' ' . $row['Author'] . ' ' . $row['BookID']));
                } else {
                    echo "Коментар не може бути порожнім.";
                }
            }
            ?>
        <script>
            
            const cartIcon = document.getElementById('Cart');
            const InCartBtn = document.getElementById('InCart');
            const cartWin = document.getElementById('CartWindow');
            let books = [];
            let CartOpen = sessionStorage.getItem('CartOpen') === 'true' ? 'true' : 'false';
            let storedBooks = JSON.parse(localStorage.getItem('books')) || [];
            let spacer = document.createElement('div');
            spacer.classList.add('spacer');
            let totalElement = document.createElement('p');
            let totalTitle = document.createElement('p');
            totalElement.classList.add('totalElement');
            totalTitle.classList.add('totalTitle');

            function updateTotal() {
                if (totalElement.parentNode) {
                    totalElement.parentNode.removeChild(totalElement);
                }

                let total = 0;
                let storedBooksIds = [];
                storedBooks.forEach(storedBook => {
                    let singlePrice = parseFloat(storedBook.singlePrice);
                    if (!isNaN(singlePrice)) {
                        total += singlePrice * storedBook.quantity;
                    }
                    let bookId = storedBook.code;
                    let quantity = storedBook.quantity;
                    let element = document.querySelector('.bookElement#' + storedBook.code + ' .CartPrice');
                    LoadDiscounts(bookId, quantity, element);
                    storedBooksIds.push({ code: storedBook.code, quantity: storedBook.quantity });
                });

                totalElement = document.createElement('p');
                totalElement.classList.add('totalElement');
                totalElement.textContent = total.toFixed(1) + ' грн';
                LoadTotalDiscount(storedBooksIds, total.toFixed(1), totalElement);
                spacer.appendChild(totalElement);
                UpdateStoredBooks();
            }
            function LoadTotalDiscount(storedBooksIds, originalTotal, totalElement) {
                $.ajax({
                    url: 'load_total_with_discounts.php',
                    method: 'GET',
                    data: {
                        ids: JSON.stringify(storedBooksIds),
                        originalTotal: originalTotal
                    },
                    success: function(data) {
                        totalElement.innerHTML = parseFloat(data).toFixed(1) + ' <s style="color: var(--red);">' + originalTotal + '</s> грн';
                    }
                });
            }
            function LoadDiscounts(bookId, quantity, element) {
                $.ajax({
                    url: 'load_discounts.php',
                    method: 'GET',
                    data: { 
                        bookId: bookId, 
                        quantity: quantity 
                    },
                    success: function(data) {
                        element.innerHTML = data;
                        console.log('Successfully loaded discounts.');
                    }
                    
                });
            }
            function transferToBook() {
                const bookElements = cartWin.querySelectorAll('.bookElement');
                bookElements.forEach(bookElement => {
                    const covers = bookElement.querySelectorAll('.CartCover');
                    let bookTitle = bookElement.querySelector('.CartTitle').textContent;
                    let bookAuthor = bookElement.querySelector('.CartAuthor').textContent;
                    let bookCode = bookElement.id;

                    covers.forEach(cover => {
                        cover.addEventListener('click', function () {
                            const encodedString = encodeURIComponent(bookTitle + ' ' + bookAuthor + ' ' + bookCode);
                            const url = 'КнижковаСторінка.php?id=' + encodedString.replace(/%20/g, '+');
                            console.log(url);
                            window.location.href = url;
                        })
                    });
                });
            }

            function handleDeleteClick() {
                const bookElements = cartWin.querySelectorAll('.bookElement');
                bookElements.forEach(bookElement => {
                    const deleteBtns = bookElement.querySelectorAll('.deleteButton');
                    deleteBtns.forEach(deleteBtn => {
                        deleteBtn.addEventListener('click', function () {
                            console.log("Book has been deleted");
                            storedBooks = storedBooks.filter(storedBook => storedBook.code != bookElement.id);
                            if (cartWin.contains(bookElement)) {
                                cartWin.removeChild(bookElement);
                            }                
                            localStorage.setItem('books', JSON.stringify(storedBooks));
                            updateTotal();
                            UpdateStoredBooks();
                        })
                    });
                });
            }



            function ToggleCartOpening(CartOpen) {
                if (CartOpen === 'false') {
                    console.log(CartOpen);
                OpenCart(CartOpen); 
                } else {
                    console.log(CartOpen);
                CloseCart(CartOpen);
                }
            }

            function OpenCart(CartOpen) {
                if(CartOpen === 'false'){
                if(document.documentElement.clientWidth > 1000) {
                    console.log("Screen width is bigger than 1000px.");
                    cartIcon.style.right = '502px';
                    cartWin.style.right = '0px';
                    sessionStorage.setItem('CartOpen', 'true');
                }
                else {
                    console.log("Screen width is smaller than 1000px.");
                    cartIcon.style.right = '350px';
                    cartWin.style.right = '0px';
                    sessionStorage.setItem('CartOpen', 'true');
                }
                console.log("OPEN DEBUGGER: ", cartWin.style.right, cartIcon.style.right);
            }
            }

            function CloseCart(CartOpen) {
                if (CartOpen === 'true'){
                if(document.documentElement.clientWidth > 1000) {
                    console.log("Screen width is bigger than 1000px.");
                    cartIcon.style.right = '-2px';
                    cartWin.style.right = '-502px';
                    sessionStorage.setItem('CartOpen', 'false');
                }
                else {
                    console.log("Screen width is smaller than 1000px.");
                    cartIcon.style.right = '-3px';
                    cartWin.style.right = '-350px';
                    sessionStorage.setItem('CartOpen', 'false');
                }
                console.log("CLOSE DEBUGGER: ", cartWin.style.right, cartIcon.style.right);
            }
            }

            document.addEventListener('click', function (event) {
                // Перевірка, чи був клік всередині кошика або на іконці кошика
                let isClickInsideCart = cartIcon.contains(event.target) || cartWin.contains(event.target);
                let isClickOnInCartBtn;
                // Перевірка, чи був клік на кнопці "В кошику"
                if (InCartBtn){
                    isClickOnInCartBtn = InCartBtn.contains(event.target);
                } else {
                    isClickOnInCartBtn = 'true';
                }
                // Перевірка, чи кошик відкритий і був клік поза кошиком
                if (sessionStorage.getItem('CartOpen') === 'true' && !isClickInsideCart && !isClickOnInCartBtn) {
                    CloseCart(sessionStorage.getItem('CartOpen'));
                }
            });

            window.onload = function () {
                if (document.getElementById('loader-wrapper')) {
                    let loaderWrapper = document.getElementById('loader-wrapper');
                    loaderWrapper.style.display = 'none';
                }
                storedBooks = JSON.parse(localStorage.getItem('books')) || [];
                sessionStorage.setItem('CartOpen', 'false');
                if (storedBooks) {
                    let total = 0;

                    for (let storedBook of storedBooks) {
                        let bookElement = document.createElement('div');
                        bookElement.innerHTML = storedBook.innerHTML;
                        bookElement.id = storedBook.code;
                        bookElement.classList.add('bookElement');
                        Object.assign(bookElement.style, storedBook.style);
                        let quantityInput = bookElement.querySelector('.quantityItself');

                        if (quantityInput) {
                            let quantity = storedBook.quantity || 1;
                            quantityInput.textContent = quantity;

                            const priceElement = bookElement.querySelector('.CartPrice');
                            let price = parseFloat(priceElement.textContent.replace(/[^0-9\.]/g, ''));
                            let bookTotal = price * quantity;
                            priceElement.textContent = bookTotal.toFixed(2) + ' грн';

                            total += bookTotal;
                        }

                        cartWin.appendChild(bookElement);
                    }
                }

                totalTitle.textContent = "Загальна вартість: ";
                spacer.appendChild(totalTitle);
                cartWin.appendChild(spacer);

                let purchaseButton = document.createElement('button');
                purchaseButton.type = 'button';
                purchaseButton.id = "Purchase";
                purchaseButton.textContent = "Оформити замовлення";
                purchaseButton.addEventListener('click', handlePurchaseClick);
                purchaseButton.addEventListener('touchstart', handlePurchaseClick);

                

                let genreLinks = document.querySelectorAll('.genreLink');
                let storedGenre = localStorage.getItem('genreFilter');

                genreLinks.forEach(genreLink => {
                    genreLink.addEventListener('click', function () {
                        storedGenre = genreLink.getAttribute('genre-link');
                        localStorage.setItem('genreFilter', storedGenre);
                    });
                });
                cartIcon.addEventListener('click', function() {
                    CartOpen = sessionStorage.getItem('CartOpen');
                    ToggleCartOpening(CartOpen);
                });
                

                cartWin.appendChild(purchaseButton);
                updateTotal();
                handleDeleteClick();
                changeQuantity();
                transferToBook();
            };
            function handlePurchaseClick() {
                window.location.href = "ОформленняЗамовлення.php";
            }
            InCartBtn.addEventListener('click', function(event) {
                event.preventDefault();
                let bookTitle = '<?php echo mysqli_real_escape_string($conn, $row['Name']); ?>';
                let bookAuthor = '<?php echo $row["Author"]; ?>';
                let bookCover = '<?php echo $row["FrontCover"]; ?>';
                let bookPrice = '<?php echo $row["Price"]; ?>';
                bookPrice = parseFloat(bookPrice);
                bookPrice = bookPrice.toFixed(2);
                let bookCode = '<?php echo $row['BookID']; ?>';
                ToggleCartOpening('false');
                console.log('1');
                if (storedBooks.some(storedBook => storedBook.code == bookCode)) {
                    console.log("Книга вже існує. Збільшую її кількість на 1.")
                    const existingBook = storedBooks.find(storedBook => storedBook.code === bookCode);
                    const book = document.getElementById(bookCode);
                    existingBook.quantity++;
                    localStorage.setItem('books', JSON.stringify(storedBooks));
                    updateQuantity(book, existingBook.quantity);
                } else {
                    console.log("Книга ще не існує. Додаю в кошик.")
                    addBookToCart(bookTitle, bookAuthor, bookCover, bookPrice, bookCode);
                }
            });
            function addBookToCart(bookTitle, bookAuthor, bookCover, bookPrice, bookCode){
                console.log('2');
                let deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.setAttribute('related-book', bookCode);
                deleteBtn.classList.add('deleteButton');
                deleteBtn.innerHTML = '<img src="x-mark.png" width="20">';
                let quantityContainer = '<div class="Quantity"><button class="DecreaseQuantity">-</button><span class="quantityItself" quantity-of="' + bookCode + '">1</span><button class="IncreaseQuantity">+</button>';
                let bookElement = document.createElement('div');
                bookElement.classList.add('bookElement');
                bookElement.innerHTML = '<img class="CartCover" src="' + bookCover + '" alt="Обкладинка" class="CartCover">' + '<h4 class="CartTitle">' + bookTitle + '</h4><p class="CartAuthor">' + bookAuthor + '</p><h4 class="CartPrice" price-of="' + bookCode + '">' + bookPrice + ' грн</h4>' + quantityContainer;
                bookElement.appendChild(deleteBtn);
                bookElement.id = bookCode;
                let clearPrice = bookPrice.replace(/[^0-9\.]/g, '');
                storedBooks.push({
                    code: bookCode,
                    innerHTML: bookElement.innerHTML,
                    singlePrice: clearPrice,
                    quantity: bookElement.querySelector('.quantityItself').textContent,
                    style: {
                        display: bookElement.style.display,
                        width: bookElement.style.width,
                        margin: bookElement.style.margin,
                        gridTemplateColumns: bookElement.style.gridTemplateColumns,
                        gridTemplateRows: bookElement.style.gridTemplateRows
                    }
                });
                localStorage.setItem('books', JSON.stringify(storedBooks));

                let purchaseButton = document.getElementById('Purchase');
                purchaseButton.addEventListener('click', handlePurchaseClick);
                console.log(handlePurchaseClick);
                totalTitle.textContent = "Загальна вартість: ";
                updateTotal();

                spacer.appendChild(totalTitle);
                cartWin.appendChild(spacer);
                if (spacer){
                    cartWin.removeChild(spacer);
                }
                if (purchaseButton) {
                    cartWin.removeChild(purchaseButton);
                }
                cartWin.appendChild(bookElement);
                if (purchaseButton) {
                    cartWin.appendChild(purchaseButton);
                }
                cartWin.appendChild(spacer);
                handleDeleteClick();
                changeQuantityNew(bookElement);
            }
            function UpdateStoredBooks() {
                let storedB = JSON.parse(localStorage.getItem("books"));
                let xhr = new XMLHttpRequest();
                xhr.open('POST', 'update_stored_books.php', true);
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        console.log(xhr.responseText);
                    }
                };
                xhr.send(JSON.stringify({books: storedB}));
            }
            document.addEventListener('DOMContentLoaded', function () {
                // Отримати посилання на елементи
                const menuToggle = document.getElementById('menuToggle');
                const navs = document.querySelectorAll('nav');
                const cabinet = document.getElementById('Cabinet');
                
                // Додати обробник подій для кліку на #menuToggle
                menuToggle.addEventListener('click', function () {
                    // Змінити стилі в залежності від стану меню
                    navs.forEach(nav => {
                    if (nav.style.display === 'grid') {
                        nav.style.display = 'none';
                        // Змінити атрибути grid-row та grid-column на початкові значення
                        nav.style.gridRow = 'initial';
                        nav.style.gridColumn = 'initial';
                        nav.classList.remove('active-menu');
                    } else {
                        nav.style.display = 'grid';
                        // Змінити атрибути grid-row та grid-column на нові значення
                        nav.classList.add('active-menu');
                    }   
                    });
                });

                let bookId = '<?php echo $row['BookID']; ?>';
                let bookPrice = document.getElementById('price');
                $.ajax({
                    url: 'load_discounts.php',
                    method: 'GET',
                    data: {
                        bookId: bookId,
                        quantity: 1
                    },
                    success: function(data) {
                        bookPrice.innerHTML = data;
                    }
                })
            });
            
            function changeQuantity() {
                const bookElements = document.querySelectorAll('.bookElement');
                bookElements.forEach(bookElement => {
                    console.log(bookElement);
                    const decreaseButton = bookElement.querySelector(".DecreaseQuantity");
                    const increaseButton = bookElement.querySelector(".IncreaseQuantity");

                        if (!decreaseButton.onclick) {
                            decreaseButton.addEventListener('click', function () {
                                DecreaseQuantity(bookElement); // Capture the current bookElement
                            });
                        }

                        if (!increaseButton.onclick) {
                            increaseButton.addEventListener('click', function () {
                                IncreaseQuantity(bookElement); // Capture the current bookElement
                            });
                        }
                });
            }
            function changeQuantityNew(bookElement) {
                const decreaseButton = bookElement.querySelector(".DecreaseQuantity");
                    const increaseButton = bookElement.querySelector(".IncreaseQuantity");

                        if (!decreaseButton.onclick) {
                            decreaseButton.addEventListener('click', function () {
                                DecreaseQuantity(bookElement); // Capture the current bookElement
                            });
                        }

                        if (!increaseButton.onclick) {
                            increaseButton.addEventListener('click', function () {
                                IncreaseQuantity(bookElement); // Capture the current bookElement
                            });
                        }
            }

            function DecreaseQuantity(bookElement) {
                console.log('Book Element is ', bookElement);
                const quantityInput = bookElement.querySelector(".quantityItself");
                let newQuantity = parseInt(quantityInput.textContent, 10) - 1;

                if (newQuantity < 0) {
                    newQuantity = 0;
                }

                updateQuantity(bookElement, newQuantity);
            }


            function IncreaseQuantity(bookElement) {
                console.log('Book Element is ', bookElement);
                    const quantityInput = bookElement.querySelector(".quantityItself");
                    let newQuantity = parseInt(quantityInput.textContent, 10) + 1;

                    updateQuantity(bookElement, newQuantity);
            }

            function updateQuantity(bookElement, newQuantity) {
                const quantityInput = bookElement.querySelector(".quantityItself");
                quantityInput.textContent = newQuantity;
                    
                console.log("Quantity of " + bookElement.id + " has been changed to " + newQuantity + ".");
                    
                let changedBook = storedBooks.find(storedBook => storedBook.code === bookElement.id);
                changedBook.quantity = newQuantity;
                localStorage.setItem('books', JSON.stringify(storedBooks));
                    
                console.log("Quantity of " + bookElement.id + " has been set in local storage.");
                    
                let newPrice = changedBook.singlePrice * newQuantity;
                let priceText = bookElement.querySelector('.CartPrice');
                priceText.textContent = newPrice.toFixed(2) + ' грн';
                    
                console.log("New price of " + bookElement.id + " has been set.");
                updateTotal();
            }
        </script>
        <script src="Comments.js"></script>
    <script src="Description.js"></script>
    <script src="Search.js"></script>
    <script src="FooterAdder.js" defer></script>
</body>
<footer>
</footer>

</html>
<?php 
    ob_end_flush();
?>