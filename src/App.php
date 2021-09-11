<?php declare(strict_types=1);

namespace Home\CmsMini;

use Home\CmsMini\Db\Connection;
use Home\CmsMini\Exception\Http404Exception;
use Home\CmsMini\Request;
use stdClass;

class App
{
    private static stdClass $config;

    private static Request $request;

    private static stdClass $route;

    public function __construct()
    {
        try {
            self::$request = new Request;

            self::$config = json_decode(file_get_contents(CONFIG . '/config.json'));
                
            Router::init();
            
            Connection::init(
                self::$config->db->dsn,
                self::$config->db->user,
                self::$config->db->pass
            );

            Router::dispatch();
        } catch (Http404Exception $e) {
            if (self::$config->debug) {
                dd($e, true);
            }
            
            http_response_code(404);

            $view = new View(self::config()->default->layout);
            $view->setMeta('brand', self::config()->app);
            $view->setMeta('title', 'Page not found!');
            $view->render('errors/404');
        } catch (\Throwable $e) {
            if (self::$config->debug) {
                dd($e, true);
            }            
            
            http_response_code(500);
            
            $view = new View(self::config()->default->layout);
            $view->setMeta('brand', self::config()->app);
            $view->setMeta('title', 'Internal Server Error!');
            $view->render('errors/500');
        }
    }

    public static function config()
    {
        return self::$config;
    }

    public static function request()
    {
        return self::$request;
    }

    public static function getRoute(): stdClass
    {
        return self::$route;
    }

    public static function setRoute(stdClass $route): void
    {
        self::$route = $route;
    }
}