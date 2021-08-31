<?php declare(strict_types=1);

session_start();
        
define("ROOT"   , dirname(__DIR__));
const CONFIG    = ROOT . '/config';
const WWW       = ROOT . '/public';
const STORAGE   = ROOT . '/public/storage';
const STORAGE_URL = '/public/storage';
const VIEW      = ROOT . '/app/Views';
const MAIL      = ROOT . '/app/Views/Mail';
const LAYOUTS   = ROOT . '/app/Views/layouts';
const INC       = ROOT . '/app/Views/layouts/inc';

require ROOT . '/vendor/autoload.php';

spl_autoload_register(function ($class) {
    $filepath = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($filepath)) {
        require $filepath;
    }
});
