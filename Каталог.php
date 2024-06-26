<!DOCTYPE html>
<html lang="UTF-8">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title Каталог</title>
    <link rel="stylesheet" href="Title Main.css">
    <link rel="stylesheet" href="Carousel of images.css">
    <link rel="stylesheet" href="books.css">
    <link rel="stylesheet" href="Main page.css">
    <link rel="stylesheet" href="Catalog.css">
    <link rel="stylesheet" href="Title Catalog.css">
    <link rel="stylesheet" href="CartStyles.css">
    <link rel="stylesheet" href="AuthorsStyles.css">
    <link rel="stylesheet" href="ScreenAdaptation.css">
    <link rel="icon" type="image/x-icon" href="favicon1.png">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.js"></script>
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
    <section id='CatalogSection'>
    <div id="Cart"><img src="shopping-cart.png" width="20"></div>
        <div id="CartWindow">
            <h2 style="text-align: center; height: 20px;">Корзина</h2>
        </div>
    <div id="AllBooksTitle">Книги у книгарні Title</div>

    <?php
        include('connect_db.php');

        // Запит для вибору всіх книг з таблиці books
        $query = "SELECT * FROM books ORDER BY `DateExact` DESC";
        $result = mysqli_query($conn, $query);

        // Вивід книг та їх жанрів
        echo '<div id="AllBooks">';
        while ($row = mysqli_fetch_array($result)) {
            // Запит для отримання англійських назв видавництв
            $publ_query = "SELECT PublNameEng FROM publishings WHERE PublName = '" . $row['Publishing'] . "'";
            $publ_result = mysqli_query($conn, $publ_query);
            $publ_row = mysqli_fetch_array($publ_result);

            // Вивід кожної книги
            echo '<div class="book-container" data-genre="' . $row["Genre"] . '" data-publishing="' . $publ_row['PublNameEng'] . '">';
            echo '<a href="КнижковаСторінка.php?id=' . urlencode($row['Name'] . ' ' . $row['Author']) . '">';
            echo '<img class="cover" src="' . $row['Cover'] . '">';
            echo '</a>';
            echo '<div class="description">';
            echo '<div class="book-name">' . $row['Name'] . '</div>';
            echo '<div class="book-author">' . $row['Author'] . '</div>';
            echo '<div class="price">' . $row['Price'] . '</div>';
            echo '</div>';
            echo '<a class="buy" href="КнижковаСторінка.php?id=' . urlencode($row['Name'] . ' ' . $row['Author']) . '"> Придбати </a>';
            echo '</div>';
        }
        echo '</div>';
    ?>


    <aside>
        <h2>Фільтри</h2>
        <a href="#" id="AllBooksFilter" data-genre="AllGenres">Показати всі книги</a>
        <div id="appliedFiltersContainer"></div>
        <h3>Жанр</h3>
        <div id="genreFilter">
        <a href="#" id="Fantasy" data-genre="Fantasy">Фентезі та фантастика</a>
        <a href="#" id="Horrors" data-genre="Horrors">Горрори | Трилери</a>
        <a href="#" id="DarkAcademia" data-genre="Dark Academia">Dark academia</a>
        <a href="#" id="LightAcademia" data-genre="Light Academia">Light academia</a>
        <a href="#" id="Detective" data-genre="Detective">Детективи</a>
        <a href="#" id="Gothic" data-genre="Gothic">Готика</a>
        <a href="#" id="Otherprose" data-genre="Other prose">Інша проза</a>
        <a href="#" id="Poetry" data-genre="Poetry">Поезія</a>
        </div>
        <h3>Видавництво</h3>
        <div id="publishFilter">
        <?php
            $sql = "SELECT * FROM publishings";

            // Виконання запиту
            $result = mysqli_query($conn, $sql);

            while($publ = mysqli_fetch_array($result)) {
                echo "<a href='#' id='" . $publ['PublNameEng'] . "' data-publishing='" . $publ['PublNameEng'] . "'>" . $publ['PublName'] . "</a>";
                
            }
        ?>
        <?php
            $priceQuery = 'SELECT `Price` FROM books';
            $priceRes = mysqli_query($conn, $priceQuery);

            $prices = [];
            while ($row = mysqli_fetch_assoc($priceRes)) {
                $prices[] = preg_replace("/[^0-9.]/", "", $row['Price']);
            }
            $minPrice = min($prices);
            $maxPrice = max($prices);
        ?>

        </div>
        <h3>Ціна</h3>
        <div id="priceFilter">
            <form method="GET" id="slider-container">
                <div id="price-slider">
                    <input type="range" style="display: none;" id="min-price" min="<?php echo $minPrice; ?>" max="<?php echo $maxPrice-1; ?>" value="<?php echo $minPrice; ?>">
                    <input type="range" style="display: none; "id="max-price" min="<?php echo $minPrice+1; ?>" max="<?php echo $maxPrice; ?>" value="<?php echo $maxPrice; ?>">
                </div>
            </form>
            <div id="price-range">
                <span id="price-display"><?php echo $minPrice.'₴-'.$maxPrice.'₴'; ?></span>
            </div>
        </div>

        <script>
            let priceSlider = document.getElementById('price-slider');
            let priceDisplay = document.getElementById('price-display');

            noUiSlider.create(priceSlider, {
                start: [<?php echo $minPrice; ?>, <?php echo $maxPrice; ?>],
                connect: true,
                range: {
                    'min': <?php echo $minPrice; ?>,
                    'max': <?php echo $maxPrice; ?>
                }
            });

            let defaultMinPrice = <?php echo $minPrice ?>; // Вкажіть стандартне значення
            let defaultMaxPrice = <?php echo $maxPrice ?>; // Вкажіть стандартне значення

            priceSlider.noUiSlider.on('update', function(values, handle) {
                let minPriceValue = parseFloat(values[0]);
                let maxPriceValue = parseFloat(values[1]);

                priceDisplay.innerText = minPriceValue.toFixed(0) + "₴ - " + maxPriceValue.toFixed(0) + "₴";

                // Фільтруємо книги за ціною, якщо повзунки не на своїх стандартних місцях
                if (minPriceValue !== defaultMinPrice || maxPriceValue !== defaultMaxPrice) {
                    filterBooksByPrice(minPriceValue, maxPriceValue);
                }
            });


            function filterBooksByPrice(minPriceValue, maxPriceValue) {
                let applFilCont = document.getElementById('appliedFiltersContainer');
                let AllBooks = document.getElementsByClassName("book-container");
                let AllPrices = document.getElementsByClassName('price');
                let storedGenre = localStorage.getItem('storedGenreFilter');
                let storedPubl = localStorage.getItem('storedPublFilter');

                for (let i = 0; i < AllBooks.length; i++) {
                    let price = parseFloat(AllPrices[i].textContent);
                    let genreMatch = true;
                    let publMatch = true;

                    if (storedGenre && AllBooks[i].getAttribute('data-genre') !== storedGenre) {
                        genreMatch = false;
                    }

                    if (storedPubl && AllBooks[i].getAttribute('data-publishing') !== storedPubl) {
                        publMatch = false;
                    }

                    if (!isNaN(price) && price >= minPriceValue && price <= maxPriceValue && genreMatch && publMatch) {
                        AllBooks[i].style.display = "grid";
                    } else {
                        AllBooks[i].style.display = "none";
                    }
                }
                
                let filterText = priceDisplay.innerText;
                let filterId = 'applFilterPrice';
                
                let previousFilter = document.getElementById(filterId);
                if (previousFilter) {
                    applFilCont.removeChild(previousFilter);
                }
                
                let filter = document.createElement('div');
                filter.id = filterId;
                filter.innerText = filterText;
                
                applFilCont.appendChild(filter);
                priceFilterDel(filter);
            }
            
            function priceFilterDel(priceFilter) {
                if (priceFilter){
                    priceFilter.addEventListener('click', function() {
                        applFilCont.removeChild(priceFilter);
                        let storagePrice = localStorage.getItem('storedPriceFilter');
                        if (storagePrice) {
                            localStorage.removeItem('storedPriceFilter');
                        }
                        location.reload();
                    })
                }
            }
            </script>
            





    </aside>
    <div id="aside-toggle">Фільтри</div>
    <script src="CartBooks.js"></script>    
    <script src="Books.js" defer></script>
    <script src="CatalogueFiltration.js" defer></script>
    <script>
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
    </section>
    <script src="Search.js"></script>
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