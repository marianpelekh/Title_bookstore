const Right = document.getElementById('RightArrow');
const Left = document.getElementById('LeftArrow');
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