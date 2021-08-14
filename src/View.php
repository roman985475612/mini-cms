<?php

namespace Home\CmsMini;

class View
{
    protected array $meta = [];

    public function __construct(
        string $template,
        ?string $layout = null,
    ) {
        $this->template = $template;
        $this->layout ??= App::$config->default->layout;
        $this->title = App::$config->app;
        $this->brand = App::$config->app;
    }

    public function __call($name, $arguments)
    {
        switch ($name) {
            case 'getLayout':
                return VIEW . '/layouts/' . $this->meta['layout'] . '.php';

            case 'getTemplate':
                return VIEW . '/' . $this->meta['template'] . '.php';
        }
    }

    public function __set(string $name, mixed $value): void
    {
        $this->meta[$name] = $value;
    }

    public function __get(string $name): mixed
    {
        return $this->meta[$name] ?? '';
    }

    public function __isset(string $name): bool
    {
        return isset($this->meta[$name]);
    }
    
    public function render(array $data = []): void
    {
        $this->content = $this->renderFile($this->getTemplate(), $data);

        echo $this->renderFile($this->getLayout(), $this->meta);
    }

    public function renderPart(string $template, array $data = []): void
    {
        echo $this->renderFile(VIEW . '/layouts/inc/' . $template . '.php', $data);
    } 

    protected function renderFile(string $filename, array $data = []): string
    {
        if (!file_exists($filename)) {
            throw new \Exception('Template: ' . $filename . ' Not Exists!');
        }

        extract($data);

        ob_start();
        include $filename;
        return ob_get_clean();
    }
}