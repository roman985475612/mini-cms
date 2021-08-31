<?php declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

spl_autoload_register(function ($class) {
    $filepath = dirname(__DIR__) . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($filepath)) {
        require $filepath;
    }
});

new \Home\CmsMini\Core\Console;
