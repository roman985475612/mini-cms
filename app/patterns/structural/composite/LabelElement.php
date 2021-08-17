<?php

namespace DesignPatterns\Structural\Composite;

class LabelElement implements Renderable
{
    public function __construct(
        private string $text,
        private array $atts = []
    ) {}

    public function render(): string
    {
        $output = '<label';
        foreach ($this->atts as $key => $value) {
            $output .= ' ' . $key . '="' . $value . '"';
        }
        return $output . '>' . ucfirst($this->text) . '</label>';
    }
}