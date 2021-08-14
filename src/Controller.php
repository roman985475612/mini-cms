<?php

namespace Home\CmsMini;

use Home\CmsMini\Auth;

abstract class Controller
{
    public View $view;

    public function __construct(array $route)
    {
        if (!$this->access()) {
            $this->accessDeny();
        }

        $this->view = new View($route[0] . '/' . $route[1]);
        $this->view->layout = $this->layout;
    }

    public function __call($name, $arguments)
    {
        switch ($name) {
            case 'render':
                $this->view->render($arguments[0]);
                break;

            case 'renderPart':
                $this->view->renderPart($arguments[0]);
                break;
        }
    }

    public function __set(string $name, mixed $value): void
    {
        switch ($name) {
            case 'title':
                $this->view->title = $value . ' | ' . $this->title;
                break;

            default:
                $this->view->$name = $value;
        }
    }

    public function __get(string $name): mixed
    {
        switch ($name) {
            case 'title':
                return $this->view->title;

            default:
                return $this->view->$name;
        }
    }

    protected function access(): bool
    {
        return true;
    }
    
    protected function accessDeny()
    {
        return throw new \Exception('Access deny');
    }

    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    public function redirect(string $url = '')
    {
        if (empty($url) && isset($_GET['back'])) {
            $url = $_GET['back'];
        }                

        header('Location: /' . $url);
        exit;
    }
}
