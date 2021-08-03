<?php declare(strict_types=1);

namespace Home\CmsMini\Validator;

class Unique implements ValidatorInterface
{
    protected string $model;

    protected string $field;

    public function __construct(string $model, string $field)
    {
        $this->model = $model;
        $this->field = $field;
    }

    public function validate(mixed $datum): bool
    {
        return empty($this->model::find($this->field, $datum));
    }

    public function errorMessage(): string
    {
        return ucfirst($this->field) . ' is already taken';
    }
}