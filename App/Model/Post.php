<?php

namespace App\Model;

use Home\CmsMini\Auth;
use Home\CmsMini\Model;
use Home\CmsMini\Storage;

class Post extends Model
{
    public function getCategory(): Category
    {
        return Category::get($this->category_id);
    }

    public function setCategory(Category $category)
    {
        $this->category_id = $category->id;
    }

    public function getAuthor()
    {
        return User::get($this->user_id);
    }

    public function setAuthor(): void
    {
        $this->user_id = Auth::user()->id;
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