let ShowBooks = document.querySelectorAll(".ViewOrderBooks");
document.addEventListener('DOMContentLoaded', function() {
    ShowBooks.forEach(image => {
        image.addEventListener('click', function(){
            let relatedBooks = image.parentElement.parentElement.querySelector('#OrdersList');
            if (relatedBooks) {
                relatedBooks.style.height = relatedBooks.style.height === '0px' ? '310px' : '0px';
            }
            if (window.innerWidth < 1000) {
                let orderContainer = image.parentElement.parentElement;
                if (orderContainer) {
                    orderContainer.style.gridTemplateRows = orderContainer.style.gridTemplateRows === '5vh 5vh 0px' ? '5vh 5vh 300px' : '5vh 5vh 0px';
                    orderContainer.style.height = orderContainer.style.height === '10vh' ? 'calc(10vh + 330px)' : '10vh';
                }
            }
        });
    });
})
