<?php

namespace App\Model;

use Home\CmsMini\Model;

class Article extends Model
{
    protected string $title;

    protected string $excerpt;

    protected string $post;

    protected string $img;
    
    protected int $category_id;

    protected static function getTableName()
    {
        return 'articles';
    }

    public function __get($name)
    {
        switch ($name) {
            case 'id': return $this->id;
            case 'title': return $this->title;
            case 'excerpt': return $this->excerpt;
            case 'post': return $this->post;
            case 'category_id': return $this->category_id;
            case 'category': return Category::get($this->category_id);
            case 'img': return '/assets/front/img/' . $this->img;
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

    public function getPermalink()
    {
        return '/home/show/' . $this->id;
    }
}