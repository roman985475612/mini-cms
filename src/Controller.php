<?php

namespace Home\CmsMini;

abstract class Controller
{
    protected string $layout = 'layouts/base';

    protected array $metadata = [];

    public function __construct()
    {
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
        return $this->metadata[$name] ?? null;
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
        include dirname(__dir__) . '/app/views/' . $this->layout . '.php';
        echo ob_get_clean();
    }

    protected function renderContent(string $template, array $data): string
    {
        extract($data);
        ob_start();
        include dirname(__dir__) . '/app/views/' . $template . '.php';
        return ob_get_clean();
    }
}
