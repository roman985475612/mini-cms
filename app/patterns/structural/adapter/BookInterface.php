<?php

namespace DesignPatterns\Structural\Adapter;

interface BookInterface
{
    public function turnPage(): void;

    public function open(): void;

    public function getPage(): int;
}