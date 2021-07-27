<?php

namespace Home\CmsMini;

class Router
{
    protected string $controller;

    protected string $action;

    protected array $params = [];

    public function __construct()
    {
        $this->controller = Config::instance()->config['default']['controller'];
        $this->action = Config::instance()->config['default']['action'];
        $this->matchRoute();
        $this->dispatch();
    }

    protected function dispatch()
    {
        $class = '\\App\\Controller\\' . $this->controller;

        try {
            if (!class_exists($class)) {
                throw new \Exception();
            }

            $controller = new $class;
            if (!method_exists($class, $this->action)) {
                throw new \Exception();
            }
            call_user_func_array([$controller, $this->action], $this->params);
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
            $this->controller =  Helper::upperCamelCase($url[0]) . 'Controller';
        }

        if (isset($url[1]) && !empty($url[1])) {
            $this->action =  'action' . Helper::upperCamelCase($url[1]);
        }

        if (isset($url[2]) && !empty($url[2])) {
            $this->params['id'] = $url[2];
        }
    }
}