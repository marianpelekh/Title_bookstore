window.onload = function() {
    const cookieAlert = document.createElement('div');
    cookieAlert.classList.add('Cookie');

    const cookieText = document.createElement('div');
    cookieText.id = 'CookieText';
    cookieAlert.appendChild(cookieText);

    const cookieTitle = document.createElement('h3');
    cookieTitle.textContent = 'Використовувати файли-cookie?';
    cookieText.appendChild(cookieTitle);

    const cookieDesc = document.createElement('p');
    cookieDesc.textContent = 'Це дозволить зберігати вашу корзину при виході з сайту та забезпечить автоматичний вхід наступного разу.';
    cookieText.appendChild(cookieDesc);

    const buttonVariants = document.createElement('div');
    buttonVariants.classList.add('ButtonVariants');
    cookieAlert.appendChild(buttonVariants);

    const cookieYes = document.createElement('button');
    cookieYes.id = 'CookieYes';
    cookieYes.textContent = 'Так';
    buttonVariants.appendChild(cookieYes);

    const cookieNecessary = document.createElement('button');
    cookieNecessary.id = 'CookieNecessary';
    cookieNecessary.textContent = 'Лише необхідні';
    buttonVariants.appendChild(cookieNecessary);

    const cookieNo = document.createElement('button');
    cookieNo.id = 'CookieNo';
    cookieNo.textContent = 'Ні';
    buttonVariants.appendChild(cookieNo);
    let cookieNothing = sessionStorage.getItem("CookieNo");
    document.body.appendChild(cookieAlert);
    let cookieON = getCookie('cookieOn');
    let cookieNEC = getCookie('cookieNEC');
    if (cookieON == 'true' || cookieNEC == 'true' || cookieNothing == 'false'){
        cookieAlert.style.display = 'none';
    }
    else if (cookieON == null && cookieNEC == null){
        cookieAlert.style.display = 'block';
    }
    else {
        sessionStorage.setItem("CookieNo", "true");
    }

cookieYes.addEventListener('click', function(){
    setCookie('cookieOn', 'true', 365);
    setCookie('cookieNEC', 'false', 365);
    cookieAlert.style.display = 'none';
})

cookieNo.addEventListener('click', function(){
    setCookie('cookieOn', 'false', 365);
    setCookie('cookieNEC', 'false', 365);
    cookieAlert.style.display = 'none';
})

cookieNecessary.addEventListener('click', function(){
    setCookie('cookieOn', 'false', 365);
    setCookie('cookieNEC', 'true', 365);
    cookieAlert.style.display = 'none';
})

function setCookie(name, value, days) {
    let date = new Date();
    date.setTime(date.getTime() + (days*24*60*60*1000));
    let expires = "expires="+ date.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

function getCookie(name) {
    let nameEQ = name + "=";
    let ca = document.cookie.split(';');
    for(let i=0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
}