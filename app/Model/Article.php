<?php

namespace App\Model;

use Home\CmsMini\Model;
use Home\CmsMini\Storage;
use Home\CmsMini\File;

class Article extends Model
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
        [$ok, $filepath] = Storage::get($this->fields['img']);
        return $ok ? $filepath : 'https://source.unsplash.com/random';
    }

    public function setImage(string $name = 'img'): void
    {
        $file = new File($name);
        
        if (empty($this->img) && !$file->uploaded()) {
            throw new \Exception('File not uploaded!');
        }

        if ($file->uploaded()) {
            if (!empty($this->img)) {
                $file->remove($this->img);
            }
            
            $file->setName();
            $file->moveToStorage();
            $this->img = $file->getName();  
            $this->addField($name);  
        }
    }

    public function getExcerpt()
    {
        return !empty($this->excerpt)
            ? $this->excerpt
            : substr($this->post, 0, 50);
    }

    public function delete(): bool
    {
        Storage::remove($this->img);
        return parent::delete();
    }
}