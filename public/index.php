<?php declare(strict_types=1);

session_start();

require dirname(__DIR__) . '/vendor/autoload.php';

(new \Home\CmsMini\Router);
