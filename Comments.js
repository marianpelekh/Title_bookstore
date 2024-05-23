document.addEventListener('DOMContentLoaded', (event) => {
    let comments = document.querySelectorAll('.CommentText');
    comments.forEach((comment, index) => {
        if (index % 2 == 0) {
            comment.style.backgroundColor = 'var(--mid-color)';
        } else {
            comment.style.backgroundColor = 'var(--main-color)';
        }
    });
});