let ShowBooks = document.querySelectorAll(".ViewOrderBooks");
ShowBooks.forEach(image => {
    image.addEventListener('click', function(){
        let relatedBooks = image.parentElement.parentElement.querySelector('#OrdersList');
        if (relatedBooks) {
            relatedBooks.style.display = relatedBooks.style.display === 'none' ? 'flex' : 'none';
        }
    });
});
