<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\Container1LGQl3C\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/Container1LGQl3C/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/Container1LGQl3C.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\Container1LGQl3C\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \Container1LGQl3C\App_KernelDevDebugContainer([
    'container.build_hash' => '1LGQl3C',
    'container.build_id' => '27fec2c6',
    'container.build_time' => 1628522085,
], __DIR__.\DIRECTORY_SEPARATOR.'Container1LGQl3C');
