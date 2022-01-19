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
        return $code === 0;
    }

}