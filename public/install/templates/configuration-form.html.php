<?php

use EvalBookCore\Command\CommandUtil;
use EvalBookCore\Installer\Form;

if(isset($_POST['migrate'])) {
    $allowedDbTypes = ['mysql-5.7', 'mysql-5.8', 'mariadb-10.5', 'sqlite'];

    $host = strip_tags($_POST['database-host']) ?? 'localhost';
    $port = (int)$_POST['database-port'] ?? 3306;
    $port = abs($port);
    // Make sure port is 3306 on incoherent provided port, registered ports are in the range 1024 to 49151
    // Ports above 1024 are private ports.
    if($port < 1024 || $port > 49151) {
        $port = 3306;
    }
    $db = strip_tags($_POST['database-name']) ?? 'evalbook';
    $db_user = strip_tags($_POST['database-username']);
    $db_password = strip_tags($_POST['database-password']);
    $db_type = strip_tags($_POST['database-type']);
    $createDatabase = intval(isset($_POST['create-database']) && $_POST['create-database'] === 'on');

    // Validating installation form.
    if($db_type !== 'sqlite') {
        $error = Form::areFieldsEmpty($host, $port, $db, $db_user, $db_password, $db_type);
    }
    else {
        $error = Form::areFieldsEmpty($db);
    }
    if($error) { ?>
        <div class="error alert">Certains champs sont vide</div> <?php
    }

    // Validating database type.
    if(!in_array($db_type, $allowedDbTypes)) { ?>
        <div class="error alert">Le système de base de données choisi n'est pas pris en charge !</div> <?php
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
            if(CommandUtil::execSymfonyCmd("php bin/console install-db $createDatabase {$_SESSION['install-mode']}")) {
                // Loading production / dev fixtures
                $res = CommandUtil::execSymfonyCmd("php bin/console doctrine:fixtures:load --group={$_SESSION['install-mode']} --no-interaction");
                if($res && $_SESSION['install-mode'] === 'prod') {
                    CommandUtil::execSymfonyCmd("rm -rf ./public/install");
                }
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
            <label class="required" for="database-host">Adresse serveur</label>
            <div>
                <input type="text" name="database-host" placeholder="Généralement localhost">
            </div>
        </div>

        <div class="input-group row">
            <label for="database-port">Port de connexion</label>
            <div>
                <input type="number" name="database-port" placeholder="Défault: 3306">
            </div>
        </div>

        <div class="input-group row">
            <label class="required" for="database-name">Nom de la base de données</label>
            <div>
                <input type="text" name="database-name" required>
                <input type="checkbox" name="create-database" checked> Créer la base de données
            </div>
        </div>

        <div class="input-group row">
            <label class="required" for="database-username">Utilisateur de la base de données</label>
            <div>
                <input type="text" name="database-username" required>
            </div>
        </div>

        <div class="input-group row">
            <label class="required" for="database-password">Password de la base de données</label>
            <div>
                <input type="password" name="database-password" required>
            </div>
        </div>

    </fieldset>

    <!-- Admin user information -->
    <fieldset>
        <legend>Accès administrateur par défaut</legend>
        <p class="important">
            Une fois connecté à l'interface, la première chose à faire sera de modifier ces accès par défaut.
            En effet, ce sont les mêmes pour chaque installation de EvalBook. Vous ne pouvez pas modifier ces accès depuis cet installateur
        </p>

        <div class="input-group row">
            <label>Login admin par défaut</label>
            <div>
                <input type="email" value="admin@evalbook.be" disabled>
            </div>
        </div>

        <div class="input-group row">
            <label>Mot de passe admin par défaut</label>
            <div>
                <input type="text" value="adminAdmin0" disabled>
            </div>
        </div>

    </fieldset>

    <div class="input-group">
        <input type="submit" class="btn" value="Finir l'installation&nbsp;&raquo;" name="migrate" id="database-configuration">
    </div>
</form>