<?php

namespace Home\CmsMini;

use Home\CmsMini\Exception\Http404Exception;
// use stdClass;

abstract class Controller
{
    // protected View $view;

    // protected stdClass $meta;

    public function __construct()
    {
        if (!$this->access()) {
            $this->accessDeny();
        }

        // $this->meta = new stdClass;
    }

    // public function render(string $template, array $data = [])
    // {
    //     $view = new View($this->meta);
    //     $view->render($template, $data);
    // }

    // public function renderPart(string $template, array $data = [])
    // {
    //     $view = new View($this->meta);
    //     $view->renderPart($template, $data);
    // }

    // public function __set(string $name, mixed $value): void
    // {
    //     $this->meta->$name = $value;
    // }

    // public function __get(string $name): mixed
    // {
    //     return $this->meta->$name ?? '';
    // }
    
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
