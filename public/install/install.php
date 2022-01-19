<?php
// TODO -> Test the whole install process, mysql still fails.
session_start();
ini_set('max_execution_time', 0);

const CHOOSE_MODE = 0;
const INSTALL_DEPENDENCIES = 1;
const INSTALL_DEPENDENCIES_COMPOSER = 2;
const INSTALL_DEPENDENCIES_NPM_YARN = 3;

require __DIR__ . '/Classes/Installer.php';
require __DIR__ . '/Classes/Form.php';
require __DIR__ . '/Classes/File.php';
require __DIR__ . '/Classes/Debug.php';

require __DIR__ . '/../../src/Command/CommandUtil.php';

/**
 * Defining current installation steps.
 */
$step = $_SESSION['step'] ?? 0;
// Checking current installation step.
if(isset($_POST['next'])){
    $step = (int)++$step;
}
elseif(isset($_POST['previous'])) {
    $step = (int)--$step;
}

$_SESSION['step'] = $step;

/**
 * Defining installation mode
 */
if(isset($_POST['install-mode']) && in_array($_POST['install-mode'], ['prod', 'dev'])) {
    $_SESSION['install-mode'] = trim($_POST['install-mode']);
}

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="/install/assets/css/style.css">

    <script src="/install/assets/js/app.js"></script>
    <script src="/install/assets/js/validator.js" defer></script>

    <title>Installation - EvalBook</title>
</head>
<body>
    <main>

        <header>
            <h1>Installation de votre instance</h1> <?php
            require __DIR__ . '/templates/loader.html.php'; ?>
            <img src="/assets/logo_text.png" alt="Logo texte EvalBook">
        </header> <?php

        /**
         * Step one, selection between production or development EvalBook installation.
         */
        if($step === CHOOSE_MODE) {
            require __DIR__ . '/templates/step-one.html.php';
        } 

        /**
         * Step 2, dependencies installation. 
         */
        elseif(in_array($step,[INSTALL_DEPENDENCIES, INSTALL_DEPENDENCIES_COMPOSER, INSTALL_DEPENDENCIES_NPM_YARN])){
            require __DIR__ . '/templates/step-two.html.php';
        }

        /**
         * Making migration and asking for database / admin details (configuration).
         */
        else {
            require __DIR__ . '/templates/configuration-form.html.php';
        }?>
    </main>
</body>
</html>
