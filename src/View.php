<?php

namespace Home\CmsMini;

class View
{
    protected array $meta = [];

    public function __construct(string | null $layout = null)
    {
        $this->layout ??= App::$config->default->layout;
        $this->title = App::$config->app;
        $this->brand = App::$config->app;
    }

    public function getLayout(): string
    {
        return LAYOUTS . $this->meta['layout'] . '.php';
    }

    public function getTemplate(string $template): string
    {
        return VIEW . $template . '.php';
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
    
    public function render(string $template, array $data = []): void
    {
        $this->content = $this->renderFile($this->getTemplate($template), $data);

        echo $this->renderFile($this->getLayout(), $this->meta);
    }

    public function renderPart(string $template, array $data = []): void
    {
        echo $this->renderFile(INC . $template . '.php', $data);
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