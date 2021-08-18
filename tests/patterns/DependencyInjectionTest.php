<?php

namespace Tests;

use DesignPatterns\Structural\DependencyInjection\DatabaseConfiguration;
use DesignPatterns\Structural\DependencyInjection\DatabaseConnection;
use PHPUnit\Framework\TestCase;

class DependencyInjectionTest extends TestCase
{
    public function testDepencencyInjection()
    {
        $config = new DatabaseConfiguration('localhost', 3306, 'john', '123456');
        $connection = new DatabaseConnection($config);

        $this->assertSame('john:123456@localhost:3306', $connection->getDsn());
    }
}