<?php

namespace App\Widget;

use \Home\CmsMini\Auth;
use \Home\CmsMini\App;

class Menu
{
    protected array $menu = [];

    protected string $currentUrl;

    public function __construct(
        private string $containerClass,
        string $filename,
    )
    {
        $this->setCurrentUrl();
        $this->setMenu($filename);
        $this->render();
    }

    protected function render()
    {
        ?>
        <ul class="<?= $this->containerClass ?>">
            <?php foreach ($this->menu as $item): ?>
                <li class="nav-item">
                    <a 
                        class="nav-link<?= $item['class'] ?>"
                        <?= $item['aria'] ?>
                        href="<?= $item['url'] ?>"
                    >
                        <?= $item['title'] ?>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
        <?php
    }

    protected function setCurrentUrl()
    {
        $this->currentUrl = App::$route->url;
        $this->currentUrl = empty($this->currentUrl) ? '/' : $this->currentUrl;
    }

    protected function isCurrent(string $url): bool
    {
        return $this->currentUrl == $url;
    }

    protected function setMenu(string $filename)
    {
        $menu = include CONFIG . '/' . $filename . '.php';

        foreach ($menu as $item) {
            if (isset($item['role']) && !Auth::{$item['role']}()) {
                continue;
            }

            $item['class'] = $this->isCurrent($item['url']) ? ' active' : '';
            $item['aria'] = $this->isCurrent($item['url']) ? 'aria-current="page"' : '';

            unset($item['role']);

            $this->menu[] = $item;
        }
    }
}
