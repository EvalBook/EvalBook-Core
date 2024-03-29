<?php

namespace EvalBookCore\Command;

class CommandUtil {

    private const WORKING_DIR = __DIR__ . '/../../';

    /**
     * @param string $cmd
     * @param bool $debug
     * @return bool
     */
    public static function execSymfonyCmd(string $cmd, bool $debug=false): bool
    {
        exec('cd "'. self::WORKING_DIR . '" && ' . $cmd, $output, $code);

        if($debug) {
            self::dump($output);
            self::dump('cd "' . self::WORKING_DIR . '" && ' . $cmd);
        }
        return $code === 0;
    }


    /**
     * Prepare env file for installation, check if env files exists and reset them if so.
     * @param string $env
     * @return void
     */
    public static function prepareEnvFiles(string $env): void
    {
        // Make sure .env file exists, it avoid Symfony to trigger an env file load error.
        $files = [
            self::WORKING_DIR . '.env',
            self::WORKING_DIR . '.env.local',
            self::WORKING_DIR . '.env.test',
        ];

        array_map(function($f){if(file_exists($f)) unlink($f);}, $files);

        CommandUtil::execSymfonyCmd("echo \"DATABASE_URL=''\" >> .env");
        if(strtolower($env) === 'dev'){
            CommandUtil::execSymfonyCmd("echo \"DATABASE_URL=''\" >> .env.local");
        }
    }


    /**
     * @param mixed $data
     * @return void
     */
    private static function dump(mixed $data): void {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }
}