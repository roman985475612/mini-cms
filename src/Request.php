<?php

namespace Home\CmsMini;

class Request
{
    public static function get() 
    {

    }

    public static function post() 
    {
        return filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    }

    public static function file() 
    {

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