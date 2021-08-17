<?php

namespace DesignPatterns\Structural\DataMapper;

class StorageAdapter
{
    public function __construct(private array $data) {}

    public function find(int $id): ?array
    {
        return $this->data[$id] ?? null;
    }
}