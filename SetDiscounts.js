let booksDiscountBlocks = document.querySelectorAll('.book-container');
booksDiscountBlocks.forEach((bookContainer) => {
    let links = bookContainer.querySelectorAll('a');
    let bookPrice = bookContainer.querySelector('.price');
    
    links.forEach((link) => {
        if (!link.classList.contains('buy')) {
            let href = link.getAttribute('href');
            let url = new URL(href, window.location.origin);
            let id = url.searchParams.get('id');
            if (id) {
                let idParts = id.split(' ');
                let bookId = idParts[idParts.length - 1];
                sendRequest(bookId, 1, bookPrice);
            }
        }
    });
});

let buyButtons = document.querySelectorAll('#BuyButton');
buyButtons.forEach((button) => {
    let href = button.getAttribute('href');
    let url = new URL(href, window.location.origin);
    let id = url.searchParams.get('id');
    if (id) {
        let idParts = id.split(' ');
        let bookId = idParts[idParts.length - 1];
        sendRequest(bookId, 1, button);
    }
});

//Функція для надсилання запитів
function sendRequest(bookId, quantity, element) {
    $.ajax({
        url: 'load_discounts.php',
        method: 'GET',
        data: { 
            bookId: bookId, 
            quantity: quantity 
        },
        success: function(data) {
            element.innerHTML = data;
        }
    });
}
