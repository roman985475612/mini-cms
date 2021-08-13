<?php

function dd(mixed $data, bool $exit = true): void
{
    $styles = <<<STYLE
    display: block;
    padding: 2rem 1rem;
    border-radius: 8px;
    background: #eae8d3;
    font-family:'JetBrains Mono';
    color: #003f5c;
    STYLE;
    echo '<pre style="' . $styles . '">'. print_r($data, true) . '</pre>';
    
    if ($exit) { exit; }
}

function upperCamelCase(string $name): string
{
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
}

function lowerCamelCase(string $name): string
{
    return lcfirst(upperCamelCase($name));
}
