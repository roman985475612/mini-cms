<?php declare(strict_types=1);

namespace Home\CmsMini\Validator;

class NotEmpty implements ValidatorInterface
{
    public function validate(mixed $datum): bool
    {
        return !empty($datum);
    }

    public function errorMessage(): string
    {
        return 'The field must not be empty';
    }
}