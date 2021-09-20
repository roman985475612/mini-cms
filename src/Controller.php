<?php

namespace Home\CmsMini;

use Home\CmsMini\Core\ViewInterface;

abstract class Controller
{
    protected ViewInterface $view;

    protected string $layout;

    public function __construct()
    {
        if (!$this->access() 
         || !$this->checkPermissions()
        ) {
            $this->accessDeny();
        }

        $this->view = new View($this->layout);
        $this->view->setMeta('title', App::config()->app);
        $this->view->setMeta('brand', App::config()->app);
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

    protected function permissions(): array
    {
        return [];
    }
    
    protected function accessDeny(): void
    {
        Auth::redirectToLoginUrl();
    }

    private function checkPermissions(): bool
    {
        $permission = true;

        $permissions = $this->permissions();

        if (isset($permissions[App::getRoute()->action])) {
            $permission = $permissions[App::getRoute()->action]();
        }

        return $permission;
    }
}
