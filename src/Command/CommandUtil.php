<?php

namespace App\Command;

class CommandUtil {

    /**
     * @param string $cmd
     * @return bool
     */
    public static function execSymfonyCmd(string $cmd): bool {
        $workingDir = $_SERVER['DOCUMENT_ROOT'];
        exec('cd "'. $workingDir . '" && ' . $cmd, $output, $code);
        return $code === 0;
    }

}