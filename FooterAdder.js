const footer = document.querySelector('footer');

const footTitle = document.createElement('h1');
footTitle.id = 'foot-title';
footTitle.textContent = 'Title';
footer.appendChild(footTitle);

const catalogFooter = document.createElement('span');
catalogFooter.id = 'catalog-footer';
footer.appendChild(catalogFooter);

const catalogLinks = [
    { id: 'FootCatalog', href: 'Каталог.php', text: 'Каталог', tag: 'h2', className: '' },
    { href: 'Каталог.php', text: 'Фентезі', tag: 'a', className: 'genreLink', genre: 'Fantasy' },
    { href: 'Каталог.php', text: 'Горрори | Трилери', tag: 'a', className: 'genreLink', genre: 'Horrors' },
    { href: 'Каталог.php', text: 'Dark academia', tag: 'a', className: 'genreLink', genre: 'DarkAcademia' },
    { href: 'Каталог.php', text: 'Light academia', tag: 'a', className: 'genreLink', genre: 'LightAcademia' },
    { href: 'Каталог.php', text: 'Детективи', tag: 'a', className: 'genreLink', genre: 'Detective' },
    { href: 'Каталог.php', text: 'Готика', tag: 'a', className: 'genreLink', genre: 'Gothic' },
    { href: 'Каталог.php', text: 'Інша проза', tag: 'a', className: 'genreLink', genre: 'OtherProse' },
    { href: 'Каталог.php', text: 'Поезія', tag: 'a', className: 'genreLink', genre: 'Poetry' }
];

catalogLinks.forEach(link => {
    const element = document.createElement(link.tag);
    if (link.id) element.id = link.id;
    if (link.className) element.className = link.className;
    if (link.href) element.href = link.href;
    if (link.genre) element.setAttribute('genre-link', link.genre);
    element.textContent = link.text;
    if (link.tag === 'h2') {
        const a = document.createElement('a');
        a.href = link.href;
        a.appendChild(element);
        catalogFooter.appendChild(a);
    } else {
        catalogFooter.appendChild(element);
    }
});

const otherFooterInfo = document.createElement('span');
otherFooterInfo.id = 'other-footer-info';
footer.appendChild(otherFooterInfo);

const otherLinks = [
    { id: 'FootAuthors', href: 'Автори.php', text: 'Автори', tag: 'h2' },
    { id: 'FootNews', href: 'Новинки.php', text: 'Новинки', tag: 'h2' },
    { id: 'FootContacts', href: 'Контакти.php', text: 'Контакти', tag: 'h2' },
    { href: '', text: '@titlebookstore', tag: 'a' },
    { href: 'mailto:title@contact.com', text: 'title@contact.com', tag: 'a' },
    { href: '', text: '+380XXXXXXXXX', tag: 'a' }
];

otherLinks.forEach(link => {
    const element = document.createElement(link.tag);
    if (link.id) element.id = link.id;
    if (link.href) element.href = link.href;
    element.textContent = link.text;
    if (link.tag === 'h2') {
        const a = document.createElement('a');
        a.href = link.href;
        a.appendChild(element);
        otherFooterInfo.appendChild(a);
    } else {
        otherFooterInfo.appendChild(element);
    }
});