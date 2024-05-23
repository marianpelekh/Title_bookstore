document.addEventListener("DOMContentLoaded", function() {
    var textElement = document.getElementById('BookDesc');
    var gradientElement = textElement.cloneNode(true);
    gradientElement.id = ''; // Remove ID to prevent duplicates

    textElement.parentNode.insertBefore(gradientElement, textElement.nextSibling);

    var computedStyle = window.getComputedStyle(textElement);
    var bgColor = computedStyle.getPropertyValue('color');

    gradientElement.style.background = 'linear-gradient(to bottom, ' + bgColor + ' 0%, ' + bgColor + ' 100%)';
});
