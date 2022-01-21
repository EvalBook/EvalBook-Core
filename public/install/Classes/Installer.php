<?php

namespace EvalBookCore\Installer;


final class Installer
{
    const COMPOSER_VERSION = '2.1.6';

    private string $root;
    private string $env;

    /**
     * @param string $env
     */
    public function __construct(string $env = 'prod')
    {
        $this->root = $_SERVER['DOCUMENT_ROOT'] . '/..';
        $this->env = $env;
    }


    /**
     * Return true if environnement is linux.
     * @return bool
     */
    public static function isLinux(): bool
    {
        return strtolower(PHP_OS) === 'linux';
    }

    /**
     * Proceed to install composer dependencies.
     * @return bool
     */
    public function installComposer(): bool
    {
        if($this->env === 'prod') {
            $release = 'https://github.com/composer/composer/releases/download/' . self::COMPOSER_VERSION . '/composer.phar';
            if (!File::download($release, $this->root, 'composer.phar')) {
                return false;
            }

            // Installing composer dependencies.
            $composer = 'php ' . $this->root . '/composer.phar install --working-dir=' . $this->root;
        }
        else {
            $composer = 'composer install --working-dir=' . $this->root . " --no-scripts";
        }
        return $this->shellInstall($composer, $this->root . '/vendor');
    }


    /**
     * Proceed to npm, yarn and yarn dependencies installation.
     * @return bool
     */
    public function installNpmAndYarn(): bool
    {
        // Installing yarn
        if($this->env === 'prod') {
            $npm = 'sh ' . $this->root . '/vendor/mouf/nodejs-installer/bin/local/npm';


            if ($this->shellInstall("$npm install yarn", $this->root . '/node_modules/yarn')) {
                // Installing yarn dependencies.
                $node = 'sh ' . $this->root . '/vendor/mouf/nodejs-installer/bin/local/node';
                $yarn = $this->root . '/node_modules/yarn/bin/yarn.js';
                return $this->shellInstall("$node $yarn install --cwd " . $this->root);
            }
        }
        else {
            // Install yarn locally, in dev mode.
            $ex = $this->shellInstall("npm install yarn", $this->root . '/node_modules/yarn');
            if($ex){
                $ex = $this->shellInstall("yarn install --cwd " . $this->root);
            }
            return $ex;
        }
        return false;
    }


    /**
     * Install dependencies via shell.
     */
    private function shellInstall(string $cmd, string $dir = null): bool
    {
        exec("$cmd");
        if (null !== $dir && !is_dir($dir)) {
            echo "Une erreur est survenue en installant une dépendance<br>";
            return false;
        }
        return true;
    }
}

