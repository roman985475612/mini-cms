<?php

namespace Home\CmsMini;

use Home\CmsMini\Auth;

abstract class Controller
{
    public function __construct(protected View $view)
    {
        if (!$this->access()) {
            $this->accessDeny();
        }

        $this->view->layout = $this->layout;
    }

    public function render(string $template, array $data = [])
    {
        $this->view->render($template, $data);
    }

    public function renderPart(string $template, array $data = [])
    {
        $this->view->renderPart($template, $data);
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
}
