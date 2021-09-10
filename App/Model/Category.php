<?php

namespace App\Model;

use Home\CmsMini\Model;

class Category extends Model implements \Stringable
{
    protected array $fillable = ['title'];

    public function __toString()
    {
        return $this->title;
    }

    public function getPosts(): array
    {
        return Post::find('category_id', $this->id)->all();
    }
}