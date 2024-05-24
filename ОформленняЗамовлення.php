<?php
    session_start();
    if(!isset($_SESSION['id'])) {
        header('Location: Кабінет.php', true, 302);
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформити замовлення</title>
    <link rel="stylesheet" href="Title Main.css">
    <link rel="stylesheet" href="Carousel of images.css">
    <link rel="stylesheet" href="Main page.css">
    <link rel="stylesheet" href="CartStyles.css">
    <link rel="stylesheet" href="Ordering.css">
    <link rel="stylesheet" href="AuthorsStyles.css">
    <link rel="stylesheet" href="ScreenAdaptation.css">
    <link rel="icon" type="image/x-icon" href="favicon1.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/inputmask@5.0.8/dist/jquery.inputmask.min.js"></script>
    <script src="OrderingAPIs.js"></script>
</head>
<header>
    <a id="SearchToggle"><img src="search.png" id="search" width="20px"></a>
    <h1><a id="Title" href="КнигарняTitle.php">Title</a></h1>
    <nav>
        <a id="Catalog" href="Каталог.php">Каталог</a>
        <a id="Authors" href="Автори.php">Автори</a>
        <h1><a id="TitleNav" href="КнигарняTitle.php">Title</a></h1>
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
        <ol>
            <div id="ShippingInfo">
            <?php
            require('connect_db.php');
            $row = mysqli_fetch_assoc(mysqli_query($conn, 'SELECT * FROM `users` WHERE `userId` = ' . $_SESSION['id'] . ''));
            $phoneNumber = !empty($row['PhoneNumber']) ? $row['PhoneNumber'] : null;
            echo '<li>
                    <div id="ContactInfo">
                        <h3>Контактна інформація</h3>
                    
                        <label for="phoneNumber">Ваш номер телефону (необов\'язково):</label>
                        <input type="tel" id="phoneNumber" name="phoneNumber" placeholder="+380(__) ___ __ __" value="'. $phoneNumber .'">
                        
                        <label for="userMail">Ваш email:</label>
                        <input type="email" id="userMail" name="userMail" placeholder="Ваш email:" value="'. $row['Email'] .'">
                        
                        <label for="userName">Ваше ПІБ:</label>
                        <input type="text" id="userName" name="userName" placeholder="Введіть ПІБ повністю" value="'. $row['LastName'] . ' ' . $row['FirstName'] . ' ' . $row['MiddleName'] . '">
                    </div>
                </li>';
            ?>

            <li>
                <form action="" id='pickDelivery'>
                    <h3>Спосіб доставки</h3>
                    <div id="DeliveryMethod">
                        <label class="radioPick">
                            <input type="radio" name="deliveryMethod" id="NovaPoshta" value="NOVA"> NOVA
                        </label>
                        <label class="radioPick">
                            <input type="radio" name="deliveryMethod" id="UkrPoshta" value="Ukrposhta"> Укрпошта
                        </label>
                        <label class="radioPick">
                            <input type="radio" name="deliveryMethod" id="SelfPickup" value="SelfPickup"> Самовивіз
                        </label>
                    </div>
                </form>
            </li>
                <li id="deliveryAddressSelection">
                    <div id="DeliveryAddress">
                        <h3>Адреса доставки</h3>
                        <label for="TownPick">Місто:</label>
                        <div id="CitiesContainer">
                            <input disabled list="cities" id="TownPick" name="deliveryCity" placeholder="Спочатку оберіть спосіб доставки">
                            <div id="cities"></div>
                        </div>
                        <label for="PostOfficePick">Відділення пошти:</label>
                        <div id="WarehouseContainer">
                            <input id="PostOfficePick" name="postOffice" placeholder="Почніть вводити номер відділення або вулицю">
                            <div id="warehouses"></div>
                        </div>
                    </div>
                </li>
            <li>
                <form action="" id="PaymentMethod">
                    <h3>Спосіб оплати</h3>
                    <div id="paymentSelectContainer">
                        <label class="radioPick">
                            <input type="radio" name="PaymentMethod" id="CardPayment" value="CardPayment">VISA/MASTERCARD
                        </label>
                        <label class="radioPick">
                            <input type="radio" name="PaymentMethod" id="CashPayment" value="CashPayment">При отриманні
                        </label>
                    </div>
                </form>
                <div id="CardInfoContainer">
                    <h3>Введіть дані вашої картки</h3>
                    <input type="text" name="CardNumber" id="CardNumber" placeholder="Номер картки">
                    <input type="text" name="CardDate" id="CardDate" placeholder="Дата">
                    <input type="text" name="CardCVV" id="CardCVV" placeholder="CVC/CVV" maxlength="3">
                    <div id="CardLogoBox">
                        <img src="credit-card.png" alt="Logo" id="CardLogo" width="40">
                    </div>
                    <p>Всі дані захищені.</p>
                </div>
            </li>

        </div>
        </ol>

        <div id="OrderingBooks">
            <h2>Ваше замовлення:</h2>
        <script>
            let OrdBooks = document.getElementById('OrderingBooks');
            let books = [];
            let storedBooks = JSON.parse(localStorage.getItem('books')) || [];
            let spacer = document.createElement('div');
            spacer.classList.add('spacerOrd');
            let totalElement = document.createElement('p');
            let totalTitle = document.createElement('p');
            totalElement.classList.add('totalElement');
            totalTitle.classList.add('totalTitle');

            function updateTotal() {
                if (totalElement.parentNode) {
                    totalElement.parentNode.removeChild(totalElement);
                }

                let total = 0;

                storedBooks.forEach(storedBook => {
                    let singlePrice = parseFloat(storedBook.singlePrice);
                    if (!isNaN(singlePrice)) {
                        total += singlePrice * storedBook.quantity;
                    }
                });

                totalElement = document.createElement('p');
                totalElement.classList.add('totalElement');
                totalElement.textContent = total.toFixed(2) + ' грн';
                spacer.appendChild(totalElement);
                let tTotalEl = document.createElement('p');
                tTotalEl.classList.add('totalElement');
                tTotalEl.textContent = totalElement.textContent;
                let totalPrice = document.getElementById('totalPrice');
                totalPrice.appendChild(tTotalEl);
                UpdateStoredBooks();
            }

            function transferToBook() {
                const bookElements = document.querySelectorAll('.bookElement');
                bookElements.forEach(bookElement => {
                    const covers = bookElement.querySelectorAll('.CartCover');
                    let bookTitle = bookElement.querySelector('.CartTitle').textContent;
                    let bookAuthor = bookElement.querySelector('.CartAuthor').textContent;
                    covers.forEach(cover => {
                        cover.addEventListener('click', function () {
                            const encodedString = encodeURIComponent(bookTitle + ' ' + bookAuthor);
                            const url = 'КнижковаСторінка.php?id=' + encodedString.replace(/%20/g, '+');
                            console.log(url);
                            window.location.href = url;
                        })
                    });
                });
            }

            function handleDeleteClick() {
                const bookElements = document.querySelectorAll('.bookElement');
                bookElements.forEach(bookElement => {
                    const deleteBtns = bookElement.querySelectorAll('.deleteButton');
                    deleteBtns.forEach(deleteBtn => {
                        deleteBtn.addEventListener('click', function () {
                            console.log("Book has been deleted");
                            storedBooks = storedBooks.filter(storedBook => storedBook.code != bookElement.id);
                            OrdBooks.removeChild(bookElement);
                            localStorage.setItem('books', JSON.stringify(storedBooks));
                            updateTotal();
                        })
                    });
                });
            }

            function changeQuantity() {
                const bookElements = OrdBooks.querySelectorAll('.bookElement');
                
                bookElements.forEach(bookElement => {
                    const decreaseButtons = bookElement.querySelectorAll(".DecreaseQuantity");
                    const increaseButtons = bookElement.querySelectorAll(".IncreaseQuantity");

                    decreaseButtons.forEach(decreaseButton => {
                        decreaseButton.addEventListener('click', function () {
                            DecreaseQuantity(bookElement);
                        });
                    });

                    increaseButtons.forEach(increaseButton => {
                        increaseButton.addEventListener('click', function () {
                            IncreaseQuantity(bookElement);
                        });
                    });
                });
            }
            function DecreaseQuantity(bookElement) {
                const quantityInput = bookElement.querySelector(".quantityItself");
                let newQuantity = parseInt(quantityInput.textContent, 10) - 1;

                if (newQuantity < 0) {
                    newQuantity = 0;
                }

                updateQuantity(bookElement, newQuantity);
            }

            function IncreaseQuantity(bookElement) {
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

            window.onload = function () {
                let storedBooks = JSON.parse(localStorage.getItem('books')) || [];
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

                        OrdBooks.appendChild(bookElement);
                    }
                }

                totalTitle.textContent = "Загальна вартість:   ";
                spacer.appendChild(totalTitle);
                OrdBooks.appendChild(spacer);

                updateTotal();
                handleDeleteClick();
                changeQuantity();
                transferToBook();
            };

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
            });
        </script>
        <script src="Search.js"></script>
        </div>
        <div id="totalPrice">
            <p>Загальна вартість:</p>
        </div>
        <input type="submit" id="ConfirmOrder" value="Підтвердити замовлення">
    </section>
