<?php declare(strict_types=1);

define("ROOT", __DIR__);

require ROOT . '/bootstrap/init.php';

\Home\CmsMini\Core\Console::create();
