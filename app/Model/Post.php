<?php

namespace App\Model;

use Home\CmsMini\Model;
use Home\CmsMini\Storage;
use Home\CmsMini\File;

class Post extends Model
{
    public function getCategory()
    {
        return Category::get($this->category_id);
    }

    public function getAuthor()
    {
        return User::get($this->user_id);
    }

    public function getImage()
    {
        [$ok, $filepath] = Storage::get($this->fields['image']);
        return $ok ? $filepath : 'https://source.unsplash.com/random';
    }

    public function setImage(string $name = 'image'): void
    {
        $file = new File($name);
        
        if (empty($this->image) && !$file->uploaded()) {
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

    public function getExcerpt()
    {
        return !empty($this->excerpt)
            ? $this->excerpt
            : substr($this->content, 0, 50);
    }

    public function delete(): bool
    {
        Storage::remove($this->image);
        return parent::delete();
    }
}