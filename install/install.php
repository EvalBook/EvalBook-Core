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
if(isset($_POST['install-mode']) && in_array($_POST['install-mode'], ['prod', 'env'])) {
    $_SESSION['install-mode'] = $_POST['install-mode'];
}

const CHOOSE_MODE = 0;
const INSTALL_DEPENDENCIES = 1;
const INSTALL_DEPENDENCIES_COMPOSER = 2;

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
            max-width: 50rem;
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

        .input-group {
            margin-top: 1rem;
            font-size: 1.6rem;
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
        }

        .input-group p {
            margin-top: 1.3rem;
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

    </style>
    <title>Installation - EvalBook</title>
</head>
<body>
    <main>

        <header>
            <h1>Installation de votre instance</h1>
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
        elseif(in_array($step,[INSTALL_DEPENDENCIES, INSTALL_DEPENDENCIES_COMPOSER])){ ?>
            <section>
                <h2>Étape 2/3: <span>Installation des dépendences</span></h2>
                <form action="index.php" method="POST">
                    <div class="input-group">
                        <?php
                        $php_version = phpversion();
                        $version_span = version_compare($php_version, '7.4.0', '>=') ?
                            "<span class='green bold'>Ok</span>" : "<span class='red bold'>Nok</span>";
                        ?>
                        <p><?= $version_span ?> - Version de php >= à 7.4 (<?= $php_version ?>)</p>
                        <hr>
                    </div><?php

                    /**
                     * Display the composer install notice before proceeding (long install, no async possible as vendors are not set yet).
                     */
                    if($step === INSTALL_DEPENDENCIES) { ?>
                        <p class="info">
                            La prochaine étape est l'installation de Composer, cette opération prend plus de temps.
                            Les étapes suivantes seront disponibles dès l'apparition des boutons de contrôle.
                        </p>

                        <div class="input-group">
                            <input type="submit" class="btn" value="Installer Composer&nbsp;&raquo;" name="next">
                        </div> <?php
                    }

                    if($step === INSTALL_DEPENDENCIES_COMPOSER) {
                        if($installer->installComposer()) { ?>
                            <p><span class='green bold'>Ok</span> - Composer et les dépendences liées ont bien été installés.</p> <?php
                        }
                        else { ?>
                            <p><span class='red bold'>Nok</span> - Un problème est survenu en installant Composer et les dépendences liées.</p>
                            <?php
                        }
                    } ?>
                </form>
            </section> <?php
        }?>
    </main>

</body>
</html>
