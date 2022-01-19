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
require dirname(__FILE__) . '/../src/Command/CommandUtil.php';

use App\Command\CommandUtil;

$installer = new Installer($_POST['install-mode'] ?? $_SESSION['install-mode'] ?? 'prod');

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="<? __dir__ ?>">

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
                            <p><?= $version_span ?> - Version de php >= à 8.0 (<?= $php_version ?>)</p>
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
                    // Make sure .env file exists, it avoid Symfony to trigger an env file load error.
                    if(!file_exists(__DIR__ . '../.env')) {
                        CommandUtil::execSymfonyCmd("echo \"DATABASE_URL=''\" >> .env");
                    }

                    $dsn = match($db_type) {
                        'mysql-5.7' => "mysql://$db_user:$db_password@$host:$port/$db?serverVersion=5.7&charset=utf8",
                        'mysql-8.0' => "mysql://$db_user:$db_password@$host:$port/$db?serverVersion=8.0&charset=utf8",
                        'mariadb-10.5' => "mysql://$db_user:$db_password@$host:$port/$db?serverVersion=mariadb-10.5.10&charset=utf8",
                        default => "sqlite:///%kernel.project_dir%/var/$db.db",
                    };

                    if(CommandUtil::execSymfonyCmd("php bin/console regenerate-env {$_SESSION['install-mode']} $dsn")) {
                        if(CommandUtil::execSymfonyCmd("php bin/console install-db")) {

                        }
                        else { ?>
                            <div class="error alert">La base de données n'a pas pu être créée / peuplée, l'installation a échoué</div> <?php
                        }
                    }
                    else { ?>
                        <div class="error alert">Le fichier de configuration n'a pas pu être généré, l'installation a échoué !</div> <?php
                    }

                    echo "<pre>";
                    var_dump($_SESSION['install-mode'], $dsn, "php bin/console regenerate-env {$_SESSION['install-mode']} $dsn");
                    echo "</pre>";

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
