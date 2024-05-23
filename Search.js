$(document).ready(function(){
    $('#searchField').on('input', function(){
        let inputValue = $(this).val();

        //Запит для динамічного пошуку
        $.ajax({
            type: 'GET',
            url: 'ServerFetchingBooks.php',
            data: { searchValue: inputValue },
            dataType: 'json',
            success: function(response){
                let booksTitle = '<h3>Книги</h3>';
                let authorsTitle = '<h3>Автори</h3>';
                $('#booksContainer').empty();
                $('#authorsContainer').empty();
                $('#booksContainer').append(booksTitle);
                $('#authorsContainer').append(authorsTitle);

                //Перевірка чи є дані
                if (response.books && response.books.length > 0) {
                    $.each(response.books, function(index, book){
                        let bookHTML = '<div class="book-container">' +
                                        '<img class="cover" data-loc="КнижковаСторінка.php?id=' + encodeURIComponent(book.Name + ' ' + book.Author) + '" src="' + book.Cover + '">' +
                                        '<div class="description">' +
                                        '<div class="book-name">' + book.Name + '</div>' +
                                        '<div class="book-author">' + book.Author + '</div>' +
                                        '<div class="price">' + book.Price + '</div>' +
                                        '</div>' +
                                        '</div>';

                        $('#booksContainer').append(bookHTML);
                    });
                } else {
                    $('#booksContainer').append('<div>Немає книг за вашим запитом.</div>');
                }

                if (response.authors && response.authors.length > 0) {
                    $.each(response.authors, function(index, author){
                        let authorHTML = '<button type="button" class="AuthorContainer" onclick="window.location.href=\'АвторськаСторінка.php?id=' + encodeURIComponent(author.AuthorName) + '\';">' + author.AuthorName + '</button>';
                        $('#authorsContainer').append(authorHTML);
                    });
                } else {
                    $('#authorsContainer').append('<div>Немає авторів за вашим запитом.</div>');
                }

                //Переходи на сторінки книг
                $('.cover').on('click', function(){
                    let location = $(this).data('loc');
                    window.location.href = location;
                });
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + status + error);
            }
        });
    });

    const searchToggle = $('#SearchToggle');
    const searchWindow = $('#searchContainer');

    searchToggle.on('click', function() {
        searchWindow.css('display', 'block');
    });

    const closeSearch = $('#closeSearch');
    closeSearch.on('click', function() {
        $('#searchField').val("");
        $('#booksContainer, #authorsContainer').empty();
        searchWindow.css('display', 'none');
    });
});
