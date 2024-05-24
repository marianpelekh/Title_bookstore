localStorage.setItem('books', JSON.stringify(storedBooks));

let storedB = JSON.parse(localStorage.getItem("books"));
let xhr = new XMLHttpRequest();
xhr.open('POST', 'update_stored_books.php', true);
xhr.setRequestHeader('Content-Type', 'application/json');
xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
        console.log(xhr.responseText);
    }
};
xhr.send(JSON.stringify({books: storedB}));