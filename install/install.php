<?php
session_start();

$step = $_SESSION['step'] ?? 0;
// Checking current installation step.
if(isset($_POST['next'])){
    $step = (int)++$step;
}
elseif(isset($_POST['previous'])) {
    $step = (int)--$step;
}

$_SESSION['step'] = $step;

// Getting installation mode.
if(isset($_POST['install-mode']) && in_array($_POST['install-mode'], ['prod', 'dev'])) {
    $_SESSION['install-mode'] = trim($_POST['install-mode']);
}

const CHOOSE_MODE = 0;
const INSTALL_DEPENDENCIES = 1;
const INSTALL_DEPENDENCIES_COMPOSER = 2;
const INSTALL_DEPENDENCIES_NPM_YARN = 3;

require dirname(__FILE__) . '/Installer.php';
$installer = new Installer($_POST['install-mode'] ?? $_SESSION['install-mode'] ?? 'prod');

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Schoolbell&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            font-size: 62.5%;
            font-family: 'Lato', sans-serif;
        }

        main, header, section {
            display: flex;
            max-width: 75rem;
            flex-direction: column;
            margin-left: auto;
            margin-right: auto;
            margin-top: 6rem;
        }

        header img {
            max-width: 50rem;
            height: auto;
            margin-top: 3rem;
        }

        h1, h2 {
            font-family: 'Schoolbell', cursive;
            text-align: center;
        }

        h1 {
            font-size: 2.2rem;
        }

        h2 {
            font-size: 1.9rem;
        }

        section > * {
            margin-top: 1.5rem;
        }

        input + label {
            margin-left: .8rem;
        }

        .btn {
            background: #6C9BC3;
            background-image: -webkit-linear-gradient(top, #6C9BC3, #76A5CD);
            background-image: -moz-linear-gradient(top, #6C9BC3, #76A5CD);
            background-image: -ms-linear-gradient(top, #6C9BC3, #76A5CD);
            background-image: -o-linear-gradient(top, #6C9BC3, #76A5CD);
            background-image: -webkit-gradient(to bottom, #6C9BC3, #76A5CD);
            -webkit-border-radius: 1rem;
            -moz-border-radius: 1rem;
            border-radius: 1rem;
            color: #FFFFFF;
            font-size: 1.6rem;
            padding: .5rem 2rem;
            -webkit-box-shadow: .1rem .1rem .8rem 0 #000000;
            -moz-box-shadow: .1rem .1rem .8rem 0 #000000;
            box-shadow: .1rem .1rem .8rem 0 #000000;
            border: solid #337FED .1rem;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            text-align: center;
        }

        .btn:hover {
            border: solid #EAAF19 .2rem;
            background: #6C9BC3;
            background-image: -webkit-linear-gradient(top, #6C9BC3, #85BAE7);
            background-image: -moz-linear-gradient(top, #6C9BC3, #85BAE7);
            background-image: -ms-linear-gradient(top, #6C9BC3, #85BAE7);
            background-image: -o-linear-gradient(top, #6C9BC3, #85BAE7);
            background-image: -webkit-gradient(to bottom, #6C9BC3, #85BAE7);
            -webkit-border-radius: 1rem;
            -moz-border-radius: 1rem;
            border-radius: 1rem;
            text-decoration: none;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            margin-top: 1.2rem;
            align-items: center;
            font-size: 1.6rem;
        }

        .input-group > div {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        .input-group.row {
            flex-direction: row;
        }

        .input-group.row > div {
            margin: 0;
            padding: 0;
            width: 100%;
        }

        p {
            margin-top: 1.3rem;
            font-size: 1.6rem;
        }

        .green {
            color: green;
        }

        .red {
            color: red;
        }

        .bold {
            font-weight: bold;
        }

        p.info {
            font-size: 1.5rem;
            margin-top: 2.5rem;
            margin-bottom: 2.5rem;
        }

        hr {
            width: 60%;
            margin-top: 5rem;
            color: #6C9BC3;
        }

        .try-again {
            margin-top: 3rem;
        }

        .alert {
            position: absolute;
            width: 100%;
            height: 5rem;
            display: flex;
            justify-content: center;
            align-items: center;
            top: 0;
            left: 0;
            font-size: 1.8rem !important;
            font-weight: bold;
        }

        .alert.error{
            background-color: indianred;
            color: white;
        }

        .error {
            color: indianred;
            outline-color: indianred;
            border-color: indianred;
            align-self: flex-start;
            font-size: 1.2rem;
        }

        .error::before:not(.alert.error) {
            content: "* ";
        }

        span.error {
            display: block;
        }

        .progress-container {
            border: .2rem solid black;
            position: absolute;
            top: 0;
            left: 30%;
            width: 40%;
            margin: 18rem auto;
            padding: 1.5rem 2rem;
            border-radius: .4rem;
            box-sizing: border-box;
            background: #fff;
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, .5);
            animation: pulse 5s infinite;
        }

        .loading {
            position: relative;
            display: inline-block;
            width: 100%;
            height: 2rem;
            background: #f1f1f1;
            box-shadow: inset 0 0 .5rem rgba(0, 0, 0, .2);
            border-radius: .4rem;
            overflow: hidden;
        }

        .loading:after {
            content: '';
            position: absolute;
            left: 0;
            width: 0;
            height: 100%;
            border-radius: 4px;
            box-shadow: 0 0 5px rgba(0, 0, 0, .2);
            animation: load 5s infinite;
        }

        label:not(input+label),
        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="number"],
        select {
            display: block;
            margin-top: 0.8rem;
            width: 100%;
            padding: 0.4rem;
        }

        label {
            margin-right: 3rem;
        }

        label.required::after {
            content: " * ";
            color: indianred;
        }

        fieldset {
            padding: 2rem;
            border-radius: 0.6rem;
            margin-top: 4rem !important;
        }

        fieldset > legend {
            margin-left: 0.5rem;
            margin-right: 0.5rem;
            padding-left: 1rem;
            padding-right: 1rem;
            font-size: 1.5rem;
            color: #6C9BC3;
        }

        @keyframes load {
            0% {
                width: 0;
                background: #6C9BC3FF;
            }

            25% {
                width: 40%;
                background: #a0d2eb;
            }

            50% {
                width: 60%;
                background: #bcdcec;
            }

            75% {
                width: 75%;
                background: #EAAF19FF;
            }

            100% {
                width: 100%;
                background: #ecd498;
            }
        }

        @keyframes pulse {
            0% {
                border-color: #6C9BC3FF;
            }

            25% {
                border-color: #a0d2eb;
            }

            50% {
                border-color: #bcdcec;
            }

            75% {
                border-color: #EAAF19FF;
            }

            100% {
                border-color: #ecd498;
            }
        }

    </style>

    <script>
        window.addEventListener('load', function() {
            const loader = document.getElementById('loader');
            loader.parentElement.removeChild(loader);
        });
    </script>

    <title>Installation - EvalBook</title>
</head>
<body>
    <main>

        <header>
            <h1>Installation de votre instance</h1>
            <div id="loader" class="progress-container">
                <div class="loading"></div>
            </div>
            <img src="/assets/logo_text.png" alt="Logo texte EvalBook">
        </header>
        <?php
        /**
         * Step one, selection between production or development EvalBook installation.
         */
        if($step === CHOOSE_MODE) { ?>
            <section>
                <h2>Étape 1/3: <span>Choix du mode d'installation</span></h2>

                <form action="index.php" method="POST">
                    <div class="input-group">
                        <!-- Standard installation mode, use in production -->
                        <div>
                            <input type="radio" id="prod" name="install-mode" value="prod" checked>
                            <label for="prod">Mode production, pour utiliser dans votre école.</label>
                        </div>

                        <!-- Dev installation mode, used to contribute to EvalBook -->
                        <div>
                            <input type="radio" id="dev" name="install-mode" value="dev">
                            <label for="prod">Mode développeur, pour contribuer à EvalBook</label>
                        </div>
                    </div>
                    <div class="input-group">
                        <input type="submit" class="btn" value="Suivant&nbsp;&raquo;" name="next">
                    </div>
                </form>

            </section> <?php
        } 
        /**
         * Step 2, dependencies installation. 
         */
        elseif(in_array($step,[INSTALL_DEPENDENCIES, INSTALL_DEPENDENCIES_COMPOSER, INSTALL_DEPENDENCIES_NPM_YARN])){ ?>
            <section>
                <h2>Étape 2/3: <span>Installation des dépendences</span></h2>
                <form action="index.php" method="POST">
                    <div class="input-group"> <?php
                        /**
                         * Display the composer install notice before proceeding (long install, no async possible as vendors are not set yet).
                         */
                        if($step === INSTALL_DEPENDENCIES) {
                            $php_version = phpversion();
                            $version_span = version_compare($php_version, '8.0.0', '>=') ?
                                "<span class='green bold'>Ok</span>" : "<span class='red bold'>Nok</span>";
                            ?>
                            <p><?= $version_span ?> - Version de php >= à 7.4 (<?= $php_version ?>)</p>
                            <hr>
                            <p class="info">
                                La prochaine étape est l'installation de Composer, cette opération prend plus de temps.
                                Les étapes suivantes seront disponibles dès l'apparition des boutons de contrôle.
                            </p>
                            <div class="input-group">
                                <input type="submit" class="btn" value="Installer Composer&nbsp;&raquo;" name="next">
                            </div> <?php
                        }

                        elseif($step === INSTALL_DEPENDENCIES_COMPOSER) {
                            $info = "
                                La prochaine étape est l'installation de NPM et de YARN, cette opération prend plus de temps.
                                Les étapes suivantes seront disponibles dès l'apparition des boutons de contrôle.
                            ";
                            installPackages(
                                $installer,
                                'installComposer',
                                'Composer et libs associées installées',
                                'Problème survenu en installant Composer.',
                                'Installer NPM et YARN',
                                $info
                            );
                        }
                        /**
                         * Display Npm and Yarn installation process.
                         */
                        else{
                            installPackages(
                                $installer,
                                'installNpmAndYarn',
                                'Npm, Yarn et libs associées installés',
                                'Problème survenu en installant Npm et Yarn.',
                                'Dernière étape'
                            );
                        }?>
                    </div>
                </form>
            </section> <?php
        }
        /**
         * Making migration and asking for database / admin details.
         */
        else {
            if(isset($_POST['migrate'])) {
                $allowedDbTypes = ['mysql-5.7', 'mysql-5.8', 'mariadb-10.5', 'sqlite'];

                $host = strip_tags($_POST['database-host']) ?? 'localhost';
                $port = (int)$_POST['database-port'] ?? 3306;
                $db = strip_tags($_POST['database-name']) ?? 'evalbook';
                $db_user = strip_tags($_POST['database-username']);
                $db_password = strip_tags($_POST['database-password']);
                $db_type = strip_tags($_POST['database-type']);

                $admin_email = strip_tags($_POST['admin-email']) ?? null;
                $admin_password = strip_tags($_POST['admin-password']) ?? null;
                $admin_password_repeat = strip_tags($_POST['admin-password-repeat']) ?? '';

                // Validating installation form.
                if($db_type !== 'sqlite') {
                    $error = areFieldsEmpty($host, $port, $db, $db_user, $db_password, $db_type, $admin_email, $admin_password, $admin_password_repeat);
                }
                else {
                    $error = areFieldsEmpty($db, $admin_email, $admin_password, $admin_password_repeat);
                }
                if($error) { ?>
                    <div class="error alert">Certains champs sont vide</div> <?php
                }

                // Validating database type.
                if(!in_array($db_type, $allowedDbTypes)) { ?>
                    <div class="error alert">Le système de base de données choisi n'est pas pris en charge !</div> <?php
                    $error = true;
                }

                // Validating EvalBook admin password format.
                if(null === $admin_password || $admin_password !== $admin_password_repeat) { ?>
                    <div class="error alert">Les mots de passe ne correspondent pas !</div> <?php
                    $error = true;
                }

                // Validating EvalBook admin password format.
                if(null === $admin_email || !preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,25}$/", $admin_password)) { ?>
                    <div class="error alert">Le mot de passe doit contenir de 8 à 25 caractères avec majuscule(s), minuscule(s), chiffre(s)</div> <?php
                    $error = true;
                }

                // Validating email
                if(!preg_match("/^[^\s@]+@[^\s@]+\.[^\s@]+$/", $admin_email)) { ?>
                    <div class="error alert">Le format de l'adresse mail n'est pas bon</div> <?php
                    $error = true;
                }

                // If no form error, writing the .env file for prod | .env.local for dev.
                if(!$error) {
                    $dsn = match($db_type) {
                        'mysql-5.7' => "mysql://$db_user:$db_password@$host:$port/$db?serverVersion=5.7&charset=utf8",
                        'mysql-8.0' => "mysql://$db_user:$db_password@$host:$port/$db?serverVersion=8.0&charset=utf8",
                        'mariadb-10.5' => "mysql://$db_user:$db_password@$host:$port/$db?serverVersion=mariadb-10.5.10&charset=utf8",
                        default => "sqlite:///%kernel.project_dir%/var/$db.db",
                    };

                    if($installer->execSymfonyCmd("php bin/console regenerate-env {$_SESSION['install-mode']} $dsn")) {
                        if($installer->execSymfonyCmd("php bin/console doctrine:database:create")) {
                            if($installer->execSymfonyCmd("php bin/console doctrine:migrations:migrate")) {

                            }
                            else { ?>
                                <div class="error alert">Impossible d'initialiser la base de données, vérifiez les informations de connexion fournies</div> <?php
                            }
                        }
                        else { ?>
                            <div class="error alert">La base de données n'a pas pu être créée, l'installation a échoué</div> <?php
                        }
                    }
                    else { ?>
                        <div class="error alert">Le fichier de configuration n'a pas pu être généré, l'installation a échoué !</div> <?php
                    }
                }

            }?>

            <form action="index.php" method="POST" name="env-form">
                <!-- Database information -->
                <fieldset>
                    <legend>Base de données</legend>

                    <div class="input-group row">
                        <label class="required" for="database-host">Adresse serveur</label>
                        <div>
                            <input type="text" name="database-host" placeholder="Généralement localhost">
                        </div>
                    </div>

                    <div class="input-group row">
                        <label for="database-type" class="required">Base de données</label>
                        <select name="database-type" id="db-type" required>
                            <option value="">-- Veuillez choisir --</option>
                            <option value="mysql-5.7">MySql 5.7</option>
                            <option value="mysql-8.0">MySql 8.0</option>
                            <option value="mariadb-10.5">MariaDB 10.5</option>
                            <option value="sqlite">SQLite</option>
                        </select>
                    </div>

                    <div class="input-group row">
                        <label class="required" for="database-port">Port</label>
                        <div>
                            <input type="number" name="database-port" placeholder="3306" required>
                        </div>
                    </div>

                    <div class="input-group row">
                        <label class="required" for="database-name">Nom de la base</label>
                        <div>
                            <input type="text" name="database-name" placeholder="Vide pour automatique" required>
                        </div>
                    </div>

                    <div class="input-group row">
                        <label class="required" for="database-username">Utilisateur de la base</label>
                        <div>
                            <input type="text" name="database-username" required>
                        </div>
                    </div>

                    <div class="input-group row">
                        <label class="required" for="database-password">Password de la base</label>
                        <div>
                            <input type="password" name="database-password" required>
                        </div>
                    </div>

                </fieldset>

                <!-- Admin user information -->
                <fieldset>
                    <legend>Définir l'accès administrateur</legend>

                    <div class="input-group row">
                        <label class="required" for="admin-email">Adresse mail</label>
                        <div>
                            <input type="email" name="admin-email" required>
                        </div>
                    </div>

                    <div class="input-group row">
                        <label class="required" for="admin-password">Mot de passe</label>
                        <div>
                            <input type="password" name="admin-password" required>
                        </div>
                    </div>

                    <div class="input-group row">
                        <label class="required" for="admin-password-repeat">Répétez mot de passe</label>
                        <div>
                            <input type="password" name="admin-password-repeat" required>
                        </div>
                    </div>

                </fieldset>

                <div class="input-group">
                    <input type="submit" class="btn" value="Finir l'installation&nbsp;&raquo;" name="migrate">
                </div>
            </form>
            <?php
        }?>
    </main>

    <script>
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

    </script>
</body>
</html>

<?php

/**
 * @param Installer $installer
 * @param string $function
 * @param string $messageOk
 * @param string $messageNok
 * @param string $nextStepLabel
 * @param string $infoParagraph
 * @return void
 */
function installPackages(
        Installer $installer,
        string $function,
        string $messageOk,
        string $messageNok,
        string $nextStepLabel = '',
        string $infoParagraph = ''
): void
{
    if($installer->$function()) { ?>
        <p><span class='green bold'>Ok</span> - <?= $messageOk ?></p>
        <hr>
        <p class="info">
            <?= $infoParagraph ?>
        </p>
        <div class="input-group">
            <input type="submit" class="btn" value="<?= $nextStepLabel ?>&nbsp;&raquo;" name="next">
        </div><?php
    }
    else { ?>
        <p><span class='red bold'>Nok</span> - <?= $messageNok ?></p>
        <hr>
        <a class="try-again" href="index.php">Essayer à nouveau</a><?php
        $_SESSION['step'] = --$_SESSION['step'];
    }
}


/**
 * @param ...$fields
 * @return bool
 */
function areFieldsEmpty(...$fields): bool {
    foreach($fields as $field) {
        return is_null($field) || (!is_int($field) && !strlen($field) > 0);
    }
    return false;
}
