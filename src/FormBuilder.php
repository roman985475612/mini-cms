<?php

namespace Home\CmsMini;

use Home\CmsMini\Request;
use Home\CmsMini\Storage;

class FormBuilder
{
    public static function open(array $atts = []): string
    {
        $atts['action'] ??= $_SERVER['PHP_SELF'];
        $atts['method'] ??= 'POST';

        $output = '<form';
        foreach ($atts as $key => $value) {
            $output .= ' ' . $key . '="' . $value . '"';
        }

        return $output . '>';
    }

    public static function close(): string
    {
        return '</form>';
    }

    public static function submit(string $text, array $atts = [], string $wrap = 'mb-3'): string
    {
        $atts['type']  ??= 'submit';
        $atts['class'] ??= 'btn btn-primary';

        $output = '<button';
        foreach ($atts as $key => $value) {
            $output .= ' ' . $key . '="' . $value . '"';
        }
        $output .= ' >' . $text . '</button>';

        return self::wrap($output, $wrap);
    }

    public static function label(string $label, array $atts = []): string
    {
        $atts['class'] ??= 'form-label';

        $output = '<label';
        foreach ($atts as $key => $value) {
            $output .= ' ' . $key . '="' . $value . '"';
        }
        $output .= '>' . ucfirst($label). ':';

        return $output . '</label>';
    }

    public static function text(array $atts, string $label = '', string $wrap = 'mb-3'): string
    {
        $atts['type'] = 'text';
        return self::input($atts, $label, $wrap);
    }

    public static function file(array $atts, string $label = '', string $wrap = 'mb-3'): string
    {
        $atts['type'] = 'file';
        return self::input($atts, $label, $wrap);
    }

    public static function phone(array $atts, string $label = '', string $wrap = 'mb-3'): string
    {
        $atts['type'] = 'tel';
        return self::input($atts, $label, $wrap);
    }

    public static function email(array $atts, string $label = '', string $wrap = 'mb-3'): string
    {
        $atts['type'] = 'email';
        return self::input($atts, $label, $wrap);
    }

    public static function password(array $atts, string $label = '', string $wrap = 'mb-3'): string
    {
        $atts['type'] = 'password';
        return self::input($atts, $label, $wrap);
    }

    public static function input(array $atts, string $label = '', string $wrap = 'mb-3'): string
    {
        $output = '';

        if (!empty($label)) {
            $output .= self::label($label, ['for' => $atts['id']]);
        }

        $atts['type'] ??= 'text';
        $atts['class'] ??= 'form-control';

        if (!empty(Request::old($atts['name']))) {
            $atts['value'] = Request::old($atts['name']);
        }
        
        if (isset($_SESSION['error'])) {
            $atts['class'] .= (Request::error($atts['name']) ? ' is-invalid' : ' is-valid'); 
        }

        if ($atts['type'] == 'file' && !empty($atts['value'])) {
            $output .= '<div class="mb-1"><img class="img-thumbnail mb-3" src="' . Storage::getFilePath($atts['value']) . '"></div>';
        }

        $output .= '<input';
        foreach ($atts as $key => $value) {
            $output .= ' ' . $key . '="' . $value . '"';
        }
        $output .= ' />';

        self::feedback($output, $atts['name']);

        return self::wrap($output, $wrap);
    }

    public static function textarea(
        array $atts = [], 
        string $label = '', 
        ?string $text = '',
        string $wrap = 'mb-3',
    ): string
    {
        $output = '';

        if (!empty($label)) {
            $output .= self::label($label, ['for' => $atts['id']]);
        }
        
        if (!empty(Request::old($atts['name']))) {
            $text = Request::old($atts['name']);
        }

        $atts['class'] ??= 'form-control';

        $output .= '<textarea';

        if (isset($_SESSION['error'])) {
            $atts['class'] .= (Request::error($atts['name']) ? ' is-invalid' : ' is-valid'); 
        }
        
        foreach ($atts as $key => $value) {
            $output .= ' ' . $key . '="' . $value . '"';
        }
        
        $output .= '>' . $text . '</textarea>';

        self::feedback($output, $atts['name']);

        return self::wrap($output, $wrap);
    }

    public static function select(
        array $options = [], 
        array $atts = [], 
        string $label = '',
        string $wrap = 'mb-3',
    ): string
    {
        $output = '';

        if (!empty($label)) {
            $output .= self::label($label, ['for' => $atts['id']]);
        }

        $atts['class'] ??= 'form-select';

        $output .= '<select';
        
        foreach ($atts as $key => $value) {
            $output .= ' ' . $key . '="' . $value . '"';
        }

        $output .= '>';

        foreach ($options as $option) {
            $output .= '<option value="' . $option['key']  . '"'
                    . ((isset($option['cur']) && $option['cur']) ? ' selected' : '') . '>' 
                    . $option['value'] 
                    . '</option>';
        }

        $output .= '</select>';

        self::feedback($output, $atts['name']);

        return self::wrap($output, $wrap);
    }   

    protected static function wrap(string $output, string $class = 'mb-3'): string
    {
        return '<div class="' . $class . '">' . $output . '</div>';
    }

    protected static function feedback(string &$output, string $name)
    {
        if ( ! empty( Request::error($name) ) )
        {
            $output .= '<div class="invalid-feedback">';
            $output .= Request::error($name);
            $output .= '</div>';
        }
    }
}