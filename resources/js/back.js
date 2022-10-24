// VALIDAZIONE CHECKBOX
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