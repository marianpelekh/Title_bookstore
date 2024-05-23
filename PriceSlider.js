// JavaScript
// Get the elements
let minPrice = document.getElementById("min-price");
let maxPrice = document.getElementById("max-price");
let minPriceDisplay = document.getElementById("min-price-display");
let maxPriceDisplay = document.getElementById("max-price-display");
let sliderTrack = document.getElementById("slider-track");

// Update the slider track and the price display
function updateSlider() {
  // Get the values of the sliders
  let min = parseInt(minPrice.value);
  let max = parseInt(maxPrice.value);

  // Prevent the sliders from crossing
  if (min >= max) {
    min = max - 10;
    minPrice.value = min;
  }
  if (max <= min) {
    max = min + 10;
    maxPrice.value = max;
  }

  // Calculate the percentage of the track to fill
  let fill = (max - min) / (maxPrice.max - minPrice.min) * 100;

  // Set the background of the track
  sliderTrack.style.background = `linear-gradient(to right, lightgray 0%, lightgray ${min}%, blue ${min}%, blue ${min + fill}%, lightgray ${min + fill}%, lightgray 100%)`;

  // Set the price display
  minPriceDisplay.textContent = min;
  maxPriceDisplay.textContent = max;
}

// Add event listeners to the sliders
minPrice.addEventListener("input", updateSlider);
maxPrice.addEventListener("input", updateSlider);

// Initialize the slider
updateSlider();
