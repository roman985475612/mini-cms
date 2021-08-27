<?php

namespace App\Model;

use Home\CmsMini\Model;

class Category extends Model
{
    public function __toString()
    {
        return $this->title;
    }

    public function getArticles()
    {
        return Article::findAll('category_id', $this->id);
    }
}