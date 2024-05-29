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

            let commInput = document.createElement('textarea'); // Замість input використовуйте textarea
            commInput.setAttribute('name', 'commText');
            commForm.appendChild(commInput);

            let submitBtn = document.createElement('button');
            submitBtn.setAttribute('type', 'submit');
            submitBtn.setAttribute('name', 'postComm');
            
            let subImage = document.createElement('img');
            subImage.src = 'post_comment.png';
            subImage.alt = 'Submit';
            submitBtn.appendChild(subImage);

            commForm.appendChild(submitBtn);

            undercomms.appendChild(commForm);
            undercomms.removeChild(makecommsBtn);
        }
        if (sendProposition != undefined) {
            undercomms.removeChild(sendProposition);
        }
    });
});

