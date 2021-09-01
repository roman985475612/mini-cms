<?php

namespace Home\CmsMini;

trait CommonFieldAccessorsTrait
{
    public function getDate()
    {
        return date('F j, Y', strtotime($this->created_at));
    }

    protected static function defultImage(): string
    {
        return '/public/assets/img/no-image.png';
    }

    public function getImage(string $name = 'image'): string
    {
        if (is_null($this->$name) || empty($this->$name)) {
            return static::defultImage();
        }

        $storage = new Storage($this->$name);

        if ($storage->fileExists()) {
            return $storage->getFileUrl();
        }

        return static::defultImage();
    }

    public function setImage(string $name = 'image', bool $require = false): void
    {
        $file = new File($name);

        if ($require && empty($this->image) && !$file->uploaded()) {
            throw new \Exception('File not uploaded!');
        }

        if ($file->uploaded()) {
            if (!empty($this->image)) {
                $file->remove($this->image);
            }
            
            $file->setName();
            $file->moveToStorage();
            $this->image = $file->getName();
            $this->addField($name);  
        }
    }

    public function removeImage(string $name = 'image'): void
    {
        if (!is_null($this->$name)) {
            Storage::remove($this->image);
        }
    }
}