<?php

namespace EvalBookCore\Installer;

final class Debug
{

    /**
     * Well formatted print_r.
     * @param $data
     */
    public static function print_r2($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

}