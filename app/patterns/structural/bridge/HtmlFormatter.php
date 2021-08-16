<?php

namespace DesignPatterns\Structural\Bridge;

class HtmlFormatter implements FormatterInterface
{
    public function format(string $text): string
    {
        return sprintf('<p>%s</p>', $text);
    }
}
