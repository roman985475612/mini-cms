<?php

namespace Home\CmsMini;

class Request
{
    public static array $old = [];

    public static function get() 
    {

    }

    public static function post(string $key = '') 
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if (empty($key)) {
            return $post;
        } else {
            return $post[$key] ?? '';
        }
    }

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

    public static function getQuery(): array | string
    {
        return $_GET;
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