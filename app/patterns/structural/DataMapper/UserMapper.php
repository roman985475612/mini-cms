<?php

namespace DesignPatterns\Structural\DataMapper;

use InvalidArgumentException;

class UserMapper
{
    public function __construct(private StorageAdapter $adapter) {}

    public function findById(int $id): User
    {
        $result = $this->adapter->find($id);

        if (is_null($result)) {
            throw new InvalidArgumentException("User #$id not found");
        }

        return $this->mapRowToUser($result);
    }

    private function mapRowToUser(array $row): User
    {
        return User::fromState($row);
    }
}