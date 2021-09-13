<?php declare(strict_types=1);

namespace Home\CmsMini\Core;

use Home\CmsMini\Exception\CacheNotFoundException;

class Cache
{
    const DATA = 'data';

    const EXPIRES = 'expires';

    private array $content = [];

    private string $filepath;

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
            $this->delete();
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

    public function delete(): void
    {
        $this->checkFileExists();

        unlink($this->filepath);
    }

    private function setFilepath(string $key)
    {
        $filepath = CACHE . '/' . md5($key) . '.cache';

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