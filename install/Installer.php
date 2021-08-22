<?php

require_once 'utils/FileUtils.php';

final class Installer
{
    const COMPOSER_VERSION = '2.1.6';

    private string $composer_release;
    private string $download_path;
    private string $composer_path;
    private string $npm_path;

    public function __construct(string $downloadPath) {
        $this->download_path = $downloadPath;
        $this->npm_path = $this->download_path . '/vendor/mouf/nodejs-installer/bin/local/npm';
        $this->composer_release = 'https://github.com/composer/composer/releases/download/' . self::COMPOSER_VERSION . '/composer.phar';

    }

    /**
     * Start installation process.
     */
    public function start() {
        if(!FileUtils::download($this->composer_release, $this->download_path, 'composer.phar')) {
            echo "Impossible de télécharger composer, vérifiez votre connexion internet<br>";
            exit(1);
        }

        $this->composer_path = $this->download_path . '/composer.phar';

        // Installing composer dependencies.
        exec('php ' . $this->composer_path . ' install --working-dir=' . $this->download_path);
        if(!is_dir($this->download_path . '/vendor')) {
            echo "Une problème est survenu en installant les dépendances composer<br>";
            exit(1);
        }

        // Requiring browser detection lib.
        if(strtolower(PHP_OS) === 'linux'){
            exec('sh ' . $this->npm_path . ' install yarn');
        }

    }

}

