<?php

namespace Home\CmsMini\Form;
use Home\CmsMini\Request;

class Textarea implements Renderable
{
    public function __construct(
        private string $text,
        private array $atts = []
    ) {}

    public function render(): string
    {
        $output = '<textarea';
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
        return $output . ' >' . $this->text . '</textarea>';
    }
}