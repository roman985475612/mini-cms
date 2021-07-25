<?php

namespace Home\CmsMini;

class Config
{
    protected static $instance = null;

    public $config = [];

    public static function instance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    protected function __construct()
    {
        $this->config = json_decode(file_get_contents(dirname(__DIR__) . '/config.json'), true);
    }
}
