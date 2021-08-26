<?php

namespace Home\CmsMini\Form;
use Home\CmsMini\Request;

class Input implements Renderable
{
    public function __construct(private array $atts = []) {}

    public function render(): string
    {
        $this->atts['value'] ??= Request::old($this->atts['name']);
        
        if (isset($_SESSION['error'])) {
            $this->atts['class'] .= (Request::error($this->atts['name']) ? ' is-invalid' : ' is-valid'); 
        }

        $output = '<input';
        foreach ($this->atts as $key => $value) {
            $output .= ' ' . $key . '="' . $value . '"';
        }
        $output .= ' />';

        if ( ! empty( Request::error($this->atts['name']) ) )
        {
            $output .= '<div class="invalid-feedback">';
            $output .= Request::error($this->atts['name']);
            $output .= '</div>';
        }

        return $output; 
    }
}