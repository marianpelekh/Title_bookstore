let section = document.getElementById('cabinetSection');
let baseBookCodeSelect = document.querySelector("#baseBookCodeSelect");
let baseGenreSelect = document.querySelector("#baseBookGenreSelect");
let baseAuthorSelect = document.querySelector('#baseAuthorSelect'); 

let adminFormsTitle = document.createElement('h3');
adminFormsTitle.id = "AdminFormsTitle";
adminFormsTitle.textContent = "Форми для адмініструванння сайту";


section.appendChild(adminFormsTitle);

function createTab(id, href, text, isActive = false) {
    let tab = document.createElement('a');
    tab.id = id;
    tab.href = href;
    tab.textContent = text;
    if (isActive) {
        tab.classList.add('active');
    }
    return tab;
}

function createForm(id, action, method, formName) {
    let form = document.createElement('form');
    form.id = id;
    form.setAttribute('action', action);
    form.setAttribute('method', method);
    let name = document.createElement('h4');
    name.textContent = formName;
    form.appendChild(name);
    return form;
}

function createInput(placeholder, type, name, max) {
    let input = document.createElement('input');
    input.setAttribute('placeholder', placeholder);
    input.setAttribute('type', type);
    input.setAttribute('name', name);
    if (max !== 0) {
        input.setAttribute('max', max);
    }
    if (name == 'InSeriesNumber') {
        input.setAttribute('step', '0.1');
    }
    return input;
}
function createInputWV(placeholder, type, name, max, value) {
    let input = document.createElement('input');
    input.setAttribute('placeholder', placeholder);
    input.setAttribute('type', type);
    input.setAttribute('name', name);
    if (max !== 0) {
        input.setAttribute('max', max);
    }
    if (name == 'InSeriesNumber') {
        input.setAttribute('step', '0.1');
    }
    input.value = value;
    return input;
}
function createNewSelect(basedOn, newId, newName) {
    console.log('Select: ', basedOn, newId, newName);
    let select;
    if (basedOn === 'BookCode') {
        select = baseBookCodeSelect.cloneNode(true);
    } else if (basedOn === 'BookGenre') {
        select = baseGenreSelect.cloneNode(true);
    } else if (basedOn === 'Author') {
        select = baseAuthorSelect.cloneNode(true);
    }
    if (select) {
        select.style.display = 'block';
        select.id = newId;
        select.setAttribute('name', newName);
        return select;
    }
}

function createNewSelectWV(basedOn, newId, newName, value) {
    let select;
    if (basedOn === 'BookGenre') {
        select = baseGenreSelect.cloneNode(true);
    }
    if (select) {
        select.id = newId;
        select.setAttribute('name', newName);
        let options = select.querySelectorAll("option");
        options.forEach(option => {
            if (option.value === value) {
                option.selected = true;
            }
        });
        select.style.display = 'block';
        return select;
    }
}
function createButton(name, innerText) {
    let button = document.createElement('button');
    button.setAttribute('name', name);
    button.innerText = innerText;
    return button;
}
function createTextarea(placeholder, name) {
    let textarea = document.createElement('textarea');
    textarea.setAttribute('placeholder', placeholder);
    textarea.setAttribute('name', name);
    return textarea;
}
function createTextareaWV(placeholder, name, value) {
    let textarea = document.createElement('textarea');
    textarea.setAttribute('placeholder', placeholder);
    textarea.setAttribute('name', name);
    textarea.innerHTML = value;
    return textarea;
}
function getBooksByCode(code) {
    console.log('Обрана книга:', code);
    $.ajax({
        url: 'get_book_by_code.php',
        method: 'GET',
        data: { bookCode: code },
        success: function(response) {
            let bookInfo = JSON.parse(response);
            let editBookForm = document.getElementById('editBookForm');
            let select = editBookForm.querySelector('select');
            editBookForm.innerHTML = '';
            editBookForm.appendChild(select);
            editBookForm.appendChild(createInputWV('Коротка назва', 'text', 'EditShortName', 0, bookInfo.ShortName));
            editBookForm.appendChild(createInputWV('Код книги', 'text', 'EditBookCode', 0, bookInfo.BookID));
            editBookForm.appendChild(createInputWV('Повна назва', 'text', 'EditFullName', 0, bookInfo.Name));
            editBookForm.appendChild(createInputWV('Автор', 'text', 'EditAuthor', 0, bookInfo.Author));
            editBookForm.appendChild(createInputWV('Видавництво', 'text', 'EditPublishing', 0, bookInfo.Publishing));
            editBookForm.appendChild(createInputWV('Ціна', 'number', 'EditPrice', 0, bookInfo.Price));
            editBookForm.appendChild(createInputWV('Посилання на обкладинку (перед)', 'text', 'EditCoverURL', 0, bookInfo.FrontCover));
            editBookForm.appendChild(createInputWV('Посилання на обкладинку (тил)', 'text', 'EditRearCoverURL', 0, bookInfo.BackCover));
            editBookForm.appendChild(createInputWV('Кількість сторінок', 'number', 'EditPageNumber', 0, bookInfo.PagesNumber));
            editBookForm.appendChild(createInputWV('Мова', 'text', 'EditLanguage', 0, bookInfo.Language));
            editBookForm.appendChild(createInputWV('Дата виходу', 'date', 'EditExactPublishingDate', 0, bookInfo.DateExact));
            editBookForm.appendChild(createTextareaWV('Анотація', 'EditAnnotation', bookInfo.Description));
            editBookForm.appendChild(createNewSelectWV('BookGenre', 'editBookGenreSelect', 'EditGenre', bookInfo.Genre));
            editBookForm.appendChild(createInputWV('Назва серії', 'text', 'EditSeriesName', 0, bookInfo.SeriesName));
            editBookForm.appendChild(createInputWV('Номер в серії', 'number', 'EditInSeriesNumber', 0, bookInfo.NumberInSeries));
            editBookForm.appendChild(createButton('editBtn', 'Редагувати книгу'));
        }
    })
}
function getAuthorByCode(code) {
    console.log('Обраний автор:', code);
    $.ajax({
        url: 'get_author_by_id.php',
        method: 'GET',
        data: { authorId: code },
        success: function(response) {
            let authorInfo = JSON.parse(response);
            let editAuthorForm = document.getElementById('editAuthorForm');
            let select = editAuthorForm.querySelector('select');
            editAuthorForm.innerHTML = '';
            editAuthorForm.appendChild(select);
            editAuthorForm.appendChild(createInputWV("Ім'я автора", 'text', 'editAuthorName', 0, authorInfo.AuthorName));
            editAuthorForm.appendChild(createInputWV("Рік народження", 'number', "editAuthorBirth", new Date().getFullYear(), authorInfo.Birth));
            editAuthorForm.appendChild(createInputWV("Рік смерті", 'number', "editAuthorDeath", new Date().getFullYear(), authorInfo.Death));
            editAuthorForm.appendChild(createInputWV('URL посилання на фото автора', 'text', 'editAuthorPic', 0, authorInfo.Picture));
            editAuthorForm.appendChild(createTextareaWV('Біографія автора', 'editAuthorBiography', authorInfo.Biography));
            editAuthorForm.appendChild(createButton('editAuthor', 'Редагувати автора'));
        }
    })
}
let formsTabs = document.createElement('div');
formsTabs.id = 'formsTabs';

