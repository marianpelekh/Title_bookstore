document.addEventListener('DOMContentLoaded', function () {
    let swiper = new Swiper('.swiper', {
        effect: "cards",
        grabCursor: true,
        initialSlide: 2,
        speed: 500,
        loop: true,
        mousewheel: {
            invert: false,
        },
        on: {
            slideChange: function () {
                // Get the active slide
                let activeSlide = this.slides[this.activeIndex];

                // Get the related book number from the attribute
                let relatedBook = activeSlide.getAttribute("related-book");

                // Update the information div based on the related book number
                let infoDiv = document.querySelector('.relatedInfo[related-book="' + relatedBook + '"]');
                if (infoDiv) {
                    // Hide all info divs and show the one related to the active book
                    document.querySelectorAll('.relatedInfo').forEach(function (div) {
                        div.style.display = 'none';
                    });
                    infoDiv.style.display = 'flex';
                }
            },
        },
    });
    let PriceBtns = document.querySelectorAll('#BuyButton');

    PriceBtns.forEach(function (PriceBtn) {
        let previousText = PriceBtn.textContent;
    
        PriceBtn.addEventListener('mouseover', function(){
            PriceBtn.textContent = "Придбати";
        });
    
        PriceBtn.addEventListener('mouseout', function(){
            PriceBtn.textContent = previousText;
        });
    });
    
});
