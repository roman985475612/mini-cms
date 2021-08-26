<?php

namespace App\Model;

use Home\CmsMini\Model;

class Category extends Model
{
    public string $title;

    protected array $articles;

    public function __get($name)
    {
        return match ($name) {
            'id'         => $this->id,
            'title'      => $this->title,
            'created_at' => $this->date($this->created_at),
            'updated_at' => $this->date($this->updated_at),
            'articles'   => $this->articles(),
        };
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
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
}