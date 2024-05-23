const arrow = document.getElementById('arrowDown');
let desc = document.getElementById('descriptionCont');
let grad = document.getElementById('gradient');
let isOpen = false;
let autoHeight; // variable to store the height when it's 'auto'

arrow.addEventListener('click', function(){
    if (isOpen == false){
        desc.style.height = 'auto';
        autoHeight = desc.scrollHeight + 'px'; // store the height
        desc.style.height = ''; // reset the height
        getComputedStyle(desc).height; // force repaint
        desc.style.transition = 'height 0.5s ease';
        desc.style.height = autoHeight; // animate to the auto height
        arrow.style.transform = 'rotate(180deg)';
        grad.style.opacity = '0';
        isOpen = true;
    }
    else if (isOpen == true){
        desc.style.transition = 'height 0.5s ease';
        desc.style.height = '100px';
        arrow.style.transform = 'rotate(0deg)';
        isOpen = false;
        grad.style.opacity = '1';
    }
})
