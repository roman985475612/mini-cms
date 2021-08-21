<?php

namespace Home\CmsMini\Form;

class Button implements Renderable
{
    public function __construct(
        private string $text,
        private array $atts = []
    ) {}

    public function render(): string
    {
        $output = '<button';
        foreach ($this->atts as $key => $value) {
            $output .= ' ' . $key . '="' . $value . '"';
        }
        return $output . ' >' . $this->text . '</button>';
    }
}