
        <script>
            const cartIcon = document.getElementById('Cart');
            const InCartBtn = document.getElementById('InCart');
            const cartWin = document.getElementById('CartWindow');
            let CartOpen = sessionStorage.setItem('CartOpen', 'false');
            let books = [];
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
            }

            InCartBtn.addEventListener('click', function() {
                let bookTitle = '<?php echo $row["Name"]; ?>';
                let bookAuthor = '<?php echo $row["Author"]; ?>';
                let bookCover = '<?php echo $row["Cover"]; ?>';
                let bookPrice = '<?php echo $row["Price"]; ?>';
                let bookCode = '<?php echo $row['number']; ?>';
                if (sessionStorage.getItem('CartOpen') != undefined){
                    CartOpen = sessionStorage.getItem('CartOpen');
                }
                else {
                    sessionStorage.setItem('CartOpen', 'false');
                    CartOpen = sessionStorage.getItem('CartOpen');
                }
                if (screen.width > 1000) {
                    CartOpen = sessionStorage.getItem('CartOpen');
                    if (CartOpen === 'false') {
                        cartIcon.style.right = '502px';
                        cartWin.style.right = '0px';
                        sessionStorage.setItem('CartOpen', 'true');
                    } else if (CartOpen === 'true') {
                        cartIcon.style.right = '-3px';
                        cartWin.style.right = '-502px';
                        sessionStorage.setItem('CartOpen', 'false');
                    }
                } else {
                    CartOpen = sessionStorage.getItem('CartOpen');
                    if (CartOpen === 'false') {
                        cartIcon.style.right = '350px';
                        cartWin.style.right = '0px';
                        sessionStorage.setItem('CartOpen', 'true');
                    } else if (CartOpen === 'true') {
                        cartIcon.style.right = '-3px';
                        cartWin.style.right = '-350px';
                        sessionStorage.setItem('CartOpen', 'false');
                    }
                }
                if (storedBooks.some(storedBook => storedBook.code == bookCode)) {
                    const existingBook = storedBooks.find(storedBook => storedBook.code === bookCode);
                    existingBook.quantity++;
                    localStorage.setItem('books', JSON.stringify(storedBooks));
                    let changedBookQuantity = Array.from(cartWin.querySelectorAll('.Quantity'))
                        .find(element => element.getAttribute('quantity-of') === bookCode);
                    if (changedBookQuantity) {
                        changedBookQuantity.value = existingBook.quantity;
                    }
                    let changedBookPrice = Array.from(cartWin.querySelectorAll('.CartPrice'))
                        .find(element => element.getAttribute('price-of') === bookCode);
                    if (changedBookPrice) {
                        changedBookPrice.textContent = existingBook.quantity * existingBook.singlePrice + " грн";
                    }
                    changeQuantity();
                } else {
                    addBookToCart(bookTitle, bookAuthor, bookCover, bookPrice, bookCode);
                
                }
            });
            function addBookToCart(bookTitle, bookAuthor, bookCover, bookPrice, bookCode){
                let deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.setAttribute('related-book', bookCode);
                deleteBtn.classList.add('deleteButton');
                deleteBtn.innerHTML = '<img src="x-mark.png" width="20">';
                let quantityContainer = '<div class="Quantity"><button class="DecreaseQuantity" onclick="DecreaseQuantity()">-</button><span class="quantityItself" quantity-of="' + bookCode + '">1</span><button class="IncreaseQuantity" onclick="IncreaseQuantity()">+</button>';
                let bookElement = document.createElement('div');
                bookElement.classList.add('bookElement');
                bookElement.innerHTML = '<img class="CartCover" src="' + bookCover + '" alt="Обкладинка" class="CartCover">' + '<h4 class="CartTitle">' + bookTitle + '</h4><p class="CartAuthor">' + bookAuthor + '</p><h4 class="CartPrice" price-of="' + bookCode + '">' + bookPrice + '</h4>' + quantityContainer;
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
                purchaseButton.setAttribute('href', "ОформленняЗамовлення.php");
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
                changeQuantity();
            }
            function transferToBook(){
                const bookElements = cartWin.querySelectorAll('.bookElement');
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
                const bookElements = cartWin.querySelectorAll('.bookElement');
                bookElements.forEach(bookElement => {
                    const deleteBtns = bookElement.querySelectorAll('.deleteButton');
                    deleteBtns.forEach(deleteBtn => {
                        deleteBtn.addEventListener('click', function () {
                            console.log("Book has been deleted");
                            storedBooks = storedBooks.filter(storedBook => storedBook.code != bookElement.id);
                            cartWin.removeChild(bookElement);
                            localStorage.setItem('books', JSON.stringify(storedBooks));
                            updateTotal();
                        })
                    });
                });
            }
            function changeQuantity() {
                const bookElements = cartWin.querySelectorAll('.bookElement');
                
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
            window.onload = function() {
                CartOpen = false;
                let storedBooks = JSON.parse(localStorage.getItem('books')) || [];
                if (storedBooks) {
                    let total = 0;

                    for (let storedBook of storedBooks) {
                        let bookElement = document.createElement('div');
                        bookElement.innerHTML = storedBook.innerHTML;
                        bookElement.id = storedBook.code;
                        bookElement.classList.add('bookElement');
                        Object.assign(bookElement.style, storedBook.style);
                        let quantityInput = bookElement.querySelector('.Quantity');
                        if (quantityInput) {
                            let quantity = storedBook.quantity || 1;
                            quantityInput.value = quantity;

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
                if (purchaseButton) {
                    purchaseButton.setAttribute('onclick', "handlePurchaseClick()");
                purchaseButton.addEventListener('click', function() {
                    window.location.href = "ОформленняЗамовлення.php";
                });
                } else {
                console.error("Елемент не знайдено");
                }
                function handlePurchaseClick() {
                    window.location.href = "ОформленняЗамовлення.php";
                }
                let genreLinks = document.querySelectorAll('.genreLink');
                let storedGenre = localStorage.getItem('genreFilter');
                genreLinks.forEach(genreLink => {
                    genreLink.addEventListener('click', function(){
                        storedGenre = genreLink.getAttribute('genre-link');
                        localStorage.setItem('genreFilter', storedGenre);
                    });
                });

                cartWin.appendChild(purchaseButton);
                updateTotal();
                handleDeleteClick();
                changeQuantity();
                transferToBook();
            };
            cartIcon.addEventListener('click', function () {
                if (sessionStorage.getItem('CartOpen') != undefined){
                    CartOpen = sessionStorage.getItem('CartOpen');
                }
                else {
                    sessionStorage.setItem('CartOpen', 'false');
                    CartOpen = sessionStorage.getItem('CartOpen');
                }
                if (screen.width > 1000) {
                    CartOpen = sessionStorage.getItem('CartOpen');
                    if (CartOpen === 'false') {
                        cartIcon.style.right = '502px';
                        cartWin.style.right = '0px';
                        sessionStorage.setItem('CartOpen', 'true');
                    } else if (CartOpen === 'true') {
                        cartIcon.style.right = '-3px';
                        cartWin.style.right = '-502px';
                        sessionStorage.setItem('CartOpen', 'false');
                    }
                } else {
                    CartOpen = sessionStorage.getItem('CartOpen');
                    if (CartOpen === 'false') {
                        cartIcon.style.right = '350px';
                        cartWin.style.right = '0px';
                        sessionStorage.setItem('CartOpen', 'true');
                    } else if (CartOpen === 'true') {
                        cartIcon.style.right = '-3px';
                        cartWin.style.right = '-350px';
                        sessionStorage.setItem('CartOpen', 'false');
                    }
                }
            });
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
                let searchBookCovers = document.querySelectorAll('.cover');
                searchBookCovers.forEach(cover => {
                    cover.addEventListener('click', function() {
                        window.location.href = cover.getAttribute('data-loc');
                    })
                })
                const searchToggle = document.getElementById('SearchToggle');
                const searchWindow = document.getElementById('searchContainer');
                searchToggle.addEventListener('click', function() {
                    searchWindow.style.display = 'block';
                });
                const closeSearch = document.getElementById('closeSearch');
                let booksContainer = document.getElementById('booksContainer');
                let authorsContainer = document.getElementById('authorsContainer');
                let searchField = document.getElementById('searchField');
                closeSearch.addEventListener('click', function() {
                    searchField.value = "";
                    booksContainer.innerHTML = "";
                    authorsContainer.innerHTML = "";
                    searchWindow.style.display = 'none';
                })
            });
        </script>
 <script>
            const cartIcon = document.getElementById('Cart');
            const InCartBtn = document.getElementById('InCart');
            const cartWin = document.getElementById('CartWindow');
            let CartOpen = sessionStorage.setItem('CartOpen', 'false');
            let books = [];
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
            }

            InCartBtn.addEventListener('click', function() {
                let bookTitle = '<?php echo $row["Name"]; ?>';
                let bookAuthor = '<?php echo $row["Author"]; ?>';
                let bookCover = '<?php echo $row["Cover"]; ?>';
                let bookPrice = '<?php echo $row["Price"]; ?>';
                let bookCode = '<?php echo $row['number']; ?>';
                if (sessionStorage.getItem('CartOpen') != undefined){
                    CartOpen = sessionStorage.getItem('CartOpen');
                }
                else {
                    sessionStorage.setItem('CartOpen', 'false');
                    CartOpen = sessionStorage.getItem('CartOpen');
                }
                if (screen.width > 1000) {
                    CartOpen = sessionStorage.getItem('CartOpen');
                    if (CartOpen === 'false') {
                        cartIcon.style.right = '502px';
                        cartWin.style.right = '0px';
                        sessionStorage.setItem('CartOpen', 'true');
                    } else if (CartOpen === 'true') {
                        cartIcon.style.right = '-3px';
                        cartWin.style.right = '-502px';
                        sessionStorage.setItem('CartOpen', 'false');
                    }
                } else {
                    CartOpen = sessionStorage.getItem('CartOpen');
                    if (CartOpen === 'false') {
                        cartIcon.style.right = '350px';
                        cartWin.style.right = '0px';
                        sessionStorage.setItem('CartOpen', 'true');
                    } else if (CartOpen === 'true') {
                        cartIcon.style.right = '-3px';
                        cartWin.style.right = '-350px';
                        sessionStorage.setItem('CartOpen', 'false');
                    }
                }
                if (storedBooks.some(storedBook => storedBook.code == bookCode)) {
                    const existingBook = storedBooks.find(storedBook => storedBook.code === bookCode);
                    existingBook.quantity++;
                    localStorage.setItem('books', JSON.stringify(storedBooks));
                    let changedBookQuantity = Array.from(cartWin.querySelectorAll('.Quantity'))
                        .find(element => element.getAttribute('quantity-of') === bookCode);
                    if (changedBookQuantity) {
                        changedBookQuantity.value = existingBook.quantity;
                    }
                    let changedBookPrice = Array.from(cartWin.querySelectorAll('.CartPrice'))
                        .find(element => element.getAttribute('price-of') === bookCode);
                    if (changedBookPrice) {
                        changedBookPrice.textContent = existingBook.quantity * existingBook.singlePrice + " грн";
                    }
                    changeQuantity();
                } else {
                    addBookToCart(bookTitle, bookAuthor, bookCover, bookPrice, bookCode);
                
                }
            });
            function addBookToCart(bookTitle, bookAuthor, bookCover, bookPrice, bookCode){
                let deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.setAttribute('related-book', bookCode);
                deleteBtn.classList.add('deleteButton');
                deleteBtn.innerHTML = '<img src="x-mark.png" width="20">';
                let bookElement = document.createElement('div');
                bookElement.classList.add('bookElement');
                bookElement.innerHTML = '<img class="CartCover" src="' + bookCover + '" alt="Обкладинка" class="CartCover">' + '<h4 class="CartTitle">' + bookTitle + '</h4><p class="CartAuthor">' + bookAuthor + '</p><h4 class="CartPrice" price-of="' + bookCode + '">' + bookPrice + '</h4><input type="number" quantity-of="' + bookCode + '" class="Quantity" value="1">';
                bookElement.appendChild(deleteBtn);
                bookElement.id = bookCode;
                let clearPrice = bookPrice.replace(/[^0-9\.]/g, '');
                storedBooks.push({
                    code: bookCode,
                    innerHTML: bookElement.innerHTML,
                    singlePrice: clearPrice,
                    quantity: bookElement.querySelector('.Quantity').value,
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
                purchaseButton.setAttribute('href', "ОформленняЗамовлення.php");
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
                changeQuantity();
            }
            function transferToBook(){
                const bookElements = cartWin.querySelectorAll('.bookElement');
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
                const bookElements = cartWin.querySelectorAll('.bookElement');
                bookElements.forEach(bookElement => {
                    const deleteBtns = bookElement.querySelectorAll('.deleteButton');
                    deleteBtns.forEach(deleteBtn => {
                        deleteBtn.addEventListener('click', function () {
                            console.log("Book has been deleted");
                            storedBooks = storedBooks.filter(storedBook => storedBook.code != bookElement.id);
                            cartWin.removeChild(bookElement);
                            localStorage.setItem('books', JSON.stringify(storedBooks));
                            updateTotal();
                        })
                    });
                });
            }
            function changeQuantity(){
                const bookElements = cartWin.querySelectorAll('.bookElement');
                bookElements.forEach(bookElement => {
                    const quantityInputs = bookElement.querySelectorAll(".Quantity");
                    quantityInputs.forEach(inputElement => {
                        inputElement.addEventListener('change', function(){
                            console.log("Quantity of " + bookElement.id + " has been changed to " + inputElement.value + ".");
                            let changedBook = storedBooks.find(storedBook => storedBook.code === bookElement.id);
                            changedBook.quantity = inputElement.value;
                            localStorage.setItem('books', JSON.stringify(storedBooks));
                            console.log("Quantity of " + bookElement.id + " has been set in local storage.");
                            let newPrice = changedBook.singlePrice * inputElement.value;
                            let priceText = bookElement.querySelector('.CartPrice');
                            priceText.textContent = newPrice.toFixed(2) + ' грн';
                            console.log("New price of " + bookElement.id + " has been set.");
                            updateTotal();
                        });
                    });
                });
            }
            window.onload = function() {
                CartOpen = false;
                let storedBooks = JSON.parse(localStorage.getItem('books')) || [];
                if (storedBooks) {
                    let total = 0;

                    for (let storedBook of storedBooks) {
                        let bookElement = document.createElement('div');
                        bookElement.innerHTML = storedBook.innerHTML;
                        bookElement.id = storedBook.code;
                        bookElement.classList.add('bookElement');
                        Object.assign(bookElement.style, storedBook.style);
                        let quantityInput = bookElement.querySelector('.Quantity');
                        if (quantityInput) {
                            let quantity = storedBook.quantity || 1;
                            quantityInput.value = quantity;

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
                if (purchaseButton) {
                    purchaseButton.setAttribute('onclick', "handlePurchaseClick()");
                purchaseButton.addEventListener('click', function() {
                    window.location.href = "ОформленняЗамовлення.php";
                });
                } else {
                console.error("Елемент не знайдено");
                }
                function handlePurchaseClick() {
                    window.location.href = "ОформленняЗамовлення.php";
                }
                let genreLinks = document.querySelectorAll('.genreLink');
                let storedGenre = localStorage.getItem('genreFilter');
                genreLinks.forEach(genreLink => {
                    genreLink.addEventListener('click', function(){
                        storedGenre = genreLink.getAttribute('genre-link');
                        localStorage.setItem('genreFilter', storedGenre);
                    });
                });

                cartWin.appendChild(purchaseButton);
                updateTotal();
                handleDeleteClick();
                changeQuantity();
                transferToBook();
            };
            cartIcon.addEventListener('click', function () {
                if (sessionStorage.getItem('CartOpen') != undefined){
                    CartOpen = sessionStorage.getItem('CartOpen');
                }
                else {
                    sessionStorage.setItem('CartOpen', 'false');
                    CartOpen = sessionStorage.getItem('CartOpen');
                }
                if (screen.width > 1000) {
                    CartOpen = sessionStorage.getItem('CartOpen');
                    if (CartOpen === 'false') {
                        cartIcon.style.right = '502px';
                        cartWin.style.right = '0px';
                        sessionStorage.setItem('CartOpen', 'true');
                    } else if (CartOpen === 'true') {
                        cartIcon.style.right = '-3px';
                        cartWin.style.right = '-502px';
                        sessionStorage.setItem('CartOpen', 'false');
                    }
                } else {
                    CartOpen = sessionStorage.getItem('CartOpen');
                    if (CartOpen === 'false') {
                        cartIcon.style.right = '350px';
                        cartWin.style.right = '0px';
                        sessionStorage.setItem('CartOpen', 'true');
                    } else if (CartOpen === 'true') {
                        cartIcon.style.right = '-3px';
                        cartWin.style.right = '-350px';
                        sessionStorage.setItem('CartOpen', 'false');
                    }
                }
            });
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
                let searchBookCovers = document.querySelectorAll('.cover');
                searchBookCovers.forEach(cover => {
                    cover.addEventListener('click', function() {
                        window.location.href = cover.getAttribute('data-loc');
                    })
                })
                const searchToggle = document.getElementById('SearchToggle');
                const searchWindow = document.getElementById('searchContainer');
                searchToggle.addEventListener('click', function() {
                    searchWindow.style.display = 'block';
                });
                const closeSearch = document.getElementById('closeSearch');
                let booksContainer = document.getElementById('booksContainer');
                let authorsContainer = document.getElementById('authorsContainer');
                let searchField = document.getElementById('searchField');
                closeSearch.addEventListener('click', function() {
                    searchField.value = "";
                    booksContainer.innerHTML = "";
                    authorsContainer.innerHTML = "";
                    searchWindow.style.display = 'none';
                })
            });
        </script>