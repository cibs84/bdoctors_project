window.addEventListener('load', function() {
    // password
    let password = document.getElementById('password');
    // conferma-password
    let confirm_password = document.getElementById('password-confirm');
    // checkbox
    let registerCheckbox = document.querySelectorAll('input[type="checkbox"]');

    // VALIDAZIONE PASSWORD
    function validatePassword(){
        if(password.value.length < 8) {
            password.setCustomValidity("La password deve essere lunga almeno 8 caratteri");
        } else {
            password.setCustomValidity('');
        }
        if(password && confirm_password) {
            if(password.value != confirm_password.value) {
            confirm_password.setCustomValidity("La password di conferma non corrisponde");
            } else {
            confirm_password.setCustomValidity('');
            }
        }

    };

    password.onkeyup = validatePassword;
    if(confirm_password) confirm_password.onkeyup = validatePassword;

    // validazione checkbox
    let markedCheckbox_value = document.querySelectorAll('input[type="checkbox"]:checked');
    if(markedCheckbox_value.length == 0 && registerCheckbox.length > 1) {
        registerCheckbox[0].setCustomValidity('Seleziona almeno una specializzazione');
    }
    else{
        registerCheckbox[0].setCustomValidity('');
    }

    registerCheckbox.forEach(item => {
        item.addEventListener('change', function(event) {
            // valore checked checkbox 
            markedCheckbox_value = document.querySelectorAll('input[type="checkbox"]:checked');
            if(markedCheckbox_value.length == 0 && registerCheckbox.length > 1) {
                registerCheckbox[0].setCustomValidity('Seleziona almeno una specializzazione');
            }
            else{
                registerCheckbox[0].setCustomValidity('');
            }
        });
    });
});
