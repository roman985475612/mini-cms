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

    public static function isPost() 
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
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