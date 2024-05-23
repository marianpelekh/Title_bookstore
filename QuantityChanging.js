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