<?php

namespace App\Controller;

use App\Model\Article;
use App\Model\Category;
use Home\CmsMini\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->title = 'HOME';
        $this->keywords = 'home, sweet, home';
        $this->description = 'Home sweet home';
    }

    public function actionIndex()
    {
        $articles = Article::all();
        
        $this->title = 'read our blog';
        $this->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        
        return $this->render('home/index', compact('articles'));
    }

    public function actionShow(int $id)
    {
        $article = Article::getOr404($id);

        $this->title = $article->title;
        $this->description = $article->excerpt;

        return $this->render('home/show', compact('article'));
    }

    public function actionCategory(int $id)
    {
        $category = Category::getOr404($id);
        $articles = $category->articles;
        
        $this->title = $category->title;
        $this->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        
        return $this->render('home/index', compact('articles'));
    }

    public function actionLogin()
    {
        $this->layout = 'layouts/simple';
        $this->header = 'login';

        return $this->render('admin/user/login');
    }
}