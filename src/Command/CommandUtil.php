<?php

namespace EvalBookCore\Command;

class CommandUtil {

    /**
     * @param string $cmd
     * @param bool $debug
     * @return bool
     */
    public static function execSymfonyCmd(string $cmd, bool $debug=false): bool
    {
        $debug = true;
        $workingDir = __DIR__ . '/../../';
        exec('cd "'. $workingDir . '" && ' . $cmd, $output, $code);

        if($debug) {
            echo "<pre>";
            var_dump($output);
            echo "</pre>";

            echo "<pre>";
            var_dump('cd "' . $workingDir . '" && ' . $cmd);
            echo "</pre>";
        }
        return $code === 0;
    }

}