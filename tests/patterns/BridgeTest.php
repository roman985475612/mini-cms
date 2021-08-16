<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

use DesignPatterns\Structural\Bridge\PlanTextFormatter;
use DesignPatterns\Structural\Bridge\HtmlFormatter;
use DesignPatterns\Structural\Bridge\HelloWorldService;
use DesignPatterns\Structural\Bridge\PingService;

class BridgeTest extends TestCase
{
    public function testCanPrintHelloWorldUsingPlanTextFormatter()
    {
        $service = new HelloWorldService(new PlanTextFormatter);

        $this->assertSame('Hello, World!', $service->get());
    }

    public function testCanPrintHelloWorldUsingHtmlFormatter()
    {
        $service = new HelloWorldService(new HtmlFormatter);

        $this->assertSame('<p>Hello, World!</p>', $service->get());
    }

    public function testCanPrintPongUsingPlanTextFormatter()
    {
        $service = new PingService(new PlanTextFormatter);
        $this->assertSame('Pong', $service->get());
    }

    public function testCanPrintPongUsingHtmlFormatter()
    {
        $service = new PingService(new HtmlFormatter);
        $this->assertSame('<p>Pong</p>', $service->get());
    }
}