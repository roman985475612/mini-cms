<?php declare(strict_types=1);
        
const CONFIG    = ROOT . '/config';
const WWW       = ROOT . '/public';
const STORAGE   = ROOT . '/public/storage';
const STORAGE_URL = '/public/storage';
const VIEW      = ROOT . '/App/Views';
const MAIL      = ROOT . '/App/Views/Mail';
const LAYOUTS   = ROOT . '/App/Views/layouts';
const INC       = ROOT . '/App/Views/layouts/inc';

require ROOT . '/vendor/autoload.php';

spl_autoload_register(function ($class) {
    $filepath = ROOT . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($filepath)) {
        require $filepath;
    }
});
