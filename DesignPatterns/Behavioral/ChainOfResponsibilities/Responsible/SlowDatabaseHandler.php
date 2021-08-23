<?php

namespace DesignPatterns\Behavioral\ChainOfResponsibilities\Responsible;

use DesignPatterns\Behavioral\ChainOfResponsibilities\Handler;
use Home\CmsMini\Request;

class SlowDatabaseHandler extends Handler
{
    protected function processing(Request $request): ?string
    {
        return 'Hello, world!';
    }
}
