<?php

namespace Home\CmsMini;

use Home\CmsMini\Auth;

abstract class Controller
{
    protected string $layout;

    protected string $template;

    protected array $metadata = [];

    public function __construct(array $route)
    {
        if (!$this->access()) {
            $this->accessDeny();
        }

        $this->layout = '/layouts/' . App::$config->default->layout; 
        $this->template = '/' . $route[0] . '/' . $route[1];

        $this->setTitle(); 
        $this->setBrand(); 
        $this->setKeywords(); 
        $this->setDescription(); 
    }

    protected function setTitle()
    {
        $this->title = App::$config->app;
    }

    protected function setBrand()
    {
        $this->brand = App::$config->app;
    }

    protected function setKeywords()
    {
        $this->keywords = '';
    }

    protected function setDescription()
    {
        $this->description = '';
    }

    protected function access(): bool
    {
        return true;
    }
    
    protected function accessDeny()
    {
        return throw new \Exception('Access deny');
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

    protected function render(array $data = [])
    {
        $content = $this->renderContent($this->template, $data);

        extract($this->metadata);
        ob_start();
        include ROOT . '/resources/views' . $this->layout . '.php';
        echo ob_get_clean();
        exit;
    }

    protected function renderContent(string $template, array $data): string
    {
        extract($data);

        $filename = ROOT . '/resources/views' . $template . '.php';
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

    public function getTemplatePart(string $partName)
    {
        $filepath = ROOT . '/resources/views/layouts/inc/' . $partName . '.php';
        if (file_exists($filepath)) {
            return include $filepath;
        } 
        return 'Err';
    }
}
