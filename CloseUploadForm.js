let formItself = document.getElementById("UploadImageForm");
let background = document.getElementById("backdropShadow");
let cross = document.getElementById("closeUploadForm");
let userPic = document.getElementById('changeUserPic');
closeUploadForm.addEventListener('click', function() {
    formItself.style.display = 'none';
    background.style.display = 'none';
})
userPic.addEventListener('click', function() {
    formItself.style.display = 'grid';
    background.style.display = 'flex';
})