document.addEventListener("DOMContentLoaded", function() {
    let cartWin = document.querySelector("#CartWindow");
    let purchaseButton = cartWin.querySelector('#Purchase');
    if (purchaseButton) {
        purchaseButton.setAttribute('onclick', "handlePurchaseClick()");
      purchaseButton.addEventListener('click', function() {
        window.location.href = "ОформленняЗамовлення.php";
      });
    } else {
      console.error("Елемент не знайдено");
    }
    function handlePurchaseClick() {
        window.location.href = "ОформленняЗамовлення.php";
    }
  });
// InCartBtn.addEventListener('click', function() {
    
//     let bookTitle = '<?php echo $row["Name"]; ?>';
//     let bookAuthor = '<?php echo $row["Author"]; ?>';
//     let bookCover = '<?php echo $row["Cover"]; ?>';
//     if (CartOpen == false){
//         cartIcon.style.right = '502px';
//         cartWin.style.right = '0px';
//         CartOpen = true;
//         let bookElement = document.createElement('div');
//         bookElement.innerHTML = '<h4>' + bookTitle + '</h4><p>' + bookAuthor + '</p><img src="' + bookCover + '" alt="Обкладинка">';
    
//         cartWin.appendChild(bookElement);
//     }
// });
// InCartBtn.addEventListener('click', function () {
//     if (CartOpen == false){
//         cartIcon.style.right = '502px';
//         cartWin.style.right = '0px';
//         CartOpen = true;
//         cartWin.innerHTML = "<img src='<?php echo $row['Cover']; ?>' alt='Обкладинка'> <h4><?php echo $row['Name'];?></h4>";
//     }
// })
// InCartBtn.forEach(button => {
//     button.addEventListener('click', function() {
//       var productId = this.dataset.productId;
  
//       fetch('add-to-cart.php', {
//         method: 'POST',
//         body: JSON.stringify({
//           id: productId
//         }),
//         headers: {
//           'Content-Type': 'application/json'
//         }
//       }).then(response => response.json())
//         .then(data => console.log(data));
//     });
//   });
  