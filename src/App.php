<?php

namespace Home\CmsMini;

use Home\CmsMini\Exception\Http404Exception;

class App
{
    public static $config;

    public static $route;

    public static Db $db;

    public function __construct()
    {
        session_start();
        
        self::$config = json_decode(file_get_contents(CONFIG . '/config.json'));

        self::$db = new Db(
            self::$config->db->host,
            self::$config->db->name,
            self::$config->db->user,
            self::$config->db->pass
        );

        try {
            Router::init();
        } catch (Http404Exception $e) {
            if (self::$config->debug) {
                dd($e);
            }
            http_response_code($e->getCode());
            (new View)->render('/errors/' . $e->getCode());
        
        } catch (\Exception $e) {
            if (self::$config->debug) {
                dd($e);
            }            
            http_response_code(500);
            (new View)->render('/errors/500');
        }
    }
}