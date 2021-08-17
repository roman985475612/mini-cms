<?php

namespace DesignPatterns\Structural\Composite;

class Form implements Renderable
{
    private array $elements = [];

    public function __construct(private array $atts = []) {}

    public function render(): string
    {
        $output = '<form';
        foreach ($this->atts as $key => $value) {
            $output .= ' ' . $key . '="' . $value . '"';
        }
        $output .= '>';

        foreach ($this->elements as $element) {
            $output .= $element->render();
        }

        return $output . '</form>';
    }

    public function addElement(Renderable $element): void
    {
        $this->elements[] = $element;
    }
}