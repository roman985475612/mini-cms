<?php declare(strict_types=1);

namespace Home\CmsMini\Validator;

interface ValidatorInterface
{
    public function validate(mixed $datum): bool;

    public function errorMessage(): string;
}