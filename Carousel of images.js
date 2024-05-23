let index = 0;
const images = document.querySelectorAll('.carousel-img');
const dot = document.querySelectorAll('.dots');
const urls = ['', 
              'КнижковаСторінка.php?id=Дев%60ятий+Дім+Лі+Бардуґо',
              '']
images.forEach((img, i) => {
  img.addEventListener('click', () => {
      window.location.href = urls[i];
  });
});

dot.forEach((SDot, i) => {
  SDot.addEventListener('click', function() {
    dot[index].classList.remove('active');
    SDot.classList.add('active');
    index = i;
    images.forEach((img, j) => {
      img.style.transform = `translateX(${(-index) * 100}%)`;
    });
  });
});

setInterval(() => {
  dot[index].classList.remove('active');
  index = (index + 1) % images.length;
  images.forEach((img, i) => {
    img.style.transform = `translateX(${(-index) * 100}%)`;
  });
  dot[index].classList.add('active');
}, 7000);
