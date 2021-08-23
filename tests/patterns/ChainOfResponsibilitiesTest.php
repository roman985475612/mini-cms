<?php

namespace Tests;

use DesignPatterns\Behavioral\ChainOfResponsibilities\Handler;
use DesignPatterns\Behavioral\ChainOfResponsibilities\Responsible\HttpInMemoryCacheHandler;
use DesignPatterns\Behavioral\ChainOfResponsibilities\Responsible\SlowDatabaseHandler;
use PHPUnit\Framework\TestCase;
use Home\CmsMini\Request;

class ChainOfResponsibilitiesTest extends TestCase
{
    private Handler $chain;

    protected function setUp(): void
    {
        $this->chain = new HttpInMemoryCacheHandler(
            ['/foo/bar?index=1' => 'Hello In Memory!'],
            new SlowDatabaseHandler
        );
    }

    public function testCanRequestKeyInFastStorage()
    {
        $request = $this->createMock(Request::class);
        $request->method('getPath')->willReturn('/foo/bar');
        $request->method('getQuery')->willReturn('index=1');
        $request->method('getMethod')->willReturn('GET');

        $this->assertSame('Hello In Memory!', $this->chain->handle($request));
    }
}
