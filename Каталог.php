<?php
    ob_start();
    include('connect_db.php');
    session_start();
?>
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
    <h1><a id="Title" href="index.php">Title</a></h1>
    <nav>
        <a id="Catalog" href="Каталог.php">Каталог</a>
        <a id="Authors" href="Автори.php">Автори</a>
        <h1><a id="TitleNav" href="index.php">Title</a></h1>
        <a id="New" href="Новинки.php">Новинки</a>
        <a id="Contacts" href="Контакти.php">Контакти</a>
        <a id="Cabinet" href="Profile.php"><img src="personal-icon.png" id="pers-cab" width="20px"></a>
    </nav>
    <a id="MainCabinet" href="Profile.php"><img src="personal-icon.png" width="20px"></a>
    <div id="menuToggle">
        <img src="menu.png" alt="Menu" width="20px">
    </div>
    <div id="searchContainer">
        <div id="searchPlusClose">
            <input type="text" id="searchField" placeholder="Введіть назву книги, серії або автора...">
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
    <div id="AllBooksTitle">Книги</div>
    <div id="AllBooks"></div>
    <div id="loading" style="display: show;">Завантажити ще</div>
    <script type="module">
    let offset = 0;
    let limit = 8;

    let loading = false;
    let previousPublFilter = localStorage.getItem('storedPublFilter');
    let previousGenreFilter = localStorage.getItem('storedGenreFilter');
    let previousPriceFilter = JSON.parse(localStorage.getItem('storedPriceFilter'));

    function loadBooks() {
        if (window.innerWidth >= 1828) {
            limit = 10;
        } else {
            limit = 8;
        }

        let storedPublishingFilter = localStorage.getItem('storedPublFilter');
        let storedGenreFilter = localStorage.getItem('storedGenreFilter');
        let storedPriceFilter = JSON.parse(localStorage.getItem('storedPriceFilter'));

        if (storedGenreFilter !== previousGenreFilter || storedPublishingFilter !== previousPublFilter || JSON.stringify(storedPriceFilter) !== JSON.stringify(previousPriceFilter)) {
            console.log(previousGenreFilter, storedGenreFilter, previousPublFilter, storedPublishingFilter);
            previousPublFilter = storedPublishingFilter;
            previousGenreFilter = storedGenreFilter;
            previousPriceFilter = storedPriceFilter;
            offset = 0;
            $('#AllBooks').empty();
        }
        let minFilterPrice = storedPriceFilter ? storedPriceFilter.minPriceValue : 0;
        let maxFilterPrice = storedPriceFilter ? storedPriceFilter.maxPriceValue : <?php echo max(preg_replace("/[^0-9.]/", "", mysqli_fetch_array(mysqli_query($conn, 'SELECT max(`Price`) FROM books'))))?>;
        console.log(minFilterPrice, maxFilterPrice, previousGenreFilter, storedGenreFilter, previousPublFilter, storedPublishingFilter);

        if (loading) return;
        loading = true;

        $.ajax({
            url: 'lazy_loading_catalog.php',
            method: 'GET',
            data: { 
                offset: offset,
                minPriceValue: minFilterPrice,
                maxPriceValue: maxFilterPrice,
                storedPublishingFilter: storedPublishingFilter,
                storedGenreFilter: storedGenreFilter,
                screenWidth: screen.width
            },
            success: function(data) {
                const books = JSON.parse(data);
                console.log(books);
                if (books.length > 0) {
                    books.forEach(book => {
                        $('#AllBooks').append(`
                            <div class="book-container" data-genre="${book.Genre}" data-publishing="${book.PublishingEng}" data-current-price="${book.CurrentPrice}">
                                <a href="КнижковаСторінка.php?id=${encodeURIComponent(book.Name + ' ' + book.Author + ' ' + book.Id)}">
                                    <img class="cover" src="${book.Cover}" alt="${book.Name}">
                                </a>
                                <div class="description">
                                    <div class="book-name">${book.Name}</div>
                                    <div class="book-author">${book.Author}</div>
                                    <div class="price">${book.Price} грн</div>
                                </div>
                                <a class="buy" href="КнижковаСторінка.php?id=${encodeURIComponent(book.Name + ' ' + book.Author + ' ' + book.Id)}"> Придбати </a>
                            </div>
                        `);
                    });
                    offset += limit;
                    $('#loading').show();
                }
                loading = false;
                let booksDiscountBlocks = document.getElementsByClassName('book-container');
                for (let i = 0; i < booksDiscountBlocks.length; i++) {
                    let links = booksDiscountBlocks[i].getElementsByTagName('a');
                    let bookPrice = booksDiscountBlocks[i].getElementsByClassName('price')[0];
                    for (let j = 0; j < links.length; j++) {
                        if (!links[j].classList.contains('buy')) {
                            let href = links[j].getAttribute('href');
                            let url = new URL(href, window.location.origin);
                            let id = url.searchParams.get('id');
                            let idParts = id.split(' ');
                            let bookId = idParts[idParts.length - 1];
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
                        }
                    }
                }
            }
        });
        
    }

    window.addEventListener('storage', function(event) {
        if (event.key === 'storedPublFilter' || event.key === 'storedGenreFilter' || event.key === 'storedPriceFilter') {
            loadBooks();
        }
    });

    $('#loading').on('click', function() {
        loadBooks();
    });

    loadBooks();
    window.loadBooks = loadBooks;
