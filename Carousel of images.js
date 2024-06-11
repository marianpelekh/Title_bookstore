const images = [
  { src: 'StandartPhoto.png', url: '' },
  { src: 'NINTH-HOUSE.jpg', url: "КнижковаСторінка.php?id=" + encodeURIComponent("Дев'ятий Дім Лі Бардуґо ІН-00002950") },
  { src: 'BSAF.jpg', url: '' },
  { src: 'https://wallpapersmug.com/download/1600x900/e9f357/high-skies-pixel-art-4k.jpg', url: '' },
  { src: 'NEW.jpg', url: '' }
];

const carousel = document.querySelector('.carousel');
const dotContainer = document.querySelector('.dot-container');

images.forEach((image, index) => {
  const imgElement = document.createElement('img');
  imgElement.classList.add('carousel-img');
  imgElement.src = image.src;
  imgElement.addEventListener('click', () => {
    if (image.url) {
      window.location.href = image.url;
    }
  });
  carousel.appendChild(imgElement);

  const dotElement = document.createElement('span');
  dotElement.classList.add('dots');
  if (index === 0) {
    dotElement.classList.add('active');
  }
  dotElement.addEventListener('click', () => {
    changeSlide(index);
  });
  dotContainer.appendChild(dotElement);
});

let index = 0;

const changeSlide = (newIndex) => {
  document.querySelectorAll('.dots')[index].classList.remove('active');
  index = newIndex;
  document.querySelectorAll('.dots')[index].classList.add('active');
  document.querySelectorAll('.carousel-img').forEach((img, i) => {
    img.style.transform = `translateX(${(-index) * 100}%)`;
  });
};

setInterval(() => {
  changeSlide((index + 1) % images.length);
}, 7000);