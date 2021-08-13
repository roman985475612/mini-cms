<?php

namespace Home\CmsMini;

use Home\CmsMini\Exception\Http404Exception;

class App
{
    public static $config;

    public function __construct()
    {
        session_start();
        
        self::$config = json_decode(file_get_contents(ROOT . '/config.json'));

        try {
            new Router;
        } catch (Http404Exception $e) {
            if (self::$config->debug) {
                dd($e);
            }
            http_response_code($e->getCode());
            include ROOT . '/app/views/errors/' . $e->getCode() . '.php';
            exit;
        }
    }
}