</script>



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

            $discountQuery = 'SELECT b.Price, d.Discount FROM books b LEFT JOIN discounts d ON b.BookID = d.BookID';
            $discountRes = mysqli_query($conn, $discountQuery);

            $prices = [];

            while ($row = mysqli_fetch_assoc($priceRes)) {
                $price = $row['Price'];
                $prices[] = $price;
            }

            while ($row = mysqli_fetch_assoc($discountRes)) {
                $price = $row['Price'];
                $discountPercent = isset($row['Discount']) ? $row['Discount'] * 0.01 : 0;
                $discountedPrice = $price * (1 - $discountPercent / 100);
                $prices[] = $discountedPrice;
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

            let defaultMinPrice = <?php echo $minPrice ?>;
            let defaultMaxPrice = <?php echo $maxPrice ?>;

            priceSlider.noUiSlider.on('update', function(values, handle) {
                let minPriceValue = parseFloat(values[0]);
                let maxPriceValue = parseFloat(values[1]);

                priceDisplay.innerText = minPriceValue.toFixed(0) + "₴ — " + maxPriceValue.toFixed(0) + "₴";

                if (minPriceValue !== defaultMinPrice || maxPriceValue !== defaultMaxPrice) {
                    filterBooksByPrice(minPriceValue, maxPriceValue);
                }
            });


            function filterBooksByPrice(minPriceValue, maxPriceValue) {
                let applFilCont = document.getElementById('appliedFiltersContainer');
                let AllBooks = document.getElementsByClassName("book-container");
                let AllPrices = [];
                    document.querySelectorAll('.book-container').forEach(element => {
                    AllPrices.push(element.getAttribute('data-current-price'));
                });
                let storedGenre = localStorage.getItem('storedGenreFilter');
                let storedPubl = localStorage.getItem('storedPublFilter');

                for (let i = 0; i < AllBooks.length; i++) {
                    let price = parseFloat(AllPrices[i]);
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
                localStorage.setItem('storedPriceFilter', JSON.stringify({minPriceValue: parseFloat(minPriceValue), maxPriceValue: parseFloat(maxPriceValue)}));
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
    <script src="SetDiscounts.js" defer></script>
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
    <script src="FooterAdder.js" defer></script>
</body>
<footer>
</footer>
</html>
<?php
    ob_end_flush();
?>