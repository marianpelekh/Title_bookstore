document.addEventListener("DOMContentLoaded", function() {
    let makecommsBtn = document.getElementById('MakeComment');
    let sendProposition = document.getElementById('SendProposition');
    let undercomms = document.getElementsByClassName('undercomms')[0];

    makecommsBtn.addEventListener('click', function() {
        if (document.getElementById("CommentForm") === undefined || document.getElementById("CommentForm") === null) {
            let commForm = document.createElement('form');
            commForm.setAttribute('action', '');
            commForm.setAttribute('method', 'POST');
            commForm.id = "CommentForm";

            let commInput = document.createElement('textarea');
            commInput.setAttribute('name', 'commText');
            commForm.appendChild(commInput);

            let ratingInput = document.createElement('div');
            let ratingValue = 0;
            let ratingValueInput = document.createElement('input');
            ratingValueInput.setAttribute('type', 'hidden');
            ratingValueInput.setAttribute('name', 'rating');
            ratingInput.className = 'ratingStars';


            for (let i = 1; i <= 5; i++) {
                let star = document.createElement('span');
                star.textContent = '★';
                star.addEventListener('click', function() {
                    ratingValue = i;
                    updateRating();
                });
                ratingInput.appendChild(star);
            }

            updateRating();

            function updateRating() {
                for (let i = 0; i < 5; i++) {
                    ratingInput.children[i].style.color = i < ratingValue ? 'var(--a-color)' : 'var(--main-color)';
                }
                ratingValueInput.value = ratingValue;
            }

            let submitBtn = document.createElement('button');
            submitBtn.setAttribute('type', 'submit');
            submitBtn.setAttribute('name', 'postComm');
            
            let subImage = document.createElement('img');
            subImage.src = 'post_comment.png';
            subImage.alt = 'Submit';
            submitBtn.appendChild(subImage);

            
            commForm.appendChild(ratingValueInput);
            commForm.appendChild(submitBtn);
            commForm.appendChild(ratingInput);
            undercomms.appendChild(commForm);
            undercomms.removeChild(makecommsBtn);
        }
        if (sendProposition != undefined) {
            undercomms.removeChild(sendProposition);
        }
    });
});

