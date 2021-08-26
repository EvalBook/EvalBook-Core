<?php
ini_set('max_execution_time', 0);
require_once 'utils/FileUtils.php';

final class Installer
{
    const COMPOSER_VERSION = '2.1.6';

    private string $root;
    private string $env;

    public function __construct(string $env = 'prod')
    {
        $this->root = $_SERVER['DOCUMENT_ROOT'] . '/..';
        $this->env = $env;
    }

    /**
     * Start installation process.
     */
    public function start()
    {
        $isLinux = strtolower(PHP_OS) === 'linux';

        $release = 'https://github.com/composer/composer/releases/download/' . self::COMPOSER_VERSION . '/composer.phar';
        if(!FileUtils::download($release, $this->root, 'composer.phar')) {
            echo "Impossible de télécharger composer, vérifiez votre connexion internet<br>";
            exit();
        }

        // Installing composer dependencies.
        $composer = 'php ' . $this->root . '/composer.phar install --working-dir=' . $this->root;
        $result = $this->shellInstall($composer, $this->root . '/vendor');

        // Installing yarn
        $npm = $isLinux ? 'sh '. $this->root .'/vendor/mouf/nodejs-installer/bin/local/npm' : $this->root .'/vendor/bin/npm.bat';
        $result = $this->shellInstall("$npm install yarn", $this->root . '/node_modules/yarn');

        // Installing yarn dependencies.
        $node = $isLinux ? 'sh '. $this->root .'/vendor/mouf/nodejs-installer/bin/local/node' : $this->root .'/vendor/bin/node.bat';
        $yarn = $this->root . '/node_modules/yarn/bin/yarn.js';
        $result = $this->shellInstall("$node $yarn install --cwd " . $this->root, null, false);
    }


    /**
     * Install dependencies via shell.
     */
    private function shellInstall(string $cmd, string $dir=null): bool {
        exec("$cmd");
        if(null !== $dir && !is_dir($dir)) {
            echo "Une erreur est survenue en installant une dépendance<br>";
            return false;
        }
        return true;
    }

}

