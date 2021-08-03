<?php

namespace Home\CmsMini;

abstract class Controller
{
    protected string $layout = 'layouts/base';

    protected array $metadata = [];

    public function __construct()
    {
        $this->brand = Config::instance()->config['app'];
        $this->title = Config::instance()->config['app'];
        $this->keywords = '';
        $this->description = '';
    }
    
    public function __set($name, $value)
    {
        $this->metadata[$name] = $value;
    }

    public function __get($name)
    {
        switch ($name) {
            case 'title': return ucwords($this->metadata[$name]);
            default:
                return $this->metadata[$name] ?? null;
        }
    }

    public function __isset($name)
    {
        return isset($this->metadata[$name]);
    }

    protected function render(string $template, array $data = [])
    {
        $content = $this->renderContent($template, $data);

        extract($this->metadata);
        ob_start();
        include dirname(__dir__) . '/resources/views/' . $this->layout . '.php';
        echo ob_get_clean();
        exit;
    }

    protected function renderContent(string $template, array $data): string
    {
        extract($data);

        $filename = dirname(__dir__) . '/resources/views/' . $template . '.php';
        if (!file_exists($filename)) {
            return false;
        }
        ob_start();
        include $filename;
        return ob_get_clean();
    }
    
    public function redirect(string $url = '')
    {
        if (empty($url) && isset($_GET['back'])) {
            $url = $_GET['back'];
        }                

        header('Location: /' . $url);
        exit;
    }

    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}
