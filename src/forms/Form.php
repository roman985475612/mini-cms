<?php

namespace Home\CmsMini\Form;

class Form extends ParentFormElement
{
    public function render(): string
    {
        $output = '<form';
        foreach ($this->atts as $key => $value) {
            $output .= ' ' . $key . '="' . $value . '"';
        }
        $output .= '>';
        $output .= parent::render();
        $output .= '</form>';

        return $output;
    }
}