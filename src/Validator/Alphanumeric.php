<?php declare(strict_types=1);

namespace Home\CmsMini\Validator;

class Alphanumeric implements ValidatorInterface
{
    public function validate(mixed $datum): bool
    {
        return (bool) preg_match('/^[a-zA-Z0-9-_]+$/', $datum);
    }

    public function errorMessage(): string
    {
        return 'Should contain only alphanumeric';
    }
}