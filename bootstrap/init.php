<?php declare(strict_types=1);

define("ROOT"   , dirname(__DIR__));
define("CONFIG" , ROOT . '/config');
define("WWW"    , ROOT . '/public');
define("VIEW"   , ROOT . '/app/Views/');
define("LAYOUTS", ROOT . '/app/Views/layouts/');
define("INC"    , ROOT . '/app/Views/layouts/inc/');

require ROOT . '/vendor/autoload.php';

spl_autoload_register(function ($class) {
    $filename = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($filename)) {
        require $filename;
    }
});
