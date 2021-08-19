<?php

namespace DesignPatterns\Structural\Facade;

interface OperatingSystemInterface
{
    public function halt();

    public function getName(): string;
}