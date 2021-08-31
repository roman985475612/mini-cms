<?php

namespace Home\CmsMini;

use Home\CmsMini\Core\ViewInterface;
use Home\CmsMini\Exception\Http404Exception;

abstract class Controller
{
    protected ViewInterface $view;

    protected string $layout;

    public function __construct()
    {
        if (!$this->access()) {
            $this->accessDeny();
        }

        $this->view = new View;
        $this->view->setLayout($this->layout);
        $this->view->setMeta('title', App::$config->app);
        $this->view->setMeta('brand', App::$config->app);
    }

    public function renderJson(array $data = [])
    {
        header('Content-type: application/json');
        echo json_encode($data);
        exit;
    }

    protected function access(): bool
    {
        return true;
    }
    
    protected function accessDeny()
    {
        return throw new Http404Exception('Access deny');
    }
}
