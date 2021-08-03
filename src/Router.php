<?php

namespace Home\CmsMini;

class Router
{
    protected string $controllerName;

    protected string $actionName;

    protected array $params = [];

    public function __construct()
    {
        $this->controllerName = Config::instance()->config['default']['controller'];
        $this->actionName = Config::instance()->config['default']['action'];
        $this->matchRoute();
        $this->setControllerPath();
        $this->dispatch();
    }

    protected function dispatch()
    {
        try {
            // Контроллер существует
            if (!class_exists($this->controllerName)) {
                throw new \Exception('404 Not Found');
            }
            $controllerRef = new \ReflectionClass($this->controllerName);

            // Метод существует
            if (!$controllerRef->hasMethod($this->actionName)) {
                throw new \Exception('404 Not found');
            }
            $actionRef = $controllerRef->getMethod($this->actionName);
            
            $paramsRef = $actionRef->getParameters();

            if (count($paramsRef) > 0
                && !isset($this->params['id']) 
                || (isset($this->params['id']) && !preg_match('/^\d*$/', $this->params['id']))
            ) {
                throw new \Exception('404 Not found');
            }

            $actionRef->invokeArgs(new $this->controllerName, $this->params);
        } catch (\Throwable $e) {
            http_response_code(404);
            echo $e->getMessage();
        }
        
    }

    protected function setControllerPath()
    {
        $this->controllerName = '\\App\\Controller\\' . $this->controllerName;
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
            $this->controllerName =  Helper::upperCamelCase($url[0]) . 'Controller';
        }

        if (isset($url[1]) && !empty($url[1])) {
            $this->actionName =  'action' . Helper::upperCamelCase($url[1]);
        }

        if (isset($url[2]) && !empty($url[2])) {
            $this->params['id'] = $url[2];
        }
    }
}