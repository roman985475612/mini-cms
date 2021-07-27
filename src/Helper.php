<?php

namespace Home\CmsMini;

class Helper
{
    public static function upperCamelCase(string $name): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
    }
}