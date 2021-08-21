<?php

namespace Home\CmsMini\Form;

abstract class ParentFormElement implements Renderable
{
    private array $elements = [];

    public function __construct(protected array $atts = []) {}

    public function render(): string
    {
        $output = '';

        foreach ($this->elements as $element) {
            $output .= $element->render();
        }

        return $output;
    }

    public function add(Renderable $element): void
    {
        $this->elements[] = $element;
    }
}
