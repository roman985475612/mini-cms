<?php

namespace Home\CmsMini\Core;

interface ViewInterface
{
    public function setMeta(string $name, string $value): void;

    public function getMeta(string $name): string;

    public function setLayout(string $path): void;

    public function render(string $templatePath, array $data = []): void;
}