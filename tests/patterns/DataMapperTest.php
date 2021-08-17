<?php

namespace Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use DesignPatterns\Structural\DataMapper\StorageAdapter;
use DesignPatterns\Structural\DataMapper\UserMapper;
use DesignPatterns\Structural\DataMapper\User;

class DataMapperTest extends TestCase
{
    public function testCanMapUserFromStorage()
    {
        $storage = new StorageAdapter([
            1 => [
                'username' => 'johnsmith',
                'email' => 'john@smith.com'
            ]
        ]);

        $mapper = new UserMapper($storage);

        $user = $mapper->findById(1);

        $this->assertInstanceOf(User::class, $user);
    }

    public function testWillNotMapInvalidData()
    {
        $this->expectException(InvalidArgumentException::class);

        $storage = new StorageAdapter([]);

        $mapper = new UserMapper($storage);

        $mapper->findById(1);
    }
}