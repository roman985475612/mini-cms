<?php

namespace DesignPatterns\Structural\Decorator;

interface BookingInterface
{
    public function calculatePrice(): int;

    public function getDescription(): string;
}