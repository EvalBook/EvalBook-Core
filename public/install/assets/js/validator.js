const envForm = document.querySelector('form[name="env-form"]');
const databaseType = envForm.querySelector('select[name="database-type"]'); // string - select.
const databaseUsername = envForm.querySelector('input[name="database-username"]'); // string
const databasePassword = envForm.querySelector('input[name="database-password"]'); // string
const databasePort = envForm.querySelector('input[name="database-port"]'); // int
const databaseHost = envForm.querySelector('input[name="database-host"]'); // string

/**
 * Removing required on database-username and database-password if SQLite was selected.
 */
databaseType.addEventListener('change', function(e) {
    if(databaseType.options[databaseType.selectedIndex].value === 'sqlite') {
        [databaseUsername, databasePort, databasePassword, databaseHost].forEach((el) => {
            el.removeAttribute('required');
            el.parentElement.parentElement.style.display = 'none';
        });
    }
    else {
        [databaseUsername, databasePort, databasePassword, databaseHost].forEach((el) => {
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
    const adminEmail = envForm.querySelector('input[name="admin-email"]'); // email
    const adminPassword = envForm.querySelector('input[name="admin-password"]'); // string - password
    const adminPasswordRepeat = envForm.querySelector('input[name="admin-password-repeat"]'); // string - password - repeat.

    // Basic form validation.
    const emptyError = validateNotEmptyField([
        databaseHost,
        databasePort,
        databaseName,
        databaseUsername,
        databasePassword,
        adminEmail,
        adminPassword,
        adminPasswordRepeat
    ]);

    const stringError = validateString([
        {el: databaseHost},
        {el: databaseName},
        {el: databaseUsername},
        {el: databasePassword},
        {el: adminPassword, min: 8, max: 25, password: true},
        {el: adminPasswordRepeat, min: 8, max: 25, password: true},
    ]);

    // Checking admin password and admin password repeat are the same.
    if(adminPassword.value !== adminPasswordRepeat.value) {
        setError(adminPassword, "Les mot de passe ne correspondent pas");
        setError(adminPasswordRepeat, "Les mots de passe ne correspondent pas");
    }

    // Checking provided database port.
    let portError = false;
    if(databasePort.hasOwnProperty('required') && !Number.isInteger(parseInt(databasePort.value)) || parseInt(databasePort.value) < 4) {
        setError(databasePort, "Le port ne semble pas correct");
        portError = true;
    }

    // Validating provided email.
    let mailError = false;
    if(!adminEmail.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
        setError(adminEmail, "L'adresse mail ne semble pas correcte");
        mailError = true;
    }

    console.log(emptyError, stringError, portError, mailError);
    if(!emptyError && !stringError && !portError && !mailError) {
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
