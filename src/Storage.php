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
        return '/storage/' . $filename;
    }
}