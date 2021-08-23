<?php

namespace DesignPatterns\Structural\Bridge;

class PlanTextFormatter implements FormatterInterface
{
    public function format(string $text): string
    {
        return $text;
    }
}
