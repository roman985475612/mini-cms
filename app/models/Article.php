<?php

namespace App\Model;

use Home\CmsMini\Model;

class Article extends Model
{
    protected string $title;

    protected ?string $excerpt;

    protected string $post;

    protected ?string $img;
    
    protected int $category_id;

    protected int $user_id;

    protected static function getTableName()
    {
        return 'articles';
    }

    public function __get($name)
    {
        switch ($name) {
            case 'id': return $this->id;
            case 'title': return $this->title;
            case 'excerpt': return $this->getExcerpt();
            case 'post': return $this->post;
            case 'category_id': return $this->category_id;
            case 'category': return Category::get($this->category_id);
            case 'user_id': return $this->user_id;
            case 'img': return $this->getImage();
            case 'created_at': return $this->date($this->created_at);
            case 'updated_at': return $this->date($this->updated_at);
            case 'author': return User::get($this->user_id);
            case 'absUrl': return $this->getPermalink();
        }
    }

    public function __set($name, $value)
    {
        switch ($name) {
            case 'id': return $this->id = $value;
            case 'title': return $this->title = $value;
            case 'post': return $this->post = $value;
            case 'category_id': return $this->category_id = $value;
            case 'user_id': return $this->user_id = $value;
            case 'created_at': return $this->created_at = $value;
            case 'updated_at': return $this->updated_at = $value;
        }
    }

    public function getImage()
    {
        $filepath = ROOT . '/public/assets/front/img/' . $this->img;
        if (!is_null($this->img) && file_exists($filepath)) {
            return '/assets/front/img/' . $this->img;
        }
        return 'https://source.unsplash.com/random';
    }

    public function getExcerpt()
    {
        return !empty($this->excerpt)
            ? $this->excerpt
            : substr($this->post, 0, 50);
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

    public function getUpdateUrl()
    {
        return '/article/update/' . $this->id;
    }

    public function getDeleteUrl()
    {
        return '/article/delete/' . $this->id;
    }
}