<?php

namespace DesignPatterns\Structural\Composite;

class InputElement implements Renderable
{
    public function __construct(private array $atts = []) {}

    public function render(): string
    {
        $output = '<input';
        foreach ($this->atts as $key => $value) {
            $output .= ' ' . $key . '="' . $value . '"';
        }
        return $output . ' />';
    }
}