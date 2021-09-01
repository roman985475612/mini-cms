<?php

namespace Home\CmsMini;

class Storage
{
    public function __construct(private string $filename) {}

    public function fileExists(): bool
    {
        return file_exists(STORAGE . "/{$this->filename}");
    }

    public function getFileUrl(): string
    {
        return STORAGE_URL . "/{$this->filename}"; 
    }

    public static function get(string $filename): string
    {
        return !is_null($filename) && file_exists(STORAGE . "/$filename")
            ? self::getFilePath($filename)
            : '';
    }

    public static function getFilePath(string $filename): string
    {
        return STORAGE_URL . "/$filename";
    }

    public static function remove(string $filename): bool
    {
        if (file_exists(STORAGE . '/' . $filename)) {
            return unlink(STORAGE . '/' . $filename);
        }
        return false;
    }
}