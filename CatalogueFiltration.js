let ShowAll = document.getElementById("AllBooksFilter");
let Fantasy = document.getElementById("Fantasy");
let Horrors = document.getElementById("Horrors");
let DarkAcademia = document.getElementById("DarkAcademia");
let LightAcademia = document.getElementById("LightAcademia");
let Detective = document.getElementById("Detective");
let Gothic = document.getElementById("Gothic");
let OtherProse = document.getElementById("Otherprose");
let Poetry = document.getElementById("Poetry");
let storedGenre = localStorage.getItem('storedGenreFilter');
let storedPubl = localStorage.getItem('storedPublFilter');
let applFilCont = document.getElementById('appliedFiltersContainer');

document.addEventListener('DOMContentLoaded', function() {
    if(storedGenre){
        filterBooks(storedGenre);
    }
    if (storedPubl) {
        publFilterBooks(storedPubl);
    }
    Fantasy.addEventListener('click', function() {
        filterBooks("Fantasy");
    });

    Horrors.addEventListener('click', function() {
        filterBooks("Horrors");
    });

    DarkAcademia.addEventListener('click', function() {
        filterBooks("Dark Academia");
    });

    LightAcademia.addEventListener('click', function() {
        filterBooks("Light Academia");
    });

    Detective.addEventListener('click', function() {
        filterBooks("Detective");
    });

    Gothic.addEventListener('click', function() {
        filterBooks("Gothic");
    });

    OtherProse.addEventListener('click', function() {
        filterBooks("Other prose");
    });

    Poetry.addEventListener('click', function() {
        filterBooks("Poetry");
    });

    ShowAll.addEventListener('click', function(){
        showAllBooks();
    });

    
    
    
    
    function filterBooks(selectedGenre) {
        let AllBooks = document.getElementsByClassName("book-container");

        for (let i = 0; i < AllBooks.length; i++) {
            let genre = AllBooks[i].getAttribute("data-genre");
            let publishing = AllBooks[i].getAttribute("data-publishing");
            let selectedPublishing = localStorage.getItem('storedPublFilter');
            if (selectedPublishing){
                if (genre === selectedGenre && (publishing === selectedPublishing)) {
                    AllBooks[i].style.display = "grid";
                } else {
                    AllBooks[i].style.display = "none";
                }
            } else {
                if (genre === selectedGenre) {
                    AllBooks[i].style.display = "grid";
                } else {
                    AllBooks[i].style.display = "none";
                }
            }
        }

        let filterText = document.getElementById(selectedGenre.replace(" ", "")).innerText;
        let filterId = 'applFilter';
        
        let previousFilter = document.getElementById(filterId);
        if (previousFilter) {
            applFilCont.removeChild(previousFilter);
        }
        
        let filter = document.createElement('div');
        filter.id = filterId;
        filter.innerText = filterText;
        
        applFilCont.appendChild(filter);
        localStorage.setItem('storedGenreFilter', selectedGenre);
        if (localStorage.getItem("storedGenreFilter")){
            console.log("Genre filter has been set");
        }
        genreFilterDel(filter);
        loadBooks();
    }

    function showAllBooks() {
        let AllBooks = document.getElementsByClassName("book-container");

        for (let i = 0; i < AllBooks.length; i++) {
            AllBooks[i].style.display = "grid";
        }
        if (storedGenre){
            localStorage.removeItem('genreFilter');
        }
        let GenreFilter = document.getElementById('applFilter');
        let PublFilter = document.getElementById('applFilterPubl');
        let PriceFilter = document.getElementById('applFilterPrice');
        if (GenreFilter) {
            applFilCont.removeChild(GenreFilter);
            let storageGenre = localStorage.getItem('storedGenreFilter');
            if (storageGenre) {
                localStorage.removeItem('storedGenreFilter');
            }
        }
        if (PublFilter) {
            applFilCont.removeChild(PublFilter);
            let storagePubl = localStorage.getItem('storedPublFilter');
            if (storagePubl) {
                localStorage.removeItem('storedPublFilter');
            }
        }
        if (PriceFilter) {
            applFilCont.removeChild(PriceFilter);
            let priceMin = document.querySelector('.noUi-handle-lower');
            let priceMax = document.querySelector('.noUi-handle-upper');
            priceMin.setAttribute('aria-valuenow', priceMin.getAttribute('aria-valuemin'));
            priceMax.setAttribute('aria-valuenow', priceMax.getAttribute('aria-valuemax'));
            priceMin.parentElement.style.transform = 'translate(-100%, 0px)';
            priceMax.parentElement.style.transform = 'translate(0%, 0px)';
            let connection = document.querySelector('.noUi-connect');
            connection.style.transform = 'translate(0%, 0px) scale(1, 1);';
        }
    }

    let links = document.querySelectorAll('#publishFilter a');
    links.forEach(link => {
        link.addEventListener('click', function() {
            let publ = link.getAttribute('data-publishing');
            publFilterBooks(publ);
        })
    })
    function publFilterBooks(publishing){
        let AllBooks = document.getElementsByClassName("book-container");
        for (let i = 0; i < AllBooks.length; i++) {
            let bookGenre = AllBooks[i].getAttribute("data-genre");
            let bookPubl = AllBooks[i].getAttribute("data-publishing");
            let storedGenre = localStorage.getItem('storedGenreFilter');

            if (storedGenre) {
                if ((bookPubl === publishing) && (bookGenre === storedGenre)) {
                    AllBooks[i].style.display = 'grid';
                } else {
                    AllBooks[i].style.display = 'none';
                }
            } else {
                if (bookPubl === publishing) {
                    AllBooks[i].style.display = 'grid';
                } else {
                    AllBooks[i].style.display = 'none';
                }
            }

        }
        let filterText = document.getElementById(publishing.replace(" ", "")).innerText;
        let filterId = 'applFilterPubl';
        
        let previousFilter = document.getElementById(filterId);
        if (previousFilter) {
            applFilCont.removeChild(previousFilter);
        }
        
        let filter = document.createElement('div');
        filter.id = filterId;
        filter.innerText = filterText;
        
        applFilCont.appendChild(filter);
        localStorage.setItem('storedPublFilter', publishing);
        publFilterDel(filter);
        loadBooks();
    }

    let asideToggle = document.getElementById('aside-toggle');
    let aside = document.querySelector('aside');
    
    asideToggle.addEventListener('click', function () {
        let asideOpen = sessionStorage.getItem('asideOpen');
        if (asideOpen !== 'true') {
            openAside();
            console.log('Open aside');
            CloseCart('true');
        } else {
            closeAside();
        }
    });
    
    if (window.innerWidth < 1000) {
        let asideLinks = document.querySelectorAll('a');
        asideLinks.forEach(link => {
            link.addEventListener('click', function () {
                closeAside();
            });
        });
        
        document.addEventListener('click', function (event) {
            if (!aside.contains(event.target) && event.target !== asideToggle) {
                closeAside();
            }
        });
    }
    
    function openAside() {
        aside.style.marginLeft = '10px';
        asideToggle.style.left = '261.5px';
        sessionStorage.setItem('asideOpen', 'true');
    }
    
    function closeAside() {
        aside.style.marginLeft = '-260px';
        asideToggle.style.left = '-3px';
        sessionStorage.setItem('asideOpen', 'false');
    }

    function genreFilterDel(genreFilter) {
        if (genreFilter){
            genreFilter.addEventListener('click', function(){
                console.log("Genre filter");
                applFilCont.removeChild(genreFilter);
                let storageGenre = localStorage.getItem('storedGenreFilter');
                if (storageGenre) {
                    localStorage.removeItem('storedGenreFilter');
                }      
                location.reload(true);
            })
        }
    }
    function publFilterDel(publFilter) {
        if (publFilter) {
            publFilter.addEventListener('click', function(){
                console.log("Publ filter");
                applFilCont.removeChild(publFilter);
                let storagePubl = localStorage.getItem('storedPublFilter');
                if (storagePubl) {
                    localStorage.removeItem('storedPublFilter');
                }
                location.reload(true);
            })
        }
    }
});
