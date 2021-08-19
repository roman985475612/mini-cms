<?php

namespace DesignPatterns\Structural\Facade;

class Computer
{
    public function __construct(
        private BiosInterface $bios,
        private OperatingSystemInterface $os
    ) {}

    public function turnOn()
    {
        $this->bios->execute();
        $this->bios->waitForPressKey();
        $this->bios->launch($this->os);
    }

    public function turnOff()
    {
        $this->os->halt();
        $this->bios->powerDown();
    }
}