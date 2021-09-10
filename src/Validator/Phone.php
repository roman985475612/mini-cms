<?php declare(strict_types=1);

namespace Home\CmsMini\Validator;

class Phone implements ValidatorInterface
{
    public function validate(mixed $datum): bool
    {
        return (bool) preg_match('/^([+]?[\s0-9]+)?(\d{3}|[(]?[0-9]+[)])?([-]?[\s]?[0-9])+$/', $datum);
    }

    public function errorMessage(): string
    {
        return 'Should contain valid phone number';
    }
}