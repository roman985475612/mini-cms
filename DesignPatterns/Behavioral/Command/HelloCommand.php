<?php

namespace DesignPatterns\Behavioral\Command;

class HelloCommand implements Command
{
    public function __construct(private Receiver $output) {}

    public function execute()
    {
        $this->output->write('Hello world');
    }
}