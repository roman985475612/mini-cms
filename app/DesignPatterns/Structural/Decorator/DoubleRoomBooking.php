<?php

namespace DesignPatterns\Structural\Decorator;

class DoubleRoomBooking implements BookingInterface
{
    public function calculatePrice(): int
    {
        return 40;
    }

    public function getDescription(): string
    {
        return 'double room';
    }
}
