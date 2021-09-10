<?php declare(strict_types=1);

namespace Home\CmsMini\Validator;

class Equal implements ValidatorInterface
{
    protected string $name;

    protected mixed $value;

    public function __construct(string $name, mixed $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function validate(mixed $datum): bool
    {
        return $datum === $this->value;
    }

    public function errorMessage(): string
    {
        return 'Field value does not match the field ' . $this->name;
    }
}