<?php

namespace App\Command;

class CommandUtil {

    /**
     * @param string $cmd
     * @return bool
     */
    public static function execSymfonyCmd(string $cmd): bool
    {
        $workingDir = __DIR__ . '/../../';
        exec('cd "'. $workingDir . '" && ' . $cmd, $output, $code);

        echo "<pre>";
        var_dump($output);
        echo "</pre>";

        echo "<pre>";
        var_dump('cd "'. $workingDir . '" && ' . $cmd);
        echo "</pre>";

        return $code === 0;
    }

}