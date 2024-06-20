document.getElementById('ConfirmOrder').addEventListener('click', function(event) {
    event.preventDefault();

    let phoneNumber = document.getElementById('phoneNumber').value;
    let userMail = document.getElementById('userMail').value;
    let userName = document.getElementById('userName').value;

    let deliveryMethod = document.querySelector('input[name="deliveryMethod"]:checked').value;
    let deliveryTown = document.getElementById('TownPick').value;
    let deliveryAddress = document.getElementById('PostOfficePick').value;

    let payByCard = document.querySelector('input[name="PaymentMethod"]:checked').value === 'CardPayment';
    let cardNumber = document.getElementById('CardNumber').value;

    let storedBooks = JSON.parse(localStorage.getItem('books')) || [];
    let bookIds = storedBooks.map(book => ({ code: book.code, quantity: book.quantity }));
    let totalText = document.querySelector('.totalElement').textContent;

    let totalPrice = parseFloat(totalText.match(/[\d.]+/));

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

    $.ajax({
        url: 'process_order.php',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(orderData),
        success: function(response) {
            document.getElementById('ConfirmOrder').style.display = 'none';
            document.getElementById("MessageFromServer").innerText = "Замовлення прийнято!";
            console.log(response);
            localStorage.removeItem('books');
        },
        error: function(xhr, status, error) {
            document.getElementById("MessageFromServer").textContent = "Сталася помилка... Можете сконтактувати з нами й розробники оперативно все виправлять.";
            console.error('Order confirmation failed:', error);
        }
    });
});
