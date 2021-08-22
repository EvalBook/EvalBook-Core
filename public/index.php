<?php

use App\Kernel;

if(is_dir('../install')) {
    require_once dirname(__DIR__) . '/install/Installer.php';
    (new Installer(dirname(__DIR__)))->start();
}
else {
    require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

    return function (array $context) {
        return new Kernel($context['APP_ENV'], (bool)$context['APP_DEBUG']);
    };
}
