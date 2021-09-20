<?php

namespace App\Widget;

use Home\CmsMini\Auth;
use Home\CmsMini\App;
use Home\CmsMini\Router;
use Home\CmsMini\View;
use Home\CmsMini\Exception\CacheNotFoundException;
use Exception;

class Menu
{
    private string $filepath;

    private array $menu = [];

    private string $currentUrlName;

    public function __construct(
        string $filename,
        private string $template,
    )
    {
        $this->currentUrlName = App::getRoute()->urlName;

        $key = "menu@{$filename}_{$this->currentUrlName}";

        try {
            $menu = App::cache()->get($key);
        } catch (CacheNotFoundException $e) {
            $this->setFilepath($filename);
            $this->prepareMenu();

            $menu = (new View)->renderPart($this->template, ['menu' => $this->menu], true);

            App::cache()->put($key, $menu);
        }

        echo $menu;
    }

    public function setFilepath(string $filename)
    {
        $filepath = CONFIG . "/$filename.php";

        if (!file_exists($filepath)) {
            throw new Exception("File not exists: $filepath");
        }

        $this->filepath = $filepath;
    }

    private function prepareMenu()
    {
        $menu = include $this->filepath;

        foreach ($menu as $item) {
            if (isset($item['role']) && !Auth::{$item['role']}()) {
                continue;
            }

            $item['url'] = Router::url($item['urlName']);
            $item['class'] = ['nav-link', 'text-uppercase',];
            $item['aria'] = '';

            if ($this->currentUrlName == $item['urlName']) {
                $item['class'][] = 'active';
                $item['aria'] = 'aria-current="page"';
            }

            unset($item['role']);

            $item['class'] = implode(' ', $item['class']);
            $this->menu[] = $item;
        }
    }
}
