<?php

namespace Home\CmsMini;

class File
{
    private array $file;

    private string $filename;

    private string $prefix;

    public function __construct(string $key)
    {
        $this->file = Request::files($key);
        $this->filename = $this->file['name'];   
        $this->prefix = date('Y') . '/' . date('m');
    }

    public function uploaded(): bool
    {
        return $this->file['error'] === 0;
    }

    public function remove(string $filename): bool
    {
        if (file_exists(STORAGE . '/' . $filename)) {
            return unlink(STORAGE . '/' . $filename);
        }
        return false;
    }

    public function setName()
    {
        $this->filename = $this->prefix . '/' 
                        . md5(time() . $this->file['name']) . '.' 
                        . $this->getExtension();
    }

    public function getName(): string
    {
        return $this->filename;
    }

    public function getExtension(): string
    {
        return match ($this->file['type']) {
            'image/jpeg' => 'jpg',
            'image/gif'  => 'gif',
            'image/png'  => 'png',
            'image/webp' => 'webp',
        };
    }

    public function moveToStorage(): bool
    {
        $dir = STORAGE . '/' . $this->prefix;
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        return move_uploaded_file(
            $this->file['tmp_name'],
            STORAGE . '/' . $this->getName()    
        );
    }
}