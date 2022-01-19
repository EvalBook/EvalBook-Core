<?php

use EvalBookCore\Kernel;

if(is_dir(__DIR__ . '/install')) {
    require_once __DIR__ . '/install/install.php';
}
else {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload_runtime.php';

    return function (array $context) {
        return new Kernel($context['APP_ENV'], (bool)$context['APP_DEBUG']);
    };
}
