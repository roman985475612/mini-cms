<?php declare(strict_types=1);

session_start();
        
define("ROOT"   , dirname(__DIR__));
define("CONFIG" , ROOT . '/config');
define("WWW"    , ROOT . '/public');
define("STORAGE", ROOT . '/public/storage');
define("STORAGE_URL", '/public/storage');
define("VIEW"   , ROOT . '/app/Views/');
define("LAYOUTS", ROOT . '/app/Views/layouts/');
define("INC"    , ROOT . '/app/Views/layouts/inc/');

require ROOT . '/vendor/autoload.php';

spl_autoload_register(function ($class) {
    $filepath = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($filepath)) {
        require $filepath;
    }
});