let booksAdminFormsA = createTab('booksAdminFormsA', '#booksAdminForms', 'Книги та знижки', true);
let authorsAdminFormsA = createTab('authorsAdminFormsA', '#authorsAdminForms', 'Автори');
let publishersAdminFormsA = createTab('publishersAdminFormsA', '#publishersAdminForms', 'Видавництва');
let commentsAdminFormsA = createTab('commentsAdminFormsA', '#commentsAdminForms', 'Коментарі');
let ordersAdminFormsA = createTab('ordersAdminFormsA', '#ordersAdminForms', 'Замовлення');

formsTabs.appendChild(booksAdminFormsA);
formsTabs.appendChild(authorsAdminFormsA);
formsTabs.appendChild(publishersAdminFormsA);
formsTabs.appendChild(commentsAdminFormsA);
formsTabs.appendChild(ordersAdminFormsA);

section.appendChild(formsTabs);

//ФОРМИ


let adminFormsDiv = document.createElement('div');
adminFormsDiv.id = "adminFormsDiv";
section.appendChild(adminFormsDiv);


//КНИЖКОВІ ФОРМИ
let booksAdminForms = document.createElement('div');
booksAdminForms.id = 'booksAdminForms';
booksAdminForms.classList.add('adminFormContent');

section.appendChild(booksAdminForms);

//ФОРМА НА ДОДАВАННЯ ЗНИЖОК

let addDiscountForm = createForm('addDiscountForm', 'add_discounts.php', 'POST', 'Додати знижку на книгу');

addDiscountForm.appendChild(createNewSelect('BookCode', 'discountBookId', 'discountBookId'));
addDiscountForm.appendChild(createInput("Відсоток знижки", 'text', 'discountValue', 0));

let expirationInput = document.createElement('div');
expirationInput.id = 'expirationInput';
let expirationLabel = document.createElement('p');
expirationLabel.textContent = "Дата закінчення знижки:";
let expirationDateInput = createInput("Оберіть дату", 'date', 'expirationDate', 0);
expirationInput.appendChild(expirationLabel);
expirationInput.appendChild(expirationDateInput);
addDiscountForm.appendChild(expirationInput);

addDiscountForm.appendChild(createButton('setDiscount', 'Додати знижку'));


booksAdminForms.appendChild(addDiscountForm);

//ФОРМА ДЛЯ ДОДАВАННЯ КНИГ

