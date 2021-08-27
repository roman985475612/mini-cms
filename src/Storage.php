<?php

namespace Home\CmsMini;

class Storage
{
    public static function get(string $filename): array
    {
        $filepath = self::getFilePath($filename);
        return [file_exists(WWW . $filepath), $filepath];
    }

    public static function getFilePath(string $filename): string
    {
        return STORAGE_URL . '/' . $filename;
    }

    public static function remove(string $filename): bool
    {
        if (file_exists(STORAGE . '/' . $filename)) {
            return unlink(STORAGE . '/' . $filename);
        }
        return false;
    }
}