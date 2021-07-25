<?php

namespace App\Model;

use Home\CmsMini\Model;

class Category extends Model
{
    protected const TABLE = 'categories';

    protected string $title;

    public function __get($name)
    {
        switch ($name) {
            case 'id': return $this->id;
            case 'title': return $this->title;
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
        return date('l jS \of F Y h:i:s A', strtotime($value));
    }
}