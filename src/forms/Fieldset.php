<?php

namespace Home\CmsMini\Form;

class Fieldset extends ParentFormElement
{
    public function render(): string
    {
        $output = '<div';
        foreach ($this->atts as $key => $value) {
            $output .= ' ' . $key . '="' . $value . '"';
        }
        $output .= '>';
        $output .= parent::render();
        $output .= '</div>';

        return $output;
    }
}
