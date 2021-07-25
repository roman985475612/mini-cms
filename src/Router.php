<?php

namespace Home\CmsMini;

class Router
{
    protected array $route = [];

    public function __construct()
    {
        $this->route['controller'] = Config::instance()->config['default']['controller'];
        $this->route['action'] = Config::instance()->config['default']['action'];
        $this->route['params'] = [];

        $this->matchRoute();
        
        $this->dispatch();
    }

    protected function dispatch()
    {
        $class = '\\App\\Controller\\' . $this->route['controller'];

        try {
            if (!class_exists($class)) {
                throw new \Exception();
            }

            $controller = new $class;
            if (!method_exists($class, $this->route['action'])) {
                throw new \Exception();
            }

            call_user_func_array([$controller, $this->route['action']], $this->route['params']);
        } catch (\Throwable $e) {
            http_response_code(404);
            echo $e->getMessage();
        }
        
    }

    protected function matchRoute()
    {
        $url = [];
        if (isset($_GET['URI'])) {
            $url = filter_var($_GET['URI'], FILTER_SANITIZE_URL);
            $url = trim($url, '/');
            $url = explode('/', $url);
        }

        if (isset($url[0]) && !empty($url[0])) {
            $this->route['controller'] =  upperCamelCase($url[0]) . 'Controller';
        }

        if (isset($url[1]) && !empty($url[1])) {
            $this->route['action'] =  'action' . upperCamelCase($url[1]);
        }

        if (isset($url[2]) && !empty($url[2])) {
            $this->route['params']['id'] = $url[2];
        }
    }
}