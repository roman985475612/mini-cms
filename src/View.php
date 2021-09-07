<?php

namespace Home\CmsMini;

use Home\CmsMini\Core\ViewInterface;
use Exception;

class View implements ViewInterface
{
    protected array $meta = [];

    public function __construct(
        protected string $layout = '',
    ) {}

    public function setMeta(string $name, string $value): void
    {
        if ($name == 'title') {
            $this->meta['title'][] = ucwords($value);
        } else {
            $this->meta[$name] = $value;
        }
    }

    public function getMeta(string $name): string
    {
        if ($name == 'title') {
            return implode(' | ', array_reverse($this->meta['title']));
        }
        return $this->meta[$name] ?? '';
    }

    public function getLayout(): string
    {
        return LAYOUTS . "/{$this->layout}.php";
    }

    public function getTemplate(string $path): string
    {
        return VIEW . "/$path.php";
    }

    public function getPart(string $path): string
    {
        return INC . "/$path.php";
    }

    public function render(string $templatePath, array $data = []): void
    {
        $content = $this->renderFile($this->getTemplate($templatePath), $data);

        $this->setMeta('content', $content);

        echo $this->renderFile($this->getLayout(), $this->meta);
    }

    public function renderPart(string $templatePath, array $data = []): void
    {
        echo $this->renderFile($this->getPart($templatePath), $data);
    } 

    protected function renderFile(string $filename, array $data = []): string
    {
        if (!file_exists($filename)) {
            throw new Exception('Template: ' . $filename . ' Not Exists!');
        }

        extract($data);

        ob_start();
        include $filename;
        return ob_get_clean();
    }
}