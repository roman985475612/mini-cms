<?php

namespace DesignPatterns\Structural\Facade;

interface BiosInterface
{
    public function execute();

    public function waitForPressKey();

    public function launch(OperatingSystemInterface $os);

    public function powerDown();
}