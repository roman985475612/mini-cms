<?php

namespace DesignPatterns\Structural\Flyweight;

interface Text
{
    public function render(string $extrinsicState): string;
}