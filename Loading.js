let titleElement = document.getElementById('LoaderTitle');
let loader = document.getElementById('loader');
//let progressElement = document.getElementById('progress');

let wordToType = titleElement.getAttribute('word');
let font = new FontFace('PressStart2P', 'url(PressStart2P-Regular.ttf)');

// Завантаження шрифта
font.load().then((loadedFont) => {
    document.fonts.add(loadedFont);

    // Викликати функцію печаті слова
    typeWord(0);
});

titleElement.innerText = "";

function typeWord(index) {
    loader.style.display = 'none';
    if (index < wordToType.length) {
        titleElement.innerText += (wordToType[index] !== ' ') ? wordToType[index] : '\u00A0';
        index++;
        setTimeout(function() {
            typeWord(index);
        }, 100);
    }
}


