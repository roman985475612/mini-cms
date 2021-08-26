<?php

namespace DesignPatterns\Behavioral\Interpreter;

class VariableExp extends AbstractExp
{
    public function __construct(private string $name) {}

    public function interpret(Context $context): bool
    {
        return $context->lookUp($this->name);
    }

    public function getName(): string
    {
        return $this->name;
    }
}