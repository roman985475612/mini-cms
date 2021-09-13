<?php

use Home\CmsMini\Core\Console;

Console::addRoute('migrate', \Home\CmsMini\Db\Migration::class);
