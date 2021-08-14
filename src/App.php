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
            $view = new View(template: '/errors/' . $e->getCode());
            $view->render();
        
        } catch (\Exception $e) {
            if (self::$config->debug) {
                dd($e);
            }            
            http_response_code(500);
            $view = new View(template: '/errors/500');
            $view->render();
         }
    }
}