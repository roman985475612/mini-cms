<?php

namespace Home\CmsMini\Exception;

class Http404Exception extends \Exception 
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct('404 Not Found' . ' : ' . $message, 404, null);
    }
}