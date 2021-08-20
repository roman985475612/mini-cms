<?php

namespace Home\CmsMini;

use Home\CmsMini\Exception\Http404Exception;

class App
{
    public static $config;

    public function __construct()
    {
        session_start();
        
        self::$config = json_decode(file_get_contents(CONFIG . '/config.json'));

        try {
            Router::init();
        } catch (Http404Exception $e) {
            if (self::$config->debug) {
                // dd($e);
            }
            http_response_code($e->getCode());
            (new View)->render('/errors/' . $e->getCode());
        
        } catch (\Exception $e) {
            if (self::$config->debug) {
                // dd($e);
            }            
            http_response_code(500);
            (new View)->render('/errors/500');
        }
    }
}