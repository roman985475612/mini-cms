<?php declare(strict_types=1);

namespace Home\CmsMini\Core;

use Home\CmsMini\Exception\CacheNotFoundException;

class Cache
{
    const DATA = 'data';

    const EXPIRES = 'expires';

    private $content = [];

    private $filepath;

    public function __construct(int $seconds = 3600)
    {
        $this->setExpires($seconds);
    }

    public function get(string $key): mixed
    {
        $this->setFilepath($key);

        $this->checkFileExists();

        $content = unserialize(file_get_contents($this->filepath));

        if (time() > $content[self::EXPIRES]) {
            unlink($this->filepath);
            throw new CacheNotFoundException('Content expires');
        }

        return $content[self::DATA];
    }

    public function put(string $key, mixed $data): void
    {
        $this->setFilepath($key);

        $this->content[self::DATA] = $data;

        file_put_contents(
            $this->filepath, 
            serialize($this->content)
        );
    }

    public function clear(string $key): void
    {
        $dirname = CACHE . '/' . $key;
        removeDirectory($dirname);
        echo "Clear folder $dirname";
    }

    // menu@main
    private function setFilepath(string $key)
    {
        $dirname = CACHE;
        if (strpos($key, '@') !== false) {
            $parts = explode('@', $key);
            $filename = array_pop($parts);
            $dirname .= '/' . implode('/', $parts);

            createDirectoryIfNotExists($dirname);

        } else {
            $filename = $key;
        }

        $filepath = $dirname . '/' . md5($filename) . '.cache';

        $this->filepath = $filepath;
    }

    private function checkFileExists()
    {
        if (!file_exists($this->filepath)) {
            throw new CacheNotFoundException("File not exists: $this->filepath");
        }
    }

    private function setExpires(int $seconds)
    {
        $this->content[self::EXPIRES] = time() + $seconds;
    }
}