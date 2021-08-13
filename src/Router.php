<?php

namespace Home\CmsMini;

use Home\CmsMini\Exception\Http404Exception;

class Router
{
    protected string $controllerName;

    protected string $actionName;

    protected array $params = [];

    protected array $route;

    public function __construct()
    {
        $this->initRoute();
        $this->setRoute();
        $this->matchRoute();
        $this->dispatch();
    }

    protected function dispatch()
    {
        if (!class_exists($this->controllerName)) {
            throw new Http404Exception('Controller not exists!');
        }
        $controllerRef = new \ReflectionClass($this->controllerName);

        if (!$controllerRef->hasMethod($this->actionName)) {
            throw new Http404Exception('Method not exists!');
        }
        $actionRef = $controllerRef->getMethod($this->actionName);
        
        if (!$actionRef->isPublic()) {
            throw new Http404Exception('Method not public!');
        }

        $paramsRef = $actionRef->getParameters();

        if (count($paramsRef) > 0
            && !isset($this->params['id']) 
            || (isset($this->params['id']) && !preg_match('/^\d*$/', $this->params['id']))
        ) {
            throw new Http404Exception('ID not found!');
        }

        $di = $this->params;
        if (isset($paramsRef[0])) {
            $param = $paramsRef[0];
            $paramName = $param->getName();

            if (!$param->getType()->isBuiltin()) {
                $modelName = $param->getType()->getName();
                $model = $modelName::getOr404($this->params['id']);    
    
                $di = [$paramName => $model];
            }
       }

        $actionRef->invokeArgs(new $this->controllerName($this->route), $di);
    }

    protected function matchRoute()
    {
        $this->controllerName = '\\App\\Controller\\' . upperCamelCase($this->route[0]);
        $this->actionName = lowerCamelCase($this->route[1]);
    }

    protected function initRoute()
    {
        $this->route = [
            App::$config->default->controller,
            App::$config->default->action
        ];
    }

    protected function setRoute()
    {
        $url = [];
        if (isset($_GET['URI'])) {
            $url = filter_var($_GET['URI'], FILTER_SANITIZE_URL);
            $url = trim($url, '/');
            $url = explode('/', $url);
            
            if (isset($url[0]) && !empty($url[0])) {
                $this->route[0] = $url[0];
            }
            
            if (isset($url[1]) && !empty($url[1])) {
                $this->route[1] = $url[1];
            }

            if (isset($url[2]) && !empty($url[2])) {
                $this->params['id'] = $url[2];
            }    
        }
    }
}
