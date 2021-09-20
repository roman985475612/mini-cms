<?php declare(strict_types=1);

namespace Home\CmsMini\Core;

use ArrayIterator;
use InvalidArgumentException;
use IteratorAggregate;

class Session implements IteratorAggregate
{
    public function __construct()
    {
        session_start();
    }

    public function get(string $key): string
    {
        if (!$this->has($key)) {
            throw new InvalidArgumentException("Undefined session key \"$key\"");
        }

        return $_SESSION[$key];
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function isEmpty(string $key): bool
    {
        return empty($this->get($key));
    }

    public function remove(string $key): void
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public function getIterator()
    {
        return new ArrayIterator($_SESSION);
    }
}