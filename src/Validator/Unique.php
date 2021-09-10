<?php declare(strict_types=1);

namespace Home\CmsMini\Validator;

class Unique implements ValidatorInterface
{
    public function __construct(
        protected string $model,
        protected string $field,
        protected string $exception = ''
    ) {}

    public function validate(mixed $datum): bool
    {
        return $this->model::find($this->field, strtolower($datum))->one()->isEmpty()
            || strtolower($datum) == strtolower($this->exception);
    }

    public function errorMessage(): string
    {
        return ucfirst($this->field) . ' is already taken';
    }
}