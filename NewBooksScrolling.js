const Right = document.querySelector('.NewsArrows > #RightArrow');
const Left = document.querySelector('.NewsArrows > #LeftArrow');
const List = document.getElementById('NewBooksMain');

Right.addEventListener('click', function(){
    // Беремо перший елемент у списку
    const firstItem = List.firstElementChild;
    // Переміщаємо перший елемент в кінець списку
    List.appendChild(firstItem);
})

Left.addEventListener('click', function(){
    // Беремо останній елемент у списку
    const lastItem = List.lastElementChild;
    // Переміщаємо останній елемент на початок списку
    List.prepend(lastItem);
})

const RightDiscs = document.querySelector('.DiscsArrows > #RightArrow');
const LeftDiscs = document.querySelector('.DiscsArrows > #LeftArrow');
const DiscsList = document.getElementById("DiscountsBooksMain");

RightDiscs.addEventListener("click", function() {
    const firstItem = DiscsList.firstElementChild;
    DiscsList.appendChild(firstItem);
})
LeftDiscs.addEventListener("click", function() {
    const lastItem = DiscsList.lastElementChild;
    DiscsList.prepend(lastItem);
})

const RightPresales = document.querySelector('.PresalesArrows > #RightArrow');
const LeftPresales = document.querySelector('.PresalesArrows > #LeftArrow');
const PresalesList = document.getElementById('PresalesMain');

RightPresales.addEventListener("click", function() {
    const firstItem = PresalesList.firstElementChild;
    PresalesList.appendChild(firstItem);
})
LeftPresales.addEventListener("click", function() {
    const lastItem = PresalesList.lastElementChild;
    PresalesList.prepend(lastItem);
})