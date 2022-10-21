window.addEventListener('load', function() {
    let checkbox = document.querySelectorAll('input[type="checkbox"]');

    // validazione checkbox
    checkbox.forEach(item => {
        item.addEventListener('change', function(event) {
            // valore checked checkbox 
            markedCheckbox_value = document.querySelectorAll('input[type="checkbox"]:checked');
            if(markedCheckbox_value.length == 0 && checkbox.length > 1) {
                checkbox[0].setCustomValidity('Seleziona almeno una specializzazione');
            }
            else{
                checkbox[0].setCustomValidity('');
            }
        });
    });
});


// BRAINTREE OFFICIAL
// var button = document.querySelector('#submit-button');

// braintree.dropin.create({
//   authorization: 'sandbox_g42y39zw_348pk9cgf3bgyw2b',
//   selector: '#dropin-container'
// }, function (err, instance) {
//   button.addEventListener('click', function () {
//     instance.requestPaymentMethod(function (err, payload) {
//       // Submit payload.nonce to your server
//     });
//   })
// });