<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use DesignPatterns\Structural\Facade\BiosInterface;
use DesignPatterns\Structural\Facade\Computer;
use DesignPatterns\Structural\Facade\OperatingSystemInterface;

class FacadeTest extends TestCase
{
    public function testComputerOn()
    {
        $os = $this->createMock(OperatingSystemInterface::class);
        $os->method('getName')
           ->will($this->returnValue('Linux'));

        $bios = $this->createMock(BiosInterface::class);
        $bios->method('launch')
             ->with($os);

        $computer = new Computer($bios, $os);
        $computer->turnOn();

        $this->assertSame('Linux', $os->getName());
    }
}