<?php declare(strict_types=1);

namespace Home\CmsMini\Validator;

class Always implements ValidatorInterface
{
    public function validate(mixed $datum): bool
    {
        return true;
    }

    public function errorMessage(): string
    {
        return '';
    }
}