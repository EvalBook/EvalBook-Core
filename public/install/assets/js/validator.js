const envForm = document.querySelector('form[name="env-form"]');
const databaseType = envForm.querySelector('select[name="database-type"]'); // string - select.
const databaseUsername = envForm.querySelector('input[name="database-username"]'); // string
const databasePassword = envForm.querySelector('input[name="database-password"]'); // string
const databaseHost = envForm.querySelector('input[name="database-host"]'); // string
const databasePort = envForm.querySelector('input[name="database-port"]'); // int

/**
 * Removing required on database-username and database-password if SQLite was selected.
 */
databaseType.addEventListener('change', function(e) {
    if(databaseType.options[databaseType.selectedIndex].value === 'sqlite') {
        [databaseUsername, databasePassword, databaseHost, databasePort].forEach((el) => {
            el.removeAttribute('required');
            el.parentElement.parentElement.style.display = 'none';
        });
    }
    else {
        [databaseUsername, databasePassword, databaseHost, databasePort].forEach((el) => {
            el.setAttribute('required', 'true');
            el.parentElement.parentElement.style.display = 'flex';
        });
    }
});


/**
 * Complete form field validation (basic validation).
 */
envForm.querySelector('input[type="submit"]').addEventListener('click', function(e) {
    // Removing old potential error messages.
    envForm.querySelectorAll('span.error').forEach(function r(e){
        e.parentElement.querySelector('input').classList.remove('error');
        e.parentElement.removeChild(e);
    });

    const databaseName = envForm.querySelector('input[name="database-name"]'); // string

    // Basic form validation.
    const emptyError = validateNotEmptyField([databaseHost, databaseName, databaseUsername, databasePassword]);
    const stringError = validateString([
        {el: databaseHost},
        {el: databaseName},
        {el: databaseUsername},
        {el: databasePassword},
    ]);

    if(!emptyError && !stringError) {
        // Clearing old triggered validity errors.
        envForm.querySelectorAll('input:not([type="submit"])').forEach(function(el) {
            el.classList.remove('error');
            el.setCustomValidity("");
        });
    }
});

/**
 * @param fields
 */
const validateNotEmptyField = function(fields) {
    let err = false;
    fields.forEach(function(field) {
        if(field.value.length === 0 && field.hasOwnProperty('required')) {
            setError(field, 'Ce champs ne peut être vide !');
            err = true;
        }
    });
    return err;
}


/**
 * @param fields
 */
const validateString = function(fields) {
    let err = false;
    fields.forEach(function(fieldEntry){
        if(!fieldEntry.hasOwnProperty('required')) {
            if (fieldEntry.hasOwnProperty('min') && fieldEntry.el.value.length < fieldEntry.min) {
                setError(fieldEntry.el, 'Minimum ' + fieldEntry.min + ' caractères');
                err = true;
            }

            if (fieldEntry.hasOwnProperty('max') && fieldEntry.el.value.length > fieldEntry.max) {
                setError(fieldEntry.el, 'Maximum ' + fieldEntry.max + ' caractères')
                err = true;
            }

            if (fieldEntry.hasOwnProperty('password') && fieldEntry.password) {
                if (!fieldEntry.el.value.match(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,25}$/)) {
                    setError(fieldEntry.el, 'De 8 à 25 caractères avec majuscule(s), minuscule(s), chiffre(s)');
                    err = true;
                }
            }
        }
    });
    return err;
}

/**
 * @param el
 * @param message
 */
const setError = function(el, message) {
    const errorElement = document.createElement('span');
    errorElement.innerText = message;
    errorElement.classList.add('error');
    el.classList.add('error');
    el.parentElement.appendChild(errorElement);
    el.setCustomValidity("Ce champs ne peut être vide !");
}
