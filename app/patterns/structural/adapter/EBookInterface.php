<?php

namespace DesignPatterns\Structural\Adapter;

interface EBookInterface
{
    public function unlock(): void;

    public function pressNext(): void;

    public function getPage(): array;
}
