<?php

namespace App\Controller;

use App\Model\Article;
use App\Model\Category;
use Home\CmsMini\Controller;

class Home extends Controller
{
    // public string $layout = 'secondary';

    public function index()
    {
        return $this->render();
    }

    public function about()
    {
        $this->title = 'about us';
        $this->header = 'about us';
        $this->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        
        return $this->render();
    }

    public function services()
    {
        $this->title = 'our services';
        $this->header = 'our services';
        $this->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        
        return $this->render();
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

    public function login()
    {
        $this->layout = 'simple';
        $this->title = 'Log In';
        $this->header = 'login';

        return $this->render(['showError' => false]);
    }
}