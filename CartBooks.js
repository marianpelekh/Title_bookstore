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

function transferToBook() {
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
                if (cartWin.contains(bookElement)) {
                    cartWin.removeChild(bookElement);
                }                
                localStorage.setItem('books', JSON.stringify(storedBooks));
                updateTotal();
            })
        });
    });
}

function changeQuantity() {
    const bookElements = document.querySelectorAll('.bookElement');
    bookElements.forEach(bookElement => {
        const decreaseButtons = bookElement.querySelectorAll(".DecreaseQuantity");
        const increaseButtons = bookElement.querySelectorAll(".IncreaseQuantity");

        decreaseButtons.forEach(decreaseButton => {
            if (!decreaseButton.onclick){
            decreaseButton.addEventListener('click', function () {
                DecreaseQuantity(bookElement);
            });
        }
        });

        increaseButtons.forEach(increaseButton => {
            if (!increaseButton.onclick){
            increaseButton.addEventListener('click', function () {
                IncreaseQuantity(bookElement);
            });
        }
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
    console.log('Redirecting...');
    window.location.href = "ОформленняЗамовлення.php";
}