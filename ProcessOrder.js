document.getElementById('ConfirmOrder').addEventListener('click', function(event) {
    event.preventDefault();

    // Collect user details
    let phoneNumber = document.getElementById('phoneNumber').value;
    let userMail = document.getElementById('userMail').value;
    let userName = document.getElementById('userName').value;

    // Collect delivery details
    let deliveryMethod = document.querySelector('input[name="deliveryMethod"]:checked').value;
    let deliveryTown = document.getElementById('TownPick').value;
    let deliveryAddress = document.getElementById('PostOfficePick').value;

    // Collect payment details
    let payByCard = document.querySelector('input[name="PaymentMethod"]:checked').value === 'CardPayment';
    let cardNumber = document.getElementById('CardNumber').value;

    // Collect books from local storage
    let storedBooks = JSON.parse(localStorage.getItem('books')) || [];
    let bookIds = storedBooks.map(book => ({ code: book.code, quantity: book.quantity }));
    // Отримати текстовий рядок з елементу p#totalElement
    let totalText = document.querySelector('.totalElement').textContent;

    // Знайти перше число в текстовому рядку (ціле або десяткове)
    let totalPrice = parseFloat(totalText.match(/[\d.]+/));

    // Перевірити, чи отримано правильне значення ціни
    console.log(totalPrice); // Перевірка у консолі браузера

    // Prepare data to be sent to the server
    let orderData = {
        phoneNumber: phoneNumber,
        userMail: userMail,
        userName: userName,
        deliveryMethod: deliveryMethod,
        deliveryTown: deliveryTown,
        deliveryAddress: deliveryAddress,
        payByCard: payByCard,
        cardNumber: cardNumber,
        bookIds: bookIds,
        totalPrice: totalPrice
    };

    // Send data to the server using AJAX
    $.ajax({
        url: 'process_order.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(orderData),
        success: function(response) {
            document.getElementById("MessageFromServer").textContent = "Замовлення прийнято!";
            console.log(response);
            // Optionally, redirect the user to another page or clear the cart
        },
        error: function(xhr, status, error) {
            document.getElementById("MessageFromServer").textContent = "Сталася помилка... Можете сконтактувати з нами й розробники оперативно все виправлять.";
            console.error('Order confirmation failed:', error);
        }
    });
});
