<?php

namespace Home\CmsMini;

class Request
{
    public static array $old = [];

    public static function get(?string $param = null) 
    {
        $get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

        if (empty($param)) {
            return $get;
        }

        if (array_key_exists($param, $get)) {
            return $get[$param];
        }
        
        return null;
    }

    public static function post(?string $param = null) 
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        if (array_key_exists($param, $post)) {
            return $post[$param];
        }
        
        return $post;
    }

    // public static function getQuery(?string $param = null): array | string
    // {
    //     $get = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    //     if (array_key_exists($param, $get)) {
    //         return $get[$param];
    //     }

    //     return $get;
    // }

    public static function file() 
    {

    }

    public static function old(string $key)
    {
        return $_SESSION['old'][$key] ?? '';
    }

    public static function error(string $key)
    {
        return $_SESSION['error'][$key] ?? false;
    }

    public static function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function isPost(): bool 
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public static function getPath(): string
    {
        $path = $_GET['URI'] ?? '';
        $path = ltrim($path, '/');
        $path = rtrim($path, '/');
        
        return '/' . $path;
    }

    public static function redirect(string $url = '')
    {
        if ($url) {
            $redirect = $url;
        } else {
            $redirect = $_SERVER['HTTP_REFERER'] ?? '/';
        }

        header('Location: ' . $redirect);
        exit;
    }
}