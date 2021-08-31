<?php declare(strict_types=1);

namespace Home\CmsMini\Validator;

class Unique implements ValidatorInterface
{
    public function __construct(
        protected string $model,
        protected string $field,
        protected ?string $exception = null
    ) {}

    public function validate(mixed $datum): bool
    {
        return empty($this->model::findOne($this->field, $datum))
            || $datum == $this->exception;
    }

    public function errorMessage(): string
    {
        return ucfirst($this->field) . ' is already taken';
    }
}