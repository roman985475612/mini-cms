<?php

namespace DesignPatterns\Structural\Bridge;

abstract class Service
{
    public function __construct(protected FormatterInterface $formatter)
    {
    }

    public function setFormatter(FormatterInterface $formatter): void
    {
        $this->formatter = $formatter;
    }

    abstract public function get(): string;
}