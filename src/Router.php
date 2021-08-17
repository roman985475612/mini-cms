<?php

namespace Home\CmsMini;

use Home\CmsMini\Exception\Http404Exception;

class Router
{
    private static array $routes = [];

    private static string $controller;

    private static string $action;

    private static array $params = [];

    public static function init(): void
    {
        if (!self::matchRoute()) {
            throw new Http404Exception('Route not exists!');
        }
        self::dispatch();
    }

    public static function get(
        string $route, 
        string $controller, 
        string $action,
    ): void
    {
        self::add($route, $controller, $action, ['GET']);
    }

    public static function post(
        string $route, 
        string $controller, 
        string $action,
    ): void
    {
        self::add(
            $route,
            $controller,
            $action,
            ['POST']
        );
    }

    public static function any(
        string $route, 
        string $controller, 
        string $action,
    ): void
    {
        self::add(
            $route,
            $controller,
            $action,
            ['GET', 'POST']
        );
    }

    private static function add(
        string $route, 
        string $controller, 
        string $action,
        array $method
    ): void
    {
        $route = str_replace('<', '(?P<', $route);
        $route = str_replace('>', '>\d+)', $route);
        $route = "#^{$route}$#";
        self::$routes[$route] = [
            'controller' => $controller,
            'action'     => $action,
            'method'     => $method
        ];
    }

    private static function getPath(): string
    {
        $path = $_GET['URI'] ?? '';
        $path = ltrim($path, '/');
        $path = rtrim($path, '/');
        
        return empty($path) ? $path : '/' . $path;
    }

    private static function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    private static function matchRoute(): bool
    {
        $method = self::getMethod();
        foreach (self::$routes as $pattern => $route) {
            if (!in_array($method, $route['method'])) {
                continue;
            }

            if (preg_match($pattern, self::getPath(), $matches)) {
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

        $di = self::$params;
        if (isset($paramsRef[0])) {
            $param = $paramsRef[0];
            $paramName = $param->getName();

            if (!$param->getType()->isBuiltin()) {
                $modelName = $param->getType()->getName();
                $model = $modelName::getOr404(self::$params['id']);    
    
                $di = [$paramName => $model];
            }
        }
        
        $route = ['controller' => $controllerRef->getShortName(), 'action' => self::$action];
        $actionRef->invokeArgs(new self::$controller($route), self::$params);
    }
}
