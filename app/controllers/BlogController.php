<?php

namespace App\Controller;

use App\Model\Article;
use App\Model\Category;
use Home\CmsMini\Controller;

class BlogController extends Controller
{
    
    public function index()
    {
        $articles = Article::all();

        $this->title = 'read our blog';
        $this->header = 'read our blog';
        $this->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        
        return $this->render('blog/index', compact('articles'));
    }

    public function show(Article $article)
    {
        $this->title = $article->category->title;
        $this->title = $article->title;
        $this->header = $article->title;
        $this->description = $article->excerpt;

        return $this->render('blog/show', compact('article'));
    }

    public function category(Category $category)
    {
        $articles = $category->articles;
        
        $this->title = $category->title;
        $this->header = $category->title;
        $this->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        
        return $this->render('blog/category', compact('articles'));
    }
}
