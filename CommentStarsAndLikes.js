$('.LikeComment').click(function() {
    let commentId = $(this).closest('.Comment').data('comment-id');
    let likeCountElem = $(this).siblings('.likeCount');
    $.ajax({
        url: 'like_comment.php',
        type: 'POST',
        data: { commentId: commentId },
        success: function(response) {
            likeCountElem.innerText = response.likes;
        }
    });
});
let comments = document.querySelectorAll('.Comment');
comments.forEach(comment => {
    let like = comment.querySelector('.likeCount');
    let id = comment.getAttribute('data-comment-id');
    $.ajax({
        url: 'like_comment.php',
        type: 'GET',
        data: { commentId: id },
        success: function(data) {
            like.innerText = data;
        }
    })
})