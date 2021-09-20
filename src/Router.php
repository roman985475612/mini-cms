<?php

namespace Home\CmsMini;

use Home\CmsMini\Exception\Http404Exception;

class Router
{
    private static array $paths = [];

    private static array $routes = [];

    private static string $controller;

    private static string $action;

    private static string $urlName;

    private static array $params = [];

    public static function init(): void
    {
        self::setRoutes();

        if (!self::matchRoute()) {
            throw new Http404Exception('Route not exists!');
        }
    }

    public static function url(
        string $name, 
        ?array $params = null, 
        ?array $getParams = null, 
        $domain = false
    ): string {
        if (!isset(self::$paths[$name])) {
            throw new Http404Exception('Route not find');
        }

        $url = $domain ? App::request()->server('HTTP_ORIGIN') : '';
        $url .= self::$paths[$name]['pattern'];

        if (!empty($params)) {
            $url = str_replace('<id>', $params['id'], $url);
        }

        if (!empty($getParams)) {
            $url .= '?' . implode('&', array_true_map($getParams, fn($v, $k) => "$k=$v"));
        }

        return $url;
    }

    private static function setRoutes()
    {
        self::$paths = require CONFIG . '/routes.php';

        self::$routes = array_map(function ($item) {
            $item['pattern'] = str_replace('<', '(?P<', $item['pattern']);
            $item['pattern'] = str_replace('>', '>\d+)', $item['pattern']);
            $item['pattern'] = "#^{$item['pattern']}$#";
            return $item;
        }, self::$paths);
    }

    private static function matchRoute(): bool
    {
        $routes = array_filter(self::$routes, function ($route) {
            return App::request()->getMethod() == strtoupper($route['method']);
        });

        foreach ($routes as $urlName => $route) {
            if (preg_match($route['pattern'], App::request()->getPath(), $matches)) {
                self::$controller = $route['controller'];
                self::$action = $route['action'];
                self::$urlName = $urlName;

                if (isset($matches['id'])) {
                    self::$params['id'] = $matches['id'];
                }

                return true;
            }       
        }
        return false;
    }

    public static function dispatch(): void
    {
        if (!class_exists(self::$controller)) {
            throw new Http404Exception('Controller not exists!');
        }

        $controllerRef = new \ReflectionClass(self::$controller);
        if (!$controllerRef->hasMethod(self::$action)) {
            throw new Http404Exception('Method not exists!');
        }
        
        $actionRef = $controllerRef->getMethod(self::$action);
        if (!$actionRef->isPublic()) {
            throw new Http404Exception('Method not public!');
        }

        $paramsRef = $actionRef->getParameters();
        if (count(self::$params) < count($paramsRef)) {
            throw new Http404Exception('ID not found!');
        }

        $params = self::$params;
        if (isset($paramsRef[0])) {
            $param = $paramsRef[0];
            $paramName = $param->getName();

            if (!$param->getType()->isBuiltin()) {
                $modelName = $param->getType()->getName();
                $model = $modelName::getOr404(self::$params['id']);    
    
                $params = [$paramName => $model];
            }
        }
        
        $route = (object) [
            'controller' => $controllerRef->getShortName(), 
            'action'     => self::$action,
            'urlName'    => self::$urlName,
        ];
        App::setRoute($route);

        $actionRef->invokeArgs(new self::$controller(), $params);
    }
}
