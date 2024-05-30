// найти всі елементи з класом 'book-container'
    let booksDiscountBlocks = document.getElementsByClassName('book-container');
    // Пройтися по всіх елементах
    for (let i = 0; i < booksDiscountBlocks.length; i++) {
        // Знайти всі посилання всередині поточного елемента 'book-container'
        let links = booksDiscountBlocks[i].getElementsByTagName('a');
        let bookPrice = booksDiscountBlocks[i].getElementsByClassName('price')[0];
        // Пройтися по всіх посиланнях
        for (let j = 0; j < links.length; j++) {
            // Перевірити, чи посилання не має класу 'buy'
            if (!links[j].classList.contains('buy')) {
                // Отримати href атрибут посилання
                let href = links[j].getAttribute('href');
                // Знайти значення параметра 'id'
                let url = new URL(href, window.location.origin); // Створити URL об'єкт
                let id = url.searchParams.get('id'); // Отримати параметр 'id'
                // Розділити параметр 'id' і взяти останню частину
                let idParts = id.split(' ');
                let bookId = idParts[idParts.length - 1];
                console.log('Book discount ID:', bookId);
                sendRequest(bookId, bookPrice);
            }
        }
    }
    let buyButtons = document.querySelectorAll('#BuyButton');
    for (let i = 0; i < buyButtons.length; i++) {
        let href = buyButtons[i].getAttribute('href');
        let url = new URL(href, window.location.origin);
        let id = url.searchParams.get('id');
        let idParts = id.split(' ');
        let bookId = idParts[idParts.length - 1];
        sendRequest(bookId, buyButtons[i]);
    }
    
    function sendRequest(bookId, bookPrice) {
        $.ajax({
            url: 'load_discounts.php',
            method: 'GET',
            data: {
                bookId: bookId
            },
            success: function(data) {
                bookPrice.innerHTML = data;
            }
        })
    }