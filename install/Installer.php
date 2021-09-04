<?php
ini_set('max_execution_time', 0);
require_once 'utils/FileUtils.php';

final class Installer
{
    const COMPOSER_VERSION = '2.1.6';

    private string $root;
    private string $env;
    private bool $isLinux;

    /**
     * @param string $env
     */
    public function __construct(string $env = 'prod')
    {
        $this->root = $_SERVER['DOCUMENT_ROOT'] . '/..';
        $this->env = $env;
        $this->isLinux = strtolower(PHP_OS) === 'linux';
    }

    /**
     * Proceed to install composer dependencies.
     * @return bool
     */
    public function installComposer(): bool {
        $release = 'https://github.com/composer/composer/releases/download/' . self::COMPOSER_VERSION . '/composer.phar';
        if(!FileUtils::download($release, $this->root, 'composer.phar')) {
            return false;
        }

        // Installing composer dependencies.
        $composer = 'php ' . $this->root . '/composer.phar install --working-dir=' . $this->root;
        return $this->shellInstall($composer, $this->root . '/vendor');
    }


    /**
     * Proceed to npm, yarn and yarn dependencies installation.
     * @return bool
     */
    public function installNpmAndYarn(): bool {
        // Installing yarn
        $npm = $this->isLinux ? 'sh '. $this->root .'/vendor/mouf/nodejs-installer/bin/local/npm' : $this->root .'/vendor/bin/npm.bat';

        if($this->shellInstall("$npm install yarn", $this->root . '/node_modules/yarn')) {
            // Installing yarn dependencies.
            $node = $this->isLinux ? 'sh '. $this->root .'/vendor/mouf/nodejs-installer/bin/local/node' : $this->root .'/vendor/bin/node.bat';
            $yarn = $this->root . '/node_modules/yarn/bin/yarn.js';
            return $this->shellInstall("$node $yarn install --cwd " . $this->root, null, false);
        }
        return false;
    }


    /**
     * @param string $cmd
     * @return bool
     */
    public function execSymfonyCmd(string $cmd): bool {
        $workingDir = $_SERVER['DOCUMENT_ROOT'] . '/../';
        exec('cd "'. $workingDir . '" && ' . $cmd, $output, $code);
        return $code === 0;
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

