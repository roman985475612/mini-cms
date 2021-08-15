<?php

namespace DesignPatterns\Structural\Adapter;

class Kindle implements EBookInterface
{
    private int $page = 1;

    private int $totalPage = 100;

    public function unlock(): void
    {
    }

    public function pressNext(): void
    {
        $this->page++;
    }

    public function getPage(): array
    {
        return  [$this->page, $this->totalPage];
    }
}
