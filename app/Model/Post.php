<?php

namespace App\Model;

use Home\CmsMini\Model;
use Home\CmsMini\Storage;

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