<?php

namespace App\Controller;

use App\Model\Article;
use App\Model\Category;
use Home\CmsMini\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return $this->render('home/index');
    }

    public function about()
    {
        $this->title = 'about us';
        $this->header = 'about us';
        $this->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        
        return $this->render('home/about');
    }

    public function services()
    {
        $this->title = 'our services';
        $this->header = 'our services';
        $this->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        
        return $this->render('home/services');
    }

    public function blog()
    {
        $articles = Article::all();

        $this->title = 'read our blog';
        $this->header = 'read our blog';
        $this->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        
        return $this->render(compact('articles'));
    }

    public function contact()
    {
        $this->title = 'contact us';
        $this->header = 'contact us';
        $this->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';

        return $this->render();
    }

    public function show(Article $article)
    {
        $this->title = $article->category->title;
        $this->title = $article->title;
        $this->header = $article->title;
        $this->description = $article->excerpt;

        return $this->render(compact('article'));
    }

    public function category(Category $category)
    {
        $articles = $category->articles;
        
        $this->title = $category->title;
        $this->header = $category->title;
        $this->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        
        return $this->render(compact('articles'));
    }
}