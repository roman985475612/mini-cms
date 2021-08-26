<?php

namespace Tests;

use DesignPatterns\Behavioral\Command\AddMessageDateCommand;
use DesignPatterns\Behavioral\Command\HelloCommand;
use DesignPatterns\Behavioral\Command\Invoker;
use DesignPatterns\Behavioral\Command\Receiver;
use PHPUnit\Framework\TestCase;

class UndoableCommandTest extends TestCase
{
    public function testInvocation()
    {
        $invoker = new Invoker;
        $receiver = new Receiver;

        $invoker->setCommand(new HelloCommand($receiver));
        $invoker->run();

        $this->assertSame('Hello world', $receiver->getOutput());
        
        return compact('invoker', 'receiver');
    }
    
    /**
     * @depends testInvocation
     */
    public function testInvocation2($data)
    {
        extract($data);

        $messageDateCommand = new AddMessageDateCommand($receiver);
        $messageDateCommand->execute();

        $invoker->run();

        $this->assertSame("Hello world\nHello world [" . date('Y-m-d') .']', $receiver->getOutput());

        return compact('invoker', 'receiver', 'messageDateCommand');
    }

    /**
     * @depends testInvocation2
     */
    public function testInvocation3($data)
    {
        extract($data);

        $messageDateCommand->undo();

        $invoker->run();

        $this->assertSame("Hello world\nHello world [".date('Y-m-d')."]\nHello world", $receiver->getOutput());
    }
}