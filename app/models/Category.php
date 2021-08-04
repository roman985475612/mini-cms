<?php

namespace App\Model;

use Home\CmsMini\Model;

class Category extends Model
{
    public string $title;

    protected array $articles;

    protected static function getTableName()
    {
        return 'categories';
    }

    public function __get($name)
    {
        switch ($name) {
            case 'id': return $this->id;
            case 'title': return $this->title;
            case 'created_at': return $this->date($this->created_at);
            case 'updated_at': return $this->date($this->updated_at);
            case 'articles': return $this->articles();
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

        return date('l jS \of F Y h:i A', strtotime($value));
    }

    public function __toString()
    {
        return $this->title;
    }

    public function articles()
    {
        return Article::findAll('category_id', $this->id);
    }

    public function getPermalink()
    {
        return '/home/category/' . $this->id;
    }
}