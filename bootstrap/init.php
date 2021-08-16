<?php declare(strict_types=1);

define("ROOT"  , dirname(__DIR__));
define("CONFIG", ROOT . '/config');
define("WWW"   , ROOT . '/public');
define("VIEW"  , ROOT . '/resources/views');

spl_autoload_register(function ($class) {
    $cls = explode('\\', $class);
    if ($cls[0] == 'DesignPatterns') {
        $cls[0] = 'patterns';
        $cls[1] = strtolower($cls[1]);
        $cls[2] = strtolower($cls[2]);

        $filepath = ROOT . '/app/' . implode('/', $cls) . '.php';

        if (file_exists($filepath)) {
            include $filepath;
        }
    }
});

require ROOT . '/vendor/autoload.php';