let addBookForm = createForm('addBookForm', 'booksAdminForms.php', 'POST', 'Додати книгу');
addBookForm.appendChild(createInput('Коротка назва', 'text', 'ShortName', 0));
addBookForm.appendChild(createInput('Код книги', 'text', 'BookCode', 0));
addBookForm.appendChild(createInput('Повна назва', 'text', 'FullName', 0));
addBookForm.appendChild(createInput('Автор', 'text', 'Author', 0));
addBookForm.appendChild(createInput('Видавництво', 'text', 'Publishing', 0));
addBookForm.appendChild(createInput('Ціна', 'number', 'Price', 0));
addBookForm.appendChild(createInput('Посилання на обкладинку (перед)', 'text', 'CoverURL', 0));
addBookForm.appendChild(createInput('Посилання на обкладинку (тил)', 'text', 'RearCoverURL', 0));
addBookForm.appendChild(createInput('Кількість сторінок', 'number', 'PageNumber', 0));
addBookForm.appendChild(createInput('Мова', 'text', 'Language', 0));
addBookForm.appendChild(createInput('Дата виходу', 'date', 'ExactPublishingDate', 0));
addBookForm.appendChild(createTextarea('Анотація', 'Annotation'));
addBookForm.appendChild(createNewSelect('BookGenre', 'addBookGenreSelect', 'Genre'));
addBookForm.appendChild(createInput('Назва серії', 'text', 'SeriesName', 0));
addBookForm.appendChild(createInput('Номер в серії', 'number', 'InSeriesNumber', 0));
addBookForm.appendChild(createButton('addBtn', 'Додати книгу'));

booksAdminForms.appendChild(addBookForm);

//ФОРМА ДЛЯ РЕДАГУВАННЯ КНИГ

let editBookSelect = createNewSelect('BookCode', "editBookSelect", 'bookCodeEdit');
editBookSelect.onchange = function() {
    getBooksByCode(editBookSelect.value);
};
let editBookForm = createForm('editBookForm', 'booksAdminForms.php', 'POST', 'Редагувати книгу');
editBookForm.appendChild(editBookSelect);
booksAdminForms.appendChild(editBookForm);

//ФОРМА ДЛЯ ВИДАЛЕННЯ КНИГ

let deleteBookForm = createForm('deleteBookForm', 'booksAdminForms.php', 'POST', 'Видалити книгу');
deleteBookForm.appendChild(createNewSelect('BookCode', 'deleteBookSelect', 'deleteBook'));
deleteBookForm.appendChild(createButton('deleteBook', 'Видалити книгу'));
booksAdminForms.appendChild(deleteBookForm);

adminFormsDiv.appendChild(booksAdminForms);







//АВТОРСЬКІ ФОРМИ

let authorsForms = document.createElement('div');
authorsForms.id = 'authorsAdminForms';
authorsForms.classList.add('adminFormContent');

//ФОРМА ДОДАВАННЯ АВТОРА

let addAuthorForm = createForm('addAuthorForm', 'authorAdminForms.php', 'POST', 'Додати автора');

addAuthorForm.appendChild(createInput("Ім'я автора", 'text', 'AuthorName', 0));
addAuthorForm.appendChild(createInput("Рік народження", 'number', "AuthorBirth", new Date().getFullYear()));
addAuthorForm.appendChild(createInput("Рік смерті", 'number', "AuthorDeath", new Date().getFullYear()));
addAuthorForm.appendChild(createInput('URL посилання на фото автора', 'text', 'AuthorPic', 0));
addAuthorForm.appendChild(createTextarea('Біографія автора', 'AuthorBiography'));
addAuthorForm.appendChild(createButton('AddAuthor', 'Додати автора'));

authorsForms.appendChild(addAuthorForm);

//ФОРМА НА РЕДАГУВАННЯ АВТОРА

let editAuthorSelect = createNewSelect('Author', "editAuthorSelect", "editAuthorSelect");
editAuthorSelect.onchange = function() {
    getAuthorByCode(editAuthorSelect.value);
};
let editAuthorForm = createForm('editAuthorForm', 'authorAdminForms.php', 'POST', 'Редагувати автора');

editAuthorForm.appendChild(editAuthorSelect);

authorsForms.appendChild(editAuthorForm);

//ФОРМА ДЛЯ ВИДАЛЕННЯ АВТОРА

let deleteAuthorSelect = createNewSelect('Author', 'deleteAuthorSelect', "deleteAuthorSelect");
let deleteAuthorForm = createForm('deleteAuthorForm', 'authorAdminForms.php', 'POST', 'Видалити автора');
deleteAuthorForm.appendChild(deleteAuthorSelect);
deleteAuthorForm.appendChild(createButton('deleteAuthor', 'Видалити'))
authorsForms.appendChild(deleteAuthorForm);


adminFormsDiv.appendChild(authorsForms);





//СВАЙПЕР

let adminTabs = document.querySelectorAll('#formsTabs a');
adminTabs.forEach((tab, index) => {
  tab.addEventListener('click', (e) => {
    console.log(adminFormsDiv.style.transform);
    e.preventDefault();
    adminTabs.forEach(t => t.classList.remove('active'));
    tab.classList.add('active');
    const translateWidth = -index * 100;
    adminFormsDiv.style.transform = `translateX(${translateWidth}vw)`;
  });
});