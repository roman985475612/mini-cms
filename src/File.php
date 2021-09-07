<?php

namespace Home\CmsMini;

class File
{
    private string $filename;

    public static function factory(string $name): array
    {
        $multipleFiles = App::request()->files($name);

        $fields = [
            'name',
            'type',
            'tmp_name',
            'error',
            'size',
        ];

        $result = [];

        foreach ($fields as $field) {
            foreach ($multipleFiles[$field] as $key => $value) {
                $result[$key][$field] = $value;
            }
        }

        $files = [];
        foreach ($result as $item) {
            $files[] = new self($item);
        }

        return $files;
    }

    public function __construct(private array $file)
    {
    }

    public function __get(string $name): ?string
    {
        return $this->file[$name];
    }

    public function __set(string $name, mixed $value)
    {
        $this->file[$name] = $value;
    }

    public function uploaded(): bool
    {
        return $this->file['error'] === 0;
    }

    public function setNewName()
    {
        $this->filename = $this->getPrefix() . '/'
                        . md5(time() . $this->name) . '.'
                        . $this->getExtension();
    }

    public function getNewName(): string
    {
        return $this->filename;
    }

    public function getTempName(): string
    {
        return $this->tmp_name;
    }

    public function isJson(): bool
    {
        return $this->type == 'application/json';
    }

    public function isXml(): bool
    {
        return $this->type == 'text/xml';
    }

    public function getExtension(): string
    {
        return match ($this->type) {
            'image/jpeg' => 'jpg',
            'image/gif'  => 'gif',
            'image/png'  => 'png',
            'image/webp' => 'webp',
        };
    }

    public function getPrefix(): string
    {
        return date('Y') . '/' . date('m');
    }

    public function moveToStorage(): bool
    {
        $dir = STORAGE . '/' . $this->getPrefix();
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        return move_uploaded_file(
            $this->tmp_name,
            STORAGE . '/' . $this->getNewName()
        );
    }
}