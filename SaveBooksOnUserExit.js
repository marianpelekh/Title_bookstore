function sendLocalStorageData() {
    let books = JSON.parse(localStorage.getItem('books'));
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_stored_books.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log("Books are saved.");
            window.location.href = 'Кабінет.php';
        } else {
            console.error("Error saving books:", xhr.responseText);
        }
    };
    xhr.send('books=' + encodeURIComponent(JSON.stringify(books)));
}
