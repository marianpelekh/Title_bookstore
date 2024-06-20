const Right = document.querySelector('.NewsArrows > #RightArrow');
const Left = document.querySelector('.NewsArrows > #LeftArrow');
const List = document.getElementById('NewBooksMain');

Right.addEventListener('click', function(){
    const firstItem = List.firstElementChild;
    List.appendChild(firstItem);
})

Left.addEventListener('click', function(){
    const lastItem = List.lastElementChild;
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