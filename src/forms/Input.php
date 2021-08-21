<?php

namespace Home\CmsMini\Form;
use Home\CmsMini\Request;

class Input implements Renderable
{
    public function __construct(private array $atts = []) {}

    public function render(): string
    {
        $output = '<input';
        foreach ($this->atts as $key => $value) {
            switch ($key) {
                case 'class':
                    if (isset($_SESSION['error'])) {
                        $output .= ' class="' . $value . (Request::error($this->atts['name']) ? ' is-invalid' : ' is-valid') . '"'; 
                    } else {
                        $output .= ' class="' . $value . '"'; 
                    }
                    break;

                default:
                    $output .= ' ' . $key . '="' . $value . '"';
            }

            $output .= ' value="' . Request::old($this->atts['name']) . '"';
        }
        return $output . ' />';
    }
}