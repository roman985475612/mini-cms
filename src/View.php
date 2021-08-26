<?php

namespace Home\CmsMini;

class View
{
    public function __construct(protected array $meta = [])
    {
        $this->layout ??= App::$config->default->layout;
        $this->meta['title']  ??= App::$config->app;
        $this->meta['brand']  ??= App::$config->app;
    }

    public function __set(string $name, mixed $value): void
    {
        switch ($name) {
            case 'layout':
                $this->meta['layout'] = LAYOUTS . $value . '.php';
                break;

            case 'template':
                $this->meta['template'] = VIEW . $value . '.php';
                break;

            case 'title':
                $this->meta['title'] = ucwords($value) . ' | ' . $this->title;
                break;

            default:
                $this->meta[$name] = $value;
        }
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
        $this->content = $this->renderFile($this->template, $data);
        echo $this->renderFile($this->layout, $this->meta);
        exit;
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