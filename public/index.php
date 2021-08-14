<?php declare(strict_types=1);

define("ROOT", dirname(__DIR__));
define("VIEW", ROOT . '/resources/views');

require ROOT . '/vendor/autoload.php';

new \Home\CmsMini\App;
