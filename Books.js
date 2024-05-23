const covers = document.querySelectorAll('.cover');
const buys = document.querySelectorAll('.buy');
const bookContainers = document.querySelectorAll('.book-container');

bookContainers.forEach((container) => {
    const cover = container.querySelector('.cover');
    const buy = container.querySelector('.buy');

    cover.style.transition = 'all 0.3s ease';

    container.addEventListener('mouseover', function () {
        buy.style.display = 'block';
        cover.style.opacity = '0.5';
    });

    container.addEventListener('mouseout', function () {
        buy.style.display = 'none';
        cover.style.opacity = '1';
    });

    buy.addEventListener('mouseover', function () {
        buy.style.display = 'block';
        cover.style.opacity = '0.5';
        buy.style.cursor = 'pointer';
    });

    buy.addEventListener('mouseout', function () {
        buy.style.display = 'none';
        cover.style.opacity = '1';
    });
});
