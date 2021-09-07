<?php

namespace Home\CmsMini;

class Request
{
    public function __construct()
    {
        session_start();
    }

    public function get(?string $param = null) 
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

    public function post(?string $param = null) 
    {
        $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        if (array_key_exists($param, $post)) {
            return $post[$param];
        }
        
        return $post;
    }

    public function files(?string $param = null) 
    {
        if (array_key_exists($param, $_FILES)) {
            return $_FILES[$param];
        }

        return $_FILES;
    }

    public function setOld(array $data, array $exclude = []): void
    {
        $_SESSION['old'] = array_filter(
            $data,
            fn($key) => !in_array($key, $exclude),
            ARRAY_FILTER_USE_KEY
        );
    }

    public function setErrors(array $data): void
    {
        $_SESSION['errors'] = $data;
    }

    public function old(string $key): mixed
    {
        return $_SESSION['old'][$key] ?? null;
    }

    public function error(string $key): mixed
    {
        return $_SESSION['errors'][$key] ?? false;
    }

    public function isErrors(): bool
    {
        return isset($_SESSION['errors']) && !empty($_SESSION['errors']);
    }

    public function clean(): void
    {
        unset($_SESSION['errors']);
        unset($_SESSION['old']);
    }

    public function getMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function isPost(): bool 
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    public function getPath(): string
    {
        $path = $_GET['URI'] ?? '';
        $path = ltrim($path, '/');
        $path = rtrim($path, '/');
        
        return '/' . $path;
    }

    public function redirect(string $url = '')
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