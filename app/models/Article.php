<?php

namespace App\Model;

use Home\CmsMini\Model;

class Article extends Model
{
    protected const TABLE = 'articles';

    protected string $title = '';

    protected string $excerpt = '';

    protected string $img = '';
    
    protected int $category_id;

    public function __get($name)
    {
        switch ($name) {
            case 'id': return $this->id;
            case 'title': return $this->title;
            case 'excerpt': return $this->excerpt;
            case 'category': return Category::findOne($this->category_id);
            case 'img': return '/assets/img/' . $this->img;
            case 'created_at': return $this->date($this->created_at);
            case 'updated_at': return $this->date($this->updated_at);
        }
    }

    public function __set($name, $value)
    {
        switch ($name) {
            case 'id': return $this->id = $value;
            case 'title': return $this->title = $value;
            case 'created_at': return $this->created_at = $value;
            case 'updated_at': return $this->updated_at = $value;
        }
    }

    public function date($value)
    {
        if (empty($value)) {
            return $value;
        }

        return date('F j, Y', strtotime($value));
    }
}