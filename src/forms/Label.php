<?php

namespace Home\CmsMini\Form;

class Label implements Renderable
{
    public function __construct(
        private string $text,
        private bool $require = false,
        private array $atts = []
    ) {}

    public function render(): string
    {
        $output = '<label';
        foreach ($this->atts as $key => $value) {
            $output .= ' ' . $key . '="' . $value . '"';
        }
        $output .= '>' . ucfirst($this->text). ':';
        $output .= $this->require ? ' <sup>*</sup>' : '';

        return $output . '</label>';
    }
}