</body>
<footer>
    <h1 id="foot-title">Title</h1>
    <span id="catalog-footer">
        <a id="FootCatalog" href="Каталог.php"><h2 id="FootCatalog" style="text-align: left;">Каталог</h2></a>
        <a href="Каталог.php" class="genreLink" genre-link="Fantasy">Фентезі</a>
        <a href="Каталог.php" class="genreLink" genre-link="Horrors">Горрори | Трилери</a>
        <a href="Каталог.php" class="genreLink" genre-link="DarkAcademia">Dark academia</a>
        <a href="Каталог.php" class="genreLink" genre-link="LightAcademia">Light academia</a>
        <a href="Каталог.php" class="genreLink" genre-link="Detective">Детективи</a>
        <a href="Каталог.php" class="genreLink" genre-link="Gothic">Готика</a>
        <a href="Каталог.php" class="genreLink" genre-link="OtherProse">Інша проза</a>
        <a href="Каталог.php" class="genreLink" genre-link="Poetry">Поезія</a>
    </span>
    <span id="other-footer-info">
        <a id="FootAuthors" href="Автори.php"><h2 id="FootAuthors">Автори</h2></a>
        <a id="FootNews" href="Новинки.php"><h2 id="FootNews">Новинки</h2></a>
        <a id="FootContacts" href="Контакти.php"><h2 id="FootContacts">Контакти</h2></a>
        <a href="">@titlebookstore</a>
        <a href="">title@contact.com</a>
        <a href="">+380*********</a>
    </span>
</footer>
</html>