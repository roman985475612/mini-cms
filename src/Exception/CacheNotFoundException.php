<?php

namespace Home\CmsMini\Exception;

use Exception;

class CacheNotFoundException extends Exception 
{
    public function __construct($message = '')
    {
        parent::__construct('Cache Not Found' . ' : ' . $message, 0, null);
    }
}