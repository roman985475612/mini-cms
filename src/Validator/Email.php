<?php declare(strict_types=1);

namespace Home\CmsMini\Validator;

class Email implements ValidatorInterface
{
    public function validate(mixed $datum): bool
    {
        return (bool) filter_var($datum, FILTER_VALIDATE_EMAIL);
    }

    public function errorMessage(): string
    {
        return 'The field must be email';
    }
}