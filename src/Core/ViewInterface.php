<?php

namespace Home\CmsMini\Core;

interface ViewInterface
{
    public function setMeta(string $name, string $value): void;

    public function getMeta(string $name): string;

    public function getLayout(): string;

    public function render(string $templatePath, array $data = []): void;
}