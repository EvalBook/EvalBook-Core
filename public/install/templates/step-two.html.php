<?php

use EvalBookCore\Installer\Installer;


/**
 * @param string $function
 * @param string $msgOk
 * @param string $msgNok
 * @param string $nextLabel
 * @param string $infoP
 * @return void
 */
function installPackages(string $function, string $msgOk, string $msgNok, string $nextLabel = '', string $infoP = ''): void
{
    $installer = new Installer($_POST['install-mode'] ?? $_SESSION['install-mode'] ?? 'prod');

    if($installer->$function()) { ?>
        <p><span class='green bold'>Ok</span> - <?= $msgOk ?></p>
        <hr>
        <p class="info">
            <?= $infoP ?>
        </p>
        <div class="input-group">
        <input type="submit" class="btn" value="<?= $nextLabel ?>&nbsp;&raquo;" name="next">
        </div><?php
    }
    else { ?>
        <p><span class='red bold'>Nok</span> - <?= $msgNok ?></p>
        <hr>
        <a class="try-again" href="/index.php">Essayer à nouveau</a><?php
        $_SESSION['step'] = --$_SESSION['step'];
    }
}

?>

<section>
    <h2>Étape 2/3: <span>Installation des dépendences</span></h2>
    <form action="/index.php" method="POST">
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
                    'installNpmAndYarn',
                    'Npm, Yarn et libs associées installés',
                    'Problème survenu en installant Npm et Yarn.',
                    'Dernière étape'
                );
            }?>
        </div>
    </form>
</section>