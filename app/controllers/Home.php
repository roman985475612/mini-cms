<?php

namespace App\Controller;

use App\Model\Article;
use App\Model\Category;
use Home\CmsMini\Controller;

class Home extends Controller
{
    protected function setTitle()
    {
        parent::setTitle();
        $this->title = 'read our blog' . ' | ' . $this->title;
    }

    public function index()
    {
        $articles = Article::all();
        
        $this->pageTitle = 'read our blog';
        $this->pageSubTitle = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        
        return $this->render(compact('articles'));
    }

    public function show(Article $article)
    {
        $this->pageTitle = $article->title;
        $this->pageSubTitle = $article->excerpt;

        return $this->render(compact('article'));
    }

    public function category(Category $category)
    {
        $articles = $category->articles;
        
        $this->pageTitle = $category->title;
        $this->pageSubTitle = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        
        return $this->render(compact('articles'));
    }

    public function login()
    {
        $this->layout = 'layouts/simple';
        $this->header = 'login';

        return $this->render(['showError' => false]);
    }
}