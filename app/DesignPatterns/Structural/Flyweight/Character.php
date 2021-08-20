<?php

namespace DesignPatterns\Structural\Flyweight;

class Character implements Text
{
    public function __construct(private string $name) {}

    public function render(string $font): string
    {
        return sprintf('Character %s with font %s', $this->name, $font);
    }
}