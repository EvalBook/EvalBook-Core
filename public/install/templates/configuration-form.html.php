<?php

use EvalBookCore\Command\CommandUtil;
use EvalBookCore\Installer\Form;

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
        $error = Form::areFieldsEmpty($host, $port, $db, $db_user, $db_password, $db_type, $admin_email, $admin_password, $admin_password_repeat);
    }
    else {
        $error = Form::areFieldsEmpty($db, $admin_email, $admin_password, $admin_password_repeat);
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
        // Reset env files before write them again.
        CommandUtil::prepareEnvFiles($_SESSION['install-mode']);

        $dsn = match($db_type) {
            'mysql-5.7' => "mysql://$db_user:$db_password@$host:$port/$db?serverVersion=5.7&charset=utf8",
            'mysql-8.0' => "mysql://$db_user:$db_password@$host:$port/$db?serverVersion=8.0&charset=utf8",
            'mariadb-10.5' => "mysql://$db_user:$db_password@$host:$port/$db?serverVersion=mariadb-10.5.10&charset=utf8",
            default => "sqlite:///%kernel.project_dir%/var/$db.db",
        };

        if(CommandUtil::execSymfonyCmd("php bin/console regenerate-env {$_SESSION['install-mode']} $dsn")) {
            // Installing database.
            if(CommandUtil::execSymfonyCmd("php bin/console install-db")) {
                // Loading production / dev fixtures
                // TODO
            }
            else { ?>
                <div class="error alert">La base de données n'a pas pu être créée / peuplée, l'installation a échoué</div> <?php
            }
        }
        else { ?>
            <div class="error alert">Le fichier de configuration n'a pas pu être généré, l'installation a échoué !</div> <?php
        }

        var_dump($_SESSION['install-mode']);
    }
}
?>

<form action="/index.php" method="POST" name="env-form">
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
                <input type="text" name="database-name" required>
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