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
            let commInput = document.createElement('input');
            commInput.setAttribute('type', 'text');
            commInput.setAttribute('name', 'commText');
            commForm.appendChild(commInput);

            let submitBtn = document.createElement('input');
            submitBtn.setAttribute('type', 'submit');
            submitBtn.setAttribute('name', 'postComm');
            submitBtn.setAttribute('value', 'Submit');
            commForm.appendChild(submitBtn);

            undercomms.appendChild(commForm);
        }
        if (sendProposition != undefined) {
            undercomms.removeChild(sendProposition);
        }
    });
});
