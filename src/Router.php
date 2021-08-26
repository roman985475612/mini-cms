<?php

namespace Home\CmsMini;

use Home\CmsMini\Exception\Http404Exception;
use Home\CmsMini\App;

class Router
{
    private static array $paths = [];
    private static array $routes = [];

    private static string $controller;

    private static string $action;

    private static array $params = [];

    public static function init(): void
    {
        self::setRoutes();

        if (!self::matchRoute()) {
            throw new Http404Exception('Route not exists!');
        }

        self::dispatch();
    }

    public static function url(string $name, array $params = []): string
    {
        if (!isset(self::$paths[$name])) {
            throw new Http404Exception('Route not find');
        }
        $url = self::$paths[$name]['pattern'];

        if ($params) {
            $url = str_replace('<id>', $params['id'], $url);
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
            $item['method'] ??= ['GET'];
            $item['action'] ??= 'index';
            return $item;     
        }, self::$paths);
    }

    private static function matchRoute(): bool
    {
        $method = Request::getMethod();
        $path = Request::getPath();
        foreach (self::$routes as $route) {
            if (!in_array($method, $route['method'])) {
                continue;
            }

            if (preg_match($route['pattern'], $path, $matches)) {
                self::$controller = $route['controller'];
                self::$action = $route['action'];

                if (isset($matches['id'])) {
                    self::$params['id'] = $matches['id'];
                }
                return true;
            }       
        }
        return false;
    }

    private static function dispatch(): void
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
        if (count($paramsRef) != count(self::$params)) {
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
        
        App::$route = (object) [
            'controller' => $controllerRef->getShortName(), 
            'action' => self::$action,
        ];

        $actionRef->invokeArgs(new self::$controller(), $params);
    }
}
